<?php $__env->startSection('title', __('ticket::static.executive.edit')); ?>
<?php $__env->startSection('content'); ?>
<div class="user-edit">
  <form id="executiveForm" action="<?php echo e(route('admin.executive.update', $executive->id)); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <?php echo $__env->make('ticket::admin.executive.fields', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Ticket/resources/views/admin/executive/edit.blade.php ENDPATH**/ ?>