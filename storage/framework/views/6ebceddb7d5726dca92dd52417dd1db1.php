<?php $__env->startSection('title', __('taxido::static.plans.add')); ?>
<?php $__env->startSection('content'); ?>
    <div class="plan-create">
        <form id="planForm" action="<?php echo e(route('admin.plan.store')); ?>" method="POST" enctype="multipart/form-data">
            <div class="row g-xl-4 g-3">
                <div class="col-12">
                    <?php echo method_field('POST'); ?>
                    <?php echo csrf_field(); ?>
                    <?php echo $__env->make('taxido::admin.plan.fields', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/plan/create.blade.php ENDPATH**/ ?>