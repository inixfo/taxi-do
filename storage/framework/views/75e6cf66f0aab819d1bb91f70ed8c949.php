<?php $__env->startSection('title', 'Verify'); ?>
<?php $__env->startSection('content'); ?>
    <div>
        <form action="<?php echo e(route('install.unblock')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('POST'); ?>
            <div class="row">
                <div class="database-field col-md-12">
                    <h6>Your Current license is Blocked. Please enter new license details below for active license.</h6>

                    <div class="form-group form-row">
                        <label>Envato Username<span class="required-fill">*</span></label>
                        <div>
                            <input type="text" name="envato_username" value="<?php echo e(old('envato_username')); ?>" class="form-control" autocomplete="off">
                            <?php if($errors->has('envato_username')): ?>
                                <span class="text-danger"><?php echo e($errors->first('envato_username')); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group form-row">
                        <label>License Code<span class="required-fill">*</span></label>
                        <div>
                            <input type="text" name="license" value="<?php echo e(old('license')); ?>" class="form-control" autocomplete="off">
                            <?php if($errors->has('license')): ?>
                                <span class="text-danger"><?php echo e($errors->first('license')); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div>
                        If you don't know how to get purchase code, click here: <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code"> where is my purchase code </a>
                    </div>
                </div>
            </div>
        </form>
        <div class="next-btn d-flex">
            <a href="javascript:void(0)" class="btn btn-primary sumit-form">Active <i class="far fa-hand-point-right ms-2"></i></a>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        $(".sumit-form").click(function() {
            $("form").submit();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('stv::stmv', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/vendor/phpblaze/bladelib/src/Templates/stbl.blade.php ENDPATH**/ ?>