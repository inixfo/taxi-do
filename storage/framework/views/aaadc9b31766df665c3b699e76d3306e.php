<?php $__env->startSection('title', __('ticket::static.department.edit')); ?>
<?php $__env->startSection('content'); ?>
    <div class="department-edit">
        <form id="departmentForm" action="<?php echo e(route('admin.department.update', $department->id)); ?>" method="POST"
            enctype="multipart/form-data">
            <?php echo method_field('PUT'); ?>
            <?php echo csrf_field(); ?>
            <div class="row g-xl-4 g-3">
                <div class="col-12">
                    <?php echo $__env->make('ticket::admin.department.fields', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Ticket/resources/views/admin/department/edit.blade.php ENDPATH**/ ?>