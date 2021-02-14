<?php ?>
<div id="ThreeDee_tabs-2">
    <form method="post" action="admin.php?page=ThreeDee#ThreeDee_tabs-0" enctype="multipart/form-data">
        <?php wp_nonce_field('ThreeDee-save-settings_'); ?>
        <input type="hidden" value="stl,obj,zip" name="file_extensions">
        <p><b><?php _e('Advanced Settings', 'ThreeDee'); ?></b></p>
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