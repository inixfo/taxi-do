<?php $__env->startSection('title', __('taxido::static.reports.ride_reports')); ?>
<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/vendors/flatpickr.min.css')); ?>">
<?php $__env->stopPush(); ?>
<?php use \App\Enums\PaymentStatus; ?>
<?php
    $drivers = getAllVerifiedDrivers();
    $riders = getAllRiders();
    $rideStatus = getRideStatus();
    $PaymentMethodList = getPaymentMethodList();
    $paymentStatus = PaymentStatus::ALL;
    $zones = getAllZones();
    $services = getAllServices();
    $serviceCategories = getAllServices();
    $vehicleTypes = getAllVehicleTypes();
    $paymentMethodColorClasses = getPaymentStatusColorClasses();
?>
<?php $__env->startSection('content'); ?>
<div class="category-main">
    <form id="filterForm" method="POST" action="<?php echo e(route('admin.ride-report.export')); ?>" enctype="multipart/form-data">
        <?php echo method_field('POST'); ?>
        <?php echo csrf_field(); ?>
        <div class="row g-4">
            <div class="col-xl-3">
                <div class="p-sticky">
                    <div class="contentbox">
                        <div class="inside">
                            <div class="contentbox-title">
                                <h3><?php echo e(__('taxido::static.reports.filter')); ?></h3>
                            </div>
                            <div class="rider-height custom-scrollbar">
                                <div class="form-group">
                                    <label for="driver"><?php echo e(__('taxido::static.reports.driver')); ?></label>
                                    <select class="select-2 form-control filter-dropdown disable-all" id="driver"
                                        name="driver[]" multiple
                                        data-placeholder="<?php echo e(__('taxido::static.reports.select_driver')); ?>">
                                        <option value="all"><?php echo e(__('taxido::static.reports.all')); ?></option>
                                        <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($driver->id); ?>" sub-title="<?php echo e($driver->email); ?>"
                                                image="<?php echo e($driver?->profile_image?->original_url); ?>">
                                                <?php echo e($driver->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="user"><?php echo e(__('taxido::static.reports.user')); ?></label>
                                    <select class="select-2 form-control filter-dropdown disable-all" id="user"
                                        name="user[]" multiple
                                        data-placeholder="<?php echo e(__('taxido::static.reports.select_user')); ?>">
                                        <option value="all"><?php echo e(__('taxido::static.reports.all')); ?></option>
                                        <?php $__currentLoopData = $riders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($rider->id); ?>" sub-title="<?php echo e($rider->email); ?>"
                                                image="<?php echo e($rider?->profile_image?->original_url); ?>">
                                                <?php echo e($rider->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="ride_status"><?php echo e(__('taxido::static.reports.ride_status')); ?></label>
                                    <select class="select-2 form-control filter-dropdown disable-all" id="ride_status"
                                        name="ride_status[]" multiple
                                        data-placeholder="<?php echo e(__('taxido::static.reports.select_ride_status')); ?>">
                                        <option value="all"><?php echo e(__('taxido::static.reports.all')); ?></option>
                                        <?php $__currentLoopData = $rideStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($status->id); ?>"><?php echo e($status->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label
                                        for="payment_status"><?php echo e(__('taxido::static.reports.payment_status')); ?></label>
                                    <select class="select-2 form-control filter-dropdown disable-all"
                                        id="payment_status" name="payment_status[]" multiple
                                        data-placeholder="<?php echo e(__('taxido::static.reports.select_payment_status')); ?>">
                                        <option value="all"><?php echo e(__('taxido::static.reports.all')); ?></option>
                                        <?php $__currentLoopData = $paymentStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($status); ?>"><?php echo e($status); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="start_end_date"><?php echo e(__('taxido::static.reports.select_date')); ?></label>
                                    <input type="text" class="form-control" id="start_end_date" name="start_end_date"
                                        placeholder="<?php echo e(__('taxido::static.reports.select_date')); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="zone"><?php echo e(__('taxido::static.reports.zone')); ?></label>
                                    <select class="select-2 form-control filter-dropdown disable-all" id="zone"
                                        name="zone[]" multiple
                                        data-placeholder="<?php echo e(__('taxido::static.reports.select_zone')); ?>">
                                        <option value="all"><?php echo e(__('taxido::static.reports.all')); ?></option>
                                        <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($zone->id); ?>">
                                                <?php echo e($zone->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="service"><?php echo e(__('taxido::static.reports.service')); ?></label>
                                    <select class="select-2 form-control filter-dropdown disable-all" id="service"
                                        name="service[]" multiple
                                        data-placeholder="<?php echo e(__('taxido::static.reports.select_service')); ?>">
                                        <option value="all"><?php echo e(__('taxido::static.reports.all')); ?></option>
                                        <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($service->id); ?>"
                                                image="<?php echo e($service?->service_image?->original_url); ?>">
                                                <?php echo e($service->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label
                                        for="service_category"><?php echo e(__('taxido::static.reports.service_category')); ?></label>
                                    <select class="select-2 form-control filter-dropdown disable-all"
                                        id="service_category[]" name="service_category[]" multiple
                                        data-placeholder="<?php echo e(__('taxido::static.reports.select_service_category')); ?>">
                                        <option value="all"><?php echo e(__('taxido::static.reports.all')); ?></option>
                                        <?php $__empty_1 = true; $__currentLoopData = $serviceCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $serviceCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <option value="<?php echo e($serviceCategory->id); ?>"
                                                image="<?php echo e($serviceCategory?->service_category_image?->original_url); ?>">
                                                <?php echo e($serviceCategory->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="vehicle_type"><?php echo e(__('taxido::static.reports.vehicle_type')); ?></label>
                                    <select class="select-2 form-control filter-dropdown disable-all"
                                        id="vehicle_type[]" name="vehicle_type[]" multiple
                                        data-placeholder="<?php echo e(__('taxido::static.reports.select_vehicle_type')); ?>">
                                        <option value="all"><?php echo e(__('taxido::static.reports.all')); ?></option>
                                        <?php $__empty_1 = true; $__currentLoopData = $vehicleTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicleType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <option value="<?php echo e($vehicleType->id); ?>"
                                                image="<?php echo e($vehicleType?->vehicle_image?->original_url); ?>">
                                                <?php echo e($vehicleType->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9">
                <div class="contentbox">
                    <div class="inside">
                        <div class="contentbox-title">
                            <h3><?php echo e(__('taxido::static.reports.ride_reports')); ?></h3>
                            <button type="button" class="btn btn-outline" data-bs-toggle="modal"
                                data-bs-target="#reportExportModal">
                                <?php echo e(__('taxido::static.reports.export')); ?>

                            </button>
                        </div>

                        <div class="ride-report-table">
                            <div class="col">
                                <div class="table-main template-table m-0 loader-table">

                                    <div class="table-responsive custom-scrollbar m-0">
                                        <table class="table" id="rideTable">
                                            <thead>
                                                <tr>
                                                    <th><?php echo e(__('taxido::static.reports.ride_number')); ?></th>
                                                    <th><?php echo e(__('taxido::static.reports.driver')); ?></th>
                                                    <th><?php echo e(__('taxido::static.reports.user')); ?></th>
                                                    <th><?php echo e(__('taxido::static.reports.ride_status')); ?></th>
                                                    <th><?php echo e(__('taxido::static.reports.payment_method')); ?></th>
                                                    <th><?php echo e(__('taxido::static.reports.payment_status')); ?></th>
                                                    <th><?php echo e(__('taxido::static.reports.service')); ?></th>
                                                    <th><?php echo e(__('taxido::static.reports.service_category')); ?></th>
                                                    <th><?php echo e(__('taxido::static.reports.vehicle_type')); ?></th>
                                                    <th><?php echo e(__('taxido::static.reports.amount')); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <div class="report-loader-wrapper" style="display:none;">
                                                    <div class="loader"></div>
                                                </div>
                                            </tbody>
                                        </table>
                                        <nav>
                                            <ul class="pagination justify-content-center mt-0 mb-3"
                                                id="report-pagination">
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="reportExportModal" tabindex="-1" aria-labelledby="reportExportModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exportModalLabel"><?php echo e(__('taxido::static.modal.export_data')); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body export-data">
                        <div class="main-img">
                            <img src="<?php echo e(asset('images/export.svg')); ?>" />
                        </div>
                        <div class="form-group">
                            <label for="exportFormat"><?php echo e(__('taxido::static.modal.select_export_format')); ?></label>
                            <select id="exportFormat" name="format" class="form-select">
                                <option value="csv"><?php echo e(__('taxido::static.modal.csv')); ?></option>

                                <option value="excel"><?php echo e(__('taxido::static.modal.excel')); ?></option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-end modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">
                                <?php echo e(__('taxido::static.modal.close')); ?>

                            </button>
                            <button type="submit" class="btn btn-primary">
                                <?php echo e(__('taxido::static.modal.export')); ?>

                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>

    <script src="<?php echo e(asset('js/flatpickr/flatpickr.js')); ?>"></script>
    <script src="<?php echo e(asset('js/flatpickr/rangePlugin.js')); ?>"></script>
    
    <script>
        $(document).ready(function () {

            fetchRideReportTable(page = 1);

            $('.filter-dropdown').change(function () {
                fetchRideReportTable();
            })

            $('#filterForm').on('submit', function () {
                setTimeout(function () {
                    $('.spinner-btn').prop('disabled', false);
                    $('.spinner-btn .spinner').remove();

                    var modal = bootstrap.Modal.getInstance($('#reportExportModal')[0]);
                    modal.hide();

                }, 3000);
            });

            function fetchRideReportTable(page = 1) {
                $('.report-loader-wrapper').show()
                let formData = $('#filterForm').serialize();
                formData += '&page=' + page;
                var $csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '<?php echo e(route('admin.ride-report.filter')); ?>',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $csrfToken
                    },
                    success: function (response) {
                        $('#rideTable tbody').html(response.rideReportTable);

                        $('.pagination').html(response.pagination);
                    },
                    complete: function () {
                        $('.report-loader-wrapper').hide();
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                    }
                });
            }

            $(document).on('click', '#report-pagination a', function (e) {
                e.preventDefault();
                const url = $(this).attr('href');
                const page = new URLSearchParams(url.split('?')[1]).get('page');

                fetchRideReportTable(page);
            });

            $('.disable-all').on('change', function () {
                const $currentSelect = $(this);
                const selectedValues = $currentSelect.val();
                const allOption = "all";

                if (selectedValues && selectedValues.includes(allOption)) {

                    $currentSelect.val([allOption]);
                    $currentSelect.find('option').not(`[value="${allOption}"]`).prop('disabled', true);
                } else {

                    $currentSelect.find('option').prop('disabled', false);
                }
                $currentSelect.select2('destroy').select2({
                    placeholder: $currentSelect.data('placeholder'),
                    width: '100%'
                });
            });

            $('.disable-all').select2({
                placeholder: function () {
                    return $(this).data('placeholder');
                },
                width: '100%'
            });

            flatpickr("#start_end_date", {
                mode: "range",
                dateFormat: "m/d/Y",
                allowInput: true,
                placeholder: "<?php echo e(__('taxido::static.reports.select_date')); ?>"
            });
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/reports/ride.blade.php ENDPATH**/ ?>