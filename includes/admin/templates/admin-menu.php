<?php

class threeDee_admin_menu
{

    public function __construct()
    {
        add_action('admin_menu', array($this, 'register_ThreeDee_menu_page'));
    }

    public function register_ThreeDee_menu_page()
    {
        add_menu_page('ThreeDee', 'ThreeDee', 'manage_options', 'ThreeDee', array($this, 'register_ThreeDee_menu_page_callback'));
    }

    public function register_ThreeDee_menu_page_callback()
    {
        global $wpdb;
        if ($_GET['page'] != 'ThreeDee') return false;
        if (!current_user_can('administrator')) return false;

        $settings = ThreeDee_get_option('ThreeDee_settings');

        if (isset($_POST['action']) && $_POST['action'] == 'save_login') {
            $settings['api_login'] = sanitize_text_field($_POST['api_login']);
            update_option('ThreeDee_settings', $settings);
        }

        if (isset($_POST['ThreeDee_settings']) && !empty($_POST['ThreeDee_settings']) && check_admin_referer('ThreeDee-save-settings_')) {
            $settings_update = array_map('sanitize_text_field', $_POST['ThreeDee_settings']);

            if (isset($_FILES['ThreeDee_settings']['tmp_name']['ajax_loader']) && strlen($_FILES['ThreeDee_settings']['tmp_name']['ajax_loader']) > 0) {
                $uploaded_file = ThreeDee_upload_file('ThreeDee_settings', 'ajax_loader');
                $settings_update['ajax_loader'] = str_replace('http:', '', $uploaded_file['url']);
            } else {
                $settings_update['ajax_loader'] = $settings['ajax_loader'];
            }
            if (isset($_FILES['ThreeDee_settings']['tmp_name']['view3d_button_image']) && strlen($_FILES['ThreeDee_settings']['tmp_name']['view3d_button_image']) > 0) {
                $uploaded_file = ThreeDee_upload_file('ThreeDee_settings', 'view3d_button_image');
                $settings_update['view3d_button_image'] = str_replace('http:', '', $uploaded_file['url']);
            } else {
                $settings_update['view3d_button_image'] = $settings['view3d_button_image'];
            }
            update_option('ThreeDee_settings', $settings_update);
        }

        $settings = ThreeDee_get_option('ThreeDee_settings');

        add_thickbox();
        include 'menu-tabs/admin-settings.php';
    }
}

$threeDee_admin_menu = new threeDee_admin_menu();
