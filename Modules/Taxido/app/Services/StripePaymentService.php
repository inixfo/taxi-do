<?php

namespace Modules\Taxido\Services;

use Exception;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Refund;
use Stripe\Transfer;
use Stripe\Account;
use Stripe\AccountLink;
use Illuminate\Support\Facades\Log;
use Modules\Taxido\Models\Ride;
use Modules\Taxido\Models\Driver;
use Modules\Taxido\Models\AuditLog;
use Modules\Taxido\Models\DriverPayout;
use Modules\Taxido\Models\PaymentAccount;

class StripePaymentService
{
    protected $stripeSecretKey;
    protected $currency;

    public function __construct()
    {
        $this->stripeSecretKey = config('services.stripe.secret') ?? env('STRIPE_SECRET_KEY');
        $this->currency = config('services.stripe.currency', 'gbp');
        
        if ($this->stripeSecretKey) {
            Stripe::setApiKey($this->stripeSecretKey);
        }
    }

    /**
     * Create a PaymentIntent with manual capture (authorization only).
     *
     * @param Ride $ride
     * @param float $amount Amount in the smallest currency unit (e.g., pence for GBP)
     * @param string $paymentMethodId
     * @return array
     */
    public function authorisePayment(Ride $ride, float $amount, string $paymentMethodId): array
    {
        try {
            $amountInCents = (int) round($amount * 100);

            $paymentIntent = PaymentIntent::create([
                'amount' => $amountInCents,
                'currency' => $this->currency,
                'payment_method' => $paymentMethodId,
                'capture_method' => 'manual', // Manual capture - authorize now, capture later
                'confirm' => true,
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never',
                ],
                'metadata' => [
                    'ride_id' => $ride->id,
                    'ride_number' => $ride->ride_number,
                    'rider_id' => $ride->rider_id,
                    'type' => 'ride_authorization',
                ],
            ]);

            // Update ride with payment intent details
            $ride->update([
                'stripe_payment_intent_id' => $paymentIntent->id,
                'stripe_payment_method_id' => $paymentMethodId,
                'authorised_amount' => $amount,
                'payment_capture_status' => 'authorised',
                'payment_authorised_at' => now(),
            ]);

            // Log the authorization
            AuditLog::logPayment($ride, AuditLog::ACTION_AUTHORISE, [
                'payment_intent_id' => $paymentIntent->id,
                'amount' => $amount,
                'status' => $paymentIntent->status,
            ], "Payment authorised for ride #{$ride->ride_number}");

            return [
                'success' => true,
                'payment_intent_id' => $paymentIntent->id,
                'client_secret' => $paymentIntent->client_secret,
                'status' => $paymentIntent->status,
            ];
        } catch (Exception $e) {
            Log::error('Stripe authorization failed: ' . $e->getMessage(), [
                'ride_id' => $ride->id,
                'amount' => $amount,
            ]);

            $ride->update([
                'payment_capture_status' => 'failed',
                'payment_error_message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Capture the authorized payment (on trip completion).
     *
     * @param Ride $ride
     * @param float|null $finalAmount If null, captures the full authorized amount
     * @return array
     */
    public function capturePayment(Ride $ride, ?float $finalAmount = null): array
    {
        try {
            if (empty($ride->stripe_payment_intent_id)) {
                throw new Exception('No payment intent found for this ride');
            }

            if ($ride->payment_capture_status !== 'authorised') {
                throw new Exception('Payment is not in authorised state');
            }

            $paymentIntent = PaymentIntent::retrieve($ride->stripe_payment_intent_id);

            $captureParams = [];
            if ($finalAmount !== null) {
                $amountInCents = (int) round($finalAmount * 100);
                $captureParams['amount_to_capture'] = $amountInCents;
            }

            $capturedIntent = $paymentIntent->capture($captureParams);

            $capturedAmount = $capturedIntent->amount_received / 100;

            // Update ride with captured amount
            $ride->update([
                'captured_amount' => $capturedAmount,
                'payment_capture_status' => 'captured',
                'payment_captured_at' => now(),
            ]);

            // Log the capture
            AuditLog::logPayment($ride, AuditLog::ACTION_CAPTURE, [
                'payment_intent_id' => $capturedIntent->id,
                'captured_amount' => $capturedAmount,
                'status' => $capturedIntent->status,
            ], "Payment captured for ride #{$ride->ride_number}");

            return [
                'success' => true,
                'payment_intent_id' => $capturedIntent->id,
                'captured_amount' => $capturedAmount,
                'status' => $capturedIntent->status,
            ];
        } catch (Exception $e) {
            Log::error('Stripe capture failed: ' . $e->getMessage(), [
                'ride_id' => $ride->id,
                'payment_intent_id' => $ride->stripe_payment_intent_id,
            ]);

            $ride->update([
                'payment_error_message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Void/Cancel the authorized payment (before trip start).
     *
     * @param Ride $ride
     * @return array
     */
    public function voidPayment(Ride $ride): array
    {
        try {
            if (empty($ride->stripe_payment_intent_id)) {
                throw new Exception('No payment intent found for this ride');
            }

            if ($ride->payment_capture_status !== 'authorised') {
                throw new Exception('Payment is not in authorised state');
            }

            $paymentIntent = PaymentIntent::retrieve($ride->stripe_payment_intent_id);
            $cancelledIntent = $paymentIntent->cancel();

            // Update ride
            $ride->update([
                'payment_capture_status' => 'voided',
                'payment_voided_at' => now(),
            ]);

            // Log the void
            AuditLog::logPayment($ride, AuditLog::ACTION_VOID, [
                'payment_intent_id' => $cancelledIntent->id,
                'status' => $cancelledIntent->status,
            ], "Payment voided for ride #{$ride->ride_number}");

            return [
                'success' => true,
                'payment_intent_id' => $cancelledIntent->id,
                'status' => $cancelledIntent->status,
            ];
        } catch (Exception $e) {
            Log::error('Stripe void failed: ' . $e->getMessage(), [
                'ride_id' => $ride->id,
                'payment_intent_id' => $ride->stripe_payment_intent_id,
            ]);

            $ride->update([
                'payment_error_message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Refund the captured payment (if trip cancelled after capture).
     *
     * @param Ride $ride
     * @param float|null $amount Amount to refund, null for full refund
     * @return array
     */
    public function refundPayment(Ride $ride, ?float $amount = null): array
    {
        try {
            if (empty($ride->stripe_payment_intent_id)) {
                throw new Exception('No payment intent found for this ride');
            }

            if ($ride->payment_capture_status !== 'captured') {
                throw new Exception('Payment has not been captured');
            }

            $refundParams = [
                'payment_intent' => $ride->stripe_payment_intent_id,
            ];

            if ($amount !== null) {
                $refundParams['amount'] = (int) round($amount * 100);
            }

            $refund = Refund::create($refundParams);

            $refundedAmount = $refund->amount / 100;

            // Update ride
            $ride->update([
                'refunded_amount' => $refundedAmount,
                'payment_capture_status' => 'refunded',
                'payment_refunded_at' => now(),
            ]);

            // Log the refund
            AuditLog::logPayment($ride, AuditLog::ACTION_REFUND, [
                'refund_id' => $refund->id,
                'refunded_amount' => $refundedAmount,
                'status' => $refund->status,
            ], "Payment refunded for ride #{$ride->ride_number}");

            return [
                'success' => true,
                'refund_id' => $refund->id,
                'refunded_amount' => $refundedAmount,
                'status' => $refund->status,
            ];
        } catch (Exception $e) {
            Log::error('Stripe refund failed: ' . $e->getMessage(), [
                'ride_id' => $ride->id,
                'payment_intent_id' => $ride->stripe_payment_intent_id,
            ]);

            $ride->update([
                'payment_error_message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Create a Stripe Connect account for a driver.
     *
     * @param Driver $driver
     * @return array
     */
    public function createConnectAccount(Driver $driver): array
    {
        try {
            $account = Account::create([
                'type' => 'express',
                'country' => 'GB',
                'email' => $driver->email,
                'capabilities' => [
                    'card_payments' => ['requested' => true],
                    'transfers' => ['requested' => true],
                ],
                'business_type' => 'individual',
                'metadata' => [
                    'driver_id' => $driver->id,
                    'driver_email' => $driver->email,
                ],
            ]);

            // Update payment account
            $paymentAccount = $driver->payment_account;
            if (!$paymentAccount) {
                $paymentAccount = PaymentAccount::create([
                    'user_id' => $driver->id,
                    'status' => 1,
                ]);
            }

            $paymentAccount->update([
                'stripe_connect_account_id' => $account->id,
                'stripe_connect_onboarding_status' => 'pending',
            ]);

            return [
                'success' => true,
                'account_id' => $account->id,
            ];
        } catch (Exception $e) {
            Log::error('Stripe Connect account creation failed: ' . $e->getMessage(), [
                'driver_id' => $driver->id,
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Generate onboarding link for Stripe Connect.
     *
     * @param Driver $driver
     * @param string $refreshUrl
     * @param string $returnUrl
     * @return array
     */
    public function createOnboardingLink(Driver $driver, string $refreshUrl, string $returnUrl): array
    {
        try {
            $paymentAccount = $driver->payment_account;
            
            if (!$paymentAccount || empty($paymentAccount->stripe_connect_account_id)) {
                // Create account first
                $result = $this->createConnectAccount($driver);
                if (!$result['success']) {
                    return $result;
                }
                $paymentAccount = $driver->payment_account()->first();
            }

            $accountLink = AccountLink::create([
                'account' => $paymentAccount->stripe_connect_account_id,
                'refresh_url' => $refreshUrl,
                'return_url' => $returnUrl,
                'type' => 'account_onboarding',
            ]);

            return [
                'success' => true,
                'url' => $accountLink->url,
            ];
        } catch (Exception $e) {
            Log::error('Stripe Connect onboarding link creation failed: ' . $e->getMessage(), [
                'driver_id' => $driver->id,
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Check and update Stripe Connect account status.
     *
     * @param Driver $driver
     * @return array
     */
    public function checkConnectAccountStatus(Driver $driver): array
    {
        try {
            $paymentAccount = $driver->payment_account;
            
            if (!$paymentAccount || empty($paymentAccount->stripe_connect_account_id)) {
                return [
                    'success' => false,
                    'error' => 'No Stripe Connect account found',
                ];
            }

            $account = Account::retrieve($paymentAccount->stripe_connect_account_id);

            $chargesEnabled = $account->charges_enabled;
            $payoutsEnabled = $account->payouts_enabled;

            $status = 'pending';
            if ($chargesEnabled && $payoutsEnabled) {
                $status = 'complete';
            } elseif ($account->details_submitted) {
                $status = 'pending_verification';
            }

            $paymentAccount->update([
                'stripe_connect_charges_enabled' => $chargesEnabled,
                'stripe_connect_payouts_enabled' => $payoutsEnabled,
                'stripe_connect_onboarding_status' => $status,
                'stripe_connect_onboarded_at' => ($chargesEnabled && $payoutsEnabled) ? now() : null,
            ]);

            return [
                'success' => true,
                'charges_enabled' => $chargesEnabled,
                'payouts_enabled' => $payoutsEnabled,
                'status' => $status,
            ];
        } catch (Exception $e) {
            Log::error('Stripe Connect status check failed: ' . $e->getMessage(), [
                'driver_id' => $driver->id,
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Transfer funds to driver's Stripe Connect account.
     *
     * @param DriverPayout $payout
     * @return array
     */
    public function transferToDriver(DriverPayout $payout): array
    {
        try {
            $driver = $payout->driver;
            $paymentAccount = $driver->payment_account;

            if (!$paymentAccount || empty($paymentAccount->stripe_connect_account_id)) {
                throw new Exception('Driver does not have a Stripe Connect account');
            }

            if (!$paymentAccount->isStripeConnectOnboarded()) {
                throw new Exception('Driver Stripe Connect onboarding is not complete');
            }

            $amountInCents = (int) round($payout->net_payout * 100);

            $transfer = Transfer::create([
                'amount' => $amountInCents,
                'currency' => $payout->currency,
                'destination' => $paymentAccount->stripe_connect_account_id,
                'metadata' => [
                    'payout_id' => $payout->id,
                    'driver_id' => $driver->id,
                    'period' => $payout->period_label,
                ],
            ]);

            $payout->markAsCompleted($transfer->id);

            // Update payment account
            $paymentAccount->update([
                'last_payout_at' => now(),
                'last_payout_amount' => $payout->net_payout,
                'last_payout_status' => 'completed',
            ]);

            // Log the payout
            AuditLog::logPayout($payout, AuditLog::ACTION_COMPLETE, [
                'transfer_id' => $transfer->id,
                'amount' => $payout->net_payout,
                'driver_id' => $driver->id,
            ], "Payout completed for driver #{$driver->id}");

            return [
                'success' => true,
                'transfer_id' => $transfer->id,
            ];
        } catch (Exception $e) {
            Log::error('Stripe transfer failed: ' . $e->getMessage(), [
                'payout_id' => $payout->id,
                'driver_id' => $payout->driver_id,
            ]);

            $payout->markAsFailed($e->getMessage());

            // Log the failure
            AuditLog::logPayout($payout, AuditLog::ACTION_FAIL, [
                'error' => $e->getMessage(),
                'driver_id' => $payout->driver_id,
            ], "Payout failed for driver #{$payout->driver_id}");

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Verify Stripe webhook signature.
     *
     * @param string $payload
     * @param string $signature
     * @return array
     */
    public function verifyWebhookSignature(string $payload, string $signature): array
    {
        try {
            $webhookSecret = config('services.stripe.webhook_secret') ?? env('STRIPE_WEBHOOK_SECRET');
            
            if (!$webhookSecret) {
                throw new Exception('Webhook secret not configured');
            }

            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $signature,
                $webhookSecret
            );

            return [
                'success' => true,
                'event' => $event,
            ];
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Stripe webhook signature verification failed: ' . $e->getMessage());

            return [
                'success' => false,
                'error' => 'Invalid signature',
            ];
        } catch (Exception $e) {
            Log::error('Stripe webhook error: ' . $e->getMessage());

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
