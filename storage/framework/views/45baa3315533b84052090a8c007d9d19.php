<?php $__env->startSection('title', __('ticket::static.status.edit')); ?>
<?php $__env->startSection('content'); ?>
    <div class="status-create">
        <form id="status" action="<?php echo e(route('admin.status.update', $status->id)); ?>" method="POST"
            enctype="multipart/form-data">

            <?php echo method_field('PUT'); ?>
            <?php echo csrf_field(); ?>
            <?php echo $__env->make('ticket::admin.status.fields', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Ticket/resources/views/admin/status/edit.blade.php ENDPATH**/ ?>