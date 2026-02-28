<?php $__env->startSection('title', __('ticket::static.report.reports')); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xl-3">
            <div class="p-sticky">
                <div class="contentbox">
                    <div class="inside">
                        <div class="customer-detail">
                            <div class="profile">
                                <?php
                                    $imageUrl = getMedia($executive?->Profile_image_id)?->original_url;
                                ?>
                                <div class="profile-img">
                                    <?php if($imageUrl): ?>
                                        <img src="<?php echo e($imageUrl); ?>" alt="">
                                    <?php else: ?>
                                        <div class="initial-letter">
                                            <span><?php echo e(strtoupper($executive?->name[0])); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="mt-2">
                                    <h4><?php echo e($executive?->name); ?></h4>
                                    <div class="rate-box">
                                        <i class="ri-star-fill"></i>
                                        <?php echo e($executive?->ratings?->avg('rating') ? number_format($executive->ratings->avg('rating'), 1) : 'Unrated'); ?>

                                    </div>
                                    <p><?php echo e(ucfirst($executive?->role->name)); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="contentbox">
                    <div class="inside">
                        <div class="contentbox-title">
                            <h3><?php echo e(__('ticket::static.report.user_detail')); ?></h3>
                        </div>
                        <div class="customer-detail">
                            <div class="detail-card">
                                <ul class="detail-list">
                                    <li class="detail-item">
                                        <h5><?php echo e(__('ticket::static.report.name')); ?></h5>
                                        <span><?php echo e($executive?->name); ?></span>
                                    </li>
                                    <li class="detail-item">
                                        <h5><?php echo e(__('ticket::static.report.role')); ?></h5>
                                        <span class="badge badge-primary"><?php echo e(ucfirst($executive?->role?->name)); ?></span>
                                    </li>
                                    <li class="detail-item">
                                        <h5><?php echo e(__('ticket::static.report.email')); ?></h5>
                                        <span><?php echo e($executive?->email); ?></span>
                                    </li>
                                    <li class="detail-item">
                                        <h5><?php echo e(__('ticket::static.report.phone')); ?></h5>
                                        <span>
                                            <?php if($executive?->phone): ?>
                                                + (<?php echo e($executive?->country_code); ?>) <?php echo e($executive?->phone); ?>

                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9">
            <div class="contentbox">
                <div class="inside">
                    <div class="contentbox-title">
                        <div class="contentbox-subtitle">
                            <h3><?php echo e(__('ticket::static.report.reports')); ?></h3>
                        </div>
                    </div>
                    <div class="report-table">
                        <?php if (isset($component)) { $__componentOriginal163c8ba6efb795223894d5ffef5034f5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal163c8ba6efb795223894d5ffef5034f5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table.index','data' => ['columns' => $tableConfig['columns'],'data' => $tableConfig['data'],'filters' => $tableConfig['filters'],'actions' => $tableConfig['actions'],'total' => $tableConfig['total'],'actionButtons' => $tableConfig['actionButtons'],'bulkactions' => $tableConfig['bulkactions'],'search' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableConfig['columns']),'data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableConfig['data']),'filters' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableConfig['filters']),'actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableConfig['actions']),'total' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableConfig['total']),'actionButtons' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableConfig['actionButtons']),'bulkactions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableConfig['bulkactions']),'search' => true]); ?>
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
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Ticket/resources/views/admin/report/edit.blade.php ENDPATH**/ ?>