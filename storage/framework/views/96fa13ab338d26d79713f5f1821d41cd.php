<?php $__env->startSection('title', __('ticket::static.department.add')); ?>
<?php $__env->startSection('content'); ?>
    <div class="department-create">
        <form id="departmentForm" action="<?php echo e(route('admin.department.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo method_field('POST'); ?>
            <?php echo csrf_field(); ?>
            <?php echo $__env->make('ticket::admin.department.fields', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Ticket/resources/views/admin/department/create.blade.php ENDPATH**/ ?>