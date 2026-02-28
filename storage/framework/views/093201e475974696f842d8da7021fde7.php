<?php $__env->startSection('title', __('taxido::static.riders.add')); ?>
<?php $__env->startSection('content'); ?>
<div class="user-create">
  <form id="riderForm" action="<?php echo e(route('admin.rider.store')); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo $__env->make('taxido::admin.rider.fields', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/rider/create.blade.php ENDPATH**/ ?>