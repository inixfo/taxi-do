<?php $__env->startSection('title', __('taxido::front.location')); ?>

<?php $__env->startSection('detailBox'); ?>
<div class="dashboard-details-box">
    <div class="dashboard-title">
        <h3><?php echo e(isset($location) && $location ? __('taxido::front.edit_address') : __('taxido::front.add_address')); ?></h3>
    </div>

    <form class="location-details-box" id="locationForm" action="<?php echo e(isset($location) ? route('front.cab.location.update', $location->id) : route('front.cab.location.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php if(isset($location) && $location): ?>
            <?php echo method_field('PUT'); ?>
        <?php endif; ?>
        <div class="form-box form-icon">
            <label class="form-label"><?php echo e(__('taxido::front.select_category')); ?></label>
            <ul class="radio-group-list">
                <?php $__currentLoopData = ['Home', 'Work', 'Other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <input type="radio" class="form-check-input" name="type" id="<?php echo e(strtolower($type)); ?>" value="<?php echo e($type); ?>"
                            <?php echo e((isset($location) && $location && $location->type === $type) || old('type') === $type ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="<?php echo e(strtolower($type)); ?>">
                            <span class="circle"></span>
                            <?php echo e($type); ?>

                        </label>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </ul>
        </div>
        <div class="form-box form-icon">
            <label for="title" class="form-label"><?php echo e(__('taxido::front.title')); ?></label>
            <div class="position-relative">
                <i class="ri-text"></i>
                <input type="text" class="form-control form-control-white" name="title" id="title" placeholder="<?php echo e(__('taxido::front.enter_title')); ?>"
                    value="<?php echo e(old('title', isset($location) && $location ? $location->title : '')); ?>">
                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <div class="form-box form-icon">
            <label for="location" class="form-label"><?php echo e(__('taxido::front.address')); ?></label>
            <div class="position-relative">
                <i class="ri-map-pin-line"></i>
                <input type="text" class="form-control form-control-white" id="location" name="location"
                    value="<?php echo e(old('location', isset($location) && $location ? $location->location : '')); ?>" placeholder="<?php echo e(__('taxido::front.select_address')); ?>" readonly>
                <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
        <div class="form-box form-icon">
            <label class="form-label"><?php echo e(__('taxido::static.zones.search_location')); ?></label>
            <div class="position-relative">
                <i class="ri-search-2-line"></i>
                <input id="search-box" class="form-control form-control-white" type="text" placeholder="<?php echo e(__('taxido::static.zones.search_locations')); ?>">
                <ul id="suggestions-list" class="map-location-list custom-scrollbar mt-1"></ul>
            </div>
        </div>
        <div class="form-box form-icon">
            <label class="form-label"><?php echo e(__('taxido::static.zones.map')); ?></label>
            <div>
                <div class="map-warper rounded overflow-hidden border" style="height: 400px;">
                    <div id="map-container" style="width: 100%; height: 100%;"></div>
                </div>
                <!-- Parse JSON coordinates if stored as JSON -->
                <?php
                    $coordinates = isset($location) && $location && isset($location->coordinates) ? json_decode($location->coordinates, true) : null;
                    $lat = $coordinates && isset($coordinates['lat']) ? $coordinates['lat'] : old('latitude', '');
                    $lng = $coordinates && isset($coordinates['lng']) ? $coordinates['lng'] : old('longitude', '');
                ?>
                <input type="hidden" name="latitude" id="latitude" value="<?php echo e($lat); ?>">
                <input type="hidden" name="longitude" id="longitude" value="<?php echo e($lng); ?>">
                <?php $__errorArgs = ['latitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <?php $__errorArgs = ['longitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
        <div class="modal-footer">
            <a href="<?php echo e(route('front.cab.location.index')); ?>" class="btn cancel-btn"><?php echo e(__('taxido::front.cancel')); ?></a>
            <button type="submit" class="btn gradient-bg-color spinner-btn"><?php echo e(__('taxido::front.confirm_location')); ?></button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(getTaxidoSettings()['location']['google_map_api_key'] ?? env('GOOGLE_MAP_API_KEY')); ?>&libraries=places&callback=initMap" async defer></script>
<script>
    let map, marker, searchBox;

    function initMap() {
        const latValue = document.getElementById('latitude').value;
        const lngValue = document.getElementById('longitude').value;
        console.log('Latitude:', latValue, 'Longitude:', lngValue);

        const initialLat = parseFloat(latValue) || 21.1702; // Default to Surat, India
        const initialLng = parseFloat(lngValue) || 72.8311; // Default to Surat, India
        const defaultCenter = { lat: initialLat, lng: initialLng };

        map = new google.maps.Map(document.getElementById('map-container'), {
            center: defaultCenter,
            zoom: 14,
        });

        marker = new google.maps.Marker({
            map: map,
            position: defaultCenter,
            draggable: true
        });

        updatePositionFields(marker.getPosition());

        marker.addListener('dragend', function () {
            updatePositionFields(marker.getPosition());
            geocodeLatLng(marker.getPosition());
        });

        if (latValue && lngValue) {
            geocodeLatLng(defaultCenter);
        } else if (document.getElementById('location').value) {
            geocodeAddress(document.getElementById('location').value);
        }

        setupSearchBox();
    }

    function updatePositionFields(position) {
        document.getElementById('latitude').value = position.lat().toFixed(6);
        document.getElementById('longitude').value = position.lng().toFixed(6);
    }

    function setupSearchBox() {
        const input = document.getElementById('search-box');
        const autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        autocomplete.addListener('place_changed', function () {
            const place = autocomplete.getPlace();
            if (!place.geometry) return;

            map.panTo(place.geometry.location);
            map.setZoom(15);
            marker.setPosition(place.geometry.location);
            updatePositionFields(place.geometry.location);
            document.getElementById('location').value = place.formatted_address || '';
        });
    }

    function geocodeLatLng(latlng) {
        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({ location: latlng }, (results, status) => {
            if (status === 'OK' && results[0]) {
                document.getElementById('location').value = results[0].formatted_address;
                console.log('Geocoded address:', results[0].formatted_address);
            } else {
                console.error('Geocoding failed:', status);
                document.getElementById('location').value = '';
            }
        });
    }

    function geocodeAddress(address) {
        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({ address: address }, (results, status) => {
            if (status === 'OK' && results[0]) {
                const location = results[0].geometry.location;
                map.panTo(location);
                marker.setPosition(location);
                updatePositionFields(location);
                document.getElementById('location').value = results[0].formatted_address;
                console.log('Geocoded coordinates from address:', location.lat(), location.lng());
            } else {
                console.error('Geocoding address failed:', status);
            }
        });
    }
</script>
<script>
    (function($) {
        "use strict";
        $(document).ready(function() {
            $("#locationForm").validate({
                ignore: [],
                rules: {
                    "type": "required",
                    "title": {
                        required: true
                    },
                    "location": {
                        required: true
                    },
                },
            });
        });
    })(jQuery);
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('taxido::front.account.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/front/location/create.blade.php ENDPATH**/ ?>