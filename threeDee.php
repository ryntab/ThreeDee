<?php
/*
Plugin Name: ThreeDee
Description: 3D models for Woocommerce
Author: Ryan Taber
Text Domain: ThreeDee
Version: 1.3.9.2
WC requires at least: 2.6.14
WC tested up to: 4.8
*/

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class threeDee
{

	public function __construct()
	{

		define('ThreeDee_VERSION', '1.3.9.2');

		global $wpdb;
		if (!function_exists('get_home_path')) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
		}

		include 'includes/ThreeDee-functions.php';

		if (is_admin()) {
			add_action('admin_enqueue_scripts', 'ThreeDee_enqueue_scripts_backend');
			add_action('wp_ajax_ThreeDee_handle_upload', 'ThreeDee_handle_upload');
			add_action('wp_ajax_ThreeDee_handle_zip', 'ThreeDee_handle_zip');
			#	add_action( 'wp_ajax_nopriv_ThreeDee_handle_upload', 'ThreeDee_handle_upload' );
			include 'includes/admin/admin-menu.php';
		} else {
			add_action('wp_enqueue_scripts', 'ThreeDee_enqueue_scripts_frontend');
		}


		register_activation_hook(__FILE__, 'ThreeDee_activate');
		register_deactivation_hook(__FILE__, 'ThreeDee_deactivate');

		add_action('init', 'ThreeDee_check_installation');
		function ThreeDee_check_installation()
		{

			if (!function_exists('get_plugin_data')) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}
			$ThreeDee_plugin_data = get_plugin_data(__FILE__);
			$ThreeDee_current_version = get_option('ThreeDee_version');

			if (!empty($ThreeDee_current_version) && version_compare($ThreeDee_current_version, $ThreeDee_plugin_data['Version'], '<')) {
				ThreeDee_check_install();
			}
		}
	}
}

$threeDee = new threeDee();
