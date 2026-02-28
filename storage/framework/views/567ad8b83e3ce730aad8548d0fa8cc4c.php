<div class="contentbox h-100">
    <div class="inside h-100 d-flex align-items-center">
        <div class="wallet-detail">
            <div class="wallet-detail-content">
                <div class="wallet-amount withdraw-box">
                    <div class="wallet-icon">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('fleet_withdraw_request.create')): ?>
                        <button type="button" id="fleet-withdraw-request" class="btn">
                            <i class="ri-add-line"></i>
                            <span><?php echo e(__('taxido::static.fleet_withdraw_requests.send_withdrawRequest')); ?></span>
                        </button>
                        <?php endif; ?>
                    </div>
                    <div>
                        <div class="form-group row">
                            <div class="col-md-10">
                                <h5 class="lh-1"></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade confirmation-modal" id="confirmation">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title"><?php echo e(__('taxido::static.fleet_withdraw_requests.withdraw_request')); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-start">
                <form action="<?php echo e(route('admin.fleet-withdraw-request.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('POST'); ?>
                    <div class="form-group row">
                        <label class="col-md-2" for="amount"><?php echo e(__('taxido::static.fleet_withdraw_requests.amount')); ?><span>*</span></label>
                        <div class="col-md-10">
                            <input class="form-control" type="number" name="amount" placeholder="Enter Request Amount" value="<?php echo e(old('amount')); ?>" required>
                            <?php $__errorArgs = ['amount'];
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
                        <label class="col-md-2" for="payment_type"><?php echo e(__('taxido::static.fleet_withdraw_requests.payment_type')); ?><span>*</span></label>
                        <div class="col-md-10">
                            <select class="form-select select-2" name="payment_type" data-placeholder="<?php echo e(__('Select Payment Type')); ?>">
                                <option class="option" value="" selected></option>
                                <option class="option" value="bank"><?php echo e(__('taxido::static.fleet_withdraw_requests.bank')); ?></option>
                                <option class="option" value="paypal"><?php echo e(__('taxido::static.fleet_withdraw_requests.paypal')); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="message"><?php echo e(__('taxido::static.fleet_withdraw_requests.message')); ?></label>
                        <div class="col-md-10">
                            <textarea class="form-control" rows="3" name="message" placeholder="<?php echo e(__('taxido::static.fleet_withdraw_requests.enter_message')); ?>" cols="80"></textarea>
                            <?php $__errorArgs = ['message'];
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
                    <div class="modal-footer px-0 pb-0">
                        <div class="submit-btn">
                            <button type="submit" name="save" class="btn btn-solid spinner-btn">
                                <?php echo e(__('taxido::static.submit')); ?>

                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function() {
            $('#fleet-withdraw-request').on('click', function() {
                var myModal = new bootstrap.Modal(document.getElementById("confirmation"), {});
                myModal.show();
            });
        });
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/fleet-withdraw-request/fleet_managers.blade.php ENDPATH**/ ?>