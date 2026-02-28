<?php use \Modules\Taxido\Models\Rider; ?>
<?php
    $riders = Rider::whereNull('deleted_at')->where('status', true)->get();
?>

<div class="contentbox h-100">
    <div class="inside">
        <div class="contentbox-title">
            <h3> <?php echo e(__('taxido::static.wallets.select_rider')); ?></h3>
        </div>
        <div class="form-group row">
            <div class="col-12 select-item">
                <select id="select-rider" class="form-select form-select-transparent" name="rider_id"
                    data-placeholder="<?php echo e(__('taxido::static.wallets.select_rider')); ?>">
                    <option></option>
                    <?php $__currentLoopData = $riders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($rider->id); ?>" sub-title="<?php if(isDemoModeEnabled()): ?> 
                                            <?php echo e(__('taxido::static.demo_mode')); ?>

                                        <?php else: ?> 
                                            <?php echo e($rider->email); ?>

                                        <?php endif; ?>"
                            image="<?php echo e($rider?->profile_image ? $rider?->profile_image?->original_url : asset('images/user.png')); ?>"
                            <?php echo e($rider->id == request()->query('rider_id') ? 'selected' : ''); ?>>
                            <?php echo e($rider->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="text-gray">
                    <?php echo e(__('taxido::static.wallets.add_rider_message')); ?>

                    <a href="<?php echo e(route('admin.rider.index')); ?>" class="text-primary">
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
                console.log(queryString)
                let params = new URLSearchParams(queryString);
                params.set('rider_id', document.getElementById("select-rider").value);
                document.location.href = "?" + params.toString();
            }

            $('#select-rider').on('change', selectUser);
            const optionFormat = (item) => {
                if (!item.id) {
                    return item.text;
                }

                var span = document.createElement('span');
                var html = '';

                html += '<div class="selected-item">';
                html += '<img src="' + item.element.getAttribute('image') +
                    '" class="rounded-circle" alt="' + item.text + '"/>';
                html += '<div class="detail">'
                html += '<h6>' + item.text + '</h6>';
                html += '<p>' + item.element.getAttribute('sub-title') + '</p>';
                html += '</div>';
                html += '</div>';

                span.innerHTML = html;
                return $(span);
            }

            $('#select-rider').select2({
                placeholder: "Select an option",
                templateSelection: optionFormat,
                templateResult: optionFormat
            });

        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/rider-wallet/riders.blade.php ENDPATH**/ ?>