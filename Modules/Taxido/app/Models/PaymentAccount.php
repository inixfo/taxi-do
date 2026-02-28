<?php

namespace Modules\Taxido\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Crypt;

class PaymentAccount extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'swift',
        'status',
        'user_id',
        'default',
        'bank_name',
        'paypal_email',
        'routing_number',
        'bank_account_no',
        'bank_holder_name',
        // UK Bank Details (encrypted)
        'uk_sort_code',
        'uk_account_number',
        'uk_account_holder_name',
        'uk_bank_name',
        // Stripe Connect
        'stripe_connect_account_id',
        'stripe_connect_onboarding_status',
        'stripe_connect_charges_enabled',
        'stripe_connect_payouts_enabled',
        'stripe_connect_onboarded_at',
        // Payout tracking
        'last_payout_at',
        'last_payout_amount',
        'last_payout_status',
    ];

    protected $casts = [
        'status' => 'integer',
        'user_id' => 'integer',
        'stripe_connect_charges_enabled' => 'boolean',
        'stripe_connect_payouts_enabled' => 'boolean',
        'stripe_connect_onboarded_at' => 'datetime',
        'last_payout_at' => 'datetime',
        'last_payout_amount' => 'decimal:2',
    ];

    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at',
        'user_id',
        'uk_sort_code',      // Hide encrypted data
        'uk_account_number', // Hide encrypted data
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'user_id');
    }

    /**
     * Set the UK sort code (encrypted).
     *
     * @param string|null $value
     */
    public function setUkSortCodeAttribute(?string $value): void
    {
        if ($value) {
            // Log the bank change before encrypting
            if ($this->exists && $this->uk_sort_code !== null) {
                AuditLog::logBankChange(
                    $this,
                    ['uk_sort_code' => $this->getMaskedSortCode()],
                    ['uk_sort_code' => $this->maskSortCode($value)],
                    "UK sort code updated for user ID: {$this->user_id}"
                );
            }
            $this->attributes['uk_sort_code'] = Crypt::encryptString($value);
        } else {
            $this->attributes['uk_sort_code'] = null;
        }
    }

    /**
     * Get the UK sort code (decrypted).
     *
     * @param string|null $value
     * @return string|null
     */
    public function getUkSortCodeAttribute(?string $value): ?string
    {
        if ($value) {
            try {
                return Crypt::decryptString($value);
            } catch (\Exception $e) {
                return null;
            }
        }
        return null;
    }

    /**
     * Set the UK account number (encrypted).
     *
     * @param string|null $value
     */
    public function setUkAccountNumberAttribute(?string $value): void
    {
        if ($value) {
            // Log the bank change before encrypting
            if ($this->exists && $this->uk_account_number !== null) {
                AuditLog::logBankChange(
                    $this,
                    ['uk_account_number' => $this->getMaskedAccountNumber()],
                    ['uk_account_number' => $this->maskAccountNumber($value)],
                    "UK account number updated for user ID: {$this->user_id}"
                );
            }
            $this->attributes['uk_account_number'] = Crypt::encryptString($value);
        } else {
            $this->attributes['uk_account_number'] = null;
        }
    }

    /**
     * Get the UK account number (decrypted).
     *
     * @param string|null $value
     * @return string|null
     */
    public function getUkAccountNumberAttribute(?string $value): ?string
    {
        if ($value) {
            try {
                return Crypt::decryptString($value);
            } catch (\Exception $e) {
                return null;
            }
        }
        return null;
    }

    /**
     * Get masked sort code for display (e.g., **-**-34).
     *
     * @return string|null
     */
    public function getMaskedSortCode(): ?string
    {
        $sortCode = $this->uk_sort_code;
        if (!$sortCode) {
            return null;
        }
        return $this->maskSortCode($sortCode);
    }

    /**
     * Mask a sort code value.
     */
    private function maskSortCode(string $sortCode): string
    {
        // Remove any dashes
        $clean = str_replace('-', '', $sortCode);
        if (strlen($clean) >= 2) {
            return '**-**-' . substr($clean, -2);
        }
        return '**-**-**';
    }

    /**
     * Get masked account number for display (e.g., ****5678).
     *
     * @return string|null
     */
    public function getMaskedAccountNumber(): ?string
    {
        $accountNumber = $this->uk_account_number;
        if (!$accountNumber) {
            return null;
        }
        return $this->maskAccountNumber($accountNumber);
    }

    /**
     * Mask an account number value.
     */
    private function maskAccountNumber(string $accountNumber): string
    {
        if (strlen($accountNumber) >= 4) {
            return '****' . substr($accountNumber, -4);
        }
        return '********';
    }

    /**
     * Check if Stripe Connect onboarding is complete.
     */
    public function isStripeConnectOnboarded(): bool
    {
        return $this->stripe_connect_charges_enabled && $this->stripe_connect_payouts_enabled;
    }

    /**
     * Check if the account has UK bank details.
     */
    public function hasUkBankDetails(): bool
    {
        return !empty($this->uk_sort_code) && !empty($this->uk_account_number);
    }

    /**
     * Get formatted bank details for display (masked).
     */
    public function getFormattedBankDetailsAttribute(): array
    {
        return [
            'uk_sort_code' => $this->getMaskedSortCode(),
            'uk_account_number' => $this->getMaskedAccountNumber(),
            'uk_account_holder_name' => $this->uk_account_holder_name,
            'uk_bank_name' => $this->uk_bank_name,
            'stripe_connect_status' => $this->stripe_connect_onboarding_status,
            'stripe_connect_ready' => $this->isStripeConnectOnboarded(),
        ];
    }
}
