<?php if(isset($delete)): ?>
<?php $__env->startPush('scripts'); ?>
<script>
    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        var route = button.data('route');    
        var title = button.data('title');    
        var description = button.data('description'); 
        var modal = $(this);

        modal.find('form').attr('action', route);

        // Update modal title dynamically (if applicable)
        if (title) {
            modal.find('.modal-title').text(title);
        }

        // Update modal description dynamically (if applicable)
        if (description) {
            modal.find('.modal-body p').text(description);
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH /var/www/taxido/Taxido_laravel/resources/views/inc/delete-modal.blade.php ENDPATH**/ ?>