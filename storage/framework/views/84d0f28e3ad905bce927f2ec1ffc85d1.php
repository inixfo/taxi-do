<li class="control-section accordion-section  open add-page" id="add-page">
    <h3 class="accordion-section-title hndle" tabindex="0"> <?php echo e(__('static.menus.custom_link')); ?><span
            class="screen-reader-text"><?php echo e(__('static.menus.press_return_expand')); ?></span></h3>
    <div class="accordion-section-content ">
        <div class="inside">
            <div class="customlinkdiv" id="customlinkdiv">
                <p id="menu-item-route-wrap">
                    <label class="howto" for="custom-menu-item-route">
                        <span><?php echo e(__('static.menus.route')); ?></span>&nbsp;&nbsp;&nbsp;
                        <input id="custom-menu-item-route" name="route" type="text" class="menu-item-textbox "
                            placeholder="<?php echo e(__('static.menus.route')); ?>" />
                    </label>
                </p>
                <p id="menu-item-name-wrap">
                    <label class="howto" for="custom-menu-item-name"> <span><?php echo e(__('static.menus.label')); ?></span>&nbsp;
                        <input id="custom-menu-item-name" name="label" type="text"
                            class="regular-text menu-item-textbox input-with-default-title"
                            placeholder="<?php echo e(__('static.menus.label')); ?>" />
                    </label>
                </p>
                <?php if(!empty($roles)): ?>
                    <p id="menu-item-role_id-wrap">
                        <label class="howto" for="custom-menu-item-role">
                            <span><?php echo e(__('static.menus.role')); ?></span>&nbsp;
                            <select id="custom-menu-item-role" name="role">
                                <option value="0"><?php echo e(__('static.menus.select_role')); ?></option>
                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($role->$role_pk); ?>"><?php echo e(ucfirst($role->$role_title_field)); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>
                    </p>
                <?php endif; ?>
                <p class="button-controls">
                    <a href="javascript:void(0)" onclick="addCustomMenu()"
                        class="button-secondary submit-add-to-menu right">
                        <?php echo e(__('static.menus.add_menu_item')); ?>

                    </a>
                    <span class="spinner" id="spincustomu"></span>
                </p>
            </div>
        </div>
    </div>
</li>
<?php /**PATH /var/www/taxido/Taxido_laravel/resources/views/admin/menu/widget.blade.php ENDPATH**/ ?>