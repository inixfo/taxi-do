<?php $__env->startComponent('mail::message'); ?>
    <strong>Contect Us details: </strong><br>
    <strong>Name: </strong>Admin <br>
    <strong>Message: </strong>Thank You for connecting with us. Your Ticket has been created <br>
    <strong>Ticket Number is: </strong>#<?php echo e($ticket->ticket_number); ?> <br>
<?php echo $__env->renderComponent(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Ticket/resources/views/admin/emails/created.blade.php ENDPATH**/ ?>