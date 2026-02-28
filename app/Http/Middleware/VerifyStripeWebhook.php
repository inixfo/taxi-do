<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Stripe\Exception\SignatureVerificationException;
use Stripe\WebhookSignature;

class VerifyStripeWebhook
{
    /**
     * Handle an incoming request.
     *
     * Verifies the Stripe webhook signature to ensure the request
     * is genuinely from Stripe.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = config('services.stripe.webhook_secret') ?? env('STRIPE_WEBHOOK_SECRET_KEY');

        if (empty($webhookSecret)) {
            \Log::warning('Stripe webhook secret not configured');
            return response()->json([
                'success' => false,
                'message' => 'Webhook verification not configured',
            ], 500);
        }

        if (empty($sigHeader)) {
            \Log::warning('Missing Stripe-Signature header', [
                'ip' => $request->ip(),
                'url' => $request->url(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Missing signature header',
            ], 400);
        }

        try {
            // Verify the webhook signature
            WebhookSignature::verifyHeader(
                $payload,
                $sigHeader,
                $webhookSecret,
                300 // Tolerance of 5 minutes
            );

            return $next($request);
        } catch (SignatureVerificationException $e) {
            \Log::error('Stripe webhook signature verification failed', [
                'error' => $e->getMessage(),
                'ip' => $request->ip(),
                'url' => $request->url(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Invalid webhook signature',
            ], 400);
        } catch (\Exception $e) {
            \Log::error('Stripe webhook verification error', [
                'error' => $e->getMessage(),
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Webhook verification failed',
            ], 500);
        }
    }
}
