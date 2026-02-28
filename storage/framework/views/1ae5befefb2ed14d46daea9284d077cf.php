<?php $__env->startSection('title', __('taxido::static.extra_charges.edit')); ?>
<?php $__env->startSection('content'); ?>
<div class="banner-main">
    <form id="extraChargeForm" action="<?php echo e(route('admin.extra-charge.update', $extraCharge->id)); ?>" method="POST" enctype="multipart/form-data">
        <div class="row g-xl-4 g-3">
            <?php echo method_field('PUT'); ?>
            <?php echo csrf_field(); ?>
            <?php echo $__env->make('taxido::admin.extra-charge.fields', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/extra-charge/edit.blade.php ENDPATH**/ ?>