<?php use \Modules\Taxido\Enums\ServiceCategoryEnum; ?>
<?php use \Modules\Taxido\Enums\ServicesEnum; ?>
<?php use \Modules\Taxido\Enums\RideStatusEnum; ?>
<?php
    $settings = getTaxidoSettings();
    $ridestatuscolorClasses = getRideStatusColorClasses();
    $rideLocationCoordinates = $ride->location_coordinates ?? [];
    $sosLocationCoordinates = $sosAlert->location_coordinates ?? [];
?>

<?php $__env->startSection('title', __('taxido::static.soses.sos_details')); ?>
<?php $__env->startSection('content'); ?>
<div class="row ride-dashboard">
    <div class="col-12">
        <div class="default-sorting mt-0">
            <div class="welcome-box">
                <div class="d-flex justify-content-between align-items-center">
                    <h2><?php echo e(__('taxido::static.soses.sos_details')); ?></h2>
                    <div class="sos-status">
                        <form action="<?php echo e(route('admin.sos-alerts.update-status', $sosAlert->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="requested" <?php echo e($sosAlert?->status?->slug == 'requested' ? 'selected' : ''); ?>>Requested</option>
                                <option value="processing" <?php echo e($sosAlert?->status?->slug == 'processing' ? 'selected' : ''); ?>>Processing</option>
                                <option value="completed" <?php echo e($sosAlert?->status?->slug == 'completed' ? 'selected' : ''); ?>>Completed</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if($ride): ?>
        <div class="col-xxl-6">
            <div class="card">
                <div class="card-header card-no-border">
                    <div class="header-top">
                        <h5 class="m-0"><?php echo e(__('taxido::static.rides.general_detail')); ?></h5>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <ul class="ride-details-list">
                        <li>
                            <?php echo e(__('taxido::static.rides.ride_id')); ?>: <span class="bg-light-primary">#<?php echo e($ride?->ride_number); ?></span>
                        </li>
                        <?php if($ride?->start_time): ?>
                            <li>
                                <?php echo e(__('taxido::static.rides.start_date_time')); ?>: 
                                <span><?php echo e($ride?->start_time->format('Y-m-d H:i:s A')); ?></span>
                            </li>
                        <?php endif; ?>
                        <?php if(in_array($ride?->service_category?->slug, [ServiceCategoryEnum::PACKAGE, ServiceCategoryEnum::RENTAL])): ?>
                            <li>
                                <?php echo e(__('taxido::static.rides.end_date_time')); ?>: 
                                <span><?php echo e($ride->end_time?->format('Y-m-d H:i:s A')); ?></span>
                            </li>
                        <?php endif; ?>
                        <li>
                            <?php echo e(__('taxido::static.rides.ride_status')); ?>: 
                            <span class="badge badge-<?php echo e($ridestatuscolorClasses[ucfirst($ride?->ride_status?->name)]); ?>">
                                <?php echo e(ucfirst($ride?->ride_status?->name)); ?>

                            </span>
                        </li>
                        <li>
                            <?php echo e(__('taxido::static.rides.service')); ?>: <span><?php echo e($ride?->service?->name); ?></span>
                        </li>
                        <li>
                            <?php echo e(__('taxido::static.rides.service_category')); ?>: <span><?php echo e($ride?->service_category?->name); ?></span>
                        </li>
                        <li>
                            <?php echo e(__('taxido::static.rides.otp')); ?>: <span><?php echo e($ride?->otp); ?></span>
                        </li>
                        <?php if(in_array($ride?->service?->slug, [ServicesEnum::PARCEL])): ?>
                            <li>
                                <?php echo e(__('taxido::static.rides.parcel_otp')); ?>: <span><?php echo e($ride?->parcel_delivered_otp); ?></span>
                            </li>
                            <li>
                                <?php echo e(__('taxido::static.rides.weight')); ?>: <span><?php echo e($ride?->weight); ?></span>
                            </li>
                        <?php endif; ?>
                        <?php if(!in_array($ride?->service_category?->slug, [ServiceCategoryEnum::RENTAL])): ?>
                            <li>
                                <?php echo e(__('taxido::static.rides.ride_distance')); ?>: 
                                <span><?php echo e($ride?->distance); ?> <?php echo e($ride?->distance_unit); ?></span>
                            </li>
                        <?php endif; ?>
                        <li>
                            <?php echo e(__('taxido::static.rides.zone')); ?>: 
                            <span><?php echo e($ride?->zones?->pluck('name')->implode(', ') ?? 'N/A'); ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="col-xxl-6">
        <div class="card">
            <div class="card-header card-no-border">
                <div class="header-top">
                    <h5 class="m-0"><?php echo e(__('taxido::static.soses.sos_details')); ?></h5>
                </div>
            </div>
            <div class="card-body pt-0">
                <ul class="ride-details-list">          
                    <li>
                        <?php echo e(__('taxido::static.soses.status')); ?>: 
                        <span class="badge badge-<?php echo e($sosAlert->status?->slug == 'completed' ? 'success' : ($sosAlert->status?->slug == 'processing' ? 'warning' : 'danger')); ?>">
                            <?php echo e(ucfirst($sosAlert?->status?->name )); ?>

                        </span>
                    </li>
                    <li>
                        <?php echo e(__('taxido::static.soses.alert_time')); ?>: 
                        <span><?php echo e($sosAlert->created_at->format('Y-m-d H:i:s A')); ?></span>
                    </li>
                    <li>
                        <?php echo e(__('taxido::static.soses.created_by')); ?>: 
                        <span><?php echo e(($sosAlert->created_by?->name ?? 'N/A')); ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-xxl-12">
        <div class="card">
            <div class="card-header card-no-border">
                <div class="header-top">
                    <h5 class="m-0"><?php echo e(__('taxido::static.soses.location_map')); ?></h5>
                </div>
            </div>
            <div class="card-body pt-0">
                <div id="map-view" style="height: 500px; width: 100%;"></div>
                <?php if($settings['location']['map_provider'] == 'google_map'): ?>
                    <?php echo $__env->make('taxido::admin.sos-alert.google', ['rideLocationCoordinates' => $rideLocationCoordinates, 'sosLocationCoordinates' => $sosLocationCoordinates], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php elseif($settings['location']['map_provider'] == 'osm'): ?>
                    <?php echo $__env->make('taxido::admin.sos-alert.osm', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/sos-alert/show.blade.php ENDPATH**/ ?>