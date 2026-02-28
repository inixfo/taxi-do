<?php $__env->startComponent('mail::message'); ?>
    <strong>Ticket details: </strong><br>
    <strong>Name: </strong>Admin <br>
    <strong>Ticket Number: </strong><?php echo e($contact->ticket->ticket_number); ?> <br>
    <strong>Message: </strong><?php echo $contact->message; ?> <br><br>
<?php echo $__env->renderComponent(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Ticket/resources/views/admin/emails/replied.blade.php ENDPATH**/ ?>