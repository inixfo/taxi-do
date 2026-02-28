<?php use \Modules\Taxido\Models\Zone; ?>
<?php
    $zones = Zone::where('status', true)?->get(['id', 'name']);
?>
<div class="row">
    <div class="row g-xl-4 g-3">
        <div class="col-xl-10 col-xxl-8 mx-auto">
            <div class="left-part">
                <div class="contentbox">
                    <div class="inside">
                        <div class="contentbox-title">
                            <h3><?php echo e(isset($sos) ? __('taxido::static.soses.edit') : __('taxido::static.soses.add')); ?>

                                (<?php echo e(request('locale', app()->getLocale())); ?>)</h3>
                        </div>

                        <?php if(isset($sos)): ?>
                            <div class="form-group row">
                                <label class="col-md-2" for="name"><?php echo e(__('taxido::static.language.languages')); ?></label>
                                <div class="col-md-10">
                                    <ul class="language-list">
                                        <?php $__empty_1 = true; $__currentLoopData = getLanguages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <li>
                                                <a href="<?php echo e(route('admin.sos.edit', ['sos' => $sos->id, 'locale' => $lang->locale])); ?>"
                                                    class="language-switcher <?php echo e(request('locale') === $lang->locale ? 'active' : ''); ?>"
                                                    target="_blank"><img
                                                        src="<?php echo e(@$lang?->flag ?? asset('admin/images/No-image-found.jpg')); ?>"
                                                        alt=""> <?php echo e(@$lang?->name); ?> (<?php echo e(@$lang?->locale); ?>)<i
                                                        class="ri-arrow-right-up-line"></i></a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <li>
                                                <a href="<?php echo e(route('admin.sos.edit', ['sos' => $sos->id, 'locale' => Session::get('locale', 'en')])); ?>"
                                                    class="language-switcher active" target="blank"><img
                                                        src="<?php echo e(asset('admin/images/flags/LR.png')); ?>"
                                                        alt="">English<i class="ri-arrow-right-up-line"></i></a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>
                        <input type="hidden" name="locale" value="<?php echo e(request('locale')); ?>">
                        <div class="form-group row">
                            <label class="col-md-2"
                                for="sos_image_id"><?php echo e(__('taxido::static.soses.sos_image')); ?></label>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <?php if (isset($component)) { $__componentOriginal22d447e3f5aafc93b8447b54b36ee789 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal22d447e3f5aafc93b8447b54b36ee789 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.image','data' => ['name' => 'sos_image_id','data' => isset($sos->sos_image) ? $sos?->sos_image : old('sos_image_id'),'text' => '','multiple' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('image'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('sos_image_id'),'data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($sos->sos_image) ? $sos?->sos_image : old('sos_image_id')),'text' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'multiple' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal22d447e3f5aafc93b8447b54b36ee789)): ?>
<?php $attributes = $__attributesOriginal22d447e3f5aafc93b8447b54b36ee789; ?>
<?php unset($__attributesOriginal22d447e3f5aafc93b8447b54b36ee789); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal22d447e3f5aafc93b8447b54b36ee789)): ?>
<?php $component = $__componentOriginal22d447e3f5aafc93b8447b54b36ee789; ?>
<?php unset($__componentOriginal22d447e3f5aafc93b8447b54b36ee789); ?>
<?php endif; ?>
                                    <?php $__errorArgs = ['sos_image_id'];
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
                            <label class="col-md-2" for="title"><?php echo e(__('taxido::static.soses.title')); ?> <span>
                                    *</span></label>
                            <div class="col-md-10">
                                <div class="position-relative">
                                    <input class="form-control" id="title" type="text" name="title"
                                        value="<?php echo e(isset($sos->title) ? $sos->getTranslation('title', request('locale', app()->getLocale())) : old('title')); ?>"
                                        placeholder="<?php echo e(__('taxido::static.soses.enter_title')); ?> (<?php echo e(request('locale', app()->getLocale())); ?>)"><i
                                        class="ri-file-copy-line copy-icon" data-target="#title"></i>
                                </div>
                                <?php $__errorArgs = ['title'];
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
                            <label class="col-md-2" for="phone"><?php echo e(__('taxido::static.soses.phone')); ?>

                                <span>*</span></label>
                            <div class="col-md-10">
                                <div class="input-group mb-3 phone-detail">
                                    <div class="col-sm-1">
                                        <select class="select-2 form-control" id="select-country-code"
                                            name="country_code">
                                            <?php $__currentLoopData = getCountryCodes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option class="option" value="<?php echo e($option->calling_code); ?>"
                                                    data-image="<?php echo e(asset('images/flags/' . $option->flag)); ?>"
                                                    <?php if($option->calling_code == old('country_code', $sos->country_code ?? 1)): echo 'selected'; endif; ?>>
                                                    <?php echo e($option->calling_code); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-11">
                                        <input class="form-control" type="number" name="phone"
                                            value="<?php echo e(isset($sos->phone) ? $sos->phone : old('phone')); ?>"
                                            placeholder="<?php echo e(__('taxido::static.soses.enter_phone')); ?>">
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
                        <div class="form-group row">
                            <label class="col-md-2" for="zone"><?php echo e(__('taxido::static.soses.zones')); ?> <span>
                                    *</span></label>
                            <div class="col-md-10 select-label-error">
                            <span class="text-gray mt-1">
                                    <?php echo e(__('taxido::static.soses.no_zones_message')); ?>

                                    <a href="<?php echo e(@route('admin.zone.index')); ?>" class="text-primary">
                                        <b><?php echo e(__('taxido::static.here')); ?></b>
                                    </a>
                                </span>
                                <select class="form-control select-2 zone" name="zones[]"
                                    data-placeholder="<?php echo e(__('taxido::static.soses.select_zones')); ?>" multiple>
                                    <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($zone->id); ?>"
                                            <?php if(isset($sos->zones)): ?> <?php if(in_array($zone->id, $sos->zones->pluck('id')->toArray())): ?>
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
                            <label class="col-md-2" for="status"><?php echo e(__('taxido::static.status')); ?></label>
                            <div class="col-md-10">
                                <div class="editor-space">
                                    <label class="switch">
                                        <input class="form-control" type="hidden" name="status" value="0">
                                        <input class="form-check-input" type="checkbox" name="status" id=""
                                            value="1" <?php if(@$sos?->status ?? true): echo 'checked'; endif; ?>>
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
</div>
<?php $__env->startPush('scripts'); ?>
    <script>
        (function($) {
            "use strict";
            $('#sosForm').validate({
                rules: {
                    "title": "required",
                    "sos_image_id": "required",
                    "phone": {
                        "required": true,
                        "minlength": 6,
                        "maxlength": 15
                    },
                    "zones[]": "required"
                }
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/sos/fields.blade.php ENDPATH**/ ?>