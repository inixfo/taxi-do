<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class RateLimitMiddleware
{
    /**
     * Handle an incoming request with rate limiting.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $type  The type of rate limit (login, booking, coupon)
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $type = 'default'): Response
    {
        $key = $this->resolveRequestKey($request, $type);
        $limits = $this->getLimitsForType($type);

        if (RateLimiter::tooManyAttempts($key, $limits['max_attempts'])) {
            $seconds = RateLimiter::availableIn($key);
            
            return response()->json([
                'success' => false,
                'message' => "Too many attempts. Please try again in {$seconds} seconds.",
                'retry_after' => $seconds,
            ], 429);
        }

        RateLimiter::hit($key, $limits['decay_seconds']);

        $response = $next($request);

        // Add rate limit headers
        $response->headers->set('X-RateLimit-Limit', $limits['max_attempts']);
        $response->headers->set('X-RateLimit-Remaining', RateLimiter::remaining($key, $limits['max_attempts']));

        return $response;
    }

    /**
     * Resolve the rate limiting key for the request.
     */
    protected function resolveRequestKey(Request $request, string $type): string
    {
        $identifier = $request->user()?->id ?? $request->ip();
        return "rate_limit:{$type}:{$identifier}";
    }

    /**
     * Get rate limits for a specific type.
     */
    protected function getLimitsForType(string $type): array
    {
        return match ($type) {
            'login' => [
                'max_attempts' => 5,      // 5 attempts
                'decay_seconds' => 300,   // per 5 minutes
            ],
            'booking' => [
                'max_attempts' => 10,     // 10 attempts
                'decay_seconds' => 60,    // per minute
            ],
            'coupon' => [
                'max_attempts' => 10,     // 10 attempts
                'decay_seconds' => 60,    // per minute
            ],
            'api' => [
                'max_attempts' => 60,     // 60 attempts
                'decay_seconds' => 60,    // per minute
            ],
            'otp' => [
                'max_attempts' => 3,      // 3 attempts
                'decay_seconds' => 120,   // per 2 minutes
            ],
            default => [
                'max_attempts' => 60,
                'decay_seconds' => 60,
            ],
        };
    }
}
