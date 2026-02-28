<?php $__env->startSection('title', __('ticket::static.priority.edit')); ?>
<?php $__env->startSection('content'); ?>
<div class="priority-create">
    <form id="priority" action="<?php echo e(route('admin.priority.update', $priority->id)); ?>" method="POST" enctype="multipart/form-data">
        <div class="row g-xl-4 g-3">
            <?php echo method_field('PUT'); ?>
            <?php echo csrf_field(); ?>
            <?php echo $__env->make('ticket::admin.priority.fields', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Ticket/resources/views/admin/priority/edit.blade.php ENDPATH**/ ?>