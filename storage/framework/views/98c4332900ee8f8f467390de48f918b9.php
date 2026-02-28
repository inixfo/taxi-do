<?php $__env->startSection('title', __('taxido::static.reports.incentive_reports')); ?>
<?php $__env->startPush('css'); ?>
<?php $__env->stopPush(); ?>
<?php use \App\Enums\PaymentStatus; ?>
<?php
    $drivers = getAllVerifiedDrivers();
    $zones = getAllZones();
    $vehicleTypes = getAllVehicleTypes();
    $periodTypes = [
       ['id' => 'daily', 'name' => 'Daily'],
        ['id' => 'weekly', 'name' => 'Weekly']
    ];
    $levels = [
        ['id' => 1, 'name' => 'Level 1'],
        ['id' => 2, 'name' => 'Level 2'],
        ['id' => 3, 'name' => 'Level 3'],
        ['id' => 4, 'name' => 'Level 4'],
        ['id' => 5, 'name' => 'Level 5']
    ];
?>
<?php $__env->startSection('content'); ?>
    <div class="row ga- category-main g-md-4 g-3">
        <form id="filterForm" method="POST" action="<?php echo e(route('admin.incentive-report.export')); ?>" enctype="multipart/form-data">
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
                                    <label for="zone"><?php echo e(__('taxido::static.reports.zone')); ?></label>
                                    <select class="select-2 form-control filter-dropdown disable-all" id="zone"
                                        name="zone[]" multiple
                                        data-placeholder="<?php echo e(__('taxido::static.reports.select_zone')); ?>">
                                        <option value="all"><?php echo e(__('taxido::static.reports.all')); ?></option>
                                        <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($zone->id); ?>">
                                                <?php echo e($zone->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="vehicle_type"><?php echo e(__('taxido::static.reports.vehicle_type')); ?></label>
                                    <select class="select-2 form-control filter-dropdown disable-all" id="vehicle_type"
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

                                <div class="form-group">
                                    <label for="period_type"><?php echo e(__('taxido::static.reports.period_type')); ?></label>
                                    <select class="select-2 form-control filter-dropdown disable-all" id="period_type"
                                        name="period_type[]" multiple
                                        data-placeholder="<?php echo e(__('taxido::static.reports.select_period_type')); ?>">
                                        <option value="all"><?php echo e(__('taxido::static.reports.all')); ?></option>
                                        <?php $__currentLoopData = $periodTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $periodType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($periodType['id']); ?>">
                                                <?php echo e($periodType['name']); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="level"><?php echo e(__('taxido::static.reports.level')); ?></label>
                                    <select class="select-2 form-control filter-dropdown disable-all" id="level"
                                        name="level[]" multiple
                                        data-placeholder="<?php echo e(__('taxido::static.reports.select_level')); ?>">
                                        <option value="all"><?php echo e(__('taxido::static.reports.all')); ?></option>
                                        <?php $__currentLoopData = $levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($level['id']); ?>">
                                                <?php echo e($level['name']); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="is_achieved"><?php echo e(__('taxido::static.reports.status')); ?></label>
                                    <select class="form-control filter-dropdown" id="is_achieved" name="is_achieved">
                                        <option value="all"><?php echo e(__('taxido::static.reports.all')); ?></option>
                                        <option value="1"><?php echo e(__('taxido::static.reports.achieved')); ?></option>
                                        <option value="0"><?php echo e(__('taxido::static.reports.pending')); ?></option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="start_date"><?php echo e(__('taxido::static.reports.start_date')); ?></label>
                                    <input type="date" class="form-control filter-dropdown" id="start_date" name="start_date">
                                </div>

                                <div class="form-group">
                                    <label for="end_date"><?php echo e(__('taxido::static.reports.end_date')); ?></label>
                                    <input type="date" class="form-control filter-dropdown" id="end_date" name="end_date">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="contentbox">
                        <div class="inside">
                            <div class="contentbox-title">
                                <h3><?php echo e(__('taxido::static.reports.incentive_reports')); ?></h3>
                                <button type="button" class="btn btn-outline" data-bs-toggle="modal"
                                    data-bs-target="#reportExportModal">
                                    <?php echo e(__('taxido::static.reports.export')); ?>

                                </button>
                            </div>

                            <!-- Analytics Cards -->
                            <div class="row g-3 mb-4" id="analytics-cards">
                                <div class="col-md-3">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body">
                                            <h6 class="card-title"><?php echo e(__('taxido::static.reports.total_payouts')); ?></h6>
                                            <h4 id="total-payouts"><?php echo e(getDefaultCurrency()?->symbol); ?>0.00</h4>
                                            <small id="total-payouts-count">0 incentives</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-success text-white">
                                        <div class="card-body">
                                            <h6 class="card-title"><?php echo e(__('taxido::static.reports.participation_rate')); ?></h6>
                                            <h4 id="participation-rate">0%</h4>
                                            <small id="participation-details">0/0 drivers</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-info text-white">
                                        <div class="card-body">
                                            <h6 class="card-title"><?php echo e(__('taxido::static.reports.completion_rate')); ?></h6>
                                            <h4 id="completion-rate">0%</h4>
                                            <small id="completion-details">0/0 achieved</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body">
                                            <h6 class="card-title"><?php echo e(__('taxido::static.reports.avg_rides')); ?></h6>
                                            <h4 id="avg-rides">0</h4>
                                            <small>rides per driver</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tag-table">
                                <div class="col">
                                    <div class="table-main template-table incentive-report-table loader-table m-0">
                                        <div class="table-responsive custom-scrollbar m-0">
                                            <table class="table" id="incentiveTable">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo e(__('taxido::static.reports.driver')); ?></th>
                                                        <th><?php echo e(__('taxido::static.reports.email')); ?></th>
                                                        <th><?php echo e(__('taxido::static.reports.vehicle_type')); ?></th>
                                                        <th><?php echo e(__('taxido::static.reports.zone')); ?></th>
                                                        <th><?php echo e(__('taxido::static.reports.period_type')); ?></th>
                                                        <th><?php echo e(__('taxido::static.reports.level')); ?></th>
                                                        <th><?php echo e(__('taxido::static.reports.target_rides')); ?></th>
                                                        <th><?php echo e(__('taxido::static.reports.bonus_amount')); ?></th>
                                                        <th><?php echo e(__('taxido::static.reports.applicable_date')); ?></th>
                                                        <th><?php echo e(__('taxido::static.reports.status')); ?></th>
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

            <div class="modal fade" id="reportExportModal" tabindex="-1" aria-labelledby="reportExportModalLabel" aria-hidden="true">
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
        $(document).ready(function() {
            fetchIncentiveReportTable(page = 1);
            fetchAnalytics();

            $('.filter-dropdown').change(function() {
                fetchIncentiveReportTable();
                fetchAnalytics();
            });

            function fetchIncentiveReportTable(page = 1, orderby = '', order = '') {
                $('.report-loader-wrapper').show();
                let formData = $('#filterForm').serialize();
                formData += '&page=' + page;
                if (orderby) {
                    formData += '&orderby=' + orderby;
                }
                if (order) {
                    formData += '&order=' + order;
                }

                var $csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '<?php echo e(route('admin.incentive-report.filter')); ?>',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $csrfToken
                    },
                    success: function(response) {
                        $('#incentiveTable tbody').html(response.incentiveReportTable);
                        $('.pagination').html(response.pagination);
                    },
                    complete: function() {
                        $('.report-loader-wrapper').hide();
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            }

            function fetchAnalytics() {
                let formData = $('#filterForm').serialize();
                var $csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: '<?php echo e(route('admin.incentive-report.analytics')); ?>',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $csrfToken
                    },
                    success: function(response) {
                        updateAnalyticsCards(response);
                    },
                    error: function(xhr) {
                        console.error('Analytics fetch failed:', xhr.responseText);
                    }
                });
            }

            function updateAnalyticsCards(data) {
                const currency = '<?php echo e(getDefaultCurrency()?->symbol); ?>';

                $('#total-payouts').text(currency + parseFloat(data.total_payouts.total_amount || 0).toFixed(2));
                $('#total-payouts-count').text(data.total_payouts.total_count + ' incentives');

                $('#participation-rate').text(parseFloat(data.participation_rate.rate || 0).toFixed(1) + '%');
                $('#participation-details').text(data.participation_rate.participating_drivers + '/' + data.participation_rate.total_drivers + ' drivers');

                $('#completion-rate').text(parseFloat(data.completion_rate.rate || 0).toFixed(1) + '%');
                $('#completion-details').text(data.completion_rate.achieved_incentives + '/' + data.completion_rate.total_incentives + ' achieved');

                $('#avg-rides').text(parseFloat(data.average_rides_per_driver || 0).toFixed(1));
            }

            $(document).on('click', '#report-pagination a', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                const page = new URLSearchParams(url.split('?')[1]).get('page');
                fetchIncentiveReportTable(page);
            });

            $('.disable-all').on('change', function() {
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
                placeholder: function() {
                    return $(this).data('placeholder');
                },
                width: '100%'
            });

            $('#is_achieved').select2({
                placeholder: 'Select Status',
                width: '100%'
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/reports/incentive.blade.php ENDPATH**/ ?>