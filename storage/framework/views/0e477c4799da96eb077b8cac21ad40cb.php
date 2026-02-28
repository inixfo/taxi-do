<?php $__env->startSection('title', __('static.forgot_password')); ?>
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
                    <h3><?php echo e(__('static.forgot_password')); ?></h3>
                    <p><?php echo e(__('static.reset_password')); ?></p>
                </div>
                <div class="main">
                    <form id="emailForm" action="<?php echo e(route('password.email')); ?>" method='POST'>
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <i class="ri-mail-line divider"></i>
                            <div class="position-relative">
                                <input type="email" class="form-control" id="email" name="email" placeholder="<?php echo e(__('static.enter_email')); ?>">
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
                        <div class="form-button">
                            <button type="submit" class="btn btn-solid justify-content-center w-100 spinner-btn mt-0">
                                <?php echo e(__('static.link')); ?>

                            </button>
                        </div>
                        <a href="<?php echo e(route('login')); ?>" class="backward">
                            <i class="ri-arrow-left-line"></i>
                            <?php echo e(__('static.back')); ?>

                        </a>
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
            $('#emailForm').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    }
                }
            });
        });
    })(jQuery);
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('auth.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/resources/views/auth/passwords/email.blade.php ENDPATH**/ ?>