@endphp

<?php $__env->startSection('title', __('static.notifications.notification')); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xl-10 col-xxl-8 mx-auto">
            <div class="contentbox">
                <div class="inside">
                    <div class="contentbox-title">
                        <div class="contentbox-subtitle">
                            <h3><?php echo e(__('static.notifications.notification')); ?></h3>
                        </div>
                        <?php if($notifications->count()): ?>
                            <a href="#!" class="btn btn-solid more-action" id="clear-all">
                                <i class="ri-delete-bin-line"></i><?php echo e(__('static.notifications.all_clear')); ?>

                            </a>
                        <?php endif; ?>
                    </div>
                    <ul class="notification-setting" id="notification-list">
                        <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <li class="<?php echo e($notification->read_at ? '' : 'unread'); ?>" data-id="<?php echo e($notification->id); ?>">
                                <h4><?php echo e($notification->data['message'] ?? 'No message'); ?></h4>
                                <h5>
                                    <i class="ri-time-line"></i>
                                    <?php echo e($notification->created_at->format('Y-m-d h:i:s A')); ?>

                                </h5>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="no-data mt-3">
                                <img src="<?php echo e(url('/images/no-data.png')); ?>" alt="" class="w-25 h-auto">
                                <h6 class="mt-2"><?php echo e(__('static.notifications.no_notification_found')); ?></h6>
                            </div>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                let unreadNotifications = $('#notification-list li.unread').map(function() {
                    return $(this).data('id');
                }).get();

                if (unreadNotifications.length) {
                    $.post("<?php echo e(route('admin.notifications.markAsRead')); ?>", {
                        ids: unreadNotifications,
                        _token: '<?php echo e(csrf_token()); ?>'
                    }).done(function(response) {
                        if (response.status === 'success') {
                            $('#notification-list li.unread').removeClass('unread');
                        }
                    });
                }
            }, 2000);

            $('#clear-all').on('click', function(e) {
                e.preventDefault();

                $.post("<?php echo e(route('admin.notifications.clearAll')); ?>", {
                    _token: '<?php echo e(csrf_token()); ?>'
                }).done(function(response) {
                    if (response.status === 'success') {
                        $('#notification-list').empty();
                        $('.no-data-detail').show();
                        $('#clear-all').hide();
                    }
                });
            });

            if (!$('#notification-list li').length) {
                $('.no-data-detail').show();
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/resources/views/admin/notification/index.blade.php ENDPATH**/ ?>