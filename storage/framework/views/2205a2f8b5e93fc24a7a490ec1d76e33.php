<?php $__env->startSection('title', __('static.accounts.edit_profile')); ?>
<?php $__env->startSection('content'); ?>
<div class="profile-main">
    <div class="row">
        <div class="col-xl-10 col-xxl-8 mx-auto">
            <div class="contentbox">
                <div class="inside">
                    <div class="contentbox-title">
                        <h3><?php echo e(__('static.accounts.edit_profile')); ?></h3>
                    </div>
                    <ul class="nav nav-tabs horizontal-tab custom-scroll" id="account" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php echo e($errors->has('name') || $errors->has('email') || $errors->has('role') || $errors->has('country_id') || $errors->has('state_id') || $errors->has('city') || $errors->has('phone') || $errors->has('countryCode') || $errors->has('latitude') || $errors->has('longitude') || !$errors->any() ? 'show active' : ''); ?>" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">
                                <i class="ri-shield-user-line"></i>
                                <?php echo e(__('static.accounts.general')); ?>

                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php echo e($errors->has('current_password') || $errors->has('new_password') || $errors->has('confirm_password') ? 'active' : ''); ?>" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab" aria-controls="password" aria-selected="false">
                                <i class="ri-rotate-lock-line"></i>
                                <?php echo e(__('static.accounts.change_password')); ?>

                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="accountContent">
                        <div class="tab-pane fade <?php echo e($errors->has('name') || $errors->has('email') || $errors->has('country_id') || $errors->has('state_id') || $errors->has('city') || $errors->has('phone') || $errors->has('countryCode') || $errors->has('latitude') || $errors->has('longitude') || !$errors->any() ? 'show active' : ''); ?>" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <form id="profileForm" action="<?php echo e(route('admin.account.profile.update', [Auth::user()->id])); ?>" method="POST" enctype="multipart/form-data" class="mb-0">
                                <?php echo method_field('PUT'); ?>
                                <?php echo csrf_field(); ?>
                                <div class="form-group row">
                                    <label class="col-md-2" for="avatar"><?php echo e(__('static.accounts.avatar')); ?>

                                    </label>
                                    <div class="col-md-10">
                                        <?php if (isset($component)) { $__componentOriginal22d447e3f5aafc93b8447b54b36ee789 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal22d447e3f5aafc93b8447b54b36ee789 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.image','data' => ['name' => 'profile_image_id','data' => Auth::user()->profile_image,'text' => __('static.accounts.image_note'),'multiple' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('image'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('profile_image_id'),'data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(Auth::user()->profile_image),'text' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('static.accounts.image_note')),'multiple' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal22d447e3f5aafc93b8447b54b36ee789)): ?>
<?php $attributes = $__attributesOriginal22d447e3f5aafc93b8447b54b36ee789; ?>
<?php unset($__attributesOriginal22d447e3f5aafc93b8447b54b36ee789); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal22d447e3f5aafc93b8447b54b36ee789)): ?>
<?php $component = $__componentOriginal22d447e3f5aafc93b8447b54b36ee789; ?>
<?php unset($__componentOriginal22d447e3f5aafc93b8447b54b36ee789); ?>
<?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2" for="name"><?php echo e(__('static.accounts.full_name')); ?><span> *</span></label>
                                    <div class="col-md-10">
                                        <div class="position-relative">
                                            <input placeholder="<?php echo e(__('static.accounts.enter_full_name')); ?>" class="form-control" value="<?php echo e(isset(Auth::user()->name) ? Auth::user()->name : old('name')); ?>" type="text" name="name" required>
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
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2" for="email"><?php echo e(__('static.accounts.email')); ?><span> *</span></label>
                                    <div class="col-md-10">
                                        <div class="position-relative">
                                            <input class="form-control" placeholder="<?php echo e(__('static.accounts.enter_email')); ?>" value="<?php echo e(isset(Auth::user()->email) ? Auth::user()->email : old('email')); ?>" type="email" name="email" required>
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
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2" for="phone"><?php echo e(__('static.accounts.phone')); ?><span> *</span></label>
                                    <div class="col-md-10">
                                        <div class="input-group mb-3 phone-detail">
                                            <div class="col-sm-1">
                                                <select class="select-2 form-control" id="select-country-code" name="country_code">
                                                    <?php
                                                    $default = old('country_code', Auth::user()->country_code ?? 1);
                                                    ?>
                                                    <?php $__currentLoopData = getCountryCodes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option class="option" value="<?php echo e($option->calling_code); ?>" data-image="<?php echo e(asset('images/flags/' . $option->flag)); ?>" <?php echo e($option->calling_code == $default ? 'selected' : ''); ?>> <?php echo e($option->calling_code); ?>

                                                    </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-11">
                                                <input class="form-control" placeholder="<?php echo e(__('static.accounts.enter_phone')); ?>" type="number" name="phone" value="<?php echo e(isset(Auth::user()->phone) ? Auth::user()->phone : old('phone')); ?>" required>
                                            </div>
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
                                </div>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-solid ms-auto spinner-btn"><i class="ri-save-line text-white lh-1"></i><?php echo e(__('static.save')); ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade <?php echo e($errors->has('new_password') || $errors->has('confirm_password') || $errors->has('current_password') ? 'active show' : ''); ?>" id="password" role="tabpanel" aria-labelledby="password-tab">
                            <form id="passwordForm" action="<?php echo e(route('admin.account.password.update')); ?>" method="POST" class="mb-0">
                                <?php echo method_field('PUT'); ?>
                                <?php echo csrf_field(); ?>
                                <div class="form-group row">
                                    <label class="col-md-2" for="current_password"><?php echo e(__('static.accounts.current_password')); ?><span> *</span></label>
                                    <div class="col-md-10">
                                        <div class="position-relative">
                                            <input class="form-control" type="password" name="current_password" placeholder="<?php echo e(__('static.accounts.enter_current_password')); ?>">
                                            <i class="ri-eye-line toggle-password"></i>
                                            <?php $__errorArgs = ['current_password'];
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
                                    <label class="col-md-2" for="new_password"><?php echo e(__('static.accounts.new_password')); ?><span> *</span></label>
                                    <div class="col-md-10">
                                        <div class="position-relative">
                                            <input class="form-control" type="password" id="new_password" name="new_password" placeholder="<?php echo e(__('static.accounts.enter_new_password')); ?>">
                                            <i class="ri-eye-line toggle-password"></i>
                                            <?php $__errorArgs = ['new_password'];
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
                                    <label class="col-md-2" for="confirm_password"><?php echo e(__('static.accounts.confirm_password')); ?><span> *</span></label>
                                    <div class="col-md-10">
                                        <div class="position-relative">
                                            <input class="form-control" type="password" name="confirm_password" placeholder="<?php echo e(__('static.accounts.enter_confirm_password')); ?>">
                                            <i class="ri-eye-line toggle-password"></i>
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
                                </div>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-solid ms-auto spinner-btn"><i class="ri-save-line text-white lh-1"></i><?php echo e(__('static.save')); ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
    (function($) {
        "use strict";

        // Custom validation method for alphabetic characters
        $.validator.addMethod("alphabetic", function(value, element) {
            return this.optional(element) || /^[a-zA-Z\s]{2,}$/.test(value);
        }, "Full name must contain at least 2 alphabetic characters");

        // Profile Update Form
        $('#profileForm').validate({
            ignore: [],
            rules: {
                name: {
                    required: true,
                    alphabetic: true
                },
                email: {
                    required: true,
                    email: true
                },
                phone: {
                    required: true,
                    minlength: 6,
                    maxlength: 15
                }
            },
            messages: {
                name: {
                    required: "Please enter your full name",
                    alphabetic: "Full name must contain at least 2 alphabetic characters"
                },
                email: {
                    required: "Please enter your email",
                    email: "Please enter a valid email address"
                },
                phone: {
                    required: "Please enter your phone number",
                    minlength: "Phone number must be at least 6 digits",
                    maxlength: "Phone number cannot exceed 15 digits"
                }
            },
            invalidHandler: function(event, validator) {
                let invalidTabs = [];
                $.each(validator.errorList, function(index, error) {
                    const tabId = $(error.element).closest('.tab-pane').attr('id');
                    $("#" + tabId + "-tab .errorIcon").show();
                    if (!invalidTabs.includes(tabId)) {
                        invalidTabs.push(tabId);
                    }
                });
                if (invalidTabs.length) {
                    $(".nav-link.active").removeClass("active");
                    $(".tab-pane.show").removeClass("show active");
                    $("#" + invalidTabs[0] + "-tab").addClass("active");
                    $("#" + invalidTabs[0]).addClass("show active");
                }
            },
            success: function(label, element) {
                $(element).closest('.tab-pane').find('.errorIcon').hide();
            }
        });

        // Change Password Form
        $('#passwordForm').validate({
            rules: {
                current_password: {
                    required: true
                },
                new_password: {
                    required: true,
                    minlength: 8
                },
                confirm_password: {
                    required: true,
                    minlength: 8,
                    equalTo: "#new_password"
                }
            },
            messages: {
                current_password: {
                    required: "Please enter your current password"
                },
                new_password: {
                    required: "Please enter a new password",
                    minlength: "New password must be at least 8 characters"
                },
                confirm_password: {
                    required: "Please confirm your new password",
                    minlength: "Confirm password must be at least 8 characters",
                    equalTo: "Passwords do not match"
                }
            }
        });
    })(jQuery);
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/resources/views/admin/account/index.blade.php ENDPATH**/ ?>