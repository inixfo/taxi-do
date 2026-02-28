<?php use \Modules\Taxido\Enums\ServicesEnum; ?>
<?php use \Modules\Taxido\Enums\RideStatusEnum; ?>
<?php use \Modules\Taxido\Enums\ServiceCategoryEnum; ?>

<?php
    $locations = $ride->locations;
    $settings = getTaxidoSettings();
    $ridestatuscolorClasses = getRideStatusColorClasses();
    $paymentstatuscolorClasses = getPaymentStatusColorClasses();
    $locationCoordinates = $ride->location_coordinates;
    $paymentLogoUrl = getPaymentLogoUrl(strtolower($ride->payment_method));
    $currencySymbol = getDefaultCurrencySymbol();
?>


<?php $__env->startSection('title', __('taxido::static.rides.rides')); ?>
<?php $__env->startSection('content'); ?>

    <div class="row ride-dashboard">
        <div class="default-sorting mt-0">
            <div class="welcome-box">
                <div class="d-flex">
                    <h2><?php echo e(__('taxido::static.rides.ride_details')); ?></h2>
                </div>
            </div>
        </div>

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
                            <?php echo e(__('taxido::static.rides.ride_id')); ?>:
                            <span class="bg-light-primary" id="ride-number-span">#<?php echo e($ride->ride_number); ?></span>
                        </li>
                        <?php if($ride->start_time): ?>
                            <li><?php echo e(__('taxido::static.rides.start_date_time')); ?> :
                                <span id="start-time-span">
                                    <?php echo e($ride?->start_time?->format('Y-m-d H:i:s A') ?? null); ?>

                                </span>
                            </li>
                        <?php endif; ?>
                        <?php if(in_array($ride?->service_category?->slug, [ServiceCategoryEnum::PACKAGE, ServiceCategoryEnum::RENTAL])): ?>
                            <li><?php echo e(__('taxido::static.rides.end_date_time')); ?> :
                                <span id="end-time-span">
                                    <?php echo e($ride?->end_time?->format('Y-m-d H:i:s A') ?? null); ?>

                                </span>
                            </li>
                        <?php endif; ?>
                        <li>
                            <?php echo e(__('taxido::static.rides.ride_status')); ?> :
                            <span id="ride-status-span"
                                class="badge badge-<?php echo e($ridestatuscolorClasses[ucfirst($ride->ride_status->name)]); ?>">
                                <?php echo e(ucfirst(strtolower($ride->ride_status->name))); ?>

                            </span>
                        </li>
                        <li>
                            <?php echo e(__('taxido::static.rides.payment_status')); ?> :
                            <span id="payment-status-span"
                                class="badge badge-<?php echo e($paymentstatuscolorClasses[ucfirst($ride->payment_status)]); ?>">
                                <?php echo e(ucfirst(strtolower($ride->payment_status))); ?>

                            </span>
                        </li>
                        <li>
                            <?php echo e(__('taxido::static.rides.service')); ?> : <span
                                id="service-name-span"><?php echo e($ride->service->name); ?></span>
                        </li>
                        <?php if(!in_array($ride->service->slug, [ServicesEnum::AMBULANCE])): ?>
                            <li>
                                <?php echo e(__('taxido::static.rides.service_category')); ?> :
                                <span id="service-category-name-span"><?php echo e($ride?->service_category?->name); ?></span>
                            </li>
                        <?php endif; ?>
                        <li>
                            <?php echo e(__('taxido::static.rides.otp')); ?> : <span id="ride-otp-span"><?php echo e($ride->otp); ?></span>
                            <?php if(in_array($ride?->service?->slug, [ServicesEnum::PARCEL])): ?>
                        <li><?php echo e(__('taxido::static.rides.parcel_otp')); ?>:
                            <span id="parcel-otp-span"> <?php echo e($ride?->parcel_delivered_otp); ?></span>
                        </li>
                        <li>
                            <?php echo e(__('taxido::static.rides.weight')); ?>: <span id="weight-span">
                                <?php echo e($ride?->weight); ?></span>
                        </li>
                        <?php endif; ?>
                        </li>
                        <?php if(in_array($ride?->service_category?->slug, [ServiceCategoryEnum::RENTAL])): ?>
                            <li>
                                <?php echo e(__('taxido::static.rides.no_of_days')); ?> : <span
                                    id="no-of-days-span"><?php echo e($ride->no_of_days); ?></span>
                            </li>
                        <?php endif; ?>

                        <?php if(in_array($ride->service->slug, [ServicesEnum::AMBULANCE])): ?>
                            <li>
                                <?php echo e(__('taxido::static.rides.ambulance_name')); ?> :
                                <span id="ambulance-name-span"><?php echo e($ride->driver?->ambulance?->name); ?></span>
                            </li>
                        <?php endif; ?>
                        <?php if(!in_array($ride?->service_category?->slug, [ServiceCategoryEnum::RENTAL])): ?>
                            <li>
                                <?php echo e(__('taxido::static.rides.ride_distance')); ?> : <span
                                    id="distance-span"><?php echo e($ride?->distance); ?>

                                    <?php echo e($ride?->distance_unit); ?></span>
                            </li>
                        <?php endif; ?>
                        <li>
                            <?php echo e(__('taxido::static.rides.waiting_total_times')); ?> :
                            <span
                                id="waiting-total-times-span"><?php echo e($ride?->waiting_total_times); ?><?php echo e(__('taxido::static.rides.minutes')); ?></span>
                        </li>
                        <li id="payment-method-span">
                            <?php echo e(__('taxido::static.rides.payment_method')); ?> :
                            <span>
                                <img class="img-fluid payment-img" alt="" id="payment-method-img"
                                    src="<?php echo e($paymentLogoUrl ?: asset('images/payment/cod.png')); ?>">
                            </span>
                        </li>
                    </ul>

                    <?php if($ride?->service_category?->slug != ServiceCategoryEnum::RENTAL &&
                            !in_array($ride->service->slug, [ServicesEnum::AMBULANCE]) &&
                            $ride->bids->isNotEmpty()): ?>
                        <div class="total-bidding">
                            <div class="left-bidding">
                                <div class="bidding-img">
                                    <div class="bg-round">
                                        <svg>
                                            <use xlink:href="<?php echo e(asset('images/dashboard/support/user.svg#user')); ?>"></use>
                                        </svg>
                                        <svg class="half-circle">
                                            <use xlink:href="<?php echo e(asset('images/dashboard/support/1.svg#support')); ?>"></use>
                                        </svg>
                                    </div>
                                </div>

                                <div class="bidding-text">
                                    <h4><?php echo e(__('taxido::static.rides.total_biddings')); ?></h4>
                                    <h3><?php echo e($ride->bids->count()); ?></h3>
                                </div>
                            </div>
                            <button class="btn bg-primary" data-bs-toggle="modal"
                                data-bs-target="#bidding"><?php echo e(__('taxido::static.rides.biddings')); ?></button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-xxl-6">
            <div class="row">
                <div class="col-xxl-12">
                    <div class="card h-auto">
                        <div class="card-header card-no-border">
                            <div class="header-top">
                                <h5 class="m-0"><?php echo e(__('taxido::static.rides.driver_detail')); ?></h5>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="personal">
                                <div class="information">
                                    <div class="border-image">
                                        <div class="profile-img">
                                            <?php if($ride?->driver?->profile_image?->original_url): ?>
                                                <img src="<?php echo e($ride?->driver?->profile_image?->original_url); ?>"
                                                    alt="" id="driver-profile-img">
                                            <?php else: ?>
                                                <div class="initial-letter" id="driver-initial-container">
                                                    <span
                                                        id="driver-initial-span"><?php echo e(strtoupper($ride?->driver?->name[0])); ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php if($ride?->driver && $ride->driver_id): ?>
                                    <div class="personal-rating">

                                        <h5>
                                            <a href="<?php echo e(route('admin.driver.show', ['driver' => $ride?->driver_id])); ?>"
                                                class="text-decoration-none" id="driver-name">
                                                <?php echo e($ride?->driver?->name); ?>

                                            </a>
                                        </h5>
                                        <div class="rating" id="driver-rating-stars">
                                            <span id="driver-rating"><?php echo e(__('taxido::static.riders.rating')); ?>:
                                                <?php
                                                    $averageRating = (int) $ride?->driver?->reviews?->avg('rating');
                                                    $totalStars = 5;
                                                ?>
                                                <?php for($i = 0; $i < $averageRating; $i++): ?>
                                                    <img src="<?php echo e(asset('images/dashboard/star.svg')); ?>" alt="Filled Star">
                                                <?php endfor; ?>
                                                <?php for($i = $averageRating; $i < $totalStars; $i++): ?>
                                                    <img src="<?php echo e(asset('images/dashboard/outline-star.svg')); ?>"
                                                        alt="Outlined Star">
                                                <?php endfor; ?>
                                            </span>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <ul class="personal-details-list">
                                    <li>
                                        <span><?php echo e(__('taxido::static.rides.email')); ?>: </span>
                                        <span id="driver-email-value"><?php echo e($ride?->driver?->email ?? ''); ?></span>
                                    </li>
                                    <li>
                                        <span><?php echo e(__('taxido::static.rides.phone')); ?>:</span>
                                        <span id="driver-phone-value">+<?php echo e($ride?->driver?->country_code ?? ''); ?>

                                            <?php echo e($ride?->driver?->phone ?? ''); ?></span>
                                    </li>
                                    <?php if(!in_array($ride->service->slug, [ServicesEnum::AMBULANCE])): ?>
                                        <li>
                                            <span id="vehicle-number"><?php echo e(__('taxido::static.riders.vehicle_num')); ?>:</span>
                                            <span id="vehicle-number-value"><?php echo e($ride?->driver?->vehicle_info?->plate_number); ?></span>
                                        </li>
                                        <?php if(!in_array($ride?->service_category?->slug, [ServiceCategoryEnum::RENTAL])): ?>
                                            <li>
                                                <span><?php echo e(__('taxido::static.rides.vehicle_type')); ?>: </span>
                                                <div class="vehicle-image">
                                                    <img src="<?php echo e($ride?->driver?->vehicle_info?->vehicle?->vehicle_image?->original_url ?? '/images/user.png'); ?>"
                                                        class="img-fluid" alt="" id="vehicle-image">
                                                </div>
                                                <span
                                                    id="vehicle-name">(<?php echo e($ride?->driver?->vehicle_info?->vehicle?->name); ?>)</span>
                                            </li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-12">
                    <div class="card h-auto">
                        <div class="card-header card-no-border">
                            <div class="header-top">
                                <h5 class="m-0"><?php echo e(__('taxido::static.rides.rider_details')); ?></h5>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="personal">
                                <div class="information">
                                    <div class="border-image">
                                        <div class="profile-img">
                                            <?php if($ride?->rider['profile_image']?->original_url ?? null): ?>
                                                <img src="<?php echo e($ride?->rider['profile_image']?->original_url); ?>"
                                                    class="img-fluid" alt="" id="rider-profile-img">
                                            <?php else: ?>
                                                <?php if(isset($ride?->rider['name'])): ?>
                                                <div class="initial-letter" id="rider-initial-container">
                                                    <span id="rider-initial"><?php echo e(strtoupper($ride?->rider['name'][0] ?? 'G')); ?></span>
                                                </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="personal-rating">
                                        <h5 id="rider-name"><?php echo e($ride['rider']['name'] ?? 'G'); ?></h5>
                                        <div class="rating" id="rider-rating-stars">
                                            <span><?php echo e(__('taxido::static.rides.rating')); ?>:
                                                <?php
                                                    $averageRating = 0;
                                                    if (
                                                        isset($ride['rider']['reviews']) &&
                                                        count($ride['rider']['reviews']) > 0
                                                    ) {
                                                        $averageRating = (int) collect($ride['rider']['reviews'])->avg(
                                                            'rating',
                                                        );
                                                    }
                                                    $totalStars = 5;
                                                ?>
                                                <?php for($i = 0; $i < $averageRating; $i++): ?>
                                                    <img src="<?php echo e(asset('images/dashboard/star.svg')); ?>"
                                                        alt="Filled Star">
                                                <?php endfor; ?>
                                                <?php for($i = $averageRating; $i < $totalStars; $i++): ?>
                                                    <img src="<?php echo e(asset('images/dashboard/outline-star.svg')); ?>"
                                                        alt="Outlined Star">
                                                <?php endfor; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <ul class="personal-details-list">
                                    <li>
                                        <span><?php echo e(__('taxido::static.rides.email')); ?>: </span>
                                        <span id="rider-email-value"><?php echo e($ride?->rider['email'] ?? ''); ?></span>
                                    </li>
                                    <li>
                                        <span><?php echo e(__('taxido::static.rides.contact_number')); ?>:</span>
                                        <span id="rider-phone-value">+<?php echo e($ride?->rider['country_code'] ?? ''); ?>

                                            <?php echo e($ride?->rider['phone'] ?? ''); ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-5">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-no-border">
                            <div class="header-top">
                                <h5 class="m-0"><?php echo e(__('taxido::static.rides.price_details')); ?></h5>
                                <?php if($ride->invoice_id): ?>
                                    <div class="d-flex">
                                        <a href="<?php echo e(route('ride.rider.invoice', $ride->invoice_id)); ?>"
                                            class="btn btn-primary">
                                            <i class="ri-download-line"></i>
                                            <?php echo e(__('taxido::static.rides.rider_invoice')); ?>

                                        </a>
                                    </div>
                                <?php endif; ?>
                                <?php if($ride->invoice_id): ?>
                                    <a href="<?php echo e(route('ride.driver.invoice', $ride->invoice_id)); ?>"
                                        class="btn btn-primary ms-2">
                                        <i class="ri-download-line"></i> <?php echo e(__('taxido::static.rides.driver_invoice')); ?>

                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <?php

                                $isRental = $ride?->service_category?->slug == ServiceCategoryEnum::RENTAL;
                                $isPackage = $ride?->service_category?->slug == ServiceCategoryEnum::PACKAGE;
                                $isParcel = $ride?->service?->slug == ServicesEnum::PARCEL;
                                $isRideTypes =
                                    in_array($ride?->service_category?->slug, [
                                        ServiceCategoryEnum::INTERCITY,
                                        ServiceCategoryEnum::RIDE,
                                        ServiceCategoryEnum::SCHEDULE,
                                    ]) || $ride?->service?->slug == ServicesEnum::FREIGHT;

                                $currencyCode = session('currency', getDefaultCurrencyCode());
                                $currencySymbol =
                                    \App\Models\Currency::where('code', $currencyCode)->value('symbol') ??
                                    getDefaultCurrencySymbol();
                                $cs = $ride?->currency_symbol ?? $currencySymbol;
                            ?>

                            <ul class="price-details-list">
                                <li class="title-list"></li>
                                <li>
                                    <?php echo e(__('taxido::static.rides.ride_fare')); ?> :
                                    <span id="ride-fare-span"><?php echo e($cs . number_format($ride?->ride_fare, 2)); ?></span>
                                </li>

                                <?php if($ride->additional_distance_charge > 0): ?>
                                    <li>
                                        <?php echo e(__('taxido::static.rides.additional_distance_charge')); ?> :
                                        <span
                                            id="additional-distance-charge-span"><?php echo e($cs . number_format($ride?->additional_distance_charge, 2)); ?></span>
                                    </li>
                                <?php endif; ?>

                                <?php if($ride->additional_minute_charge > 0): ?>
                                    <li>
                                        <?php echo e(__('taxido::static.rides.additional_minute_charge')); ?> :
                                        <span
                                            id="additional-minute-charge-span"><?php echo e($cs . number_format($ride?->additional_minute_charge, 2)); ?></span>
                                    </li>
                                <?php endif; ?>

                                <?php if($ride->additional_weight_charge > 0): ?>
                                    <li>
                                        <?php echo e(__('taxido::static.rides.additional_weight_charge')); ?> :
                                        <span
                                            id="additional-weight-charge-span"><?php echo e($cs . number_format($ride?->additional_weight_charge, 2)); ?></span>
                                    </li>
                                <?php endif; ?>

                                <?php if($ride->total_extra_charge > 0): ?>
                                    <li>
                                        <?php echo e(__('taxido::static.rides.extra_charge')); ?> :
                                        <span
                                            id="package-extra-charge-span"><?php echo e($cs . number_format(round($ride?->total_extra_charge, 2), 2)); ?></span>
                                    </li>
                                <?php endif; ?>

                                <?php if($isRental): ?>
                                    <li>
                                        <?php echo e(__('taxido::static.rides.vehicle_charge')); ?> :
                                        <span id="vehicle-charge-span">
                                            <?php echo e($cs . number_format(round($ride?->vehicle_per_day_price, 2) * $ride?->no_of_days, 2)); ?>

                                            (<?php echo e(round($ride?->vehicle_per_day_price, 2)); ?> * <?php echo e($ride?->no_of_days); ?>

                                            <?php echo e(__('taxido::static.rides.days')); ?>)
                                        </span>
                                    </li>
                                    <li>
                                        <?php echo e(__('taxido::static.rides.driver_charge')); ?> :
                                        <span id="driver-charge-span">
                                            <?php echo e($cs . number_format(round($ride?->driver_per_day_charge, 2) * $ride?->no_of_days, 2)); ?>

                                            (<?php echo e(round($ride?->driver_per_day_charge, 2)); ?> * <?php echo e($ride?->no_of_days); ?>

                                            <?php echo e(__('taxido::static.rides.days')); ?>)
                                        </span>
                                    </li>
                                <?php endif; ?>

                                <?php if($ride->waiting_charges > 0): ?>
                                    <li>
                                        <?php echo e(__('taxido::static.rides.waiting_charges')); ?> :
                                        <span
                                            id="waiting-charge-span"><?php echo e($cs . number_format($ride?->waiting_charges, 2)); ?></span>
                                    </li>
                                <?php endif; ?>

                                <?php if($ride->bid_extra_amount > 0): ?>
                                    <li>
                                        <?php echo e(__('taxido::static.rides.bid_extra_amount')); ?> :
                                        <span
                                            id="bid-extra-amount-span"><?php echo e($cs . number_format($ride?->bid_extra_amount, 2)); ?></span>
                                    </li>
                                <?php endif; ?>

                                <?php if($ride->driver_tips > 0): ?>
                                    <li>
                                        <?php echo e(__('taxido::static.invoice.driver_tips')); ?> :
                                        <span
                                            id="driver-tips-span"><?php echo e($cs . number_format(round($ride?->driver_tips, 2), 2)); ?></span>
                                    </li>
                                <?php endif; ?>

                                <li class="success-text">
                                    <?php echo e(__('taxido::static.rides.subtotal')); ?> :
                                    <span
                                        id="driver-tips-span"><?php echo e($cs . number_format(round($ride?->sub_total, 2), 2)); ?></span>
                                </li>

                                <?php if($ride?->coupon_total_discount): ?>
                                    <li class="danger-text">
                                        <?php echo e(__('taxido::static.rides.coupon_discount')); ?>

                                        <?php if($ride?->coupon?->code): ?>
                                            (#<?php echo e($ride?->coupon?->code); ?>)
                                        <?php endif; ?> :
                                        <span
                                            id="coupon-discount-span">-<?php echo e($cs . number_format(round($ride?->coupon_total_discount, 2), 2)); ?></span>
                                    </li>
                                <?php endif; ?>

                                <li>
                                    <?php echo e(__('taxido::static.rides.platform_fee')); ?> :
                                    <span id="platform-fee-span"><?php echo e($cs . number_format($ride?->platform_fees, 2)); ?></span>
                                </li>

                                <li>
                                    <?php echo e(__('taxido::static.rides.tax')); ?> :
                                    <span id="tax-span"><?php echo e($cs . number_format(round($ride?->tax, 2), 2)); ?></span>
                                </li>

                                <li>
                                    <?php echo e(__('taxido::static.rides.admin_commission')); ?> :
                                    <span id="admin-commission-span"><?php echo e($cs . number_format($ride?->commission, 2)); ?></span>
                                </li>

                                <?php if($ride->processing_fee > 0): ?>
                                    <li>
                                        <?php echo e(__('taxido::static.rides.processing_fee')); ?> :
                                        <span
                                            id="processing-fee-span"><?php echo e($cs . number_format($ride?->processing_fee, 2)); ?></span>
                                    </li>
                                <?php endif; ?>

                                <li class="total-box">
                                    <?php echo e(__('taxido::static.rides.total')); ?> :
                                    <span id="total-span"><?php echo e($cs . number_format(round($ride?->total, 2), 2)); ?></span>
                                </li>
                            </ul>
                            <ul class="comment-box-list">
                                <?php if($ride?->comment): ?>
                                    <li>
                                        <h4><?php echo e(__('taxido::static.rides.comments')); ?></h4>
                                        <p id="ride-comment"><?php echo e($ride?->comment); ?></p>
                                    </li>
                                <?php endif; ?>

                                <li>
                                    <ul class="price-details-list">
                                        
                                        <?php if(in_array($ride?->ride_status?->slug, [RideStatusEnum::CANCELLED])): ?>
                                            <li>
                                                <h4><?php echo e(__('taxido::static.rides.cancellation_reason')); ?></h4>
                                                <span id="cancellation-reason">
                                                    <?php echo e($ride->cancellation_reason->title ?? __('taxido::static.rides.default_cancel_reason')); ?>

                                                </span>
                                            </li>
                                        <?php endif; ?>

                                        
                                        <?php
                                            $riderCharge = $ride->rider_cancellation_charge ?? 0;
                                            $driverCharge = $ride->driver_cancellation_charge ?? 0;
                                            $totalCharge = $riderCharge + $driverCharge;
                                        ?>

                                        <?php if($totalCharge > 0): ?>
                                            <?php if($riderCharge > 0): ?>
                                                <li>
                                                    <?php echo e(__('taxido::static.rides.rider_cancellation_charge')); ?> :
                                                    <span id="rider-cancellation-charge-span">
                                                        <?php echo e($cs . number_format($riderCharge, 2)); ?>

                                                    </span>
                                                </li>
                                            <?php endif; ?>

                                            <?php if($driverCharge > 0): ?>
                                                <li>
                                                    <?php echo e(__('taxido::static.rides.driver_cancellation_charge')); ?> :
                                                    <span id="driver-cancellation-charge-span">
                                                        <?php echo e($cs . number_format($driverCharge, 2)); ?>

                                                    </span>
                                                </li>
                                            <?php endif; ?>

                                            <li>
                                                <strong><?php echo e(__('taxido::static.rides.total_cancellation_charge')); ?> :</strong>
                                                <span id="ride-cancellation-charge">
                                                    <?php echo e($cs . number_format($totalCharge, 2)); ?>

                                                </span>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php if(in_array($ride?->service?->slug, [ServicesEnum::PARCEL])): ?>
                <div class="col-12">
                    <div class="card">
                        <div class="parcel-box">
                            <div class="left-box">
                                <img src="<?php echo e($ride->cargo_image?->original_url ?? asset('images/nodata1.webp')); ?>"
                                    class="img-fluid" alt="" id="parcel-image">
                            </div>
                            <ul class="right-list">
                                <?php if($ride?->parcel_receiver): ?>
                                    <li><span><?php echo e(__('taxido::static.rides.receiver_name')); ?>:</span>
                                        <span id="receiver-name"><?php echo e($ride?->parcel_receiver['name']); ?></span>
                                    </li>
                                    <li>
                                        <span><?php echo e(__('taxido::static.rides.receiver_no')); ?>:</span>
                                        <span id="receiver-phone"><?php echo e($ride?->parcel_receiver['country_code'] ?? ''); ?>

                                            <?php echo e($ride?->parcel_receiver['phone'] ?? ''); ?></span>
                                    </li>
                                    <li><span><?php echo e(__('taxido::static.rides.parcel_otp')); ?>:</span>
                                        <span id="parcel-delivered-otp"><?php echo e($ride?->parcel_delivered_otp); ?></span>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>

                
                <?php if($ride->pickup_photo || $ride->dropoff_photo): ?>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-no-border">
                            <div class="header-top">
                                <h5 class="m-0"><i class="ri-camera-line me-2"></i><?php echo e(__('taxido::static.rides.parcel_security_photos') ?? 'Parcel Security Photos'); ?></h5>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                
                                <div class="col-md-6 mb-3">
                                    <div class="parcel-photo-card">
                                        <h6 class="mb-2">
                                            <i class="ri-map-pin-line text-success"></i>
                                            <?php echo e(__('taxido::static.rides.pickup_photo') ?? 'Pickup Photo'); ?>

                                        </h6>
                                        <?php if($ride->pickup_photo): ?>
                                            <div class="photo-container" style="border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;">
                                                <a href="<?php echo e($ride->pickup_photo->original_url); ?>" target="_blank" title="Click to view full size">
                                                    <img src="<?php echo e($ride->pickup_photo->original_url); ?>" 
                                                         class="img-fluid" 
                                                         alt="Pickup Photo"
                                                         style="max-height: 200px; width: 100%; object-fit: cover;">
                                                </a>
                                            </div>
                                            <?php if($ride->pickup_photo_taken_at): ?>
                                            <small class="text-muted d-block mt-1">
                                                <i class="ri-time-line"></i>
                                                <?php echo e(\Carbon\Carbon::parse($ride->pickup_photo_taken_at)->format('M d, Y H:i')); ?>

                                            </small>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <div class="text-muted text-center p-4" style="background: #f8f9fa; border-radius: 8px;">
                                                <i class="ri-image-line" style="font-size: 2rem;"></i>
                                                <p class="mb-0 mt-2"><?php echo e(__('taxido::static.rides.no_pickup_photo') ?? 'No pickup photo available'); ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                
                                <div class="col-md-6 mb-3">
                                    <div class="parcel-photo-card">
                                        <h6 class="mb-2">
                                            <i class="ri-flag-line text-danger"></i>
                                            <?php echo e(__('taxido::static.rides.dropoff_photo') ?? 'Dropoff Photo'); ?>

                                        </h6>
                                        <?php if($ride->dropoff_photo): ?>
                                            <div class="photo-container" style="border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;">
                                                <a href="<?php echo e($ride->dropoff_photo->original_url); ?>" target="_blank" title="Click to view full size">
                                                    <img src="<?php echo e($ride->dropoff_photo->original_url); ?>" 
                                                         class="img-fluid" 
                                                         alt="Dropoff Photo"
                                                         style="max-height: 200px; width: 100%; object-fit: cover;">
                                                </a>
                                            </div>
                                            <?php if($ride->dropoff_photo_taken_at): ?>
                                            <small class="text-muted d-block mt-1">
                                                <i class="ri-time-line"></i>
                                                <?php echo e(\Carbon\Carbon::parse($ride->dropoff_photo_taken_at)->format('M d, Y H:i')); ?>

                                            </small>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <div class="text-muted text-center p-4" style="background: #f8f9fa; border-radius: 8px;">
                                                <i class="ri-image-line" style="font-size: 2rem;"></i>
                                                <p class="mb-0 mt-2"><?php echo e(__('taxido::static.rides.no_dropoff_photo') ?? 'No dropoff photo available'); ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="alert alert-info mt-2 mb-0">
                                <i class="ri-information-line"></i>
                                <small><?php echo e(__('taxido::static.rides.parcel_photos_info') ?? 'These photos are captured by the driver at pickup and dropoff locations for parcel security verification.'); ?></small>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if(in_array($ride?->service_category?->slug, [ServiceCategoryEnum::RENTAL])): ?>
                <div class="col-12">
                    <div class="card">
                        <div class="driver-box">
                            <div class="left-box">
                                <img src="<?php echo e($ride?->rental_vehicle?->normal_image?->original_url ?? asset('images/nodata1.webp')); ?>"
                                    class="img-fluid" alt="" id="rental-vehicle-image">
                            </div>
                            <ul class="right-list">
                                <li><span><?php echo e(__('taxido::static.rides.vehicle_name')); ?>:</span>
                                    <span id="rental-vehicle-name"><?php echo e($ride?->rental_vehicle?->name); ?></span>
                                </li>
                                <?php if($ride?->is_with_driver == 1): ?>
                                    <li><span><?php echo e(__('taxido::static.rides.assign_driver_name')); ?>:</span>
                                        <span id="assigned-driver-name"><?php echo e($ride?->assigned_driver['name']); ?></span>
                                    </li>
                                    <li>
                                        <span><?php echo e(__('taxido::static.rides.assign_driver_no')); ?>:</span>
                                        <span
                                            id="assigned-driver-phone">+<?php echo e($ride?->assigned_driver['country_code'] ?? ''); ?>

                                            <?php echo e($ride?->assigned_driver['phone'] ?? ''); ?></span>
                                    </li>
                                <?php else: ?>
                                    <li><span><?php echo e(__('taxido::static.rides.driver_name')); ?>:</span>
                                        <span id="driver-name-value"><?php echo e($ride?->driver?->name); ?></span>
                                    </li>
                                    <li><span><?php echo e(__('taxido::static.rides.driver_no')); ?>:</span>
                                        <span id="driver-phone-value"><?php echo e($ride?->driver?->phone); ?></span>
                                    </li>
                                <?php endif; ?>
                                <li><span><?php echo e(__('taxido::static.rides.vehicle_registration_no')); ?>:</span>
                                    <span
                                        id="rental-vehicle-registration"><?php echo e($ride?->rental_vehicle?->registration_no); ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-xxl-7">
            <div class="card maps-view h-auto">
                <div class="card-header card-no-border">
                    <div class="header-top">
                        <div>
                            <h5 class="m-0"><?php echo e(__('taxido::static.rides.map_view')); ?></h5>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="map-view" id="map-view" loading="lazy"></div>
                    <div class="accordion" id="location-view">
                        <div class="accordion-item location-details">
                            <div class="accordion-header contentbox-title">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#location-viewCollapse">
                                    <h4><?php echo e(__('taxido::static.rides.location_details')); ?></h4>
                                </button>
                            </div>
                            <div id="location-viewCollapse" class="accordion-collapse collapse show"
                                data-bs-parent="#location-view">
                                <div class="accordion-body">
                                    <div class="">
                                        <ul class="tracking-path" id="locations-list">
                                            <?php
                                                $points = range('A', 'Z');
                                            ?>
                                            <?php $__currentLoopData = $ride->locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($loop->last): ?>
                                                    <li class="end-point">
                                                        <?php echo e($location); ?><span><?php echo e($points[$index]); ?></span>
                                                    </li>
                                                <?php else: ?>
                                                    <li class="stop-point">
                                                        <?php echo e($location); ?><span><?php echo e($points[$index]); ?></span>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if(isset($ride?->riderReview)): ?>
                <div class="card h-auto">
                    <!-- Rider Reviews Section -->
                    <div class="card-header card-no-border">
                        <div class="header-top">
                            <h5 class="m-0"><?php echo e(__('taxido::static.rides.rider_reviews')); ?></h5>
                        </div>
                    </div>
                    <div class="card-body rider-reviews p-0">
                        <?php if(isset($ride?->riderReview)): ?>
                            <div class="table-responsive h-custom-scrollbar">
                                <table class="table driver-review-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('taxido::static.rides.driver')); ?></th>
                                            <th><?php echo e(__('taxido::static.rides.rating')); ?></th>
                                            <th><?php echo e(__('taxido::static.rides.description')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="customer-image">
                                                        <?php if($ride?->riderReview?->driver?->profile_image?->original_url): ?>
                                                            <img src="<?php echo e($ride?->riderReview?->driver?->profile_image?->original_url); ?>"
                                                                alt="" id="review-driver-image">
                                                        <?php else: ?>
                                                            <?php if(isset($ride?->riderReview?->driver)): ?>
                                                                <div class="initial-letter" id="review-driver-initial-container">
                                                                    <span
                                                                        id="review-driver-initial"><?php echo e(strtoupper($ride?->riderReview?->driver?->name[0])); ?></span>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h5 id="review-driver-name"><?php echo e($ride?->riderReview?->driver?->name); ?>

                                                        </h5>
                                                        <span id="review-driver-email">
                                                            <?php echo e($ride?->riderReview?->driver?->email ?? ''); ?>

                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="rating" id="rider-review-rating">
                                                    <?php if(isset($ride?->riderReview)): ?>
                                                        <?php
                                                            $averageRating = (int) $ride?->riderReview?->rating;
                                                            $totalStars = 5;
                                                        ?>
                                                        <?php for($i = 0; $i < $averageRating; $i++): ?>
                                                            <img src="<?php echo e(asset('images/dashboard/star.svg')); ?>"
                                                                alt="Filled Star">
                                                        <?php endfor; ?>
                                                        <?php for($averageRating; $i < $totalStars; $i++): ?>
                                                            <img src="<?php echo e(asset('images/dashboard/outline-star.svg')); ?>"
                                                                alt="Outlined Star">
                                                        <?php endfor; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="position-relative">
                                                    <p class="review-text" id="rider-review-message">
                                                        <span class="initial-review">
                                                            <?php echo e(\Illuminate\Support\Str::limit($ride?->riderReview?->message, 15)); ?>

                                                        </span>
                                                        <span class="full-review d-none">
                                                            <?php echo e($ride?->riderReview?->message); ?>

                                                        </span>
                                                    </p>
                                                    <a href="javascript:void(0);" class="read-more"
                                                        onclick="toggleRiderReview()">
                                                        <?php echo e(__('taxido::static.rides.read_more')); ?>

                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="table-no-data">
                                <img src="<?php echo e(asset('images/dashboard/data-not-found.svg')); ?>" class="img-fluid"
                                    alt="data not found">
                                <h6 class="text-center">
                                    <?php echo e(__('taxido::static.widget.no_data_available')); ?>

                                </h6>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if(isset($ride?->driverReview)): ?>
                <div class="card h-auto">
                    <div class="card-header card-no-border">
                        <div class="header-top">
                            <h5 class="m-0"><?php echo e(__('taxido::static.rides.driver_reviews')); ?></h5>
                        </div>
                    </div>
                    <div class="card-body rider-reviews p-0">
                        <?php if(isset($ride?->driverReview)): ?>
                            <div class="table-responsive h-custom-scrollbar">
                                <table class="table driver-review-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('taxido::static.rides.rider')); ?></th>
                                            <th><?php echo e(__('taxido::static.rides.rating')); ?></th>
                                            <th><?php echo e(__('taxido::static.rides.description')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="customer-image">
                                                        <?php if($ride?->driverReview?->rider?->profile_image?->original_url): ?>
                                                            <img src="<?php echo e($ride?->driverReview?->rider?->profile_image?->original_url); ?>"
                                                                alt="" id="driver-review-rider-image">
                                                        <?php else: ?>
                                                            <?php if(isset($ride?->driverReview?->rider)): ?>
                                                                <div class="initial-letter"
                                                                    id="driver-review-rider-initial-container">
                                                                    <span
                                                                        id="driver-review-rider-initial"><?php echo e(strtoupper($ride?->driverReview?->rider?->name[0])); ?></span>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h5 id="driver-review-rider-name">
                                                            <?php echo e($ride?->driverReview?->rider?->name); ?></h5>
                                                        <span id="driver-review-rider-email">
                                                            <?php echo e($ride?->driverReview?->rider?->email ?? ''); ?>

                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="rating" id="driver-review-rating">
                                                    <?php if(isset($ride?->driverReview)): ?>
                                                        <?php
                                                            $averageRating = (int) $ride?->driverReview?->rating;
                                                            $totalStars = 5;
                                                        ?>
                                                        <?php for($i = 0; $i < $averageRating; $i++): ?>
                                                            <img src="<?php echo e(asset('images/dashboard/star.svg')); ?>"
                                                                alt="Filled Star">
                                                        <?php endfor; ?>
                                                        <?php for($i = $averageRating; $i < $totalStars; $i++): ?>
                                                            <img src="<?php echo e(asset('images/dashboard/outline-star.svg')); ?>"
                                                                alt="Outlined Star">
                                                        <?php endfor; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="position-relative">
                                                    <p class="review-text" id="driver-review-message">
                                                        <span class="initial-review">
                                                            <?php echo e(\Illuminate\Support\Str::limit($ride?->driverReview?->message, 15)); ?>

                                                        </span>
                                                        <span class="full-review d-none">
                                                            <?php echo e($ride?->driverReview?->message); ?>

                                                        </span>
                                                    </p>
                                                    <a href="javascript:void(0);" class="read-more"
                                                        onclick="toggleDriverReview()">
                                                        <?php echo e(__('taxido::static.rides.read_more')); ?>

                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="table-no-data">
                                <img src="<?php echo e(asset('images/dashboard/data-not-found.svg')); ?>" class="img-fluid"
                                    alt="data not found">
                                <h6 class="text-center">
                                    <?php echo e(__('taxido::static.widget.no_data_available')); ?>

                                </h6>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body rider-reviews p-0">
                    <?php if(isset($ride?->driverReview)): ?>
                        <div class="table-responsive h-custom-scrollbar">
                            <table class="table driver-review-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('taxido::static.rides.rider')); ?></th>
                                        <th><?php echo e(__('taxido::static.rides.rating')); ?></th>
                                        <th><?php echo e(__('taxido::static.rides.description')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="customer-image">
                                                    <?php if($ride?->driverReview?->rider?->profile_image?->original_url): ?>
                                                        <img src="<?php echo e($ride?->driverReview?->rider?->profile_image?->original_url); ?>"
                                                            alt="" id="driver-review-rider-image">
                                                    <?php else: ?>
                                                        <?php if(isset($ride?->driverReview?->rider)): ?>
                                                            <div class="initial-letter"
                                                                id="driver-review-rider-initial-container">
                                                                <span
                                                                    id="driver-review-rider-initial"><?php echo e(strtoupper($ride?->driverReview?->rider?->name[0])); ?></span>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h5 id="driver-review-rider-name">
                                                        <?php echo e($ride?->driverReview?->rider?->name); ?></h5>
                                                    <span id="driver-review-rider-email">
                                                        <?php echo e($ride?->driverReview?->rider?->email ?? ''); ?>

                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="rating" id="driver-review-rating">
                                                <?php if(isset($ride?->driverReview)): ?>
                                                    <?php
                                                        $averageRating = (int) $ride?->driverReview?->rating;
                                                        $totalStars = 5;
                                                    ?>
                                                    <?php for($i = 0; $i < $averageRating; $i++): ?>
                                                        <img src="<?php echo e(asset('images/dashboard/star.svg')); ?>"
                                                            alt="Filled Star">
                                                    <?php endfor; ?>
                                                    <?php for($i = $averageRating; $i < $totalStars; $i++): ?>
                                                        <img src="<?php echo e(asset('images/dashboard/outline-star.svg')); ?>"
                                                            alt="Outlined Star">
                                                    <?php endfor; ?>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="position-relative">
                                                <p class="review-text" id="driver-review-message">
                                                    <span class="initial-review">
                                                        <?php echo e(\Illuminate\Support\Str::limit($ride?->driverReview?->message, 15)); ?>

                                                    </span>
                                                    <span class="full-review d-none">
                                                        <?php echo e($ride?->driverReview?->message); ?>

                                                    </span>
                                                </p>
                                                <a href="javascript:void(0);" class="read-more"
                                                    onclick="toggleDriverReview()">
                                                    <?php echo e(__('taxido::static.rides.read_more')); ?>

                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="table-no-data">
                            <img src="<?php echo e(asset('images/dashboard/data-not-found.svg')); ?>" class="img-fluid"
                                alt="data not found">
                            <h6 class="text-center">
                                <?php echo e(__('taxido::static.widget.no_data_available')); ?>

                            </h6>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if($ride->ride_status_activities->isNotEmpty()): ?>
            <div class="card m-0 h-auto">
                <div class="card-header card-no-border">
                    <div class="header-top">
                        <div class="booking-title">
                            <h5 class="m-0">Ride Details of #<?php echo e($ride->ride_number); ?></h5>
                            <h6>Created <?php echo e($ride->created_at->format('j F Y, h:i A')); ?></h6>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="booking-details-box">
                        <div class="booking-content">
                            <ul class="booking-number-list">
                                <?php $__currentLoopData = $ride?->ride_status_activities->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <div class="activity-dot"></div>
                                        <div class="circle <?php echo e(\Modules\Taxido\Models\RideStatus::getActivityClassByStatus($activity->status)); ?>"></div>
                                        <div class="booking-number-box">
                                            <div class="left-box">
                                                <h6 class="date"><?php echo e(\Carbon\Carbon::parse($activity->created_at)->format('d-m-Y')); ?></h6>
                                                <h6 class="name"><?php echo e(ucfirst(str_replace('_', ' ', $activity->status))); ?></h6>
                                                <h6 class="text-pra"><?php echo e($activity->ride_status ? $activity->ride_status->description : \Modules\Taxido\Models\RideStatus::getDescriptionByStatus($activity->status)); ?></h6>
                                            </div>
                                            <div class="right-box">
                                                <h6><?php echo e(\Carbon\Carbon::parse($activity->created_at)->format('h:i A')); ?></h6>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="modal fade" id="bidding">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo e(__('taxido::static.rides.biddings')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="bidding-modal">
                        <ul class="h-custom-scrollbar" id="bids-list">
                            <?php $__empty_1 = true; $__currentLoopData = $ride?->bids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <li class="d-flex align-items-center">
                                    <div class="customer-image">
                                        <?php if($bid?->driver?->profile_image?->original_url): ?>
                                            <img src="<?php echo e($bid?->driver?->profile_image?->original_url); ?>"
                                                alt="">
                                        <?php else: ?>
                                            <div class="initial-letter">
                                                <span><?php echo e(strtoupper($bid?->driver?->name[0])); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5><?php echo e($bid?->driver?->name); ?></h5>
                                        <span><?php echo e(__('taxido::static.riders.rating')); ?>:
                                            <?php
                                                $averageRating = (int) $ride?->driver?->reviews?->avg('rating');
                                                $totalStars = 5;
                                            ?>
                                            <?php for($i = 0; $i < $averageRating; $i++): ?>
                                                <img src="<?php echo e(asset('images/dashboard/star.svg')); ?>" alt="Filled Star">
                                            <?php endfor; ?>
                                            <?php for($i = $averageRating; $i < $totalStars; $i++): ?>
                                                <img src="<?php echo e(asset('images/dashboard/outline-star.svg')); ?>"
                                                    alt="Outlined Star">
                                            <?php endfor; ?>
                                        </span>
                                    </div>
                                    <?php if($bid?->status == 'rejected'): ?>
                                        <div class="accept-bid">
                                            <h4><?php echo e(getDefaultCurrency()->symbol); ?><?php echo e($bid?->amount); ?></h4>
                                            <a href="#" class="btn btn-reject"><?php echo e(ucfirst($bid?->status)); ?></a>
                                        </div>
                                    <?php elseif($bid?->status == 'accepted'): ?>
                                        <div class="accept-bid">
                                            <h4><?php echo e(getDefaultCurrency()->symbol); ?><?php echo e($bid?->amount); ?></h4>
                                            <a href="#"
                                                class="btn bg-light-primary"><?php echo e(ucfirst($bid?->status)); ?></a>
                                        </div>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="no-data mt-3">
                                    <img src="<?php echo e(asset('images/no-data.png')); ?>" alt="">
                                    <h6 class="mt-2"><?php echo e(__('static.no_result')); ?></h6>
                                </div>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php if($settings['location']['map_provider'] == 'google_map'): ?>
    <?php if ($__env->exists('taxido::admin.ride.google')) echo $__env->make('taxido::admin.ride.google', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php elseif($settings['location']['map_provider'] == 'osm'): ?>
    <?php if ($__env->exists('taxido::admin.ride.osm')) echo $__env->make('taxido::admin.ride.osm', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<?php $__env->startPush('scripts'); ?>
    <!-- Firebase SDK -->
    <script src="<?php echo e(asset('js/firebase/firebase-app-compat.js')); ?>"></script>
    <script src="<?php echo e(asset('js/firebase/firebase-firestore-compat.js')); ?>"></script>

    <script>
        // Firebase configuration
        const firebaseConfig = {
            apiKey: "<?php echo e(env('FIREBASE_API_KEY')); ?>",
            authDomain: "<?php echo e(env('FIREBASE_AUTH_DOMAIN')); ?>",
            projectId: "<?php echo e(env('FIREBASE_PROJECT_ID')); ?>",
            storageBucket: "<?php echo e(env('FIREBASE_STORAGE_BUCKET')); ?>",
            messagingSenderId: "<?php echo e(env('FIREBASE_MESSAGING_SENDER_ID')); ?>",
            appId: "<?php echo e(env('FIREBASE_APP_ID')); ?>",
            measurementId: "<?php echo e(env('FIREBASE_MEASUREMENT_ID')); ?>"
        };

        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        const db = firebase.firestore();
        const instantData = doc.data();

        // Safe element updater
        function safeUpdateElement(id, value, attribute = 'textContent') {
            const element = document.getElementById(id);
            if (element && value !== undefined && value !== null) {
                if (attribute === 'textContent') {
                    element.textContent = value;
                } else if (attribute === 'src') {
                    element.src = value;
                } else if (attribute === 'href') {
                    element.href = value;
                } else if (attribute === 'className') {
                    element.className = value;
                }
            }
        }

        // Helper function to render star ratings safely
        function renderStars(rating, containerId) {
            const container = document.getElementById(containerId);
            if (!container) return;

            container.innerHTML = '';
            const totalStars = 5;
            const filledStars = Math.min(Math.max(0, Math.round(rating || 0)), totalStars);

            for (let i = 0; i < filledStars; i++) {
                const star = document.createElement('img');
                star.src = "<?php echo e(asset('images/dashboard/star.svg')); ?>";
                star.alt = "Filled Star";
                container.appendChild(star);
            }

            for (let i = filledStars; i < totalStars; i++) {
                const star = document.createElement('img');
                star.src = "<?php echo e(asset('images/dashboard/outline-star.svg')); ?>";
                star.alt = "Outlined Star";
                container.appendChild(star);
            }
        }

        // Helper function to format date safely
        function formatFirebaseTimestamp(timestamp) {
            if (!timestamp || !timestamp.toDate) return '';
            try {
                const date = timestamp.toDate();
                return date.toLocaleString('en-US', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: true
                });
            } catch (e) {
                console.error('Error formatting timestamp: ', e);
                return '';
            }
        }

        // Helper function to safely update profile image or initial
        function updateProfileImage(containerId, initialId, imgId, profileImage, name) {
            const container = document.getElementById(containerId);
            const initial = document.getElementById(initialId);
            const img = document.getElementById(imgId);
            if (!container || !initial || !img) return;
            if (profileImage) {
                img.src = profileImage;
                img.style.display = 'block';
                container.style.display = 'none';
            } else if (name && name.length > 0) {
                initial.textContent = name[0].toUpperCase();
                container.style.display = 'block';
                img.style.display = 'none';
            }
        }

        // Main function to listen for ride updates with error handling
        function setupFirebaseListener() {
            const rideId = "<?php echo e($ride->id); ?>";
            if (!rideId) {
                console.error('No ride ID found');
                return;
            }

            const rideStatusColorClasses = <?php echo json_encode($ridestatuscolorClasses, 15, 512) ?>;
            const paymentStatusColorClasses = <?php echo json_encode($paymentstatuscolorClasses, 15, 512) ?>;
            const currencySymbol = "<?php echo e(getDefaultCurrencySymbol()); ?>";

            db.collection('rides').doc(rideId).onSnapshot((doc) => {
                try {
                    if (!doc.exists) {
                        console.log('No such ride document!');
                        return;
                    }

                    const rideData = doc.data();

                    if (!rideData) return;

                    // Update general details
                    safeUpdateElement('ride-number-span', `#${rideData.ride_number || ''}`);

                    safeUpdateElement('service-name-span', rideData.service?.name || '');
                    safeUpdateElement('service-category-name-span', rideData.service_category?.name || '');
                    safeUpdateElement('ride-otp-span', rideData.otp || '');
                    safeUpdateElement('parcel-otp-span', rideData.parcel_delivered_otp || '');
                    safeUpdateElement('weight-span', rideData.weight || '');
                    safeUpdateElement('no-of-days-span', rideData.no_of_days || '');
                    safeUpdateElement('ambulance-name-span', rideData.driver?.ambulance?.name || '');
                    safeUpdateElement('distance-span', rideData.distance ?
                        `${rideData.distance} ${rideData.distance_unit || ''}` : '');
                    safeUpdateElement('zone-span', rideData.zones?.map(zone => zone.name).join(', ') || '');

                    // Update ride status
                    const rideStatus = rideData.ride_status?.slug ?
                        rideData.ride_status.slug.charAt(0).toUpperCase() + rideData.ride_status.slug.slice(1) : '';
                    safeUpdateElement('ride-status-span', rideStatus);
                    safeUpdateElement('ride-status-span',
                        `badge badge-${rideStatusColorClasses[rideStatus] || 'secondary'}`, 'className');

                    // Update payment status
                    const paymentStatus = rideData.payment_status ?
                        rideData.payment_status?.charAt(0)?.toUpperCase() + rideData.payment_status?.slice(1)
                        ?.toLowerCase() : '';
                    safeUpdateElement('payment-status-span', paymentStatus);
                    console.log(paymentStatusColorClasses[paymentStatus?.toUpperCase()], paymentStatusColorClasses,
                        paymentStatus, "paymment Class")
                    safeUpdateElement('payment-status-span',
                        `badge badge-${paymentStatusColorClasses[paymentStatus?.toUpperCase()] || 'secondary'}`,
                        'className');

                    // Update payment method image
                    if (rideData.payment_method) {
                        const paymentImg = document.getElementById('payment-method-img');
                        if (paymentImg) {
                            paymentImg.src = rideData.payment_method === 'cash' ?
                                "<?php echo e(asset('images/payment/cod.png')); ?>" :
                                "<?php echo e(getPaymentLogoUrl(strtolower($ride->payment_method))); ?>";
                        }
                    }

                    // Update driver details
                    if (rideData.driver) {
                        safeUpdateElement('driver-name', rideData.driver.name || '');
                        safeUpdateElement('driver-name', `<?php echo e(route('admin.driver.show', ['driver' => ':id'])); ?>`
                            .replace(':id', rideData.driver_id), 'href');
                        safeUpdateElement('driver-email-value', rideData.driver.email || '');
                        safeUpdateElement('driver-phone-value',
                            `+${rideData.driver.country_code || ''} ${rideData.driver.phone || ''}`);
                        safeUpdateElement('vehicle-number-value', rideData.driver?.vehicle_info?.plate_number ||
                            '');
                        safeUpdateElement('vehicle-name', rideData.driver?.vehicle_info?.vehicle?.name ?
                            `(${rideData.driver.vehicle_info.vehicle.name})` : '');

                        if (rideData.driver?.vehicle_info?.vehicle?.vehicle_image?.original_url) {
                            safeUpdateElement('vehicle-image', rideData.driver.vehicle_info.vehicle.vehicle_image
                                .original_url, 'src');
                        }

                        updateProfileImage(
                            'driver-initial-container',
                            'driver-initial-span',
                            'driver-profile-img',
                            rideData.driver.profile_image_url,
                            rideData.driver.name
                        );

                        const driverRating = rideData.driver.reviews?.length ?
                            rideData.driver.reviews.reduce((sum, r) => sum + (r.rating || 0), 0) / rideData.driver
                            .reviews.length :
                            0;
                        renderStars(Math.round(driverRating), 'driver-rating-stars');
                    }

                    if (instantData.cargo_image_url) {
                        $("#parcel-image").attr("src", instantData.cargo_image_url);
                    }

                    // Update rider details
                    if (rideData.rider) {
                        safeUpdateElement('rider-name', rideData.rider.name || '');
                        safeUpdateElement('rider-email-value', rideData.rider.email || '');
                        safeUpdateElement('rider-phone-value',
                            `+${rideData.rider.country_code || ''} ${rideData.rider.phone || ''}`);

                        updateProfileImage(
                            'rider-initial-container',
                            'rider-initial',
                            'rider-profile-img',
                            rideData.rider.profile_image_url,
                            rideData.rider.name
                        );

                        const riderRating = rideData.rider.reviews?.length ?
                            rideData.rider.reviews.reduce((sum, r) => sum + (r.rating || 0), 0) / rideData.rider
                            .reviews.length :
                            0;
                        renderStars(Math.round(riderRating), 'rider-rating-stars');
                    }

                    // Update price details
                    const cs = rideData.currency_symbol || currencySymbol;
                    safeUpdateElement('package-extra-charge-span',
                        `${cs}${(rideData.extra_charge?.toFixed(2) || 0)}`);
                    safeUpdateElement('vehicle-charge-span',
                        `${cs}${((rideData.vehicle_per_day_price?.toFixed(2) || 0) * (rideData.no_of_days || 0))}`
                    );
                    safeUpdateElement('driver-charge-span',
                        `${cs}${((rideData.driver_per_day_charge?.toFixed(2) || 0) * (rideData.no_of_days || 0))}`
                    );
                    safeUpdateElement('admin-commission-span', `${cs}${(rideData.commission?.toFixed(2) || 0)}`);
                    safeUpdateElement('subtotal-span', `${cs}${(rideData.sub_total || 0)}`);
                    safeUpdateElement('processing-fee-span', `${cs}${(rideData.processing_fee?.toFixed(2) || 0)}`);
                    safeUpdateElement('platform-fee-span', `${cs}${(rideData.platform_fees || 0)}`);
                    safeUpdateElement('coupon-discount-span',
                        `-${cs}${(rideData.coupon_total_discount?.toFixed(2) || 0)}`);
                    safeUpdateElement('tax-span', `${cs}${(rideData.tax || 0)}`);
                    safeUpdateElement('driver-tips-span', `${cs}${(rideData.driver_tips || 0)}`);
                    safeUpdateElement('total-span', `${cs}${(rideData.total || 0)}`);

                    safeUpdateElement('ride-fare-span', `${cs}${(rideData.ride_fare || 0)}`);
                    safeUpdateElement('additional-distance-charge-span',
                        `${cs}${(rideData.additional_distance_charge || 0)}`);
                    safeUpdateElement('additional-minute-charge-span',
                        `${cs}${(rideData.additional_minute_charge || 0)}`);
                    safeUpdateElement('additional-weight-charge-span',
                        `${cs}${(rideData.additional_weight_charge || 0)}`);

                    safeUpdateElement('rider-cancellation-charge-span',
                        `${cs}${(rideData.rider_cancellation_charge || 0)}`);
                    safeUpdateElement('driver-cancellation-charge-span',
                        `${cs}${(rideData.driver_cancellation_charge || 0)}`);


                    // Update comments and cancellation reason
                    safeUpdateElement('ride-comment', rideData.comment || '');
                    safeUpdateElement('cancellation-reason', rideData.cancellation_reason ||
                        '<?php echo e(__('taxido::static.rides.default_cancel_reason')); ?>');

                    // Update parcel details
                    safeUpdateElement('receiver-name', rideData.parcel_receiver?.name || '');
                    safeUpdateElement('receiver-phone', rideData.parcel_receiver ?
                        `+${rideData.parcel_receiver.country_code || ''} ${rideData.parcel_receiver.phone || ''}` :
                        '');
                    safeUpdateElement('parcel-delivered-otp', rideData.parcel_delivered_otp || '');

                    // Update rental vehicle details
                    safeUpdateElement('rental-vehicle-name', rideData.rental_vehicle?.name || '');
                    safeUpdateElement('rental-vehicle-registration', rideData.rental_vehicle?.registration_no ||
                        '');

                    if (rideData.rental_vehicle?.normal_image?.original_url) {
                        safeUpdateElement('rental-vehicle-image', rideData.rental_vehicle.normal_image.original_url,
                            'src');
                    }

                    if (rideData.is_with_driver == 1 && rideData.assigned_driver) {
                        safeUpdateElement('assigned-driver-name', rideData.assigned_driver.name || '');
                        safeUpdateElement('assigned-driver-phone',
                            `+${rideData.assigned_driver.country_code || ''} ${rideData.assigned_driver.phone || ''}`
                        );
                    }

                    // Update reviews
                    if (rideData.rider_review) {
                        safeUpdateElement('review-driver-name', rideData.rider_review.driver?.name || '');
                        safeUpdateElement('review-driver-email', rideData.rider_review.driver?.email || '');

                        const riderReviewMessage = document.getElementById('rider-review-message');
                        if (riderReviewMessage) {
                            const initialReview = riderReviewMessage.querySelector('.initial-review');
                            const fullReview = riderReviewMessage.querySelector('.full-review');
                            if (initialReview) initialReview.textContent = rideData.rider_review.message?.substring(
                                0, 15) || '';
                            if (fullReview) fullReview.textContent = rideData.rider_review.message || '';
                        }

                        updateProfileImage(
                            'review-driver-initial-container',
                            'review-driver-initial',
                            'review-driver-image',
                            rideData.rider_review.driver?.profile_image_url?.original_url,
                            rideData.rider_review.driver?.name
                        );

                        renderStars(rideData.rider_review.rating || 0, 'rider-review-rating');
                    }

                    if (rideData.driver_review) {
                        safeUpdateElement('driver-review-rider-name', rideData.driver_review.rider?.name || '');
                        safeUpdateElement('driver-review-rider-email', rideData.driver_review.rider?.email || '');

                        const driverReviewMessage = document.getElementById('driver-review-message');
                        if (driverReviewMessage) {
                            const initialReview = driverReviewMessage.querySelector('.initial-review');
                            const fullReview = driverReviewMessage.querySelector('.full-review');
                            if (initialReview) initialReview.textContent = rideData.driver_review.message
                                ?.substring(0, 15) || '';
                            if (fullReview) fullReview.textContent = rideData.driver_review.message || '';
                        }

                        updateProfileImage(
                            'driver-review-rider-initial-container',
                            'driver-review-rider-initial',
                            'driver-review-rider-image',
                            rideData.driver_review.rider?.profile_image?.original_url,
                            rideData.driver_review.rider?.name
                        );

                        renderStars(rideData.driver_review.rating || 0, 'driver-review-rating');
                    }

                    // Update locations
                    const locationsList = document.getElementById('locations-list');
                    if (locationsList && rideData.locations) {
                        locationsList.innerHTML = '';
                        const points = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('');
                        rideData.locations.forEach((location, index) => {
                            if (location) {
                                const li = document.createElement('li');
                                li.className = index === rideData.locations.length - 1 ? 'end-point' :
                                    'stop-point';
                                li.innerHTML = `${location}<span>${points[index] || ''}</span>`;
                                locationsList.appendChild(li);
                            }
                        });
                    }

                    // Update bids
                    const bidsList = document.getElementById('bids-list');
                    if (bidsList) {
                        bidsList.innerHTML = '';

                        if (!rideData.bids || rideData.bids.length === 0) {
                            bidsList.innerHTML = `
                            <div class="no-data mt-3">
                                <img src="<?php echo e(asset('images/no-data.png')); ?>" alt="">
                                <h6 class="mt-2"><?php echo e(__('static.no_result')); ?></h6>
                            </div>
                        `;
                        } else {
                            rideData.bids.forEach(bid => {
                                if (!bid) return;

                                const li = document.createElement('li');
                                li.className = 'd-flex align-items-center';

                                let driverImage = '';
                                if (bid.driver?.profile_image?.original_url) {
                                    driverImage =
                                        `<img src="${bid.driver.profile_image.original_url}" alt="">`;
                                } else if (bid.driver?.name) {
                                    driverImage =
                                        `<div class="initial-letter"><span>${bid.driver.name[0].toUpperCase()}</span></div>`;
                                }

                                const averageRating = bid.driver?.reviews?.length ?
                                    bid.driver.reviews.reduce((sum, r) => sum + (r.rating || 0), 0) / bid
                                    .driver.reviews.length :
                                    0;

                                li.innerHTML = `
                                <div class="customer-image">
                                    ${driverImage}
                                </div>
                                <div class="flex-grow-1">
                                    <h5>${bid.driver?.name || ''}</h5>
                                    <span><?php echo e(__('taxido::static.riders.rating')); ?>:
                                        ${'<img src="' + "<?php echo e(asset('images/dashboard/star.svg')); ?>" + '" alt="Filled Star">'.repeat(Math.round(averageRating))}
                                        ${'<img src="' + "<?php echo e(asset('images/dashboard/outline-star.svg')); ?>" + '" alt="Outlined Star">'.repeat(5 - Math.round(averageRating))}
                                    </span>
                                </div>
                                <div class="accept-bid">
                                    <h4>${currencySymbol}${(bid.amount || 0).toFixed(2)}</h4>
                                    <a href="#" class="btn ${bid.status === 'rejected' ? 'btn-reject' : 'bg-light-primary'}">
                                        ${bid.status ? bid.status.charAt(0).toUpperCase() + bid.status.slice(1) : ''}
                                    </a>
                                </div>
                            `;

                                bidsList.appendChild(li);
                            });
                        }
                    }
                } catch (error) {
                    console.error('Error processing ride update:', error);
                }
            }, (error) => {
                console.error("Error listening to ride updates:", error);
            });
        }

        // Initialize the Firebase listener when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            try {
                setupFirebaseListener();

                // Initialize map (this should be handled by your map provider include)
                if (typeof initMap === 'function') {
                    initMap(<?php echo json_encode($locationCoordinates, 15, 512) ?>, <?php echo json_encode($ride->locations, 15, 512) ?>);
                }
            } catch (error) {
                console.error('Error initializing ride details:', error);
            }
        });

        function toggleRiderReview() {
            try {
                const reviewText = document.getElementById('rider-review-message');
                if (!reviewText) return;

                const initialReview = reviewText.querySelector('.initial-review');
                const fullReview = reviewText.querySelector('.full-review');
                const readMoreLink = reviewText.nextElementSibling;

                if (!initialReview || !fullReview || !readMoreLink) return;

                initialReview.classList.toggle('d-none');
                fullReview.classList.toggle('d-none');

                if (fullReview.classList.contains('d-none')) {
                    readMoreLink.innerHTML = "<?php echo e(__('taxido::static.rides.read_more')); ?>";
                } else {
                    readMoreLink.innerHTML = "<?php echo e(__('taxido::static.rides.read_less')); ?>";
                }
            } catch (error) {
                console.error('Error toggling rider review:', error);
            }
        }

        function toggleDriverReview() {
            try {
                const reviewText = document.getElementById('driver-review-message');
                if (!reviewText) return;

                const initialReview = reviewText.querySelector('.initial-review');
                const fullReview = reviewText.querySelector('.full-review');
                const readMoreLink = reviewText.nextElementSibling;

                if (!initialReview || !fullReview || !readMoreLink) return;

                initialReview.classList.toggle('d-none');
                fullReview.classList.toggle('d-none');

                if (fullReview.classList.contains('d-none')) {
                    readMoreLink.innerHTML = "<?php echo e(__('taxido::static.rides.read_more')); ?>";
                } else {
                    readMoreLink.innerHTML = "<?php echo e(__('taxido::static.rides.read_less')); ?>";
                }
            } catch (error) {
                console.error('Error toggling driver review:', error);
            }
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/ride/details.blade.php ENDPATH**/ ?>