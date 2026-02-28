<?php $__env->startSection('title', __('taxido::static.reports.zone_reports')); ?>

<?php
    $rideStatus = getRideStatus();
    $zones = getAllZones();
    $vehicleTypes = getAllVehicleTypes();
?>
<?php $__env->startSection('content'); ?>
<div class="row ga- category-main g-md-4 g-3">
    <form id="filterForm" method="POST" action="<?php echo e(route('admin.zone-report.export')); ?>" enctype="multipart/form-data">
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
                                <label for="vehicle_type"><?php echo e(__('taxido::static.reports.vehicle_type')); ?></label>
                                <select class="select-2 form-control filter-dropdown disable-all" id="vehicle_type[]"
                                    name="vehicle_type[]" multiple
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
            <div class="col-xl-9">
                <div class="contentbox">
                    <div class="inside">
                        <div class="contentbox-title">
                            <h3><?php echo e(__('taxido::static.reports.zone_reports')); ?></h3>
                            <button type="button" class="btn btn-outline" data-bs-toggle="modal"
                                data-bs-target="#reportExportModal">
                                <?php echo e(__('taxido::static.reports.export')); ?>

                            </button>
                        </div>

                        <div class="tag-table">
                            <div class="col">
                                <div class="table-main loader-table template-table m-0">
                                    <div class="table-responsive custom-scrollbar m-0">
                                        <table class="table" id="zoneTable">
                                            <thead>
                                                <tr>
                                                    <th><?php echo e(__('taxido::static.reports.name')); ?></th>
                                                    <th><?php echo e(__('taxido::static.reports.total_rides')); ?></th>
                                                    <th><?php echo e(__('taxido::static.reports.total_drivers')); ?></th>
                                                    <th><?php echo e(__('taxido::static.reports.total_tax')); ?></th>
                                                    <th><?php echo e(__('taxido::static.reports.total_ride_amount')); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <div class="report-loader-wrapper" style="display:none;">
                                                    <div class="loader"></div>
                                                </div>
                                            </tbody>
                                        </table>

                                        <nav aria-label="Media Pagination">
                                            <ul class="pagination justify-content-center mt-3" id="report-pagination">
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
    <script>
        $(document).ready(function () {

            fetchZoneReportTable(page = 1);

            $('.filter-dropdown').change(function () {
                fetchZoneReportTable();
            })

            function fetchZoneReportTable(page = 1) {
                $('.report-loader-wrapper').show()
                let formData = $('#filterForm').serialize();
                formData += '&page=' + page;
                var $csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '<?php echo e(route('admin.zone-report.filter')); ?>',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $csrfToken
                    },
                    success: function (response) {
                        $('#zoneTable tbody').html(response.zoneReportTable);
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

                fetchZoneReportTable(page);
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
        })
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/reports/zone.blade.php ENDPATH**/ ?>