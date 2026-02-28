<?php $__env->startComponent('mail::message'); ?>
            <h3 class="card-title"><?php echo e(@$content['title'][$locale]); ?></h3>
            <p class="card-text"><?php echo @$emailContent; ?></p>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/emails/email-template.blade.php ENDPATH**/ ?>