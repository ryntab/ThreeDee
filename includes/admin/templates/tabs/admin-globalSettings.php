<?php ?>
<div id="ThreeDee_tabs-0">
    <form method="post" action="admin.php?page=ThreeDee#ThreeDee_tabs-0" enctype="multipart/form-data">
        <?php wp_nonce_field('ThreeDee-save-settings_'); ?>
        <input type="hidden" value="stl,obj,zip" name="file_extensions">
        <hr>
        <p><b><?php _e('Default Settings', 'ThreeDee'); ?></b></p>
        <table>
            <tr>
                <td><?php _e('Loading Image', 'ThreeDee'); ?></td>
                <td>
                    <img class="ThreeDee-preview" src="<?php echo esc_url($settings['ajax_loader']); ?>">
                    <input type="file" name="ThreeDee_settings[ajax_loader]" accept="image/*">
                </td>
            </tr>
            <tr>
                <td><?php _e('View3D Image', 'ThreeDee'); ?></td>
                <td>
                    <img class="ThreeDee-preview" src="<?php echo esc_url($settings['view3d_button_image']); ?>">
                    <input type="file" name="ThreeDee_settings[view3d_button_image]" accept="image/*">
                </td>
            </tr>
            <tr>
                <td><?php _e('Auto Rotation', 'ThreeDee'); ?></td>
                <td><input type="hidden" name="ThreeDee_settings[auto_rotation]" value="0"><input type="checkbox" name="ThreeDee_settings[auto_rotation]" <?php if ($settings['auto_rotation'] == 'on') echo 'checked'; ?>></td>
            </tr>
            <tr>
                <td><?php _e('Show Toobar', 'ThreeDee'); ?></td>
                <td><input type="hidden" name="ThreeDee_settings[show_controls]" value="0"><input type="checkbox" name="ThreeDee_settings[show_controls]" <?php if ($settings['show_controls'] == 'on') echo 'checked'; ?>>
                    <img class="ThreeDee-tooltip" data-title="<?php htmlentities(_e('Enables frontend tools: fullscreen, zoom, auto rotation, screenshot', 'ThreeDee')); ?>" src="<?php echo plugins_url('threedee/images/question.png'); ?>">
                </td>
            </tr>
            <tr>
                <td><?php _e('Enable Controls (Zoom/Pan)', 'ThreeDee'); ?></td>
                <td><input type="hidden" name="ThreeDee_settings[enable_controls]" value="0"><input type="checkbox" name="ThreeDee_settings[enable_controls]" <?php if ($settings['enable_controls'] == 'on') echo 'checked'; ?>>
                    <img class="ThreeDee-tooltip" data-title="<?php htmlentities(_e('Enables manual controls (zoom/pan) by mouse or swipe', 'ThreeDee')); ?>" src="<?php echo plugins_url('threedee/images/question.png'); ?>">
                </td>
            </tr>
            <tr>
                <td><?php _e('Show Fog', 'ThreeDee'); ?></td>
                <td><input type="hidden" name="ThreeDee_settings[show_fog]" value="0"><input type="checkbox" name="ThreeDee_settings[show_fog]" <?php if ($settings['show_fog'] == 'on') echo 'checked'; ?>></td>
            </tr>
            <tr>
                <td><?php _e('Show Shadows', 'ThreeDee'); ?></td>
                <td><input type="hidden" name="ThreeDee_settings[show_shadow]" value="0"><input type="checkbox" name="ThreeDee_settings[show_shadow]" <?php if ($settings['show_shadow'] == 'on') echo 'checked'; ?>></td>
            </tr>
            <tr>
                <td><?php _e('Show Ground', 'ThreeDee'); ?></td>
                <td><input type="hidden" name="ThreeDee_settings[show_ground]" value="0"><input type="checkbox" name="ThreeDee_settings[show_ground]" <?php if ($settings['show_ground'] == 'on') echo 'checked'; ?>></td>
            </tr>

            <tr>
                <td><?php _e('Ground Mirror', 'ThreeDee'); ?></td>
                <td><input type="hidden" name="ThreeDee_settings[ground_mirror]" value="0"><input type="checkbox" name="ThreeDee_settings[ground_mirror]" <?php if ($settings['ground_mirror'] == 'on') echo 'checked'; ?>></td>
            </tr>

            <tr>
                <td><?php _e('Show Grid', 'ThreeDee'); ?></td>
                <td><input type="hidden" name="ThreeDee_settings[show_grid]" value="0"><input type="checkbox" name="ThreeDee_settings[show_grid]" <?php if ($settings['show_grid'] == 'on') echo 'checked'; ?>></td>
            </tr>
        </table>
        <p class="submit">
            <input type="submit" class="btn btn-lg btn-primary" value="<?php _e('Save Changes', 'ThreeDee') ?>" />
        </p>
    </form>
</div>