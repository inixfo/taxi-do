<div class="row">
    <div class="col-xl-10 col-xxl-8 mx-auto">
        <div class="left-part">
            <div class="contentbox">
                <div class="inside">
                    <div class="contentbox-title">
                        <h3><?php echo e(isset($department) ? __('ticket::static.department.edit') : __('ticket::static.department.add')); ?>

                        </h3>
                    </div>
                    <?php if(isset($department)): ?>
                        <div class="form-group row">
                            <label class="col-md-2" for="name"><?php echo e(__('ticket::static.language.languages')); ?></label>
                            <div class="col-md-10">
                                <ul class="language-list">
                                    <?php $__empty_1 = true; $__currentLoopData = getLanguages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.department.edit', ['department' => $department->id, 'locale' => $lang->locale])); ?>"
                                                class="language-switcher <?php echo e(request('locale') === $lang->locale ? 'active' : ''); ?>"
                                                target="_blank"><img
                                                    src="<?php echo e(@$lang?->flag ?? asset('admin/images/No-image-found.jpg')); ?>"
                                                    alt=""> <?php echo e(@$lang?->name); ?> (<?php echo e(@$lang?->locale); ?>)<i
                                                    class="ri-arrow-right-up-line"></i></a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.department.edit', ['department' => $department->id, 'locale' => Session::get('locale', 'en')])); ?>"
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
                        <label class="col-md-2"
                            for="department_image_id"><?php echo e(__('ticket::static.department.image')); ?></label>
                        <div class="col-md-10">
                            <div class="form-group">
                                <?php if (isset($component)) { $__componentOriginal22d447e3f5aafc93b8447b54b36ee789 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal22d447e3f5aafc93b8447b54b36ee789 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.image','data' => ['name' => 'department_image_id','data' => isset($department->department_image)
                                    ? $department?->department_image
                                    : old('department_image_id'),'text' => ' ','multiple' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('image'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('department_image_id'),'data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($department->department_image)
                                    ? $department?->department_image
                                    : old('department_image_id')),'text' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'multiple' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal22d447e3f5aafc93b8447b54b36ee789)): ?>
<?php $attributes = $__attributesOriginal22d447e3f5aafc93b8447b54b36ee789; ?>
<?php unset($__attributesOriginal22d447e3f5aafc93b8447b54b36ee789); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal22d447e3f5aafc93b8447b54b36ee789)): ?>
<?php $component = $__componentOriginal22d447e3f5aafc93b8447b54b36ee789; ?>
<?php unset($__componentOriginal22d447e3f5aafc93b8447b54b36ee789); ?>
<?php endif; ?>
                                <?php $__errorArgs = ['department_image_id'];
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
                        <label class="col-md-2"
                            for="name"><?php echo e(__('ticket::static.department.name')); ?><span>*</span></label>
                        <div class="col-md-10">
                            <div class="position-relative">
                                <input class="form-control" type="text" name="name" id="name"
                                    value="<?php echo e(isset($department->name) ? $department->getTranslation('name', request('locale', app()->getLocale())) : old('name')); ?>"
                                    placeholder="<?php echo e(__('ticket::static.department.enter_name')); ?> (<?php echo e(request('locale', app()->getLocale())); ?>)"
                                    required>
                                <i class="ri-file-copy-line copy-icon" data-target="#name"></i>
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
                        <label class="col-md-2"
                            for="description"><?php echo e(__('ticket::static.department.description')); ?></label>
                        <div class="col-md-10">
                            <div class="position-relative">
                                <textarea class="form-control content" name="description" id="description"
                                    placeholder="<?php echo e(__('ticket::static.department.enter_description')); ?> (<?php echo e(request('locale', app()->getLocale())); ?>)">
                                    <?php echo e(isset($department->description) ? $department->getTranslation('description', request('locale', app()->getLocale())) : old('description')); ?>

                                </textarea>
                                <i class="ri-file-copy-line copy-icon" data-target="#description"></i>
                            </div>
                            <?php $__errorArgs = ['description'];
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
                        <label class="col-md-2" for="user_ids"><?php echo e(__('ticket::static.department.user')); ?><span>
                                *</span></label>
                        <div class="col-md-10 select-label-error">
                            <span class="text-gray mt-1">
                                <?php echo e(__('ticket::static.department.no_users_message')); ?>

                                <a href="<?php echo e(@route('admin.executive.index')); ?>" class="text-primary">
                                    <b><?php echo e(__('ticket::static.here')); ?></b>
                                </a>
                            </span>
                            <select class="select-2 form-control" name="user_ids[]" data-placeholder="<?php echo e(__('ticket::static.department.select_user')); ?>"
                                multiple>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option class="option" value="<?php echo e($user->id); ?>"
                                        <?php if(@$department?->assigned_executives): ?> <?php if(in_array($user->id, $department?->assigned_executives->pluck('id')->toArray())): ?>
                                            selected <?php endif; ?>
                                        <?php endif; ?>
                                        ><?php echo e($user->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['user_ids'];
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
                            for="imap_default_account"><?php echo e(__('ticket::static.department.default_account')); ?><span>
                                *</span></label>
                        <div class="col-md-10 select-label-error">
                            <select class="select-2 form-control" name="imap_default_account" id="imap_default_account"
                                data-placeholder="<?php echo e(__('ticket::static.department.select_account')); ?>">
                                <option class="select-placeholder" value=""></option>
                                <option class="option" value="default"
                                    <?php if(isset($department)): ?> <?php if($department->imap_credentials['imap_default_account'] == 'default'): ?>
                                    selected <?php endif; ?>
                                    <?php endif; ?>><?php echo e(__('ticket::static.department.default')); ?>

                                </option>
                                <option class="option" value="custom"
                                    <?php if(isset($department)): ?> <?php if($department->imap_credentials['imap_default_account'] == 'custom'): ?>
                                    selected <?php endif; ?>
                                    <?php endif; ?>><?php echo e(__('ticket::static.department.custom')); ?>

                                </option>
                            </select>
                            <?php $__errorArgs = ['imap_default_account'];
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

                    <div class="imap-credentials">
                        <div class="form-group row">
                            <label class="col-md-2" for="imap_host"><?php echo e(__('ticket::static.department.host')); ?><span>
                                    *</span></label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="imap_host"
                                    value="<?php echo e(isset($department->imap_credentials['imap_host']) ? $department->imap_credentials['imap_host'] : old('imap_host')); ?>"
                                    placeholder="<?php echo e(__('ticket::static.department.enter_imap_host')); ?>" required>
                                <?php $__errorArgs = ['imap_host'];
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
                            <label class="col-md-2" for="imap_port"><?php echo e(__('ticket::static.department.port')); ?><span>
                                    *</span></label>
                            <div class="col-md-10">
                                <input class="form-control" type="number" name="imap_port"
                                    value="<?php echo e(isset($department->imap_credentials['imap_port']) ? $department->imap_credentials['imap_port'] : old('imap_port')); ?>"
                                    placeholder="<?php echo e(__('ticket::static.department.enter_imap_port')); ?>" required>
                                <?php $__errorArgs = ['imap_port'];
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
                            <label for="imap_encryption"
                                class="col-md-2"><?php echo e(__('ticket::static.department.encryption')); ?><span>
                                    *</span></label>
                            <div class="col-md-10 select-dropdown">
                                <select class="select-2 form-control" name="imap_encryption" id="imap_encryption"
                                    data-placeholder="<?php echo e(__('ticket::static.department.select_imap_encryption')); ?>">
                                    <option class="select-placeholder" value=""></option>
                                    <?php $__empty_1 = true; $__currentLoopData = ['tls' => 'TLS', 'ssl' => 'SSL']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option class="option" value=<?php echo e($key); ?>

                                            <?php if(isset($department)): ?> <?php if($department->imap_credentials['imap_encryption'] == $key): ?>
                                            selected <?php endif; ?>
                                            <?php endif; ?>><?php echo e($option); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <option value="" disabled></option>
                                        <?php endif; ?>
                                    </select>
                                    <?php $__errorArgs = ['mode'];
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
                                    for="imap_username"><?php echo e(__('ticket::static.department.username')); ?><span>
                                        *</span></label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="imap_username"
                                        value="<?php echo e(isset($department->imap_credentials['imap_username']) ? $department->imap_credentials['imap_username'] : old('imap_username')); ?>"
                                        placeholder="<?php echo e(__('ticket::static.department.enter_imap_username')); ?>" required>
                                    <?php $__errorArgs = ['imap_username'];
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
                                    for="imap_password"><?php echo e(__('ticket::static.department.password')); ?><span>
                                        *</span></label>
                                <div class="col-md-10">
                                    <input class="form-control" type="password" name="imap_password"
                                        value="<?php echo e(isset($department->imap_credentials['imap_password']) ? $department->imap_credentials['imap_password'] : old('imap_password')); ?>"
                                        placeholder="<?php echo e(__('ticket::static.department.enter_imap_password')); ?>" required>
                                    <?php $__errorArgs = ['imap_password'];
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
                                    for="imap_protocol"><?php echo e(__('ticket::static.department.protocol')); ?><span>
                                        *</span></label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="imap_protocol"
                                        value="<?php echo e(isset($department->imap_credentials['imap_protocol']) ? $department->imap_credentials['imap_protocol'] : old('imap_protocol')); ?>"
                                        placeholder="<?php echo e(__('ticket::static.department.enter_imap_protocol')); ?>" required>
                                    <?php $__errorArgs = ['imap_protocol'];
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

                        <div class="form-group row mt-4">
                            <label class="col-md-2" for="status"><?php echo e(__('ticket::static.department.status')); ?></label>
                            <div class="col-md-10">
                                <div class="editor-space">
                                    <label class="switch">
                                        <input class="form-control" type="hidden" name="status" value="0">
                                        <input class="form-check-input" type="checkbox" name="status" id=""
                                            value="1" <?php if(@$department?->status ?? true): echo 'checked'; endif; ?>>
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
                                    <button type="submit" name="save" class="btn btn-solid spinner-btn">
                                        <i class="ri-save-line text-white lh-1"></i> <?php echo e(__('static.save')); ?>

                                    </button>
                                    <button type="submit" name="save_and_exit" class="btn btn-solid spinner-btn spinner-btn">
                                        <i
                                            class="ri-expand-left-line text-white lh-1"></i><?php echo e(__('static.save_and_exit')); ?>

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

                    $('.imap-credentials').hide();

                    $(document).on('change', '#imap_default_account', function(e) {
                        e.preventDefault();

                        var account = $(this).val();
                        if (account == 'custom') {
                            $('.imap-credentials').show();
                            $('#departmentForm').validate().valid();
                        } else {
                            $('.imap-credentials').hide();
                        }
                    });

                    $('#departmentForm').validate({
                        ignore: [],
                        rules: {
                            "name": "required",
                            "user_ids[]": {
                                required: function(element) {
                                    return $(element).val().length == 0;
                                }
                            },
                            "imap_default_account": {
                                required: function(element) {
                                    return $(element).val().length == 0;
                                }
                            },
                            "imap_encryption": {
                                required: function(element) {
                                    return $('#imap_default_account').val() === 'custom';
                                }
                            },
                            "imap_host": {
                                required: function(element) {
                                    return $('#imap_default_account').val() === 'custom';
                                }
                            },
                            "imap_port": {
                                required: function(element) {
                                    return $('#imap_default_account').val() === 'custom';
                                }
                            },
                            "imap_username": {
                                required: function(element) {
                                    return $('#imap_default_account').val() === 'custom';
                                }
                            },
                            "imap_password": {
                                required: function(element) {
                                    return $('#imap_default_account').val() === 'custom';
                                }
                            },
                            "imap_protocol": {
                                required: function(element) {
                                    return $('#imap_default_account').val() === 'custom';
                                }
                            }
                        },
                        messages: {
                            imap_encryption: {
                                required: "Select IMAP Encryption"
                            }
                        },
                    });
                });
            })(jQuery);
        </script>
    <?php $__env->stopPush(); ?>
<?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Ticket/resources/views/admin/department/fields.blade.php ENDPATH**/ ?>