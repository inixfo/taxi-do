<li id="menu-item-<?php echo e($menu->id); ?>"
    class="menu-item menu-item-depth-<?php echo e($menu->depth); ?> menu-item-page menu-item-edit-inactive pending" style="display: list-item;">
    <dl class="menu-item-bar">
        <dt class="menu-item-handle">
            <span class="item-title">
                <span class="menu-item-title">
                    <span id="menutitletemp_<?php echo e($menu->id); ?>"><?php echo e(__($menu->label)); ?></span>
                    <span style="color: transparent;">|<?php echo e($menu->id); ?>|</span>
                </span>
                <span class="is-submenu" style="<?php if($menu->depth==0): ?>display: none;<?php endif; ?>">
                    <?php echo e(__('static.menus.sub_element')); ?>

                </span>
            </span>
            <span class="item-controls">
                <span class="item-type"><?php echo e(__('static.menus.link')); ?></span>
                <span class="item-order hide-if-js">
                    <a href="<?php echo e($currentUrl); ?>?action=move-up-menu-item&menu-item=<?php echo e($menu->id); ?>&_wpnonce=8b3eb7ac44"
                        class="item-move-up"><abbr title="Move Up">↑</abbr></a> | <a
                        href="<?php echo e($currentUrl); ?>?action=move-down-menu-item&menu-item=<?php echo e($menu->id); ?>&_wpnonce=8b3eb7ac44"
                        class="item-move-down"><abbr title="Move Down">↓</abbr></a>
                </span>
                <a class="item-edit" id="edit-<?php echo e($menu->id); ?>" href="<?php echo e($currentUrl); ?>?edit-menu-item=<?php echo e($menu->id); ?>#menu-item-settings-<?php echo e($menu->id); ?>"></a>
            </span>
        </dt>
    </dl>
    <div class="menu-item-settings" id="menu-item-settings-<?php echo e($menu->id); ?>">
        <input type="hidden" class="edit-menu-item-id" name="menuid_<?php echo e($menu->id); ?>" value="<?php echo e($menu->id); ?>" />
        <p class="description description-thin">
            <label for="edit-menu-item-title-<?php echo e($menu->id); ?>"> <?php echo e(__('static.menus.label')); ?>

                <br>
                <input type="text" id="idlabelmenu_<?php echo e($menu->id); ?>" class="widefat edit-menu-item-title"
                    name="idlabelmenu_<?php echo e($menu->id); ?>" value="<?php echo e(__($menu->label)); ?>">
            </label>
        </p>
        <p class="field-css-classes description description-thin">
            <label for="edit-menu-item-classes-<?php echo e($menu->id); ?>"><?php echo e(__('static.menus.class_css_(optional)')); ?>

                <br>
                <input type="text" id="clases_menu_<?php echo e($menu->id); ?>" class="widefat code edit-menu-item-classes"
                    name="clases_menu_<?php echo e($menu->id); ?>" value="<?php echo e($menu->class); ?>">
            </label>
        </p>
        <p class="field-css-icon mb-0 description description-thin">
            <label for="edit-menu-item-icon-<?php echo e($menu->id); ?>"><?php echo e(__('static.menus.remix_icon_class')); ?>

                <br>
                <input type="text" id="icon_menu_<?php echo e($menu->id); ?>" class="widefat code edit-menu-item-icon"
                    id="icon_menu_<?php echo e($menu->id); ?>" placeholder="dashboard-line" <?php if($menu->icon): ?> value="<?php echo e($menu->icon); ?>"
                <?php endif; ?>>
            </label>

            <span class="mt-1 d-inline-block"><?php echo e(__('static.menus.select_remix_icon_class')); ?><a class="mt-4 ms-2"
                    href="https://remixicon.com/" target="_blank"><?php echo e(__('static.menus.click_here')); ?></a></span>
        </p>

        <p class="field-css-route mt-0 description description-thin">
            <label for="edit-menu-item-route-<?php echo e($menu->id); ?>"> <?php echo e(__('static.menus.route')); ?>

                <br>
                <select id="route_menu_<?php echo e($menu->id); ?>" class="widefat code edit-menu-item-route form-select"
                    name="route_menu_[<?php echo e($menu->id); ?>]">
                    <option value=""><?php echo e(__('static.menus.select_route_url')); ?></option>
                    <?php $__currentLoopData = $adminRouteList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option <?php if($route==$menu->route): ?> selected <?php endif; ?> value="<?php echo e($route); ?>"><?php echo e($route); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </label>
        </p>
        <p class="field-move hide-if-no-js description description-wide">
            <label>
                <span><?php echo e(__('static.menus.move')); ?></span> <a href="<?php echo e($currentUrl); ?>" class="menus-move-up"
                    style="display: none;"><?php echo e(__('static.move_up')); ?></a> <a href="<?php echo e($currentUrl); ?>"
                    class="menus-move-down" title="Mover uno abajo"
                    style="display: inline;"><?php echo e(__('static.menus.move_down')); ?></a> <a href="<?php echo e($currentUrl); ?>"
                    class="menus-move-right" style="display: none;"></a> <a href="<?php echo e($currentUrl); ?>"
                    class="menus-move-top" style="display: none;"><?php echo e(__('static.menus.top')); ?></a>
            </label>
        </p>
        <div class="menu-item-actions description-wide submitbox">
            <a class="item-delete submitdelete deletion" id="delete-<?php echo e($menu->id); ?>"
                href="<?php echo e($currentUrl); ?>?action=delete-menu-item&menu-item=<?php echo e($menu->id); ?>&_wpnonce=2844002501"><?php echo e(__('static.menus.remove')); ?></a>
            <span class="meta-sep hide-if-no-js"> | </span>
            <a class="item-cancel submitcancel hide-if-no-js button-secondary" id="cancel-<?php echo e($menu->id); ?>"
                href="<?php echo e($currentUrl); ?>?edit-menu-item=<?php echo e($menu->id); ?>&cancel=1424297719#menu-item-settings-<?php echo e($menu->id); ?>"><?php echo e(__('static.menus.Cancel')); ?></a>
            <span class="meta-sep hide-if-no-js"> | </span>
        </div>
    </div>
    <ul class="menu-item-transport"></ul>
</li>
<?php /**PATH /var/www/taxido/Taxido_laravel/resources/views/admin/menu/items.blade.php ENDPATH**/ ?>