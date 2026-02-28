<?php $__env->startSection('title', __('ticket::static.status.add')); ?>
<?php $__env->startSection('content'); ?>
    <div class="status-create">
        <form id="statusForm" action="<?php echo e(route('admin.status.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo method_field('POST'); ?>
            <?php echo csrf_field(); ?>
            <?php echo $__env->make('ticket::admin.status.fields', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Ticket/resources/views/admin/status/create.blade.php ENDPATH**/ ?>