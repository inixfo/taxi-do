<?php $__env->startSection('title', __('taxido::static.withdraw_requests.title')); ?>
<?php $__env->startSection('content'); ?>
<?php if ($__env->exists('inc.modal', ['export' => true, 'routes' => 'admin.withdraw-request.export'])) echo $__env->make('inc.modal', ['export' => true, 'routes' => 'admin.withdraw-request.export'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<div class="row g-4 wallet-main mb-4">
    <?php if(Auth::user()->hasRole('driver')): ?>
        <div class="col-xxl-8 col-xl-7">
            <?php if ($__env->exists('taxido::admin.withdraw-request.amount')) echo $__env->make('taxido::admin.withdraw-request.amount', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
        <div class="col-xxl-4 col-xl-5">
            <?php if ($__env->exists('taxido::admin.withdraw-request.drivers')) echo $__env->make('taxido::admin.withdraw-request.drivers', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    <?php endif; ?>
</div>
<div class="contentbox">
    <div class="inside">
        <div class="contentbox-title justify-unset">
            <h3><?php echo e(__('taxido::static.withdraw_requests.title')); ?></h3>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('withdraw_request.index')): ?>
                <?php if($tableConfig['total'] > 0): ?>
                    <button class="btn btn-outline" data-bs-toggle="modal" data-bs-target="#exportModal">
                        <i class="ri-download-line"></i><?php echo e(__('static.export.export')); ?>

                    </button>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <div class="withdrawRequest-table">
            <?php if (isset($component)) { $__componentOriginal163c8ba6efb795223894d5ffef5034f5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal163c8ba6efb795223894d5ffef5034f5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table.index','data' => ['columns' => $tableConfig['columns'],'data' => $tableConfig['data'],'filters' => $tableConfig['filters'],'total' => '','bulkactions' => $tableConfig['bulkactions'],'viewActionBox' => $tableConfig['viewActionBox'],'search' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableConfig['columns']),'data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableConfig['data']),'filters' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableConfig['filters']),'total' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'bulkactions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableConfig['bulkactions']),'viewActionBox' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableConfig['viewActionBox']),'search' => true]); ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal163c8ba6efb795223894d5ffef5034f5)): ?>
<?php $attributes = $__attributesOriginal163c8ba6efb795223894d5ffef5034f5; ?>
<?php unset($__attributesOriginal163c8ba6efb795223894d5ffef5034f5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal163c8ba6efb795223894d5ffef5034f5)): ?>
<?php $component = $__componentOriginal163c8ba6efb795223894d5ffef5034f5; ?>
<?php unset($__componentOriginal163c8ba6efb795223894d5ffef5034f5); ?>
<?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/withdraw-request/index.blade.php ENDPATH**/ ?>