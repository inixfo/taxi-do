<?php $__env->startSection('title', __('Payout Details')); ?>
<?php $__env->startSection('content'); ?>
<div class="contentbox">
    <div class="inside">
        <div class="contentbox-title">
            <div class="d-flex align-items-center gap-3">
                <a href="<?php echo e(route('admin.driver-payouts.index')); ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="ri-arrow-left-line"></i> Back
                </a>
                <h3>Payout #<?php echo e($payout->id); ?></h3>
            </div>
            <span class="badge bg-<?php echo e($payout->status_class); ?> fs-6"><?php echo e(ucfirst($payout->status)); ?></span>
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
                                <td><?php echo e($payout->driver?->name ?? 'N/A'); ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo e($payout->driver?->email ?? 'N/A'); ?></td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td><?php echo e($payout->driver?->phone ?? 'N/A'); ?></td>
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
                                <td><?php echo e($payout->period_label); ?></td>
                            </tr>
                            <tr>
                                <th>Rides Count</th>
                                <td><?php echo e($payout->rides_count); ?></td>
                            </tr>
                            <tr>
                                <th>Gross Earnings</th>
                                <td><?php echo e(getDefaultCurrency()?->symbol); ?><?php echo e(number_format($payout->gross_earnings, 2)); ?></td>
                            </tr>
                            <tr>
                                <th>Commission</th>
                                <td>-<?php echo e(getDefaultCurrency()?->symbol); ?><?php echo e(number_format($payout->commission_deducted, 2)); ?></td>
                            </tr>
                            <tr class="table-success">
                                <th>Net Payout</th>
                                <td><strong><?php echo e(getDefaultCurrency()?->symbol); ?><?php echo e(number_format($payout->net_payout, 2)); ?></strong></td>
                            </tr>
                            <tr>
                                <th>Currency</th>
                                <td><?php echo e($payout->currency); ?></td>
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
                                <td><?php echo e($payout->created_at->format('M d, Y H:i:s')); ?></td>
                            </tr>
                            <tr>
                                <th>Scheduled</th>
                                <td><?php echo e($payout->scheduled_at?->format('M d, Y H:i:s') ?? '-'); ?></td>
                            </tr>
                            <tr>
                                <th>Processed</th>
                                <td><?php echo e($payout->processed_at?->format('M d, Y H:i:s') ?? '-'); ?></td>
                            </tr>
                            <tr>
                                <th>Completed</th>
                                <td><?php echo e($payout->completed_at?->format('M d, Y H:i:s') ?? '-'); ?></td>
                            </tr>
                            <?php if($payout->failed_at): ?>
                            <tr class="table-danger">
                                <th>Failed</th>
                                <td><?php echo e($payout->failed_at->format('M d, Y H:i:s')); ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if($payout->processedBy): ?>
                            <tr>
                                <th>Processed By</th>
                                <td><?php echo e($payout->processedBy->name); ?></td>
                            </tr>
                            <?php endif; ?>
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
                                <td><code><?php echo e($payout->stripe_transfer_id ?? '-'); ?></code></td>
                            </tr>
                            <tr>
                                <th>Payout ID</th>
                                <td><code><?php echo e($payout->stripe_payout_id ?? '-'); ?></code></td>
                            </tr>
                            <?php if($payout->failure_reason): ?>
                            <tr class="table-danger">
                                <th>Failure Reason</th>
                                <td><?php echo e($payout->failure_reason); ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if($payout->failure_code): ?>
                            <tr>
                                <th>Failure Code</th>
                                <td><?php echo e($payout->failure_code); ?></td>
                            </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/driver-payouts/show.blade.php ENDPATH**/ ?>