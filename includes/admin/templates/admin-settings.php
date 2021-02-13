<?php


?>
<script language="javascript">
    jQuery(document).ready(function() {
        jQuery('.ThreeDee-tooltip').tooltipster({
            contentAsHTML: true,
            multiple: true
        });
    });
</script>
<div class="wrap">
    <h2><?php _e('ThreeDee Settings', 'ThreeDee'); ?></h2>
    <div id="ThreeDee_tabs">
        <ul>
            <li><a href="#ThreeDee_tabs-0"><?php _e('General Settings', 'pizzatime'); ?></a></li>
            <li><a href="#ThreeDee_tabs-1"><?php _e('Shortcode Builder', 'pizzatime'); ?></a></li>
        </ul>
        <div id="ThreeDee_tabs-0">
            <form method="post" action="admin.php?page=ThreeDee#ThreeDee_tabs-0" enctype="multipart/form-data">
                <?php wp_nonce_field('ThreeDee-save-settings_'); ?>
                <input type="hidden" value="stl,obj,zip" name="file_extensions">
                <hr>
                <p><b><?php _e('Default Settings', 'ThreeDee'); ?></b></p>
                <table>
                    <tr>
                        <td><?php _e('Object Dimensions', 'ThreeDee'); ?></td>
                        <td><input size="3" type="text" placeholder="<?php _e('Width', 'ThreeDee'); ?>" name="ThreeDee_settings[canvas_width]" value="<?php echo $settings['canvas_width']; ?>">px &times; <input size="3" type="text" placeholder="<?php _e('Height', 'ThreeDee'); ?>" name="ThreeDee_settings[canvas_height]" value="<?php echo $settings['canvas_height']; ?>">px</td>
                    </tr>
                    <tr>
                        <td><?php _e('Shading', 'ThreeDee'); ?></td>
                        <td>
                            <select name="ThreeDee_settings[shading]">
                                <option <?php if ($settings['shading'] == 'flat') echo 'selected'; ?> value="flat"><?php _e('Flat', 'ThreeDee'); ?></option>
                                <option <?php if ($settings['shading'] == 'smooth') echo 'selected'; ?> value="smooth"><?php _e('Smooth', 'ThreeDee'); ?></option>
                            </select>
                            <img class="ThreeDee-tooltip" data-title="<img src='<?php echo plugins_url('threedee/images/shading.jpg'); ?>'>" src="<?php echo plugins_url('threedee/images/question.png'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><?php _e('Model Color', 'ThreeDee'); ?></td>
                        <td><input type="text" class="ThreeDee-color-picker" name="ThreeDee_settings[model_default_color]" value="<?php echo $settings['model_default_color']; ?>"></td>
                    </tr>
                    <tr>
                        <td><?php _e('Background Color', 'ThreeDee'); ?></td>
                        <td><input type="text" class="ThreeDee-color-picker" name="ThreeDee_settings[background1]" value="<?php echo $settings['background1']; ?>"></td>
                    </tr>
                    <tr>
                        <td><?php _e('Fog Color', 'ThreeDee'); ?></td>
                        <td><input type="text" class="ThreeDee-color-picker" name="ThreeDee_settings[fog_color]" value="<?php echo $settings['fog_color']; ?>"></td>
                    </tr>
                    <tr>
                        <td><?php _e('Ground Color', 'ThreeDee'); ?></td>
                        <td><input type="text" class="ThreeDee-color-picker" name="ThreeDee_settings[ground_color]" value="<?php echo $settings['ground_color']; ?>"></td>
                    </tr>
                    <tr>
                        <td><?php _e('Grid Color', 'ThreeDee'); ?></td>
                        <td><input type="text" class="ThreeDee-color-picker" name="ThreeDee_settings[grid_color]" value="<?php echo $settings['grid_color']; ?>"></td>
                    </tr>
                    <tr>
                        <td><?php _e('Light Sources', 'ThreeDee'); ?></td>
                        <td>
                            <table>
                                <tr>
                                    <td><input type="hidden" name="ThreeDee_settings[show_light_source8]" value="0"><input class="form-check-input" type="checkbox" name="ThreeDee_settings[show_light_source8]" <?php if ($settings['show_light_source8'] == 'on') echo 'checked'; ?>></td>
                                    <td><input type="hidden" name="ThreeDee_settings[show_light_source1]" value="0"><input class="form-check-input" type="checkbox" name="ThreeDee_settings[show_light_source1]" <?php if ($settings['show_light_source1'] == 'on') echo 'checked'; ?>></td>
                                    <td><input type="hidden" name="ThreeDee_settings[show_light_source2]" value="0"><input class="form-check-input" type="checkbox" name="ThreeDee_settings[show_light_source2]" <?php if ($settings['show_light_source2'] == 'on') echo 'checked'; ?>></td>
                                </tr>
                                <tr>
                                    <td><input type="hidden" name="ThreeDee_settings[show_light_source7]" value="0"><input class="form-check-input" type="checkbox" name="ThreeDee_settings[show_light_source7]" <?php if ($settings['show_light_source7'] == 'on') echo 'checked'; ?>></td>
                                    <td><input type="hidden" name="ThreeDee_settings[show_light_source9]" value="0"><input class="form-check-input" type="checkbox" name="ThreeDee_settings[show_light_source9]" <?php if ($settings['show_light_source9'] == 'on') echo 'checked'; ?>></td>
                                    <td><input type="hidden" name="ThreeDee_settings[show_light_source3]" value="0"><input class="form-check-input" type="checkbox" name="ThreeDee_settings[show_light_source3]" <?php if ($settings['show_light_source3'] == 'on') echo 'checked'; ?>></td>
                                </tr>
                                <tr>
                                    <td><input type="hidden" name="ThreeDee_settings[show_light_source6]" value="0"><input class="form-check-input" type="checkbox" name="ThreeDee_settings[show_light_source6]" <?php if ($settings['show_light_source6'] == 'on') echo 'checked'; ?>></td>
                                    <td><input type="hidden" name="ThreeDee_settings[show_light_source5]" value="0"><input class="form-check-input" type="checkbox" name="ThreeDee_settings[show_light_source5]" <?php if ($settings['show_light_source5'] == 'on') echo 'checked'; ?>></td>
                                    <td><input type="hidden" name="ThreeDee_settings[show_light_source4]" value="0"><input class="form-check-input" type="checkbox" name="ThreeDee_settings[show_light_source4]" <?php if ($settings['show_light_source4'] == 'on') echo 'checked'; ?>></td>
                                </tr>

                            </table>

                        </td>
                    </tr>
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
                <hr>

                <p><b><?php _e('Other', 'ThreeDee'); ?></b></p>
                <table>

                    <tr>
                        <td><?php _e('Load Everywhere', 'ThreeDee'); ?></td>
                        <td>
                            <input type="hidden" name="ThreeDee_settings[load_everywhere]" value="0">
                            <input type="checkbox" name="ThreeDee_settings[load_everywhere]" <?php if ($settings['load_everywhere'] == 'on') echo 'checked'; ?>>
                            <img class="ThreeDee-tooltip" data-title="<?php htmlentities(_e('Enable if you need to load ThreeDee css and js files on all pages of the site.', 'ThreeDee')); ?>" src="<?php echo plugins_url('threedee/images/question.png'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><?php _e('File Chunk Size', 'ThreeDee'); ?></td>
                        <td><input type="text" size="1" name="ThreeDee_settings[file_chunk_size]" value="<?php echo $settings['file_chunk_size']; ?>">&nbsp;<?php _e('mb', 'ThreeDee'); ?>
                            <img class="ThreeDee-tooltip" data-title="<?php htmlentities(_e('Used for uploading WEBM and GIF files rendered by the plugin. Keep it under upload_max_filesize and post_max_size PHP directives.', 'ThreeDee')); ?>" src="<?php echo plugins_url('threedee/images/question.png'); ?>">
                        </td>

                    </tr>

                    <tr>
                        <td><?php _e('Skip animation on mobile devices', 'ThreeDee'); ?></td>
                        <td>
                            <input type="hidden" name="ThreeDee_settings[mobile_no_animation]" value="0">
                            <input type="checkbox" name="ThreeDee_settings[mobile_no_animation]" <?php if ($settings['mobile_no_animation'] == 'on') echo 'checked'; ?>>
                            <img class="ThreeDee-tooltip" data-title="<?php htmlentities(_e('Disable rotation on mobile devices for better performance.', 'ThreeDee')); ?>" src="<?php echo plugins_url('threedee/images/question.png'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><?php _e('Model compression', 'ThreeDee'); ?></td>
                        <td>
                            <input type="hidden" name="ThreeDee_settings[model_compression]" value="0">
                            <input type="checkbox" name="ThreeDee_settings[model_compression]" disabled>
                            <img class="ThreeDee-tooltip" data-title="<?php htmlentities(_e('Compress models (ZIP) for faster loading.', 'ThreeDee')); ?>" src="<?php echo plugins_url('threedee/images/question.png'); ?>">&nbsp;
                            <?php _e('Compress models larger than', 'ThreeDee'); ?><input type="text" size="2" name="ThreeDee_settings[model_compression_threshold]" disabled>&nbsp;<?php _e('mb', 'ThreeDee'); ?>
                            <?php
                            if (!class_exists('ZipArchive')) echo '<p><span style="color:red;">' . __('PHP zip extension is not enabled. Contact your hosting tech support to enable it.') . '</span></p>';
                            ?>
                            &nbsp;Unlock in <a href="http://ThreeDeeiewer.wp3dprinting.com/">PRO version</a><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td><?php _e('Use cross domain proxy', 'ThreeDee'); ?></td>
                        <td>
                            <input type="hidden" name="ThreeDee_settings[proxy]" value="0">
                            <input type="checkbox" name="ThreeDee_settings[proxy]" disabled>
                            <img class="ThreeDee-tooltip" data-title="<?php htmlentities(_e('Proxy makes possible loading models from 3rd party sites.', 'ThreeDee')); ?>" src="<?php echo plugins_url('threedee/images/question.png'); ?>">&nbsp;
                            <?php _e('Trusted domains', 'ThreeDee'); ?>:<input type="text" size="30" name="ThreeDee_settings[proxy_domains]" disabled>&nbsp;
                            <img class="ThreeDee-tooltip" data-title="<?php htmlentities(_e('Comma delimited list of domains you are loading models from. Please include both www and non-www domains, i.e.: example1.com, www.example1.com', 'ThreeDee')); ?>" src="<?php echo plugins_url('threedee/images/question.png'); ?>">&nbsp;
                            &nbsp;Unlock in <a href="http://ThreeDeeiewer.wp3dprinting.com/">PRO version</a><br><br>
                        </td>
                    </tr>




                </table>
                <p class="submit">
                    <input type="submit" class="btn btn-lg btn-primary" value="<?php _e('Save Changes', 'ThreeDee') ?>" />
                </p>
            </form>
        </div>
        <div id="ThreeDee_tabs-1">
            <?php
            include_once('ThreeDee-admin-shortcode-builder.php');
            ?>
        </div>
    </div><!-- ThreeDee_tabs -->
</div> <!-- wrap -->
<?php

?>