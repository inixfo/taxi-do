<?php

namespace Modules\Taxido\Http\Controllers\Admin;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Taxido\Models\TieredPricing;
use Modules\Taxido\Models\VehicleTypeZone;

class TieredPricingController extends Controller
{
    /**
     * Display tiered pricing for a vehicle type zone.
     *
     * @param int $vehicleTypeZoneId
     * @return \Illuminate\View\View
     */
    public function index(int $vehicleTypeZoneId)
    {
        $vehicleTypeZone = VehicleTypeZone::with(['vehicleType', 'zone'])->findOrFail($vehicleTypeZoneId);
        $tiers = TieredPricing::where('vehicle_type_zone_id', $vehicleTypeZoneId)
            ->orderBy('min_distance')
            ->get();

        return view('taxido::admin.tiered-pricing.index', compact('vehicleTypeZone', 'tiers'));
    }

    /**
     * Store a new tiered pricing tier.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'vehicle_type_zone_id' => 'required|exists:vehicle_type_zones,id',
                'min_distance' => 'required|numeric|min:0',
                'max_distance' => 'nullable|numeric|min:0',
                'per_distance_charge' => 'required|numeric|min:0',
                'status' => 'boolean',
            ]);

            // Validate that max_distance > min_distance if provided
            if (isset($validated['max_distance']) && $validated['max_distance'] <= $validated['min_distance']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Maximum distance must be greater than minimum distance.',
                ], 422);
            }

            // Check for overlapping tiers
            $overlap = TieredPricing::where('vehicle_type_zone_id', $validated['vehicle_type_zone_id'])
                ->where(function ($query) use ($validated) {
                    $query->where(function ($q) use ($validated) {
                        // New tier starts within existing tier
                        $q->where('min_distance', '<=', $validated['min_distance'])
                          ->where(function ($q2) use ($validated) {
                              $q2->where('max_distance', '>', $validated['min_distance'])
                                 ->orWhereNull('max_distance');
                          });
                    })->orWhere(function ($q) use ($validated) {
                        // New tier ends within existing tier (if max is set)
                        if (isset($validated['max_distance'])) {
                            $q->where('min_distance', '<', $validated['max_distance'])
                              ->where(function ($q2) use ($validated) {
                                  $q2->where('max_distance', '>=', $validated['max_distance'])
                                     ->orWhereNull('max_distance');
                              });
                        }
                    });
                })
                ->exists();

            if ($overlap) {
                return response()->json([
                    'success' => false,
                    'message' => 'This tier overlaps with an existing tier.',
                ], 422);
            }

            // Calculate order based on min_distance
            $validated['order'] = TieredPricing::where('vehicle_type_zone_id', $validated['vehicle_type_zone_id'])
                ->where('min_distance', '<', $validated['min_distance'])
                ->count();

            $tier = TieredPricing::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Tiered pricing added successfully.',
                'tier' => $tier,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update a tiered pricing tier.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $tier = TieredPricing::findOrFail($id);

            $validated = $request->validate([
                'min_distance' => 'required|numeric|min:0',
                'max_distance' => 'nullable|numeric|min:0',
                'per_distance_charge' => 'required|numeric|min:0',
                'status' => 'boolean',
            ]);

            // Validate that max_distance > min_distance if provided
            if (isset($validated['max_distance']) && $validated['max_distance'] <= $validated['min_distance']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Maximum distance must be greater than minimum distance.',
                ], 422);
            }

            $tier->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Tiered pricing updated successfully.',
                'tier' => $tier->fresh(),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a tiered pricing tier.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $tier = TieredPricing::findOrFail($id);
            $tier->delete();

            return response()->json([
                'success' => true,
                'message' => 'Tiered pricing tier deleted successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Toggle status of a tiered pricing tier.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function toggleStatus(int $id): JsonResponse
    {
        try {
            $tier = TieredPricing::findOrFail($id);
            $tier->update(['status' => !$tier->status]);

            return response()->json([
                'success' => true,
                'message' => 'Tier status updated successfully.',
                'status' => $tier->status,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Create default tiered pricing for UK (example tiers).
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createDefaultTiers(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'vehicle_type_zone_id' => 'required|exists:vehicle_type_zones,id',
            ]);

            $vehicleTypeZoneId = $validated['vehicle_type_zone_id'];

            // Check if tiers already exist
            if (TieredPricing::where('vehicle_type_zone_id', $vehicleTypeZoneId)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tiered pricing already exists for this vehicle type zone.',
                ], 422);
            }

            // Default UK tiered pricing tiers (miles)
            $defaultTiers = [
                ['min_distance' => 0, 'max_distance' => 1, 'per_distance_charge' => 3.00],
                ['min_distance' => 1, 'max_distance' => 3, 'per_distance_charge' => 2.50],
                ['min_distance' => 3, 'max_distance' => 5, 'per_distance_charge' => 2.20],
                ['min_distance' => 5, 'max_distance' => 10, 'per_distance_charge' => 2.00],
                ['min_distance' => 10, 'max_distance' => 20, 'per_distance_charge' => 1.80],
                ['min_distance' => 20, 'max_distance' => 50, 'per_distance_charge' => 1.60],
                ['min_distance' => 50, 'max_distance' => 99, 'per_distance_charge' => 1.40],
                ['min_distance' => 99, 'max_distance' => null, 'per_distance_charge' => 1.20], // 99+ miles
            ];

            foreach ($defaultTiers as $order => $tierData) {
                TieredPricing::create([
                    'vehicle_type_zone_id' => $vehicleTypeZoneId,
                    'min_distance' => $tierData['min_distance'],
                    'max_distance' => $tierData['max_distance'],
                    'per_distance_charge' => $tierData['per_distance_charge'],
                    'order' => $order,
                    'status' => true,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Default tiered pricing created successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
