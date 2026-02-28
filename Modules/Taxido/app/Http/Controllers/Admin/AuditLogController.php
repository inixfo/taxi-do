<?php

namespace Modules\Taxido\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Taxido\Models\AuditLog;

class AuditLogController extends Controller
{
    /**
     * Display a listing of audit logs.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = AuditLog::with('user')->latest();

        // Filter by event type
        if ($request->has('event_type') && $request->event_type) {
            $query->where('event_type', $request->event_type);
        }

        // Filter by action
        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }

        // Filter by user
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $logs = $query->paginate(25);

        // Get unique event types for filter dropdown
        $eventTypes = [
            AuditLog::EVENT_BANK_CHANGE => 'Bank Changes',
            AuditLog::EVENT_DRIVER_APPROVAL => 'Driver Approvals',
            AuditLog::EVENT_PAYOUT => 'Payouts',
            AuditLog::EVENT_COUPON => 'Coupons',
            AuditLog::EVENT_PHOTO_DELETION => 'Photo Deletions',
            AuditLog::EVENT_PHOTO_LOCK => 'Photo Locks',
            AuditLog::EVENT_PHOTO_UNLOCK => 'Photo Unlocks',
            AuditLog::EVENT_PAYMENT => 'Payments',
            AuditLog::EVENT_RIDE => 'Rides',
            AuditLog::EVENT_USER => 'Users',
        ];

        // Get unique actions for filter dropdown
        $actions = [
            AuditLog::ACTION_CREATE => 'Create',
            AuditLog::ACTION_UPDATE => 'Update',
            AuditLog::ACTION_DELETE => 'Delete',
            AuditLog::ACTION_APPROVE => 'Approve',
            AuditLog::ACTION_REJECT => 'Reject',
            AuditLog::ACTION_LOCK => 'Lock',
            AuditLog::ACTION_UNLOCK => 'Unlock',
            AuditLog::ACTION_PROCESS => 'Process',
            AuditLog::ACTION_COMPLETE => 'Complete',
            AuditLog::ACTION_FAIL => 'Fail',
            AuditLog::ACTION_VOID => 'Void',
            AuditLog::ACTION_REFUND => 'Refund',
            AuditLog::ACTION_CAPTURE => 'Capture',
            AuditLog::ACTION_AUTHORISE => 'Authorise',
        ];

        return view('taxido::admin.audit-logs.index', compact('logs', 'eventTypes', 'actions'));
    }

    /**
     * Display the specified audit log.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show(int $id)
    {
        $log = AuditLog::with('user')->findOrFail($id);

        return view('taxido::admin.audit-logs.show', compact('log'));
    }

    /**
     * Get audit logs for a specific model.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forModel(Request $request)
    {
        $validated = $request->validate([
            'model_type' => 'required|string',
            'model_id' => 'required|integer',
        ]);

        $logs = AuditLog::where('auditable_type', $validated['model_type'])
            ->where('auditable_id', $validated['model_id'])
            ->with('user')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'logs' => $logs,
        ]);
    }

    /**
     * Export audit logs to CSV.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export(Request $request)
    {
        $query = AuditLog::with('user')->latest();

        // Apply filters
        if ($request->has('event_type') && $request->event_type) {
            $query->where('event_type', $request->event_type);
        }
        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $logs = $query->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="audit_logs_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($logs) {
            $file = fopen('php://output', 'w');
            
            // Header row
            fputcsv($file, [
                'ID',
                'User',
                'User Type',
                'Action',
                'Event Type',
                'Model Type',
                'Model ID',
                'Description',
                'IP Address',
                'Date/Time',
            ]);

            // Data rows
            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->id,
                    $log->user?->name ?? 'System',
                    $log->user_type ?? 'N/A',
                    $log->action,
                    $log->event_type,
                    class_basename($log->auditable_type),
                    $log->auditable_id,
                    $log->description,
                    $log->ip_address,
                    $log->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
