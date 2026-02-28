<div class="row">
    <div class="col-xl-10 col-xxl-8 mx-auto">
      <div class="contentbox">
        <div class="inside">
          <div class="contentbox-title">
            <h3><?php echo e(isset($executive) ?  __('ticket::static.executive.edit') :  __('ticket::static.executive.add')); ?></h3>
          </div>
          <div class="form-group row">
            <label class="col-md-2" for="name"><?php echo e(__('ticket::static.executive.full_name')); ?><span> *</span></label>
            <div class="col-md-10">
              <input class="form-control" value="<?php echo e(isset($executive->name) ? $executive->name : old('name')); ?>" type="text" name="name" placeholder="<?php echo e(__('ticket::static.executive.enter_full_name')); ?>" required>
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
                <label class="col-md-2" for="email"><?php echo e(__('ticket::static.executive.email')); ?><span> *</span></label>
                <div class="col-md-10">
                    <?php if(isset($executive) && isDemoModeEnabled()): ?> 
                        <input class="form-control" value="<?php echo e(__('static.demo_mode')); ?>" type="text" readonly>
                    <?php else: ?>
                        <input class="form-control" 
                            value="<?php echo e(isset($executive->email) ? $executive->email : old('email')); ?>" 
                            type="email" name="email" 
                            placeholder="<?php echo e(__('ticket::static.executive.enter_email')); ?>" required>
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
                <label class="col-md-2" for="phone"><?php echo e(__('ticket::static.executive.phone')); ?><span> *</span></label>
                <div class="col-md-10">
                    <?php if(isset($executive) && isDemoModeEnabled()): ?> 
                        <input class="form-control" value="<?php echo e(__('static.demo_mode')); ?>" type="text" readonly>
                    <?php else: ?>
                        <div class="input-group mb-3 phone-detail">
                            <div class="col-sm-1">
                                <select class="select-2 form-control" id="select-country-code" name="country_code">
                                    <?php $__currentLoopData = getCountryCodes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option class="option" value="<?php echo e($option->calling_code); ?>"
                                            data-image="<?php echo e(asset('images/flags/' . $option->flag)); ?>"
                                            <?php if($option->calling_code == old('country_code', $executive->country_code ?? '1')): echo 'selected'; endif; ?>>
                                            <?php echo e($option->calling_code); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-sm-11">
                                <input class="form-control" type="number" name="phone"
                                    value="<?php echo e(old('phone', $executive->phone ?? '')); ?>"
                                    placeholder="<?php echo e(__('ticket::static.executive.enter_phone')); ?>" required>
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
          <?php if(request()->routeIs('admin.executive.create')): ?>
          <div class="form-group row">
            <label class="col-md-2" for="password"><?php echo e(__('ticket::static.executive.new_password')); ?><span> *</span></label>
            <div class="col-md-10">
              <div class="position-relative">
                <input class="form-control" type="password" id="password" name="password" placeholder="<?php echo e(__('ticket::static.executive.enter_password')); ?>" required>
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
            <label class="col-md-2" for="confirm_password"><?php echo e(__('ticket::static.executive.confirm_password')); ?><span> *</span></label>
            <div class="col-md-10">
              <div class="position-relative">
                <input class="form-control" type="password" name="confirm_password" placeholder="<?php echo e(__('ticket::static.executive.enter_confirm_password')); ?>" required>
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
            <label class="col-md-2 mb-0" for="notify"><?php echo e(__('ticket::static.executive.notification')); ?></label>
            <div class="col-md-10">
              <div class="form-check p-0 w-auto">
                <input type="checkbox" name="notify" id="notify" value="1" class="form-check-input me-2">
                <label for="notify"><?php echo e(__('ticket::static.executive.sentence')); ?></label>
              </div>
            </div>
          </div>
          <?php endif; ?>
          <div class="form-group row">
            <label class="col-md-2" for="role"><?php echo e(__('ticket::static.executive.status')); ?></label>
            <div class="col-md-10">
              <div class="editor-space">
                <label class="switch">
                  <input class="form-control" type="hidden" name="status" value="0">
                  <input class="form-check-input" type="checkbox" name="status" value="1" <?php if(@$executive?->status ?? true): echo 'checked'; endif; ?>>
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
                          <i class="ri-save-line text-white lh-1"></i> <?php echo e(__('ticket::static.save')); ?>

                      </button>
                      <button type="submit" name="save_and_exit" class="btn btn-primary spinner-btn">
                          <i class="ri-expand-left-line text-white lh-1"></i><?php echo e(__('ticket::static.save_and_exit')); ?>

                      </button>
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
      $('#executiveForm').validate({
        rules: {
          "name": "required",
          "email": {
            "required": true,
            "email": true
          },
          "phone": {
            "required": true,
            "minlength": 6,
            "maxlength": 15
          },
          "password": {
              "required": true,
              "minlength": 6
          },
          "confirm_password": {
              "required": true,
              "equalTo": "#password"
          }
        },
      });
    })(jQuery);
  </script>
  <?php $__env->stopPush(); ?>
  <?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Ticket/resources/views/admin/executive/fields.blade.php ENDPATH**/ ?>