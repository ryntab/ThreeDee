<?php
/**
 *
 *
 * @author Sergey Burkov, http://www.wp3dprinting.com
 * @copyright 2017
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ($settings['load_everywhere']!='on') {
?>
	<p style="color:red;"><?php _e('Please enable Load Everywhere option in General Settings!');?></p>
<?php
}
?>
<?php
if (isset($_GET['set_model']) && $_GET['set_model']=='1') {
?>
<script language="javascript">
jQuery(document).ready( function(){
	renderMediaUploader();
})

</script>
<?php
}
?>
	<input type="hidden" id="ThreeDee_reload_url" value="<?php echo admin_url( 'admin.php?page=ThreeDee&set_model=1#ThreeDee_tabs-1' ); ?>" />
	<input type="hidden" id="product_model" name="product_model" value="" />
	<input type="hidden" id="product_attachment_id" name="product_attachment_id" value="" />
	<input type="hidden" id="product_image_png" name="product_image_png" value="" />
	<input type="hidden" id="product_image_gif" name="product_image_gif" value="" />
	<input type="hidden" id="product_video_webm" name="product_video_webm" value="" />
	<input type="hidden" id="product_model_extracted_path" name="product_model_extracted_path" value="" />
	<input type="hidden" id="product_show_grid" name="product_show_grid" value="" />
	<input type="hidden" id="product_show_ground" name="product_show_ground" value="" />
	<input type="hidden" id="product_show_shadow" name="product_show_shadow" value="" />
	<input type="hidden" id="product_background1" name="product_background1" value="" />
	<input type="hidden" id="product_ground_mirror" name="product_ground_mirror" value="" />
	<input type="hidden" id="product_fog_color" name="product_fog_color" value="" />
	<input type="hidden" id="product_grid_color" name="product_grid_color" value="" />
	<input type="hidden" id="product_ground_color" name="product_ground_color" value="" />
	<input type="hidden" id="product_auto_rotation" name="product_auto_rotation" value="" />
	<input type="hidden" id="product_model" name="product_model" value="" />
	<input type="hidden" id="product_attachment_id" name="product_attachment_id" value="" />

	<input type="hidden" id="ThreeDee_canvas_width" value="<?php echo esc_attr($settings['canvas_width']);?>">
	<input type="hidden" id="ThreeDee_canvas_height" value="<?php echo esc_attr($settings['canvas_height']);?>">
	<input type="hidden" id="ThreeDee_model_image_url" value="">

	<input type="hidden" name="product_image_data" id="product_image_data" value="">
	<input type="hidden" name="product_gif_data" id="product_gif_data" value="">
	<input type="hidden" name="product_webm_data" id="product_webm_data" value="">


	<p>
		<?php _e( 'Shortcode', 'ThreeDee' ); ?>:<input id="ThreeDee_shortcode" readonly size="50" onclick="this.select()" type="text">&nbsp;<button id="ThreeDee-sg-button" onclick="ThreeDeeGenerateShortcode();" class="button-secondary" type="button"><?php _e( 'Generate', 'ThreeDee' ); ?></button>
	</p>

	<p>
		<button class="button-secondary" id="set-model" type="button"><?php _e( 'Set model', 'ThreeDee' ); ?></button> (.OBJ, .STL, .WRL, .GLTF, .GLB, .ZIP)
	</p>

	<div id="ThreeDee-viewer" style="display:none;">
		<p class="hide-if-no-js" id="ThreeDee-canvas-instructions">
			<?php _e('Adjust angle with the left mouse button. Zoom with the scroll button. Adjust camera position with the right mouse button.', 'ThreeDee');?>
		</p>

		<canvas id="ThreeDee-cv" width="<?php echo esc_attr($settings['canvas_width']);?>" height="<?php echo esc_attr($settings['canvas_height']);?>" style="border: 1px solid;max-width:500px;max-height:500px;"></canvas>
		<div id="ThreeDee-file-loading" style="display:none;">
			<img alt="Loading file" src="<?php echo esc_attr($settings['ajax_loader']); ?>">
		</div>
		<p style="display:none;" id="ThreeDee-convert1" class="ThreeDee-status2">&#9888; <?php _e('For best performance <a href="https://modelconverter.com/convert.html">convert</a> the model to GLB format.', 'ThreeDee'); ?></p>
		<p style="display:none;" id="ThreeDee-convert2" class="ThreeDee-status2">&#9888; <?php _e('For best performance <a href="https://myminifactory.github.io/stl2gltf/">convert</a> the model to GLB format.', 'ThreeDee'); ?></p>

		<div class="ThreeDee-info">
			<table cellpadding="5">
				<tr>
					<td>
						<p class="ThreeDee-info" id="ThreeDee-file-stats">
							<?php _e('File Size', 'ThreeDee');?>&nbsp;<span id="ThreeDee-file-stats-size">0</span>&nbsp;<?php _e('mb', 'ThreeDee');?>&nbsp;
							<?php _e('Polygon Count', 'ThreeDee');?>&nbsp;<span id="ThreeDee-file-stats-polygons">0</span>
						</p>
					</td>
					<td>
						<p>
							<input id="ThreeDee-remember-camera-position" type="checkbox" checked value="1">
							<label for="ThreeDee-remember-camera-position">
							<?php _e('Remember camera position', 'ThreeDee');?>
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
			<p id="ThreeDee-canvas-repair-status" style="display:none;">
				<br style="clear:both"> 
				<img id="ThreeDee-canvas-repair-image" alt="Repairing" src="<?php echo plugins_url( 'woo-3d-viewer/images/ajax-loader-small.gif'); ?>">
				<span id="ThreeDee-canvas-repair-message"></span>
			</p>
			<p id="ThreeDee-canvas-reduce-status" style="display:none;">
				<br style="clear:both">
				<img id="ThreeDee-canvas-reduce-image" alt="Reducing" src="<?php echo plugins_url( 'woo-3d-viewer/images/ajax-loader-small.gif'); ?>">
				<span id="ThreeDee-canvas-reduce-message"></span>
			</p>
		</div>

		<div class="ThreeDee-info">
			<table>
			<tr>
				<td>
					<button onclick="alert('Unlock in PRO version')" type="button"><?php _e('Repair', 'ThreeDee');?></button>&nbsp;
					<button onclick="alert('Unlock in PRO version')" type="button"><?php _e('Reduce', 'ThreeDee');?></button>&nbsp;
					<button onclick="ThreeDeeFitCameraToObject(ThreeDee.camera, ThreeDee.object, 1.2, ThreeDee.controls);" type="button"><?php _e('Fit camera');?></button>
				</td>
				<td>
					<span class="ThreeDee-x-axis"><?php _e('X','ThreeDee');?>:</span>
					<input type="number" autocomplete="off" class="ThreeDee-dim-input" min="-360" max="360" step="90" value="0" id="rotation_x" > <span class="ThreeDee-separator">&deg; </span> 
					<span class="ThreeDee-y-axis"><?php _e('Y','ThreeDee');?>:</span>
					<input type="number" autocomplete="off" class="ThreeDee-dim-input" min="-360" max="360" step="90" value="0" id="rotation_y" > <span class="ThreeDee-separator">&deg; </span>
					<span class="ThreeDee-z-axis"><?php _e('Z','ThreeDee');?>:</span>
					<input type="number" autocomplete="off" class="ThreeDee-dim-input" min="-360" max="360" step="90" value="0" id="rotation_z" > <span class="ThreeDee-separator">&deg; </span>
					<span class="ThreeDee-z-offset"><?php _e('Z Offset','ThreeDee');?>:</span>
					<input type="number" autocomplete="off" step="0.1" value="" id="z_offset"> 
				</td>
			</tr>
			</table>
		</div>

		<table>
		<tr>
			<td><?php _e('Canvas Width');?>:</td>
			<td><input type="number" id="ThreeDee-canvas-width" min="1" value="500" style="width:80px">px</td>
			<td><?php _e('Canvas Height');?>:</td>
			<td><input type="number" id="ThreeDee-canvas-height" min="1" value="500" style="width:80px">px</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td><?php _e('Color');?>:</td>
			<td><input type="text" id="ThreeDee-model-color" class="ThreeDee-color-picker" onchange="ThreeDeeChangeModelColor(this.value);" value="<?php echo $settings['model_default_color'];?>" /></td>
			<td><?php _e('Background Color');?>:</td>
			<td><input type="text" id="ThreeDee-background-color" class="ThreeDee-color-picker ThreeDee-background" onchange="ThreeDeeChangeBackgroundColor(this.value);" value="<?php echo $settings['background1'];?>"></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td><?php _e('Shininess', 'ThreeDee');?>:</td>
			<td>
				<select id="ThreeDee-model-shininess" onchange="ThreeDeeSetCurrentShininess(this.value);">
					<option selected value="plastic"><?php _e('Plastic', 'ThreeDee');?></option>
					<option value="wood"><?php _e('Wood', 'ThreeDee');?></option>
					<option value="metal"><?php _e('Metal', 'ThreeDee');?></option>
				</select>
			</td>
			<td><?php _e( 'Grid Color', 'ThreeDee' );?>:</td>
			<td><input type="text" id="ThreeDee-grid-color" class="ThreeDee-color-picker ThreeDee-grid" onchange="ThreeDeeChangeGridColor(this.value);" value="<?php echo $settings['grid_color'];?>"></td>
			<td><?php _e( 'Show Grid', 'ThreeDee' );?></td>
			<td><input type="checkbox" id="ThreeDee-show-grid" onclick="ThreeDeeToggleGrid();" <?php if ($settings['show_grid']=='on') echo 'checked';?>></td>
<!--			<td><?php _e( 'Fog Color', 'ThreeDee' );?>:</td>
			<td><input type="text" id="ThreeDee-fog-color" class="ThreeDee-color-picker ThreeDee-fog" onchange="ThreeDeeChangeFogColor(this.value);" value="<?php echo $product_fog_color;?>"></td>
			<td><?php _e( 'Show Fog', 'ThreeDee' );?></td>
			<td><input type="checkbox" id="ThreeDee-show-fog" onclick="ThreeDeeToggleFog();" <?php if ($product_show_fog=='on') echo 'checked';?>></td>
-->

		</tr>
		<tr>
		<td><?php _e('Transparency', 'ThreeDee');?>:</td>
			<td>
				<select id="ThreeDee-model-transparency" onchange="ThreeDeeSetCurrentTransparency(this.value);">
					<option selected value="opaque"><?php _e('Opaque', 'ThreeDee');?></option>
					<option value="resin"><?php _e('Resin', 'ThreeDee');?></option>
					<option value="glass"><?php _e('Glass', 'ThreeDee');?></option>
				</select>
			</td>
			<td><?php _e( 'Ground Color', 'ThreeDee' );?>:</td>
			<td><input type="text" id="ThreeDee-ground-color" class="ThreeDee-color-picker ThreeDee-ground" onchange="ThreeDeeChangeGroundColor(this.value);" value="<?php echo $settings['ground_color'];?>"></td>
			<td><?php _e( 'Show Ground', 'ThreeDee' );?></td>
			<td><input type="checkbox" id="ThreeDee-show-ground" onclick="ThreeDeeToggleGround();" <?php if ($settings['show_ground']=='on') echo 'checked';?>></td>
		</tr>
		<tr>
			<td>
				<?php _e('Display mode', 'ThreeDee');?>:
			</td>
			<td>
				<select id="ThreeDee-display-mode">
					<option selected value="3d_model"><?php _e('3D model', 'ThreeDee');?></option>
<!--					<option value="png_image"><?php _e('PNG image', 'ThreeDee');?></option>--> <!-- todo -->
					<option disabled value="gif_image"><?php _e('GIF image', 'ThreeDee');?></option>
					<option disabled value="webm_video"><?php _e('WEBM video', 'ThreeDee');?></option>
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
				<?php _e('Mobile display mode', 'ThreeDee');?>:
			</td>
			<td>
				<select id="ThreeDee-display-mode-mobile">
					<option selected value="3d_model"><?php _e('3D model', 'ThreeDee');?></option>
<!--					<option value="png_image"><?php _e('PNG image', 'ThreeDee');?></option>--> <!-- todo -->
					<option disabled value="gif_image"><?php _e('GIF image', 'ThreeDee');?></option>
					<option disabled value="webm_video"><?php _e('WEBM video', 'ThreeDee');?></option>
				</select>
				<br>Unlock in <a href="http://ThreeDeeiewer.wp3dprinting.com/">PRO version</a><br><br>
			</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>


		</tr>
		<tr>
			<td><?php _e( 'Light Sources', 'ThreeDee' );?>:</td>
			<td>
				<table>
					<tr>
						<td><input onclick="ThreeDeeToggleLightSource(8);" type="checkbox" id="ThreeDee-show-light-source8" <?php if ($settings['show_light_source8']=='on') echo 'checked';?>></td>
						<td><input onclick="ThreeDeeToggleLightSource(1);" type="checkbox" id="ThreeDee-show-light-source1" <?php if ($settings['show_light_source1']=='on') echo 'checked';?>></td>
						<td><input onclick="ThreeDeeToggleLightSource(2);" type="checkbox" id="ThreeDee-show-light-source2" <?php if ($settings['show_light_source2']=='on') echo 'checked';?>></td>
					</tr>
					<tr>
						<td><input onclick="ThreeDeeToggleLightSource(7);" type="checkbox" id="ThreeDee-show-light-source7" <?php if ($settings['show_light_source7']=='on') echo 'checked';?>></td>
						<td><input onclick="ThreeDeeToggleLightSource(9);" type="checkbox" id="ThreeDee-show-light-source9" <?php if ($settings['show_light_source9']=='on') echo 'checked';?>></td>
						<td><input onclick="ThreeDeeToggleLightSource(3);" type="checkbox" id="ThreeDee-show-light-source3" <?php if ($settings['show_light_source3']=='on') echo 'checked';?>></td>
					</tr>
					<tr>
						<td><input onclick="ThreeDeeToggleLightSource(6);" type="checkbox" id="ThreeDee-show-light-source6" <?php if ($settings['show_light_source6']=='on') echo 'checked';?>></td>
						<td><input onclick="ThreeDeeToggleLightSource(5);" type="checkbox" id="ThreeDee-show-light-source5" <?php if ($settings['show_light_source5']=='on') echo 'checked';?>></td>
						<td><input onclick="ThreeDeeToggleLightSource(4);" type="checkbox" id="ThreeDee-show-light-source4" <?php if ($settings['show_light_source4']=='on') echo 'checked';?>></td>
					</tr>
				</table>

			</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td><?php _e( 'Show Shadow', 'ThreeDee' );?>:</td>
			<td><input onclick="ThreeDeeToggleShadow();" type="checkbox" id="ThreeDee-show-shadow" <?php if ($settings['show_shadow']=='on') echo 'checked';?>></td>
		</tr>
		<tr>
			<td><?php _e( 'Show Mirror', 'ThreeDee' );?>:</td>
			<td><input onclick="ThreeDeeToggleMirror();" type="checkbox" id="ThreeDee-show-mirror" <?php if ($settings['ground_mirror']=='on') echo 'checked';?>></td>
		</tr>
		<tr>
			<td><?php _e( 'Auto Rotation', 'ThreeDee' );?>:</td>
			<td><input onclick="ThreeDeeToggleRotation(this.checked);" type="checkbox" id="ThreeDee-auto-rotation" <?php if ($settings['auto_rotation']=='on') echo 'checked';?>></td>
		</tr>
		<tr>
			<td><?php _e( 'Show Controls', 'ThreeDee' );?>:</td>
			<td><input type="checkbox" id="ThreeDee-show-controls" <?php if ($settings['show_controls']=='on') echo 'checked';?>></td>
		</tr>


		</table>

			<div id="png_block" style="display:none">

			</div>
			<div id="gif_block" style="display:none;">

			</div>
			<div id="webm_block" style="display:none">

			</div>



	</div>
