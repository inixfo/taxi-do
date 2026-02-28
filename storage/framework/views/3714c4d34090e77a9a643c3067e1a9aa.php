<?php $__env->startSection('title', __('static.reset_password')); ?>
<?php $__env->startSection('content'); ?>
<section class="auth-page">
    <div class="container">
        <div class="auth-main">
            <div class="auth-card">
                <div class="text-center">
                    <?php if(isset(getSettings()['general']['light_logo_image'])): ?>
                    <img class="login-img" src="<?php echo e(getSettings()['general']['light_logo_image']?->original_url); ?>" alt="logo">
                    <?php else: ?>
                    <h2><?php echo e(env('APP_NAME')); ?></h2>
                    <?php endif; ?>
                </div>
                <div class="welcome">
                    <h3><?php echo e(__('static.reset_password')); ?></h3>
                    <p><?php echo e(__('static.create_password')); ?></p>
                </div>
                <div class="main">
                    <form id="resetForm" action="<?php echo e(route('password.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="token" value="<?php echo e($token); ?>">
                        <div class="form-group">
                            <i class="ri-mail-line divider"></i>
                            <div class="position-relative">
                                <input class="form-control" value="<?php echo e(old('email')); ?>" id="email" type="email" name="email" placeholder="<?php echo e(__('static.enter_email')); ?>">
                            </div>
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
                        <div class="form-group">
                            <i class="ri-lock-line divider"></i>
                            <div class="position-relative">
                                <input class="form-control input-icon" id="password" type="password" name="password" placeholder="<?php echo e(__('static.enter_password')); ?>">
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
                        <div class="form-group">
                            <i class="ri-lock-line divider"></i>
                            <div class="position-relative">
                                <input class="form-control input-icon" id="confirm-password" type="password" name="password_confirmation" placeholder="<?php echo e(__('static.enter_confirm_password')); ?>">
                                <i class="ri-eye-line toggle-password"></i>
                            </div>
                            <?php $__errorArgs = ['password_confirmation'];
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
                        <div class="form-button">
                            <button type="submit" class="btn btn-solid justify-content-center w-100 spinner-btn mt-0">
                                <?php echo e(__('static.reset_password')); ?>

                            </button>
                        </div>
                    </form>
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
            $('#resetForm').validate({
                rules: {
                    email: {
                        required: true,
                    },
                    password: {
                        required: true,
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    }
                }
            });
        });
    })(jQuery);
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('auth.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/resources/views/auth/passwords/reset.blade.php ENDPATH**/ ?>