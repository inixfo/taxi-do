<?php $__env->startSection('title', __('taxido::static.riders.rider_details')); ?>
<?php
    $colorClasses = [
        'Pending' => 'warning',
        'Approved' => 'primary',
        'Rejected' => 'danger',
    ];
    $services = getAllServices();
    $rides = $rider?->rides;
    $paymentMethodColorClasses = getPaymentStatusColorClasses();
    $ridestatuscolorClasses = getRideStatusColorClasses();
?>
<?php $__env->startSection('content'); ?>
    <div class="row driver-dashboard">
        <div class="col-xxl-5">
            <div class="card">
                <div class="card-header card-no-border">
                    <div class="header-top">
                        <div>
                            <h5 class="m-0"><?php echo e(__('taxido::static.riders.personal_information')); ?></h5>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="personal">
                        <div class="information">
                            <div class="border-image">
                                <div class="profile-img">
                                    <?php if($rider?->profile_image): ?>
                                        <img src="<?php echo e($rider?->profile_image?->original_url); ?>" alt="">
                                    <?php else: ?>
                                        <div class="initial-letter">
                                            <span><?php echo e(strtoupper($rider?->name[0])); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="personal-rating">
                                <h5><?php echo e($rider?->name); ?></h5>
                                <span><?php echo e(__('taxido::static.riders.rating')); ?>

                                    <?php
                                        $averageRating = (int) $rider?->reviews?->avg('rating');
                                        $totalStars = 5;
                                    ?>

                                    <?php for($i = 0; $i < $averageRating; $i++): ?>
                                        <img src="<?php echo e(asset('images/dashboard/star.svg')); ?>" alt="Filled Star">
                                    <?php endfor; ?>
                                    <?php for($i = $averageRating; $i < $totalStars; $i++): ?>
                                        <img src="<?php echo e(asset('images/dashboard/outline-star.svg')); ?>" alt="Outlined Star">
                                    <?php endfor; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="information-details">
                        <ul>
                            <li><strong><?php echo e(__('taxido::static.riders.contact_number')); ?> : </strong> <?php if(isDemoModeEnabled()): ?>
                                        <?php echo e(__('taxido::static.demo_mode')); ?>

                                    <?php else: ?>
                                        + <?php echo e($rider?->country_code); ?> <?php echo e($rider?->phone); ?>

                                    <?php endif; ?></li>
                            <li><strong><?php echo e(__('taxido::static.riders.emails')); ?> : </strong> <?php if(isDemoModeEnabled()): ?>
                                    <?php echo e(__('static.demo_mode')); ?>

                                <?php else: ?>
                                    <?php echo e($rider->email ?? ''); ?>

                                <?php endif; ?></li>
                            <li><strong><?php echo e(__('taxido::static.riders.country')); ?> :
                                </strong><?php echo e($rider?->address?->country?->name ?? 'N/A'); ?>

                            </li>
                        </ul>
                        <ul>
                            <li><strong><?php echo e(__('taxido::static.riders.total_rides')); ?> :
                                </strong><?php echo e($rider?->rides?->count()); ?></li>
                            <li><strong><?php echo e(__('taxido::static.riders.wallet')); ?> :
                                </strong>
                                <a href="<?php echo e(url('admin/rider-wallet')); ?>?rider_id=<?php echo e($rider->id); ?>">
                                    <?php echo e(number_format($rider?->wallet?->balance, 2)); ?></a>
                            </li>
                            <li><strong><?php echo e(__('taxido::static.riders.city')); ?> : </strong><?php echo e($rider?->address?->city); ?>

                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3">
            <div class="card">
                <div class="card-header card-no-border">
                    <div class="header-top">
                        <div>
                            <h5 class="m-0"><?php echo e(__('taxido::static.riders.bank_details')); ?></h5>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="vehicle-information bank-details h-custom-scrollbar">
                        <ul>
                            <?php if($rider->payment_account): ?>
                                <li><strong><?php echo e(__('taxido::static.riders.account_holder_name')); ?> :
                                    </strong><?php echo e($rider->payment_account->bank_holder_name); ?>

                                </li>
                                <li><strong><?php echo e(__('taxido::static.riders.bank_name')); ?> :
                                    </strong><?php echo e($rider->payment_account->bank_name); ?>

                                </li>
                                <li><strong><?php echo e(__('taxido::static.riders.account_number')); ?> :
                                    </strong><?php echo e($rider->payment_account->bank_account_no); ?>

                                </li>
                                <li><strong><?php echo e(__('taxido::static.riders.routing_code')); ?> :
                                    </strong><?php echo e($rider->payment_account->routing_number ?? 'N/A'); ?></li>
                                <li><strong><?php echo e(__('taxido::static.riders.swift_code')); ?> :
                                    </strong><?php echo e($rider->payment_account->swift ?? 'N/A'); ?></li>
                            <?php else: ?>
                                <li class="table-no-data d-flex">
                                    <img src = "<?php echo e(asset('images/dashboard/data-not-found.svg')); ?>" alt="data not found">
                                    <h6 class="text-center"><?php echo e(__('taxido::static.riders.no_bank_details')); ?></h6>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4">
            <div class="card">
                <div class="card-header card-no-border">
                    <div class="header-top">
                        <div>
                            <h5 class="m-0"><?php echo e(__('taxido::static.riders.driver_reviews')); ?></h5>
                        </div>
                    </div>
                </div>
                <div class="card-body driver-document driver-review p-0">
                    <div class="table-responsive h-custom-scrollbar">
                        <table class="table display" style="width:100%">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('taxido::static.riders.name')); ?></th>
                                    <th><?php echo e(__('taxido::static.riders.ratings')); ?></th>
                                    <th><?php echo e(__('taxido::static.riders.description')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $rider->reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="customer-image">
                                                    <?php if($review?->driver?->profile_image?->original_url): ?>
                                                        <img src="<?php echo e($review?->driver?->profile_image->original_url); ?>"
                                                            alt="">
                                                    <?php else: ?>
                                                        <div class="initial-letter">
                                                            <span><?php echo e(strtoupper($review->driver->name[0])); ?></span>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h5><?php echo e($review->driver->name); ?></h5>
                                                    <span>
                                                        <?php if(isDemoModeEnabled()): ?>
                                                            <?php echo e(__('static.demo_mode')); ?>

                                                        <?php else: ?>
                                                            <?php echo e($review->driver->email); ?>

                                                        <?php endif; ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="rating">
                                                <?php
                                                    $averageRating = (int) $review->rating;
                                                    $totalStars = 5;
                                                ?>
                                                <?php for($i = 0; $i < $averageRating; $i++): ?>
                                                    <img src="<?php echo e(asset('images/dashboard/star.svg')); ?>" alt="Filled Star">
                                                <?php endfor; ?>
                                                <?php for($i = $averageRating; $i < $totalStars; $i++): ?>
                                                    <img src="<?php echo e(asset('images/dashboard/outline-star.svg')); ?>"
                                                        alt="Outlined Star">
                                                <?php endfor; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <p><?php echo e($review->message); ?></p>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        
                                        <td colspan="3">
                                            <div class="table-no-data d-flex">
                                                <img src = "<?php echo e(asset('images/dashboard/data-not-found.svg')); ?>"
                                                    alt="data not found">
                                                <h6><?php echo e(__('taxido::static.riders.no_reviews')); ?></h6>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body drivers-details-tabs pb-0">
                    <div class="tabs-container">
                        <div>
                            <ul class="nav nav-tabs horizontal-tab custom-scroll" id="account" role="tablist">
                                <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link <?php if($key === 0): ?> active <?php endif; ?>"
                                            id="tab-<?php echo e($service->id); ?>-tab" data-bs-toggle="tab"
                                            data-bs-target="#tab-<?php echo e($service->id); ?>" type="button" role="tab"
                                            aria-controls="tab-<?php echo e($service->id); ?>"
                                            aria-selected="<?php echo e($key === 0 ? 'true' : 'false'); ?>">
                                            <i class="ri-roadster-line"></i>
                                            <?php echo e($service->name); ?>

                                        </a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="tab-pane fade <?php if($key === 0): ?> show active <?php endif; ?>"
                                    id="tab-<?php echo e($service->id); ?>" role="tabpanel"
                                    aria-labelledby="tab-<?php echo e($service->id); ?>-tab">

                                    <div class="driver-document driver-details">
                                        <div class="table-responsive h-custom-scrollbar">
                                            <table class="table display" style="width:100%">
                                                <thead>
                                                    <tr>
                                                    <tr>
                                                        <th><?php echo e(__('taxido::static.riders.ride_number')); ?></th>
                                                        <th><?php echo e(__('taxido::static.riders.driver')); ?></th>
                                                        <th><?php echo e(__('taxido::static.riders.service')); ?></th>
                                                        <th><?php echo e(__('taxido::static.riders.service_category')); ?></th>
                                                        <th><?php echo e(__('taxido::static.riders.ride_status')); ?></th>
                                                        <th><?php echo e(__('taxido::static.riders.total_amount')); ?></th>
                                                        <th><?php echo e(__('taxido::static.riders.created_at')); ?></th>
                                                        <th><?php echo e(__('taxido::static.riders.action')); ?></th>
                                                    </tr>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__empty_2 = true; $__currentLoopData = $rides?->where('service_id', $service?->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ride): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                        <tr>
                                                            <td>
                                                                <span
                                                                    class="bg-light-primary">#<?php echo e($ride?->ride_number); ?></span>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="customer-image">
                                                                        <?php if($ride?->driver?->profile_image?->original_url): ?>
                                                                            <img src="<?php echo e($ride?->driver?->profile_image?->original_url); ?>" alt="">
                                                                        <?php else: ?>
                                                                            <div class="initial-letter">
                                                                                <span>
                                                                                    <?php echo e($ride?->driver?->name ? strtoupper($ride->driver->name[0]) : ''); ?>

                                                                                </span>
                                                                            </div>
                                                                        <?php endif; ?>

                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <h5><?php echo e($ride?->driver?->name); ?></h5>
                                                                        <span>
                                                                            <?php if(isDemoModeEnabled()): ?>
                                                                                <?php echo e(__('static.demo_mode')); ?>

                                                                            <?php else: ?>
                                                                                <?php echo e($ride?->driver?->email); ?>

                                                                            <?php endif; ?>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td><?php echo e($ride?->service?->name); ?></td>
                                                            <td><?php echo e($ride?->service_category?->name); ?></td>
                                                            <td>
                                                                <div
                                                                    class='badge badge-<?php echo e($ridestatuscolorClasses[ucfirst($ride->ride_status->name)]); ?>'>
                                                                    <?php echo e($ride->ride_status->name); ?></div>
                                                            </td>
                                                            <td><?php echo e(getDefaultCurrency()->symbol); ?><?php echo e($ride->total); ?></td>
                                                            <td><?php echo e($ride?->created_at->format('Y-m-d h:i:s A')); ?></td>

                                                            <td>
                                                                <a href="<?php echo e(route('admin.ride.details', $ride->id)); ?>"
                                                                    class="action-icon">
                                                                    <i class="ri-eye-line"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                        <tr>
                                                            
                                                            <td colspan="9">
                                                                <div class="table-no-data d-flex">
                                                                    <img src = "<?php echo e(asset('images/dashboard/data-not-found.svg')); ?>"
                                                                        alt="data not found">
                                                                    <h6><?php echo e(__('taxido::static.riders.no_rides')); ?></h6>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/rider/details.blade.php ENDPATH**/ ?>