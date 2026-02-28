<?php

namespace Modules\Taxido\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AuditLog extends Model
{
    protected $table = 'audit_logs';

    protected $fillable = [
        'user_id',
        'user_type',
        'action',
        'auditable_type',
        'auditable_id',
        'event_type',
        'old_values',
        'new_values',
        'description',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'auditable_id' => 'integer',
        'old_values' => 'json',
        'new_values' => 'json',
    ];

    // Event types for categorization
    const EVENT_BANK_CHANGE = 'bank_change';
    const EVENT_DRIVER_APPROVAL = 'driver_approval';
    const EVENT_PAYOUT = 'payout';
    const EVENT_COUPON = 'coupon';
    const EVENT_PHOTO_DELETION = 'photo_deletion';
    const EVENT_PHOTO_LOCK = 'photo_lock';
    const EVENT_PHOTO_UNLOCK = 'photo_unlock';
    const EVENT_PAYMENT = 'payment';
    const EVENT_RIDE = 'ride';
    const EVENT_USER = 'user';

    // Actions
    const ACTION_CREATE = 'create';
    const ACTION_UPDATE = 'update';
    const ACTION_DELETE = 'delete';
    const ACTION_APPROVE = 'approve';
    const ACTION_REJECT = 'reject';
    const ACTION_LOCK = 'lock';
    const ACTION_UNLOCK = 'unlock';
    const ACTION_PROCESS = 'process';
    const ACTION_COMPLETE = 'complete';
    const ACTION_FAIL = 'fail';
    const ACTION_VOID = 'void';
    const ACTION_REFUND = 'refund';
    const ACTION_CAPTURE = 'capture';
    const ACTION_AUTHORISE = 'authorise';

    /**
     * Get the user who performed the action.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the auditable model.
     *
     * @return MorphTo
     */
    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Create an audit log entry.
     *
     * @param string $action
     * @param Model $model
     * @param string $eventType
     * @param array|null $oldValues
     * @param array|null $newValues
     * @param string|null $description
     * @return AuditLog
     */
    public static function log(
        string $action,
        Model $model,
        string $eventType,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?string $description = null
    ): AuditLog {
        $user = auth()->user();

        return self::create([
            'user_id' => $user?->id,
            'user_type' => $user ? getCurrentRoleName() : null,
            'action' => $action,
            'auditable_type' => get_class($model),
            'auditable_id' => $model->id,
            'event_type' => $eventType,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Log a bank change event.
     */
    public static function logBankChange(Model $model, ?array $oldValues, array $newValues, ?string $description = null): AuditLog
    {
        return self::log(self::ACTION_UPDATE, $model, self::EVENT_BANK_CHANGE, $oldValues, $newValues, $description);
    }

    /**
     * Log a driver approval event.
     */
    public static function logDriverApproval(Model $model, bool $approved, ?string $description = null): AuditLog
    {
        $action = $approved ? self::ACTION_APPROVE : self::ACTION_REJECT;
        return self::log($action, $model, self::EVENT_DRIVER_APPROVAL, null, ['approved' => $approved], $description);
    }

    /**
     * Log a payout event.
     */
    public static function logPayout(Model $model, string $action, ?array $details = null, ?string $description = null): AuditLog
    {
        return self::log($action, $model, self::EVENT_PAYOUT, null, $details, $description);
    }

    /**
     * Log a coupon event.
     */
    public static function logCoupon(Model $model, string $action, ?array $oldValues = null, ?array $newValues = null, ?string $description = null): AuditLog
    {
        return self::log($action, $model, self::EVENT_COUPON, $oldValues, $newValues, $description);
    }

    /**
     * Log a photo deletion event.
     */
    public static function logPhotoDeletion(Model $model, array $photoDetails, ?string $description = null): AuditLog
    {
        return self::log(self::ACTION_DELETE, $model, self::EVENT_PHOTO_DELETION, $photoDetails, null, $description);
    }

    /**
     * Log a photo lock event.
     */
    public static function logPhotoLock(Model $model, ?string $description = null): AuditLog
    {
        return self::log(self::ACTION_LOCK, $model, self::EVENT_PHOTO_LOCK, null, ['locked' => true], $description);
    }

    /**
     * Log a photo unlock event.
     */
    public static function logPhotoUnlock(Model $model, ?string $description = null): AuditLog
    {
        return self::log(self::ACTION_UNLOCK, $model, self::EVENT_PHOTO_UNLOCK, null, ['locked' => false], $description);
    }

    /**
     * Log a payment event.
     */
    public static function logPayment(Model $model, string $action, ?array $details = null, ?string $description = null): AuditLog
    {
        return self::log($action, $model, self::EVENT_PAYMENT, null, $details, $description);
    }

    /**
     * Scope to filter by event type.
     */
    public function scopeOfEventType($query, string $eventType)
    {
        return $query->where('event_type', $eventType);
    }

    /**
     * Scope to filter by action.
     */
    public function scopeOfAction($query, string $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope to filter by user.
     */
    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to filter by auditable model.
     */
    public function scopeForModel($query, Model $model)
    {
        return $query->where('auditable_type', get_class($model))
            ->where('auditable_id', $model->id);
    }
}
