<?php if(isset($withdrawRequest)): ?>
<div class="modal-icon-box">
    <a href="javascript:void(0)" data-bs-toggle="modal" class="dark-icon-box" data-bs-target="#withdrawRequestModal<?php echo e($withdrawRequest->id); ?>">
        <i class="ri-eye-line"></i>
    </a>
    <div class="modal fade" id="withdrawRequestModal<?php echo e($withdrawRequest->id); ?>" tabindex="-1" aria-labelledby="withdrawRequestModalLabel<?php echo e($withdrawRequest->id); ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo e(__('taxido::static.withdraw_requests.withdraw_request')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="withdraw-detail">
                        <div class="form-group row">
                            <label class="col-md-2" for="message"><?php echo e(__('taxido::static.withdraw_requests.message')); ?></label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="message" value="<?php echo e($withdrawRequest->message ?? old('message')); ?>" disabled>
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
                        <div class="form-group row">
                            <label class="col-md-2" for="amount"><?php echo e(__('taxido::static.withdraw_requests.amount')); ?></label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="amount" value="<?php echo e($withdrawRequest->amount ?? old('amount')); ?>" disabled>
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
                            <label class="col-md-2" for="payment_type"><?php echo e(__('taxido::static.withdraw_requests.payment_type')); ?></label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="payment_type" value="<?php echo e($withdrawRequest->payment_type ?? old('payment_type')); ?>" disabled>
                                <?php $__errorArgs = ['payment_type'];
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
                            <label class="col-md-2" for="status"><?php echo e(__('taxido::static.withdraw_requests.status')); ?></label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="status" value="<?php echo e($withdrawRequest->status ?? old('status')); ?>" disabled>
                                <?php $__errorArgs = ['status'];
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
                        <?php if(Auth::user()->hasRole('admin') && strtolower($withdrawRequest->status) === strtolower(\Modules\Taxido\Enums\RequestEnum::PENDING)): ?>
                            <form action="<?php echo e(route('admin.withdraw-request.update', $withdrawRequest->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <div class="submit-btn">
                                            <button type="submit" name="status" value="approved" class="btn btn-solid">
                                                <?php echo e(__('Approve')); ?>

                                            </button>
                                            <button type="submit" name="status" value="rejected" class="btn btn-danger">
                                                <?php echo e(__('Reject')); ?>

                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/withdraw-request/show.blade.php ENDPATH**/ ?>