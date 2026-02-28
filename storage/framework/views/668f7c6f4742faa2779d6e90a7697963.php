<?php if(isset($document)): ?>
    <div class="modal-icon-box">
        <a href="javascript:void(0)" data-bs-toggle="modal" class="dark-icon-box"
            data-bs-target="#documentModal<?php echo e($document?->id); ?>">
            <i class="ri-eye-line"></i>
        </a>

        <a href="javascript:void(0)" class="dark-icon-box status-option"
           data-status="approved"
           data-document-id="<?php echo e($document->id); ?>"
           title="Approve">
            <i class="ri-checkbox-circle-line"></i>
        </a>

        <a href="javascript:void(0)" class="dark-icon-box status-option"
           data-status="rejected" data-document-id="<?php echo e($document->id); ?>"
           title="Reject">
            <i class="ri-close-circle-fill"></i>
        </a>

        <div class="modal fade document-view-modal" id="documentModal<?php echo e($document?->id); ?>" tabindex="-1"
            aria-labelledby="documentModalLabel<?php echo e($document?->id); ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header pb-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="doc-detail">
                            <div class="doc-img">
                                <img src="<?php echo e($document?->document_image?->original_url ?? asset('images/avtar/16.jpg')); ?>" alt="user">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="<?php echo e(route('admin.vehicleInfoDoc.updateStatus', $document->id)); ?>" id="statusForm<?php echo e($document->id); ?>">
      <?php echo csrf_field(); ?>
      <?php echo method_field('PUT'); ?>
      <input type="hidden" name="status" value="" id="statusInput<?php echo e($document->id); ?>">
        <div class="modal fade confirmation-modal" id="confirmation<?php echo e($document?->id); ?>" tabindex="-1" role="dialog"
            aria-labelledby="confirmationLabel<?php echo e($document?->id); ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-start confirmation-data">
                        <div class="main-img">
                            <div class="delete-icon">
                                <i class="ri-question-mark"></i>
                            </div>
                        </div>
                        <h4 class="modal-title"><?php echo e(__('taxido::static.wallets.confirmation')); ?></h4>
                        <p>
                            <?php echo e(__('taxido::static.documents.status_update_note')); ?>

                        </p>
                        <div class="d-flex">
                            <a type="button" href="<?php echo e(route('admin.fleet-document.index')); ?>" class="btn cancel btn-light me-2"><?php echo e(__('taxido::static.wallets.no')); ?></a>
                            <button type="submit" class="btn btn-primary delete delete-btn spinner-btn"><?php echo e(__('taxido::static.wallets.yes')); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </form>
<?php endif; ?>
<?php $__env->startPush('scripts'); ?>
<script>
    function toggleDropdown(event, docId) {
        event.stopPropagation();
        document.querySelectorAll('.dropdown-popover').forEach(el => el.style.display = 'none');
        const dropdown = document.getElementById('dropdownContainer' + docId);
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    document.addEventListener('click', function(event) {
        document.querySelectorAll('.dropdown-popover').forEach(dropdown => {
            if (!dropdown.contains(event.target) && !event.target.closest('.dark-icon-box')) {
                dropdown.style.display = 'none';
            }
        });
    });

    document.querySelectorAll('.status-option').forEach(function(el) {
        el.addEventListener('click', function(e) {
            e.preventDefault();
            const status = this.dataset.status;
            const docId = this.dataset.documentId;

            const input = document.getElementById('statusInput' + docId);
            input.value = status;

            const modalEl = document.getElementById('confirmation' + docId);
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/vehicle-info-doc/show.blade.php ENDPATH**/ ?>