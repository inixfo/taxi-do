<?php $__env->startSection('title', __('ticket::static.executive.add_support_executive')); ?>
<?php $__env->startSection('content'); ?>
<div class="user-create">
  <form id="executiveForm" action="<?php echo e(route('admin.executive.store')); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo $__env->make('ticket::admin.executive.fields', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Ticket/resources/views/admin/executive/create.blade.php ENDPATH**/ ?>