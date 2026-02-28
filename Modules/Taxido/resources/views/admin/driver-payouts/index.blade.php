@extends('admin.layouts.master')
@section('title', __('Driver Payouts'))
@section('content')
<div class="contentbox">
    <div class="inside">
        <div class="contentbox-title">
            <h3>Driver Payouts</h3>
            <div class="d-flex gap-2">
                <button class="btn btn-success" id="generatePayoutsBtn">
                    <i class="ri-calendar-line"></i> Generate Weekly Payouts
                </button>
                <button class="btn btn-primary" id="processAllBtn">
                    <i class="ri-send-plane-line"></i> Process All Pending
                </button>
                <a href="{{ route('admin.driver-payouts.export', request()->query()) }}" class="btn btn-outline">
                    <i class="ri-download-line"></i> Export
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card bg-warning text-dark">
                    <div class="card-body">
                        <h6>Pending</h6>
                        <h3>{{ $stats['pending_count'] }}</h3>
                        <small>{{ getDefaultCurrency()?->symbol }}{{ number_format($stats['pending_amount'], 2) }}</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h6>Completed</h6>
                        <h3>{{ $stats['completed_count'] }}</h3>
                        <small>{{ getDefaultCurrency()?->symbol }}{{ number_format($stats['completed_amount'], 2) }}</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h6>Failed</h6>
                        <h3>{{ $stats['failed_count'] }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Driver</label>
                <select name="driver_id" class="form-select">
                    <option value="">All Drivers</option>
                    @foreach($drivers as $driver)
                        <option value="{{ $driver->id }}" {{ request('driver_id') == $driver->id ? 'selected' : '' }}>
                            {{ $driver->name }}
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
                <a href="{{ route('admin.driver-payouts.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>

        <!-- Payouts Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Driver</th>
                        <th>Period</th>
                        <th>Rides</th>
                        <th>Gross</th>
                        <th>Net Payout</th>
                        <th>Status</th>
                        <th>Processed</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payouts as $payout)
                        <tr>
                            <td>{{ $payout->id }}</td>
                            <td>
                                {{ $payout->driver?->name ?? 'N/A' }}
                                <br><small class="text-muted">{{ $payout->driver?->email }}</small>
                            </td>
                            <td>{{ $payout->period_label }}</td>
                            <td>{{ $payout->rides_count }}</td>
                            <td>{{ getDefaultCurrency()?->symbol }}{{ number_format($payout->gross_earnings, 2) }}</td>
                            <td><strong>{{ getDefaultCurrency()?->symbol }}{{ number_format($payout->net_payout, 2) }}</strong></td>
                            <td>
                                <span class="badge bg-{{ $payout->status_class }}">
                                    {{ ucfirst($payout->status) }}
                                </span>
                            </td>
                            <td>
                                {{ $payout->completed_at?->format('M d, Y H:i') ?? '-' }}
                                @if($payout->processedBy)
                                    <br><small class="text-muted">by {{ $payout->processedBy->name }}</small>
                                @endif
                            </td>
                            <td>
                                @if($payout->status == 'pending')
                                    <button class="btn btn-sm btn-success process-payout" data-id="{{ $payout->id }}">
                                        <i class="ri-send-plane-line"></i> Process
                                    </button>
                                    <button class="btn btn-sm btn-danger cancel-payout" data-id="{{ $payout->id }}">
                                        <i class="ri-close-line"></i>
                                    </button>
                                @elseif($payout->status == 'failed')
                                    <button class="btn btn-sm btn-warning retry-payout" data-id="{{ $payout->id }}">
                                        <i class="ri-refresh-line"></i> Retry
                                    </button>
                                @endif
                                <a href="{{ route('admin.driver-payouts.show', $payout->id) }}" class="btn btn-sm btn-outline-info">
                                    <i class="ri-eye-line"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <i class="ri-money-dollar-circle-line" style="font-size: 48px; color: #ccc;"></i>
                                <p class="text-muted mt-2">No payouts found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $payouts->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    
    // Generate weekly payouts
    $('#generatePayoutsBtn').on('click', function() {
        if (!confirm('Generate weekly payouts for all eligible drivers?')) return;
        const $btn = $(this);
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Generating...');
        
        $.ajax({
            url: '{{ route("admin.driver-payouts.generate-weekly") }}',
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: function(response) {
                alert(response.message);
                location.reload();
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON?.message || 'Failed to generate payouts'));
            },
            complete: function() {
                $btn.prop('disabled', false).html('<i class="ri-calendar-line"></i> Generate Weekly Payouts');
            }
        });
    });
    
    // Process all pending
    $('#processAllBtn').on('click', function() {
        if (!confirm('Process all pending payouts now?')) return;
        const $btn = $(this);
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Processing...');
        
        $.ajax({
            url: '{{ route("admin.driver-payouts.process-all") }}',
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: function(response) {
                alert(response.message);
                location.reload();
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON?.message || 'Failed to process payouts'));
            },
            complete: function() {
                $btn.prop('disabled', false).html('<i class="ri-send-plane-line"></i> Process All Pending');
            }
        });
    });
    
    // Process single payout
    $('.process-payout').on('click', function() {
        const payoutId = $(this).data('id');
        const $btn = $(this);
        $btn.prop('disabled', true);
        
        $.ajax({
            url: '{{ url("admin/driver-payouts") }}/' + payoutId + '/process',
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: function(response) {
                location.reload();
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON?.message || 'Failed to process payout'));
                $btn.prop('disabled', false);
            }
        });
    });
    
    // Retry failed payout
    $('.retry-payout').on('click', function() {
        const payoutId = $(this).data('id');
        const $btn = $(this);
        $btn.prop('disabled', true);
        
        $.ajax({
            url: '{{ url("admin/driver-payouts") }}/' + payoutId + '/retry',
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: function(response) {
                location.reload();
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON?.message || 'Failed to retry payout'));
                $btn.prop('disabled', false);
            }
        });
    });
    
    // Cancel payout
    $('.cancel-payout').on('click', function() {
        if (!confirm('Cancel this payout?')) return;
        const payoutId = $(this).data('id');
        
        $.ajax({
            url: '{{ url("admin/driver-payouts") }}/' + payoutId + '/cancel',
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: function(response) {
                location.reload();
            }
        });
    });
});
</script>
@endpush
