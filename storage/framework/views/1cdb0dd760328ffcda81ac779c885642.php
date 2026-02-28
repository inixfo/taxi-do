<?php use \Modules\Taxido\Models\Driver; ?>
<?php
    $drivers = Driver::whereNull('deleted_at')->where('status', true)->where('is_verified', true)->get();
?>
<div class="contentbox h-100">
    <div class="inside">
        <div class="contentbox-title">
            <h3> <?php echo e(__('taxido::static.wallets.select_driver')); ?></h3>
        </div>
        <div class="form-group row">
            <div class="col-12 select-item">
                <select id="select-driver" class="form-select form-select-transparent" name="driver_id"
                    data-placeholder="<?php echo e(__('taxido::static.wallets.select_driver')); ?>">
                    <option></option>
                    <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($driver->id); ?>" sub-title="<?php if(isDemoModeEnabled()): ?> 
                                            <?php echo e(__('taxido::static.demo_mode')); ?>

                                        <?php else: ?> 
                                            <?php echo e($driver->email); ?>

                                        <?php endif; ?>"
                                image="<?php echo e($driver?->profile_image ? $driver?->profile_image?->original_url : asset('images/user.png')); ?>"
                                <?php echo e($driver->id == request()->query('driver_id') ? 'selected' : ''); ?>>
                                <?php echo e($driver->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="text-gray mt-1">
                    <?php echo e(__('taxido::static.wallets.add_driver_message')); ?>

                    <a href="<?php echo e(@route('admin.driver.index')); ?>" class="text-primary">
                        <b><?php echo e(__('taxido::static.here')); ?></b>
                    </a>
                </span>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
    <script>
        (function($) {
            "use strict";

            const selectUser = () => {
                let queryString = window.location.search;
                let params = new URLSearchParams(queryString);
                params.set('driver_id', document.getElementById("select-driver").value);
                document.location.href = "?" + params.toString();
            }

            $('#select-driver').on('change', selectUser);
            const optionFormat = (item) => {
                if (!item.id) {
                    return item.text;
                }

                var span = document.createElement('span');
                var html = '';

                html += '<div class="selected-item">';
                html += '<img src="' + item.element.getAttribute('image') +
                    '" class="rounded-circle h-30 w-30" alt="' + item.text + '"/>';
                html += '<div class="detail">'
                html += '<h6>' + item.text + '</h6>';
                html += '<p>' + item.element.getAttribute('sub-title') + '</p>';
                html += '</div>';
                html += '</div>';

                span.innerHTML = html;
                return $(span);
            }

            $('#select-driver').select2({
                placeholder: "Select an option",
                templateSelection: optionFormat,
                templateResult: optionFormat
            });

        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/driver-wallet/drivers.blade.php ENDPATH**/ ?>