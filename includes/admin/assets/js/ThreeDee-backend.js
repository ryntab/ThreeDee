/**
 * @author Sergey Burkov, http://www.wp3dprinting.com
 * @copyright 2017
 */

jQuery(document).ready(function() {
	if (jQuery( "#ThreeDee_tabs" ).length) {
		jQuery( "#ThreeDee_tabs" ).tabs();
	}
	jQuery( ".ThreeDee-color-picker" ).wpColorPicker({

		change : function(event, ui) {
			if (typeof(ThreeDee)!='undefined') {
				if (jQuery(event.target).hasClass('ThreeDee-background')) {
					ThreeDeeChangeBackgroundColor(ui.color.toString());
				}
				else if (jQuery(event.target).hasClass('ThreeDee-fog')) {
					ThreeDeeChangeFogColor(ui.color.toString());
				}
				else if (jQuery(event.target).hasClass('ThreeDee-grid')) {
					ThreeDeeChangeGridColor(ui.color.toString());
				}
				else if (jQuery(event.target).hasClass('ThreeDee-ground')) {
					ThreeDeeChangeGroundColor(ui.color.toString());
				}
				else {
					ThreeDeeChangeModelColor(ui.color.toString());
				}
			}
		},
		clear : function(event, ui) {
			if (typeof(ThreeDee)!='undefined') {
				if (jQuery(event.target).hasClass('ThreeDee-background')) {
					ThreeDeeChangeBackGroundColor('#ffffff');
				}
				else if (jQuery(event.target).hasClass('ThreeDee-fog')) {
					ThreeDeeChangeFogColor('#ffffff');
				}
				else if (jQuery(event.target).hasClass('ThreeDee-grid')) {
					ThreeDeeChangeGridColor('#ffffff');
				}
				else if (jQuery(event.target).hasClass('ThreeDee-ground')) {
					ThreeDeeChangeGroundColor('#ffffff');
				}
				else {
					ThreeDeeChangeModelColor('#ffffff');
				}
			}
		}

	});

jQuery(".ThreeDee-noenter").on('keyup', function (e) {
    if (e.keyCode == 13) {
	e.preventDefault();
        return false;
    }
});

});


/**
 * Callback function for the 'click' event of the 'Set Footer Image'
 * anchor in its meta box.
 *
 * Displays the media uploader for selecting an image.
 *
 * @since 0.1.0
 */
function renderMediaUploader() {
    'use strict';
 
    var file_frame, image_data;
 
    /**
     * If an instance of file_frame already exists, then we can open it
     * rather than creating a new instance.
     */
    if ( undefined !== file_frame ) {
 
        file_frame.open();
        return;
 
    }
 
    /**
     * If we're this far, then an instance does not exist, so we need to
     * create our own.
     *
     * Here, use the wp.media library to define the settings of the Media
     * Uploader. We're opting to use the 'post' frame which is a template
     * defined in WordPress core and are initializing the file frame
     * with the 'insert' state.
     *
     * We're also not allowing the user to select more than one image.
     */
    file_frame = wp.media.frames.file_frame = wp.media({
        frame:    'post',
        state:    'insert',
        multiple: false
    });
 
    /**
     * Setup an event handler for what to do when an image has been
     * selected.
     *
     * Since we're using the 'view' state when initializing
     * the file_frame, we need to make sure that the handler is attached
     * to the insert event.
     */
    file_frame.on( 'insert', function() {

	var json = file_frame.state().get( 'selection' ).first().toJSON();

//	if( /[^a-zA-Z0-9\-]/.test( json.title ) ) {
//		alert('File name must not be  (a-z,0-9,-)');
//		return false;
//	}
//	console.log(json);
	if (jQuery('#ThreeDee_shortcode').length>0) {
		ThreeDee.model_url = json.url;
		ThreeDee.model_mtl = '';
		ThreeDee.model_color = ThreeDee.model_default_color;
		ThreeDee.model_transparency = 'opaque';
		ThreeDee.model_shininess = 'plastic';
		ThreeDee.upload_url = jQuery('#ThreeDee_upload_url').val();
		ThreeDee.stored_position_x = 0;
		ThreeDee.stored_position_y = 0;
		ThreeDee.stored_position_z = 0;
		ThreeDee.stored_lookat_x = 0;
		ThreeDee.stored_lookat_y = 0;
		ThreeDee.stored_lookat_z = 0;
		ThreeDee.stored_controls_target_x = 0;
		ThreeDee.stored_controls_target_y = 0;
		ThreeDee.stored_controls_target_z = 0;
		ThreeDee.offset_z = 0;

		window.ThreeDee_canvas = document.getElementById('ThreeDee-cv');
		ThreeDeeDisplayUserDefinedProgressBar(true);
		ThreeDeeCanvasDetails();
		var logoTimerID = 0;
		ThreeDee.targetRotation = 0;
		var model_type=ThreeDee.model_url.split('.').pop().toLowerCase();
		jQuery('#ThreeDee-viewer').show();
		if (model_type=='zip') {
			jQuery.ajax({
				url:    ajaxurl,
				method: "POST",
				data:    {action : "ThreeDee_handle_zip", post_id : json.id},
				success: function(result) {
						var response = jQuery.parseJSON(result);
						if (response.status=='1') {
							ThreeDee.model_url = response.model_url;
							ThreeDee.model_mtl = response.material_url;
							model_type = response.model_file.split('.').pop();
						}
						else {
							ThreeDee.model_url=false;
							alert(ThreeDee.text_model_not_found);
							return;
						}
					},
				async:   false
			});
		}
		if (ThreeDee.model_url) {
			ThreeDeeViewerInit(ThreeDee.model_url, ThreeDee.model_mtl, model_type, false);
			ThreeDeeAnimate();
			jQuery( 'button.media-modal-close' ).click();
		}
	}
	jQuery( '#product_model' ).val( json.url );
	jQuery( '#product_attachment_id' ).val( json.id );
	jQuery( 'button.media-modal-close' ).click();
	jQuery( '#ThreeDee_save_block' ).show();
	ThreeDee_remove_params();


/*
	$( '#footer-thumbnail-src' ).val( json.url );
	$( '#footer-thumbnail-title' ).val( json.title );
	$( '#footer-thumbnail-alt' ).val( json.title );
*/

    });
 
    // Now display the actual file_frame
    file_frame.open();
 
}
 
(function( $ ) {
    'use strict';
 
    $(function() {
        $( '#set-model' ).on( 'click', function( evt ) {
 
            // Stop the anchor's default behavior
            evt.preventDefault();
            if (jQuery('#ThreeDee_reload_url').length && typeof(ThreeDee)=='object' && ThreeDee.object) {
             if (document.location.href==jQuery('#ThreeDee_reload_url').val()) {
              location.reload();
             }
             else {
              document.location.href=jQuery('#ThreeDee_reload_url').val();
             }
            }
            else {
             // Display the media uploader
             renderMediaUploader();
           }
 
        });
 
    });
 
})( jQuery );

function ThreeDee_remove_params() {
		jQuery('#ThreeDee_display_mode').val('3d_model');
		jQuery('#ThreeDee_display_mode_model').val('3d_model');
		jQuery('#ThreeDee_product_model_extracted_path').val('');
		jQuery('#ThreeDee_rotation_x').val('');
		jQuery('#ThreeDee_rotation_y').val('');
		jQuery('#ThreeDee_rotation_z').val('');
		jQuery('#product_offset_z').val('');
		ThreeDee_remove_camera_params();

}

function ThreeDee_remove_camera_params() {
		jQuery('input[name=product_remember_camera_position]').val('0');
		jQuery('#product_camera_position_x').val('');
		jQuery('#product_camera_position_y').val('');
		jQuery('#product_camera_position_z').val('');
		jQuery('#product_camera_lookat_x').val('');
		jQuery('#product_camera_lookat_y').val('');
		jQuery('#product_camera_lookat_z').val('');
		jQuery('#product_controls_target_x').val('');
		jQuery('#product_controls_target_y').val('');
		jQuery('#product_controls_target_z').val('');
}

function ThreeDee_remove_model() {
	jQuery('#product_model').val('')
	jQuery('#product_model_name').html('')
	jQuery('#ThreeDee-cv').hide()
}



function ThreeDeeChangeDisplayMode(mode, mobile) {
	if (mode!='png_image') {
		jQuery('#png_block').hide();
		jQuery('#product_image_data').val('');
	}
	else {
		jQuery('#png_block').show();
		jQuery('#ThreeDee-canvas-instructions').show();
	}

	if (mode!='gif_image') {
		jQuery('#gif_block').hide();
		jQuery('#product_gif_data').val('');
	}
	else {
		jQuery('#ThreeDee-canvas-instructions').show();
		jQuery('#gif_block').show();
	}

	if (mode!='webm_video') {
		jQuery('#webm_block').hide();
		jQuery('#product_webm_data').val('');
	}
	else {
		jQuery('#webm_block').show();
		jQuery('#ThreeDee-canvas-instructions').show();
	}
	if (mode=='3d_model') {
		jQuery('#ThreeDee-canvas-instructions').hide();
	}
	if (mobile)
		jQuery('#ThreeDee_display_mode_mobile').val(mode);
	else 
		jQuery('#ThreeDee_display_mode').val(mode);
}

function ThreeDeeCheckPostSize() {
	var post_max_size = parseInt(ThreeDee.post_max_size) * 1048576; //bytes
	var post_size = jQuery('#product_image_data').val().length + jQuery('#product_gif_data').val().length + jQuery('#product_webm_data').val().length;
	if (post_size > post_max_size) {
		alert(ThreeDee.text_post_max_size);
		return false;
	}
	return true;


}

/**
 * Callback function for the 'click' event of the 'Set Footer Image'
 * anchor in its meta box.
 *
 * Displays the media uploader for selecting an image.
 *
 * @since 0.1.0
 */
function ThreeDeeRenderMediaUploader(variation_id) {
    'use strict';
 
    var file_frame, image_data;
 
    /**
     * If an instance of file_frame already exists, then we can open it
     * rather than creating a new instance.
     */
    if ( undefined !== file_frame ) {
 
        file_frame.open();
        return;
 
    }
 
    /**
     * If we're this far, then an instance does not exist, so we need to
     * create our own.
     *
     * Here, use the wp.media library to define the settings of the Media
     * Uploader. We're opting to use the 'post' frame which is a template
     * defined in WordPress core and are initializing the file frame
     * with the 'insert' state.
     *
     * We're also not allowing the user to select more than one image.
     */
    file_frame = wp.media.frames.file_frame = wp.media({
        frame:    'post',
        state:    'insert',
        multiple: false
    });
 
    /**
     * Setup an event handler for what to do when an image has been
     * selected.
     *
     * Since we're using the 'view' state when initializing
     * the file_frame, we need to make sure that the handler is attached
     * to the insert event.
     */
    file_frame.on( 'insert', function() {

	var json = file_frame.state().get( 'selection' ).first().toJSON();

//	if( /[^a-zA-Z0-9\-]/.test( json.title ) ) {
//		alert('File name must not be  (a-z,0-9,-)');
//		return false;
//	}
	console.log(json.url);
	jQuery( '#ThreeDee_variation_file_url_'+variation_id ).val( json.url );
	jQuery( '#ThreeDee_variation_attachment_id_'+variation_id ).val( json.id );
	jQuery( 'button.media-modal-close' ).click();


/*
	$( '#footer-thumbnail-src' ).val( json.url );
	$( '#footer-thumbnail-title' ).val( json.title );
	$( '#footer-thumbnail-alt' ).val( json.title );
*/

    });
 
    // Now display the actual file_frame
    file_frame.open();
 
}

function ThreeDeeSetModel(evt, variation_id) {
            // Stop the anchor's default behavior
            evt.preventDefault();
 
            // Display the media uploader
            ThreeDeeRenderMediaUploader(variation_id);
}




function ThreeDeeGenerateShortcode() {
	if (typeof(ThreeDee.object)=='undefined') {
		alert(ThreeDee.text_upload_model);
		return false;
	}
	var model_url = ThreeDee.model_url.replace('http:','').replace('https:',''); //avoid mixed content issues
	var mtl_url = ThreeDee.model_mtl.replace('http:','').replace('https:',''); //avoid mixed content issues
	var display_mode = jQuery('#ThreeDee-display-mode').val();
	var display_mode_mobile = jQuery('#ThreeDee-display-mode-mobile').val();
	var model_color = jQuery('#ThreeDee-model-color').val();
	var background_color = jQuery('#ThreeDee-background-color').val();
	var model_shininess = jQuery('#ThreeDee-model-shininess').val();
	var grid_color = jQuery('#ThreeDee-grid-color').val();
	var show_grid = jQuery('#ThreeDee-show-grid').prop('checked');
	var model_transparency = jQuery('#ThreeDee-model-transparency').val();
	var ground_color = jQuery('#ThreeDee-ground-color').val();
	var show_ground = jQuery('#ThreeDee-show-ground').prop('checked');
	var light_source1 = jQuery('#ThreeDee-show-light-source1').prop('checked');
	var light_source2 = jQuery('#ThreeDee-show-light-source2').prop('checked');
	var light_source3 = jQuery('#ThreeDee-show-light-source3').prop('checked');
	var light_source4 = jQuery('#ThreeDee-show-light-source4').prop('checked');
	var light_source5 = jQuery('#ThreeDee-show-light-source5').prop('checked');
	var light_source6 = jQuery('#ThreeDee-show-light-source6').prop('checked');
	var light_source7 = jQuery('#ThreeDee-show-light-source7').prop('checked');
	var light_source8 = jQuery('#ThreeDee-show-light-source8').prop('checked');
	var light_source9 = jQuery('#ThreeDee-show-light-source9').prop('checked');
	var show_shadow = jQuery('#ThreeDee-show-shadow').prop('checked');
	var show_mirror = jQuery('#ThreeDee-show-mirror').prop('checked');
	var auto_rotation = jQuery('#ThreeDee-auto-rotation').prop('checked');
	var remember_camera_position = jQuery('#ThreeDee-remember-camera-position').prop('checked');
	var show_controls = jQuery('#ThreeDee-show-controls').prop('checked');
	var rotation_x = jQuery('#rotation_x').val();
	var rotation_y = jQuery('#rotation_y').val();
	var rotation_z = jQuery('#rotation_z').val();
	var z_offset = jQuery('#z_offset').val();
	var canvas_width = jQuery('#ThreeDee-canvas-width').val();
	var canvas_height = jQuery('#ThreeDee-canvas-height').val();
	if (display_mode == 'webm_video' || display_mode_mobile == 'webm_video') {
		var rendered_file_url = ThreeDee.upload_dir.replace('http:','').replace('https:','') + ThreeDee.uniqid + '.webm'
	}
	else if (display_mode == 'gif_image' || display_mode_mobile == 'webm_video') {
		var rendered_file_url = ThreeDee.upload_dir.replace('http:','').replace('https:','') + ThreeDee.uniqid + '.gif'
	}
	else {
		var rendered_file_url = '';
	}
	var shortcode = '[ThreeDeeiewer';

//	if (model_url.length>0) {
	shortcode += ' model_url="'+model_url+'"';
	shortcode += ' material_url="'+mtl_url+'"';
	shortcode += ' canvas_width="'+canvas_width+'"';
	shortcode += ' canvas_height="'+canvas_height+'"';
	shortcode += ' display_mode="'+display_mode+'"';
	shortcode += ' display_mode_mobile="'+display_mode_mobile+'"';
	shortcode += ' rendered_file_url="'+rendered_file_url+'"';
	shortcode += ' model_color="'+model_color+'"';
	shortcode += ' background_color="'+background_color+'"';
	shortcode += ' model_transparency="'+model_transparency+'"';
	shortcode += ' model_shininess="'+model_shininess+'"';
	shortcode += ' show_grid="'+show_grid.toString()+'"';
	shortcode += ' grid_color="'+grid_color+'"';
	shortcode += ' show_ground="'+show_ground.toString()+'"';
	shortcode += ' ground_color="'+ground_color+'"';
	shortcode += ' show_shadow="'+show_shadow.toString()+'"';
	shortcode += ' show_mirror="'+show_mirror.toString()+'"';
	shortcode += ' auto_rotation="'+auto_rotation.toString()+'"';
	shortcode += ' rotation_x="'+rotation_x+'"';
	shortcode += ' rotation_y="'+rotation_y+'"';
	shortcode += ' rotation_z="'+rotation_z+'"';
	shortcode += ' offset_z="'+z_offset+'"';
	shortcode += ' light_source1="'+light_source1.toString()+'"';
	shortcode += ' light_source2="'+light_source2.toString()+'"';
	shortcode += ' light_source3="'+light_source3.toString()+'"';
	shortcode += ' light_source4="'+light_source4.toString()+'"';
	shortcode += ' light_source5="'+light_source5.toString()+'"';
	shortcode += ' light_source6="'+light_source6.toString()+'"';
	shortcode += ' light_source7="'+light_source7.toString()+'"';
	shortcode += ' light_source8="'+light_source8.toString()+'"';
	shortcode += ' light_source9="'+light_source9.toString()+'"';
	shortcode += ' remember_camera_position="'+remember_camera_position.toString()+'"';
	shortcode += ' show_controls="'+show_controls.toString()+'"';
	if (remember_camera_position) {
		var vec = ThreeDee.camera.getWorldDirection( ThreeDee.vec );

		shortcode += ' camera_position_x="'+ThreeDee.camera.position.x+'"';
		shortcode += ' camera_position_y="'+ThreeDee.camera.position.y+'"';
		shortcode += ' camera_position_z="'+ThreeDee.camera.position.z+'"';

		shortcode += ' camera_lookat_x="'+vec.x+'"';
		shortcode += ' camera_lookat_y="'+vec.y+'"';
		shortcode += ' camera_lookat_z="'+vec.z+'"';

		shortcode += ' controls_target_x="'+ThreeDee.controls.target.x+'"';
		shortcode += ' controls_target_y="'+ThreeDee.controls.target.y+'"';
		shortcode += ' controls_target_z="'+ThreeDee.controls.target.z+'"';
	}

	shortcode += ']';

	jQuery('#ThreeDee_shortcode').val(shortcode);
//	}
//	else {
//		alert(ThreeDee.text_upload_model);
//	}
}
