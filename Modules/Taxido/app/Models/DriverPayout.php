<?php

namespace Modules\Taxido\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DriverPayout extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'driver_payouts';

    protected $fillable = [
        'driver_id',
        'amount',
        'currency',
        'status',
        'stripe_transfer_id',
        'stripe_payout_id',
        'failure_reason',
        'failure_code',
        'payout_period_start',
        'payout_period_end',
        'rides_count',
        'gross_earnings',
        'commission_deducted',
        'net_payout',
        'scheduled_at',
        'processed_at',
        'completed_at',
        'failed_at',
        'processed_by_id',
    ];

    protected $casts = [
        'driver_id' => 'integer',
        'amount' => 'decimal:2',
        'failure_code' => 'integer',
        'rides_count' => 'integer',
        'gross_earnings' => 'decimal:2',
        'commission_deducted' => 'decimal:2',
        'net_payout' => 'decimal:2',
        'payout_period_start' => 'date',
        'payout_period_end' => 'date',
        'scheduled_at' => 'datetime',
        'processed_at' => 'datetime',
        'completed_at' => 'datetime',
        'failed_at' => 'datetime',
        'processed_by_id' => 'integer',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';

    /**
     * Get the driver for this payout.
     *
     * @return BelongsTo
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    /**
     * Get the admin who processed this payout.
     *
     * @return BelongsTo
     */
    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by_id');
    }

    /**
     * Scope to get pending payouts.
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope to get completed payouts.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    /**
     * Scope to get failed payouts.
     */
    public function scopeFailed($query)
    {
        return $query->where('status', self::STATUS_FAILED);
    }

    /**
     * Scope to get payouts for a specific driver.
     */
    public function scopeForDriver($query, int $driverId)
    {
        return $query->where('driver_id', $driverId);
    }

    /**
     * Scope to get payouts scheduled for today or earlier.
     */
    public function scopeScheduledForProcessing($query)
    {
        return $query->where('status', self::STATUS_PENDING)
            ->where('scheduled_at', '<=', now());
    }

    /**
     * Mark the payout as processing.
     */
    public function markAsProcessing(): bool
    {
        return $this->update([
            'status' => self::STATUS_PROCESSING,
            'processed_at' => now(),
            'processed_by_id' => getCurrentUserId(),
        ]);
    }

    /**
     * Mark the payout as completed.
     */
    public function markAsCompleted(string $stripeTransferId = null, string $stripePayoutId = null): bool
    {
        return $this->update([
            'status' => self::STATUS_COMPLETED,
            'stripe_transfer_id' => $stripeTransferId,
            'stripe_payout_id' => $stripePayoutId,
            'completed_at' => now(),
        ]);
    }

    /**
     * Mark the payout as failed.
     */
    public function markAsFailed(string $reason, int $code = null): bool
    {
        return $this->update([
            'status' => self::STATUS_FAILED,
            'failure_reason' => $reason,
            'failure_code' => $code,
            'failed_at' => now(),
        ]);
    }

    /**
     * Get the payout period as a human-readable string.
     */
    public function getPeriodLabelAttribute(): string
    {
        return $this->payout_period_start->format('M d') . ' - ' . $this->payout_period_end->format('M d, Y');
    }

    /**
     * Check if this payout can be retried.
     */
    public function canRetry(): bool
    {
        return $this->status === self::STATUS_FAILED;
    }

    /**
     * Get the CSS class for status badge.
     */
    public function getStatusClassAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'pending',
            self::STATUS_PROCESSING => 'progress',
            self::STATUS_COMPLETED => 'completed',
            self::STATUS_FAILED => 'failed',
            default => 'secondary',
        };
    }
}
