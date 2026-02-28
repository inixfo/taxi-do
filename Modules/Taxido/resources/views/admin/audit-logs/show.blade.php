@extends('admin.layouts.master')
@section('title', __('Audit Log Details'))
@section('content')
<div class="contentbox">
    <div class="inside">
        <div class="contentbox-title">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="ri-arrow-left-line"></i> Back
                </a>
                <h3>Audit Log #{{ $log->id }}</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Basic Information</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">User</th>
                                <td>{{ $log->user?->name ?? 'System' }}</td>
                            </tr>
                            <tr>
                                <th>User Type</th>
                                <td>{{ ucfirst($log->user_type ?? 'N/A') }}</td>
                            </tr>
                            <tr>
                                <th>Action</th>
                                <td><span class="badge bg-primary">{{ ucfirst($log->action) }}</span></td>
                            </tr>
                            <tr>
                                <th>Event Type</th>
                                <td>{{ str_replace('_', ' ', ucfirst($log->event_type)) }}</td>
                            </tr>
                            <tr>
                                <th>Model</th>
                                <td>{{ class_basename($log->auditable_type) }} #{{ $log->auditable_id }}</td>
                            </tr>
                            <tr>
                                <th>IP Address</th>
                                <td>{{ $log->ip_address ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Date/Time</th>
                                <td>{{ $log->created_at->format('M d, Y H:i:s') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Description</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ $log->description ?? 'No description provided' }}</p>
                    </div>
                </div>

                @if($log->user_agent)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">User Agent</h5>
                    </div>
                    <div class="card-body">
                        <small class="text-muted">{{ $log->user_agent }}</small>
                    </div>
                </div>
                @endif
            </div>
        </div>

        @if($log->old_values || $log->new_values)
        <div class="row">
            @if($log->old_values)
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">Old Values</h5>
                    </div>
                    <div class="card-body">
                        <pre class="mb-0" style="max-height: 300px; overflow: auto;">{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                </div>
            </div>
            @endif

            @if($log->new_values)
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">New Values</h5>
                    </div>
                    <div class="card-body">
                        <pre class="mb-0" style="max-height: 300px; overflow: auto;">{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection
