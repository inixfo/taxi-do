<?php $__env->startSection('title', __('static.currencies.edit_currency')); ?>
<?php $__env->startSection('content'); ?>
<div class="currency-main">
    <form id="currencyForm" action="<?php echo e(route('admin.currency.update', $currency->id)); ?>" method="POST" enctype="multipart/form-data">
        <div class="row g-xl-4 g-3">
            <?php echo method_field('PUT'); ?>
            <?php echo csrf_field(); ?>
            <?php echo $__env->make('admin.currency.fields', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/resources/views/admin/currency/edit.blade.php ENDPATH**/ ?>