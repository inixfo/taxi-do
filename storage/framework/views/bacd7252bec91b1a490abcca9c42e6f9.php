<?php
    $settings = getTaxidoSettings();
?>

<?php $__env->startSection('title', __('taxido::static.peakZones.map_view')); ?>
<?php $__env->startSection('content'); ?>
    <div class="map-section">
        <div class="contentbox">
            <div class="inside">
                <div class="contentbox-title">
                    <div class="contentbox-subtitle">
                        <h3><?php echo e(__('taxido::static.peakZones.map_view')); ?></h3>
                    </div>
                    <div class="contentbox-right">
                        <select class="form-select" id="zone-filter">
                            <option value="all"><?php echo e(__('taxido::static.all')); ?></option>
                            <option value="active"><?php echo e(__('taxido::static.active')); ?></option>
                            <option value="inactive"><?php echo e(__('taxido::static.inactive')); ?></option>
                        </select>
                    </div>
                </div>
                <div class="map-box">
                    <div id="map" style="height: 600px;"></div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php if($settings['location']['map_provider'] == 'google_map'): ?>
    <?php if ($__env->exists('taxido::admin.peak-zone-map.google')) echo $__env->make('taxido::admin.peak-zone-map.google', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php elseif($settings['location']['map_provider'] == 'osm'): ?>
    <?php if ($__env->exists('taxido::admin.peak-zone-map.osm')) echo $__env->make('taxido::admin.peak-zone-map.osm', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/peak-zone-map/index.blade.php ENDPATH**/ ?>