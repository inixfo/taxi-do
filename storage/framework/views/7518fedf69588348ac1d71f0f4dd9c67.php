<div class="row">
    <div class="col-xl-10 col-xxl-8 mx-auto">
        <div class="left-part">
            <div class="contentbox">
                <div class="inside">
                    <div class="contentbox-title">
                        <h3><?php echo e(isset($status) ? __('ticket::static.status.edit') : __('ticket::static.status.add')); ?>

                        </h3>
                    </div>
                    <?php if(isset($status)): ?>
                        <div class="form-group row">
                            <label class="col-md-2" for="name"><?php echo e(__('ticket::static.language.languages')); ?></label>
                            <div class="col-md-10">
                                <ul class="language-list">
                                    <?php $__empty_1 = true; $__currentLoopData = getLanguages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.status.edit', ['status' => $status->id, 'locale' => $lang->locale])); ?>"
                                                class="language-switcher <?php echo e(request('locale') === $lang->locale ? 'active' : ''); ?>"
                                                target="_blank"><img
                                                    src="<?php echo e(@$lang?->flag ?? asset('admin/images/No-image-found.jpg')); ?>"
                                                    alt=""> <?php echo e(@$lang?->name); ?> (<?php echo e(@$lang?->locale); ?>)<i
                                                    class="ri-arrow-right-up-line"></i></a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.status.edit', ['status' => $status->id, 'locale' => Session::get('locale', 'en')])); ?>"
                                                class="language-switcher active" target="blank"><img
                                                    src="<?php echo e(asset('admin/images/flags/LR.png')); ?>" alt="">English<i
                                                    class="ri-arrow-right-up-line"></i></a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                    <input type="hidden" name="locale" value="<?php echo e(request('locale')); ?>">
                    <div class="form-group row">
                        <label class="col-md-2" for="name"><?php echo e(__('ticket::static.status.name')); ?><span>
                                *</span></label>
                        <div class="col-md-10">
                            <div class="position-relative">
                                <input class="form-control" type="text" name="name" id="name"
                                    value="<?php echo e(isset($status->name) ? $status->getTranslation('name', request('locale', app()->getLocale())) : old('name')); ?>"
                                    placeholder="<?php echo e(__('ticket::static.status.enter_name')); ?>(<?php echo e(request('locale', app()->getLocale())); ?>)"
                                    required><i class="ri-file-copy-line copy-icon" data-target="#name"></i>
                            </div>
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
                        <label class="col-md-2" for="color"><?php echo e(__('ticket::static.status.color')); ?><span>
                                *</span></label>
                        <div class="col-md-10 select-label-error">
                            <select class="select-2 form-control" name="color"
                                data-placeholder="<?php echo e(__('ticket::static.status.select_color')); ?>">
                                <option class="select-placeholder" value=""></option>
                                <?php $__empty_1 = true; $__currentLoopData = ['primary' => 'Primary', 'secondary' => 'Secondary', 'success' => 'Success', 'danger' => 'Danger', 'info' => 'Info', 'light' => 'Light', 'dark' => 'Dark', 'warning' => 'Warning']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <option class="option" value=<?php echo e($key); ?>

                                        <?php if(old('color', $status->color ?? '') == $key): ?> selected <?php endif; ?>><?php echo e($option); ?></option>
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
                        <label class="col-md-2" for="role"><?php echo e(__('ticket::static.status.status')); ?></label>
                        <div class="col-md-10">
                            <div class="editor-space">
                                <label class="switch">
                                    <input class="form-control" type="hidden" name="status" value="0">
                                    <input class="form-check-input" type="checkbox" name="status" id=""
                                        value="1" <?php if(@$status?->status ?? true): echo 'checked'; endif; ?>>
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
</div>
<?php $__env->startPush('scripts'); ?>
    <script>
        (function($) {
            "use strict";
            $('#statusForm').validate({
                rules: {
                    "color": "required"
                },
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Ticket/resources/views/admin/status/fields.blade.php ENDPATH**/ ?>