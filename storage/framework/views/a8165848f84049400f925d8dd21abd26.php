<?php use \Modules\Taxido\Models\ServiceCategory; ?>
<?php
    $serviceCategories = ServiceCategory::where('status', true)?->get(['id', 'name']);
?>
<div class="row g-xl-4 g-3">
    <div class="col-xl-10 col-xxl-8 mx-auto">
        <div class="left-part">
            <div class="contentbox">
                <div class="inside">
                    <div class="contentbox-title">
                        <h3><?php echo e(isset($plan) ? __('taxido::static.plans.edit') : __('taxido::static.plans.add')); ?>

                            (<?php echo e(request('locale', app()->getLocale())); ?>)
                        </h3>
                    </div>
                    <?php if(isset($plan)): ?>
                        <div class="form-group row">
                            <label class="col-md-2" for="name"><?php echo e(__('taxido::static.language.languages')); ?></label>
                            <div class="col-md-10">
                                <ul class="language-list">
                                    <?php $__empty_1 = true; $__currentLoopData = getLanguages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.plan.edit', ['plan' => $plan->id, 'locale' => $lang->locale])); ?>"
                                                class="language-switcher <?php echo e(request('locale') === $lang->locale ? 'active' : ''); ?>"
                                                target="_blank"><img
                                                    src="<?php echo e(@$lang?->flag ?? asset('admin/images/No-image-found.jpg')); ?>"
                                                    alt=""> <?php echo e(@$lang?->name); ?> (<?php echo e(@$lang?->locale); ?>)<i
                                                    class="ri-arrow-right-up-line"></i></a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.plan.edit', ['plan' => $plan->id, 'locale' => Session::get('locale', 'en')])); ?>"
                                                class="language-switcher active" target="blank"><img
                                                    src="<?php echo e(asset('admin/images/flags/LR.png')); ?>" alt="">English<i
                                                    class="ri-arrow-right-up-line"></i></a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                    <input type="hidden" name="locale" value="<?php echo e(request('locale')); ?>">
                    <div class="form-group row">
                        <label class="col-md-2"
                            for="name"><?php echo e(__('taxido::static.plans.name')); ?><span>*</span></label>
                        <div class="col-md-10">
                            <div class="position-relative">
                                <input class="form-control" type="text" name="name" id="name"
                                    value="<?php echo e(isset($plan->name) ? $plan->getTranslation('name', request('locale', app()->getLocale())) : old('name')); ?>"
                                    placeholder="<?php echo e(__('taxido::static.plans.enter_name')); ?> (<?php echo e(request('locale', app()->getLocale())); ?>)">
                                <i class="ri-file-copy-line copy-icon" data-target="#name"></i>
                            </div>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div id="description-group">
                        <?php if(!empty(old('description', $plan->description ?? []))): ?>
                            <?php $__currentLoopData = old('description', $plan->description ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $descriptionDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-group row">
                                    <label class="col-md-2" for="description">
                                        <?php echo e(__('taxido::static.plans.description')); ?><span>
                                            *</span>
                                    </label>
                                    <div class="col-md-10">
                                        <div class="description-fields">
                                            <input class="form-control" type="text" name="description[]"
                                                placeholder="<?php echo e(__('taxido::static.plans.enter_description')); ?>"
                                                value="<?php echo e($descriptionDetail); ?>">
                                            <button type="button" class="btn btn-danger remove-description">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="form-group row">
                                <label class="col-md-2" for="description">
                                    <?php echo e(__('taxido::static.plans.description')); ?>

                                </label>
                                <div class="col-md-10">
                                    <div class="description-fields">
                                        <input class="form-control" type="text" name="description[]"
                                            placeholder="<?php echo e(__('taxido::static.plans.enter_description')); ?>">
                                        <button type="button" class="btn remove-description">
                                            <i class="ri-delete-bin-line text-danger"></i>

                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="added-button mb-sm-4 mb-3">
                        <button type="button" id="add-description" class="btn btn-primary mt-0 ms-auto">
                            <?php echo e(__('taxido::static.plans.add_description')); ?>

                        </button>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="duration"><?php echo e(__('taxido::static.plans.duration')); ?> <span
                                class="required-span">*</span></label>
                        <div class="col-md-10 error-div select-dropdown d-flex flex-column-reverse">
                            <select class="select-2 form-control" id="duration" name="duration"
                                data-placeholder="<?php echo e(__('taxido::static.plans.select_duration')); ?>">
                                <option class="select-placeholder" value=""></option>
                                <?php $__currentLoopData = ['daily' => 'Daily', 'weekly' => 'Weekly','monthly' => 'Monthly', 'yearly' => 'Yearly']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option class="option" value="<?php echo e($key); ?>"
                                        <?php if(old('duration', $plan->duration ?? old('duration')) == $key): ?> selected <?php endif; ?>><?php echo e($option); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['duration'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="form-group row amount">
                        <label class="col-md-2" for="price"><?php echo e(__('taxido::static.plans.price')); ?> <span class="required-span">*</span></label>
                        <div class="col-md-10">
                            <input class='form-control' type="number" min="1" name="price" id="price" value="<?php echo e($plan->price ?? old('price')); ?>" placeholder="<?php echo e(__('taxido::static.plans.enter_plan_price')); ?>">
                            <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="form-group row" id="service-category-selection">
                        <label class="col-md-2"
                            for="serviceCategory"><?php echo e(__('taxido::static.plans.select_service_category')); ?></label>
                        <div class="col-md-10">
                            <select class="form-control select-2" name="service_categories[]"
                                data-placeholder="<?php echo e(__('taxido::static.plans.select_service_categories')); ?>"
                                multiple>
                                <?php $__currentLoopData = $serviceCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $serviceCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($serviceCategory->id); ?>"
                                        <?php if(@$plan?->service_categories): ?> <?php if(in_array($serviceCategory->id, $plan->service_categories->pluck('id')->toArray())): ?>
                                                selected <?php endif; ?>
                                    <?php elseif(old('service_categories.' . $index) == $serviceCategory->id): ?> selected <?php endif; ?>>
                                        <?php echo e($serviceCategory->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['service_categories'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="plan"><?php echo e(__('taxido::static.plans.status')); ?></label>
                        <div class="col-md-10">
                            <div class="editor-space">
                                <label class="switch">
                                    <input class="form-control" type="hidden" name="status" value="0">
                                    <input class="form-check-input" type="checkbox" name="status" id=""
                                        value="1" <?php if(@$plan?->status ?? true): echo 'checked'; endif; ?>>
                                    <span class="switch-state"></span>
                                </label>
                            </div>
                            <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <div class="submit-btn">
                                <button type="submit" name="save" class="btn btn-primary spinner-btn">
                                    <i class="ri-save-line text-white lh-1"></i> <?php echo e(__('taxido::static.save')); ?>

                                </button>
                                <button type="submit" name="save_and_exit" class="btn btn-primary spinner-btn">
                                    <i class="ri-expand-left-line text-white lh-1"></i><?php echo e(__('taxido::static.save_and_exit')); ?>

                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
    <script>
        (function($) {
            "use strict";

            // Change Password Form
            $('#planForm').validate({
                rules: {
                    "name": "required",
                    "price": "required",
                    "duration": "required"
                }
            });

            $(document).ready(function() {
                const MAX_DESCRIPTIONS = 5;

                function toggleRemoveButtons() {
                    if ($('#description-group .form-group').length === 1) {
                        $('#description-group .remove-description').hide();
                    } else {
                        $('#description-group .remove-description').show();
                    }
                }

                $('#add-description').on('click', function() {
                    const descriptionCount = $('#description-group .form-group').length;

                    if (descriptionCount >= MAX_DESCRIPTIONS) {

                        toastr.warning("<?php echo e(__('taxido::static.plans.message')); ?>");
                        return;
                    }

                    var newDescriptionField = $('#description-group .form-group:first').clone();
                    newDescriptionField.find('input').val('');
                    $('#description-group').append(newDescriptionField);
                    toggleRemoveButtons();
                });

                $(document).on('click', '.remove-description', function() {
                    $(this).closest('.form-group').remove();
                    toggleRemoveButtons();
                });

                toggleRemoveButtons();
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/plan/fields.blade.php ENDPATH**/ ?>