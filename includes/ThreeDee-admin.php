<?php

/**
 *
 *
 * @author Sergey Burkov, http://www.wp3dprinting.com
 * @copyright 2017
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

add_action('add_meta_boxes', 'ThreeDee_add_meta_boxes', 30);
function ThreeDee_add_meta_boxes()
{
	add_meta_box('ThreeDee-product-model', __('Product model', 'ThreeDee'), 'ThreeDee_meta_box_output', 'product', 'side', 'low');
}

function ThreeDee_meta_box_output()
{

	$settings = get_option('ThreeDee_settings');
	$upload_dir = wp_upload_dir();
	#print_r($upload_dir);
	//var_dump(ThreeDee_is_ThreeDee((int)$_GET['post'] ));
	$product_model = $display_mode = $display_mode_mobile = $product_color = $product_background1 = $product_default_color = $product_fog_color = $product_grid_color = $product_ground_color = $product_shininess = $product_transparency = $product_mtl = $product_attachment_id = $rotation_x = $rotation_y = $rotation_z = $product_image_png = $product_image_gif = $product_video_webm = $product_model_extracted_path = $product_show_grid = $product_show_fog = $product_show_ground = $product_ground_mirror = $product_show_shadow = $product_auto_rotation = $product_view3d_button = $upload_url = '';
	if (isset($_GET['post']) && ThreeDee_is_ThreeDee((int)$_GET['post'])) {
		$product_model = get_post_meta((int)$_GET['post'], '_product_model', true);

		$display_mode = get_post_meta((int)$_GET['post'], '_display_mode', true);
		$display_mode_mobile = get_post_meta((int)$_GET['post'], '_display_mode_mobile', true);
		$product_color = get_post_meta((int)$_GET['post'], '_product_color', true);
		if (!$product_color) $product_color = $settings['model_default_color'];
		$product_shininess = get_post_meta((int)$_GET['post'], '_product_shininess', true);
		$product_transparency = get_post_meta((int)$_GET['post'], '_product_transparency', true);
		$product_mtl = get_post_meta((int)$_GET['post'], '_product_mtl', true);
		$product_attachment_id = get_post_meta((int)$_GET['post'], '_product_attachment_id', true);
		$product_remember_camera_position = get_post_meta((int)$_GET['post'], '_product_remember_camera_position', true);
		$product_camera_position_x = get_post_meta((int)$_GET['post'], '_product_camera_position_x', true);
		$product_camera_position_y = get_post_meta((int)$_GET['post'], '_product_camera_position_y', true);
		$product_camera_position_z = get_post_meta((int)$_GET['post'], '_product_camera_position_z', true);
		$product_camera_lookat_x = get_post_meta((int)$_GET['post'], '_product_camera_lookat_x', true);
		$product_camera_lookat_y = get_post_meta((int)$_GET['post'], '_product_camera_lookat_y', true);
		$product_camera_lookat_z = get_post_meta((int)$_GET['post'], '_product_camera_lookat_z', true);
		$product_controls_target_x = get_post_meta((int)$_GET['post'], '_product_controls_target_x', true);
		$product_controls_target_y = get_post_meta((int)$_GET['post'], '_product_controls_target_y', true);
		$product_controls_target_z = get_post_meta((int)$_GET['post'], '_product_controls_target_z', true);
		$product_offset_z = get_post_meta((int)$_GET['post'], '_product_offset_z', true);
		$product_model_extracted_path = get_post_meta((int)$_GET['post'], '_product_model_extracted_path', true);
		#var_dump($product_offset_z);


		#		$product_show_fog = get_post_meta( (int)$_GET['post'], '_product_show_fog', true );
		$product_show_grid = get_post_meta((int)$_GET['post'], '_product_show_grid', true);
		$product_show_ground = get_post_meta((int)$_GET['post'], '_product_show_ground', true);
		$product_show_shadow = get_post_meta((int)$_GET['post'], '_product_show_shadow', true);
		$product_background1 = get_post_meta((int)$_GET['post'], '_product_background1', true);
		$product_ground_mirror = get_post_meta((int)$_GET['post'], '_product_ground_mirror', true);
		$product_fog_color = get_post_meta((int)$_GET['post'], '_product_fog_color', true);
		$product_grid_color = get_post_meta((int)$_GET['post'], '_product_grid_color', true);
		$product_ground_color = get_post_meta((int)$_GET['post'], '_product_ground_color', true);
		$product_auto_rotation = get_post_meta((int)$_GET['post'], '_product_auto_rotation', true);
		$product_view3d_button = get_post_meta((int)$_GET['post'], '_product_view3d_button', true);

		#		if (!$product_show_fog) $product_show_fog = $settings['show_fog'];
		//$product_default_color = $settings['model_default_color'];

		if (!$product_show_grid) $product_show_grid = $settings['show_grid'];
		if (!$product_show_ground) $product_show_ground = $settings['show_ground'];
		if (!$product_show_shadow) $product_show_shadow = $settings['show_shadow'];
		if (!$product_background1) $product_background1 = $settings['background1'];
		if (!$product_fog_color) $product_fog_color = $settings['fog_color'];
		if (!$product_grid_color) $product_grid_color = $settings['grid_color'];
		if (!$product_ground_color) $product_ground_color = $settings['ground_color'];
		if (!$product_ground_mirror) $product_ground_mirror = $settings['ground_mirror'];
		if (!$product_auto_rotation) $product_auto_rotation = $settings['auto_rotation'];

		$product_show_light_source1 = get_post_meta((int)$_GET['post'], '_product_show_light_source1', true);
		$product_show_light_source2 = get_post_meta((int)$_GET['post'], '_product_show_light_source2', true);
		$product_show_light_source3 = get_post_meta((int)$_GET['post'], '_product_show_light_source3', true);
		$product_show_light_source4 = get_post_meta((int)$_GET['post'], '_product_show_light_source4', true);
		$product_show_light_source5 = get_post_meta((int)$_GET['post'], '_product_show_light_source5', true);
		$product_show_light_source6 = get_post_meta((int)$_GET['post'], '_product_show_light_source6', true);
		$product_show_light_source7 = get_post_meta((int)$_GET['post'], '_product_show_light_source7', true);
		$product_show_light_source8 = get_post_meta((int)$_GET['post'], '_product_show_light_source8', true);
		$product_show_light_source9 = get_post_meta((int)$_GET['post'], '_product_show_light_source9', true);


		if (!$product_show_light_source1) $product_show_light_source1 = $settings['show_light_source1'];
		if (!$product_show_light_source2) $product_show_light_source2 = $settings['show_light_source2'];
		if (!$product_show_light_source3) $product_show_light_source3 = $settings['show_light_source3'];
		if (!$product_show_light_source4) $product_show_light_source4 = $settings['show_light_source4'];
		if (!$product_show_light_source5) $product_show_light_source5 = $settings['show_light_source5'];
		if (!$product_show_light_source6) $product_show_light_source6 = $settings['show_light_source6'];
		if (!$product_show_light_source7) $product_show_light_source7 = $settings['show_light_source7'];
		if (!$product_show_light_source8) $product_show_light_source8 = $settings['show_light_source8'];
		if (!$product_show_light_source9) $product_show_light_source9 = $settings['show_light_source9'];

		$rotation_x = (int)get_post_meta((int)$_GET['post'], '_rotation_x', true);
		$rotation_y = (int)get_post_meta((int)$_GET['post'], '_rotation_y', true);
		$rotation_z = (int)get_post_meta((int)$_GET['post'], '_rotation_z', true);

		$product_image_png = $upload_dir['baseurl'] . '/ThreeDee/' . get_post_meta(get_the_ID(), '_product_image_png', true);
		$product_image_gif = $upload_dir['baseurl'] . '/ThreeDee/' . get_post_meta(get_the_ID(), '_product_image_gif', true);
		$product_video_webm = $upload_dir['baseurl'] . '/ThreeDee/' . get_post_meta(get_the_ID(), '_product_video_webm', true);
		$upload_url = dirname($product_model) . '/';
	}
	#echo dirname($product_model);
	#print_r(get_post_meta( (int)$_GET['post']));
	//var_dump($product_color);

?>
	<div>

		<input type="hidden" id="product_model" name="product_model" value="<?php echo esc_attr($product_model); ?>" />
		<input type="hidden" id="product_attachment_id" name="product_attachment_id" value="<?php echo esc_attr($product_attachment_id); ?>" />
		<input type="hidden" id="product_image_png" name="product_image_png" value="<?php echo esc_attr($product_image_png); ?>" />
		<input type="hidden" id="product_image_gif" name="product_image_gif" value="<?php echo esc_attr($product_image_gif); ?>" />
		<input type="hidden" id="product_video_webm" name="product_video_webm" value="<?php echo esc_attr($product_video_webm); ?>" />
		<input type="hidden" id="product_model_extracted_path" name="product_model_extracted_path" value="<?php echo esc_attr($product_model_extracted_path); ?>" />

		<!--		<input type="hidden" id="product_show_fog" name="product_show_fog" value="<?php echo esc_attr($product_show_fog); ?>" />-->
		<input type="hidden" id="product_show_grid" name="product_show_grid" value="<?php echo esc_attr($product_show_grid); ?>" />
		<input type="hidden" id="product_show_ground" name="product_show_ground" value="<?php echo esc_attr($product_show_ground); ?>" />
		<input type="hidden" id="product_show_shadow" name="product_show_shadow" value="<?php echo esc_attr($product_show_shadow); ?>" />
		<input type="hidden" id="product_background1" name="product_background1" value="<?php echo esc_attr($product_background1); ?>" />
		<!--		<input type="hidden" id="product_default_color" name="product_default_color" value="<?php echo esc_attr($product_default_color); ?>" />-->
		<!--
		<input type="hidden" name="product_color" id="ThreeDee_model_color" value="<?php echo esc_attr($product_color); ?>">
-->
		<input type="hidden" id="product_ground_mirror" name="product_ground_mirror" value="<?php echo esc_attr($product_ground_mirror); ?>" />
		<input type="hidden" id="product_fog_color" name="product_fog_color" value="<?php echo esc_attr($product_fog_color); ?>" />
		<input type="hidden" id="product_grid_color" name="product_grid_color" value="<?php echo esc_attr($product_grid_color); ?>" />
		<input type="hidden" id="product_ground_color" name="product_ground_color" value="<?php echo esc_attr($product_ground_color); ?>" />
		<input type="hidden" id="product_auto_rotation" name="product_auto_rotation" value="<?php echo esc_attr($product_auto_rotation); ?>" />
		<input type="hidden" id="product_view3d_button" name="product_view3d_button" value="<?php echo esc_attr($product_view3d_button); ?>" />



		<?php
		if (($product_model != '' || $product_image_png != '' || $product_image_gif != '' || $product_video_webm != '')) {
		?>
			<div id="ThreeDee_dialog" style="display:none;">
				<div id="threedee" style="<?php if ($product_model == '') echo 'display:none;'; ?>">
					<canvas id="ThreeDee-cv" width="<?php echo esc_attr($settings['canvas_width']); ?>" height="<?php echo esc_attr($settings['canvas_height']); ?>" style="border: 1px solid;max-width:90%;min-width:640px;min-height:480px;"></canvas>
				</div>
				<p style="display:none;" id="ThreeDee-convert1" class="ThreeDee-status2">&#9888; <?php _e('For best performance <a href="https://modelconverter.com/convert.html">convert</a> the model to GLB format.', 'ThreeDee'); ?></p>
				<p style="display:none;" id="ThreeDee-convert2" class="ThreeDee-status2">&#9888; <?php _e('For best performance <a href="https://myminifactory.github.io/stl2gltf/">convert</a> the model to GLB format.', 'ThreeDee'); ?></p>

				<div class="ThreeDee-info">
					<table width="100%">
						<tr>
							<td width="30%">
								<p class="ThreeDee-info" id="ThreeDee-file-stats">
									<?php _e('File Size', 'ThreeDee'); ?>&nbsp;<span id="ThreeDee-file-stats-size">0</span>&nbsp;<?php _e('mb', 'ThreeDee'); ?>&nbsp;
									<?php _e('Polygon Count', 'ThreeDee'); ?>&nbsp;<span id="ThreeDee-file-stats-polygons">0</span>
								</p>
							</td>
							<td width="50%">
								<p>
									<input id="ThreeDee-remember-camera-position" type="checkbox" <?php if ($product_remember_camera_position == '1') echo 'checked'; ?> value="1">
									<label for="ThreeDee-remember-camera-position">
										<?php _e('Remember camera position', 'ThreeDee'); ?>
									</label>
								</p>
							</td>
						</tr>
					</table>
				</div>

				<p class="ThreeDee-info ThreeDee-panel-right">
				<pre id="ThreeDee-console"></pre>
				</p>

				<div class="ThreeDee-info" id="canvas-stats">

				</div>
				<div class="ThreeDee-info">
					<table width="100%">
						<tr>
							<td>
								<button onclick="alert('Unlock in PRO version')" type="button"><?php _e('Repair', 'ThreeDee'); ?></button>&nbsp;
								<button onclick="alert('Unlock in PRO version')" type="button"><?php _e('Reduce', 'ThreeDee'); ?></button>
								&nbsp;
								<button onclick="ThreeDeeFitCameraToObject(ThreeDee.camera, ThreeDee.object, 1.2, ThreeDee.controls);" type="button"><?php _e('Fit camera'); ?></button>
							</td>
							<td>
								<span class="ThreeDee-x-axis"><?php _e('X', 'ThreeDee'); ?>:</span>
								<input type="number" autocomplete="off" class="ThreeDee-dim-input" min="-360" max="360" step="Any" value="<?php echo $rotation_x; ?>" id="rotation_x"> <span class="ThreeDee-separator">&deg; </span>
								<span class="ThreeDee-y-axis"><?php _e('Y', 'ThreeDee'); ?>:</span>
								<input type="number" autocomplete="off" class="ThreeDee-dim-input" min="-360" max="360" step="Any" value="<?php echo $rotation_y; ?>" id="rotation_y"> <span class="ThreeDee-separator">&deg; </span>
								<span class="ThreeDee-z-axis"><?php _e('Z', 'ThreeDee'); ?>:</span>
								<input type="number" autocomplete="off" class="ThreeDee-dim-input" min="-360" max="360" step="Any" value="<?php echo $rotation_z; ?>" id="rotation_z"> <span class="ThreeDee-separator">&deg; </span>
								<span class="ThreeDee-z-offset"><?php _e('Z Offset', 'ThreeDee'); ?>:</span>
								<input type="number" autocomplete="off" step="Any" value="" id="z_offset">
							</td>

						</tr>
					</table>
				</div>
				<p class="hide-if-no-js" id="ThreeDee-canvas-instructions" style="<?php if ($display_mode == '3d_model') echo 'display:none;' ?>">
					<?php _e('Adjust angle with the left mouse button. Zoom with the scroll button. Adjust camera position with the right mouse button.', 'ThreeDee'); ?>
				</p>

				<p class="hide-if-no-js" id="ThreeDee-rotation-controls">

				</p>
				<table>
					<tr>
						<td><?php _e('Color'); ?>:</td>
						<td><input type="text" class="ThreeDee-color-picker" onchange="ThreeDeeChangeModelColor(this.value);" value="<?php echo $product_color; ?>" /></td>
						<td><?php _e('Background Color'); ?>:</td>
						<td><input type="text" id="ThreeDee-background-color" class="ThreeDee-color-picker ThreeDee-background" onchange="ThreeDeeChangeBackgroundColor(this.value);" value="<?php echo $product_background1; ?>"></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><?php _e('Shininess', 'ThreeDee'); ?>:</td>
						<td>
							<select onchange="ThreeDeeSetCurrentShininess(this.value);">
								<option <?php if ($product_shininess == 'plastic') echo "selected"; ?> value="plastic"><?php _e('Plastic', 'ThreeDee'); ?></option>
								<option <?php if ($product_shininess == 'wood') echo "selected"; ?> value="wood"><?php _e('Wood', 'ThreeDee'); ?></option>
								<option <?php if ($product_shininess == 'metal') echo "selected"; ?> value="metal"><?php _e('Metal', 'ThreeDee'); ?></option>
							</select>
						</td>
						<td><?php _e('Grid Color', 'ThreeDee'); ?>:</td>
						<td><input type="text" id="ThreeDee-grid-color" class="ThreeDee-color-picker ThreeDee-grid" onchange="ThreeDeeChangeGridColor(this.value);" value="<?php echo $product_grid_color; ?>"></td>
						<td><?php _e('Show Grid', 'ThreeDee'); ?></td>
						<td><input type="checkbox" id="ThreeDee-show-grid" onclick="ThreeDeeToggleGrid();" <?php if ($product_show_grid == 'on') echo 'checked'; ?>></td>
						<!--			<td><?php _e('Fog Color', 'ThreeDee'); ?>:</td>
			<td><input type="text" id="ThreeDee-fog-color" class="ThreeDee-color-picker ThreeDee-fog" onchange="ThreeDeeChangeFogColor(this.value);" value="<?php echo $product_fog_color; ?>"></td>
			<td><?php _e('Show Fog', 'ThreeDee'); ?></td>
			<td><input type="checkbox" id="ThreeDee-show-fog" onclick="ThreeDeeToggleFog();" <?php if ($product_show_fog == 'on') echo 'checked'; ?>></td>
-->

					</tr>
					<tr>
						<td><?php _e('Transparency', 'ThreeDee'); ?>:</td>
						<td>
							<select onchange="ThreeDeeSetCurrentTransparency(this.value);">
								<option <?php if ($product_transparency == 'opaque') echo "selected"; ?> value="opaque"><?php _e('Opaque', 'ThreeDee'); ?></option>
								<option <?php if ($product_transparency == 'resin') echo "selected"; ?> value="resin"><?php _e('Resin', 'ThreeDee'); ?></option>
								<option <?php if ($product_transparency == 'glass') echo "selected"; ?> value="glass"><?php _e('Glass', 'ThreeDee'); ?></option>
							</select>
						</td>
						<td><?php _e('Ground Color', 'ThreeDee'); ?>:</td>
						<td><input type="text" id="ThreeDee-ground-color" class="ThreeDee-color-picker ThreeDee-ground" onchange="ThreeDeeChangeGroundColor(this.value);" value="<?php echo $product_ground_color; ?>"></td>
						<td><?php _e('Show Ground', 'ThreeDee'); ?></td>
						<td><input type="checkbox" id="ThreeDee-show-ground" onclick="ThreeDeeToggleGround();" <?php if ($product_show_ground == 'on') echo 'checked'; ?>></td>




					</tr>
					<tr>
						<td>
							<?php _e('Display mode', 'ThreeDee'); ?>:
						</td>
						<td>
							<select onchange="ThreeDeeChangeDisplayMode(this.value, false)">
								<option <?php if ($display_mode == '3d_model') echo "selected"; ?> value="3d_model"><?php _e('3D model', 'ThreeDee'); ?></option>
								<option disabled <?php if ($display_mode == 'png_image') echo "selected"; ?> value="png_image"><?php _e('PNG image', 'ThreeDee'); ?></option>
								<option disabled <?php if ($display_mode == 'gif_image') echo "selected"; ?> value="gif_image"><?php _e('GIF image', 'ThreeDee'); ?></option>
								<option disabled <?php if ($display_mode == 'webm_video') echo "selected"; ?> value="webm_video"><?php _e('WEBM video', 'ThreeDee'); ?></option>
							</select>
							<br>Unlock in <a href="http://ThreeDeeiewer.wp3dprinting.com/">PRO version</a><br><br>
						</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>


					</tr>
					<tr>
						<td>
							<?php _e('Mobile display mode', 'ThreeDee'); ?>:
						</td>
						<td>
							<select onchange="ThreeDeeChangeDisplayMode(this.value, true)">
								<option <?php if ($display_mode_mobile == '3d_model') echo "selected"; ?> value="3d_model"><?php _e('3D model', 'ThreeDee'); ?></option>
								<option disabled <?php if ($display_mode_mobile == 'png_image') echo "selected"; ?> value="png_image"><?php _e('PNG image', 'ThreeDee'); ?></option>
								<option disabled <?php if ($display_mode_mobile == 'gif_image') echo "selected"; ?> value="gif_image"><?php _e('GIF image', 'ThreeDee'); ?></option>
								<option disabled <?php if ($display_mode_mobile == 'webm_video') echo "selected"; ?> value="webm_video"><?php _e('WEBM video', 'ThreeDee'); ?></option>
							</select>
							<br>Unlock in <a href="http://ThreeDeeiewer.wp3dprinting.com/">PRO version</a><br><br>
						</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>


					</tr>
					<tr>
						<td><?php _e('Light Sources', 'ThreeDee'); ?>:</td>
						<td>
							<table>
								<tr>
									<td><input onclick="ThreeDeeToggleLightSource(8);" type="checkbox" id="ThreeDee-show-light-source8" <?php if ($product_show_light_source8 == 'on') echo 'checked'; ?>></td>
									<td><input onclick="ThreeDeeToggleLightSource(1);" type="checkbox" id="ThreeDee-show-light-source1" <?php if ($product_show_light_source1 == 'on') echo 'checked'; ?>></td>
									<td><input onclick="ThreeDeeToggleLightSource(2);" type="checkbox" id="ThreeDee-show-light-source2" <?php if ($product_show_light_source2 == 'on') echo 'checked'; ?>></td>
								</tr>
								<tr>
									<td><input onclick="ThreeDeeToggleLightSource(7);" type="checkbox" id="ThreeDee-show-light-source7" <?php if ($product_show_light_source7 == 'on') echo 'checked'; ?>></td>
									<td><input onclick="ThreeDeeToggleLightSource(9);" type="checkbox" id="ThreeDee-show-light-source9" <?php if ($product_show_light_source9 == 'on') echo 'checked'; ?>></td>
									<td><input onclick="ThreeDeeToggleLightSource(3);" type="checkbox" id="ThreeDee-show-light-source3" <?php if ($product_show_light_source3 == 'on') echo 'checked'; ?>></td>
								</tr>
								<tr>
									<td><input onclick="ThreeDeeToggleLightSource(6);" type="checkbox" id="ThreeDee-show-light-source6" <?php if ($product_show_light_source6 == 'on') echo 'checked'; ?>></td>
									<td><input onclick="ThreeDeeToggleLightSource(5);" type="checkbox" id="ThreeDee-show-light-source5" <?php if ($product_show_light_source5 == 'on') echo 'checked'; ?>></td>
									<td><input onclick="ThreeDeeToggleLightSource(4);" type="checkbox" id="ThreeDee-show-light-source4" <?php if ($product_show_light_source4 == 'on') echo 'checked'; ?>></td>
								</tr>
							</table>

						</td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><?php _e('Show Shadow', 'ThreeDee'); ?>:</td>
						<td><input onclick="ThreeDeeToggleShadow();" type="checkbox" id="ThreeDee-show-shadow" <?php if ($product_show_shadow == 'on') echo 'checked'; ?>></td>
					</tr>
					<tr>
						<td><?php _e('Show Mirror', 'ThreeDee'); ?>:</td>
						<td><input onclick="ThreeDeeToggleMirror();" type="checkbox" id="ThreeDee-show-mirror" <?php if ($product_ground_mirror == 'on') echo 'checked'; ?>></td>
					</tr>
					<tr>
						<td><?php _e('Auto Rotation', 'ThreeDee'); ?>:</td>
						<td><input onclick="ThreeDeeToggleRotation(this.checked);" type="checkbox" id="ThreeDee-auto-rotation" <?php if ($product_auto_rotation == 'on') echo 'checked'; ?>></td>
					</tr>
					<tr>
						<td><?php _e('Show View 3D Button', 'ThreeDee'); ?>:</td>
						<td><input type="checkbox" id="ThreeDee-view3d-button" <?php if ($product_view3d_button == 'on') echo 'checked'; ?>></td>
					</tr>


				</table>


			</div>

			<input type="hidden" id="ThreeDee_model_url" value="<?php echo esc_attr($product_model); ?>">
			<input type="hidden" id="ThreeDee_model_mtl" value="<?php echo esc_attr(basename($product_mtl)); ?>">
			<input type="hidden" id="ThreeDee_upload_url" value="<?php echo esc_attr($upload_url); ?>" />
			<input type="hidden" name="product_color" id="ThreeDee_model_color" value="<?php echo esc_attr($product_color); ?>">
			<input type="hidden" name="product_shininess" id="ThreeDee_model_shininess" value="<?php echo esc_attr($product_shininess); ?>">
			<input type="hidden" name="product_transparency" id="ThreeDee_model_transparency" value="<?php echo esc_attr($product_transparency); ?>">
			<input type="hidden" name="rotation_x" id="ThreeDee_rotation_x" value="<?php echo esc_attr($rotation_x); ?>">
			<input type="hidden" name="rotation_y" id="ThreeDee_rotation_y" value="<?php echo esc_attr($rotation_y); ?>">
			<input type="hidden" name="rotation_z" id="ThreeDee_rotation_z" value="<?php echo esc_attr($rotation_z); ?>">
			<input type="hidden" name="display_mode" id="ThreeDee_display_mode" value="<?php echo esc_attr($display_mode); ?>">
			<input type="hidden" name="display_mode_mobile" id="ThreeDee_display_mode_mobile" value="<?php echo esc_attr($display_mode_mobile); ?>">
			<input type="hidden" name="use_png_as_thumnbail" id="ThreeDee_use_png_as_thumnbail" value="">
			<input type="hidden" name="product_remember_camera_position" value="<?php echo esc_attr($product_remember_camera_position); ?>" />
			<input type="hidden" name="product_camera_position_x" id="product_camera_position_x" value="<?php echo esc_attr($product_camera_position_x); ?>" />
			<input type="hidden" name="product_camera_position_y" id="product_camera_position_y" value="<?php echo esc_attr($product_camera_position_y); ?>" />
			<input type="hidden" name="product_camera_position_z" id="product_camera_position_z" value="<?php echo esc_attr($product_camera_position_z); ?>" />
			<input type="hidden" name="product_camera_lookat_x" id="product_camera_lookat_x" value="<?php echo esc_attr($product_camera_lookat_x); ?>" />
			<input type="hidden" name="product_camera_lookat_y" id="product_camera_lookat_y" value="<?php echo esc_attr($product_camera_lookat_y); ?>" />
			<input type="hidden" name="product_camera_lookat_z" id="product_camera_lookat_z" value="<?php echo esc_attr($product_camera_lookat_z); ?>" />
			<input type="hidden" name="product_controls_target_x" id="product_controls_target_x" value="<?php echo esc_attr($product_controls_target_x); ?>" />
			<input type="hidden" name="product_controls_target_y" id="product_controls_target_y" value="<?php echo esc_attr($product_controls_target_y); ?>" />
			<input type="hidden" name="product_controls_target_z" id="product_controls_target_z" value="<?php echo esc_attr($product_controls_target_z); ?>" />
			<input type="hidden" name="product_offset_z" id="product_offset_z" value="<?php echo esc_attr($product_offset_z); ?>" />
			<input type="hidden" name="product_show_light_source1" value="<?php echo esc_attr($product_show_light_source1); ?>" />
			<input type="hidden" name="product_show_light_source2" value="<?php echo esc_attr($product_show_light_source2); ?>" />
			<input type="hidden" name="product_show_light_source3" value="<?php echo esc_attr($product_show_light_source3); ?>" />
			<input type="hidden" name="product_show_light_source4" value="<?php echo esc_attr($product_show_light_source4); ?>" />
			<input type="hidden" name="product_show_light_source5" value="<?php echo esc_attr($product_show_light_source5); ?>" />
			<input type="hidden" name="product_show_light_source6" value="<?php echo esc_attr($product_show_light_source6); ?>" />
			<input type="hidden" name="product_show_light_source7" value="<?php echo esc_attr($product_show_light_source7); ?>" />
			<input type="hidden" name="product_show_light_source8" value="<?php echo esc_attr($product_show_light_source8); ?>" />
			<input type="hidden" name="product_show_light_source9" value="<?php echo esc_attr($product_show_light_source9); ?>" />

			<!--		<input type="hidden" name="product_show_fog" value="<?php echo esc_attr($product_show_fog); ?>" />-->
			<input type="hidden" name="product_show_grid" value="<?php echo esc_attr($product_show_grid); ?>" />
			<input type="hidden" name="product_show_ground" value="<?php echo esc_attr($product_show_ground); ?>" />
			<input type="hidden" name="product_show_shadow" value="<?php echo esc_attr($product_show_shadow); ?>" />
			<input type="hidden" name="product_background1" value="<?php echo esc_attr($product_background1); ?>" />
			<input type="hidden" name="product_show_mirror" value="<?php echo esc_attr($product_ground_mirror); ?>" />
			<input type="hidden" name="product_fog_color" value="<?php echo esc_attr($product_fog_color); ?>" />
			<input type="hidden" name="product_grid_color" value="<?php echo esc_attr($product_grid_color); ?>" />
			<input type="hidden" name="product_ground_color" value="<?php echo esc_attr($product_ground_color); ?>" />
			<input type="hidden" name="product_auto_rotation" value="<?php echo esc_attr($product_auto_rotation); ?>" />
			<input type="hidden" name="product_view3d_button" value="<?php echo esc_attr($product_view3d_button); ?>" />






			<input type="hidden" id="ThreeDee_canvas_width" value="<?php echo esc_attr($settings['canvas_width']); ?>">
			<input type="hidden" id="ThreeDee_canvas_height" value="<?php echo esc_attr($settings['canvas_height']); ?>">
			<input type="hidden" id="ThreeDee_model_image_url" value="">

			<input type="hidden" name="product_image_data" id="product_image_data" value="">
			<input type="hidden" name="product_gif_data" id="product_gif_data" value="">
			<input type="hidden" name="product_webm_data" id="product_webm_data" value="">

			<p class="hide-if-no-js">
				<button onclick="ThreeDeePreview()" type="button"><?php _e('Edit/Preview', 'ThreeDee'); ?></button>
			</p>
			<p class="hide-if-no-js">
			<div id="product_model_name" style="<?php if ($product_model == '') echo 'display:none;'; ?>">
				<?php
				echo '<a href="' . $product_model . '">' . basename($product_model) . '</a>&nbsp;';
				echo '<a title="' . __('Remove', 'ThreeDee') . '" href="javascript:ThreeDee_remove_model();">&#10006;</a>';

				?>
			</div>


			</p>
		<?php
		}
		?>
		<p class="hide-if-no-js">

			<br>


		</p>

		<p id="ThreeDee_save_block" class="hide-if-no-js" style="display:none;">
			<span style="color:green;"><?php _e('Uploaded! You can now save the product.', 'ThreeDee'); ?></span>
		</p>



		<p class="hide-if-no-js">
			<a title="<?php _e('Set model', 'ThreeDee'); ?>" href="javascript:;" id="set-model"><?php _e('Set model', 'ThreeDee'); ?></a>
		</p>
	</div>
<?php
}
?>