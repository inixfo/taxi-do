<div class="contentbox">
    <div class="inside">
        <div class="wallet-detail">
            <div class="wallet-detail-content">
                <div class="wallet-amount">
                    <div class="wallet-icon">
                        <i class="ri-wallet-line"></i>
                    </div>
                    <div>
                        <div class="form-group row">
                            <?php if(isset($label)): ?>
                                <label class="col-md-2" for="name"><?php echo e(__('taxido::static.withdraw_requests.balance')); ?><span>*</span></label>
                            <?php endif; ?>
                            <div class="col-md-10">
                                <h4><?php echo e(getDefaultCurrency()?->symbol); ?><input class="form-control" type="text" name="name" min="1" id="balanceLabel" readonly value="<?php echo e(isset($balance) ? number_format($balance, 2) : '0.00'); ?>"></h4>
                                <h5 class="lh-1"><?php echo e(__('taxido::static.withdraw_requests.pending_balance')); ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/withdraw-request/amount.blade.php ENDPATH**/ ?>