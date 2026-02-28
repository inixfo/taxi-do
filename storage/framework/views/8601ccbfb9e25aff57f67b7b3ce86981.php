<?php use \Modules\Taxido\Models\Zone; ?>
<?php
    $zones = Zone::where('status', true)?->get(['id', 'name']);
?>
<div class="row g-xl-4 g-3">
    <div class="col-xl-10 col-xxl-8 mx-auto">
        <div class="left-part">
            <div class="contentbox">
                <div class="inside">
                    <div class="contentbox-title">
                        <h3><?php echo e(isset($dispatcher) ? __('taxido::static.dispatchers.edit') : __('taxido::static.dispatchers.add')); ?>

                        </h3>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="name"><?php echo e(__('taxido::static.dispatchers.full_name')); ?><span>
                                *</span></label>
                        <div class="col-md-10">
                            <input class="form-control" value="<?php echo e(isset($dispatcher->name) ? $dispatcher->name : old('name')); ?>"
                                type="text" name="name"
                                placeholder="<?php echo e(__('taxido::static.dispatchers.enter_full_name')); ?>">
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
                        <label class="col-md-2" for="email"><?php echo e(__('taxido::static.dispatchers.email')); ?><span>
                                *</span></label>
                        <div class="col-md-10">
                            <input class="form-control"
                                value="<?php echo e(isset($dispatcher->email) ? $dispatcher->email : old('email')); ?>" type="email"
                                name="email" placeholder="<?php echo e(__('taxido::static.dispatchers.enter_email')); ?>">
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
                        <label class="col-md-2" for="phone"><?php echo e(__('taxido::static.dispatchers.phone')); ?><span>
                                *</span></label>
                        <div class="col-md-10">
                            <div class="input-group mb-3 phone-detail">
                                <div class="col-sm-1">
                                    <select class="select-2 form-control" id="select-country-code" name="country_code">
                                        <?php $__currentLoopData = getCountryCodes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option class="option" value="<?php echo e($option->calling_code); ?>"
                                                data-image="<?php echo e(asset('images/flags/' . $option->flag)); ?>"
                                                <?php if($option->calling_code == old('country_code', $dispatcher->country_code ?? '1')): echo 'selected'; endif; ?>>
                                                <?php echo e($option->calling_code); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-sm-11">
                                    <input class="form-control" type="number" name="phone"
                                        value="<?php echo e(old('phone', $dispatcher->phone ?? '')); ?>"
                                        placeholder="<?php echo e(__('taxido::static.dispatchers.enter_phone')); ?>">
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
                    <?php if(request()->routeIs('admin.dispatcher.create')): ?>
                        <div class="form-group row">
                            <label class="col-md-2" for="password"><?php echo e(__('taxido::static.dispatchers.new_password')); ?><span>
                                    *</span></label>
                            <div class="col-md-10">
                                <div class="position-relative">
                                    <input class="form-control" type="password" id="password" name="password"
                                        placeholder="<?php echo e(__('taxido::static.dispatchers.enter_password')); ?>">
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
                                for="confirm_password"><?php echo e(__('taxido::static.dispatchers.confirm_password')); ?><span>
                                    *</span></label>
                            <div class="col-md-10">
                                <div class="position-relative">
                                    <input class="form-control" type="password" name="confirm_password"
                                        placeholder="<?php echo e(__('taxido::static.dispatchers.enter_confirm_password')); ?>"
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
                        <?php endif; ?>
                        

                    <div class="form-group row">
                        <label class="col-md-2" for="zone"><?php echo e(__('taxido::static.dispatchers.zones')); ?> <span>
                                *</span></label>
                        <div class="col-md-10 select-label-error">
                        <span class="text-gray mt-1">
                                <?php echo e(__('taxido::static.dispatchers.no_zones_message')); ?>

                                <a href="<?php echo e(@route('admin.zone.index')); ?>" class="text-primary">
                                    <b><?php echo e(__('taxido::static.here')); ?></b>
                                </a>
                            </span>
                            <select class="form-control select-2 zone" name="zones[]"
                                data-placeholder="<?php echo e(__('taxido::static.dispatchers.select_zones')); ?>" multiple>
                                <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($zone->id); ?>"
                                        <?php if(isset($dispatcher->zones)): ?> <?php if(in_array($zone->id, $dispatcher->zones->pluck('id')->toArray())): ?>
                                selected <?php endif; ?>
                                    <?php elseif(old('zones.' . $index) == $zone->id): ?> selected <?php endif; ?>>
                                        <?php echo e($zone->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['zones'];
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
                            for="notify"><?php echo e(__('taxido::static.dispatchers.notification')); ?></label>
                        <div class="col-md-10">
                            <div class="form-check p-0 w-auto">
                                <input type="checkbox" name="notify" id="notify" value="1"
                                    class="form-check-input me-2">
                                <label for="notify"><?php echo e(__('taxido::static.dispatchers.sentence')); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="role"><?php echo e(__('taxido::static.status')); ?></label>
                        <div class="col-md-10">
                            <div class="editor-space">
                                <label class="switch">
                                    <input class="form-control" type="hidden" name="status" value="0">
                                    <input class="form-check-input" type="checkbox" name="status" id=""
                                        value="1" <?php if(@$dispatcher?->status ?? true): echo 'checked'; endif; ?>>
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
                                    <i
                                        class="ri-expand-left-line text-white lh-1"></i><?php echo e(__('taxido::static.save_and_exit')); ?>

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

        $(document).ready(function() {
            $('#dispatcherForm').validate({
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
                    }
                }
            });

        });

    })(jQuery);
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/dispatcher/fields.blade.php ENDPATH**/ ?>