<?php $__env->startComponent('mail::message'); ?>
    <strong>Ticket details: </strong><br>
    <strong>Name: </strong>Admin <br>
    <strong>Ticket Number: </strong><?php echo e($ticket->ticket_number); ?> <br>
    <strong>Message: </strong><br>
    Hello, <br>
    We wanted to provide you with an update regarding your recent ticket, ID. #<?php echo e($ticket->ticket_number); ?>. <br>
    Your ticket status has been updated to <?php echo e($ticket->ticketStatus->name); ?>.<br>
    Please feel free to reach out to us if you have any questions or need assistance.
<?php echo $__env->renderComponent(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Ticket/resources/views/admin/emails/status.blade.php ENDPATH**/ ?>