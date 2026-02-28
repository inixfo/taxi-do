<?php $__env->startSection('title', __('taxido::static.notices.add_notice')); ?>
<?php $__env->startSection('content'); ?>
    <div class="notice-main">
        <form id="noticeForm" action="<?php echo e(route('admin.notice.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo $__env->make('taxido::admin.notice.fields', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/notice/create.blade.php ENDPATH**/ ?>