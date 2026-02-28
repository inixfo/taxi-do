<?php $__env->startSection('title', __('static.languages.add')); ?>
<?php $__env->startSection('content'); ?>
<div class="language-create">
    <form id="languageForm" action="<?php echo e(route('admin.language.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo method_field('POST'); ?>
        <?php echo csrf_field(); ?>
        <?php echo $__env->make('admin.language.fields', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/resources/views/admin/language/create.blade.php ENDPATH**/ ?>