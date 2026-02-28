<?php $__env->startSection('title', __('taxido::static.cancellation-reasons.add')); ?>
<?php $__env->startSection('content'); ?>
<div class="cancellationReason-create">
    <form id="cancellationReasonForm" action="<?php echo e(route('admin.cancellation-reason.store')); ?>" method="POST" enctype="multipart/form-data">
        <div class="row g-xl-4 g-3">
            <?php echo method_field('POST'); ?>
            <?php echo csrf_field(); ?>
            <?php echo $__env->make('taxido::admin.cancellation-reason.fields', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/cancellation-reason/create.blade.php ENDPATH**/ ?>