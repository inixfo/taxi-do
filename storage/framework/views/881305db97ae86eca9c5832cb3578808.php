<?php
    $languages = getLanguages();
    $defaultLocale = app()?->getLocale();
?>

<?php $__env->startSection('title', $eventAndShortcodes['name']); ?>

<?php $__env->startSection('content'); ?>
    <div class="contentbox">
        <div class="inside">
            <div class="contentbox-title">
                <div class="contentbox-subtitle">
                    <h3><?php echo e(@$eventAndShortcodes['name']); ?></h3>
                </div>
            </div>

            <div class="button-container">
                <?php $__empty_1 = true; $__currentLoopData = $eventAndShortcodes['shortcodes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $shortcode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <button class="btn btn-primary shortcode-button"
                        data-text="<?php echo e($shortcode['action']); ?>"><?php echo e($shortcode['text']); ?></button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <?php endif; ?>
            </div>

            <div>
                <ul class="nav nav-tabs horizontal-tab custom-scroll" id="account" role="tablist">
                    <?php $__empty_1 = true; $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php if($loop->first): ?> active <?php endif; ?>"
                                id="tab-<?php echo e($language['locale']); ?>-tab" data-bs-toggle="tab"
                                href="#tab-<?php echo e($language['locale']); ?>" role="tab"
                                aria-controls="tab-<?php echo e($language['locale']); ?>"
                                aria-selected="<?php echo e($loop->first ? 'true' : 'false'); ?>">
                                <img src="<?php echo e(asset($language['flag'])); ?>"></i>
                                <?php echo e($language['name']); ?>

                                <i class="ri-error-warning-line danger errorIcon"></i>
                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <?php endif; ?>
                </ul>

                <form method="POST" id="pushNotificationTemplatesForm"
                    action="<?php echo e(route('admin.push-notification-template.update', @$slug)); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="tab-content" id="accountContent">
                        <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="tab-pane fade <?php echo e(session('active_tab') == $key ? 'show active' : ''); ?>"
                                id="tab-<?php echo e($language['locale']); ?>" role="tabpanel"
                                aria-labelledby="tab-<?php echo e($language['locale']); ?>-tab">
                                <div class="row g-4 align-items-start">
                                    <div class="col-12 col-md-7">
                                        <div class="push-notification">
                                            <div class="row g-4 align-items-center">
                                                <div class="col-12">
                                                    <div class="form-group row">
                                                        <label class="col-md-2"
                                                            for="title"><?php echo e(__('static.notify_templates.title')); ?><span>*</span></label>
                                                        <div class="col-md-10">
                                                            <input class="form-control" type="text"
                                                                id="title_<?php echo e($language['locale']); ?>"
                                                                name="title[<?php echo e($language['locale']); ?>]"
                                                                value="<?php echo e(@$content['title'][$language['locale']]); ?>"
                                                                placeholder="<?php echo e(__('static.notify_templates.enter_title')); ?>">
                                                            <?php $__errorArgs = ["title.{$language['locale']}"];
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
                                                        <label class="col-md-2"
                                                            for="content"><?php echo e(__('static.notify_templates.content')); ?></label>
                                                        <div class="col-md-10">
                                                            <textarea class="form-control" placeholder="<?php echo e(__('static.notify_templates.enter_content')); ?>" rows="4"
                                                                id="content_<?php echo e($language['locale']); ?>" name="content[<?php echo e($language['locale']); ?>]" cols="50"><?php echo e(@$content['content'][$language['locale']]); ?></textarea>
                                                            <?php $__errorArgs = ["content.{$language['locale']}"];
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
                                                        <label class="col-md-2"
                                                            for="url"><?php echo e(__('static.notify_templates.url')); ?></label>
                                                        <div class="col-md-10">
                                                            <input class="form-control" id="url_<?php echo e($language['locale']); ?>"
                                                                type="url"
                                                                placeholder="<?php echo e(__('static.notify_templates.enter_url')); ?>"
                                                                name="url[<?php echo e($language['locale']); ?>]"
                                                                value="<?php echo e(@$content['url'][$language['locale']]); ?>">
                                                            <?php $__errorArgs = ["url.{$language['locale']}"];
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
                                                        <div class="col-12">
                                                            <div class="submit-btn">
                                                                <button type="submit" name="save"
                                                                    class="btn btn-solid spinner-btn">
                                                                    <?php echo e(__('static.notify_templates.save')); ?>

                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xxl-5 col-xl-4 text-center">
                                        <div class="notification-mobile-box">
                                            <div class="notify-main">
                                                <img src="<?php echo e(asset('/images/notify.png')); ?>" class="notify-img">
                                                <div class="notify-content">
                                                    <h2 class="current-time" id="current-time"></h2>
                                                    <div class="notify-data">
                                                        <div class="message mt-0">
                                                            <img id="notify-image" src="<?php echo e(asset('images/favicon.svg')); ?>"
                                                                alt="user">
                                                            <div class="notifi-head">
                                                                <h5 id="notify-title">
                                                                    <?php echo e(@$content['title'][$language['locale']]); ?></h5>
                                                                <span><?php echo e(__('static.notify_templates.3_min_ago')); ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="notify-footer">
                                                            <p id="notify-message">
                                                                <?php echo e(@$content['content'][$language['locale']]); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript" src="<?php echo e(asset('js/flatpickr/time.js')); ?>"></script>
    <script>
        (function($) {
            "use strict";

            const defaultLocale = `<?php echo $defaultLocale; ?>`;

            $('#pushNotificationTemplatesForm').validate({
                ignore: [],
                rules: {
                    [`title[${defaultLocale}]`]: "required",
                    [`content[${defaultLocale}]`]: "required",
                },
                invalidHandler: function(event, validator) {
                    const $tabLink = $(`#tab-${defaultLocale}-tab`);
                    $tabLink.find(".errorIcon").show();
                    $(".nav-link.active").removeClass("active");
                    $(".tab-pane.show").removeClass("show active");
                    $(`#tab-${defaultLocale}`).addClass("show active");
                    $tabLink.addClass("active");
                },
                success: function(label, element) {
                    const $tabLink = $(`#tab-${defaultLocale}-tab`);
                    const $invalidFields = $(`#tab-${defaultLocale}`).find(".error:visible");
                    if ($invalidFields.length === 0) {
                        $tabLink.find(".errorIcon").hide();
                    }
                }
            });

            $('.shortcode-button').on('click', function() {
                var text = $(this).data('text');

                var activeTab = $('.tab-pane.show.active');
                var languageLocale = activeTab.attr('id').split('-')[1];
                var textarea = $('#content_' + languageLocale);

                var start = textarea[0].selectionStart;
                var end = textarea[0].selectionEnd;

                textarea.val(textarea.val().substring(0, start) + text + textarea.val().substring(end));

                textarea[0].selectionStart = textarea[0].selectionEnd = start + text.length;

                textarea.focus();
            });
        })(jQuery)
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/resources/views/admin/push-notification-template/template.blade.php ENDPATH**/ ?>