<?php use \Modules\Taxido\Models\Zone; ?>
<?php use \Modules\Taxido\Models\Rider; ?>
<?php use \Modules\Taxido\Models\Service; ?>
<?php use \Modules\Taxido\Models\VehicleType; ?>
<?php use \Modules\Taxido\Models\ServiceCategory; ?>
<?php
    $zones = Zone::where('status', true)?->get(['id', 'name']);
    $riders = Rider::where('status', true)?->get(['id', 'name']);
    $services = Service::where('status', true)?->get(['id', 'name']);
    $vehicleTypes = VehicleType::where('status', true)?->get(['id', 'name']);
    $serviceCategories = ServiceCategory::where('status', true)?->get(['id', 'name']);
?>
<div class="row g-xl-4 g-3">
    <div class="col-xl-10 col-xxl-8 mx-auto">
        <div class="left-part">
            <div class="contentbox">
                <div class="inside">

                    <div class="contentbox-title">
                        <h3><?php echo e(isset($coupon) ? __('taxido::static.coupons.edit_coupon') : __('taxido::static.coupons.add_coupon')); ?>

                            (<?php echo e(request('locale', app()->getLocale())); ?>)
                        </h3>
                    </div>

                    <ul class="nav nav-tabs horizontal-tab custom-scroll" id="couponTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="general-tab" data-bs-toggle="tab" href="#general"
                                type="button" role="tab" aria-controls="general" aria-selected="true">
                                <i class="ri-settings-line"></i>
                                <?php echo e(__('taxido::static.coupons.general')); ?>

                                <i class="ri-error-warning-line danger errorIcon"></i>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="restriction-tab" data-bs-toggle="tab" href="#restriction"
                                type="button" role="tab" aria-controls="restriction" aria-selected="true">
                                <i class="ri-spam-2-line"></i>
                                <?php echo e(__('taxido::static.coupons.restriction')); ?>

                                <i class="ri-error-warning-line danger errorIcon"></i>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="usage-tab" data-bs-toggle="tab" href="#usage" role="tab"
                                type="button" aria-controls="usage" aria-selected="true">
                                <i class="ri-pie-chart-line"></i>
                                <?php echo e(__('taxido::static.coupons.usage')); ?>

                                <i class="ri-error-warning-line danger errorIcon"></i>
                            </a>
                        </li>
                    </ul>
                    <?php if(isset($coupon)): ?>
                        <div class="form-group row">
                            <label class="col-md-2" for="name"><?php echo e(__('taxido::static.language.languages')); ?></label>
                            <div class="col-md-10">
                                <ul class="language-list">
                                    <?php $__empty_1 = true; $__currentLoopData = getLanguages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.coupon.edit', ['coupon' => $coupon->id, 'locale' => $lang->locale])); ?>"
                                            class="language-switcher <?php echo e(request('locale') === $lang->locale ? 'active' : ''); ?>"
                                            target="_blank"><img
                                            src="<?php echo e(@$lang?->flag ?? asset('admin/images/No-image-found.jpg')); ?>"
                                            alt=""> <?php echo e(@$lang?->name); ?> (<?php echo e(@$lang?->locale); ?>)<i
                                            class="ri-arrow-right-up-line"></i></a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.coupon.edit', ['coupon' => $coupon->id, 'locale' => Session::get('locale', 'en')])); ?>"
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
                    <div class="tab-content" id="couponTabContent">
                        <div class="tab-pane fade <?php echo e(session('active_tab') != null ? '' : 'show active'); ?>"
                            id="general" role="tabpanel" aria-labelledby="general-tab">

                            <div class="form-group row">
                                <label class="col-md-2" for="title"><?php echo e(__('taxido::static.coupons.title')); ?><span>
                                        *</span></label>
                                <div class="col-md-10">
                                    <div class="position-relative">
                                        <input class="form-control" type="text" name="title" id="title" required
                                            value="<?php echo e(isset($coupon->title) ? $coupon->getTranslation('title', request('locale', app()->getLocale())) : old('title')); ?>"
                                            placeholder="<?php echo e(__('taxido::static.coupons.enter_title')); ?> (<?php echo e(request('locale', app()->getLocale())); ?>)"><i
                                            class="ri-file-copy-line copy-icon" data-target="#title"></i>
                                    </div>
                                    <?php $__errorArgs = ['title'];
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
                                <label class="col-md-2"
                                    for="description"><?php echo e(__('taxido::static.coupons.description')); ?></label>
                                <div class="col-md-10">
                                    <div class="position-relative">
                                        <textarea class="form-control" rows="2" id="description" name="description"
                                            placeholder="<?php echo e(__('taxido::static.coupons.enter_description')); ?> (<?php echo e(request('locale', app()->getLocale())); ?>)"
                                            cols="80"><?php echo e(isset($coupon->description) ? $coupon->getTranslation('description', request('locale', app()->getLocale())) : old('description')); ?></textarea><i class="ri-file-copy-line copy-icon"
                                            data-target="#description"></i>
                                    </div>
                                    <?php $__errorArgs = ['description'];
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
                                <label class="col-md-2" for="code"><?php echo e(__('taxido::static.coupons.code')); ?><span>
                                        *</span></label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="code" required
                                        value="<?php echo e(isset($coupon->code) ? $coupon->code : old('code')); ?>"
                                        placeholder="<?php echo e(__('taxido::static.coupons.enter_code')); ?>">
                                    <?php $__errorArgs = ['code'];
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
                                <label class="col-md-2" for="type"><?php echo e(__('taxido::static.coupons.type')); ?><span>
                                        *</span></label>
                                <div class="col-md-10 select-label-error">
                                    <select class="select-2 form-control" id="type" name="type" required
                                        data-placeholder="<?php echo e(__('taxido::static.coupons.select_type')); ?>">
                                        <option class="select-placeholder" value=""></option>
                                        <?php $__currentLoopData = ['fixed' => 'Fixed', 'percentage' => 'Percentage']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option class="option" value="<?php echo e($key); ?>"
                                                <?php if(old('type', $coupon->type ?? '') == $key): ?> selected <?php endif; ?>><?php echo e($option); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="form-group row amount-input" id="amountField"
                                style="<?php echo e(($coupon->type ?? 'percentage') == 'percentage' ? '' : 'display:none;'); ?>">
                                <label class="col-md-2"
                                    for="amount"><?php echo e(__('taxido::static.coupons.amount')); ?><span> *</span></label>
                                <div class="col-md-10 select-label-error amount">
                                    <div class="input-group">
                                        <span class="input-group-text currency" id="currencyIcon"
                                            style="display: none"><?php echo e(getDefaultCurrency()?->symbol); ?></span>
                                        <input class="form-control" type="number" name="amount"
                                            value="<?php echo e(isset($coupon->amount) ? $coupon->amount : old('amount')); ?>"
                                            placeholder="<?php echo e(__('taxido::static.coupons.enter_amount')); ?>" required>
                                        <span class="input-group-text percent" id="percentageIcon" style="display: none;"><i
                                                class="ri-percent-line"></i></span>
                                    </div>
                                    <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2" for="is_expired"><?php echo e(__('taxido::static.coupons.is_expired')); ?></label>
                                <div class="col-md-10">
                                    <div class="editor-space">
                                        <label class="switch">
                                            <?php if(isset($coupon)): ?>
                                                <input class="form-control" type="hidden" name="is_expired" value="0">
                                                <input class="form-check-input" id="is_expired" type="checkbox" name="is_expired" value="1"
                                                    <?php echo e($coupon->is_expired ? 'checked' : ''); ?>>
                                            <?php else: ?>
                                                <input class="form-control" type="hidden" name="is_expired" value="0">
                                                <input class="form-check-input" id="is_expired" type="checkbox" name="is_expired" value="1">
                                            <?php endif; ?>
                                            <span class="switch-state"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row flatpicker-calender select-date" style="display: none">
                                <label class="col-md-2" for="start_end_date"><?php echo e(__('Select Date')); ?> <span class="required-span">*</span></label>
                                <div class="col-md-10">
                                    <?php if(isset($coupon) && $coupon->start_date && $coupon->end_date): ?>
                                        <input class="form-control" id="date-range" 
                                            value="<?php echo e(\Carbon\Carbon::parse($coupon->start_date)->format('m/d/Y')); ?> to <?php echo e(\Carbon\Carbon::parse($coupon->end_date)->format('m/d/Y')); ?>"
                                            name="start_end_date" placeholder="Select Date.." required>
                                    <?php else: ?>
                                        <input class="form-control" id="date-range" name="start_end_date" placeholder="Select Date.." required>
                                    <?php endif; ?>
                                    <?php $__errorArgs = ['start_end_date'];
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
                                <label class="col-md-2"
                                    for="status"><?php echo e(__('taxido::static.coupons.status')); ?></label>
                                <div class="col-md-10 error-div">

                                    <div class="editor-space">
                                        <label class="switch">
                                            <input class="form-control" type="hidden" name="status"
                                                value="0">
                                            <input class="form-check-input" type="checkbox" name="status"
                                                id="" value="1" <?php if(@$coupon?->status ?? true): echo 'checked'; endif; ?>>
                                            <span class="switch-state"></span>
                                        </label>
                                    </div>
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
                            <div class="footer">
                                <button type="button"
                                    class="nextBtn btn btn-primary"><?php echo e(__('static.next')); ?></button>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="restriction" role="tabpanel"
                            aria-labelledby="restriction-tab">
                            <div class="form-group row amount-input">
                                <label class="col-md-2"
                                    for="min_ride_fare"><?php echo e(__('taxido::static.coupons.minimum_ride_fare')); ?><span>
                                        *</span></label>
                                <div class="col-md-10 error-div">
                                    <div class="input-group mb-3 flex-nowrap">
                                        <span class="input-group-text"><?php echo e(getDefaultCurrency()?->symbol); ?></span>
                                        <div class="w-100">
                                            <input class="form-control" type="number" name="min_ride_fare"
                                                value="<?php echo e(isset($coupon->min_ride_fare) ? $coupon->min_ride_fare : old('min_ride_fare')); ?>"
                                                placeholder="<?php echo e(__('taxido::static.coupons.enter_minimum_ride_fare')); ?>"
                                                required>
                                            <?php $__errorArgs = ['min_ride_fare'];
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
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2" for="role"><?php echo e(__('taxido::static.coupons.is_apply_all')); ?></label>
                                <div class="col-md-10">
                                    <div class="editor-space">
                                        <label class="switch">
                                            <?php if(isset($coupon)): ?>
                                                <input class="form-control" type="hidden" name="is_apply_all" value="0">
                                                <input class="form-check-input" id="is_apply_all" type="checkbox" name="is_apply_all" value="1" <?php echo e($coupon->is_apply_all ? 'checked' : ''); ?>>
                                            <?php else: ?>
                                                <input class="form-control" type="hidden" name="is_apply_all" value="0">
                                                <input class="form-check-input" id="is_apply_all" type="checkbox" name="is_apply_all" value="1">
                                            <?php endif; ?>
                                            <span class="switch-state"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group row" id="service-selection">
                                <label class="col-md-2" for="services"><?php echo e(__('taxido::static.coupons.services')); ?><span> *</span></label>
                                <div class="col-md-10 select-label-error">
                                    <select class="form-control select-2" id="service_id" name="services[]" data-placeholder="<?php echo e(__('taxido::static.coupons.select_services')); ?>" multiple>
                                        <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($service->id); ?>"
                                                <?php if(isset($coupon) && !$coupon->is_apply_all && $coupon->services->contains($service->id)): ?> selected
                                                <?php elseif(old('services.' . $index) == $service->id): ?> selected <?php endif; ?>>
                                                <?php echo e($service->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['services'];
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
                            
                            <div class="form-group row" id="vehicle-type-selection">
                                <label class="col-md-2" for="vehicle_type"><?php echo e(__('taxido::static.coupons.select_vehicle_type')); ?></label>
                                <div class="col-md-10 select-label-error">
                                    <select class="form-control select-2" name="vehicle_types[]" data-placeholder="<?php echo e(__('taxido::static.coupons.select_vehicle_type')); ?>" multiple>
                                        <?php $__currentLoopData = $vehicleTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $vehicleType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($vehicleType->id); ?>"
                                                <?php if(isset($coupon) && !$coupon->is_apply_all && $coupon->vehicle_types->contains($vehicleType->id)): ?> selected
                                                <?php elseif(old('vehicle_types.' . $index) == $vehicleType->id): ?> selected <?php endif; ?>>
                                                <?php echo e($vehicleType->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['vehicle_types'];
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
                            <div class="footer">
                                <button type="button"
                                            class="previousBtn bg-light-primary btn cancel"><?php echo e(__('static.previous')); ?></button>
                                <button type="button"
                                    class="nextBtn btn btn-primary"><?php echo e(__('static.next')); ?></button>
                            </div>
                        </div>

                        <div class="tab-pane fade <?php echo e(session('active_tab') == 'usage-tab' ? 'show active' : ''); ?>"
                            id="usage" role="tabpanel" aria-labelledby="usage-tab">

                            <div class="form-group row">
                                <label class="col-md-2" for="role"><?php echo e(__('taxido::static.coupons.is_unlimited')); ?></label>
                                <div class="col-md-10">
                                    <div class="editor-space">
                                        <label class="switch">
                                            <?php if(isset($coupon)): ?>
                                                <input class="form-control" type="hidden" name="is_unlimited" value="0">
                                                <input class="form-check-input" id="is_unlimited" type="checkbox" name="is_unlimited" value="1" <?php echo e($coupon->is_unlimited ? 'checked' : ''); ?>>
                                            <?php else: ?>
                                                <input class="form-control" type="hidden" name="is_unlimited" value="0">
                                                <input class="form-check-input" id="is_unlimited" type="checkbox" name="is_unlimited" value="1">
                                            <?php endif; ?>
                                            <span class="switch-state"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row" id="usage_per_coupon">
                                <label class="col-md-2" for="usage_per_coupon"><?php echo e(__('taxido::static.coupons.usage_per_coupon')); ?><span> *</span></label>
                                <div class="col-md-10">
                                    <input class='form-control' type="number" name="usage_per_coupon" value="<?php echo e(isset($coupon->usage_per_coupon) ? $coupon->usage_per_coupon : old('usage_per_coupon')); ?>" placeholder="<?php echo e(__('taxido::static.coupons.enter_value')); ?>" id="usage_per_coupon_input" <?php if(!isset($coupon) || !$coupon->is_unlimited): ?> required <?php endif; ?>>
                                    <?php $__errorArgs = ['usage_per_coupon'];
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
                            
                            <div class="form-group row" id="usage_per_rider">
                                <label class="col-md-2" for="usage_per_rider"><?php echo e(__('taxido::static.coupons.usage_per_rider')); ?><span> *</span></label>
                                <div class="col-md-10">
                                    <input class='form-control' type="number" name="usage_per_rider" value="<?php echo e(isset($coupon->usage_per_rider) ? $coupon->usage_per_rider : old('usage_per_rider')); ?>" placeholder="<?php echo e(__('taxido::static.coupons.enter_value')); ?>" id="usage_per_rider_input" <?php if(!isset($coupon) || !$coupon->is_unlimited): ?> required <?php endif; ?>>
                                    <?php $__errorArgs = ['usage_per_rider'];
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
                                        <button type="button"
                                            class="previousBtn bg-light-primary btn cancel"><?php echo e(__('static.previous')); ?></button>
                                        <button type="submit" name="save"
                                            class="btn btn-solid spinner-btn submitBtn">
                                            <i class="ri-save-line text-white lh-1"></i><?php echo e(__('taxido::static.save')); ?>

                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/vendors/flatpickr.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('js/flatpickr/flatpickr.js')); ?>"></script>
    <script src="<?php echo e(asset('js/flatpickr/rangePlugin.js')); ?>"></script>

    <script>
        (function($) {
            "use strict";

            $(document).ready(function() {
                function toggleDateFields() {
                    if ($("#is_expired").is(":checked")) {
                        $(".select-date").show();
                    } else {
                        $(".select-date").hide();
                    }
                }

                $("#is_expired").change(toggleDateFields);
                toggleDateFields();

                flatpickr("#date-range", {
                    mode: "range",
                    dateFormat: "m/d/Y",
                    allowInput: true,
                    placeholder: "Select Date Range",
                    onReady: function(selectedDates, dateStr, instance) {
                        instance._input.setAttribute('data-input', '');
                    },
                    onChange: function(selectedDates, dateStr, instance) {
                        if (selectedDates.length === 2) {
                            const formattedDates = [
                                instance.formatDate(selectedDates[0], "m/d/Y"),
                                instance.formatDate(selectedDates[1], "m/d/Y")
                            ];
                            $("#date-range").val(formattedDates.join(' to '));
                        }
                    }
                });

                <?php if(isset($coupon) && $coupon->start_date && $coupon->end_date): ?>
                    var startDate = moment("<?php echo e($coupon->start_date); ?>").format('MM/DD/YYYY');
                    var endDate = moment("<?php echo e($coupon->end_date); ?>").format('MM/DD/YYYY');
                    $("#date-range").val(startDate + ' to ' + endDate);
                <?php endif; ?>

                $("#couponForm").on('submit', function(e) {
                    if ($("#is_expired").is(":checked")) {
                        const dateRange = $("#date-range").val();
                        if (!dateRange || !dateRange.includes(' to ')) {
                            e.preventDefault();
                            alert('Please select a valid date range');
                            return false;
                        }

                        const dates = dateRange.split(' to ');
                        if (dates.length !== 2 || !dates[0].trim() || !dates[1].trim()) {
                            e.preventDefault();
                            alert('Please select a valid date range');
                            return false;
                        }
                    }
                    return true;
                });

                function toggleApplyFields() {
                    const isApplyAll = $('#is_apply_all').is(":checked");
                    if (isApplyAll) {
                        $('#vehicle-type-selection, #service-selection').hide();
                        $('select[name="services[]"]').val(null).trigger('change');
                        $('select[name="vehicle_types[]"]').val(null).trigger('change');
                    } else {
                        $('#vehicle-type-selection, #service-selection').show();
                    }
                }

                $('#is_apply_all').change(toggleApplyFields);
                toggleApplyFields();

                function toggleInputFields(type) {
                    if (type === 'fixed') {
                        $('#currencyIcon').show();
                        $('#percentageIcon').hide();
                        $('#amountField').show();
                    } else if (type === 'percentage') { 
                        $('#currencyIcon').hide();
                        $('#percentageIcon').show();
                        $('#amountField').show();
                    } else {
                        $('#amountField').hide();
                    }
                }

                toggleInputFields($('#type').val());
                $('#type').on('change', function() {
                    toggleInputFields($(this).val());
                });

                function toggleUsageFields() {
                    if ($("#is_unlimited").is(":checked")) {
                        $('#usage_per_coupon, #usage_per_rider').hide();
                        $('#usage_per_coupon_input, #usage_per_rider_input').removeAttr('required');
                    } else {
                        $('#usage_per_coupon, #usage_per_rider').show();
                        $('#usage_per_coupon_input, #usage_per_rider_input').attr('required', true);
                    }
                }

                toggleUsageFields();
                $('#is_unlimited').change(toggleUsageFields);
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/coupon/fields.blade.php ENDPATH**/ ?>