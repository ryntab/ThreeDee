<?php

function ThreeDee_enqueue_scripts_backend()
{
    global $wp_scripts;
    $ThreeDee_current_version = get_option('ThreeDee_version');
    $settings = get_option('ThreeDee_settings');
    $upload_dir = wp_upload_dir();
    //var_dump($upload_dir);exit;
    wp_enqueue_script('js/ThreeDee-backend.js', plugin_dir_url(__FILE__) . 'js/ThreeDee-backend.js', array('jquery'), $ThreeDee_current_version);

    if (isset($_GET['page']) && $_GET['page'] == 'ThreeDee' || (isset($_GET['post']) && is_numeric($_GET['post']) && $_GET['action'] == 'edit' && ThreeDee_is_ThreeDee($_GET['post']))) {
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_script('jquery-ui-dialog');
        wp_enqueue_script('tooltipster.js',  plugin_dir_url(__FILE__) . 'ext/tooltipster/js/jquery.tooltipster.js', array('jquery'), $ThreeDee_current_version);
        wp_enqueue_style('tooltipster.css', plugin_dir_url(__FILE__) . 'ext/tooltipster/css/tooltipster.css', array(), $ThreeDee_current_version);

        wp_enqueue_script('ThreeDee-threejs',  plugin_dir_url(__FILE__) . 'ext/threejs/three.min.js', array('jquery'), $ThreeDee_current_version);
        wp_enqueue_script('ThreeDee-threejs-detector',  plugin_dir_url(__FILE__) . 'ext/threejs/js/Detector.js', array('jquery'), $ThreeDee_current_version);
        wp_enqueue_script('ThreeDee-threejs-mirror',  plugin_dir_url(__FILE__) . 'ext/threejs/js/Mirror.js', array('jquery'), $ThreeDee_current_version);
        wp_enqueue_script('ThreeDee-threejs-controls',  plugin_dir_url(__FILE__) . 'ext/threejs/js/controls/OrbitControls.js', array('jquery'), $ThreeDee_current_version);
        wp_enqueue_script('ThreeDee-threejs-canvas-renderer',  plugin_dir_url(__FILE__) . 'ext/threejs/js/renderers/CanvasRenderer.js', array('jquery'), $ThreeDee_current_version);
        wp_enqueue_script('ThreeDee-threejs-projector-renderer',  plugin_dir_url(__FILE__) . 'ext/threejs/js/renderers/Projector.js', array('jquery'), $ThreeDee_current_version);
        wp_enqueue_script('ThreeDee-threejs-stl-loader',  plugin_dir_url(__FILE__) . 'ext/threejs/js/loaders/STLLoader.js', array('jquery'), $ThreeDee_current_version);
        wp_enqueue_script('ThreeDee-threejs-obj-loader',  plugin_dir_url(__FILE__) . 'ext/threejs/js/loaders/OBJLoader.js', array('jquery'), $ThreeDee_current_version);
        wp_enqueue_script('ThreeDee-threejs-vrml-loader',  plugin_dir_url(__FILE__) . 'ext/threejs/js/loaders/VRMLLoader.js', array('jquery'), $ThreeDee_current_version);
        wp_enqueue_script('ThreeDee-threejs-draco-loader',  plugin_dir_url(__FILE__) . 'ext/threejs/js/loaders/DRACOLoader.js', array('jquery'), $ThreeDee_current_version);
        wp_enqueue_script('ThreeDee-threejs-gltf-loader',  plugin_dir_url(__FILE__) . 'ext/threejs/js/loaders/GLTFLoader.js', array('jquery'), $ThreeDee_current_version);
        wp_enqueue_script('ThreeDee-threejs-mtl-loader',  plugin_dir_url(__FILE__) . 'ext/threejs/js/loaders/MTLLoader.js', array('jquery'), $ThreeDee_current_version);
        wp_enqueue_script('ThreeDee-backend-model.js',  plugin_dir_url(__FILE__) . 'js/ThreeDee-backend-model.js', array('jquery'), $ThreeDee_current_version);

        wp_enqueue_style('jquery-ui.min.css', plugin_dir_url(__FILE__) . 'ext/jquery-ui/jquery-ui.min.css', array(), $ThreeDee_current_version);
        wp_enqueue_style('ThreeDee-backend.css', plugin_dir_url(__FILE__) . 'css/ThreeDee-backend.css', array(), $ThreeDee_current_version);

        wp_localize_script(
            'ThreeDee-backend-model.js',
            'ThreeDee',
            array(
                'url' => admin_url('admin-ajax.php'),
                'plugin_url' => plugin_dir_url(dirname(__FILE__)),
                'upload_dir' => $upload_dir['baseurl'] . '/ThreeDee/',
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
                'show_light_source8' => $settings['show_light_source8'],
                'show_light_source9' => $settings['show_light_source9'],
                'show_ground' => $settings['show_ground'],
                'show_fog' => $settings['show_fog'],
                'ground_mirror' => $settings['ground_mirror'],
                'model_default_color' => str_replace('#', '0x', $settings['model_default_color']),
                'background1' => str_replace('#', '0x', $settings['background1']),
                'grid_color' => str_replace('#', '0x', $settings['grid_color']),
                'fog_color' => str_replace('#', '0x', $settings['fog_color']),
                'ground_color' => str_replace('#', '0x', $settings['ground_color']),
                'auto_rotation' => $settings['auto_rotation'],
                'show_grid' => $settings['show_grid'],
                'file_chunk_size' => $settings['file_chunk_size'],
                'post_max_size' => ini_get('post_max_size'),
                'text_not_available' => __('Not available in your browser', 'ThreeDee'),
                'text_model_not_found' => __('Model not found!', 'ThreeDee'),
                'text_enable_preview' => __('Please enable Preview Model in the settings of the plugin', 'ThreeDee'),
                'text_upload_model' => __('Please upload the model first', 'ThreeDee'),
                'text_webm_chrome' => __('WEBM rendering works only in Chrome browser', 'ThreeDee'),
                'text_switch_tabs' => __("Please don't switch to other tabs while rendering", 'ThreeDee'),
                'text_post_max_size' => __('The amount of data we are going to submit is larger than post_max_size in php.ini (' . ini_get('post_max_size') . '). Either increase post_max_size value or decrease resolution or quality of gif/video', 'ThreeDee'),
                'text_repairing_model' => __("Repairing..", 'ThreeDee'),
                'text_model_repaired' => __("Repairing.. done!", 'ThreeDee'),
                'text_model_repair_report' => __('Error report:', 'ThreeDee'),
                'text_model_repair_failed' => __("Repairing.. fail!", 'ThreeDee'),
                'text_model_no_repair_needed' => __('No errors found.', 'ThreeDee'),
                'text_model_repair_degenerate_facets' => __('Degenerate facets', 'ThreeDee'),
                'text_model_repair_edges_fixed' => __('Edges fixed', 'ThreeDee'),
                'text_model_repair_facets_removed' => __('Facets removed', 'ThreeDee'),
                'text_model_repair_facets_added' => __('Facets added', 'ThreeDee'),
                'text_model_repair_facets_reversed' => __('Facets reversed', 'ThreeDee'),
                'text_model_repair_backwards_edges' => __('Backwards edges', 'ThreeDee'),
                'text_repairing_mtl' => __('Can not repair textured models yet!', 'ThreeDee'),
                'text_repairing_only' => __('Can repair only STL and OBJ models', 'ThreeDee'),
                'text_repairing_alert' => __("The model will be sent to our server for repair.\nRepairing some models with very faulty geometries may result in broken models.\nClick OK if you agree.", 'ThreeDee'),
                'text_reducing_model' => __("Reducing..", 'ThreeDee'),
                'text_model_reduced' => __("Reducing.. done!", 'ThreeDee'),
                'text_model_no_reduction_needed' => __("No reduction needed", 'ThreeDee'),
                'text_enter_polygon_cap' => __("% of triangles to reduce", 'ThreeDee'),
                'text_reducing_mtl' => __('Can not reduce textured models yet!', 'ThreeDee'),
                'text_reducing_only' => __('Can reduce only STL and OBJ models', 'ThreeDee'),
                'text_reducing_alert' => __("The model will be sent to our server for polygon reduction.\n Click OK if you agree.", 'ThreeDee'),
                'upload_file_nonce' => wp_create_nonce('ThreeDee-file-upload')
            )
        );
    }
}
add_action('admin_enqueue_scripts', 'ThreeDee_enqueue_scripts_backend');
