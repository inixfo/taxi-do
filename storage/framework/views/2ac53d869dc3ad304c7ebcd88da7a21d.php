<?php
    $locale = Session::get('front-locale',getDefaultLangLocale());
?>

<?php $__env->startSection('title', __('static.pages.page')); ?>
<?php $__env->startSection('content'); ?>

    <body>
        <section class="privacy-policy-details-section section-b-space">
            <div class="container">
                <div class="page-title">
                    <h2><?php echo e($page->title); ?></h2>
                    <h6><?php echo e($page->created_at->format('jS F Y')); ?></h6>
                </div>

                <div class="page-content">
                    <?php echo $page->content; ?>

                </div>
            </div>
        </section>
    </body>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/resources/views/front/pages/details.blade.php ENDPATH**/ ?>