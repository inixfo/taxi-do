<?php $__env->startSection('title', __('taxido::front.register')); ?>
<?php $__env->startSection('content'); ?>
    <section class="authentication-section section-b-space">
        <div class="container">
            <div class="auth-form-box">
                <div class="row align-items-center">
                    <div class="col-xl-7 col-lg-6 d-lg-block d-none">
                        <img src="<?php echo e(asset('images/authentication-img.png')); ?>" class="img-fluid auth-image">
                    </div>

                    <div class="col-xl-5 col-lg-6">
                        <div class="auth-right-box">
                            <h3><?php echo e(__('taxido::front.create_account')); ?></h3>
                            <h6><?php echo e(__('taxido::front.sign_up_minutes')); ?></h6>
                            <form method="POST" action="<?php echo e(route('front.cab.register.store')); ?>" id="registerForm">
                                <?php echo csrf_field(); ?>
                                <div class="form-box form-icon">
                                    <div class="position-relative">
                                        <i class="ri-user-line"></i>
                                        <input type="text" class="form-control" name="name" placeholder="<?php echo e(__('taxido::front.full_name')); ?>" value="<?php echo e(old('name')); ?>">
                                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="form-box form-icon">
                                    <div class="position-relative">
                                        <i class="ri-mail-line"></i>
                                        <input type="email" class="form-control" name="email" placeholder="<?php echo e(__('taxido::front.enter_email')); ?>" value="<?php echo e(old('email')); ?>">
                                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="form-box">
                                    
                                    <div class="number-mail-box">
                                        <div class="country-code-section">
                                            <select class="select-2 form-control select-country-code" id="select-country-code" name="country_code">
                                                <?php $__currentLoopData = getCountryCodes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option class="option" value="<?php echo e($option->calling_code); ?>"
                                                        data-image="<?php echo e(asset('images/flags/' . $option->flag)); ?>"
                                                        <?php if($option->calling_code == old('country_code', $rider?->country_code ?? '1')): echo 'selected'; endif; ?>>
                                                        <?php echo e($option->calling_code); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-12-full">
                                            <input type="number" name="phone" class="form-control" id="phoneNumber"
                                                value="<?php echo e(old('phone', $rider?->phone ?? '')); ?>"
                                                placeholder="<?php echo e(__('taxido::front.enter_phone_number')); ?>" required>
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
                                <div class="form-box form-icon">
                                    <div class="position-relative">
                                        <i class="ri-lock-2-line"></i>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="<?php echo e(__('taxido::front.enter_password')); ?>">
                                        <i class="ri-eye-line toggle-password right-icon"></i>
                                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="form-box form-icon">
                                    <div class="position-relative">
                                        <i class="ri-lock-2-line"></i>
                                        <input type="password" class="form-control" name="password_confirmation" placeholder="<?php echo e(__('taxido::front.enter_confirm_password')); ?>">
                                        <i class="ri-eye-line toggle-password right-icon"></i>
                                        <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <button type="submit" class="btn gradient-bg-color otp-btn spinner-btn"><?php echo e(__('taxido::front.sign_up')); ?> </button>
                            </form>

                            <div class="or-box">
                                <span><?php echo e(__('taxido::front.or')); ?></span>
                            </div>

                            <h6 class="new-account mt-0 flex-column"><?php echo e(__('taxido::front.already_have_account')); ?> 
                                <a href="<?php echo e(route('front.cab.login.index')); ?>"><?php echo e(__('taxido::front.sign_in')); ?></a>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        (function($) {
            "use strict";
            $(document).ready(function() {
                $('#registerForm').validate({
                    rules: {
                        name: {
                            required: true
                        },
                        email: {
                            required: true,
                            email: true 
                        },
                        phone: {
                            required: true,
                            number: true,
                            minlength: 6,
                            maxlength: 15
                        },
                        country_code: {
                            required: true
                        },
                        password: {
                            required: true,
                            minlength: 8
                        },
                        password_confirmation: {
                            required: true,
                            equalTo: "#password"
                        }
                    },
                    messages: {
                        name: {
                            required: "Please enter your full name."
                        },
                        email: {
                            required: "Please enter your email address.",
                            email: "Please enter a valid email address."
                        },
                        phone: {
                            required: "Please enter your phone number.",
                            number: "Please enter a valid phone number.",
                            minlength: "Phone number must be at least 6 digits.",
                            maxlength: "Phone number cannot exceed 15 digits."
                        },
                        country_code: {
                            required: "Please select a country code."
                        },
                        password: {
                            required: "Please enter a password.",
                            minlength: "Your password must be at least 8 characters long."
                        },
                        password_confirmation: {
                            required: "Please confirm your password.",
                            equalTo: "Passwords do not match."
                        },
                    }
                });
            });
        })(jQuery);
    </script>
    <script>
        $(document).ready(function () {
                $('#select-country-code').select2({
                    templateResult: function (data) {
                        if (!data.id) return data.text;

                        const imageUrl = $(data.element).data('image');
                        const $result = $(`
                            <span>
                                <img src="${imageUrl}" class="flag-img" onerror="this.onerror=null;this.src='<?php echo e(asset('front/images/placeholder/49x37.png')); ?>';" />
                                + ${data.text.trim()}
                            </span>
                        `);
                        return $result;
                    },
                    templateSelection: function (data) {
                        if (!data.id) return data.text;

                        const imageUrl = $(data.element).data('image');
                        const $result = $(`
                            <span>
                                <img src="${imageUrl}" class="flag-img" onerror="this.onerror=null;this.src='<?php echo e(asset('front/images/placeholder/49x37.png')); ?>';" />
                                + ${data.text.trim()}
                            </span>
                        `);
                        return $result;
                    },
                    escapeMarkup: function (m) { return m; }
                });
            });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('front.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/front/auth/register.blade.php ENDPATH**/ ?>