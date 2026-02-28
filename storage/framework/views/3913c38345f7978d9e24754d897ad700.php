<?php $__env->startSection('title', __('taxido::static.documents.add_document')); ?>
<?php $__env->startSection('content'); ?>
    <div class="document-main">
        <form id="documentForm" action="<?php echo e(route('admin.document.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo $__env->make('taxido::admin.document.fields', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/document/create.blade.php ENDPATH**/ ?>