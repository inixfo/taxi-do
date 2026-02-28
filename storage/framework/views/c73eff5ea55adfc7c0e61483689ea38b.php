<?php $__env->startSection('title', __('Audit Logs')); ?>
<?php $__env->startSection('content'); ?>
<div class="contentbox">
    <div class="inside">
        <div class="contentbox-title">
            <h3>Audit Logs</h3>
            <a href="<?php echo e(route('admin.audit-logs.export', request()->query())); ?>" class="btn btn-outline">
                <i class="ri-download-line"></i> Export CSV
            </a>
        </div>

        <!-- Filters -->
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <label class="form-label">Event Type</label>
                <select name="event_type" class="form-select">
                    <option value="">All Events</option>
                    <?php $__currentLoopData = $eventTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($key); ?>" <?php echo e(request('event_type') == $key ? 'selected' : ''); ?>>
                            <?php echo e($label); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Action</label>
                <select name="action" class="form-select">
                    <option value="">All Actions</option>
                    <?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($key); ?>" <?php echo e(request('action') == $key ? 'selected' : ''); ?>>
                            <?php echo e($label); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control" value="<?php echo e(request('start_date')); ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label">End Date</label>
                <input type="date" name="end_date" class="form-control" value="<?php echo e(request('end_date')); ?>">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">Filter</button>
                <a href="<?php echo e(route('admin.audit-logs.index')); ?>" class="btn btn-outline-secondary">Reset</a>
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
                    <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($log->id); ?></td>
                            <td>
                                <?php echo e($log->user?->name ?? 'System'); ?>

                                <?php if($log->user_type): ?>
                                    <br><small class="text-muted"><?php echo e(ucfirst($log->user_type)); ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-<?php echo e(getActionBadgeClass($log->action)); ?>">
                                    <?php echo e(ucfirst($log->action)); ?>

                                </span>
                            </td>
                            <td><?php echo e($eventTypes[$log->event_type] ?? $log->event_type); ?></td>
                            <td>
                                <?php echo e(class_basename($log->auditable_type)); ?>

                                <br><small class="text-muted">#<?php echo e($log->auditable_id); ?></small>
                            </td>
                            <td><?php echo e(Str::limit($log->description, 50)); ?></td>
                            <td><small><?php echo e($log->ip_address); ?></small></td>
                            <td><?php echo e($log->created_at->format('M d, Y H:i')); ?></td>
                            <td>
                                <a href="<?php echo e(route('admin.audit-logs.show', $log->id)); ?>" class="btn btn-sm btn-outline-info">
                                    <i class="ri-eye-line"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <i class="ri-file-list-line" style="font-size: 48px; color: #ccc;"></i>
                                <p class="text-muted mt-2">No audit logs found</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            <?php echo e($logs->appends(request()->query())->links()); ?>

        </div>
    </div>
</div>

<?php
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
?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/audit-logs/index.blade.php ENDPATH**/ ?>