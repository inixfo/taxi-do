<?php

namespace Modules\Taxido\Http\Controllers\Admin;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Taxido\Models\Driver;
use Modules\Taxido\Models\DriverPayout;
use Modules\Taxido\Models\CabCommissionHistory;
use Modules\Taxido\Services\StripePaymentService;
use Carbon\Carbon;

class DriverPayoutController extends Controller
{
    protected $stripeService;

    public function __construct(StripePaymentService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    /**
     * Display a listing of driver payouts.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = DriverPayout::with(['driver', 'processedBy'])->latest();

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by driver
        if ($request->has('driver_id') && $request->driver_id) {
            $query->where('driver_id', $request->driver_id);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $payouts = $query->paginate(25);
        $drivers = Driver::where('status', true)->where('is_verified', true)->get(['id', 'name']);

        // Get summary stats
        $stats = [
            'pending_count' => DriverPayout::pending()->count(),
            'pending_amount' => DriverPayout::pending()->sum('net_payout'),
            'completed_count' => DriverPayout::completed()->count(),
            'completed_amount' => DriverPayout::completed()->sum('net_payout'),
            'failed_count' => DriverPayout::failed()->count(),
        ];

        return view('taxido::admin.driver-payouts.index', compact('payouts', 'drivers', 'stats'));
    }

    /**
     * Display the specified payout details.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show(int $id)
    {
        $payout = DriverPayout::with(['driver', 'processedBy'])->findOrFail($id);

        return view('taxido::admin.driver-payouts.show', compact('payout'));
    }

    /**
     * Generate weekly payouts for all eligible drivers.
     *
     * @return JsonResponse
     */
    public function generateWeeklyPayouts(): JsonResponse
    {
        try {
            // Get the previous week's date range
            $periodStart = Carbon::now()->subWeek()->startOfWeek();
            $periodEnd = Carbon::now()->subWeek()->endOfWeek();

            // Get all verified drivers with Stripe Connect accounts
            $drivers = Driver::where('status', true)
                ->where('is_verified', true)
                ->whereHas('payment_account', function ($query) {
                    $query->whereNotNull('stripe_connect_account_id')
                        ->where('stripe_connect_payouts_enabled', true);
                })
                ->get();

            $payoutsCreated = 0;

            foreach ($drivers as $driver) {
                // Check if payout already exists for this period
                $existingPayout = DriverPayout::where('driver_id', $driver->id)
                    ->where('payout_period_start', $periodStart)
                    ->where('payout_period_end', $periodEnd)
                    ->exists();

                if ($existingPayout) {
                    continue;
                }

                // Calculate earnings for the period
                $commissionHistory = CabCommissionHistory::where('driver_id', $driver->id)
                    ->whereBetween('created_at', [$periodStart, $periodEnd])
                    ->get();

                if ($commissionHistory->isEmpty()) {
                    continue;
                }

                $ridesCount = $commissionHistory->count();
                $grossEarnings = $commissionHistory->sum('driver_commission');
                $commissionDeducted = 0; // Already deducted in cab_commission_history

                // Net payout is the driver's commission
                $netPayout = $grossEarnings;

                // Only create payout if there's something to pay
                if ($netPayout > 0) {
                    DriverPayout::create([
                        'driver_id' => $driver->id,
                        'amount' => $netPayout,
                        'currency' => 'GBP',
                        'status' => DriverPayout::STATUS_PENDING,
                        'payout_period_start' => $periodStart,
                        'payout_period_end' => $periodEnd,
                        'rides_count' => $ridesCount,
                        'gross_earnings' => $grossEarnings,
                        'commission_deducted' => $commissionDeducted,
                        'net_payout' => $netPayout,
                        'scheduled_at' => Carbon::now()->addDay(), // Schedule for tomorrow
                    ]);

                    $payoutsCreated++;
                }
            }

            return response()->json([
                'success' => true,
                'message' => "{$payoutsCreated} payouts created successfully.",
                'payouts_created' => $payoutsCreated,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Process a specific payout.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function processPayout(int $id): JsonResponse
    {
        try {
            $payout = DriverPayout::findOrFail($id);

            if ($payout->status !== DriverPayout::STATUS_PENDING) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payout is not in pending status.',
                ], 422);
            }

            $payout->markAsProcessing();

            // Process via Stripe
            $result = $this->stripeService->transferToDriver($payout);

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'message' => 'Payout processed successfully.',
                    'transfer_id' => $result['transfer_id'],
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['error'],
                ], 500);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Process all pending payouts.
     *
     * @return JsonResponse
     */
    public function processAllPending(): JsonResponse
    {
        try {
            $pendingPayouts = DriverPayout::pending()
                ->where('scheduled_at', '<=', now())
                ->get();

            $processed = 0;
            $failed = 0;

            foreach ($pendingPayouts as $payout) {
                $payout->markAsProcessing();
                $result = $this->stripeService->transferToDriver($payout);

                if ($result['success']) {
                    $processed++;
                } else {
                    $failed++;
                }
            }

            return response()->json([
                'success' => true,
                'message' => "{$processed} payouts processed, {$failed} failed.",
                'processed' => $processed,
                'failed' => $failed,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Retry a failed payout.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function retryPayout(int $id): JsonResponse
    {
        try {
            $payout = DriverPayout::findOrFail($id);

            if (!$payout->canRetry()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This payout cannot be retried.',
                ], 422);
            }

            // Reset to pending
            $payout->update([
                'status' => DriverPayout::STATUS_PENDING,
                'failure_reason' => null,
                'failure_code' => null,
                'failed_at' => null,
            ]);

            // Process immediately
            return $this->processPayout($id);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Cancel a pending payout.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function cancelPayout(int $id): JsonResponse
    {
        try {
            $payout = DriverPayout::findOrFail($id);

            if ($payout->status !== DriverPayout::STATUS_PENDING) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only pending payouts can be cancelled.',
                ], 422);
            }

            $payout->delete();

            return response()->json([
                'success' => true,
                'message' => 'Payout cancelled successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Export payouts to CSV.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export(Request $request)
    {
        $query = DriverPayout::with(['driver'])->latest();

        // Apply filters
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        if ($request->has('driver_id') && $request->driver_id) {
            $query->where('driver_id', $request->driver_id);
        }
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $payouts = $query->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="driver_payouts_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($payouts) {
            $file = fopen('php://output', 'w');
            
            // Header row
            fputcsv($file, [
                'ID',
                'Driver',
                'Period',
                'Rides',
                'Gross Earnings',
                'Commission',
                'Net Payout',
                'Currency',
                'Status',
                'Stripe Transfer ID',
                'Created',
                'Processed',
            ]);

            // Data rows
            foreach ($payouts as $payout) {
                fputcsv($file, [
                    $payout->id,
                    $payout->driver?->name ?? 'N/A',
                    $payout->period_label,
                    $payout->rides_count,
                    number_format($payout->gross_earnings, 2),
                    number_format($payout->commission_deducted, 2),
                    number_format($payout->net_payout, 2),
                    $payout->currency,
                    ucfirst($payout->status),
                    $payout->stripe_transfer_id ?? 'N/A',
                    $payout->created_at->format('Y-m-d H:i'),
                    $payout->completed_at?->format('Y-m-d H:i') ?? 'N/A',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
