<?php $__env->startSection('title', __('Audit Log Details')); ?>
<?php $__env->startSection('content'); ?>
<div class="contentbox">
    <div class="inside">
        <div class="contentbox-title">
            <div class="d-flex align-items-center gap-3">
                <a href="<?php echo e(route('admin.audit-logs.index')); ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="ri-arrow-left-line"></i> Back
                </a>
                <h3>Audit Log #<?php echo e($log->id); ?></h3>
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
                                <td><?php echo e($log->user?->name ?? 'System'); ?></td>
                            </tr>
                            <tr>
                                <th>User Type</th>
                                <td><?php echo e(ucfirst($log->user_type ?? 'N/A')); ?></td>
                            </tr>
                            <tr>
                                <th>Action</th>
                                <td><span class="badge bg-primary"><?php echo e(ucfirst($log->action)); ?></span></td>
                            </tr>
                            <tr>
                                <th>Event Type</th>
                                <td><?php echo e(str_replace('_', ' ', ucfirst($log->event_type))); ?></td>
                            </tr>
                            <tr>
                                <th>Model</th>
                                <td><?php echo e(class_basename($log->auditable_type)); ?> #<?php echo e($log->auditable_id); ?></td>
                            </tr>
                            <tr>
                                <th>IP Address</th>
                                <td><?php echo e($log->ip_address ?? 'N/A'); ?></td>
                            </tr>
                            <tr>
                                <th>Date/Time</th>
                                <td><?php echo e($log->created_at->format('M d, Y H:i:s')); ?></td>
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
                        <p><?php echo e($log->description ?? 'No description provided'); ?></p>
                    </div>
                </div>

                <?php if($log->user_agent): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">User Agent</h5>
                    </div>
                    <div class="card-body">
                        <small class="text-muted"><?php echo e($log->user_agent); ?></small>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if($log->old_values || $log->new_values): ?>
        <div class="row">
            <?php if($log->old_values): ?>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">Old Values</h5>
                    </div>
                    <div class="card-body">
                        <pre class="mb-0" style="max-height: 300px; overflow: auto;"><?php echo e(json_encode($log->old_values, JSON_PRETTY_PRINT)); ?></pre>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if($log->new_values): ?>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">New Values</h5>
                    </div>
                    <div class="card-body">
                        <pre class="mb-0" style="max-height: 300px; overflow: auto;"><?php echo e(json_encode($log->new_values, JSON_PRETTY_PRINT)); ?></pre>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/audit-logs/show.blade.php ENDPATH**/ ?>