<?php $__env->startSection('title', __('taxido::static.fleet_managers.edit')); ?>
<?php $__env->startSection('content'); ?>
    <div class="fleet-manager-edit">
        <form id="fleetManagerForm" action="<?php echo e(route('admin.fleet-manager.update', $fleetManager->id)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo method_field('PUT'); ?>
            <?php echo csrf_field(); ?>
            <?php echo $__env->make('taxido::admin.fleet-manager.fields', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/fleet-manager/edit.blade.php ENDPATH**/ ?>