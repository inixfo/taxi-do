<?php $__env->startSection('title', __('Tiered Pricing')); ?>
<?php $__env->startSection('content'); ?>
<div class="contentbox">
    <div class="inside">
        <div class="contentbox-title">
            <div class="d-flex align-items-center gap-3">
                <a href="<?php echo e(url()->previous()); ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="ri-arrow-left-line"></i> Back
                </a>
                <div>
                    <h3>Tiered Pricing</h3>
                    <p class="text-muted mb-0">
                        <?php echo e($vehicleTypeZone->vehicleType->name ?? 'Vehicle Type'); ?> - 
                        <?php echo e($vehicleTypeZone->zone->name ?? 'Zone'); ?>

                    </p>
                </div>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTierModal">
                <i class="ri-add-line"></i> Add Tier
            </button>
        </div>

        <div class="alert alert-info">
            <i class="ri-information-line"></i>
            Configure different per-mile/km rates based on distance ranges. For example: £3.00/mile for 0-1 miles, £2.50/mile for 1-3 miles, etc.
        </div>

        <?php if($tiers->isEmpty()): ?>
            <div class="text-center py-5">
                <i class="ri-price-tag-3-line" style="font-size: 48px; color: #ccc;"></i>
                <p class="text-muted mt-3">No tiered pricing configured yet.</p>
                <button class="btn btn-success" id="createDefaultTiers">
                    <i class="ri-magic-line"></i> Create Default UK Tiers
                </button>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Distance Range</th>
                            <th>Per Distance Charge</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tiersTableBody">
                        <?php $__currentLoopData = $tiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr data-tier-id="<?php echo e($tier->id); ?>">
                                <td><?php echo e($tier->tier_label); ?></td>
                                <td><?php echo e(getDefaultCurrency()?->symbol); ?><?php echo e(number_format($tier->per_distance_charge, 2)); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo e($tier->status ? 'success' : 'danger'); ?>">
                                        <?php echo e($tier->status ? 'Active' : 'Inactive'); ?>

                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary edit-tier" 
                                            data-tier='<?php echo json_encode($tier, 15, 512) ?>'>
                                        <i class="ri-edit-line"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-warning toggle-status" 
                                            data-id="<?php echo e($tier->id); ?>">
                                        <i class="ri-toggle-line"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger delete-tier" 
                                            data-id="<?php echo e($tier->id); ?>">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Add/Edit Tier Modal -->
<div class="modal fade" id="addTierModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Pricing Tier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="tierForm">
                <div class="modal-body">
                    <input type="hidden" name="id" id="tierId">
                    <input type="hidden" name="vehicle_type_zone_id" value="<?php echo e($vehicleTypeZone->id); ?>">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Min Distance</label>
                            <input type="number" class="form-control" name="min_distance" id="minDistance" 
                                   step="0.01" min="0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Max Distance <small class="text-muted">(leave empty for unlimited)</small></label>
                            <input type="number" class="form-control" name="max_distance" id="maxDistance" 
                                   step="0.01" min="0">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Per Distance Charge (<?php echo e(getDefaultCurrency()?->symbol); ?>)</label>
                        <input type="number" class="form-control" name="per_distance_charge" id="perDistanceCharge" 
                               step="0.01" min="0" required>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" name="status" id="tierStatus" value="1" checked>
                        <label class="form-check-label" for="tierStatus">Active</label>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end gap-2 pt-3 pb-3 pe-3">
                    <button type="button" class="btn cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-solid px-4">Save Tier</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    const vehicleTypeZoneId = <?php echo e($vehicleTypeZone->id); ?>;
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    
    // Create default tiers
    $('#createDefaultTiers').on('click', function() {
        const $btn = $(this);
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Creating...');
        
        $.ajax({
            url: '<?php echo e(route("admin.tiered-pricing.create-default")); ?>',
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            data: { vehicle_type_zone_id: vehicleTypeZoneId },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                alert('Error creating default tiers');
            },
            complete: function() {
                $btn.prop('disabled', false).html('<i class="ri-magic-line"></i> Create Default UK Tiers');
            }
        });
    });
    
    // Edit tier
    $('.edit-tier').on('click', function() {
        const tier = $(this).data('tier');
        $('#tierId').val(tier.id);
        $('#minDistance').val(tier.min_distance);
        $('#maxDistance').val(tier.max_distance || '');
        $('#perDistanceCharge').val(tier.per_distance_charge);
        $('#tierStatus').prop('checked', tier.status);
        $('.modal-title').text('Edit Pricing Tier');
        $('#addTierModal').modal('show');
    });
    
    // Reset form when modal closes
    $('#addTierModal').on('hidden.bs.modal', function() {
        $('#tierForm')[0].reset();
        $('#tierId').val('');
        $('.modal-title').text('Add Pricing Tier');
    });
    
    // Submit form
    $('#tierForm').on('submit', function(e) {
        e.preventDefault();
        const tierId = $('#tierId').val();
        const url = tierId 
            ? '<?php echo e(url("admin/tiered-pricing")); ?>/' + tierId 
            : '<?php echo e(route("admin.tiered-pricing.store")); ?>';
        const method = tierId ? 'PUT' : 'POST';
        
        $.ajax({
            url: url,
            method: method,
            headers: { 'X-CSRF-TOKEN': csrfToken },
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON?.message || 'Error saving tier';
                alert(errors);
            }
        });
    });
    
    // Toggle status
    $('.toggle-status').on('click', function() {
        const tierId = $(this).data('id');
        $.ajax({
            url: '<?php echo e(url("admin/tiered-pricing")); ?>/' + tierId + '/toggle-status',
            method: 'PUT',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: function(response) {
                location.reload();
            }
        });
    });
    
    // Delete tier
    $('.delete-tier').on('click', function() {
        if (!confirm('Are you sure you want to delete this tier?')) return;
        const tierId = $(this).data('id');
        $.ajax({
            url: '<?php echo e(url("admin/tiered-pricing")); ?>/' + tierId,
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: function(response) {
                location.reload();
            }
        });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/taxido/Taxido_laravel/Modules/Taxido/resources/views/admin/tiered-pricing/index.blade.php ENDPATH**/ ?>