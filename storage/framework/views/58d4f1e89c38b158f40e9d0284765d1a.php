<div class="row g-xl-4 g-3">
    <div class="col-xl-10 col-xxl-8 mx-auto">
        <div class="left-part">
            <div class="contentbox">
                <div class="inside">
                    <div class="contentbox-title">
                        <h3><?php echo e(isset($fleetManager) ? __('taxido::static.fleet_managers.edit') : __('taxido::static.fleet_managers.add')); ?>

                        </h3>
                    </div>
                    <ul class="nav nav-tabs horizontal-tab custom-scroll" id="account" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#profile"
                                type="button" role="tab" aria-controls="profile" aria-selected="true">
                                <i class="ri-shield-user-line"></i>
                                <?php echo e(__('taxido::static.fleet_managers.general')); ?>

                                <i class="ri-error-warning-line danger errorIcon"></i>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="address-tab" data-bs-toggle="tab" href="#address" type="button"
                                role="tab" aria-controls="address" aria-selected="true">
                                <i class="ri-rotate-lock-line"></i>
                                <?php echo e(__('taxido::static.fleet_managers.address_details')); ?>

                                <i class="ri-error-warning-line danger errorIcon"></i>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="payout-tab" data-bs-toggle="tab" href="#payout" type="button"
                                role="tab" aria-controls="payout" aria-selected="true">
                                <i class="ri-rotate-lock-line"></i>
                                <?php echo e(__('taxido::static.fleet_managers.payout_details')); ?>

                                <i class="ri-error-warning-line danger errorIcon"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="accountContent">
                        <div class="tab-pane fade  <?php echo e(session('active_tab') != null ? '' : 'show active'); ?>"
                            id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="form-group row">
                                <label class="col-md-2"
                                    for="profile_image_id"><?php echo e(__('taxido::static.fleet_managers.profile_image')); ?><span>
                                        *</span></label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <?php if (isset($component)) { $__componentOriginal22d447e3f5aafc93b8447b54b36ee789 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal22d447e3f5aafc93b8447b54b36ee789 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.image','data' => ['text' => __('static.svg_not_supported'),'unallowedTypes' => ['svg'],'name' => 'profile_image_id','data' => isset($fleetManager->profile_image)
                                            ? $fleetManager?->profile_image
                                            : old('profile_image_id'),'multiple' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('image'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['text' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('static.svg_not_supported')),'unallowed_types' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['svg']),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('profile_image_id'),'data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($fleetManager->profile_image)
                                            ? $fleetManager?->profile_image
                                            : old('profile_image_id')),'multiple' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal22d447e3f5aafc93b8447b54b36ee789)): ?>
<?php $attributes = $__attributesOriginal22d447e3f5aafc93b8447b54b36ee789; ?>
<?php unset($__attributesOriginal22d447e3f5aafc93b8447b54b36ee789); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal22d447e3f5aafc93b8447b54b36ee789)): ?>
<?php $component = $__componentOriginal22d447e3f5aafc93b8447b54b36ee789; ?>
<?php unset($__componentOriginal22d447e3f5aafc93b8447b54b36ee789); ?>
<?php endif; ?>
                                        <?php $__errorArgs = ['profile_image_id'];
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
                            <div class="form-group row">
                                <label class="col-md-2"
                                    for="name"><?php echo e(__('taxido::static.fleet_managers.full_name')); ?><span>
                                        *</span></label>
                                <div class="col-md-10">
                                    <input class="form-control"
                                        value="<?php echo e(isset($fleetManager->name) ? $fleetManager->name : old('name')); ?>"
                                        type="text" name="name"
                                        placeholder="<?php echo e(__('taxido::static.fleet_managers.enter_full_name')); ?>">
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
                            <div class="form-group row">
                                <label class="col-md-2" for="email"><?php echo e(__('taxido::static.fleet_managers.email')); ?><span> *</span></label>
                                <div class="col-md-10">
                                    <?php if(isset($fleetManager) && isDemoModeEnabled()): ?>
                                        <input class="form-control" value="<?php echo e(__('static.demo_mode')); ?>" type="text" readonly>
                                    <?php else: ?>
                                        <input class="form-control"
                                            value="<?php echo e(isset($fleetManager->email) ? $fleetManager->email : old('email')); ?>"
                                            type="email" name="email"
                                            placeholder="<?php echo e(__('taxido::static.fleet_managers.enter_email')); ?>" required>
                                    <?php endif; ?>
                                    <?php $__errorArgs = ['email'];
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
                                <label class="col-md-2" for="phone"><?php echo e(__('taxido::static.fleet_managers.phone')); ?><span> *</span></label>
                                <div class="col-md-10">
                                    <?php if(isset($fleetManager) && isDemoModeEnabled()): ?>
                                        <input class="form-control" value="<?php echo e(__('static.demo_mode')); ?>" type="text" readonly>
                                    <?php else: ?>
                                        <div class="input-group mb-3 phone-detail">
                                            <div class="col-sm-1">
                                                <select class="select-2 form-control" id="select-country-code" name="country_code">
                                                    <?php $__currentLoopData = getCountryCodes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option class="option" value="<?php echo e($option->calling_code); ?>"
                                                            data-image="<?php echo e(asset('images/flags/' . $option->flag)); ?>"
                                                            <?php if($option->calling_code == old('country_code', $fleetManager->country_code ?? '1')): echo 'selected'; endif; ?>>
                                                            <?php echo e($option->calling_code); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-11">
                                                <input class="form-control" type="number" name="phone"
                                                    value="<?php echo e(old('phone', $fleetManager->phone ?? '')); ?>"
                                                    placeholder="<?php echo e(__('taxido::static.fleet_managers.enter_phone')); ?>" required>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php $__errorArgs = ['phone'];
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

                            <?php if(request()->routeIs('admin.fleet-manager.create')): ?>
                                <div class="form-group row">
                                    <label class="col-md-2"
                                        for="password"><?php echo e(__('taxido::static.fleet_managers.new_password')); ?><span>
                                            *</span></label>
                                    <div class="col-md-10">
                                        <div class="position-relative">
                                            <input class="form-control" type="password" id="password" name="password"
                                                placeholder="<?php echo e(__('taxido::static.fleet_managers.enter_password')); ?>">
                                            <i class="ri-eye-line toggle-password"></i>
                                        </div>
                                        <?php $__errorArgs = ['password'];
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
                                        for="confirm_password"><?php echo e(__('taxido::static.fleet_managers.confirm_password')); ?><span>
                                            *</span></label>
                                    <div class="col-md-10">
                                        <div class="position-relative">
                                            <input class="form-control" type="password" name="confirm_password"
                                                placeholder="<?php echo e(__('taxido::static.fleet_managers.enter_confirm_password')); ?>"
                                                required>
                                            <i class="ri-eye-line toggle-password"></i>
                                        </div>
                                        <?php $__errorArgs = ['confirm_password'];
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
                                    <label class="col-md-2 mb-0"
                                        for="notify"><?php echo e(__('taxido::static.fleet_managers.notification')); ?></label>
                                    <div class="col-md-10">
                                        <div class="form-check p-0 w-auto">
                                            <input type="checkbox" name="notify" id="notify" value="1"
                                                class="form-check-input me-2">
                                            <label
                                                for="notify"><?php echo e(__('taxido::static.fleet_managers.sentence')); ?></label>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="form-group row">
                                <label class="col-md-2" for="role"><?php echo e(__('taxido::static.status')); ?></label>
                                <div class="col-md-10">
                                    <div class="editor-space">
                                        <label class="switch">
                                            <input class="form-control" type="hidden" name="status"
                                                value="0">
                                            <input class="form-check-input" type="checkbox" name="status"
                                                id="" value="1" <?php if(@$fleetManager?->status ?? true): echo 'checked'; endif; ?>>
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
                            <div class="footer">
                                <button type="button"
                                    class="nextBtn btn btn-primary"><?php echo e(__('static.next')); ?></button>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">

                            <div class="form-group row">
                                <label class="col-md-2"
                                    for="company_name"><?php echo e(__('taxido::static.fleet_managers.company_name')); ?><span>*</span></label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="address[company_name]"
                                        placeholder="<?php echo e(__('taxido::static.fleet_managers.enter_company_name')); ?>"
                                        value="<?php echo e(old('address.company_name', $fleetManager->address->company_name ?? '')); ?>">
                                    <?php $__errorArgs = ['address.company_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback d-block"><strong><?php echo e($message); ?></strong></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2"
                                    for="company_email"><?php echo e(__('taxido::static.fleet_managers.company_email')); ?><span>*</span></label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="address[company_email]"
                                        placeholder="<?php echo e(__('taxido::static.fleet_managers.enter_company_email')); ?>"
                                        value="<?php echo e(old('address.company_email', $fleetManager->address->company_email ?? '')); ?>">
                                    <?php $__errorArgs = ['address.company_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback d-block"><strong><?php echo e($message); ?></strong></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2"
                                    for="company_address"><?php echo e(__('taxido::static.fleet_managers.company_address')); ?><span>*</span></label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="address[company_address]"
                                        placeholder="<?php echo e(__('taxido::static.fleet_managers.enter_company_address')); ?>"
                                        value="<?php echo e(old('address.company_address', $fleetManager->address->company_address ?? '')); ?>">
                                    <?php $__errorArgs = ['address.company_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback d-block"><strong><?php echo e($message); ?></strong></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2"
                                    for="city"><?php echo e(__('taxido::static.fleet_managers.city')); ?><span>*</span></label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="address[city]"
                                        placeholder="<?php echo e(__('taxido::static.fleet_managers.enter_city')); ?>"
                                        value="<?php echo e(old('address.city', $fleetManager->address->city ?? '')); ?>">
                                    <?php $__errorArgs = ['address.city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback d-block"><strong><?php echo e($message); ?></strong></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2"
                                    for="postal_code"><?php echo e(__('taxido::static.fleet_managers.postal_code')); ?><span>*</span></label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="address[postal_code]"
                                        placeholder="<?php echo e(__('taxido::static.fleet_managers.enter_postal_code')); ?>"
                                        value="<?php echo e(old('address.postal_code', $fleetManager->address->postal_code ?? '')); ?>">
                                    <?php $__errorArgs = ['address.postal_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback d-block"><strong><?php echo e($message); ?></strong></span>
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
                        <div class="tab-pane fade" id="payout" role="tabpanel" aria-labelledby="payout-tab">
                            <div class="form-group row">
                                <label class="col-md-2"
                                    for="bank_account_no"><?php echo e(__('taxido::static.fleet_managers.bank_account_no')); ?><span>*</span></label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text"
                                        name="payment_account[bank_account_no]"
                                        placeholder="<?php echo e(__('taxido::static.fleet_managers.enter_bank_account')); ?>"
                                        value="<?php echo e(old('payment_account.bank_account_no', $fleetManager->payment_account->bank_account_no ?? '')); ?>">
                                    <?php $__errorArgs = ['payment_account.bank_account_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback d-block"><strong><?php echo e($message); ?></strong></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2"
                                    for="bank_name"><?php echo e(__('taxido::static.fleet_managers.bank_name')); ?><span>*</span></label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="payment_account[bank_name]"
                                        placeholder="<?php echo e(__('taxido::static.fleet_managers.enter_bank_name')); ?>"
                                        value="<?php echo e(old('payment_account.bank_name', $fleetManager->payment_account->bank_name ?? '')); ?>">
                                    <?php $__errorArgs = ['payment_account.bank_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback d-block"><strong><?php echo e($message); ?></strong></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2"
                                    for="bank_holder_name"><?php echo e(__('taxido::static.fleet_managers.holder_name')); ?><span>*</span></label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text"
                                        name="payment_account[bank_holder_name]"
                                        placeholder="<?php echo e(__('taxido::static.fleet_managers.enter_holder_name')); ?>"
                                        value="<?php echo e(old('payment_account.bank_holder_name', $fleetManager->payment_account->bank_holder_name ?? '')); ?>">
                                    <?php $__errorArgs = ['payment_account.bank_holder_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback d-block"><strong><?php echo e($message); ?></strong></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2"
                                    for="swift"><?php echo e(__('taxido::static.fleet_managers.swift')); ?><span>*</span></label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="payment_account[swift]"
                                        placeholder="<?php echo e(__('taxido::static.fleet_managers.enter_swift_code')); ?>"
                                        value="<?php echo e(old('payment_account.swift', $fleetManager->payment_account->swift ?? '')); ?>">
                                    <?php $__errorArgs = ['payment_account.swift'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback d-block"><strong><?php echo e($message); ?></strong></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2" for="routing_number">
                                    <?php echo e(__('taxido::static.fleet_managers.routing_number')); ?><span>*</span>
                                </label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="payment_account[routing_number]"
                                        placeholder="<?php echo e(__('taxido::static.fleet_managers.enter_routing_number')); ?>"
                                        value="<?php echo e(old('payment_account.routing_number', $fleetManager->payment_account->routing_number ?? '')); ?>">
                                    <?php $__errorArgs = ['payment_account.routing_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback d-block"><strong><?php echo e($message); ?></strong></span>
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
                                            <i class="ri-save-line text-white lh-1"></i> <?php echo e(__('static.save')); ?>

                                        </button>
                                        <button type="submit" name="save_and_exit" class="btn btn-primary spinner-btn">
                                            <i class="ri-expand-left-line text-white lh-1"></i><?php echo e(__('static.save_and_exit')); ?>

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
<?php $__env->startPush('scripts'); ?>
    <script>
        (function($) {
            "use strict";
            $('#fleetManagerForm').validate({
                ignore: [] ,
                rules: {
                    "name": "required",
                    "email": "required",
                    "role_id": "required",
                    "phone": {
                        "required": true,
                        "minlength": 6,
                        "maxlength": 15
                    },
                    "password": {
                        "required": true,
                        "minlength": 8
                    },
                    "confirm_password": {
                        "required": true,
                        "equalTo": "#password"
                    },
                    "address[company_name]": "required",
                    "address[company_email]" : "required",
                    "address[company_address]" : "required",
                    "address[city]" : "required",
                    "address[postal_code]" : "required",
                    "address[city]" : "required",
                    "payment_account[routing_number]" : "required",
                    "payment_account[swift]" : "required",
                    "payment_account[bank_holder_name]" : "required",
                    "payment_account[bank_name]" : "required",
                    "payment_account[bank_account_no]" : "required",
                },
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/fleet-manager/fields.blade.php ENDPATH**/ ?>