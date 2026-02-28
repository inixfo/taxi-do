<?php use \Modules\Taxido\Models\VehicleType; ?>
<?php use \Modules\Taxido\Models\FleetManager; ?>
<?php use \Modules\Taxido\Enums\RoleEnum; ?>
<?php
    $vehicleTypes = VehicleType::where('status', true)?->get(['id', 'name']);
    $fleetManagers = FleetManager::where('status', true)?->get(['id', 'name', 'email']);
    $defaultFleetId = null;
    if (getCurrentRoleName() == RoleEnum::FLEET_MANAGER) {
        $defaultFleetId = getCurrentUserId();
    }
?>
<div class="row g-xl-4 g-3">
    <div class="col-xl-10 col-xxl-8 mx-auto">
        <div class="left-part">
            <div class="contentbox">
                <div class="inside">
                    <div class="contentbox-title">
                        <h3><?php echo e(isset($vehicleInfo) ? __('taxido::static.fleet_vehicles.edit') : __('taxido::static.fleet_vehicles.add')); ?>

                            (<?php echo e(request('locale', app()->getLocale())); ?>)
                        </h3>
                    </div>
                    <input type="hidden" name="locale" value="<?php echo e(request('locale')); ?>">

                    <div class="form-group row">
                        <label class="col-md-2" for="name"><?php echo e(__('taxido::static.fleet_vehicles.name')); ?><span>*</span></label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="name" id="name"
                                   value="<?php echo e(isset($vehicleInfo->name) ? $vehicleInfo->name : old('name')); ?>"
                                   placeholder="<?php echo e(__('taxido::static.fleet_vehicles.enter_name')); ?>">
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
                        <label class="col-md-2" for="fleet_manager_id"><?php echo e(__('taxido::static.fleet_vehicles.fleet_manager')); ?><span>*</span></label>
                        <div class="col-md-10 select-label-error">
                            <select class="form-control select-2" name="fleet_manager_id"
                                    data-placeholder="<?php echo e(__('taxido::static.fleet_vehicles.select_fleet_manager')); ?>">
                                <option value=""><?php echo e(__('taxido::static.fleet_vehicles.select_fleet_manager')); ?></option>
                                <?php $__currentLoopData = $fleetManagers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($fm->id); ?>"
                                        <?php if((isset($vehicleInfo) && (int)$vehicleInfo->fleet_manager_id === (int)$fm->id)
                                            || (old('fleet_manager_id') && (int)old('fleet_manager_id') === (int)$fm->id)
                                            || (!isset($vehicleInfo) && !$errors->has('fleet_manager_id') && $defaultFleetId && (int)$defaultFleetId === (int)$fm->id)): ?>
                                            selected <?php endif; ?>>
                                        <?php echo e($fm->name); ?> <?php echo e($fm->email ? '(' . (isDemoModeEnabled() ? __('taxido::static.demo_mode') : $fm->email) . ')' : ''); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['fleet_manager_id'];
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
                        <label class="col-md-2" for="vehicle_type_id"><?php echo e(__('taxido::static.fleet_vehicles.vehicle_type')); ?><span>*</span></label>
                        <div class="col-md-10 select-label-error">
                            <select class="form-control select-2" name="vehicle_type_id"
                                    data-placeholder="<?php echo e(__('taxido::static.fleet_vehicles.select_vehicle_type')); ?>">
                                <option value=""><?php echo e(__('taxido::static.fleet_vehicles.select_vehicle_type')); ?></option>
                                <?php $__currentLoopData = $vehicleTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($type->id); ?>"
                                        <?php if((isset($vehicleInfo) && $vehicleInfo->vehicle_type_id == $type->id) || old('vehicle_type_id') == $type->id): ?> selected <?php endif; ?>>
                                        <?php echo e($type->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['vehicle_type_id'];
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
                        <label class="col-md-2" for="plate_number"><?php echo e(__('taxido::static.fleet_vehicles.plate_number')); ?><span>*</span></label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="plate_number" id="plate_number"
                                   value="<?php echo e(isset($vehicleInfo->plate_number) ? $vehicleInfo->plate_number : old('plate_number')); ?>"
                                   placeholder="<?php echo e(__('taxido::static.fleet_vehicles.enter_plate_number')); ?>">
                            <?php $__errorArgs = ['plate_number'];
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
                        <label class="col-md-2" for="color"><?php echo e(__('taxido::static.fleet_vehicles.color')); ?></label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="color" id="color"
                                   value="<?php echo e(isset($vehicleInfo->color) ? $vehicleInfo->color : old('color')); ?>"
                                   placeholder="<?php echo e(__('taxido::static.fleet_vehicles.enter_color')); ?>">
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
                        <label class="col-md-2" for="model"><?php echo e(__('taxido::static.fleet_vehicles.model')); ?></label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="model" id="model"
                                   value="<?php echo e(isset($vehicleInfo->model) ? $vehicleInfo->model : old('model')); ?>"
                                   placeholder="<?php echo e(__('taxido::static.fleet_vehicles.enter_model')); ?>">
                            <?php $__errorArgs = ['model'];
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
                        <label class="col-md-2" for="model_year"><?php echo e(__('taxido::static.fleet_vehicles.model_year')); ?></label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="model_year" id="model_year"
                                   value="<?php echo e(isset($vehicleInfo->model_year) ? $vehicleInfo->model_year : old('model_year')); ?>"
                                   placeholder="<?php echo e(__('taxido::static.fleet_vehicles.enter_model_year')); ?>">
                            <?php $__errorArgs = ['model_year'];
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


<?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/vehicle-info/fields.blade.php ENDPATH**/ ?>