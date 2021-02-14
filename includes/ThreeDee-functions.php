<?php

/**
 *
 *
 * @author Sergey Burkov, http://www.wp3dprinting.com
 * @copyright 2017
 */

function ThreeDee_activate() {
	global $wpdb;

//	if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
//		deactivate_plugins( plugin_basename( __FILE__ ) );
//		wp_die ('Woocommerce is not installed!');
//	}

	$current_version = get_option( 'ThreeDee_version');


	ThreeDee_check_install();

	add_option( 'ThreeDee_do_activation_redirect', true );

	update_option( 'ThreeDee_version', ThreeDee_VERSION );

	do_action( 'ThreeDee_activate' );
}

function ThreeDee_check_install() {
	global $wpdb;

	$current_version = get_option( 'ThreeDee_version');
	$charset_collate = $wpdb->get_charset_collate();

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	$default_image_url = str_replace('http:','',plugins_url()).'/threedee/images/';

	$current_settings = get_option( 'ThreeDee_settings' );

	update_option( 'ThreeDee_servers',  array(0=>'http://srv1.wp3dprinting.com', 1=>'http://srv2.wp3dprinting.com') );

	if (!isset($current_settings['display_mode'])) $display_mode = '3d_model';
	else $display_mode = $current_settings['display_mode'];
	if (!isset($current_settings['display_mode_mobile'])) $display_mode_mobile = $display_mode;
	else $display_mode_mobile = $current_settings['display_mode_mobile'];

	$settings=array(
		'file_extensions' => 'stl,obj,wrl,gltf,glb,zip',
		'display_mode' => $display_mode,
		'display_mode_mobile' => $display_mode_mobile,
		'canvas_width' => (isset($current_settings['canvas_width']) ? $current_settings['canvas_width'] : '1024'),
		'canvas_height' => (isset($current_settings['canvas_height']) ? $current_settings['canvas_height'] : '768'),
		'shading' => (isset($current_settings['shading']) ? $current_settings['shading'] : 'flat'),
		'auto_rotation' => (isset($current_settings['auto_rotation']) ? $current_settings['auto_rotation'] : 'on'),
		'background1' => (isset($current_settings['background1']) ? $current_settings['background1'] : '#FFFFFF'),
		'background2' => (isset($current_settings['background2']) ? $current_settings['background2'] : '#1e73be'),
		'model_default_color' => (isset($current_settings['model_default_color']) ? $current_settings['model_default_color'] : '#ffffff'),
		'grid_color' => (isset($current_settings['grid_color']) ? $current_settings['grid_color'] : '#898989'),
		'fog_color' => (isset($current_settings['fog_color']) ? $current_settings['fog_color'] : '#FFFFFF'),
		'ground_color' => (isset($current_settings['ground_color']) ? $current_settings['ground_color'] : '#c1c1c1'),
		'ground_mirror' => (isset($current_settings['ground_mirror']) ? $current_settings['ground_mirror'] : ''),
		'show_light_source1' => (isset($current_settings['show_light_source1']) ? $current_settings['show_light_source1'] : ''),
		'show_light_source2' => (isset($current_settings['show_light_source2']) ? $current_settings['show_light_source2'] : 'on'),
		'show_light_source3' => (isset($current_settings['show_light_source3']) ? $current_settings['show_light_source3'] : ''),
		'show_light_source4' => (isset($current_settings['show_light_source4']) ? $current_settings['show_light_source4'] : ''),
		'show_light_source5' => (isset($current_settings['show_light_source5']) ? $current_settings['show_light_source5'] : ''),
		'show_light_source6' => (isset($current_settings['show_light_source6']) ? $current_settings['show_light_source6'] : 'on'),
		'show_light_source7' => (isset($current_settings['show_light_source7']) ? $current_settings['show_light_source7'] : ''),
		'show_light_source8' => (isset($current_settings['show_light_source8']) ? $current_settings['show_light_source8'] : ''),
		'show_light_source9' => (isset($current_settings['show_light_source9']) ? $current_settings['show_light_source9'] : ''),
		'show_shadow' => (isset($current_settings['show_shadow']) ? $current_settings['show_shadow'] : ''),
		'show_ground' => (isset($current_settings['show_ground']) ? $current_settings['show_ground'] : 'on'),
		'ajax_loader' => (isset($current_settings['ajax_loader']) ? $current_settings['ajax_loader'] : $default_image_url.'ajax-loader.gif'),
		'view3d_button_image' => (isset($current_settings['view3d_button_image']) ? $current_settings['view3d_button_image'] : $default_image_url.'view3d.png'),
		'show_grid' => (isset($current_settings['show_grid']) ? $current_settings['show_grid'] : 'on'),
		'show_fog' => (isset($current_settings['show_fog']) ? $current_settings['show_fog'] : ''),
		'show_controls' => (isset($current_settings['show_controls']) ? $current_settings['show_controls'] : 'on'),
		'enable_controls' => (isset($current_settings['enable_controls']) ? $current_settings['enable_controls'] : 'on'),
		'api_login' => (isset($current_settings['api_login']) ? $current_settings['api_login'] : ''),
		'load_everywhere' => (isset($current_settings['load_everywhere']) ? $current_settings['load_everywhere'] : 'on'),
		'file_chunk_size' => (isset($current_settings['file_chunk_size']) ? $current_settings['file_chunk_size'] : '2'),
		'model_compression' => (isset($current_settings['model_compression']) ? $current_settings['model_compression'] : 'on'),
		'model_compression_threshold' => (isset($current_settings['model_compression_threshold']) ? $current_settings['model_compression_threshold'] : '1'),
		'proxy' => (isset($current_settings['proxy']) ? $current_settings['proxy'] : ''),
		'proxy_domains' => (isset($current_settings['proxy_domains']) ? $current_settings['proxy_domains'] : ''),
		'mobile_no_animation' => (isset($current_settings['mobile_no_animation']) ? $current_settings['mobile_no_animation'] : '')
	);


	update_option( 'ThreeDee_settings', $settings );

	$upload_dir = wp_upload_dir();

	if ( !is_dir( $upload_dir['basedir'].'/ThreeDee/' ) ) {
		mkdir( $upload_dir['basedir'].'/ThreeDee/' );
	}

	if ( !file_exists( $upload_dir['basedir'].'/ThreeDee/index.html' ) ) {
		$fp = fopen( $upload_dir['basedir'].'/ThreeDee/index.html', "w" );
		fclose( $fp );
	}


	update_option( 'ThreeDee_version', ThreeDee_VERSION );

}

function ThreeDee_filter_update_checks($queryArgs) {
	$settings = get_option('ThreeDee_settings');
	if ( !empty($settings['api_login']) ) {
		$queryArgs['login'] = $settings['api_login'];

	}
	return $queryArgs;
}

function ThreeDee_get_option ($option) {
	return get_option($option);
}

function ThreeDee_add_option ($option, $data) {

	add_option($data);
}

function ThreeDee_update_option ($option, $data) {
	update_option($option, $data);
}

add_action( 'plugins_loaded', 'ThreeDee_load_textdomain' );
function ThreeDee_load_textdomain() {
	load_plugin_textdomain( 'ThreeDee', false, dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/' );
}


function ThreeDee_enqueue_scripts_frontend() {
	global $post, $woocommerce;
	if ( function_exists('is_shop') && is_shop() ) return false;

	$available_variations = array();

	$product_model = get_post_meta( get_the_ID(), '_product_model', true );
	$display_mode = get_post_meta( get_the_ID(), '_display_mode', true );
	$display_mode_mobile = get_post_meta( get_the_ID(), '_display_mode_mobile', true );

	$ThreeDee_current_version = get_option('ThreeDee_version');

	$settings = get_option( 'ThreeDee_settings' );

	if (ThreeDee_is_ThreeDee(get_the_ID())) {
		if ($display_mode=='3d_model' && $settings['load_everywhere']!='on') $condition = (strlen( $product_model ) );
		else $condition = true;
	}
	else if ($settings['load_everywhere']=='on') {
		$condition = true;

	}
		else $condition = false;

	//do not load on 3DPrint products
	$post_object = get_post(get_the_ID());
	if (is_object($post_object) && $post_object->post_type=='product' && class_exists('WC_Product_Variable')) {
		$product = new WC_Product_Variable( get_the_ID() );
		if (function_exists('p3d_is_p3d') && p3d_is_p3d($product->get_id())) {
			$condition = false;
		}

	}

	//echo get_the_ID();
	if ( $condition ) {
		wp_enqueue_style( 'ThreeDee-frontend.css', plugin_dir_url( __FILE__ ).'css/ThreeDee-frontend.css', array(), $ThreeDee_current_version );

		wp_enqueue_style( 'tooltipster.bundle.min.css', plugin_dir_url( __FILE__ ).'ext/tooltipster/css/tooltipster.bundle.min.css', array(), $ThreeDee_current_version );
		wp_enqueue_style( 'tooltipster-sideTip-light.min.css ', plugin_dir_url( __FILE__ ).'ext/tooltipster/css/plugins/tooltipster/sideTip/themes/tooltipster-sideTip-light.min.css', array(), $ThreeDee_current_version );

		if( $woocommerce && version_compare( $woocommerce->version, '3.0', ">=" ) ) {
			wp_enqueue_style( 'prettyPhoto.css', plugin_dir_url( __FILE__ ).'ext/prettyPhoto/css/prettyPhoto.css', array(), $ThreeDee_current_version );
		}

//		wp_enqueue_script( 'ThreeDee-threejs-checker',  plugin_dir_url( __FILE__ ).'js/ThreeDee-threejs-checker.js', array( 'jquery' ), $ThreeDee_current_version );

		wp_enqueue_script( 'ThreeDee-es6-promise',  plugin_dir_url( __FILE__ ).'ext/es6-promise/es6-promise.auto.js', array( 'jquery' ), $ThreeDee_current_version );
		wp_enqueue_script( 'ThreeDee-threejs',  plugin_dir_url( __FILE__ ).'ext/threejs/three.min.js', array( 'jquery' ), $ThreeDee_current_version );
		wp_enqueue_script( 'ThreeDee-threejs-detector',  plugin_dir_url( __FILE__ ).'ext/threejs/js/Detector.js', array( 'jquery' ), $ThreeDee_current_version );
		wp_enqueue_script( 'ThreeDee-threejs-mirror',  plugin_dir_url( __FILE__ ).'ext/threejs/js/Mirror.js', array( 'jquery' ), $ThreeDee_current_version );
		wp_enqueue_script( 'ThreeDee-threejs-controls',  plugin_dir_url( __FILE__ ).'ext/threejs/js/controls/OrbitControls.js', array( 'jquery' ), $ThreeDee_current_version );
		wp_enqueue_script( 'ThreeDee-threejs-canvas-renderer',  plugin_dir_url( __FILE__ ).'ext/threejs/js/renderers/CanvasRenderer.js', array( 'jquery' ), $ThreeDee_current_version );
		wp_enqueue_script( 'ThreeDee-threejs-projector-renderer',  plugin_dir_url( __FILE__ ).'ext/threejs/js/renderers/Projector.js', array( 'jquery' ), $ThreeDee_current_version );
		wp_enqueue_script( 'ThreeDee-threejs-stl-loader',  plugin_dir_url( __FILE__ ).'ext/threejs/js/loaders/STLLoader.js', array( 'jquery' ), $ThreeDee_current_version );
		wp_enqueue_script( 'ThreeDee-threejs-obj-loader',  plugin_dir_url( __FILE__ ).'ext/threejs/js/loaders/OBJLoader.js', array( 'jquery' ), $ThreeDee_current_version );
		wp_enqueue_script( 'ThreeDee-threejs-vrml-loader',  plugin_dir_url( __FILE__ ).'ext/threejs/js/loaders/VRMLLoader.js', array( 'jquery' ), $ThreeDee_current_version );
		wp_enqueue_script( 'ThreeDee-threejs-draco-loader',  plugin_dir_url( __FILE__ ).'ext/threejs/js/loaders/DRACOLoader.js', array( 'jquery' ), $ThreeDee_current_version );
		wp_enqueue_script( 'ThreeDee-threejs-gltf-loader',  plugin_dir_url( __FILE__ ).'ext/threejs/js/loaders/GLTFLoader.js', array( 'jquery' ), $ThreeDee_current_version );
#
		wp_enqueue_script( 'ThreeDee-threejs-mtl-loader',  plugin_dir_url( __FILE__ ).'ext/threejs/js/loaders/MTLLoader.js', array( 'jquery' ), $ThreeDee_current_version );
		wp_enqueue_script( 'ThreeDee-threex',  plugin_dir_url( __FILE__ ).'ext/threex/THREEx.FullScreen.js', array( 'jquery' ), $ThreeDee_current_version );



		if( $woocommerce && version_compare( $woocommerce->version, '3.0', ">=" ) ) {
			wp_enqueue_script( 'jquery.prettyPhoto.min.js',  plugin_dir_url( __FILE__ ).'ext/prettyPhoto/js/jquery.prettyPhoto.min.js', array( 'jquery' ), $ThreeDee_current_version );
			wp_enqueue_script( 'jquery.prettyPhoto.init.min.js',  plugin_dir_url( __FILE__ ).'ext/prettyPhoto/js/jquery.prettyPhoto.init.min.js', array( 'jquery' ), $ThreeDee_current_version );
		}
		wp_enqueue_script( 'ThreeDee-frontend.js',  plugin_dir_url( __FILE__ ).'js/ThreeDee-frontend.js', array( 'jquery' ), $ThreeDee_current_version );

		$settings=get_option( 'ThreeDee_settings' );

		$ThreeDee_file_url = get_post_meta(get_the_ID(), 'ThreeDee_file_url', true); 


		wp_localize_script( 'ThreeDee-frontend.js', 'ThreeDee',
			array(
				'url' => admin_url( 'admin-ajax.php' ),
				'plugin_url' => plugin_dir_url( dirname( __FILE__ ) ),
				'shading' => $settings['shading'],
				'display_mode' => isset($settings['display_mode']) ? $settings['display_mode'] : '3d_model',
				'display_mode_mobile' => isset($settings['display_mode_mobile']) ? $settings['display_mode_mobile'] : '3d_model',
				'show_shadow' => $settings['show_shadow'],
				'show_light_source1' => $settings['show_light_source1'],
				'show_light_source2' => $settings['show_light_source2'],
				'show_light_source3' => $settings['show_light_source3'],
				'show_light_source4' => $settings['show_light_source4'],
				'show_light_source5' => $settings['show_light_source5'],
				'show_light_source6' => $settings['show_light_source6'],
				'show_light_source7' => $settings['show_light_source7'],
				'show_light_source9' => $settings['show_light_source9'],
				'show_fog' => $settings['show_fog'],
				'show_controls' => $settings['show_controls'],
				'enable_controls' => $settings['enable_controls'],
				'show_ground' => $settings['show_ground'],
				'ground_mirror' => $settings['ground_mirror'],
				'model_default_color' => str_replace( '#', '0x', $settings['model_default_color'] ),
				'background1' => str_replace( '#', '0x', $settings['background1']),
				'grid_color' => str_replace( '#', '0x', $settings['grid_color'] ),
				'ground_color' => str_replace( '#', '0x', $settings['ground_color'] ),
				'fog_color' => str_replace( '#', '0x', $settings['fog_color'] ),
				'auto_rotation' => $settings['auto_rotation'],
				'show_grid' => $settings['show_grid'],
				'mobile_no_animation' => $settings['mobile_no_animation'],
				'text_not_available' => __('Not available in your browser', 'ThreeDee'),
				'text_multiple' => __('Upgrade to ThreeDeeiewer PRO to have multiple viewers on one page!', 'ThreeDee')
			)
		);

		if  ( ThreeDee_is_ThreeDee ( get_the_ID() ) || $condition ) {
			$fix_css = "
				.product.has-default-attributes.has-children > .images {
					opacity:1 !important;
				}
				@media screen and (max-width: 400px) {
				   .product.has-default-attributes.has-children > .images { 
				    float: none;
				    margin-right:0;
				    width:auto;
				    border:0;
				    border-bottom:2px solid #000;    
				  }
				}
				@media screen and (max-width:800px){
					.product.has-default-attributes.has-children > .images  {
						width: auto !important;
					}

				}
			";
			wp_add_inline_style( 'ThreeDee-frontend.css', $fix_css );
		}
	}


	
}

function ThreeDee_handle_upload() {
		check_ajax_referer( 'ThreeDee-file-upload', 'nonce' );

		$filename = sanitize_file_name($_POST['file']).($_POST['file_type']=='gif' ? ".gif" : ".webm");

		$wp_upload_dir = wp_upload_dir();

		$file_path     = $wp_upload_dir['basedir'].'/ThreeDee/' . $filename;
		$file_data     = ThreeDee_decode_chunk( $_POST['file_data'] );

		if ( false === $file_data ) {
			wp_send_json_error();
		}

		file_put_contents( $file_path, $file_data, FILE_APPEND );

		wp_send_json_success();

}

function ThreeDee_decode_chunk( $data ) {
	$data = explode( ';base64,', $data );
		if ( ! is_array( $data ) || ! isset( $data[1] ) ) {
		return false;
	}
		$data = base64_decode( $data[1] );
	if ( ! $data ) {
		return false;
	}
		return $data;
}


add_action( 'admin_init', 'ThreeDee_plugin_redirect' );
function ThreeDee_plugin_redirect() {
	if ( get_option( 'ThreeDee_do_activation_redirect', false ) ) {
		delete_option( 'ThreeDee_do_activation_redirect' );
		if ( !isset( $_GET['activate-multi'] ) ) {
			wp_redirect( admin_url( 'admin.php?page=ThreeDee' ) );exit;
		}
	}
}

function ThreeDee_extension($file) {
	$array=explode('.',$file);
	$ext=array_pop($array);
	return $ext;
} 




function ThreeDee_deactivate() {
	global $wpdb;

	do_action( 'ThreeDee_deactivate' );
}

function ThreeDee_delete_ThreeDee( $post_id ) {

}

function ThreeDee_is_ThreeDee( $post_id ) {
	$product_model = get_post_meta( $post_id, '_product_model', true );
	if (strlen($product_model)) return true;

	$product_image_png = get_post_meta( $post_id, '_product_image_png', true );
	if (strlen($product_image_png)) return true;

	$product_image_gif = get_post_meta( $post_id, '_product_image_gif', true );
	if (strlen($product_image_gif)) return true;

	$product_video_webm = get_post_meta( $post_id, '_product_video_webm', true );
	if (strlen($product_video_webm)) return true;


	return false;
}

add_action( 'save_post', 'ThreeDee_save_post' );
function ThreeDee_save_post( $post_id ) {

	if ( wp_is_post_revision( $post_id ) )
		return;
	if ( isset( $_POST['post_ID'] ) && $_POST['post_ID']==$post_id ) {
//		var_dump($_POST);exit;

	}


}


add_action('woocommerce_variation_options', 'ThreeDee_variation_options', 10, 3);
function ThreeDee_variation_options($loop, $variation_data, $variation) {

	$product_id = $variation->post_parent;
	$variation_id = $variation->ID;

	if (ThreeDee_is_ThreeDee($product_id)) {
	$settings = get_option( 'ThreeDee_settings' );
?>
<script>
jQuery(document).ready(function() {
	jQuery( "table.ThreeDee-settings .ThreeDee-color-picker" ).wpColorPicker();
})
</script>

		<p><?php _e('ThreeDeeiewer settings', 'ThreeDee');?>:</p>
		<br>Unlock in <a href="http://ThreeDeeiewer.wp3dprinting.com/">PRO version</a>
		<br>
		<table class="ThreeDee-settings">
			<tr>
				<td><?php _e( 'Custom Model', 'ThreeDee' ); ?>:</td>
				<td class="file_url">
					<input type="text" class="input_text" disabled placeholder="<?php esc_attr_e( 'STL, OBJ or ZIP file', 'ThreeDee' ); ?>" value="" />
				</td>
				<td class="file_url_choose" width="1%"><a title="<?php _e( 'Set model', 'ThreeDee' ); ?>" class="button" href="javascript:;" onclick="return false;"><?php _e( 'Set model', 'ThreeDee' ); ?></a></td>
				<td width="1%"><a href="javascript:void(0);" onclick="return false;"class="button"><?php _e( 'Delete', 'ThreeDee' ); ?></a></td>
			</tr>
			<tr>
				<td>
					<?php _e( 'Rotation', 'ThreeDee' ); ?>: 
				</td>
				<td>
					<table>
					<tr>
					<td>X<input disabled size="3" style="width:20px;" type="text" value="" />&deg;</td>
					<td>Y<input disabled size="3" style="width:20px;" type="text" value="" />&deg;</td>
					<td>Z<input disabled size="3" style="width:20px;" type="text" value="" />&deg;</td>
					</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<?php _e( 'Color', 'ThreeDee' ); ?>: 
				</td>
				<td>
					<input disabled type="text" class="ThreeDee-color-picker" value="<?php esc_attr_e( $settings['model_default_color'] );?>" />
				</td>
			</tr>
			<tr>
				<td><?php _e('Shininess', 'ThreeDee');?>:</td>
				<td>
					<select disabled >
						<option value="default"><?php _e('Default', 'ThreeDee');?></option>
						<option value="plastic"><?php _e('Plastic', 'ThreeDee');?></option>
						<option value="wood"><?php _e('Wood', 'ThreeDee');?></option>
						<option value="metal"><?php _e('Metal', 'ThreeDee');?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td><?php _e('Transparency', 'ThreeDee');?>:</td>
				<td>
					<select disabled>
						<option value="default"><?php _e('Default', 'ThreeDee');?></option>
						<option value="opaque"><?php _e('Opaque', 'ThreeDee');?></option>
						<option value="resin"><?php _e('Resin', 'ThreeDee');?></option>
						<option value="glass"><?php _e('Glass', 'ThreeDee');?></option>
					</select>
				</td>
			</tr>


		</table>
<?php
	}
}


function ThreeDee_save_thumbnail( $data, $filename ) {
	$link = '';
	if ( !empty($data) ) {
//		$new_filename=$filename.'.png';
		$new_filename=$filename;
		$upload_dir = wp_upload_dir();
		$file_path=$upload_dir['basedir'].'/ThreeDee/'.$new_filename;
		file_put_contents( $file_path, base64_decode( $data ) );
		$link = $upload_dir['baseurl'].'/ThreeDee/'.$new_filename;
	}
	return $link;
}

//do_action( 'woocommerce_save_product_variation', $variation_id, $i );

add_action( 'woocommerce_save_product_variation', 'ThreeDee_save_product_variation', 20, 2 );  //save changes button is pressed
function ThreeDee_save_product_variation($post_id, $i) {
		//save variations
		if ( isset($_POST['ThreeDee_variation_file_url']) && count($_POST['ThreeDee_variation_file_url'])>0 ) {
			$options = array();
			foreach ($_POST['ThreeDee_variation_file_url'] as $variation_id => $file_url) {
				$options['product_model']=$file_url;
				$options['product_image_png']='';
				$options['product_image_gif']='';
				$options['product_video_webm']='';
				$options['display_mode']='3d_model';
				$options['display_mode_mobile']='3d_model';
				$options['product_color']=$_POST['ThreeDee_variation_product_color'][$variation_id];
				$options['product_shininess']=$_POST['ThreeDee_variation_product_shininess'][$variation_id];
				$options['product_transparency']=$_POST['ThreeDee_variation_product_transparency'][$variation_id];
				$options['rotation_x']=(int)$_POST['ThreeDee_variation_product_rotation_x'][$variation_id];
				$options['rotation_y']=(int)$_POST['ThreeDee_variation_product_rotation_y'][$variation_id];
				$options['rotation_z']=(int)$_POST['ThreeDee_variation_product_rotation_z'][$variation_id];
				$options['attachment_id']=(int)$_POST['ThreeDee_variation_attachment_id'][$variation_id];
				$options['product_image_data']='';
				$options['product_gif_data']='';
				$options['product_webm_data']='';
				ThreeDee_save_model_meta($variation_id, $options);
			}
		}
}

add_action( 'woocommerce_process_product_meta', 'ThreeDee_save_model', 20, 2 ); //update button is pressed
function ThreeDee_save_model($post_id) {

		$options = $_POST;

		//save main post
		ThreeDee_save_model_meta($post_id, $options);

		//save variations
		if ( isset($_POST['ThreeDee_variation_file_url']) && count($_POST['ThreeDee_variation_file_url'])>0 ) {
			$options = array();
			foreach ($_POST['ThreeDee_variation_file_url'] as $variation_id => $file_url) {
				$options['product_model']=$file_url;
				$options['product_image_png']='';
				$options['product_image_gif']='';
				$options['product_video_webm']='';
				$options['display_mode']='3d_model';
				$options['display_mode_mobile']='3d_model';
				$options['product_color']=$_POST['ThreeDee_variation_product_color'][$variation_id];
				$options['product_shininess']=$_POST['ThreeDee_variation_product_shininess'][$variation_id];
				$options['product_transparency']=$_POST['ThreeDee_variation_product_transparency'][$variation_id];
				$options['rotation_x']=(int)$_POST['ThreeDee_variation_product_rotation_x'][$variation_id];
				$options['rotation_y']=(int)$_POST['ThreeDee_variation_product_rotation_y'][$variation_id];
				$options['rotation_z']=(int)$_POST['ThreeDee_variation_product_rotation_z'][$variation_id];
				$options['attachment_id']=(int)$_POST['ThreeDee_variation_attachment_id'][$variation_id];
				$options['product_image_data']='';
				$options['product_gif_data']='';
				$options['product_webm_data']='';
				ThreeDee_save_model_meta($variation_id, $options);
			}
		}

}


function ThreeDee_save_model_meta($post_id, $options) {

		$product_model = wc_clean($options['product_model']);
		$product_model = str_ireplace('http:', '', $product_model);
		$product_model = str_ireplace('https:', '', $product_model);
		$product_image_png = wc_clean($options['product_image_png']);
		$product_image_gif = wc_clean($options['product_image_gif']);
		$product_video_webm = wc_clean($options['product_video_webm']);
		$display_mode = wc_clean($options['display_mode']);
		$display_mode_mobile = wc_clean($options['display_mode_mobile']);
		$product_color = wc_clean($options['product_color']);
		$product_shininess = wc_clean($options['product_shininess']);
		$product_transparency = wc_clean($options['product_transparency']);
		$product_attachment_id = wc_clean($options['product_attachment_id']);
		$rotation_x = (int)$options['rotation_x'];
		$rotation_y = (int)$options['rotation_y'];
		$rotation_z = (int)$options['rotation_z'];
		$product_remember_camera_position=(int)$options['product_remember_camera_position'];
		$product_camera_position_x = (float)$options['product_camera_position_x'];
		$product_camera_position_y = (float)$options['product_camera_position_y'];
		$product_camera_position_z = (float)$options['product_camera_position_z'];
		$product_camera_lookat_x = (float)$options['product_camera_lookat_x'];
		$product_camera_lookat_y = (float)$options['product_camera_lookat_y'];
		$product_camera_lookat_z = (float)$options['product_camera_lookat_z'];
		$product_offset_z = (float)$options['product_offset_z'];
#var_dump($options['product_offset_z']);exit;
		$product_controls_target_x = (float)$options['product_controls_target_x'];
		$product_controls_target_y = (float)$options['product_controls_target_y'];
		$product_controls_target_z = (float)$options['product_controls_target_z'];
		$product_model_extracted_path = $options['product_model_extracted_path'];
		$product_show_light_source1 = $options['product_show_light_source1'];
		$product_show_light_source2 = $options['product_show_light_source2'];
		$product_show_light_source3 = $options['product_show_light_source3'];
		$product_show_light_source4 = $options['product_show_light_source4'];
		$product_show_light_source5 = $options['product_show_light_source5'];
		$product_show_light_source6 = $options['product_show_light_source6'];
		$product_show_light_source7 = $options['product_show_light_source7'];
		$product_show_light_source8 = $options['product_show_light_source8'];
		$product_show_light_source9 = $options['product_show_light_source9'];

		$product_show_fog = $options['product_show_fog'];
		$product_show_grid = $options['product_show_grid'];
		$product_show_ground = $options['product_show_ground'];
		$product_show_shadow = $options['product_show_shadow'];
		$product_background1 = $options['product_background1'];
		$product_ground_mirror = $options['product_show_mirror'];
		$product_fog_color = $options['product_fog_color'];
		$product_grid_color = $options['product_grid_color'];
		$product_ground_color = $options['product_ground_color'];
		$product_auto_rotation = $options['product_auto_rotation'];
		$product_view3d_button = $options['product_view3d_button'];



		

		$product_image_data = $options['product_image_data'];
		$product_gif_data = $options['product_gif_data'];
		$product_webm_data = $options['product_webm_data'];
		$upload_dir = wp_upload_dir();
		$targetDir = dirname($upload_dir['basedir']).'/'.dirname(substr($product_model, strpos($product_model, 'uploads/'))).'/';
		$targetDir = str_replace('/uploads/sites/uploads/sites/', '/uploads/sites/', $targetDir);
		if (strtolower(ThreeDee_extension($product_model))=='zip') {

//ThreeDee_process_zip
			$output = ThreeDee_process_zip($product_model, $targetDir);
			$wp_filename = $output['model_file'];
			$material_file = $output['material_file'];

			update_post_meta( $post_id, 'ThreeDee_original_file', $targetDir.$wp_filename.'.zip' );
			update_post_meta( $post_id, 'ThreeDee_extracted_file', $targetDir.$wp_filename );
			update_post_meta( $post_id, 'ThreeDee_original_file_url', $product_model );

				
		}
		else {

		}
		if ($product_model=='') { //removed
			$old_product_model = get_post_meta( $post_id, '_product_model', true );
			if ($old_product_model) {
				$old_product_path = ThreeDee_get_path_by_url($old_product_model);
				unlink($old_product_path);
			}
		}

		update_post_meta( $post_id, '_product_model', $product_model );
		update_post_meta( $post_id, '_product_model_extracted_path', $product_model_extracted_path );
//		delete_post_meta( $post_id, '_product_model_extracted_path');



		if (strlen($wp_filename)>0) {
			update_post_meta( $post_id, '_product_model', dirname($product_model).'/'.$wp_filename );
			update_post_meta( $post_id, '_product_model_extracted_path', base64_encode($targetDir.'/'.$wp_filename) );
		}

		if (strlen($material_file)>0) {
			update_post_meta( $post_id, '_product_mtl', dirname($product_model).'/'.$material_file );
		}
		else if (ThreeDee_extension($product_model) != 'obj' || (strlen(ThreeDee_extension($wp_filename))>0 && ThreeDee_extension($wp_filename) != 'obj')) {
			delete_post_meta( $post_id, '_product_mtl' );
		}


		update_post_meta( $post_id, '_display_mode', $display_mode );
		update_post_meta( $post_id, '_display_mode_mobile', $display_mode_mobile );
		update_post_meta( $post_id, '_product_color', $product_color );
		update_post_meta( $post_id, '_product_shininess', $product_shininess );
		update_post_meta( $post_id, '_product_transparency', $product_transparency );
		update_post_meta( $post_id, '_product_attachment_id', $product_attachment_id );


		update_post_meta( $post_id, '_rotation_x', $rotation_x );
		update_post_meta( $post_id, '_rotation_y', $rotation_y );
		update_post_meta( $post_id, '_rotation_z', $rotation_z );

		update_post_meta( $post_id, '_product_remember_camera_position', $product_remember_camera_position );

		update_post_meta( $post_id, '_product_camera_position_x', $product_camera_position_x );
		update_post_meta( $post_id, '_product_camera_position_y', $product_camera_position_y );
		update_post_meta( $post_id, '_product_camera_position_z', $product_camera_position_z );

		update_post_meta( $post_id, '_product_camera_lookat_x', $product_camera_lookat_x );
		update_post_meta( $post_id, '_product_camera_lookat_y', $product_camera_lookat_y );
		update_post_meta( $post_id, '_product_camera_lookat_z', $product_camera_lookat_z );

		update_post_meta( $post_id, '_product_offset_z', $product_offset_z );

		update_post_meta( $post_id, '_product_controls_target_x', $product_controls_target_x );
		update_post_meta( $post_id, '_product_controls_target_y', $product_controls_target_y );
		update_post_meta( $post_id, '_product_controls_target_z', $product_controls_target_z );

		update_post_meta( $post_id, '_product_show_light_source1', $product_show_light_source1 );
		update_post_meta( $post_id, '_product_show_light_source2', $product_show_light_source2 );
		update_post_meta( $post_id, '_product_show_light_source3', $product_show_light_source3 );
		update_post_meta( $post_id, '_product_show_light_source4', $product_show_light_source4 );
		update_post_meta( $post_id, '_product_show_light_source5', $product_show_light_source5 );
		update_post_meta( $post_id, '_product_show_light_source6', $product_show_light_source6 );
		update_post_meta( $post_id, '_product_show_light_source7', $product_show_light_source7 );
		update_post_meta( $post_id, '_product_show_light_source8', $product_show_light_source8 );
		update_post_meta( $post_id, '_product_show_light_source9', $product_show_light_source9 );


		update_post_meta( $post_id, '_product_show_fog', $product_show_fog );
		update_post_meta( $post_id, '_product_show_grid', $product_show_grid );
		update_post_meta( $post_id, '_product_show_ground', $product_show_ground );
		update_post_meta( $post_id, '_product_show_shadow', $product_show_shadow );
		update_post_meta( $post_id, '_product_background1', $product_background1 );
		update_post_meta( $post_id, '_product_ground_mirror', $product_ground_mirror );
		update_post_meta( $post_id, '_product_fog_color', $product_fog_color );
		update_post_meta( $post_id, '_product_grid_color', $product_grid_color );
		update_post_meta( $post_id, '_product_ground_color', $product_ground_color );
		update_post_meta( $post_id, '_product_auto_rotation', $product_auto_rotation );
		update_post_meta( $post_id, '_product_view3d_button', $product_view3d_button );




		if ($product_image_png=='') { //removed
			$old_product_image_png = $upload_dir['baseurl'].'/ThreeDee/'.get_post_meta( get_the_ID(), '_product_image_png', true );

			if ($old_product_image_png) {
				$old_png_path = ThreeDee_get_path_by_url('/ThreeDee/'.$old_product_image_png);
				unlink($old_png_path);
				update_post_meta( $post_id, '_product_image_png', '' );
			}
		}

		if ($product_image_gif=='') { //removed
			$old_product_image_gif = $upload_dir['baseurl'].'/ThreeDee/'.get_post_meta( get_the_ID(), '_product_image_gif', true );

			if ($old_product_image_gif) {
				$old_gif_path = ThreeDee_get_path_by_url('/ThreeDee/'.$old_product_image_gif);
				unlink($old_gif_path);
				update_post_meta( $post_id, '_product_image_gif', '' );
			}
		}

		if ($product_video_webm=='') { //removed
			$old_product_video_webm = $upload_dir['baseurl'].'/ThreeDee/'.get_post_meta( get_the_ID(), '_product_video_webm', true );

			if ($old_product_video_webm) {
				$old_webm_path = ThreeDee_get_path_by_url('/ThreeDee/'.$old_product_video_webm);
				unlink($old_webm_path);
				update_post_meta( $post_id, '_product_video_webm', '' );
			}
		}



		

		if (strlen($product_image_data)>0) {
			$uniqid=uniqid();
			ThreeDee_save_thumbnail(wc_clean($product_image_data), $uniqid.'.png' );
			update_post_meta( $post_id, '_product_image_png', $uniqid.'.png' );

			if ($_POST['use_png_as_thumnbail']=='on') {
				copy($upload_dir['basedir'].'/ThreeDee/'.$uniqid.'.png', $upload_dir['path'].'/'.$uniqid.'.png');
				$filename = $upload_dir['path']. '/'.$uniqid.'.png' ;
				$filetype = wp_check_filetype( basename( $filename ), null );

				$attachment = array(
					'guid'           => $upload_dir['url'] . '/'.basename( $filename ), 
					'post_mime_type' => $filetype['type'],
					'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
					'post_content'   => '',
					'post_status'    => 'inherit'
				);
				$attach_id = wp_insert_attachment( $attachment, $filename, $post_id );
				require_once( ABSPATH . 'wp-admin/includes/image.php' );
				$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
				wp_update_attachment_metadata( $attach_id, $attach_data );
	
				set_post_thumbnail( $post_id, $attach_id );
			}


		}

		if (strlen($product_gif_data)>0) {
			$uniqid=sanitize_file_name($product_gif_data);
			//ThreeDee_save_thumbnail(wc_clean($product_gif_data), $uniqid.'.gif' );
			update_post_meta( $post_id, '_product_image_gif', $uniqid.'.gif' );
		}

		if (strlen($product_webm_data)>0) {
			$uniqid=sanitize_file_name($product_webm_data);
			//ThreeDee_save_thumbnail(wc_clean($product_webm_data), $uniqid.'.webm' );
			update_post_meta( $post_id, '_product_video_webm', $uniqid.'.webm' );
		}

//var_dump($_POST);
#var_dump($product_gif_data);exit;
#var_dump(get_post_meta( (int)$post_id));
#var_dump(get_post_meta( (int)$post_id, '_display_mode', true ));
#exit;
}

function ThreeDee_process_zip($product_model, $targetDir) {

	if (class_exists('ZipArchive')) {
		$allowed_extensions_inside_archive=ThreeDee_get_allowed_extensions_inside_archive();

		$time=time();

		$filePath = $targetDir.ThreeDee_basename($product_model);
		if (!file_exists("$targetDir/tmp")) mkdir ("$targetDir/tmp");


		$zip = new ZipArchive;
		$res = $zip->open( $filePath );

		if ( $res === TRUE ) {

			for( $i = 0; $i < $zip->numFiles; $i++ ) {
				$file_to_extract =  sanitize_file_name(ThreeDee_basename( $zip->getNameIndex($i) ) );

				$f2e_path_parts = pathinfo($file_to_extract);

				$f2e_extension = mb_strtolower($f2e_path_parts['extension']);

				if (!in_array($f2e_extension, $allowed_extensions_inside_archive)) continue;
				$entry_stats = $zip->statIndex($i);


				if (strstr( $entry_stats['name'], "__MACOS")) continue;

				if ( in_array($f2e_extension, ThreeDee_get_accepted_models()) && !in_array($f2e_extension, ThreeDee_get_support_extensions_inside_archive())) {
					$file_found = true;

					$file_to_extract =  ThreeDee_basename( $file_to_extract );
					$wp_filename =  $time.'_'.$file_to_extract ;
					$extension = ThreeDee_extension($file_to_extract);
				}
				$zip->extractTo( "$targetDir/tmp", array( $zip->getNameIndex($i) ) );
				$files = ThreeDee_find_all_files("$targetDir/tmp");
				if (count($files)) {
					foreach ($files as $filename) {	

						rename($filename, $targetDir.$time."_".$file_to_extract);
							if (strtolower(ThreeDee_extension($filename))=='mtl') { 
								$material_file = $time."_".$file_to_extract;
								ThreeDee_process_mtl($targetDir.$time."_".$file_to_extract, $time);
						}
					}
				}

			}

			$zip->close();

			return array('model_file'=>$wp_filename, 'material_file'=>$material_file);


		}
		else {
					//die( '{"jsonrpc" : "2.0", "error" : {"code": 105, "message": "'.__( 'Could not extract the file.', 'ThreeDee' ).'"}, "id" : "id"}' );
		}
	}
}

function ThreeDee_get_path_by_url ($url) {
	$wp_upload_dir=wp_upload_dir();
	$offset = strrpos($url, 'uploads')+7;
	$path = substr($url, $offset);
	return $wp_upload_dir['basedir'].$path;
}

add_filter('upload_mimes', 'ThreeDee_enable_extended_upload');
function ThreeDee_enable_extended_upload ( $mime_types =array() ) {
	$mime_types['stl']  = 'application/octet-stream';
	$mime_types['wrl']  = 'model/vrml';
	$mime_types['glb']  = 'model/gltf-binary';
	$mime_types['gltf']  = 'model/gltf-json';
	$mime_types['obj']  = 'text/plain';
	$mime_types['zip']  = 'application/zip';

	return $mime_types;
}

add_filter( 'wp_check_filetype_and_ext', 'ThreeDee_secondary_mime', 99, 4 );    
function ThreeDee_secondary_mime( $check, $file, $filename, $mimes ) {
	if ( empty( $check['ext'] ) && empty( $check['type'] ) ) {

		$secondary_mime = [ 'stl' => 'text/plain', 'glb' => 'application/octet-stream', 'gltf' => 'text/plain' ];

		// Run another check, but only for our secondary mime and not on core mime types.
		remove_filter( 'wp_check_filetype_and_ext', 'ThreeDee_secondary_mime', 99, 4 );
		$check = wp_check_filetype_and_ext( $file, $filename, $secondary_mime );
		add_filter( 'wp_check_filetype_and_ext', 'ThreeDee_secondary_mime', 99, 4 );
	}
	return $check;
}
 

function ThreeDee_upload_file($name, $index) {
	$uploadedfile = array(
		'name'     => $_FILES[$name]['name'][$index],
		'type'     => $_FILES[$name]['type'][$index],
		'tmp_name' => $_FILES[$name]['tmp_name'][$index],
		'error'    => $_FILES[$name]['error'][$index],
		'size'     => $_FILES[$name]['size'][$index]
	);

	$upload_overrides = array( 'test_form' => false );
	$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
	if (isset( $movefile['error'])) echo $movefile['error'];
	return $movefile;
}

function ThreeDee_get_real_path($model_url) {
	$upload_dir = wp_upload_dir();
	$targetDir  = dirname($upload_dir['basedir']).'/'.dirname(substr($model_url, strpos($model_url, 'uploads/'))).'/';
	$targetDir  = str_replace('/uploads/sites/uploads/sites/', '/uploads/sites/', $targetDir);
	$targetFile = $targetDir.basename($model_url);
	return $targetFile;
}


add_shortcode( 'ThreeDeeiewer' , 'ThreeDee_shortcode' );
function ThreeDee_shortcode ($atts) {
	global $post;
#	include_once(dirname(__FILE__).'/ext/mobile_detect/Mobile_Detect.php');
#	$detect = new Mobile_Detect;
	//var_dump();
	$settings = get_option('ThreeDee_settings');	
	$upload_dir = wp_upload_dir();

	$model_url = $atts['model_url'];
	$material_url = $atts['material_url'];
	$upload_url = dirname($model_url).'/';
	$image_gif = $video_webm = $atts['rendered_file_url'];
	$mtl = ''; //todo $atts['mtl'];
//	$mtl = $atts['mtl'];
	$display_mode = $atts['display_mode'];
	$display_mode_mobile = $atts['display_mode_mobile'];

	$canvas_width = $atts['canvas_width'];
	$canvas_height = $atts['canvas_height'];

	$color = str_replace('#', '0x', $atts['model_color']);
	$transparency = $atts['model_transparency'];
	$shininess = $atts['model_shininess'];

	$rotation_x = $atts['rotation_x'];
	$rotation_y = $atts['rotation_y'];
	$rotation_z = $atts['rotation_z'];

	$offset_z = $atts['offset_z'];
	if (!$offset_z) $offset_z = '0';

	$show_light_source1 = ($atts['light_source1']=='on' ? $atts['light_source1'] : '');
	$show_light_source2 = ($atts['light_source2']=='on' ? $atts['light_source2'] : '');
	$show_light_source3 = ($atts['light_source3']=='on' ? $atts['light_source3'] : '');
	$show_light_source4 = ($atts['light_source4']=='on' ? $atts['light_source4'] : '');
	$show_light_source5 = ($atts['light_source5']=='on' ? $atts['light_source5'] : '');
	$show_light_source6 = ($atts['light_source6']=='on' ? $atts['light_source6'] : '');
	$show_light_source7 = ($atts['light_source7']=='on' ? $atts['light_source7'] : '');
	$show_light_source8 = ($atts['light_source8']=='on' ? $atts['light_source8'] : '');
	$show_light_source9 = ($atts['light_source9']=='on' ? $atts['light_source9'] : '');

	$camera_position_x = (isset($atts['camera_position_x']) ? $atts['camera_position_x'] : 0);
	$camera_position_y = (isset($atts['camera_position_y']) ? $atts['camera_position_y'] : 0);
	$camera_position_z = (isset($atts['camera_position_z']) ? $atts['camera_position_z'] : 0);

	$camera_lookat_x = (isset($atts['camera_lookat_x']) ? $atts['camera_lookat_x'] : 0);
	$camera_lookat_y = (isset($atts['camera_lookat_y']) ? $atts['camera_lookat_y'] : 0);
	$camera_lookat_z = (isset($atts['camera_lookat_z']) ? $atts['camera_lookat_z'] : 0);

	$controls_target_x = (isset($atts['controls_target_x']) ? $atts['controls_target_x'] : 0);
	$controls_target_y = (isset($atts['controls_target_y']) ? $atts['controls_target_y'] : 0);
	$controls_target_z = (isset($atts['controls_target_z']) ? $atts['controls_target_z'] : 0);


//	$show_fog = ($atts['show_fog']=='true' ? 'on' : '');
	$show_fog = $settings['show_fog'];
	$show_controls = $settings['show_controls'];

	$show_grid = ($atts['show_grid']=='true' ? 'on' : 'off');
	$show_ground = ($atts['show_ground']=='true' ? 'on' : 'off');
	$show_shadow = ($atts['show_shadow']=='true' ? 'on' : 'off');
	$background1 = str_replace('#', '0x', $atts['background_color']);
	$ground_mirror = ($atts['show_mirror']=='true' ? 'on' : 'off');;
//	$fog_color = str_replace('#', '0x', $atts['fog_color']);
	$fog_color = str_replace('#', '0x', $settings['fog_color']);
	$grid_color = str_replace('#', '0x', $atts['grid_color']);
	$ground_color = str_replace('#', '0x', $atts['ground_color']);
	$auto_rotation = ($atts['auto_rotation']=='true' ? 'on' : 'off');
	if (isset($atts['show_controls'])) $show_controls = ($atts['show_controls']=='true' ? 'on' : 'off');

#	if ($detect->isMobile()) $display_mode = $display_mode_mobile;
//str_replace( '#', '0x'
//style="max-width:500px;max-height:500px;"
	ob_start(); 
?>
	<div id="ThreeDee-viewer" style="max-width:<?php echo esc_attr($canvas_width);?>px;max-height:<?php echo esc_attr($canvas_height);?>px;">
		<div class="ThreeDee-canvas-wrapper">
			<canvas id="ThreeDee-cv" class="ThreeDee-canvas" width="<?php echo esc_attr($canvas_width);?>" height="<?php echo esc_attr($canvas_height);?>"></canvas>
			<div id="ThreeDee-file-loading">
				<img alt="Loading file" src="<?php echo esc_attr($settings['ajax_loader']); ?>">
			</div>
		</div>

	<?php if ($show_controls=='on' && ($display_mode=='3d_model' || $display_mode=='')) { ?>
	<div id="ThreeDee-model-controls">
		<ul id="ThreeDee-model-controls-list">
		<li><a href="javascript:void(0)" onclick="ThreeDeeToggleFullScreen();"><img alt="<?php _e('Fullscreen', 'ThreeDee');?>" title="<?php _e('Fullscreen', 'ThreeDee');?>" id="ThreeDee-controls-fullscreen" src="<?php echo plugins_url( 'threedee/images/fullscreen.png'); ?>"></a>
		<li><a href="javascript:void(0)" onclick="ThreeDeeToggleWireframe();"><img alt="<?php _e('Wireframe', 'ThreeDee');?>" title="<?php _e('Wireframe', 'ThreeDee');?>" id="ThreeDee-controls-wireframe" src="<?php echo plugins_url( 'threedee/images/wireframe.png'); ?>"></a>
		<li><a href="javascript:void(0)" onclick="ThreeDeeZoomIn();"><img alt="<?php _e('Zoom In', 'ThreeDee');?>" title="<?php _e('Zoom In', 'ThreeDee');?>" id="ThreeDee-controls-zoomin" src="<?php echo plugins_url( 'threedee/images/zoom_in.png'); ?>"></a>
		<li><a href="javascript:void(0)" onclick="ThreeDeeZoomOut();"><img alt="<?php _e('Zoom Out', 'ThreeDee');?>" title="<?php _e('Zoom Out', 'ThreeDee');?>" id="ThreeDee-controls-zoomout" src="<?php echo plugins_url( 'threedee/images/zoom_out.png'); ?>"></a>
		<li><a href="javascript:void(0)" onclick="ThreeDeeToggleRotation();"><img alt="<?php _e('Rotation', 'ThreeDee');?>" title="<?php _e('Rotation', 'ThreeDee');?>" id="ThreeDee-controls-rotation" src="<?php echo plugins_url( 'threedee/images/rotation.png'); ?>"></a>
		<li><a href="javascript:void(0)" onclick="ThreeDeeScreenshot();" id="ThreeDee-screenshot"><img alt="<?php _e('Screenshot', 'ThreeDee');?>" title="<?php _e('Screenshot', 'ThreeDee');?>" id="ThreeDee-controls-screenshot" src="<?php echo plugins_url( 'threedee/images/screenshot.png'); ?>"></a>
		<li><a href="#ThreeDee-popup1" class="ThreeDee-button"><img alt="<?php _e('Help', 'ThreeDee');?>" title="<?php _e('Help', 'ThreeDee');?>" id="ThreeDee-controls-help" src="<?php echo plugins_url( 'threedee/images/help.png'); ?>"></a>
		</ul>
	</div>
	<div id="ThreeDee-popup1" class="ThreeDee-overlay">
		<div class="ThreeDee-popup">
			<h2><?php _e('Controls', 'ThreeDee');?></h2>
			<a class="ThreeDee-close" href="#">&times;</a>
			<div class="ThreeDee-content">
				<ul id="ThreeDee-controls-help">
					<li><?php _e('Rotate with the left mouse button. ', 'ThreeDee');?>
					<li><?php _e('Zoom with the scroll button. ', 'ThreeDee');?>
					<li><?php _e('Adjust camera position with the right mouse button.', 'ThreeDee');?>
					<li><?php _e('Double-click to enter the fullscreen mode.', 'ThreeDee');?>
					<li><?php _e('On mobile devices swipe to rotate.', 'ThreeDee');?>
					<li><?php _e('On mobile devices pinch two fingers together or apart to adjust zoom.', 'ThreeDee');?>
				</ul>
			</div>
		</div>
	</div>
	<?php } ?>
	</div>

	<input type="hidden" id="ThreeDee_model_url" value="<?php if ($display_mode=='3d_model' || $display_mode=='') echo esc_attr($model_url);?>">
	<input type="hidden" id="ThreeDee_model_mtl" value="<?php echo esc_attr(basename($material_url));?>">
	<input type="hidden" id="ThreeDee_model_gif" value="<?php echo esc_attr($image_gif);?>">


	<input type="hidden" id="ThreeDee_upload_url" value="<?php echo esc_attr( $upload_url ); ?>" />
	<input type="hidden" id="ThreeDee_model_color" value="<?php echo esc_attr($color);?>">
	<input type="hidden" id="ThreeDee_model_shininess" value="<?php echo esc_attr($shininess);?>">
	<input type="hidden" id="ThreeDee_model_transparency" value="<?php echo esc_attr($transparency);?>">

	<input type="hidden" id="ThreeDee_model_rotation_x" value="<?php echo esc_attr($rotation_x);?>">
	<input type="hidden" id="ThreeDee_model_rotation_y" value="<?php echo esc_attr($rotation_y);?>">
	<input type="hidden" id="ThreeDee_model_rotation_z" value="<?php echo esc_attr($rotation_z);?>">

	<input type="hidden" id="ThreeDee_show_light_source1" value="<?php echo esc_attr($show_light_source1);?>">
	<input type="hidden" id="ThreeDee_show_light_source2" value="<?php echo esc_attr($show_light_source2);?>">
	<input type="hidden" id="ThreeDee_show_light_source3" value="<?php echo esc_attr($show_light_source3);?>">
	<input type="hidden" id="ThreeDee_show_light_source4" value="<?php echo esc_attr($show_light_source4);?>">
	<input type="hidden" id="ThreeDee_show_light_source5" value="<?php echo esc_attr($show_light_source5);?>">
	<input type="hidden" id="ThreeDee_show_light_source6" value="<?php echo esc_attr($show_light_source6);?>">
	<input type="hidden" id="ThreeDee_show_light_source7" value="<?php echo esc_attr($show_light_source7);?>">
	<input type="hidden" id="ThreeDee_show_light_source8" value="<?php echo esc_attr($show_light_source8);?>">
	<input type="hidden" id="ThreeDee_show_light_source9" value="<?php echo esc_attr($show_light_source9);?>">



	<input type="hidden" id="ThreeDee_camera_position_x" value="<?php echo esc_attr( $camera_position_x ); ?>" />
	<input type="hidden" id="ThreeDee_camera_position_y"  value="<?php echo esc_attr( $camera_position_y ); ?>" />
	<input type="hidden" id="ThreeDee_camera_position_z"  value="<?php echo esc_attr( $camera_position_z ); ?>" />
	<input type="hidden" id="ThreeDee_camera_lookat_x" value="<?php echo esc_attr( $camera_lookat_x ); ?>" />
	<input type="hidden" id="ThreeDee_camera_lookat_y"  value="<?php echo esc_attr( $camera_lookat_y ); ?>" />
	<input type="hidden" id="ThreeDee_camera_lookat_z"  value="<?php echo esc_attr( $camera_lookat_z ); ?>" />
	<input type="hidden" id="ThreeDee_controls_target_x" value="<?php echo esc_attr( $controls_target_x ); ?>" />
	<input type="hidden" id="ThreeDee_controls_target_y" value="<?php echo esc_attr( $controls_target_y ); ?>" />
	<input type="hidden" id="ThreeDee_controls_target_z" value="<?php echo esc_attr( $controls_target_z ); ?>" />
	<input type="hidden" id="ThreeDee_offset_z"  value="<?php echo esc_attr( $offset_z ); ?>" />


	<input type="hidden" id="ThreeDee_show_fog"  value="<?php echo esc_attr( $show_fog ); ?>" />
	<input type="hidden" id="ThreeDee_show_grid"  value="<?php echo esc_attr( $show_grid ); ?>" />
	<input type="hidden" id="ThreeDee_show_ground"  value="<?php echo esc_attr( $show_ground ); ?>" />
	<input type="hidden" id="ThreeDee_show_shadow"  value="<?php echo esc_attr( $show_shadow ); ?>" />
	<input type="hidden" id="ThreeDee_background1"  value="<?php echo esc_attr( $background1 ); ?>" />
	<input type="hidden" id="ThreeDee_ground_mirror"  value="<?php echo esc_attr( $ground_mirror ); ?>" />
	<input type="hidden" id="ThreeDee_fog_color"  value="<?php echo esc_attr( $fog_color ); ?>" />
	<input type="hidden" id="ThreeDee_grid_color"  value="<?php echo esc_attr( $grid_color ); ?>" />
	<input type="hidden" id="ThreeDee_ground_color"  value="<?php echo esc_attr( $ground_color ); ?>" />
	<input type="hidden" id="ThreeDee_auto_rotation"  value="<?php echo esc_attr( $auto_rotation ); ?>" />
<?php
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

add_filter( 'woocommerce_single_product_image_html', 'ThreeDee_woocommerce_single_product_image_html', 10, 2 );
function ThreeDee_woocommerce_single_product_image_html ($image_url, $post_id) {
	global $post, $woocommerce, $product;
	$settings = get_option('ThreeDee_settings');
#	include_once(dirname(__FILE__).'/ext/mobile_detect/Mobile_Detect.php');
#	$detect = new Mobile_Detect;

	$product_image_gif=$product_image_png=$product_image_png='';
	$master_models = $master_mtls =array();

	if (!ThreeDee_is_ThreeDee(get_the_ID())) return $image_url;
	$upload_dir = wp_upload_dir();
	$product_model = get_post_meta( get_the_ID(), '_product_model', true );
	$display_mode = get_post_meta( get_the_ID(), '_display_mode', true );
	$display_mode_mobile = get_post_meta( get_the_ID(), '_display_mode_mobile', true );
	if (!$display_mode_mobile) $display_mode_mobile = $display_mode;
	$product_mtl = get_post_meta( get_the_ID(), '_product_mtl', true );

	$product_color = get_post_meta( get_the_ID(), '_product_color', true );
	if (!$product_color) $product_color = $settings['model_default_color'];
	$product_transparency = get_post_meta( get_the_ID(), '_product_transparency', true );
	$product_shininess = get_post_meta( get_the_ID(), '_product_shininess', true );

	$rotation_x = get_post_meta( get_the_ID(), '_rotation_x', true );
	$rotation_y = get_post_meta( get_the_ID(), '_rotation_y', true );
	$rotation_z = get_post_meta( get_the_ID(), '_rotation_z', true );

	$product_offset_z = get_post_meta( get_the_ID(), '_product_offset_z', true );
	if (!$product_offset_z) $product_offset_z = '0';

	$product_show_light_source1 = get_post_meta( get_the_ID(), '_product_show_light_source1', true );
	$product_show_light_source2 = get_post_meta( get_the_ID(), '_product_show_light_source2', true );
	$product_show_light_source3 = get_post_meta( get_the_ID(), '_product_show_light_source3', true );
	$product_show_light_source4 = get_post_meta( get_the_ID(), '_product_show_light_source4', true );
	$product_show_light_source5 = get_post_meta( get_the_ID(), '_product_show_light_source5', true );
	$product_show_light_source6 = get_post_meta( get_the_ID(), '_product_show_light_source6', true );
	$product_show_light_source7 = get_post_meta( get_the_ID(), '_product_show_light_source7', true );
	$product_show_light_source8 = get_post_meta( get_the_ID(), '_product_show_light_source8', true );
	$product_show_light_source9 = get_post_meta( get_the_ID(), '_product_show_light_source9', true );

	if (!$product_show_light_source1) $product_show_light_source1 = $settings['show_light_source1'];
	if (!$product_show_light_source2) $product_show_light_source2 = $settings['show_light_source2'];
	if (!$product_show_light_source3) $product_show_light_source3 = $settings['show_light_source3'];
	if (!$product_show_light_source4) $product_show_light_source4 = $settings['show_light_source4'];
	if (!$product_show_light_source5) $product_show_light_source5 = $settings['show_light_source5'];
	if (!$product_show_light_source6) $product_show_light_source6 = $settings['show_light_source6'];
	if (!$product_show_light_source7) $product_show_light_source7 = $settings['show_light_source7'];
	if (!$product_show_light_source8) $product_show_light_source8 = $settings['show_light_source8'];
	if (!$product_show_light_source9) $product_show_light_source9 = $settings['show_light_source9'];


	$product_show_fog = get_post_meta( get_the_ID(), '_product_show_fog', true );
	$product_show_grid = get_post_meta( get_the_ID(), '_product_show_grid', true );
	$product_show_ground = get_post_meta( get_the_ID(), '_product_show_ground', true );
	$product_show_shadow = get_post_meta( get_the_ID(), '_product_show_shadow', true );
	$product_background1 = get_post_meta( get_the_ID(), '_product_background1', true );
	$product_ground_mirror = get_post_meta( get_the_ID(), '_product_ground_mirror', true );
	$product_fog_color = get_post_meta( get_the_ID(), '_product_fog_color', true );
	$product_grid_color = get_post_meta( get_the_ID(), '_product_grid_color', true );
	$product_ground_color = get_post_meta( get_the_ID(), '_product_ground_color', true );
	$product_auto_rotation = get_post_meta( get_the_ID(), '_product_auto_rotation', true );
	$product_view3d_button = get_post_meta( get_the_ID(), '_product_view3d_button', true );

	$product_show_controls = $settings['show_controls'];
	if (!$product_show_fog) $product_show_fog = $settings['show_fog'];
	if (!$product_show_grid) $product_show_grid = $settings['show_grid'];
	if (!$product_show_ground) $product_show_ground = $settings['show_ground'];
	if (!$product_show_shadow) $product_show_shadow = $settings['show_shadow'];
	if (!$product_background1) $product_background1 = $settings['background1'];
	if (!$product_fog_color) $product_fog_color = $settings['fog_color'];
	if (!$product_grid_color) $product_grid_color = $settings['grid_color'];
	if (!$product_ground_color) $product_ground_color = $settings['ground_color'];
	if (!$product_ground_mirror) $product_ground_mirror = $settings['ground_mirror'];
	if (!$product_auto_rotation) $product_auto_rotation = $settings['auto_rotation'];



	$product_remember_camera_position = get_post_meta( get_the_ID(), '_product_remember_camera_position', true );
	if ($product_remember_camera_position=='1') {
		$product_camera_position_x = get_post_meta( get_the_ID(), '_product_camera_position_x', true );
		$product_camera_position_y = get_post_meta( get_the_ID(), '_product_camera_position_y', true );
		$product_camera_position_z = get_post_meta( get_the_ID(), '_product_camera_position_z', true );
		$product_camera_lookat_x = get_post_meta( get_the_ID(), '_product_camera_lookat_x', true );
		$product_camera_lookat_y = get_post_meta( get_the_ID(), '_product_camera_lookat_y', true );
		$product_camera_lookat_z = get_post_meta( get_the_ID(), '_product_camera_lookat_z', true );
		$product_controls_target_x = get_post_meta( get_the_ID(), '_product_controls_target_x', true );
		$product_controls_target_y = get_post_meta( get_the_ID(), '_product_controls_target_y', true );
		$product_controls_target_z = get_post_meta( get_the_ID(), '_product_controls_target_z', true );
	}
	else {
		$product_camera_position_x = $product_camera_position_y = $product_camera_position_z = $product_camera_lookat_x = $product_camera_lookat_y = $product_camera_lookat_z = $product_controls_target_x = $product_controls_target_y = $product_controls_target_z = 0;
	}


	if (get_post_meta( get_the_ID(), '_product_image_png', true )) $product_image_png = $upload_dir['baseurl'].'/ThreeDee/'.get_post_meta( get_the_ID(), '_product_image_png', true );
	if (get_post_meta( get_the_ID(), '_product_image_gif', true )) $product_image_gif = $upload_dir['baseurl'].'/ThreeDee/'.get_post_meta( get_the_ID(), '_product_image_gif', true );
	if (get_post_meta( get_the_ID(), '_product_video_webm', true )) $product_video_webm = $upload_dir['baseurl'].'/ThreeDee/'.get_post_meta( get_the_ID(), '_product_video_webm', true );


	$targetFile = ThreeDee_get_real_path($product_model);

	if (is_file($targetFile)) {
		$targetFileMD5 = md5_file($targetFile);
		$master_models[$targetFileMD5] = $product_model;
	}

	$targetMTL = ThreeDee_get_real_path($product_mtl);

	if (is_file($targetMTL)) {
		$targetMTLMD5 = md5_file($targetMTL);
		$master_mtls[$targetMTLMD5] = $product_mtl;
	}

	$product = wc_get_product(get_the_ID());



	$targetFile = ThreeDee_get_real_path($product_model);
	if (is_file($targetFile)) {
		$targetFileMD5 = md5_file($targetFile);
		if (isset($master_models[$targetFileMD5])) {
			$product_model = $master_models[$targetFileMD5];
		}
	}

	$targetMTL = ThreeDee_get_real_path($product_mtl);

	if (is_file($targetMTL)) {
		$targetMTLMD5 = md5_file($targetMTL);
		if (isset($master_mtls[$targetMTLMD5])) {
			$product_mtl = $master_mtls[$targetMTLMD5];
		}
	}

	$upload_url = dirname($product_model).'/';


	$settings=get_option('ThreeDee_settings');

#	if ($detect->isMobile()) $display_mode = $display_mode_mobile;
	ob_start(); 
	if ($product_view3d_button=='on') {
		$post_thumbnail_id = $product->get_image_id();
		$image_url = wp_get_attachment_image_url( $post_thumbnail_id, 'full' );
		echo '<div class="ThreeDee-view3d-button-wrapper">';		
		echo '<a class="ThreeDee-view3d-button" href="javascript:void(0);" onclick="ThreeDeeInit3D()"><img src="'.esc_attr($settings['view3d_button_image']).'"></a>';
		echo '<a class="zoom ThreeDee-main-image" data-rel="prettyPhoto[product-gallery]" href="'.esc_attr($image_url).'"> <img src="'.esc_attr($image_url).'"></a>';
		echo '</div>';
	}
?>


	<div id="ThreeDee-viewer" style="<?php if ($product_view3d_button=='on') echo 'display:none;';?>">
		<div class="ThreeDee-canvas-wrapper">
			<canvas id="ThreeDee-cv" class="ThreeDee-canvas" width="<?php echo esc_attr($settings['canvas_width']);?>" height="<?php echo esc_attr($settings['canvas_height']);?>"></canvas>
			<div id="ThreeDee-file-loading">
				<img alt="Loading file" src="<?php echo esc_attr($settings['ajax_loader']); ?>">
			</div>
		</div>


	<?php if ($product_show_controls=='on' && ($display_mode=='3d_model' || $display_mode=='')) { ?>
	<div id="ThreeDee-model-controls">
		<ul id="ThreeDee-model-controls-list">
		<li><a href="javascript:void(0)" onclick="ThreeDeeToggleFullScreen();"><img alt="<?php _e('Fullscreen', 'ThreeDee');?>" title="<?php _e('Fullscreen', 'ThreeDee');?>" id="ThreeDee-controls-fullscreen" src="<?php echo plugins_url( 'threedee/images/fullscreen.png'); ?>"></a>
		<li><a href="javascript:void(0)" onclick="ThreeDeeToggleWireframe();"><img alt="<?php _e('Wireframe', 'ThreeDee');?>" title="<?php _e('Wireframe', 'ThreeDee');?>" id="ThreeDee-controls-wireframe" src="<?php echo plugins_url( 'threedee/images/wireframe.png'); ?>"></a>
		<li><a href="javascript:void(0)" onclick="ThreeDeeZoomIn();"><img alt="<?php _e('Zoom In', 'ThreeDee');?>" title="<?php _e('Zoom In', 'ThreeDee');?>" id="ThreeDee-controls-zoomin" src="<?php echo plugins_url( 'threedee/images/zoom_in.png'); ?>"></a>
		<li><a href="javascript:void(0)" onclick="ThreeDeeZoomOut();"><img alt="<?php _e('Zoom Out', 'ThreeDee');?>" title="<?php _e('Zoom Out', 'ThreeDee');?>" id="ThreeDee-controls-zoomout" src="<?php echo plugins_url( 'threedee/images/zoom_out.png'); ?>"></a>
		<li><a href="javascript:void(0)" onclick="ThreeDeeToggleRotation();"><img alt="<?php _e('Rotation', 'ThreeDee');?>" title="<?php _e('Rotation', 'ThreeDee');?>" id="ThreeDee-controls-rotation" src="<?php echo plugins_url( 'threedee/images/rotation.png'); ?>"></a>
		<li><a href="javascript:void(0)" onclick="ThreeDeeScreenshot();" id="ThreeDee-screenshot"><img alt="<?php _e('Screenshot', 'ThreeDee');?>" title="<?php _e('Screenshot', 'ThreeDee');?>" id="ThreeDee-controls-screenshot" src="<?php echo plugins_url( 'threedee/images/screenshot.png'); ?>"></a>
		<li><a href="#ThreeDee-popup1" class="ThreeDee-button"><img alt="<?php _e('Help', 'ThreeDee');?>" title="<?php _e('Help', 'ThreeDee');?>" id="ThreeDee-controls-help" src="<?php echo plugins_url( 'threedee/images/help.png'); ?>"></a>
		</ul>
	</div>
	<div id="ThreeDee-popup1" class="ThreeDee-overlay">
		<div class="ThreeDee-popup">
			<h2><?php _e('Controls', 'ThreeDee');?></h2>
			<a class="ThreeDee-close" href="#">&times;</a>
			<div class="ThreeDee-content">
				<ul id="ThreeDee-controls-help">
					<li><?php _e('Rotate with the left mouse button. ', 'ThreeDee');?>
					<li><?php _e('Zoom with the scroll button. ', 'ThreeDee');?>
					<li><?php _e('Adjust camera position with the right mouse button.', 'ThreeDee');?>
					<li><?php _e('Double-click to enter the fullscreen mode.', 'ThreeDee');?>
					<li><?php _e('On mobile devices swipe to rotate.', 'ThreeDee');?>
					<li><?php _e('On mobile devices pinch two fingers together or apart to adjust zoom.', 'ThreeDee');?>
				</ul>
			</div>
		</div>
	</div>
	<?php } ?>
	</div>

	<input type="hidden" id="ThreeDee_model_url" value="<?php if ($display_mode=='3d_model' || $display_mode=='') echo esc_attr($product_model);?>">
	<input type="hidden" id="ThreeDee_model_mtl" value="<?php echo esc_attr(basename($product_mtl));?>">
	<input type="hidden" id="ThreeDee_model_gif" value="<?php echo esc_attr($product_image_gif);?>">
	<input type="hidden" id="ThreeDee_model_png" value="<?php echo esc_attr($product_image_png);?>">

	<input type="hidden" id="ThreeDee_upload_url" value="<?php echo esc_attr( $upload_url ); ?>" />
	<input type="hidden" id="ThreeDee_model_color" value="<?php echo esc_attr($product_color);?>">
	<input type="hidden" id="ThreeDee_model_shininess" value="<?php echo esc_attr($product_shininess);?>">
	<input type="hidden" id="ThreeDee_model_transparency" value="<?php echo esc_attr($product_transparency);?>">

	<input type="hidden" id="ThreeDee_model_rotation_x" value="<?php echo esc_attr($rotation_x);?>">
	<input type="hidden" id="ThreeDee_model_rotation_y" value="<?php echo esc_attr($rotation_y);?>">
	<input type="hidden" id="ThreeDee_model_rotation_z" value="<?php echo esc_attr($rotation_z);?>">

	<input type="hidden" id="ThreeDee_show_light_source1" value="<?php echo esc_attr($product_show_light_source1);?>">
	<input type="hidden" id="ThreeDee_show_light_source2" value="<?php echo esc_attr($product_show_light_source2);?>">
	<input type="hidden" id="ThreeDee_show_light_source3" value="<?php echo esc_attr($product_show_light_source3);?>">
	<input type="hidden" id="ThreeDee_show_light_source4" value="<?php echo esc_attr($product_show_light_source4);?>">
	<input type="hidden" id="ThreeDee_show_light_source5" value="<?php echo esc_attr($product_show_light_source5);?>">
	<input type="hidden" id="ThreeDee_show_light_source6" value="<?php echo esc_attr($product_show_light_source6);?>">
	<input type="hidden" id="ThreeDee_show_light_source7" value="<?php echo esc_attr($product_show_light_source7);?>">
	<input type="hidden" id="ThreeDee_show_light_source8" value="<?php echo esc_attr($product_show_light_source8);?>">
	<input type="hidden" id="ThreeDee_show_light_source9" value="<?php echo esc_attr($product_show_light_source9);?>">



	<input type="hidden" id="ThreeDee_camera_position_x" value="<?php echo esc_attr( $product_camera_position_x ); ?>" />
	<input type="hidden" id="ThreeDee_camera_position_y"  value="<?php echo esc_attr( $product_camera_position_y ); ?>" />
	<input type="hidden" id="ThreeDee_camera_position_z"  value="<?php echo esc_attr( $product_camera_position_z ); ?>" />
	<input type="hidden" id="ThreeDee_camera_lookat_x" value="<?php echo esc_attr( $product_camera_lookat_x ); ?>" />
	<input type="hidden" id="ThreeDee_camera_lookat_y"  value="<?php echo esc_attr( $product_camera_lookat_y ); ?>" />
	<input type="hidden" id="ThreeDee_camera_lookat_z"  value="<?php echo esc_attr( $product_camera_lookat_z ); ?>" />
	<input type="hidden" id="ThreeDee_controls_target_x" value="<?php echo esc_attr( $product_controls_target_x ); ?>" />
	<input type="hidden" id="ThreeDee_controls_target_y" value="<?php echo esc_attr( $product_controls_target_y ); ?>" />
	<input type="hidden" id="ThreeDee_controls_target_z" value="<?php echo esc_attr( $product_controls_target_z ); ?>" />
	<input type="hidden" id="ThreeDee_offset_z"  value="<?php echo esc_attr( $product_offset_z ); ?>" />


	<input type="hidden" id="ThreeDee_show_fog"  value="<?php echo esc_attr( $product_show_fog ); ?>" />
	<input type="hidden" id="ThreeDee_show_grid"  value="<?php echo esc_attr( $product_show_grid ); ?>" />
	<input type="hidden" id="ThreeDee_show_ground"  value="<?php echo esc_attr( $product_show_ground ); ?>" />
	<input type="hidden" id="ThreeDee_show_shadow"  value="<?php echo esc_attr( $product_show_shadow ); ?>" />
	<input type="hidden" id="ThreeDee_background1"  value="<?php echo esc_attr( $product_background1 ); ?>" />
	<input type="hidden" id="ThreeDee_ground_mirror"  value="<?php echo esc_attr( $product_ground_mirror ); ?>" />
	<input type="hidden" id="ThreeDee_fog_color"  value="<?php echo esc_attr( $product_fog_color ); ?>" />
	<input type="hidden" id="ThreeDee_grid_color"  value="<?php echo esc_attr( $product_grid_color ); ?>" />
	<input type="hidden" id="ThreeDee_ground_color"  value="<?php echo esc_attr( $product_ground_color ); ?>" />
	<input type="hidden" id="ThreeDee_auto_rotation"  value="<?php echo esc_attr( $product_auto_rotation ); ?>" />
	<input type="hidden" id="ThreeDee_view3d_button" value="<?php echo esc_attr( $product_view3d_button ); ?>" />




<?php
#print_r($product->get_default_attributes());


	$image_url = ob_get_contents();
	ob_end_clean();

	return $image_url;	
}




add_filter( 'wc_get_template', 'ThreeDee_get_template', 10, 2 );
function ThreeDee_get_template( $located, $template_name ) {
	$ThreeDee_templates=array( 'single-product/product-image.php' );

	if ( ThreeDee_is_ThreeDee( get_queried_object_id() ) || ThreeDee_is_ThreeDee( get_the_ID() ) ) {
		if ( in_array( $template_name, $ThreeDee_templates ) ) {
			$ThreeDee_dir = ThreeDee_plugin_path();
			$located = $ThreeDee_dir."/woocommerce/$template_name";
		}
	}
	return $located;
}
add_filter( 'woocommerce_locate_template', 'ThreeDee_woocommerce_locate_template', 10, 3 );
function ThreeDee_woocommerce_locate_template( $template, $template_name, $template_path ) {
	$_template = $template;

	if ( ThreeDee_is_ThreeDee( get_queried_object_id() ) || ThreeDee_is_ThreeDee( get_the_ID() ) ) {

		if ( ! $template_path ) $template_path = $woocommerce->template_url;
		$plugin_path  = ThreeDee_plugin_path() . '/woocommerce/';

		$template = locate_template(
			array(
				$template_path . $template_name,
				$template_name
			)
		);

		if ( ! $template && file_exists( $plugin_path . $template_name ) )
			$template = $plugin_path . $template_name;
	}
	else {

	}

	if ( ! $template )
		$template = $_template;

	return $template;
}

function ThreeDee_plugin_path() {
	return untrailingslashit( dirname( plugin_dir_path( __FILE__ ) ) );
}



function ThreeDee_basename($file) {
	$array=explode('/',$file);
	$base=array_pop($array);
	return $base;
} 


function ThreeDee_find_all_files($dir) {
	$root = scandir($dir);
	foreach($root as $value) {
	if($value === '.' || $value === '..') {continue;}
		if(is_file("$dir/$value")) {$result[]="$dir/$value";continue;}
		foreach(ThreeDee_find_all_files("$dir/$value") as $value) {
			$result[]=$value;
		}
	}
	return $result;
} 

function ThreeDee_get_accepted_models () {
/*
	$settings = get_option('ThreeDee_settings');
	$file_extensions = explode(',', $settings['file_extensions']);
	$models = array();
	foreach ($file_extensions as $extension) {
		if ($extension=='zip') continue;
		$models[]=$extension;
		
	}
	return $models;
*/
	return array('stl', 'obj', 'wrl', 'glb', 'gltf');
}

function ThreeDee_get_support_extensions_inside_archive() {
	return array('mtl', 'png', 'jpg', 'jpeg', 'gif', 'tga', 'bmp');
}
function ThreeDee_get_allowed_extensions_inside_archive() {
	return array_merge(ThreeDee_get_accepted_models(), ThreeDee_get_support_extensions_inside_archive());
}


function ThreeDee_process_mtl($mtl_path, $timestamp) {
	if (file_exists($mtl_path)) {
		$new_content='';
		$handle = fopen($mtl_path, "r");  
		while (($line = fgets($handle)) !== false) {
			if (substr( trim(strtolower($line)), 0, 4 ) === "map_") {
				list ($map, $file) = explode(' ', $line, 2);
				$newline = "$map $timestamp"."_".sanitize_file_name(basename($file))."\n";
			} else {
				$newline = $line;
			}
			$new_content.=$newline;
		  }
		fclose($handle);
		file_put_contents($mtl_path, $new_content);
	}
}

function ThreeDee_get_mtl($file_path) {
	if (file_exists($file_path)) {
		$handle = fopen($file_path, "r");  
		while (($line = fgets($handle)) !== false) {
			if (substr( trim(strtolower($line)), 0, 6 ) === "mtllib") {
				list ($mtllib, $file) = explode(' ', $line, 2);
				list ($time, $name) = explode('_', ThreeDee_basename($file_path), 2);
				return $time."_".$file;
			}
		}
	}
	return '';
}
function ThreeDee_unprotected_warning() {
	$class = 'notice notice-error is-dismissible';


#	if (!ThreeDee_get_current_protection() && $_GET['page']=='ThreeDee') {
#		$message = __( 'Your <a href="'.ThreeDee_uploads_url().'">uploads folder</a> seems unprotected. Consider <a href="https://www.wpbeginner.com/wp-tutorials/disable-directory-browsing-wordpress/">disabling wordpress directory browsing</a>.', 'ThreeDee' );
#		printf( '<div class="%1$s"><b>ThreeDeeiewer</b>: %2$s</div>', $class, $message ); 
#	}
}
add_action( 'admin_notices', 'ThreeDee_unprotected_warning' );

/**
 * Author:            Alexis Blondin
*/
function ThreeDee_uploads_url() {
	$uploads_dir = wp_upload_dir();
	return $uploads_dir['baseurl'];
}

function ThreeDee_uploads_dir() {
	$uploads_dir = wp_upload_dir();
	return $uploads_dir['basedir'];
}



/**
 * Author:            Alexis Blondin
*/
function ThreeDee_get_current_protection() {
	// check if header is 200 (ok)
	$uploads_headers = @get_headers( ThreeDee_uploads_url() . '/' );
	if(!is_array($uploads_headers)) $uploads_headers[0] = '';
	if( preg_match('/200/i', $uploads_headers[0] )) {
		// because
		if( !file_exists( ThreeDee_uploads_dir() .'/index.php' ) ) {
			return false;
		}
		else {
			return true;
		}
	}
	// check if header is 403 (forbidden)
	if( preg_match('/403/i', $uploads_headers[0] )) {
		return true;
	}
}

function ThreeDee_handle_process() {
	error_reporting( 0 );
	set_time_limit( 5*60 );
	ini_set( 'memory_limit', '-1' );

	do_action('ThreeDee_handle_process_begin');

	$settings = ThreeDee_get_option( 'ThreeDee_settings' );

	$servers = ThreeDee_get_option( 'ThreeDee_servers' );
	shuffle($servers);
	$server = $servers[0];

	$repair = $reduce = 0;
	if ($_POST['ThreeDee_action']=='repair') $repair=1;
	if ($_POST['ThreeDee_action']=='reduce') $reduce=1;
	if ($repair) $process_url = $servers[0]."/repair_ThreeDee.php";
	elseif ($reduce) $process_url = $servers[0]."/reduce_ThreeDee.php";

	$polygon_cap = (float)$_POST['polygon_cap'];

	$cookie = WC()->session->get_session_cookie();
	$session_id = md5($_SERVER['REMOTE_ADDR'].$cookie[0]);
	$uploads = wp_upload_dir();
	$uploads['path'] = $uploads['basedir'].'/ThreeDee/';


	$product_attachment_id = get_post_meta( (int)$_POST['post_id'], '_product_attachment_id', true );
	if (!$product_attachment_id) {
		$attached_file = get_post_meta( (int)$_POST['post_id'], '_wp_attached_file', true ); //shortcode builder
		if ($attached_file) {
			$filepath = $uploads['basedir'].'/'.$attached_file;
			$file_to_upload = $filepath;
			$basename = md5_file($filepath).".".ThreeDee_extension($filepath) ;
		}

	}
	else {
		$filepath = get_attached_file($product_attachment_id);

		$basename = md5_file($filepath).".".ThreeDee_extension($filepath) ;
		$file_to_upload = $filepath;
	 	$extracted_path = base64_decode(get_post_meta( (int)$_POST['post_id'], '_product_model_extracted_path',true));
	
		if ($extracted_path) {	
			$file_to_upload = $extracted_path;
			$filepath = $extracted_path;
	
	#		$basename = ThreeDee_basename( $extracted_path );
			$basename = md5_file($extracted_path).".".ThreeDee_extension($extracted_path) ;
		}
	}
	$upload = true;

	if ( !file_exists ( $file_to_upload ) ) wp_die( '{"jsonrpc" : "2.0", "error" : {"code": 107, "message": "'.__( 'The file does not exist.', 'ThreeDee' ).'"}, "id" : "id"}' );

	if ( !function_exists('curl_version') ) wp_die( '{"jsonrpc" : "2.0", "error" : {"code": 108, "message": "'.__( 'The server does not support curl.', 'ThreeDee' ).'"}, "id" : "id"}' );

	//check if file already exists on a remote server
/*
	$post = array( 'file_name' => $basename, 'file_key' => md5_file ( $file_to_upload ), 'check_existence' => 1);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "$server/check2.php");
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	if (PHP_VERSION < 7.0) {
		curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
	}
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result=curl_exec ($ch);


	if($errno = curl_errno($ch)) {
		$error_message = curl_strerror($errno);		
	}
	curl_close ($ch);
	if ( $errno ) {
		wp_die( '{"jsonrpc" : "2.0", "error" : {"code": 109, "message": "'.__( 'Error: '.$error_message, 'ThreeDee' ).'"}, "id" : "id"}' );
	}

	$response = json_decode($result, true);
	if ($response['file_exists'] == '1') $upload = false;
*/

	if ($upload) {
		if (class_exists('ZipArchive') && filesize($file_to_upload) >= 1048576 ) {
			$zip_file = "$file_to_upload.tmp.zip";
			$zip = new ZipArchive();
			
			if ($zip->open($zip_file, ZipArchive::CREATE)!==TRUE) {
			    wp_die( '{"jsonrpc" : "2.0", "error" : {"code": 112, "message": "'.__( 'Could not create a zip archive.', 'ThreeDee' ).'"}, "id" : "id"}' );
			}
			$zip->addFile($file_to_upload, $basename);
			$zip->close();
			$file_to_upload = $zip_file;

		}
	}



	//wp_schedule_single_event

	$post = array( 'login' => $settings['api_login'],  'repair'=>$repair, 'reduce'=>$reduce, 'polygon_cap'=>$polygon_cap, 'session_id' => $session_id, 'file_name' => $basename, 'file_key' => md5_file ( $file_to_upload ), 'file_contents'=>curl_file_create($file_to_upload) );

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$process_url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	if (PHP_VERSION < 7.0) {
		curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
	}
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

	$result=curl_exec ($ch);

	curl_close ($ch);
	if (file_exists($zip_file)) unlink($zip_file);

	$response = json_decode($result, true);



	$output['jsonrpc'] = "2.0";
	$output['status'] = "2"; //in progress
	$output['server'] = $server;
	$output['file_to_upload'] = $file_to_upload;

	wp_die( json_encode( $output ) );
}

function ThreeDee_handle_process_check() {
	error_reporting( 0 );
	set_time_limit( 5*60 );
	ini_set( 'memory_limit', '-1' );

	do_action('ThreeDee_handle_process_check_begin');

	$settings = ThreeDee_get_option( 'ThreeDee_settings' );


	$servers = ThreeDee_get_option( 'ThreeDee_servers' );
	if (!empty($_POST['server']) && in_array($_POST['server'], $servers)) $server = $_POST['server'];
	else 
		wp_die( '{"jsonrpc" : "2.0", "error" : {"code": 114, "message": "'.__( 'Server not found.', 'ThreeDee' ).'"}, "id" : "id"}' );


	$repair=$reduce=0;
	if ($_POST['ThreeDee_action']=='repair') $repair=1;
	if ($_POST['ThreeDee_action']=='reduce') $reduce=1;

	if ($repair) $process_url = $server."/check_repair_ThreeDee.php";
	else if ($reduce) $process_url = $server."/check_reduce_ThreeDee.php";

	$cookie = WC()->session->get_session_cookie();
	$session_id = md5($_SERVER['REMOTE_ADDR'].$cookie[0]);
	$uploads = wp_upload_dir();
	$uploads['path'] = $uploads['basedir'].'/ThreeDee/';

	$product_attachment_id = get_post_meta( (int)$_POST['post_id'], '_product_attachment_id', true );
	if (!$product_attachment_id) {
		$attached_file = get_post_meta( (int)$_POST['post_id'], '_wp_attached_file', true ); //shortcode builder
		if ($attached_file) {
			$filepath = $uploads['basedir'].'/'.$attached_file;
			$file_to_upload = $filepath;
			$basename = md5_file($filepath).".".ThreeDee_extension($filepath) ;
		}

	}
	else {
		$filepath = get_attached_file($product_attachment_id);


	#	$basename = ThreeDee_basename( $filepath );
		$basename = md5_file($filepath).".".ThreeDee_extension($filepath) ;
		$file_to_upload = $filepath;

	 	$extracted_path = base64_decode(get_post_meta( (int)$_POST['post_id'], '_product_model_extracted_path',true));
		if ($extracted_path) {	
			$file_to_upload = $extracted_path;
			$filepath = $extracted_path;
	
	#		$basename = ThreeDee_basename( $extracted_path );
			$basename = md5_file($extracted_path).".".ThreeDee_extension($extracted_path) ;
		}
	}

	$upload = true;


	if ( !file_exists ( $file_to_upload ) ) wp_die( '{"jsonrpc" : "2.0", "error" : {"code": 107, "message": "'.__( 'The file does not exist.', 'ThreeDee' ).'"}, "id" : "id"}' );

	if ( !function_exists('curl_version') ) wp_die( '{"jsonrpc" : "2.0", "error" : {"code": 108, "message": "'.__( 'The server does not support curl.', 'ThreeDee' ).'"}, "id" : "id"}' );


	//wp_schedule_single_event

	$post = array( 'login' => $settings['api_login'],  'repair'=>$repair, 'reduce'=>$reduce, 'session_id' => $session_id, 'file_name' => $basename, 'file_key' => md5_file ( $file_to_upload ) );

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $process_url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	if (PHP_VERSION < 7.0) {
		curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
	}
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result=curl_exec ($ch);


	if($errno = curl_errno($ch)) {
		$error_message = curl_strerror($errno);		
	}
	curl_close ($ch);
	if (file_exists($zip_file)) unlink($zip_file);
	if ( $errno ) {
		wp_die( '{"jsonrpc" : "2.0", "error" : {"code": 109, "message": "'.__( 'Repair error: '.$error_message, 'ThreeDee' ).'"}, "id" : "id"}' );
	}

	$response = json_decode($result, true);
/*
	if ( $response['status']=='1' && !empty ( $response['url'] ) ) { //reduced
		//download reduced file
		$ch = curl_init($response['url']);
		$repaired_file = $response['filename']; 
//		$fp = fopen(dirname($filepath).'/'.$repaired_file, 'wb');  
		$fp = fopen($filepath, 'wb');   //let's overwrite it for now
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
		$output['jsonrpc'] = "2.0";
		$output['status'] = "1"; //completed
		$output['filename'] = ThreeDee_basename($filepath);

		wp_die( json_encode( $output ) );
	}
*/
	if ( $response['status']=='1' && !empty ( $response['url'] ) ) {
		//download processed file

		$ch = curl_init($response['url']);
		$repaired_file = $response['filename']; 
//		$fp = fopen(dirname($filepath).'/'.$repaired_file, 'wb');  
		$fp = fopen($filepath, 'wb');   //let's overwrite it for now
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
		$output['jsonrpc'] = "2.0";
		$output['status'] = "1"; //completed
		$output['filename'] = $repaired_file;
//		$output['filepath'] = $filepath;
		if ($repair) {
			$output['needed_repair']=$response['needed_repair'];
			$output['degenerate_facets']=$response['degenerate_facets'];
			$output['edges_fixed']=$response['edges_fixed'];
			$output['facets_removed']=$response['facets_removed'];
			$output['facets_added']=$response['facets_added'];
			$output['facets_reversed']=$response['facets_reversed'];
			$output['backwards_edges']=$response['backwards_edges'];
		}


		wp_die( json_encode( $output ) );
	}
	elseif ( $repair && $response['status']=='1' ) {

		$output['jsonrpc'] = "2.0";
		$output['status'] = "1"; //completed
		$output['needed_repair']=$response['needed_repair'];

		wp_die( json_encode( $output ) );

	}
	elseif ( $response['status']=='2' ) {
		$output['jsonrpc'] = "2.0";
		$output['status'] = "2"; //in progress
		$output['server'] = $server;

		wp_die( json_encode( $output ) );

	}
	elseif ( $response['status']=='0' ) {
		wp_die( '{"jsonrpc" : "2.0", "error" : {"code": 110, "message": "'.__( $response['message'], 'ThreeDee' ).'"}, "id" : "id"}' );
	}
	else {
		wp_die( '{"jsonrpc" : "2.0", "error" : {"code": 111, "message": "'.__( 'Unknown error.', 'ThreeDee' ).'"}, "id" : "id"}' );
	}

}

function ThreeDee_handle_zip() {
#	error_reporting( 0 );
	set_time_limit( 5*60 );
	ini_set( 'memory_limit', '-1' );

	do_action('ThreeDee_handle_zip');

	$settings = ThreeDee_get_option( 'ThreeDee_settings' );
	$post_id = (int)$_REQUEST['post_id'];

	$uploads = wp_upload_dir();

	$attached_file = get_post_meta( $post_id, '_wp_attached_file', true ); 
	$attached_file_dir = dirname($attached_file); 
	if ($attached_file) {
//$upload_dir['baseurl']
		$filepath = $uploads['basedir'].'/'.$attached_file;
		$targetDir = dirname($filepath).'/';
		$output = ThreeDee_process_zip($filepath, $targetDir);
		$output['model_url'] = $uploads['baseurl'].'/'.$attached_file_dir.'/'.$output['model_file'];
		$output['material_url'] = $uploads['baseurl'].'/'.$attached_file_dir.'/'.$output['material_file'];

		$output['jsonrpc'] = "2.0";
		if ($output['model_file']) {
			$output['status'] = "1"; 
		}
		else {
			$output['model_'];
			$output['status'] = "0"; 
		}
		wp_die( json_encode( $output ) );
		
	}
	else wp_die( '{"jsonrpc" : "2.0", "error" : {"code": 111, "message": "'.__( 'Unknown error.', 'ThreeDee' ).'"}, "id" : "id"}' );	

}
?>
