<?php use \Modules\Taxido\Models\Driver; ?>
<?php
    $drivers = Driver::where('status', true)?->get(['id', 'name']);
?>
<div class="row g-xl-4 g-3">
    <div class="col-xl-10 col-xxl-8 mx-auto">
        <div class="left-part">
            <div class="contentbox">
                <div class="inside">
                    <div class="contentbox-title">
                        <h3><?php echo e(isset($notice) ? __('taxido::static.notices.edit') : __('taxido::static.notices.add_notice')); ?>

                            (<?php echo e(app()->getLocale()); ?>)</h3>
                    </div>
                    <?php if(isset($notice)): ?>
                        <div class="form-group row">
                            <label class="col-md-2" for="name"><?php echo e(__('taxido::static.language.languages')); ?></label>
                            <div class="col-md-10">
                                <ul class="language-list">
                                    <?php $__empty_1 = true; $__currentLoopData = getLanguages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.notice.edit', ['notice' => $notice->id, 'locale' => $lang->locale])); ?>"
                                                class="language-switcher <?php echo e(request('locale') === $lang->locale ? 'active' : ''); ?>"
                                                target="_blank"><img
                                                    src="<?php echo e(@$lang?->flag ?? asset('admin/images/No-image-found.jpg')); ?>"
                                                    alt=""> <?php echo e(@$lang?->name); ?> (<?php echo e(@$lang?->locale); ?>)<i
                                                    class="ri-arrow-right-up-line"></i></a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.notice.edit', ['notice' => $notice->id, 'locale' => Session::get('locale', 'en')])); ?>"
                                                class="language-switcher active" target="blank"><img
                                                    src="<?php echo e(asset('admin/images/flags/LR.png')); ?>" alt="">English<i
                                                    class="ri-arrow-right-up-line"></i></a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="form-group row">
                        <label class="col-md-2" for="send_to"><?php echo e(__('taxido::static.notices.send_to')); ?>

                            <span>*</span></label>
                        <div class="col-md-10 select-label-error">
                            <select class="select-2 form-control" id="send_to" name="send_to"
                                data-placeholder="<?php echo e(__('taxido::static.notices.select_send_to')); ?>">
                                <option class="select-placeholder" value=""></option>
                                <?php $__currentLoopData = ['all' => 'All', 'particular' => 'Drivers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option class="option" value="<?php echo e($key); ?>"
                                        <?php if(old('send_to', $notice->send_to ?? '') == $key): ?> selected <?php endif; ?>><?php echo e($option); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['send_to'];
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

                    <div class="form-group row" id="driver-selection" style="display: none;">
                        <label class="col-md-2" for="driver"><?php echo e(__('taxido::static.notices.select_drivers')); ?><span>
                                *</span></label>
                        <div class="col-md-10 select-label-error">
                            <span class="text-gray mt-1">
                                <?php echo e(__('taxido::static.notices.no_drivers_message')); ?>

                                <a href="<?php echo e(@route('admin.driver.index')); ?>" class="text-primary">
                                    <b><?php echo e(__('taxido::static.here')); ?></b>
                                </a>
                            </span>
                            <select class="form-control select-2 driver" name="drivers[]"
                                data-placeholder="<?php echo e(__('taxido::static.notices.select_drivers')); ?>" multiple>
                                <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($driver->id); ?>"
                                        <?php if(@$notice?->drivers): ?> <?php if(in_array($driver->id, $notice->drivers->pluck('id')->toArray())): ?> selected <?php endif; ?>
                                    <?php elseif(old('drivers.' . $index) == $driver->id): ?> selected <?php endif; ?>>
                                        <?php echo e($driver->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['drivers'];
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
                            for="message"><?php echo e(__('taxido::static.notices.message')); ?><span>*</span></label>
                        <div class="col-md-10">
                            <div class="position-relative">
                                <textarea class="form-control"
                                    placeholder="<?php echo e(__('taxido::static.notices.enter_message')); ?> (<?php echo e(request('locale', app()->getLocale())); ?>)"
                                    rows="4" id="message" name="message" cols="50"><?php echo e(isset($notice->message) ? $notice->getTranslation('message', request('locale', app()->getLocale())) : old('message')); ?></textarea><i class="ri-file-copy-line copy-icon"
                                    data-target="#message"></i>
                            </div>
                            <?php $__errorArgs = ['message'];
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
                        <label class="col-md-2" for="color"><?php echo e(__('taxido::static.notices.color')); ?><span>
                                *</span></label>
                        <div class="col-md-10 select-label-error">
                            <select class="select-2 form-control" name="color"
                                data-placeholder="<?php echo e(__('taxido::static.notices.select_color')); ?>">
                                <option class="select-placeholder" value=""></option>
                                <?php $__empty_1 = true; $__currentLoopData = ['primary' => 'Primary', 'secondary' => 'Secondary', 'success' => 'Success', 'danger' => 'Danger', 'info' => 'Info', 'light' => 'Light', 'dark' => 'Dark', 'warning' => 'Warning']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <option class="option" value=<?php echo e($key); ?>

                                        <?php if(old('color', $notice->color ?? '') == $key): ?> selected <?php endif; ?>><?php echo e($option); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <option value="" disabled></option>
                                <?php endif; ?>
                            </select>
                            <?php $__errorArgs = ['color'];
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
                        <label class="col-md-2" for="notice"><?php echo e(__('taxido::static.status')); ?></label>
                        <div class="col-md-10">
                            <div class="editor-space">
                                <label class="switch">
                                    <input class="form-control" type="hidden" name="status" value="0">
                                    <input class="form-check-input" type="checkbox" name="status" id=""
                                        value="1" <?php if(@$notice?->status ?? true): echo 'checked'; endif; ?>>
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

            $('#noticeForm').validate({
                rules: {
                    "send_to": "required",
                    "color": "required",
                    "message": "required",
                    "drivers[]": {
                        required: function() {
                            return $('#send_to').val() === 'particular';
                        }
                    }
                }
            });

            $('#send_to').on('change', function() {
                if ($(this).val() === 'particular') {
                    $('#driver-selection').show();
                } else {
                    $('#driver-selection').hide();
                }
            });

            $('#send_to').trigger('change');

        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/notice/fields.blade.php ENDPATH**/ ?>