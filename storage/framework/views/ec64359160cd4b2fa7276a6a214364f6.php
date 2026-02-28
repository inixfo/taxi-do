<?php use \Modules\Taxido\Models\Driver; ?>
<?php use \Modules\Taxido\Models\Document; ?>
<?php use \Modules\Taxido\Enums\RoleEnum as BaseRoleEnum; ?>
<?php use \App\Enums\RoleEnum; ?>
<?php
    $drivers = Driver::where('status', true)?->get(['id', 'name']);
    $documents = Document::where('status', true)?->get();
?>
<div class="row g-xl-4 g-3">
    <div class="col-xl-10 col-xxl-8 mx-auto">
        <div class="left-part">
            <div class="contentbox">
                <div class="inside">
                    <div class="contentbox-title">
                        <h3><?php echo e(isset($driverDocument) ? __('taxido::static.driver_documents.edit') : __('taxido::static.driver_documents.add')); ?>

                        </h3>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2"
                            for="document_image_id"><?php echo e(__('taxido::static.driver_documents.document_image')); ?><span>
                                *</span></label>
                        <div class="col-md-10">
                            <div class="form-group">
                                <?php if (isset($component)) { $__componentOriginal22d447e3f5aafc93b8447b54b36ee789 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal22d447e3f5aafc93b8447b54b36ee789 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.image','data' => ['name' => 'document_image_id','data' => isset($driverDocument->document_image)
                                    ? $driverDocument?->document_image
                                    : old('document_image_id'),'multiple' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('image'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('document_image_id'),'data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($driverDocument->document_image)
                                    ? $driverDocument?->document_image
                                    : old('document_image_id')),'multiple' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal22d447e3f5aafc93b8447b54b36ee789)): ?>
<?php $attributes = $__attributesOriginal22d447e3f5aafc93b8447b54b36ee789; ?>
<?php unset($__attributesOriginal22d447e3f5aafc93b8447b54b36ee789); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal22d447e3f5aafc93b8447b54b36ee789)): ?>
<?php $component = $__componentOriginal22d447e3f5aafc93b8447b54b36ee789; ?>
<?php unset($__componentOriginal22d447e3f5aafc93b8447b54b36ee789); ?>
<?php endif; ?>
                                <?php $__errorArgs = ['document_image_id'];
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

                    <?php if(getCurrentRoleName() == RoleEnum::ADMIN): ?>
                        <div class="form-group row">
                            <label class="col-md-2" for="driver_id"><?php echo e(__('taxido::static.driver_documents.driver')); ?>

                                <span> *</span></label>
                            <div class="col-md-10 select-label-error">
                                <span class="text-gray mt-1">
                                    <?php echo e(__('taxido::static.driver_documents.add_driver_message')); ?>

                                    <a href="<?php echo e(route('admin.driver.index')); ?>" class="text-primary">
                                        <b><?php echo e(__('taxido::static.here')); ?></b>
                                    </a>
                                </span>
                                <select id="select-driver" class="form-control select-2 driver" name="driver_id"
                                    data-placeholder="<?php echo e(__('taxido::static.driver_documents.select_driver')); ?>">
                                    <option></option>
                                    <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($driver->id); ?>" sub-title="<?php echo e($driver->email); ?>"
                                            image="<?php echo e($driver->profile_image ? $driver->profile_image->original_url : asset('images/user.png')); ?>"
                                            <?php if(old('driver_id', @$driverDocument->driver_id) == $driver->id): echo 'selected'; endif; ?>>
                                            <?php echo e($driver->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['driver_id'];
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
                    <?php elseif(getCurrentRoleName() == BaseRoleEnum::DRIVER): ?>
                        <input type="hidden" name="driver_id" value="<?php echo e(getCurrentUserId()); ?>">
                    <?php endif; ?>

                    <div class="form-group row">
                        <label class="col-md-2"
                            for="document_id"><?php echo e(__('taxido::static.driver_documents.document')); ?><span>
                                *</span></label>
                        <div class="col-md-10 select-label-error">

                            <?php if(getCurrentRoleName() == RoleEnum::ADMIN): ?>
                                <span class="text-gray mt-1">
                                    <?php echo e(__('taxido::static.driver_documents.no_documents_message')); ?>

                                    <a href="<?php echo e(@route('admin.document.index')); ?>" class="text-primary">
                                        <b><?php echo e(__('taxido::static.here')); ?></b>
                                    </a>
                                </span>
                            <?php endif; ?>
                            <select class="form-control select-2 document" name="document_id"
                                data-placeholder="<?php echo e(__('taxido::static.driver_documents.select_document')); ?>">
                                <option class="option" value=""></option>
                                <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($document->id); ?>"
                                        data-need_expired_date="<?php echo e($document->need_expired_date); ?>"
                                        <?php if(@$driverDocument): ?> <?php if(old('document_id', @$driverDocument?->document_id) == $document->id): echo 'selected'; endif; ?> <?php endif; ?>>
                                        <?php echo e($document?->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['document_id'];
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

                    <div class="form-group row flatpicker-calender select-date">
                        <label class="col-md-2" for="expired_at"><?php echo e(__('Expired At')); ?></label>
                        <div class="col-md-10">
                            <?php if(isset($driverDocument) && $driverDocument->expired_at): ?>
                                <input class="form-control" id="expired_at"
                                    value="<?php echo e(\Carbon\Carbon::parse($driverDocument->expired_at)->format('m/d/Y')); ?>"
                                    name="expired_at" placeholder="Select Date.." required>
                            <?php else: ?>
                                <input class="form-control" id="expired_at" name="expired_at" placeholder="Select Date.." required>
                            <?php endif; ?>
                            <?php $__errorArgs = ['expired_at'];
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

                    <?php if(getCurrentRoleName() == RoleEnum::ADMIN): ?>
                        <div class="form-group row">
                            <label for="status" class="col-md-2">
                                <?php echo e(__('taxido::static.driver_documents.status')); ?><span>*</span>
                            </label>
                            <div class="col-md-10 select-label-error">
                                <select class="select-2 form-control" id="status" name="status"
                                    data-placeholder="<?php echo e(__('taxido::static.driver_documents.select_status')); ?>">
                                    <option class="option" value="" selected></option>
                                    <option value="pending" <?php if(old('status', @$driverDocument?->status) == 'pending'): echo 'selected'; endif; ?>>
                                        <?php echo e(__('taxido::static.driver_documents.pending')); ?>

                                    </option>
                                    <option value="approved" <?php if(old('status', @$driverDocument?->status) == 'approved'): echo 'selected'; endif; ?>>
                                        <?php echo e(__('taxido::static.driver_documents.approved')); ?>

                                    </option>
                                    <option value="rejected" <?php if(old('status', @$driverDocument?->status) == 'rejected'): echo 'selected'; endif; ?>>
                                        <?php echo e(__('taxido::static.driver_documents.rejected')); ?>

                                    </option>
                                </select>
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
                    <?php elseif(getCurrentRoleName() == BaseRoleEnum::DRIVER): ?>
                        <input type="hidden" name="status" value="pending">
                    <?php endif; ?>

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
<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/vendors/flatpickr.min.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('js/flatpickr/flatpickr.js')); ?>"></script>
    <script src="<?php echo e(asset('js/flatpickr/rangePlugin.js')); ?>"></script>
    <script>
        (function($) {
            "use strict";
            $('#driverDocumentForm').validate({
                ignore: [],
                rules: {
                    "driver_id": "required",
                    "document_id": "required",
                    "status": "required",
                    expired_at: {
                        required: function (element) {
                            let selectedOption = $('select[name="document_id"]').find(':selected');
                            let needExpiredDate = selectedOption.data('need_expired_date');
                            return needExpiredDate == 1;
                        }
                    }
                },
                messages: {
                    expired_at: {
                        required: "This document requires an expiration date."
                    }
                }
            });
            const optionFormat = (item) => {
                console.log(item)
                if (!item.id) {
                    return item.text;
                }

                var span = document.createElement('span');
                var html = '';

                html += '<div class="selected-item">';
                html += '<img src="' + item.element.getAttribute('image') +
                    '" class="rounded-circle h-30 w-30" alt="' + item.text + '"/>';
                html += '<div class="detail">'
                html += '<h6>' + item.text + '</h6>';
                html += '<p>' + item.element.getAttribute('sub-title') + '</p>';
                html += '</div>';
                html += '</div>';

                span.innerHTML = html;
                return $(span);
            }

            $('#select-driver').select2({
                placeholder: "Select an option",
                templateSelection: optionFormat,
                templateResult: optionFormat
            });

            flatpickr("#expired_at", {
                dateFormat: "m/d/Y",
                minDate: "today"
            });

        $('select[name="document_id"]').on('change', function () {
            $('#expired_at').valid();
        });

        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/driver-document/fields.blade.php ENDPATH**/ ?>