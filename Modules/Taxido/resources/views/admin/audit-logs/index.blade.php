@extends('admin.layouts.master')
@section('title', __('Audit Logs'))
@section('content')
<div class="contentbox">
    <div class="inside">
        <div class="contentbox-title">
            <h3>Audit Logs</h3>
            <a href="{{ route('admin.audit-logs.export', request()->query()) }}" class="btn btn-outline">
                <i class="ri-download-line"></i> Export CSV
            </a>
        </div>

        <!-- Filters -->
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <label class="form-label">Event Type</label>
                <select name="event_type" class="form-select">
                    <option value="">All Events</option>
                    @foreach($eventTypes as $key => $label)
                        <option value="{{ $key }}" {{ request('event_type') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Action</label>
                <select name="action" class="form-select">
                    <option value="">All Actions</option>
                    @foreach($actions as $key => $label)
                        <option value="{{ $key }}" {{ request('action') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">End Date</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">Filter</button>
                <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>

        <!-- Logs Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Event Type</th>
                        <th>Model</th>
                        <th>Description</th>
                        <th>IP Address</th>
                        <th>Date/Time</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td>{{ $log->id }}</td>
                            <td>
                                {{ $log->user?->name ?? 'System' }}
                                @if($log->user_type)
                                    <br><small class="text-muted">{{ ucfirst($log->user_type) }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ getActionBadgeClass($log->action) }}">
                                    {{ ucfirst($log->action) }}
                                </span>
                            </td>
                            <td>{{ $eventTypes[$log->event_type] ?? $log->event_type }}</td>
                            <td>
                                {{ class_basename($log->auditable_type) }}
                                <br><small class="text-muted">#{{ $log->auditable_id }}</small>
                            </td>
                            <td>{{ Str::limit($log->description, 50) }}</td>
                            <td><small>{{ $log->ip_address }}</small></td>
                            <td>{{ $log->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.audit-logs.show', $log->id) }}" class="btn btn-sm btn-outline-info">
                                    <i class="ri-eye-line"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <i class="ri-file-list-line" style="font-size: 48px; color: #ccc;"></i>
                                <p class="text-muted mt-2">No audit logs found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $logs->appends(request()->query())->links() }}
        </div>
    </div>
</div>

@php
function getActionBadgeClass($action) {
    return match($action) {
        'create' => 'success',
        'update' => 'primary',
        'delete' => 'danger',
        'approve' => 'success',
        'reject' => 'danger',
        'lock' => 'warning',
        'unlock' => 'info',
        default => 'secondary',
    };
}
@endphp
@endsection
