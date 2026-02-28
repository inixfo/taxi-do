    <?php use \Modules\Taxido\Models\FleetManager; ?>
<?php
    $fleetManagers = FleetManager::whereNull('deleted_at')->where('status', true)->get();
?>

<div class="contentbox h-100">
    <div class="inside">
        <div class="contentbox-title">
            <h3> <?php echo e(__('taxido::static.wallets.select_fleet_manager')); ?></h3>
        </div>
        <div class="form-group row">
            <div class="col-12 select-item">
                <select id="select-fleet-manager" class="form-select form-select-transparent" name="fleet_manager_id"
                    data-placeholder="<?php echo e(__('taxido::static.wallets.select_fleet_manager')); ?>">
                    <option></option>
                    <?php $__currentLoopData = $fleetManagers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manager): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($manager->id); ?>"
                            sub-title="<?php echo e($manager->email); ?>"
                            image="<?php echo e($manager?->profile_image ? $manager?->profile_image?->original_url : asset('images/user.png')); ?>"
                            <?php echo e($manager->id == request()->query('fleet_manager_id') ? 'selected' : ''); ?>>
                            <?php echo e($manager->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="text-gray">
                    <?php echo e(__('taxido::static.wallets.add_fleet_manager_message')); ?>

                    <a href="<?php echo e(route('admin.fleet-manager.index')); ?>" class="text-primary">
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

           const selectFleetManager = () => {
                let queryString = window.location.search;
                let params = new URLSearchParams(queryString);
                params.set('fleet_manager_id', document.getElementById("select-fleet-manager").value);
                document.location.href = "?" + params.toString();
            }
            $('#select-fleet-manager').on('change', selectFleetManager);

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

            $('#select-fleet-manager').select2({
                placeholder: "Select an option",
                templateSelection: optionFormat,
                templateResult: optionFormat
            });

        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/fleet-wallet/fleets.blade.php ENDPATH**/ ?>