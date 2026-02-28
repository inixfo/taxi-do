<?php $__env->startSection('title', 'Verify'); ?>
<?php $__env->startSection('content'); ?>
<div>
  <form action="<?php echo e(route('install.verify')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php echo method_field('POST'); ?>
    <div class="row">
      <div class="database-field col-md-12">
        <h6>Please verify license & enter your administration details below.</h6>

        <!-- Envato Username Field -->
        <div class="form-group form-row">
          <label>Envato Username<span class="required-fill">*</span></label>
          <div>
            <input type="text" name="envato_username" value="<?php echo e(old('envato_username')); ?>" class="form-control" autocomplete="off">
            <?php if($errors->has('envato_username')): ?>
            <span class="text-danger"><?php echo e($errors->first('envato_username')); ?></span>
            <?php endif; ?>
          </div>
        </div>

        <!-- Purchase Code Field -->
        <div class="form-group form-row">
          <label>Purchase Code<span class="required-fill">*</span></label>
          <div>
            <input type="text" name="license" value="<?php echo e(old('license')); ?>" class="form-control" autocomplete="off">
            <?php if($errors->has('license')): ?>
            <span class="text-danger"><?php echo e($errors->first('license')); ?></span>
            <?php endif; ?>
          </div>
        </div>

        <!-- Purchase Code Help Link -->
        <div>
          If you don't know how to get purchase code, click here:
          <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code">where is my purchase code</a>
        </div>

        <!-- Conditional Admin Fields -->
        <?php if(scSpatPkS()): ?>
        <!-- First Name Field -->
        <div class="form-group form-row">
          <div>
            <div class="form-group form-row">
              <label>First Name <span class="required-fill">*</span></label>
              <div>
                <input type="text" name="admin[first_name]" value="<?php echo e(old('admin.first_name')); ?>" class="form-control" autocomplete="off">
                <?php if($errors->has('admin.first_name')): ?>
                <span class="text-danger"><?php echo e($errors->first('admin.first_name')); ?></span>
                <?php endif; ?>
              </div>
            </div>

            <!-- Last Name Field -->
            <div class="form-group form-row">
              <label>Last Name<span class="required-fill">*</span></label>
              <div>
                <input type="text" name="admin[last_name]" value="<?php echo e(old('admin.last_name')); ?>" class="form-control" autocomplete="off">
                <?php if($errors->has('admin.last_name')): ?>
                <span class="text-danger"><?php echo e($errors->first('admin.last_name')); ?></span>
                <?php endif; ?>
              </div>
            </div>

            <!-- Email Field -->
            <div class="form-group form-row">
              <label>Email <span class="required-fill">*</span></label>
              <div>
                <input type="email" name="admin[email]" value="<?php echo e(old('admin.email')); ?>" class="form-control" autocomplete="off">
                <?php if($errors->has('admin.email')): ?>
                <span class="text-danger"><?php echo e($errors->first('admin.email')); ?></span>
                <?php endif; ?>
              </div>
            </div>

            <!-- Password Field -->
            <div class="form-group form-row">
              <label>Password <span class="required-fill">*</span></label>
              <div>
                <input type="password" name="admin[password]" class="form-control" autocomplete="off">
                <?php if($errors->has('admin.password')): ?>
                <span class="text-danger"><?php echo e($errors->first('admin.password')); ?></span>
                <?php endif; ?>
              </div>
            </div>

            <!-- Confirm Password Field -->
            <div class="form-group form-row">
              <label>Confirm Password <span class="required-fill">*</span></label>
              <div>
                <input type="password" name="admin[password_confirmation]" class="form-control" autocomplete="off">
                <?php if($errors->has('admin.password_confirmation')): ?>
                <span class="text-danger"><?php echo e($errors->first('admin.password_confirmation')); ?></span>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Submit Button -->
    <div class="next-btn d-flex">
      <a href="javascript:void(0)" class="btn btn-primary submit-form">Submit <i class="far fa-hand-point-right ms-2"></i></a>
    </div>
  </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
  $(".submit-form").click(function() {
    $("form").submit();
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('stv::stmv', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/vendor/phpblaze/bladelib/src/Templates/stvi.blade.php ENDPATH**/ ?>