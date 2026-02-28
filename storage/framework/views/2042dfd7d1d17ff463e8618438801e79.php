<?php $__env->startComponent('mail::message'); ?>
    <h1><?php echo e(__('auth.reset_password')); ?></h1>
    <?php echo e(__('auth.code')); ?>

    <h2><?php echo e($token); ?></h2>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /var/www/taxido/Taxido_laravel/resources/views/emails/forgot-password.blade.php ENDPATH**/ ?>