@extends('admin.layouts.master')
@section('title', __('Payout Details'))
@section('content')
<div class="contentbox">
    <div class="inside">
        <div class="contentbox-title">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('admin.driver-payouts.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="ri-arrow-left-line"></i> Back
                </a>
                <h3>Payout #{{ $payout->id }}</h3>
            </div>
            <span class="badge bg-{{ $payout->status_class }} fs-6">{{ ucfirst($payout->status) }}</span>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Driver Information</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">Name</th>
                                <td>{{ $payout->driver?->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $payout->driver?->email ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $payout->driver?->phone ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Payout Details</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">Period</th>
                                <td>{{ $payout->period_label }}</td>
                            </tr>
                            <tr>
                                <th>Rides Count</th>
                                <td>{{ $payout->rides_count }}</td>
                            </tr>
                            <tr>
                                <th>Gross Earnings</th>
                                <td>{{ getDefaultCurrency()?->symbol }}{{ number_format($payout->gross_earnings, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Commission</th>
                                <td>-{{ getDefaultCurrency()?->symbol }}{{ number_format($payout->commission_deducted, 2) }}</td>
                            </tr>
                            <tr class="table-success">
                                <th>Net Payout</th>
                                <td><strong>{{ getDefaultCurrency()?->symbol }}{{ number_format($payout->net_payout, 2) }}</strong></td>
                            </tr>
                            <tr>
                                <th>Currency</th>
                                <td>{{ $payout->currency }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Timeline</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">Created</th>
                                <td>{{ $payout->created_at->format('M d, Y H:i:s') }}</td>
                            </tr>
                            <tr>
                                <th>Scheduled</th>
                                <td>{{ $payout->scheduled_at?->format('M d, Y H:i:s') ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Processed</th>
                                <td>{{ $payout->processed_at?->format('M d, Y H:i:s') ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Completed</th>
                                <td>{{ $payout->completed_at?->format('M d, Y H:i:s') ?? '-' }}</td>
                            </tr>
                            @if($payout->failed_at)
                            <tr class="table-danger">
                                <th>Failed</th>
                                <td>{{ $payout->failed_at->format('M d, Y H:i:s') }}</td>
                            </tr>
                            @endif
                            @if($payout->processedBy)
                            <tr>
                                <th>Processed By</th>
                                <td>{{ $payout->processedBy->name }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Stripe Information</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">Transfer ID</th>
                                <td><code>{{ $payout->stripe_transfer_id ?? '-' }}</code></td>
                            </tr>
                            <tr>
                                <th>Payout ID</th>
                                <td><code>{{ $payout->stripe_payout_id ?? '-' }}</code></td>
                            </tr>
                            @if($payout->failure_reason)
                            <tr class="table-danger">
                                <th>Failure Reason</th>
                                <td>{{ $payout->failure_reason }}</td>
                            </tr>
                            @endif
                            @if($payout->failure_code)
                            <tr>
                                <th>Failure Code</th>
                                <td>{{ $payout->failure_code }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
