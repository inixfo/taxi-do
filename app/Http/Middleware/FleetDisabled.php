<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FleetDisabled
{
    /**
     * Handle an incoming request.
     *
     * This middleware blocks all fleet-related endpoints when fleet functionality
     * is disabled. Returns 404 to indicate the feature doesn't exist.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if fleet is enabled in settings
        $fleetEnabled = config('taxido.fleet_enabled', false);
        
        // Also check database settings if available
        try {
            $settings = getTaxidoSettings();
            $fleetEnabled = $settings['activation']['is_fleet_management_active'] ?? false;
        } catch (\Exception $e) {
            // If settings not available, default to disabled
            $fleetEnabled = false;
        }

        if (!$fleetEnabled) {
            return response()->json([
                'success' => false,
                'message' => 'Fleet functionality is not available.',
            ], 404);
        }

        return $next($request);
    }
}
