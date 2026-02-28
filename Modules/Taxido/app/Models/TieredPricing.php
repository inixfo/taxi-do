<?php

namespace Modules\Taxido\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TieredPricing extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tiered_pricing';

    protected $fillable = [
        'vehicle_type_zone_id',
        'min_distance',
        'max_distance',
        'per_distance_charge',
        'order',
        'status',
        'created_by_id',
    ];

    protected $casts = [
        'vehicle_type_zone_id' => 'integer',
        'min_distance' => 'decimal:2',
        'max_distance' => 'decimal:2',
        'per_distance_charge' => 'decimal:2',
        'order' => 'integer',
        'status' => 'boolean',
        'created_by_id' => 'integer',
    ];

    public static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $model->created_by_id = getCurrentUserId() ?? getAdmin()?->id;
        });
    }

    /**
     * Get the vehicle type zone that owns this tiered pricing.
     *
     * @return BelongsTo
     */
    public function vehicleTypeZone(): BelongsTo
    {
        return $this->belongsTo(VehicleTypeZone::class, 'vehicle_type_zone_id');
    }

    /**
     * Get the user who created this tiered pricing.
     *
     * @return BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by_id');
    }

    /**
     * Scope to get active tiered pricing.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Get the tier label (e.g., "1-3 miles", "3-5 miles", "99+ miles")
     */
    public function getTierLabelAttribute(): string
    {
        $unit = setDistanceUnit();
        
        if (is_null($this->max_distance)) {
            return "{$this->min_distance}+ {$unit}";
        }
        
        return "{$this->min_distance}-{$this->max_distance} {$unit}";
    }

    /**
     * Calculate the per-distance charge for a given distance.
     * Returns the appropriate tier's rate.
     *
     * @param float $distance
     * @param int $vehicleTypeZoneId
     * @return float
     */
    public static function getChargeForDistance(float $distance, int $vehicleTypeZoneId): ?float
    {
        $tier = self::where('vehicle_type_zone_id', $vehicleTypeZoneId)
            ->where('status', true)
            ->where('min_distance', '<=', $distance)
            ->where(function ($query) use ($distance) {
                $query->where('max_distance', '>=', $distance)
                    ->orWhereNull('max_distance');
            })
            ->orderBy('order')
            ->first();

        return $tier?->per_distance_charge;
    }

    /**
     * Calculate total fare using tiered pricing.
     *
     * @param float $distance
     * @param int $vehicleTypeZoneId
     * @return float
     */
    public static function calculateTieredFare(float $distance, int $vehicleTypeZoneId): float
    {
        $tiers = self::where('vehicle_type_zone_id', $vehicleTypeZoneId)
            ->where('status', true)
            ->orderBy('min_distance')
            ->get();

        if ($tiers->isEmpty()) {
            return 0;
        }

        $totalFare = 0;
        $remainingDistance = $distance;

        foreach ($tiers as $tier) {
            if ($remainingDistance <= 0) {
                break;
            }

            $tierMin = (float) $tier->min_distance;
            $tierMax = $tier->max_distance ? (float) $tier->max_distance : PHP_FLOAT_MAX;
            
            // Calculate distance that falls within this tier
            if ($distance >= $tierMin) {
                $applicableDistance = min($remainingDistance, $tierMax - $tierMin);
                
                // For the first tier
                if ($tierMin == 0 || $distance <= $tierMax) {
                    $applicableDistance = min($distance - $tierMin, $tierMax - $tierMin);
                    if ($tierMax === PHP_FLOAT_MAX) {
                        $applicableDistance = $distance - $tierMin;
                    }
                }

                if ($applicableDistance > 0) {
                    $totalFare += $applicableDistance * (float) $tier->per_distance_charge;
                    $remainingDistance -= $applicableDistance;
                }
            }
        }

        return round($totalFare, 2);
    }
}
