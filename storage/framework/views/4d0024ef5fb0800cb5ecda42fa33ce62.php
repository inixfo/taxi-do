<?php $__env->startSection('title', __('static.pages.pages')); ?>
<?php $__env->startSection('content'); ?>
    <?php if ($__env->exists('inc.modal', [
        'export' => true,
        'routes' => 'admin.page.export',
        'import' => true,
        'route' => 'admin.page.import.csv',
        'instruction_file' => 'admin/import/pages',
        'example_file' => 'admin/import/example/pages.csv',
    ])) echo $__env->make('inc.modal', [
        'export' => true,
        'routes' => 'admin.page.export',
        'import' => true,
        'route' => 'admin.page.import.csv',
        'instruction_file' => 'admin/import/pages',
        'example_file' => 'admin/import/example/pages.csv',
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="contentbox">
        <div class="inside">
            <div class="contentbox-title">
                <div class="contentbox-subtitle">
                    <h3><?php echo e(__('static.pages.pages')); ?></h3>
                    <div class="subtitle-button-group">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('page.create')): ?>
                            <button class="add-spinner btn btn-outline" data-url="<?php echo e(route('admin.page.create')); ?>">
                                <i class="ri-add-line"></i> <?php echo e(__('static.pages.add_new')); ?>

                            </button>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('page.index')): ?>
                        <?php if($tableConfig['total'] > 0): ?>
                            <button class="btn btn-outline" data-bs-toggle="modal" data-bs-target="#exportModal">
                                <i class="ri-download-line"></i> <?php echo e(__('static.export.export')); ?>

                            </button>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('page.create')): ?>
                            <button class="btn btn-outline" data-bs-toggle="modal" data-bs-target="#importModal"
                                id="importButton" data-model="page">
                                <i class="ri-upload-line"></i> <?php echo e(__('static.import.import')); ?>

                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="page-table">
                <?php if (isset($component)) { $__componentOriginal163c8ba6efb795223894d5ffef5034f5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal163c8ba6efb795223894d5ffef5034f5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table.index','data' => ['columns' => $tableConfig['columns'],'data' => $tableConfig['data'],'filters' => $tableConfig['filters'],'actions' => $tableConfig['actions'],'total' => $tableConfig['total'],'bulkactions' => $tableConfig['bulkactions'],'search' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableConfig['columns']),'data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableConfig['data']),'filters' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableConfig['filters']),'actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableConfig['actions']),'total' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableConfig['total']),'bulkactions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableConfig['bulkactions']),'search' => true]); ?>
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

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/resources/views/admin/page/index.blade.php ENDPATH**/ ?>