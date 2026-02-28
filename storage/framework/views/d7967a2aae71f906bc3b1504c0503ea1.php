<?php use \App\Enums\PaymentMethod; ?>
<?php
    $settings = getTaxidoSettings();
?>
<div class="col-12">
    <div class="row g-xl-4 g-3">
        <div class="col-xl-12">
            <div class="left-part">
                <div class="contentbox">
                    <div class="inside">
                        <div class="contentbox-title">
                            <h3>
                                <?php echo e(isset($peakZone) ? __('taxido::static.peakZones.edit') : __('taxido::static.peakZones.add')); ?>

                                (<?php echo e(request('locale', app()->getLocale())); ?>)
                            </h3>
                        </div>
                        <?php if(isset($peakZone)): ?>
                            <div class="form-group row">
                                <label class="col-md-2" for="name"><?php echo e(__('taxido::static.language.languages')); ?></label>
                                <div class="col-md-10">
                                    <ul class="language-list">
                                        <?php $__empty_1 = true; $__currentLoopData = getLanguages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <li>
                                                <a href="<?php echo e(route('admin.zone.edit', ['zone' => $peakZone->id, 'locale' => $lang->locale])); ?>"
                                                    class="language-switcher <?php echo e(request('locale') === $lang->locale ? 'active' : ''); ?>"
                                                    target="_blank">
                                                    <img src="<?php echo e(@$lang?->flag ?? asset('admin/images/No-image-found.jpg')); ?>"
                                                        alt="">
                                                    <?php echo e(@$lang?->name); ?> (<?php echo e(@$lang?->locale); ?>)
                                                    <i class="ri-arrow-right-up-line"></i>
                                                </a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <li>
                                                <a href="<?php echo e(route('admin.zone.edit', ['zone' => $peakZone->id, 'locale' => Session::get('locale', 'en')])); ?>"
                                                    class="language-switcher active" target="blank">
                                                    <img src="<?php echo e(asset('admin/images/flags/LR.png')); ?>" alt="">
                                                    English
                                                    <i class="ri-arrow-right-up-line"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>
                        <input type="hidden" name="locale" value="<?php echo e(request('locale')); ?>">
                        <div class="form-group row">
                            <label class="col-md-2" for="name"><?php echo e(__('taxido::static.peakZones.name')); ?><span>*</span></label>
                            <div class="col-md-10">
                                    <input class="form-control" type="text" id="name" name="name"
                                        placeholder="<?php echo e(__('taxido::static.peakZones.enter_name')); ?> (<?php echo e(request('locale', app()->getLocale())); ?>)"
                                        value="<?php echo e(isset($peakZone->name) ? $peakZone->name : old('name')); ?>">
                                    <i class="ri-file-copy-line copy-icon" data-target="#name"></i>
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

                        <!-- Place Point, Search & Map -->
                        <div class="form-group row">
                            <label class="col-md-2"
                                for="place_points"><?php echo e(__('taxido::static.peakZones.place_points')); ?><span>
                                    *</span></label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" id="place_points" name="place_points"
                                    placeholder="<?php echo e(__('taxido::static.peakZones.select_place_points')); ?>"
                                    value="<?php echo e(isset($peakZone->locations) ? json_encode($peakZone->locations, true) : old('place_points')); ?>"
                                    readonly>
                                <?php $__errorArgs = ['place_points'];
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
                                for="search-box"><?php echo e(__('taxido::static.peakZones.search_location')); ?></label>
                            <div class="col-md-10">
                                <input id="search-box" class="form-control" type="text"
                                    placeholder="<?php echo e(__('taxido::static.peakZones.search_locations')); ?>">
                                <ul id="suggestions-list" class="map-location-list custom-scrollbar"></ul>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2" for="map"><?php echo e(__('taxido::static.peakZones.map')); ?></label>
                            <div class="col-md-10">
                                <div class="map-warper dark-support rounded overflow-hidden">
                                    <div class="map-container" id="map-container"></div>
                                </div>
                                <div id="coords"></div>
                            </div>
                        </div>



                        <div class="form-group row">
                            <label class="col-md-2" for="status"><?php echo e(__('taxido::static.status')); ?></label>
                            <div class="col-md-10">
                                <div class="editor-space">
                                    <label class="switch">
                                        <?php if(isset($peakZone)): ?>
                                            <input class="form-control" type="hidden" name="is_active"
                                                value="0">
                                            <input class="form-check-input" type="checkbox" name="is_active"
                                                id="" value="1" <?php echo e($peakZone->is_active ? 'checked' : ''); ?>>
                                        <?php else: ?>
                                            <input class="form-control" type="hidden" name="is_active"
                                                value="0">
                                            <input class="form-check-input" type="checkbox" name="is_active"
                                                id="" value="1" checked>
                                        <?php endif; ?>
                                        <span class="switch-state"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <div class="submit-btn">
                                    <button type="button" id="saveBtn" name="save" class="btn btn-primary spinner-btn">
                                        <i class="ri-save-line text-white lh-1"></i> <?php echo e(__('taxido::static.save')); ?>

                                    </button>
                                    <button type="button" id="saveExitBtn" name="save_and_exit" class="btn btn-primary spinner-btn">
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

<?php if($settings['location']['map_provider'] == 'google_map'): ?>
    <?php if ($__env->exists('taxido::admin.peak-zone.google')) echo $__env->make('taxido::admin.peak-zone.google', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php elseif($settings['location']['map_provider'] == 'osm'): ?>
    <?php if ($__env->exists('taxido::admin.peak-zone.osm')) echo $__env->make('taxido::admin.peak-zone.osm', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        (function($) {
            "use strict";
            $('#peakZoneForm').validate({
                rules: {
                    "name": "required",
                    "place_points": "required",
                }
            });
        })(jQuery);
        $('#saveBtn,#saveExitBtn').click(function(e) {
            e.preventDefault();
            if ($("#peakZoneForm").valid()) {
                $("#peakZoneForm").submit();
            }
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/peak-zone/fields.blade.php ENDPATH**/ ?>