<?php

namespace Modules\Taxido\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Modules\Taxido\Models\VehicleTypeZone;
use Modules\Taxido\Models\TieredPricing;

class FareCalculationService
{
    protected $googleMapsApiKey;
    protected $cacheDuration = 1800; // 30 minutes cache for Places API results

    public function __construct()
    {
        $settings = getTaxidoSettings();
        $this->googleMapsApiKey = $settings['location']['google_map_api_key'] ?? env('GOOGLE_MAP_API_KEY');
    }

    /**
     * Calculate fare using Distance Matrix API with tiered pricing.
     *
     * @param array $pickup ['lat' => float, 'lng' => float]
     * @param array $dropoff ['lat' => float, 'lng' => float]
     * @param int $vehicleTypeId
     * @param int $zoneId
     * @return array
     */
    public function calculateFare(array $pickup, array $dropoff, int $vehicleTypeId, int $zoneId): array
    {
        try {
            // Get distance and duration from Google Maps
            $distanceData = $this->getDistanceMatrix($pickup, $dropoff);
            
            if (!$distanceData['success']) {
                throw new Exception($distanceData['error'] ?? 'Failed to get distance data');
            }

            // Get vehicle type zone pricing
            $vehicleTypeZone = VehicleTypeZone::where('vehicle_type_id', $vehicleTypeId)
                ->where('zone_id', $zoneId)
                ->first();

            if (!$vehicleTypeZone) {
                throw new Exception('Vehicle type zone configuration not found');
            }

            $distance = $distanceData['distance_value']; // in km or miles
            $duration = $distanceData['duration_minutes'];

            // Calculate base fare
            $baseFare = (float) $vehicleTypeZone->base_fare_charge;

            // Calculate distance charge using tiered pricing if available
            $distanceCharge = $vehicleTypeZone->calculateDistanceCharge($distance);

            // Calculate per-minute charge
            $minuteCharge = $duration * (float) $vehicleTypeZone->per_minute_charge;

            // Get toll estimate (if available)
            $tollEstimate = $this->getTollEstimate($pickup, $dropoff);

            // Calculate subtotal
            $subTotal = $baseFare + $distanceCharge + $minuteCharge + $tollEstimate;

            // Calculate tax if enabled
            $taxAmount = 0;
            if ($vehicleTypeZone->is_allow_tax && $vehicleTypeZone->tax_id) {
                $taxRate = getTaxRateById($vehicleTypeZone->tax_id);
                $taxAmount = ($subTotal * $taxRate) / 100;
            }

            $total = $subTotal + $taxAmount;

            return [
                'success' => true,
                'distance' => round($distance, 2),
                'distance_unit' => $distanceData['distance_unit'],
                'duration' => $duration,
                'duration_text' => $distanceData['duration'],
                'base_fare' => round($baseFare, 2),
                'distance_charge' => round($distanceCharge, 2),
                'minute_charge' => round($minuteCharge, 2),
                'toll_estimate' => round($tollEstimate, 2),
                'sub_total' => round($subTotal, 2),
                'tax' => round($taxAmount, 2),
                'total' => round($total, 2),
                'pricing_tiers' => $this->getPricingTierBreakdown($distance, $vehicleTypeZone->id),
                'is_tiered_pricing' => $vehicleTypeZone->hasTieredPricing(),
            ];
        } catch (Exception $e) {
            Log::error('Fare calculation failed: ' . $e->getMessage(), [
                'pickup' => $pickup,
                'dropoff' => $dropoff,
                'vehicle_type_id' => $vehicleTypeId,
                'zone_id' => $zoneId,
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get distance matrix data from Google Maps API.
     * Uses caching to reduce API costs.
     *
     * @param array $origin
     * @param array $destination
     * @return array
     */
    public function getDistanceMatrix(array $origin, array $destination): array
    {
        try {
            // Create cache key
            $cacheKey = 'distance_matrix_' . md5(json_encode([$origin, $destination]));
            
            // Check cache first
            $cached = Cache::get($cacheKey);
            if ($cached) {
                return $cached;
            }

            $url = "https://maps.googleapis.com/maps/api/distancematrix/json";
            $distanceUnit = setDistanceUnit();
            $units = $distanceUnit === 'mile' ? 'imperial' : 'metric';

            $response = Http::get($url, [
                'origins' => "{$origin['lat']},{$origin['lng']}",
                'destinations' => "{$destination['lat']},{$destination['lng']}",
                'key' => $this->googleMapsApiKey,
                'units' => $units,
                'mode' => 'driving',
                // Do NOT avoid highways or tolls by default as per requirements
            ]);

            if (!$response->ok()) {
                throw new Exception('Google Maps API request failed');
            }

            $data = $response->json();

            if ($data['status'] !== 'OK') {
                throw new Exception('Google Maps API error: ' . ($data['error_message'] ?? $data['status']));
            }

            $element = $data['rows'][0]['elements'][0] ?? null;

            if (!$element || $element['status'] !== 'OK') {
                throw new Exception('No route found');
            }

            // Calculate distance in the configured unit
            $distanceMeters = $element['distance']['value'];
            $distanceValue = $distanceUnit === 'mile' 
                ? $distanceMeters * 0.000621371 
                : $distanceMeters * 0.001;

            $durationSeconds = $element['duration']['value'];
            $durationMinutes = (int) ceil($durationSeconds / 60);

            $result = [
                'success' => true,
                'distance_value' => round($distanceValue, 2),
                'distance_unit' => $distanceUnit,
                'distance_text' => $element['distance']['text'],
                'duration' => "{$durationMinutes} mins",
                'duration_minutes' => $durationMinutes,
                'duration_seconds' => $durationSeconds,
            ];

            // Cache the result for 10-30 minutes as per requirements
            Cache::put($cacheKey, $result, $this->cacheDuration);

            return $result;
        } catch (Exception $e) {
            Log::error('Distance Matrix API error: ' . $e->getMessage());

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get toll estimate from Google Maps.
     * Returns 0 if toll data is not available.
     *
     * @param array $origin
     * @param array $destination
     * @return float
     */
    public function getTollEstimate(array $origin, array $destination): float
    {
        try {
            // Create cache key for toll estimate
            $cacheKey = 'toll_estimate_' . md5(json_encode([$origin, $destination]));
            
            // Check cache first
            $cached = Cache::get($cacheKey);
            if ($cached !== null) {
                return $cached;
            }

            // Use Routes API for toll information (if available)
            // Note: This requires the Routes API to be enabled
            $url = "https://routes.googleapis.com/directions/v2:computeRoutes";

            $response = Http::withHeaders([
                'X-Goog-Api-Key' => $this->googleMapsApiKey,
                'X-Goog-FieldMask' => 'routes.travelAdvisory.tollInfo',
            ])->post($url, [
                'origin' => [
                    'location' => [
                        'latLng' => [
                            'latitude' => $origin['lat'],
                            'longitude' => $origin['lng'],
                        ],
                    ],
                ],
                'destination' => [
                    'location' => [
                        'latLng' => [
                            'latitude' => $destination['lat'],
                            'longitude' => $destination['lng'],
                        ],
                    ],
                ],
                'travelMode' => 'DRIVE',
                'extraComputations' => ['TOLLS'],
            ]);

            if ($response->ok()) {
                $data = $response->json();
                $tollInfo = $data['routes'][0]['travelAdvisory']['tollInfo'] ?? null;
                
                if ($tollInfo && isset($tollInfo['estimatedPrice'])) {
                    $tollAmount = 0;
                    foreach ($tollInfo['estimatedPrice'] as $price) {
                        // Convert units (e.g., GBP minor units to major)
                        $tollAmount += ($price['units'] ?? 0) + (($price['nanos'] ?? 0) / 1000000000);
                    }
                    
                    Cache::put($cacheKey, $tollAmount, $this->cacheDuration);
                    return $tollAmount;
                }
            }

            // No toll data available
            Cache::put($cacheKey, 0, $this->cacheDuration);
            return 0;
        } catch (Exception $e) {
            Log::warning('Toll estimate failed: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get a breakdown of pricing tiers for display.
     *
     * @param float $distance
     * @param int $vehicleTypeZoneId
     * @return array
     */
    public function getPricingTierBreakdown(float $distance, int $vehicleTypeZoneId): array
    {
        $tiers = TieredPricing::where('vehicle_type_zone_id', $vehicleTypeZoneId)
            ->where('status', true)
            ->orderBy('min_distance')
            ->get();

        if ($tiers->isEmpty()) {
            return [];
        }

        $breakdown = [];
        $remainingDistance = $distance;

        foreach ($tiers as $tier) {
            if ($remainingDistance <= 0) {
                break;
            }

            $tierMin = (float) $tier->min_distance;
            $tierMax = $tier->max_distance ? (float) $tier->max_distance : PHP_FLOAT_MAX;

            // Check if this tier applies to our distance
            if ($distance > $tierMin) {
                $applicableDistance = min(
                    $distance - $tierMin,
                    $tierMax - $tierMin
                );

                if ($applicableDistance > 0) {
                    $tierCharge = $applicableDistance * (float) $tier->per_distance_charge;
                    
                    $breakdown[] = [
                        'tier_label' => $tier->tier_label,
                        'min_distance' => $tier->min_distance,
                        'max_distance' => $tier->max_distance,
                        'per_distance_charge' => (float) $tier->per_distance_charge,
                        'applicable_distance' => round($applicableDistance, 2),
                        'charge' => round($tierCharge, 2),
                    ];

                    $remainingDistance -= $applicableDistance;
                }
            }
        }

        return $breakdown;
    }

    /**
     * Get autocomplete suggestions from Places API with session token.
     * Restricted to UK as per requirements.
     *
     * @param string $input
     * @param string $sessionToken
     * @return array
     */
    public function getPlaceAutocomplete(string $input, string $sessionToken): array
    {
        try {
            // Create cache key (don't cache autocomplete as it's dynamic)
            $url = "https://maps.googleapis.com/maps/api/place/autocomplete/json";

            $response = Http::get($url, [
                'input' => $input,
                'key' => $this->googleMapsApiKey,
                'sessiontoken' => $sessionToken,
                'components' => 'country:gb', // Restrict to UK
                'types' => 'geocode|establishment',
            ]);

            if (!$response->ok()) {
                throw new Exception('Places API request failed');
            }

            $data = $response->json();

            if ($data['status'] !== 'OK' && $data['status'] !== 'ZERO_RESULTS') {
                throw new Exception('Places API error: ' . ($data['error_message'] ?? $data['status']));
            }

            return [
                'success' => true,
                'predictions' => $data['predictions'] ?? [],
            ];
        } catch (Exception $e) {
            Log::error('Places API error: ' . $e->getMessage());

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'predictions' => [],
            ];
        }
    }

    /**
     * Get place details from Places API.
     *
     * @param string $placeId
     * @param string $sessionToken
     * @return array
     */
    public function getPlaceDetails(string $placeId, string $sessionToken): array
    {
        try {
            // Cache place details
            $cacheKey = 'place_details_' . $placeId;
            $cached = Cache::get($cacheKey);
            
            if ($cached) {
                return $cached;
            }

            $url = "https://maps.googleapis.com/maps/api/place/details/json";

            $response = Http::get($url, [
                'place_id' => $placeId,
                'key' => $this->googleMapsApiKey,
                'sessiontoken' => $sessionToken,
                'fields' => 'geometry,formatted_address,name', // Minimal fields as per requirements
            ]);

            if (!$response->ok()) {
                throw new Exception('Place Details API request failed');
            }

            $data = $response->json();

            if ($data['status'] !== 'OK') {
                throw new Exception('Place Details API error: ' . ($data['error_message'] ?? $data['status']));
            }

            $result = [
                'success' => true,
                'place' => $data['result'] ?? null,
            ];

            // Cache for 30 minutes
            Cache::put($cacheKey, $result, $this->cacheDuration);

            return $result;
        } catch (Exception $e) {
            Log::error('Place Details API error: ' . $e->getMessage());

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
