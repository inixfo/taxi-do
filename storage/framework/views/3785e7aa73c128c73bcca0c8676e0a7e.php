<?php $__env->startSection('content'); ?>
    <h1>Hello World</h1>

    <p>Module: <?php echo config('iyzico.name'); ?></p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('iyzico::layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Iyzico/resources/views/index.blade.php ENDPATH**/ ?>