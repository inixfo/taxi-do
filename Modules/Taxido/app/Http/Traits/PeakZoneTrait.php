<?php

namespace Modules\Taxido\Http\Traits;

use Carbon\Carbon;
use Sk\Geohash\Geohash;
use Modules\Taxido\Models\Zone;
use Modules\Taxido\Models\Ride;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\FireStoreTrait;
use Modules\Taxido\Models\PeakZone;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;
use MatanYadaev\EloquentSpatial\Objects\LineString;

trait PeakZoneTrait
{
    use FireStoreTrait;

    /**
     * Generate optimized polygon coordinates around a center point.
     */
    protected function generatePolygonCoordinates(float $centerLat, float $centerLng, float $radiusKm, int $numPoints = 8): array
    {
        $coordinates = [];
        $earthRadius = 6371; // km

        for ($i = 0; $i < $numPoints; $i++) {
            $bearing = deg2rad(360 / $numPoints * $i);
            $latRad = deg2rad($centerLat);
            $lngRad = deg2rad($centerLng);
            $distRatio = $radiusKm / $earthRadius;

            $newLatRad = asin(sin($latRad) * cos($distRatio) + cos($latRad) * sin($distRatio) * cos($bearing));
            $newLngRad = $lngRad + atan2(
                sin($bearing) * sin($distRatio) * cos($latRad),
                cos($distRatio) - sin($latRad) * sin($newLatRad)
            );

            $coordinates[] = [
                'lat' => rad2deg($newLatRad),
                'lng' => rad2deg($newLngRad),
            ];
        }

        // Close the polygon
        $coordinates[] = $coordinates[0];
        return $coordinates;
    }

    /**
     * Check for overlapping active peak zones (MySQL compatible)
     */
    protected function hasOverlappingPeakZone(int $zoneId, Polygon $newPolygon): bool
    {
        $wkt = $newPolygon->toWKT();

        return PeakZone::where('zone_id', $zoneId)
            ->where('is_active', true)
            ->whereNotNull('polygon')
            ->whereRaw('ST_Intersects(polygon, ST_GeomFromText(?, 4326))', [$wkt])
            ->exists();
    }

    /**
     * Deactivate overlapping active peak zones
     */
    protected function deactivateOverlappingPeakZones(int $zoneId, Polygon $newPolygon): void
    {
        $overlappingZones = PeakZone::where('zone_id', $zoneId)
            ->where('is_active', true)
            ->whereNotNull('polygon')
            ->whereRaw('ST_Intersects(polygon, ST_GeomFromText(?, 4326))', [$newPolygon->toWKT()])
            ->get();

        foreach ($overlappingZones as $zone) {
            $now = Carbon::now();

            $zone->update([
                'is_active' => false,
                'ends_at' => $now,
                'updated_at' => $now,
            ]);

            $coordinates = $zone->locations ?? [];

            $this->fireStoreAddDocument("peak_zones/{$zoneId}/expired", [
                'id' => (string)$zone->id,
                'name' => $zone->name,
                'active' => false,
                'g' => (new Geohash())->encode($coordinates[0]['lat'] ?? 0, $coordinates[0]['lng'] ?? 0, 12),
                'start_time' => $zone->starts_at?->format('H:i:s'),
                'start_time_timestamp' => $zone->starts_at?->timestamp,
                'end_time' => $now->format('H:i:s'),
                'end_time_timestamp' => $now->timestamp,
                'coordinates' => $coordinates,
                'updated_at' => $now->format('Y-m-d\TH:i:s.v\Z'),
            ], (string)$zone->id);

            $this->fireStoreDeleteDocument("peak_zones/{$zoneId}/active", (string)$zone->id);

            Log::info("Deactivated overlapping peak zone", ['peak_zone_id' => $zone->id]);
        }
    }

    /**
     * Validate and generate a peak zone based on ride pickup locations.
     */
    protected function validateAndGeneratePeakZone(float $pickLat, float $pickLng, int $zoneId, string $timezone): ?PeakZone
    {
        $zone = Zone::find($zoneId);
        if (!$zone || !$zone->minutes_choosing_peak_zone || !$zone->peak_price_increase_percentage) {
            return null;
        }

        // Validate required config
        if (
            $zone->minutes_choosing_peak_zone <= 0 ||
            $zone->peak_price_increase_percentage <= 0 ||
            $zone->peak_zone_geographic_radius <= 0 ||
            $zone->total_rides_in_peak_zone <= 0
        ) {
            Log::warning('Invalid peak zone parameters', ['zone_id' => $zoneId]);
            return null;
        }

        $searchRadius = $zone->peak_zone_geographic_radius;
        $expiryDuration = $zone->minutes_peak_zone_active;
        $minimumNoRides = $zone->total_rides_in_peak_zone;
        $distancePricePercentage = $zone->peak_price_increase_percentage;

        $currentTime = Carbon::now()->setTimezone($timezone);
        $subTime = $currentTime->copy()->subMinutes($zone->minutes_choosing_peak_zone);

        $haversine = "(6371 * acos(cos(radians($pickLat)) * cos(radians(JSON_EXTRACT(location_coordinates, '$[0].lat'))) * cos(radians(JSON_EXTRACT(location_coordinates, '$[0].lng')) - radians($pickLng)) + sin(radians($pickLat)) * sin(radians(JSON_EXTRACT(location_coordinates, '$[0].lat')))))";

        $rideCount = Ride::whereRaw("{$haversine} < ?", [$searchRadius])
            ->where('created_at', '>=', $subTime)
            ->whereHas('zones', fn($q) => $q->where('zone_id', $zoneId))
            ->count();

        if ($rideCount < $minimumNoRides) {
            return null;
        }

        // Generate circular polygon
        $polygonCoordinates = $this->generatePolygonCoordinates($pickLat, $pickLng, $searchRadius, 8);
        $points = array_map(fn($c) => new Point($c['lat'], $c['lng']), $polygonCoordinates);
        $lineString = new LineString($points);
        $polygon = new Polygon([$lineString], 4326); // SRID set here → stored correctly

        $startsAt = Carbon::now();
        $endsAt = $startsAt->copy()->addMinutes($expiryDuration);

        // 1. Check if current point is already inside an active peak zone
        $existingActiveZone = PeakZone::where('zone_id', $zoneId)
            ->where('is_active', true)
            ->whereNotNull('polygon')
            ->whereRaw('ST_Contains(polygon, ST_GeomFromText(?, 4326))', ["POINT($pickLat $pickLng)"])
            ->first();

        if ($existingActiveZone) {
            $newEndsAt = Carbon::now()->addMinutes($zone->minutes_peak_zone_active);
            if (!$existingActiveZone->ends_at || $existingActiveZone->ends_at->lt($newEndsAt)) {
                $existingActiveZone->update(['ends_at' => $newEndsAt, 'updated_at' => Carbon::now()]);
            }
            Log::info('Extended existing active peak zone', ['peak_zone_id' => $existingActiveZone->id]);
            return $existingActiveZone;
        }

        // 2. Check for any overlap with existing active zones
        if ($this->hasOverlappingPeakZone($zoneId, $polygon)) {
            Log::info('Overlap detected with existing active peak zone', ['zone_id' => $zoneId]);
            return null; // Don't create new one
        }

        // 3. Create new peak zone (with transaction + locking)
        return DB::transaction(function () use (
            $zone, $polygon, $startsAt, $endsAt, $polygonCoordinates,
            $pickLat, $pickLng, $distancePricePercentage
        ) {
            // Deactivate any overlapping zones (just in case race condition)
            $this->deactivateOverlappingPeakZones($zone->id, $polygon);

            $peakZone = PeakZone::create([
                'zone_id' => $zone->id,
                'name' => "Peak Zone {$zone->name} - " . $startsAt->format('YmdHis'),
                'polygon' => $polygon,
                'is_active' => true,
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
                'distance_price_percentage' => $distancePricePercentage,
            ]);

            $peakZone->update(['locations' => $polygonCoordinates]);

            $geohash = (new Geohash())->encode($pickLat, $pickLng, 12);

            $this->fireStoreAddDocument("peak_zones/{$zone->id}/active", [
                'id' => (string)$peakZone->id,
                'name' => $peakZone->name,
                'active' => true,
                'g' => $geohash,
                'start_time' => $startsAt->format('H:i:s'),
                'start_time_timestamp' => $startsAt->timestamp,
                'end_time' => $endsAt->format('H:i:s'),
                'end_time_timestamp' => $endsAt->timestamp,
                'coordinates' => $polygonCoordinates,
                'updated_at' => $startsAt->format('Y-m-d\TH:i:s.v\Z'),
            ], (string)$peakZone->id);

            Log::info('Created new peak zone', ['peak_zone_id' => $peakZone->id]);

            return $peakZone;
        });
    }

    /**
     * Find active peak zone containing given coordinates
     */
    protected function findActivePeakZone(float $lat, float $lng, int $zoneId): ?PeakZone
    {
        return PeakZone::where('zone_id', $zoneId)
            ->where('is_active', true)
            ->whereNotNull('polygon')
            ->whereRaw('ST_Contains(polygon, ST_GeomFromText(?, 4326))', ["POINT($lat $lng)"])
            ->where(function ($q) {
                $q->where(function ($sq) {
                    $sq->where('starts_at', '<=', now())
                       ->where('ends_at', '>=', now());
                })->orWhere(function ($sq) {
                    $sq->whereNull('starts_at')
                       ->whereNull('ends_at')
                       ->where('created_at', '>=', now()->subMinutes(60));
                });
            })
            ->orderBy('starts_at', 'desc')
            ->first();
    }

    /**
     * Main public method: Get or create peak zone for pickup point
     */
    protected function getPeakZones($coordinates)
    {
        $pickup = $coordinates[0] ?? null;
        if (!$pickup || !isset($pickup['lat'], $pickup['lng'])) {
            Log::warning('getPeakZones: Invalid pickup coordinates');
            return null;
        }

        $zone = getZoneByPoint($pickup['lat'], $pickup['lng'])?->first();
        if (!$zone || !$zone->peak_price_increase_percentage) {
            return null;
        }

        $peakZone = $this->findActivePeakZone($pickup['lat'], $pickup['lng'], $zone->id);

        if (!$peakZone) {
            $peakZone = $this->validateAndGeneratePeakZone(
                $pickup['lat'],
                $pickup['lng'],
                $zone->id,
                config('app.timezone')
            );
        }

        if ($peakZone) {
            $peakZone->refresh();
            if (!$peakZone->isActiveNow()) {
                Log::info('Peak zone expired during request', ['peak_zone_id' => $peakZone->id]);
                return null;
            }
        }

        return $peakZone;
    }

    /**
     * Calculate earnings from a peak zone
     */
    protected function calculatePeakZoneEarnings(int $peakZoneId, ?Carbon $from = null, ?Carbon $to = null): array
    {
        $peakZone = PeakZone::findOrFail($peakZoneId);

        $query = Ride::where('peak_zone_id', $peakZoneId)
            ->where('payment_status', 'COMPLETED');

        if ($from) $query->where('start_time', '>=', $from);
        if ($to) $query->where('start_time', '<=', $to);

        $surgeSum = $query->sum('peak_zone_charge');
        $rideCount = $query->count();

        return [
            'peak_zone_id' => $peakZoneId,
            'peak_zone_name' => $peakZone->name,
            'zone_id' => $peakZone->zone_id,
            'zone_name' => $peakZone->zone->name ?? 'Unknown',
            'total_surge_charges' => round($surgeSum, 2),
            'platform_earnings' => round($surgeSum * 0.2, 2),
            'ride_count' => $rideCount,
        ];
    }
}
