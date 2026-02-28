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

            <div>
                <ul class="language-list accept-bid custom-scroll" id="account" role="tablist">
                    <?php $__empty_1 = true; $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php if($loop->first): ?> active <?php endif; ?>"
                                id="tab-<?php echo e($language['locale']); ?>-tab" data-bs-toggle="tab"
                                href="#tab-<?php echo e($language['locale']); ?>" role="tab"
                                aria-controls="tab-<?php echo e($language['locale']); ?>"
                                aria-selected="<?php echo e($loop->first ? 'true' : 'false'); ?>">
                                <img src="<?php echo e(asset($language['flag'])); ?>">
                                <?php echo e($language['name']); ?>

                                <i class="ri-error-warning-line errorIcon"></i>
                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <?php endif; ?>
                </ul>

                <form method="POST" id="emailTemplatesForm" action="<?php echo e(route('admin.email-template.update', @$slug)); ?>"
                    enctype="multipart/form-data">
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
                                                            <textarea class="form-control email-content" placeholder="<?php echo e(__('static.notify_templates.enter_content')); ?>"
                                                                rows="4" id="content_<?php echo e($language['locale']); ?>" name="content[<?php echo e($language['locale']); ?>]" cols="50"><?php echo e(@$content['content'][$language['locale']]); ?></textarea>
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


                                    <div class="col-12 col-md-5">
                                        <div class="card email-template-box email-send">
                                            <div class="card-body">
                                                <h5 class="card-title" id="email-notify-title">
                                                    <?php echo e(@$content['title'][$language['locale']]); ?>

                                                </h5>
                                                <div class="email-template-contain" id="email-notify-content">
                                                    <?php if(!empty($content['content'][$language['locale']])): ?>
                                                        <?php echo $content['content'][$language['locale']]; ?>

                                                    <?php else: ?>
                                                        <h6><?php echo e(__('static.notify_templates.enter_content')); ?> </h6>
                                                    <?php endif; ?>
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
    <script>
        (function($) {
            "use strict";
            const defaultLocale = `<?php echo $defaultLocale; ?>`;
            $('#emailTemplatesForm').validate({
                ignore: [],
                rules: {
                    [`title[${defaultLocale}]`]: "required",

                },
                messages: {
                    [`title[${defaultLocale}]`]: "This field is required.",

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

            if ($.fn.tinymce) {
                tinymce.init({
                    selector: '.email-content',
                    setup: function(editor) {
                        editor.on('change input', function() {
                            const contentId = editor.id;
                            const language = contentId.split('_').pop();
                            const content = editor.getContent();

                            // document.querySelector(`#email-notify-content`).innerHTML = content;
                            // var text = document.querySelector(`#email-notify-content`).innerHTML;
                            // console.log(text);

                            const plainText = content.replace(/<[^>]*>/g, '').replace(/&nbsp;/g, '')
                                .trim();

                            const container = document.querySelector(`#email-notify-content`);

                            if (plainText === '') {
                                // Show fallback message
                                container.innerHTML = '<h6><?php echo e(__('static.notify_templates.enter_content')); ?> </h6>';
                            } else {
                                // Show content as-is
                                container.innerHTML = content;
                            }

                        });
                    },
                    plugins: [
                        'shortcodes',
                        "advlist autolink lists link image charmap print preview anchor",
                        "searchreplace visualblocks code fullscreen",
                        "insertdatetime media table paste"
                    ],
                    toolbar: [
                        "insertfile undo redo | styleselect | bold italic underline strikethrough | formatselect | shortcodes | forecolor backcolor code table | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
                    ],
                    image_title: true,
                    file_picker_types: 'image',
                    relative_urls: false,
                    remove_script_host: false,
                    images_upload_handler: function(blobInfo, success, failure) {
                        var formData = new FormData();
                        formData.append('file', blobInfo.blob(), blobInfo.filename());
                        var $csrfToken = $('meta[name="csrf-token"]').attr('content');

                        $.ajax({
                            url: "<?php echo e(url('admin/media/upload')); ?>",
                            type: 'POST',
                            data: formData,
                            headers: {
                                'X-CSRF-TOKEN': $csrfToken
                            },
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                if (response.location) {
                                    success(response.location);
                                } else {
                                    failure('Invalid JSON response');
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                failure('Image upload failed: ' + textStatus + ' - ' +
                                    errorThrown);
                            }
                        });
                    },
                    menubar: false,
                    branding: false,
                    placeholder: 'Enter your text here...',
                });
            }

            var shortcodes = <?php echo json_encode($eventAndShortcodes['shortcodes'], 15, 512) ?>;
            tinymce.PluginManager.add('shortcodes', function(editor, url) {
                var toggleState = false;
                editor.ui.registry.addMenuButton('shortcodes', {
                    icon: 'sourcecode',
                    text: 'Shortcodes',
                    fetch: function(callback) {
                        var items = shortcodes.map(function(shortcode) {
                            return {
                                type: 'menuitem',
                                text: shortcode.text,
                                onAction: function() {
                                    editor.insertContent('&nbsp;<p>' + shortcode
                                        .action + '</p>');
                                }
                            };
                        });
                        callback(items);
                    }
                });
            });

        })(jQuery)
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/resources/views/admin/email-template/template.blade.php ENDPATH**/ ?>