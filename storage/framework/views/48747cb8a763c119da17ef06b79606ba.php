<?php
    $tags = App\Models\Tag::whereNull('deleted_at')->latest()->get();
?>
<?php if(isset($tags)): ?>
    <li class="control-section accordion-section add-page" id="add-page">
        <h3 class="accordion-section-title hndle" tabindex="0">
            <?php echo e(__('ticket::static.tags.tags')); ?><span
                class="screen-reader-text"><?php echo e(__('ticket::static.tags.press_return_or_enter_to_expand')); ?></span>
        </h3>
        <div class="accordion-section-content ">
            <div class="inside">
                <div id="tabs-panel-posttype-post-most-recent" class="tabs-panel tabs-panel-active menu-item-tab"
                    role="region" aria-label="Most Recent" tabindex="0">
                    <ul class="nav nav-tabs" id="menuItemTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="most-recent-tab" data-bs-toggle="tab"
                                data-bs-target="#most-recent" type="button" role="tab" aria-controls="most-recent"
                                aria-selected="true"><?php echo e(__('Most Recent')); ?></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="view-all-tab" data-bs-toggle="tab" data-bs-target="#view-all"
                                type="button" role="tab" aria-controls="view-all"
                                aria-selected="false"><?php echo e(__('View All')); ?></button>
                        </li>
                    </ul>
                    <div class="tab-content tab-content-scroll" id="menuItemTabContent">
                        <div class="tab-pane fade show active custom-scrollbar" id="most-recent" role="tabpanel"
                            aria-labelledby="most-recent-tab">
                            <ul id="postchecklist-most-recent" class="categorychecklist form-no-clear">
                                <?php $__empty_1 = true; $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <li>
                                        <label class="menu-item-title">
                                            <input data-id="<?php echo e($tag?->id); ?>"
                                                id="custom-menu-item-widget-name-<?php echo e($tag?->id); ?>" type="checkbox"
                                                class="menu-item-checkbox" name="label" value="<?php echo e($tag?->name); ?>">
                                            <?php echo e($tag?->name); ?>

                                        </label>
                                        <input type="hidden" class="custom-menu-item"
                                            id="custom-menu-item-widget-url-<?php echo e($tag?->id); ?>" name="url"
                                            value="<?php echo e($tag?->slug); ?>">
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <li>
                                        <div class="no-data mt-3">
                                            <img src="<?php echo e(url('/images/no-data.png')); ?>" alt="">
                                            <h6 class="mt-2"><?php echo e(__('ticket::static.tags.no_tag_found')); ?></h6>
                                        </div>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="tab-pane fade custom-scrollbar" id="view-all" role="tabpanel"
                            aria-labelledby="view-all-tab">
                            <ul id="view-all-tab" class="categorychecklist form-no-clear">
                                <?php $__empty_1 = true; $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <li>
                                        <label class="menu-item-title">
                                            <input data-id="<?php echo e($tag?->id); ?>"
                                                id="custom-menu-item-widget-name-<?php echo e($tag?->id); ?>" type="checkbox"
                                                class="menu-item-checkbox" name="label" value="<?php echo e($tag?->name); ?>">
                                            <?php echo e($tag?->name); ?>

                                        </label>
                                        <input type="hidden" class="custom-menu-item"
                                            id="custom-menu-item-widget-url-<?php echo e($tag?->id); ?>" name="url"
                                            value="<?php echo e($tag?->slug); ?>">
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <li>
                                        <div class="no-data mt-3">
                                            <img src="<?php echo e(url('/images/no-data.png')); ?>" alt="">
                                            <h6 class="mt-2"><?php echo e(__('ticket::static.tags.no_tag_found')); ?></h6>
                                        </div>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="button-controls">
                        <div class="form-check p-0 float-start">
                            <input type="checkbox" class="form-check-input checkAll" id="select-all" disabled>
                            <label for="select-all" class="m-0"><?php echo e(__('ticket::static.tags.select_all')); ?></label>
                        </div>
                        <a href="javascript:void(0)" onclick="addCustomMenuWidget()"
                            class="button-secondary submit-add-to-menu float-end right">
                            <?php echo e(__('static.tags.add_menu_item')); ?>

                        </a>
                        <span class="spinner" id="spincustomu"></span>
                    </div>
                </div>
            </div>
        </div>
    </li>
<?php endif; ?>
<?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Ticket/resources/views/admin/tag/widget.blade.php ENDPATH**/ ?>