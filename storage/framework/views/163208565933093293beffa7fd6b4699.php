<div class="row g-xl-4 g-3">
    <div class="col-xl-10 col-xxl-8 mx-auto">
        <div class="left-part">
            <div class="contentbox">
                <div class="inside">
                    <div class="contentbox-title">
                        <h3><?php echo e(isset($surgePrice) ? __('taxido::static.surge_prices.edit') : __('taxido::static.surge_prices.add')); ?>

                        </h3>
                    </div>
                    <div class="row g-4">
                        <div class="col-xxl-6">
                            <div class="form-group row">
                                <label class="col-md-5" for="start_time"><?php echo e(__('taxido::static.surge_prices.start_time')); ?><span>*</span></label>
                                <div class="col-md-7">
                                    <div id="start-time" class="surge-timer">
                                        <input type="text" class="form-control flatpickr-time h-auto" name="start_time"
                                            id="start_time"
                                            value="<?php echo e(isset($surgePrice->start_time) ? \Carbon\Carbon::parse($surgePrice->start_time)->format('H:i') : now()->format('H:i')); ?>"
                                            placeholder="Select Start Time" required>
                                        <?php $__errorArgs = ['start_time'];
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
                        </div>
                        <div class="col-xxl-6">
                            <div class="form-group row">
                                <label class="col-md-5" for="end_time"><?php echo e(__('taxido::static.surge_prices.end_time')); ?><span>*</span></label>
                                <div class="col-md-7">
                                    <div id="end-time" class="surge-timer">
                                        <input type="text" class="form-control flatpickr-time h-auto" name="end_time"
                                            id="end_time"
                                            value="<?php echo e(isset($surgePrice->end_time) ? \Carbon\Carbon::parse($surgePrice->end_time)->format('H:i') : now()->addHour()->format('H:i')); ?>"
                                            placeholder="Select End Time" required>
                                        <?php $__errorArgs = ['end_time'];
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
                        </div>

                        <div class="col-12">
                        <div class="form-group row">
                            <label class="col-md-2"
                                for="day"><?php echo e(__('taxido::static.surge_prices.day')); ?><span> *</span></label>
                            <div class="col-md-10 select-label-error">
                                <select class="select-2 form-control" id="day" name="day"
                                    data-placeholder="<?php echo e(__('taxido::static.surge_prices.select_day')); ?>">
                                    <option class="select-placeholder" value=""></option>
                                    <?php $__currentLoopData = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($day); ?>"
                                                <?php echo e(old('day', $surgePrice->day ?? '') == $day ? 'selected' : ''); ?>>
                                                <?php echo e($day); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['day'];
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

                        <div class="col-12">
                            <div class="form-group row">
                                <label class="col-md-2" for="status"><?php echo e(__('taxido::static.status')); ?></label>
                                <div class="col-md-10">
                                    <div class="editor-space">
                                        <label class="switch">
                                            <?php if(isset($surgePrice)): ?>
                                                <input class="form-control" type="hidden" name="status"
                                                    value="0">
                                                <input class="form-check-input" type="checkbox" name="status" id="" value="1" <?php echo e($surgePrice->status ? 'checked' : ''); ?>>
                                            <?php else: ?>
                                                <input class="form-control" type="hidden" name="status"
                                                    value="0">
                                                <input class="form-check-input" type="checkbox" name="status"
                                                    id="" value="1" checked>
                                            <?php endif; ?>
                                            <span class="switch-state"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="submit-btn">
                                        <button type="button" id="saveBtn" name="save"
                                            class="btn btn-primary spinner-btn">
                                            <i class="ri-save-line text-white lh-1"></i>
                                            <?php echo e(__('taxido::static.save')); ?>

                                        </button>
                                        <button type="button" id="saveExitBtn" name="save_and_exit"
                                            class="btn btn-primary spinner-btn">
                                            <i class="ri-expand-left-line text-white lh-1"></i><?php echo e(__('taxido::static.save_and_exit')); ?>

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

            $('#surgePriceForm').validate({
                ignore: [],
                rules: {
                    "start_time": "required",
                    "end_time": "required",
                    "price": {
                        required: true,
                        number: true,
                        min: 0
                    },
                    "day": "required"
                }
            });

            flatpickr("#start_time", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
                static: true,
                appendTo: document.getElementById("start-time"),
            });

            flatpickr("#end_time", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
                static: true,
                appendTo: document.getElementById("end-time"),
            });

        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/surge-price/fields.blade.php ENDPATH**/ ?>