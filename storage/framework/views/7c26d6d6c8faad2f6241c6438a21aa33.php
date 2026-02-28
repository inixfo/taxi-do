<?php use \Modules\Taxido\Models\Zone; ?>
<?php use \Modules\Taxido\Models\Ride; ?>
<?php
    $settings = getTaxidoSettings();
    $vehicleTypes = getVehicleType();
    $activeTab = 'all';
    $ride = Ride::latest()->first();
?>


<?php $__env->startSection('title', __('taxido::static.drivers.driver_location')); ?>
<?php $__env->startSection('content'); ?>
    <div class="search-box">
        <div class="row g-0">
            <div class="custom-col-xxl-3 custom-col-lg-4">
                <button class="btn toggle-menu">
                    <i class="ri-menu-2-line"></i>
                </button>
                <div class="left-location-box custom-scrollbar">
                    <div class="title">
                        <h4><?php echo e(__('taxido::static.locations.taxi_drivers')); ?></h4>
                        <button class="location-close-btn btn d-xl-none">
                            <i class="ri-close-line"></i>
                        </button>
                    </div>
                    <div class="search-input">
                        <div class="position-relative w-100">
                            <input type="search" id="driver-search"
                                placeholder="<?php echo e(__('taxido::static.locations.search_driver')); ?>" class="form-control">
                            <i class="ri-search-line"></i>
                        </div>
                    </div>

                    <ul class="nav nav-tabs driver-tabs custom-scrollbar" id="myTab">
                        <li class="nav-item">
                            <button class="nav-link <?php echo e($activeTab == 'all' ? 'active' : ''); ?>" id="all-tab"
                                data-bs-toggle="tab" data-bs-target="#all-pane">
                                <?php echo e(__('taxido::static.locations.all')); ?> <span class="driver-count"
                                    id="all-count">(0)</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link <?php echo e($activeTab == 'onride' ? 'active' : ''); ?>" id="onride-tab"
                                data-bs-toggle="tab" data-bs-target="#onride-pane">
                                <?php echo e(__('taxido::static.locations.onride')); ?> <span class="driver-count"
                                    id="onride-count">(0)</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link <?php echo e($activeTab == 'online' ? 'active' : ''); ?>" id="online-tab"
                                data-bs-toggle="tab" data-bs-target="#online-pane">
                                <?php echo e(__('taxido::static.locations.online')); ?> <span class="driver-count"
                                    id="online-count">(0)</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="offline-tab" data-bs-toggle="tab" data-bs-target="#offline-pane">
                                <?php echo e(__('taxido::static.locations.offline')); ?> <span class="driver-count"
                                    id="offline-count">(0)</span>
                            </button>
                        </li>
                    </ul>
                    <div id="no-data-message" class="no-data">
                        <img src="<?php echo e(asset('images/no-data.png')); ?>" alt="no-data" loading="lazy">
                        <h6 class="mt-2"><?php echo e(__('taxido::static.drivers.no_driver_found')); ?></h6>
                    </div>
                    <div class="tab-content driver-content" id="myTabContent">

                        <div class="tab-pane fade <?php echo e($activeTab == 'all' ? 'show active' : ''); ?>" id="all-pane">
                            <div class="accordion location-accordion" id="driver-list-all">
                            </div>
                        </div>

                        <div class="tab-pane fade <?php echo e($activeTab == 'onride' ? 'show active' : ''); ?>" id="onride-pane">
                            <div class="accordion location-accordion" id="driver-list-onride">
                            </div>
                        </div>

                        <div class="tab-pane fade <?php echo e($activeTab == 'online' ? 'show active' : ''); ?>" id="online-pane">
                            <div class="accordion location-accordion" id="driver-list-online">
                            </div>
                        </div>

                        <div class="tab-pane fade" id="offline-pane">
                            <div class="accordion location-accordion" id="driver-list-offline">
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="custom-col-xxl-9 custom-col-lg-8">
                <div class="location-map">
                    <div id="map_canvas"></div>
                    <div class="location-top-select">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne"><?php echo e(__('taxido::static.vehicle_types.vehicle')); ?></button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <ul class="driver-category-box" id="vehicle-type-list">
                                            <?php if($vehicleTypes->isEmpty()): ?>
                                                <div class="no-data" id="no-vehicle-types">
                                                    <img src="<?php echo e(asset('images/no-data.png')); ?>" alt="no-data"
                                                        loading="lazy">
                                                    <h6 class="mt-2">
                                                        <?php echo e(__('taxido::static.vehicle_types.no_vehicle_types_found')); ?>

                                                    </h6>
                                                </div>
                                            <?php else: ?>
                                                <li class="category-input">
                                                    <input class="form-control" type="text" id="vehicle-type-search"
                                                        placeholder="<?php echo e(__('taxido::static.vehicle_types.search_vehicle_types')); ?>"
                                                        onkeyup="filterVehicleTypes()">
                                                </li>
                                                <?php $__currentLoopData = $vehicleTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicleType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li class="vehicle-list"
                                                        data-name="<?php echo e(strtolower($vehicleType['name'])); ?>">
                                                        <div class="form-check">
                                                            <input class="form-check-input vehicle-filter" type="checkbox"
                                                                value="<?php echo e($vehicleType['id']); ?>"
                                                                id="vehicle-<?php echo e($vehicleType['id']); ?>">
                                                            <label for="vehicle-<?php echo e($vehicleType['id']); ?>">
                                                                <img src="<?php echo e($vehicleType['image']); ?>"
                                                                    alt="<?php echo e($vehicleType['name']); ?> image"
                                                                    class="vehicle-icon img-fluid">
                                                                <?php echo e($vehicleType['name']); ?>

                                                            </label>
                                                        </div>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php if($settings['location']['map_provider'] == 'google_map'): ?>
    <?php if ($__env->exists('taxido::admin.driver-location.google')) echo $__env->make('taxido::admin.driver-location.google', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php elseif($settings['location']['map_provider'] == 'osm'): ?>
    <?php if ($__env->exists('taxido::admin.driver-location.osm')) echo $__env->make('taxido::admin.driver-location.osm', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(".select-ride-btn").click(function() {
            $(".driver-category-box").addClass("show");
        });
       
        $(".location-close-btn").click(function() {
            $(".driver-category-box").removeClass("show");
        });

        $(".toggle-menu").on("click", function () {
            $(".left-location-box").toggleClass("show");
        });

        // Close sidebar on close button click
        $(".location-close-btn").on("click", function () {
            $(".left-location-box").removeClass("show");
        });

        // Search functionality
        document.getElementById('driver-search').addEventListener('input', function(e) {
            const searchQuery = e.target.value?.toLowerCase();
            const allDrivers = document.querySelectorAll('.driver-item');
            let foundDriver = false;

            allDrivers.forEach(function(driverItem) {
                const driverName = driverItem.querySelector('.name').textContent.toLowerCase();
                if (driverName.includes(searchQuery)) {
                    driverItem.style.display = 'block';
                    foundDriver = true;
                } else {
                    driverItem.style.display = 'none';
                }
            });

            document.getElementById('no-data-message').style.display = foundDriver ? 'none' : 'flex';
        });

        // Vehicle type filter
        function filterVehicleTypes() {
            const searchTerm = document.getElementById("vehicle-type-search").value.toLowerCase();
            const vehicleLists = document.querySelectorAll("#vehicle-type-list .vehicle-list");
            vehicleLists.forEach(function(listItem) {
                const vehicleName = listItem.getAttribute("data-name");
                listItem.style.display = vehicleName.includes(searchTerm) ? "block" : "none";
            });
        }

        // Initialize Bootstrap tooltips
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/driver-location/index.blade.php ENDPATH**/ ?>