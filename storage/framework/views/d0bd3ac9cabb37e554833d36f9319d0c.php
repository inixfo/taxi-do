<?php $__env->startSection('title', __('taxido::static.surge_prices.add')); ?>
<?php $__env->startSection('content'); ?>
    <div class="surgePrice-create">
        <form id="surgePriceForm" action="<?php echo e(route('admin.surge-price.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo method_field('POST'); ?>
            <?php echo csrf_field(); ?>
            <?php echo $__env->make('taxido::admin.surge-price.fields', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/surge-price/create.blade.php ENDPATH**/ ?>