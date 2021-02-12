/**
 * @author Sergey Burkov, http://www.wp3dprinting.com
 * @copyright 2017
 */

ThreeDee.aabb = new Array();
ThreeDee.resize_scale = 1.2;
ThreeDee.image_render_required = 0;
ThreeDee.default_scale = 100;
ThreeDee.cookie_expire = parseInt(ThreeDee.cookie_expire);
ThreeDee.boundingBox=[];
ThreeDee.max_frames = 600;
ThreeDee.initial_rotation_x = 0;
ThreeDee.initial_rotation_y = 0;
ThreeDee.initial_rotation_z = 0;
ThreeDee.font_size = 25;
ThreeDee.vec = new THREE.Vector3();



jQuery(document).ready(function(){

	if (!document.getElementById('ThreeDee-cv')) return;

//	jQuery('#ThreeDee_dialog input').blur()
	
	jQuery("#rotation_x").bind('keyup mouseup', function () {
		ThreeDeeRotateModel('x', this.value);
		jQuery("#ThreeDee_rotation_x").val(this.value);
	});
	jQuery("#rotation_y").bind('keyup mouseup', function () {
		ThreeDeeRotateModel('y', this.value);
		jQuery("#ThreeDee_rotation_y").val(this.value);
	});
	jQuery("#rotation_z").bind('keyup mouseup', function () {
		ThreeDeeRotateModel('z', this.value);
		jQuery("#ThreeDee_rotation_z").val(this.value);
	});

	jQuery("#z_offset").bind('keyup mouseup', function () {
		ThreeDeeOffsetZ(this.value);
		jQuery("#z_offset").val(this.value);
	});

	if (jQuery('#product_grid_color').val().length>1) ThreeDee.grid_color = jQuery('#product_grid_color').val().replace('#', '0x');//ThreeDee.ground_color

	jQuery("form[name=post]").submit(function(){


		if (jQuery('#ThreeDee-show-shadow').prop('checked')) {
			jQuery('input[name=product_show_shadow]').val('on');
		}
		else {
			jQuery('input[name=product_show_shadow]').val('off');
		}
		if (jQuery('#ThreeDee-show-mirror').prop('checked')) {
			jQuery('input[name=product_show_mirror]').val('on');
		}
		else {
			jQuery('input[name=product_show_mirror]').val('off');
		}

/*		if (jQuery('#ThreeDee-show-fog').prop('checked')) {
			jQuery('input[name=product_show_fog]').val('on');
		}
		else {
			jQuery('input[name=product_show_fog]').val('off');
		}
*/

		if (jQuery('#ThreeDee-show-grid').prop('checked')) {
			jQuery('input[name=product_show_grid]').val('on');
		}
		else {
			jQuery('input[name=product_show_grid]').val('off');
		}

		if (jQuery('#ThreeDee-show-ground').prop('checked')) {
			jQuery('input[name=product_show_ground]').val('on');
		}
		else {
			jQuery('input[name=product_show_ground]').val('off');
		}
		if (jQuery('#ThreeDee-auto-rotation').prop('checked')) {
			jQuery('input[name=product_auto_rotation]').val('on');
		}
		else {
			jQuery('input[name=product_auto_rotation]').val('off');
		}
		if (jQuery('#ThreeDee-view3d-button').prop('checked')) {
			jQuery('input[name=product_view3d_button]').val('on');
		}
		else {
			jQuery('input[name=product_view3d_button]').val('off');
		}


		if (jQuery('#ThreeDee-background-color').val().length>0) {
			jQuery('input[name=product_background1]').val(jQuery('#ThreeDee-background-color').val());
		}
		else {
			jQuery('input[name=product_background1]').val('#ffffff');
		}
/*		if (jQuery('#ThreeDee-fog-color').val().length>0) {
			jQuery('input[name=product_fog_color]').val(jQuery('#ThreeDee-fog-color').val());
		}
		else {
			jQuery('input[name=product_fog_color]').val('#ffffff');
		}
*/
		if (jQuery('#ThreeDee-grid-color').val().length>0) {
			jQuery('input[name=product_grid_color]').val(jQuery('#ThreeDee-grid-color').val());
		}
		else {
			jQuery('input[name=product_grid_color]').val('#ffffff');
		}
		if (jQuery('#ThreeDee-ground-color').val().length>0) {
			jQuery('input[name=product_ground_color]').val(jQuery('#ThreeDee-ground-color').val());
		}
		else {
			jQuery('input[name=product_ground_color]').val('#ffffff');
		}





		if (jQuery('#ThreeDee-show-light-source1').prop('checked')) {
			jQuery('input[name=product_show_light_source1]').val('on');
		}
		else {
			jQuery('input[name=product_show_light_source1]').val('off');
		}
		if (jQuery('#ThreeDee-show-light-source2').prop('checked')) {
			jQuery('input[name=product_show_light_source2]').val('on');
		}
		else {
			jQuery('input[name=product_show_light_source2]').val('off');
		}
		if (jQuery('#ThreeDee-show-light-source3').prop('checked')) {
			jQuery('input[name=product_show_light_source3]').val('on');
		}
		else {
			jQuery('input[name=product_show_light_source3]').val('off');
		}
		if (jQuery('#ThreeDee-show-light-source4').prop('checked')) {
			jQuery('input[name=product_show_light_source4]').val('on');
		}
		else {
			jQuery('input[name=product_show_light_source4]').val('off');
		}
		if (jQuery('#ThreeDee-show-light-source5').prop('checked')) {
			jQuery('input[name=product_show_light_source5]').val('on');
		}
		else {
			jQuery('input[name=product_show_light_source5]').val('off');
		}
		if (jQuery('#ThreeDee-show-light-source6').prop('checked')) {
			jQuery('input[name=product_show_light_source6]').val('on');
		}
		else {
			jQuery('input[name=product_show_light_source6]').val('off');
		}
		if (jQuery('#ThreeDee-show-light-source7').prop('checked')) {
			jQuery('input[name=product_show_light_source7]').val('on');
		}
		else {
			jQuery('input[name=product_show_light_source7]').val('off');
		}
		if (jQuery('#ThreeDee-show-light-source8').prop('checked')) {
			jQuery('input[name=product_show_light_source8]').val('on');
		}
		else {
			jQuery('input[name=product_show_light_source8]').val('off');
		}
		if (jQuery('#ThreeDee-show-light-source9').prop('checked')) {
			jQuery('input[name=product_show_light_source9]').val('on');
		}
		else {
			jQuery('input[name=product_show_light_source9]').val('off');
		}
		if (jQuery('#z_offset').val().length>0) {
			jQuery('#product_offset_z').val(jQuery('#z_offset').val());
		}
		
		if (jQuery('#ThreeDee-remember-camera-position').prop('checked')) {
			jQuery('input[name=product_remember_camera_position]').val('1');
			if (typeof(ThreeDee.camera)!=='undefined') {
				jQuery('#product_camera_position_x').val(ThreeDee.camera.position.x);
				jQuery('#product_camera_position_y').val(ThreeDee.camera.position.y);
				jQuery('#product_camera_position_z').val(ThreeDee.camera.position.z);

				jQuery('#product_controls_target_x').val(ThreeDee.controls.target.x);
				jQuery('#product_controls_target_y').val(ThreeDee.controls.target.y);
				jQuery('#product_controls_target_z').val(ThreeDee.controls.target.z);

				var vec = ThreeDee.camera.getWorldDirection( ThreeDee.vec );
				jQuery('#product_camera_lookat_x').val(vec.x);
				jQuery('#product_camera_lookat_y').val(vec.y);
				jQuery('#product_camera_lookat_z').val(vec.z);
			}
		}
		else {
			ThreeDee_remove_camera_params();
		}
	})
});



function ThreeDeePreview() {

	//workaround for shortcode pages
	ThreeDee.model_url = jQuery('#ThreeDee_model_url').val();
	ThreeDee.model_mtl = jQuery('#ThreeDee_model_mtl').val();
	ThreeDee.model_color = jQuery('#ThreeDee_model_color').val();

	ThreeDee.model_transparency = jQuery('#ThreeDee_model_transparency').val();
	ThreeDee.model_shininess = jQuery('#ThreeDee_model_shininess').val();
	ThreeDee.upload_url = jQuery('#ThreeDee_upload_url').val();
	ThreeDee.stored_position_x = parseFloat(jQuery('#product_camera_position_x').val()) || 0;
	ThreeDee.stored_position_y = parseFloat(jQuery('#product_camera_position_y').val()) || 0;
	ThreeDee.stored_position_z = parseFloat(jQuery('#product_camera_position_z').val()) || 0;
	ThreeDee.stored_lookat_x = parseFloat(jQuery('#product_camera_lookat_x').val()) || 0;
	ThreeDee.stored_lookat_y = parseFloat(jQuery('#product_camera_lookat_y').val()) || 0;
	ThreeDee.stored_lookat_z = parseFloat(jQuery('#product_camera_lookat_z').val()) || 0;
	ThreeDee.stored_controls_target_x = parseFloat(jQuery('#product_controls_target_x').val()) || 0;
	ThreeDee.stored_controls_target_y = parseFloat(jQuery('#product_controls_target_y').val()) || 0;
	ThreeDee.stored_controls_target_z = parseFloat(jQuery('#product_controls_target_z').val()) || 0;
	ThreeDee.offset_z = parseFloat(jQuery('#product_offset_z').val()) || 0;
	if (jQuery('input[name=product_show_light_source1]').val().length>1) ThreeDee.show_light_source1 = jQuery('input[name=product_show_light_source1]').val();
	if (jQuery('input[name=product_show_light_source2]').val().length>1) ThreeDee.show_light_source2 = jQuery('input[name=product_show_light_source2]').val();
	if (jQuery('input[name=product_show_light_source3]').val().length>1) ThreeDee.show_light_source3 = jQuery('input[name=product_show_light_source3]').val();
	if (jQuery('input[name=product_show_light_source4]').val().length>1) ThreeDee.show_light_source4 = jQuery('input[name=product_show_light_source4]').val();
	if (jQuery('input[name=product_show_light_source5]').val().length>1) ThreeDee.show_light_source5 = jQuery('input[name=product_show_light_source5]').val();
	if (jQuery('input[name=product_show_light_source6]').val().length>1) ThreeDee.show_light_source6 = jQuery('input[name=product_show_light_source6]').val();
	if (jQuery('input[name=product_show_light_source7]').val().length>1) ThreeDee.show_light_source7 = jQuery('input[name=product_show_light_source7]').val();
	if (jQuery('input[name=product_show_light_source8]').val().length>1) ThreeDee.show_light_source8 = jQuery('input[name=product_show_light_source8]').val();
	if (jQuery('input[name=product_show_light_source9]').val().length>1) ThreeDee.show_light_source9 = jQuery('input[name=product_show_light_source9]').val();


//	if ()
//jQuery('#ThreeDee-show-light-source1]').val('');


	jQuery( function() {
		jQuery( "#ThreeDee_dialog" ).dialog({
			modal: true,
			width: "800px",
			open: function(event, ui) {
				ThreeDeeOnWindowResize();
			}
		});
	} );


	window.ThreeDee_canvas = document.getElementById('ThreeDee-cv');
	ThreeDeeCanvasDetails();

	var logoTimerID = 0;

	ThreeDee.targetRotation = 0;

	var model_type=ThreeDee.model_url.split('.').pop().toLowerCase();
	ThreeDeeViewerInit(ThreeDee.model_url, ThreeDee.model_mtl, model_type, false);

	ThreeDeeAnimate();
}



function ThreeDeeViewerInit(model, mtl, ext) {
	var ThreeDee_canvas = document.getElementById('ThreeDee-cv');
	var ThreeDee_canvas_width = jQuery('#ThreeDee-cv').width()
	var ThreeDee_canvas_height = jQuery('#ThreeDee-cv').height()
//console.log(ThreeDee.model_color)
	jQuery('#ThreeDee_shortcode').val('');

	ThreeDee.mtl=mtl;

	//3D Renderer
	ThreeDee.renderer = Detector.webgl? new THREE.WebGLRenderer({ antialias: true, canvas: ThreeDee_canvas, preserveDrawingBuffer: true }): new THREE.CanvasRenderer({canvas: ThreeDee_canvas});
	ThreeDee.renderer.setClearColor( parseInt(ThreeDee.background1, 16) );
	ThreeDee.renderer.setPixelRatio( window.devicePixelRatio );
	ThreeDee.renderer.setSize( ThreeDee_canvas_width, ThreeDee_canvas_height );


	if (Detector.webgl) {

		ThreeDee.renderer.gammaInput = true;
		ThreeDee.renderer.gammaOutput = true;
		if (!jQuery('#ThreeDee-show-shadow').prop('checked')) ThreeDee.renderer.shadowMap.enabled = false;
		else ThreeDee.renderer.shadowMap.enabled = true;
//		ThreeDee.renderer.shadowMap.renderReverseSided = false;
		ThreeDee.renderer.shadowMap.Type = THREE.PCFSoftShadowMap;
	}
	ThreeDee.camera = new THREE.PerspectiveCamera( 35, ThreeDee_canvas_width / ThreeDee_canvas_height, 1, 1000 );
//	ThreeDee.camera.position.set( 0, 0, 6 );

	if (ThreeDee.stored_position_x!=0 || ThreeDee.stored_position_y!=0 || ThreeDee.stored_position_z!=0) {
		ThreeDee.camera.position.set(ThreeDee.stored_position_x, ThreeDee.stored_position_y, ThreeDee.stored_position_z);
	}
	else {
		ThreeDee.camera.position.set( 0, 0, 0 );
	}

//	ThreeDee.cameraTarget = new THREE.Vector3( 0, 0, 0 );




	ThreeDee.scene = new THREE.Scene();
	if (jQuery('#ThreeDee-background-color').val().length>0) {
		ThreeDee.scene.background = new THREE.Color(parseInt(jQuery('#ThreeDee-background-color').val().replace('#', '0x'), 16));
	}


	ThreeDee.clock = new THREE.Clock();

	//Group
	if (ThreeDee.group) ThreeDee.scene.remove(ThreeDee.group);
	ThreeDee.group = new THREE.Group();
	ThreeDee.group.position.set( 0, 0, 0 )
	ThreeDee.group.name = "group";
	ThreeDee.scene.add( ThreeDee.group );

	//Axis
	ThreeDee.axis = new THREE.AxesHelper( 300 )
	ThreeDee.scene.add( ThreeDee.axis );





	//Light
	ambientLight = new THREE.AmbientLight(0x191919);
	ThreeDee.scene.add(ambientLight);
	ambientLight.name = "light";


	if (ThreeDee.show_light_source1=='on') ThreeDee.directionalLight1 = ThreeDeeMakeLight(1);
	if (ThreeDee.show_light_source2=='on') ThreeDee.directionalLight2 = ThreeDeeMakeLight(2);
	if (ThreeDee.show_light_source3=='on') ThreeDee.directionalLight3 = ThreeDeeMakeLight(3);
	if (ThreeDee.show_light_source4=='on') ThreeDee.directionalLight4 = ThreeDeeMakeLight(4);
	if (ThreeDee.show_light_source5=='on') ThreeDee.directionalLight5 = ThreeDeeMakeLight(5);
	if (ThreeDee.show_light_source6=='on') ThreeDee.directionalLight6 = ThreeDeeMakeLight(6);
	if (ThreeDee.show_light_source7=='on') ThreeDee.directionalLight7 = ThreeDeeMakeLight(7);
	if (ThreeDee.show_light_source8=='on') ThreeDee.directionalLight8 = ThreeDeeMakeLight(8);
	if (ThreeDee.show_light_source9=='on') ThreeDee.directionalLight9 = ThreeDeeMakeLight(9);



	ThreeDee.controls = new THREE.OrbitControls( ThreeDee.camera, ThreeDee.renderer.domElement );
	if (ThreeDee.auto_rotation=='on' || jQuery('#ThreeDee-auto-rotation').prop('checked')) {
		ThreeDee.controls.autoRotate = true; 
		ThreeDee.controls.autoRotateSpeed = 6;
	}
	if (!jQuery('#ThreeDee-auto-rotation').prop('checked')) {
		ThreeDee.controls.autoRotate = false;
	}

	ThreeDee.controls.addEventListener( 'start', function() {
		ThreeDee.controls.autoRotate = false; 
	});
	jQuery('#ThreeDee-convert1').hide();
	jQuery('#ThreeDee-convert2').hide();
	if (ext=='stl') {
		jQuery('#ThreeDee-convert2').show();
		ThreeDee.loader = new THREE.STLLoader();
	}
/*	else if (ext=='dae') {
		ThreeDee.loader = new THREE.ColladaLoader();
	}*/
	else if (ext=='obj') {
		jQuery('#ThreeDee-convert1').show();
		ThreeDee.loader = new THREE.OBJLoader();
	}
	else if (ext=='wrl') {
		jQuery('#ThreeDee-convert1').show();
		ThreeDee.loader = new THREE.VRMLLoader();
	}
	else if (ext=='gltf' || ext=='glb') {
		jQuery('#ThreeDee-convert1').hide();
		THREE.DRACOLoader.setDecoderPath( ThreeDee.plugin_url+'includes/ext/threejs/js/libs/draco/gltf/' );
		ThreeDee.loader = new THREE.GLTFLoader();
		ThreeDee.loader.setDRACOLoader( new THREE.DRACOLoader() );
	}
	else if (typeof(ext)!=='undefined') {

		if (ext == 'zip') {
			alert('ZIP is not supported by the viewer yet.');
		}
		else {
			alert('Supported file types: STL, OBJ, WRL, GLTF, GLB, ZIP');
		}
		ThreeDeeDisplayUserDefinedProgressBar(false);
		return;
	}

	if (model.length>0) {

		var mtlLoader = new THREE.MTLLoader();
		mtlLoader.setPath( ThreeDee.upload_url );

		if (ext=='obj' && mtl && mtl.length>0) {
			mtlLoader.load( mtl, function( materials ) {
				materials.preload();
				var objLoader = new THREE.OBJLoader();
				ThreeDee.loader.setMaterials( materials );

				ThreeDee.loader.load( model, function ( geometry ) {
		        	    ThreeDeeModelOnLoad(geometry);
				});
			});
		}
		else if (ext=='gltf' || ext=='glb') {
			ThreeDee.loader.load( model, function ( gltf ) {
				ThreeDeeModelOnLoad(gltf.scene);
/*
					gltf.scene.traverse( function ( child ) {

						if ( child.isSkinnedMesh ) child.castShadow = true;

					} );
*/
				if (gltf.animations.length>0) {
					ThreeDee.mixer = new THREE.AnimationMixer( gltf.scene );
					ThreeDee.mixer.clipAction( gltf.animations[ 0 ] ).play();
				}
			} );
		}
		else {
			ThreeDee.loader.load( model, function ( geometry ) {
				ThreeDeeModelOnLoad(geometry)
				if (ext=='wrl' && jQuery('#ThreeDee_shortcode').length>0) { //strange bug fix
					jQuery('#z_offset').val('1');
					ThreeDeeOffsetZ(1);
					ThreeDeeFitCameraToObject(ThreeDee.camera, ThreeDee.object, 1.2, ThreeDee.controls);
				}

			} );
		}
	}

//	if (ThreeDee.display_mode=='fullscreen') {
//		ThreeDeeGoFullScreen();
//
//	}


	window.addEventListener( 'resize', ThreeDeeOnWindowResize, false );

}


function ThreeDeeModelOnLoad(object) {

	ThreeDee.object = object;
	geometry = object;

	if (object.type=='Group') {
		geometry = object.children[0].geometry;
		//todo: merge multiple geometries?
	}

	//Material
	var material = ThreeDeeCreateMaterial(ThreeDee.shading);
	if (typeof(geometry.computeBoundingBox)!=='undefined') {
		geometry.computeBoundingBox();
		ThreeDee.boundingBox=geometry.boundingBox;
	}
	else {
	    	ThreeDee.boundingBox = new THREE.Box3().setFromObject(object);
	}
/*
	if (object.type=='Group' && object.children.length>1) {
		var min_coords=[];
		var max_coords=[];
		for(var i=0;i<object.children.length;i++) {
			object.children[i].geometry.computeBoundingBox();
			if (i==0) {
				min_coords.x=object.children[i].geometry.boundingBox.min.x;
				min_coords.y=object.children[i].geometry.boundingBox.min.y;
				min_coords.z=object.children[i].geometry.boundingBox.min.z;
				max_coords.x=object.children[i].geometry.boundingBox.max.x;
				max_coords.y=object.children[i].geometry.boundingBox.max.y;
				max_coords.z=object.children[i].geometry.boundingBox.max.z;
			}
			else {
				if (object.children[i].geometry.boundingBox.min.x < min_coords.x) min_coords.x = object.children[i].geometry.boundingBox.min.x;
				if (object.children[i].geometry.boundingBox.min.y < min_coords.y) min_coords.y = object.children[i].geometry.boundingBox.min.y;
				if (object.children[i].geometry.boundingBox.min.z < min_coords.z) min_coords.z = object.children[i].geometry.boundingBox.min.z;

				if (object.children[i].geometry.boundingBox.max.x > max_coords.x) max_coords.x = object.children[i].geometry.boundingBox.max.x;
				if (object.children[i].geometry.boundingBox.max.y > max_coords.y) max_coords.y = object.children[i].geometry.boundingBox.max.y;
				if (object.children[i].geometry.boundingBox.max.z > max_coords.z) max_coords.z = object.children[i].geometry.boundingBox.max.z;
			}
		}
		ThreeDee.boundingBox.min=min_coords;
		ThreeDee.boundingBox.max=max_coords;
	}
*/

	//Model


	ThreeDeeCreateModel(object, geometry, material, ThreeDee.shading);
	ThreeDeeChangeModelColor(ThreeDee.model_color);


//	if ((object.type=='Group'&& object.children.length>1) || object.type=='Scene') {
	if ((object.type=='Group'&& object.children.length>1) || object.type=='Scene') {
		new THREE.Box3().setFromObject( ThreeDee.object ).getCenter( ThreeDee.object.position ).multiplyScalar( - 1 );
	    	ThreeDee.boundingBox = new THREE.Box3().setFromObject(object);
	}
	else {
		geometry.center();
	}



//	var model_dim = new Array();
//	model_dim.x = ThreeDee.boundingBox.max.x - ThreeDee.boundingBox.min.x;
//	model_dim.y = ThreeDee.boundingBox.max.y - ThreeDee.boundingBox.min.y;
//	model_dim.z = ThreeDee.boundingBox.max.z - ThreeDee.boundingBox.min.z;

	var mesh_width = ThreeDee.boundingBox.max.x - ThreeDee.boundingBox.min.x;
	var mesh_length = ThreeDee.boundingBox.max.y - ThreeDee.boundingBox.min.y;
	var mesh_height = ThreeDee.boundingBox.max.z - ThreeDee.boundingBox.min.z;

	var mesh_diagonal = Math.sqrt(mesh_width * mesh_width + mesh_length * mesh_length + mesh_height * mesh_height);



	if (Detector.webgl) {
		var canvas_width=ThreeDee.renderer.getSize().width;
		var canvas_height=ThreeDee.renderer.getSize().height;
	}
	else {
		var canvas_width=jQuery('#ThreeDee-cv').width();
		var canvas_height=jQuery('#ThreeDee-cv').height();
	}

	var canvas_diagonal = Math.sqrt(canvas_width * canvas_width + canvas_height * canvas_height);

	var max_side = Math.max(mesh_width, mesh_length, mesh_height)
//	var max_side_xy = Math.max(mesh_width, mesh_length)

//	var axis_length = Math.max(mesh_width, mesh_length);
///	var axis_width = Math.min(mesh_width, mesh_length);

//	console.log(Math.max(canvas_width , canvas_height));
//	var font_size = (Math.max(canvas_width , canvas_height)/30);	
//console.log(font_size);

	var plane_width = max_side * 100;
	var grid_step = plane_width/100;

	if (ThreeDee.axis.geometry.boundingSphere.radius < max_side) {
		ThreeDee.axis.scale.set(max_side,max_side,max_side);
	}

	if (ThreeDee.show_fog=='on') {
		ThreeDee.scene.background = new THREE.Color( parseInt(ThreeDee.fog_color, 16) );
		ThreeDee.scene.fog = new THREE.Fog( parseInt(ThreeDee.fog_color, 16), max_side*3, plane_width/2 ); 
		ThreeDee.scene.fog.oldfar = ThreeDee.scene.fog.far;
	}
//	if (!jQuery('#ThreeDee-show-fog').prop('checked')) {
//		ThreeDee.scene.fog.far=Infinity;
//	}

//0xa0a0a0


//	console.log(dist);
//	font_size = 20;

	ThreeDee.spritey_x = ThreeDeeMakeTextSprite( " X ", 
		{ fontsize: ThreeDee.font_size, borderColor: {r:255, g:102, b:0, a:1.0}, backgroundColor: {r:255, g:255, b:255, a:0.8} } );
	ThreeDee.spritey_x.position.set(((ThreeDeeGetFraction(ThreeDee.font_size)*(mesh_width/2))+10),0,0);
	ThreeDee.spritey_x.rotation.z = 90 * Math.PI/180;
	ThreeDee.spritey_x.rotation.x = -90 * Math.PI/180;
	ThreeDee.scene.add( ThreeDee.spritey_x );

	ThreeDee.spritey_y = ThreeDeeMakeTextSprite( " Y ", 
		{ fontsize: ThreeDee.font_size, borderColor: {r:51, g:51, b:255, a:1.0}, backgroundColor: {r:255, g:255, b:255, a:0.8} } );
	ThreeDee.spritey_y.position.set(0,0,((ThreeDeeGetFraction(ThreeDee.font_size)*(mesh_length/2))+10));
	ThreeDee.spritey_y.rotation.z = 90 * Math.PI/180;
	ThreeDee.spritey_y.rotation.x = -90 * Math.PI/180;
	ThreeDee.scene.add( ThreeDee.spritey_y );

	ThreeDee.spritey_z = ThreeDeeMakeTextSprite( " Z ", 
		{ fontsize: ThreeDee.font_size, borderColor: {r:51, g:204, b:51, a:1.0}, backgroundColor: {r:255, g:255, b:255, a:0.8} } );
	ThreeDee.spritey_z.position.set(0,((ThreeDeeGetFraction(ThreeDee.font_size)*(mesh_height/2))+10),0);
	ThreeDee.spritey_z.rotation.z = 90 * Math.PI/180;
	ThreeDee.spritey_z.rotation.x = -90 * Math.PI/180;
	ThreeDee.scene.add( ThreeDee.spritey_z );





	//Camera
	//todo if remember camera pos
	if (ThreeDee.stored_position_x!=0 || ThreeDee.stored_position_y!=0 || ThreeDee.stored_position_z!=0) {//manually set 
	        var objectWorldPosition = new THREE.Vector3(ThreeDee.stored_lookat_x, ThreeDee.stored_lookat_y, ThreeDee.stored_lookat_z); //params?
	        ThreeDee.camera.lookAt(objectWorldPosition); 

		ThreeDee.camera.position.set(ThreeDee.stored_position_x, ThreeDee.stored_position_y, ThreeDee.stored_position_z);

		ThreeDee.controls.target = new THREE.Vector3(ThreeDee.stored_controls_target_x, ThreeDee.stored_controls_target_y, ThreeDee.stored_controls_target_z); 

		ThreeDee.camera.far=plane_width*5;
		ThreeDee.camera.updateProjectionMatrix();
	}
	else {//auto set
		ThreeDeeFitCameraToObject(ThreeDee.camera, ThreeDee.object, 1.2, ThreeDee.controls);
	}

//ThreeDeeFitCameraToObject(ThreeDee.camera, ThreeDee.object, 1.35, ThreeDee.controls);

//	mesh_width, mesh_height

	//Ground
	if (Detector.webgl) {
//		if (ThreeDee.ground_mirror=='on' || jQuery('#ThreeDee-show-mirror').prop('checked')) {
		if (true) {
			var plane_shininess = 2500;
			var plane_transparent = true;
			var plane_opacity = 0.6;
		}
		else {
			var plane_shininess = 30;
			var plane_transparent = false;
			var plane_opacity = 1;
		}
		
		plane = new THREE.Mesh(
			new THREE.PlaneBufferGeometry( plane_width, plane_width ),
			new THREE.MeshPhongMaterial ( { color: parseInt(ThreeDee.ground_color, 16), transparent:plane_transparent, opacity:plane_opacity, shininess: plane_shininess } ) 
		);
		if (ThreeDee.show_ground!='on' || !jQuery('#ThreeDee-show-ground').prop('checked')) {
			plane.visible = false;
		}
		if (jQuery('#ThreeDee-ground-color').val().length>0) {
			plane.material.color = new THREE.Color(parseInt(jQuery('#ThreeDee-ground-color').val().replace('#', '0x'), 16));
		}

		plane.rotation.x = -Math.PI/2;
		plane.position.y = ThreeDee.boundingBox.min.z;
		plane.receiveShadow = true;
		plane.castShadow = true;
		plane.name = 'ground';
		ThreeDee.scene.add( plane );
//		if (ThreeDee.ground_mirror=='on' || jQuery('#ThreeDee-show-mirror').prop('checked')) {
		if (true) {
			var planeGeo = new THREE.PlaneBufferGeometry( plane_width, plane_width );
			ThreeDee.groundMirror = new THREE.Mirror( ThreeDee.renderer, ThreeDee.camera, { clipBias: 0.003, textureWidth: canvas_width, textureHeight: canvas_height, color: 0xaaaaaa } );
			var mirrorMesh = new THREE.Mesh( planeGeo, ThreeDee.groundMirror.material );
			mirrorMesh.position.y = ThreeDee.boundingBox.min.z-1;
			mirrorMesh.add( ThreeDee.groundMirror );
			mirrorMesh.rotateX( - Math.PI / 2 );
			mirrorMesh.name = 'mirror';
			//if (!jQuery('#ThreeDee-show-mirror').prop('checked')) mirrorMesh.visible = false;

			ThreeDee.scene.add( mirrorMesh );
			if (!jQuery('#ThreeDee-show-mirror').prop('checked')) {
				mirrorMesh.visible = false;
				ThreeDee.scene.getObjectByName('ground').material.transparent = false;
				ThreeDee.scene.getObjectByName('ground').material.opacity = 1;
				ThreeDee.scene.getObjectByName('ground').material.shininess = 30;

			}

		}

	}

	if (ThreeDee.object.type=='Scene') {
		//calculate new dimensions
		var bbox = new THREE.Box3().setFromObject(ThreeDee.object);
		var mesh_height = bbox.max.y - bbox.min.y;
		var mesh_width = bbox.max.x - bbox.min.x;
		var mesh_length = bbox.max.z - bbox.min.z;
		ThreeDee.object.position.y = ThreeDee.scene.getObjectByName('ground').position.y
//		ThreeDee.object.position.y = ThreeDee.scene.getObjectByName('ground').position.y
	}



	//Grid
//	if (ThreeDee.show_grid=='on' && ThreeDee.grid_color.length>0) {
	if (true) {

		if (ThreeDee.grid_color.length==0) ThreeDee.grid_color = '0xffffff';
//		var size = 1000, step = 50;
		var size = plane_width/2, step = grid_step;
		var grid_geometry = new THREE.Geometry();
		for ( var i = - size; i <= size; i += step ) {
			grid_geometry.vertices.push( new THREE.Vector3( - size, ThreeDee.boundingBox.min.z, i ) );
			grid_geometry.vertices.push( new THREE.Vector3(   size, ThreeDee.boundingBox.min.z, i ) );
			grid_geometry.vertices.push( new THREE.Vector3( i, ThreeDee.boundingBox.min.z, - size ) );
			grid_geometry.vertices.push( new THREE.Vector3( i, ThreeDee.boundingBox.min.z,   size ) );
		
		}


		var grid_material = new THREE.LineBasicMaterial( { color: parseInt(ThreeDee.grid_color, 16), opacity: 0.2 } );
		var line = new THREE.LineSegments( grid_geometry, grid_material );
		line.name = "grid";
		ThreeDee.scene.add( line );
		ThreeDee.group.add( line );
	}
	if (ThreeDee.show_grid!='on' || !jQuery('#ThreeDee-show-grid').prop('checked')) { 
		ThreeDee.scene.getObjectByName('grid').visible=false;
	}
/*	
	directionalLight.position.set( max_side*2, max_side*2, max_side*2 );
	directionalLight2.position.set( -max_side*2, max_side*2, -max_side*2 );
	if (Detector.webgl && ThreeDee.show_shadow=='on') {
		directionalLight.castShadow = true;
		directionalLight2.castShadow = true;
		ThreeDeeMakeShadow();
	}
	ThreeDee.scene.add( directionalLight );
	ThreeDee.scene.add( directionalLight2 );
*/

	if (ThreeDee.show_light_source1=='on') ThreeDeeSetupLight(ThreeDee.directionalLight1, 1);
	if (ThreeDee.show_light_source2=='on') ThreeDeeSetupLight(ThreeDee.directionalLight2, 2);
	if (ThreeDee.show_light_source3=='on') ThreeDeeSetupLight(ThreeDee.directionalLight3, 3);
	if (ThreeDee.show_light_source4=='on') ThreeDeeSetupLight(ThreeDee.directionalLight4, 4);
	if (ThreeDee.show_light_source5=='on') ThreeDeeSetupLight(ThreeDee.directionalLight5, 5);
	if (ThreeDee.show_light_source6=='on') ThreeDeeSetupLight(ThreeDee.directionalLight6, 6);
	if (ThreeDee.show_light_source7=='on') ThreeDeeSetupLight(ThreeDee.directionalLight7, 7);
	if (ThreeDee.show_light_source8=='on') ThreeDeeSetupLight(ThreeDee.directionalLight8, 8);
	if (ThreeDee.show_light_source9=='on') ThreeDeeSetupLight(ThreeDee.directionalLight9, 9);



	ThreeDeeDisplayUserDefinedProgressBar(false);
	ThreeDee.original_width=jQuery('#ThreeDee-cv').width();
	ThreeDee.original_height=jQuery('#ThreeDee-cv').height();

	//ThreeDeeRotateModel();
	if (jQuery("#ThreeDee_rotation_x").val()!=0)
		ThreeDeeRotateModel('x', jQuery("#rotation_x").val());
	if (jQuery("#ThreeDee_rotation_y").val()!=0)
		ThreeDeeRotateModel('y', jQuery("#rotation_y").val());
	if (jQuery("#ThreeDee_rotation_z").val()!=0)
		ThreeDeeRotateModel('z', jQuery("#rotation_z").val());

	ThreeDee.spritey_x.position.set(((ThreeDeeGetFraction(ThreeDee.font_size)*(mesh_width/2))+10),0,0);
	ThreeDee.spritey_y.position.set(0,0,((ThreeDeeGetFraction(ThreeDee.font_size)*(mesh_length/2))+10));
	ThreeDee.spritey_z.position.set(0,((ThreeDeeGetFraction(ThreeDee.font_size)*(mesh_height/2))+10),0);

	if (!isNaN(ThreeDee.offset_z) && ThreeDee.offset_z!=0) {
		if (ThreeDee.object.type=='Scene' || ThreeDee.object.type=='Group') {
			ThreeDee.object.position.y = ThreeDee.offset_z;
		}
		else {
			//ThreeDee.model_mesh.position.y = ThreeDee.offset_z;
		}
	}

	if (ThreeDee.object.type=='Scene' || ThreeDee.object.type=='Group') {
		jQuery('#z_offset').val(ThreeDee.object.position.y);
	}
	else {
		jQuery('#z_offset').val(ThreeDee.model_mesh.position.y);
	}


}

function ThreeDeeToggleLightSource(idx) {
	switch(idx) {
		case 1:
			if (typeof(ThreeDee.directionalLight1)!=='undefined') {
				if (ThreeDee.directionalLight1.visible) {
					ThreeDee.directionalLight1.visible = false;
				}
				else {
					ThreeDee.directionalLight1.visible = true;
				}
			}
			else {
				ThreeDee.directionalLight1 = ThreeDeeMakeLight(1);
				ThreeDeeSetupLight(ThreeDee.directionalLight1, 1);
			}
	        break;
		case 2:
			if (typeof(ThreeDee.directionalLight2)!=='undefined') {
				if (ThreeDee.directionalLight2.visible) {
					ThreeDee.directionalLight2.visible = false;
				}
				else {
					ThreeDee.directionalLight2.visible = true;
				}
			}
			else {
				ThreeDee.directionalLight2 = ThreeDeeMakeLight(2);
				ThreeDeeSetupLight(ThreeDee.directionalLight2, 2);
			}
	        break;
		case 3:
			if (typeof(ThreeDee.directionalLight3)!=='undefined') {
				if (ThreeDee.directionalLight3.visible) {
					ThreeDee.directionalLight3.visible = false;
				}
				else {
					ThreeDee.directionalLight3.visible = true;
				}
			}
			else {
				ThreeDee.directionalLight3 = ThreeDeeMakeLight(3);
				ThreeDeeSetupLight(ThreeDee.directionalLight3, 3);
			}
	        break;
		case 4:
			if (typeof(ThreeDee.directionalLight4)!=='undefined') {
				if (ThreeDee.directionalLight4.visible) {
					ThreeDee.directionalLight4.visible = false;
				}
				else {
					ThreeDee.directionalLight4.visible = true;
				}
			}
			else {
				ThreeDee.directionalLight4 = ThreeDeeMakeLight(4);
				ThreeDeeSetupLight(ThreeDee.directionalLight4, 4);
			}
	        break;
		case 5:
			if (typeof(ThreeDee.directionalLight5)!=='undefined') {
				if (ThreeDee.directionalLight5.visible) {
					ThreeDee.directionalLight5.visible = false;
				}
				else {
					ThreeDee.directionalLight5.visible = true;
				}
			}
			else {
				ThreeDee.directionalLight5 = ThreeDeeMakeLight(5);
				ThreeDeeSetupLight(ThreeDee.directionalLight5, 5);
			}
	        break;
		case 6:
			if (typeof(ThreeDee.directionalLight6)!=='undefined') {
				if (ThreeDee.directionalLight6.visible) {
					ThreeDee.directionalLight6.visible = false;
				}
				else {
					ThreeDee.directionalLight6.visible = true;
				}
			}
			else {
				ThreeDee.directionalLight6 = ThreeDeeMakeLight(6);
				ThreeDeeSetupLight(ThreeDee.directionalLight6, 6);
			}
	        break;
		case 7:
			if (typeof(ThreeDee.directionalLight7)!=='undefined') {
				if (ThreeDee.directionalLight7.visible) {
					ThreeDee.directionalLight7.visible = false;
				}
				else {
					ThreeDee.directionalLight7.visible = true;
				}
			}
			else {
				ThreeDee.directionalLight7 = ThreeDeeMakeLight(7);
				ThreeDeeSetupLight(ThreeDee.directionalLight7, 7);
			}
	        break;
		case 8:
			if (typeof(ThreeDee.directionalLight8)!=='undefined') {
				if (ThreeDee.directionalLight8.visible) {
					ThreeDee.directionalLight8.visible = false;
				}
				else {
					ThreeDee.directionalLight8.visible = true;
				}
			}
			else {
				ThreeDee.directionalLight8 = ThreeDeeMakeLight(8);
				ThreeDeeSetupLight(ThreeDee.directionalLight8, 8);
			}
	        break;
		case 9:
			if (typeof(ThreeDee.directionalLight9)!=='undefined') {
				if (ThreeDee.directionalLight9.visible) {
					ThreeDee.directionalLight9.visible = false;
				}
				else {
					ThreeDee.directionalLight9.visible = true;
				}
			}
			else {
				ThreeDee.directionalLight9 = ThreeDeeMakeLight(9);
				ThreeDeeSetupLight(ThreeDee.directionalLight9, 9);
			}
	        break;
	}

	//recalculate intensity
	var number_of_sources=0;
	var intensity=0;
	for(var i=0;i<ThreeDee.scene.children.length;i++) {
		if (ThreeDee.scene.children[i].type=='DirectionalLight' && ThreeDee.scene.children[i].visible) {
			number_of_sources++
		}
	}
	intensity = Math.min((1/number_of_sources)*1.5, 1);
	for(var i=0;i<ThreeDee.scene.children.length;i++) {
		if (ThreeDee.scene.children[i].type=='DirectionalLight' && ThreeDee.scene.children[i].visible) {
			ThreeDee.scene.children[i].intensity = intensity;
		}
	}
}

function ThreeDeeGetLightIntensity() {

	var number_of_sources=0;
	if (ThreeDee.show_light_source1=='on') number_of_sources++;
	if (ThreeDee.show_light_source2=='on') number_of_sources++;
	if (ThreeDee.show_light_source3=='on') number_of_sources++;
	if (ThreeDee.show_light_source4=='on') number_of_sources++;
	if (ThreeDee.show_light_source5=='on') number_of_sources++;
	if (ThreeDee.show_light_source6=='on') number_of_sources++;
	if (ThreeDee.show_light_source7=='on') number_of_sources++;
	if (ThreeDee.show_light_source8=='on') number_of_sources++;
	if (ThreeDee.show_light_source9=='on') number_of_sources++;

	return Math.min((1/number_of_sources)*1.5, 1);

}

function ThreeDeeMakeLight(idx) {
	var intensity = ThreeDeeGetLightIntensity();
	var directionalLight = new THREE.DirectionalLight( 0xffffff, intensity );
	directionalLight.name = "light"+idx;
	return directionalLight;
}


function ThreeDeeSetupLight(directionalLight, idx) {
	var model_dim = new Array();
	model_dim.x = ThreeDee.boundingBox.max.x - ThreeDee.boundingBox.min.x;
	model_dim.y = ThreeDee.boundingBox.max.y - ThreeDee.boundingBox.min.y;
	model_dim.z = ThreeDee.boundingBox.max.z - ThreeDee.boundingBox.min.z;

	var max_side = Math.max(model_dim.x, model_dim.y, model_dim.z)

	switch(idx) {
		case 1:
			directionalLight.position.set( max_side*2, max_side*2, 0 );
	        break;
		case 2:
			directionalLight.position.set( max_side*2, max_side*2, max_side*2 );
	        break;
		case 3:
			directionalLight.position.set( 0, max_side*2, max_side*2 );
	        break;
		case 4:
			directionalLight.position.set( -max_side*2, max_side*2, max_side*2 );
	        break;
		case 5:
			directionalLight.position.set( -max_side*2, max_side*2, 0 );
	        break;
		case 6:
			directionalLight.position.set( -max_side*2, max_side*2, -max_side*2 );
	        break;
		case 7:
			directionalLight.position.set( 0, max_side*2, - max_side*2 );
	        break;
		case 8:
			directionalLight.position.set( max_side*2, max_side*2, -max_side*2 );
	        break;
		case 9:
			directionalLight.position.set( 0, max_side*2, 0 );
	        break;
	}
	if (Detector.webgl) {
		directionalLight.castShadow = true;
		ThreeDeeMakeShadow(directionalLight);
	}
	ThreeDee.scene.add( directionalLight );

}

function ThreeDeeMakeShadow(directionalLight) {
	var model_dim = new Array();
	model_dim.x = ThreeDee.boundingBox.max.x - ThreeDee.boundingBox.min.x;
	model_dim.y = ThreeDee.boundingBox.max.y - ThreeDee.boundingBox.min.y;
	model_dim.z = ThreeDee.boundingBox.max.z - ThreeDee.boundingBox.min.z;

	var max_side = Math.max(model_dim.x, model_dim.y, model_dim.z)
//  	var bias = -0.001;
	var d = max_side;
//	if (d<30) bias = -0.0001;

  	var bias = -0.00001;
	directionalLight.shadow.camera.left = -d;
	directionalLight.shadow.camera.right = d;
	directionalLight.shadow.camera.top = d;
	directionalLight.shadow.camera.bottom = -d;
	directionalLight.shadow.camera.near = 0.1;
	directionalLight.shadow.camera.far = ThreeDee.camera.far;
	directionalLight.shadow.mapSize.width = 2048;
	directionalLight.shadow.mapSize.height = 2048;
	directionalLight.shadow.bias = bias;

	if (directionalLight.shadow.map) {
		directionalLight.shadow.map.dispose(); 
		directionalLight.shadow.map = null;
	}
}


function ThreeDeeGetFraction(size) {

	model_dim=[];
	model_dim.x = ThreeDee.boundingBox.max.x - ThreeDee.boundingBox.min.x;
	model_dim.y = ThreeDee.boundingBox.max.y - ThreeDee.boundingBox.min.y;
	model_dim.z = ThreeDee.boundingBox.max.z - ThreeDee.boundingBox.min.z;

	var max_side = Math.max(model_dim.x, model_dim.y, model_dim.z)
	var zero = []; zero.x=zero.y=zero.y=0;
	var dist = ThreeDeeLineLength(ThreeDee.camera.position, zero);
	var vFOV = ThreeDee.camera.fov * Math.PI / 180;        // convert vertical fov to radians
	var height = 2 * Math.tan( vFOV / 2 ) * dist; // visible height

//	var fraction = height/max_side;

	var fraction = height/size;

	if (fraction<1) fraction = 1;

	return fraction;
}

function ThreeDeeMakeTextSprite( message, parameters )  {
        if ( parameters === undefined ) parameters = {};
        var fontface = parameters.hasOwnProperty("fontface") ? parameters["fontface"] : "Arial";
        var fontsize = parameters.hasOwnProperty("fontsize") ? parameters["fontsize"] : 18;
        var borderThickness = parameters.hasOwnProperty("borderThickness") ? parameters["borderThickness"] : 4;
        var borderColor = parameters.hasOwnProperty("borderColor") ?parameters["borderColor"] : { r:0, g:0, b:0, a:1.0 };
        var backgroundColor = parameters.hasOwnProperty("backgroundColor") ?parameters["backgroundColor"] : { r:255, g:255, b:255, a:0 };
        var textColor = parameters.hasOwnProperty("textColor") ?parameters["textColor"] : { r:0, g:0, b:0, a:1.0 };

        var canvas = document.createElement('canvas');
//	canvas.width=256;
//	canvas.height=128;
        var context = canvas.getContext('2d');


//	console.log(context.canvas.width, context.canvas.height);
        context.font = "Bold " + fontsize + "px " + fontface;
        var metrics = context.measureText( message );
//console.log(metrics);
        var textWidth = metrics.width;

        context.fillStyle   = "rgba(" + backgroundColor.r + "," + backgroundColor.g + "," + backgroundColor.b + "," + backgroundColor.a + ")";
        context.strokeStyle = "rgba(" + borderColor.r + "," + borderColor.g + "," + borderColor.b + "," + borderColor.a + ")";

        context.lineWidth = borderThickness;
        ThreeDeeRoundRect(context, borderThickness/2, borderThickness/2, (textWidth + borderThickness) * 1.1, fontsize * 1.4 + borderThickness, 8);

        context.fillStyle = "rgba("+textColor.r+", "+textColor.g+", "+textColor.b+", 1.0)";
        context.fillText( message, borderThickness, fontsize + borderThickness);
//	context.globalAlpha = 0;
//console.log(context);

        var texture = new THREE.Texture(canvas) 
        texture.needsUpdate = true;

        var spriteMaterial = new THREE.SpriteMaterial( { map: texture } );
        var sprite = new THREE.Sprite( spriteMaterial );
//	var scale_x = 0.5 * fontsize * ThreeDeeGetFraction(fontsize);
//	var scale_y = 0.25 * fontsize * ThreeDeeGetFraction(fontsize);
//	var scale_z = 0.75 * fontsize * ThreeDeeGetFraction(fontsize);

        sprite.scale.set(0.5 * fontsize * ThreeDeeGetFraction(fontsize), 0.25 * fontsize * ThreeDeeGetFraction(fontsize), 0.75 * fontsize * ThreeDeeGetFraction(fontsize));
        return sprite;  
}

function ThreeDeeRoundRect(ctx, x, y, w, h, r) {
    ctx.beginPath();
    ctx.moveTo(x+r, y);
    ctx.lineTo(x+w-r, y);
    ctx.quadraticCurveTo(x+w, y, x+w, y+r);
    ctx.lineTo(x+w, y+h-r);
    ctx.quadraticCurveTo(x+w, y+h, x+w-r, y+h);
    ctx.lineTo(x+r, y+h);
    ctx.quadraticCurveTo(x, y+h, x, y+h-r);
    ctx.lineTo(x, y+r);
    ctx.quadraticCurveTo(x, y, x+r, y);
    ctx.closePath();
    ctx.fill();
    ctx.stroke();   
}



function ThreeDeeCreateMaterial(model_shading) {

	var color = new THREE.Color( parseInt(ThreeDee.model_color, 16) );
	var shininess = ThreeDeeGetCurrentShininess();
	var transparency = ThreeDeeGetCurrentTransparency();

	color.offsetHSL(0, 0, -0.1);

	if (Detector.webgl) {
		if (model_shading=='smooth') {
			var flat_shading = false;
		}
		else {
			var flat_shading = true;
		}


		var material = new THREE.MeshPhongMaterial( { color: color, specular: shininess.specular, shininess: shininess.shininess, transparent:true, opacity:transparency, wireframe:false, flatShading:flat_shading, precision: 'mediump' } );
	}
	else {

		var material = new THREE.MeshLambertMaterial( { color: color, vertexColors: THREE.FaceColors, wireframe: false, overdraw:1, flatShading:true } );
	}

	return material;
}

function ThreeDeeCreateModel(object, geometry, material, shading) {
	ThreeDee.model_mesh = new THREE.Mesh(geometry, material);
	if (typeof(geometry.getAttribute)!=='undefined') {
		var attrib = geometry.getAttribute('position');
		if(attrib === undefined) {
			throw new Error('a given BufferGeometry object must have a position attribute.');
		}
		var positions = attrib.array;
		var vertices = [];
		for(var i = 0, n = positions.length; i < n; i += 3) {
			var x = positions[i];
			var y = positions[i + 1];
			var z = positions[i + 2];
			vertices.push(new THREE.Vector3(x, y, z));
		}
		var faces = [];
		for(var i = 0, n = vertices.length; i < n; i += 3) {
			faces.push(new THREE.Face3(i, i + 1, i + 2));
		}

		var new_geometry = new THREE.Geometry();
		new_geometry.vertices = vertices;
		new_geometry.faces = faces;
		new_geometry.computeFaceNormals();              
		new_geometry.computeVertexNormals();
		new_geometry.computeBoundingBox();

		geometry = new_geometry;
		geometry.center();


		if (shading=='smooth' && Detector.webgl) {
	                var smooth_geometry = new THREE.Geometry();
	                smooth_geometry.vertices = vertices;
	                smooth_geometry.faces = faces;
	                smooth_geometry.computeFaceNormals();              
	                smooth_geometry.mergeVertices();
	                smooth_geometry.computeVertexNormals();
			smooth_geometry.computeBoundingBox();
			geometry = smooth_geometry;
	                ThreeDee.model_mesh = new THREE.Mesh(geometry, material);
		}
		else {
			ThreeDee.model_mesh = new THREE.Mesh( geometry, material );
		}
	}
	else {
		ThreeDee.model_mesh = new THREE.Mesh(geometry, material);
	}

	if (ThreeDee.object.type=='Group') { //obj
		if (!ThreeDee.mtl || ThreeDee.mtl.length==0) {
			//ThreeDee.object.children[0].material=ThreeDee.model_mesh.material;
			for (var i=0;i<ThreeDee.object.children.length;i++) {
				ThreeDee.object.children[i].material=ThreeDee.model_mesh.material;
			}
		}

		ThreeDee.object.position.set( 0, 0, 0 );
		ThreeDee.object.rotation.z = 90 * Math.PI/180;
		ThreeDee.object.rotation.x = -90 * Math.PI/180;
		ThreeDee.object.name = "object";

		ThreeDee.initial_rotation_x = ThreeDee.object.rotation.x;
		ThreeDee.initial_rotation_y = ThreeDee.object.rotation.y;
		ThreeDee.initial_rotation_z = ThreeDee.object.rotation.z;


		if (Detector.webgl) {
			for (var i=0;i<ThreeDee.object.children.length;i++) {
				ThreeDee.object.children[i].castShadow = true;
				ThreeDee.object.children[i].receiveShadow = true;
			}
		}
		ThreeDee.scene.add( ThreeDee.object );
		ThreeDee.group.add( ThreeDee.object );
	}
	else if (ThreeDee.object.type=='Scene') { //wrl

		ThreeDee.object.position.set( 0, 0, 0 );
		ThreeDee.object.rotation.z = 90 * Math.PI/180;
		ThreeDee.object.rotation.x = -90 * Math.PI/180;
		ThreeDee.object.name = "object";

		ThreeDee.initial_rotation_x = ThreeDee.object.rotation.x;
		ThreeDee.initial_rotation_y = ThreeDee.object.rotation.y;
		ThreeDee.initial_rotation_z = ThreeDee.object.rotation.z;


		if (Detector.webgl) {
			ThreeDee.object.traverse( function ( child ) {
				if ( child.isMesh ) {
					child.castShadow = true;
					child.receiveShadow = true;
				}
			} );
/*			ThreeDee.object.traverse( function( object ) { 
				if ( object.isMesh ) {
					object.castShadow = true;
				}
			} );*/

		}
		ThreeDee.scene.add( ThreeDee.object );
		ThreeDee.group.add( ThreeDee.object );
	}
	else {
//
//		var mesh_height = ThreeDee.boundingBox.max.z - ThreeDee.boundingBox.min.z;

//		ThreeDee.model_mesh.computeBoundingBox();
//		ThreeDee.boundingBox=ThreeDee.model_mesh.boundingBox;
//		var mesh_height = ThreeDee.boundingBox.max.y - ThreeDee.boundingBox.min.y;
		ThreeDee.model_mesh.position.set( 0, 0, 0 );




		ThreeDee.model_mesh.rotation.z = 90 * Math.PI/180;
		ThreeDee.model_mesh.rotation.x = -90 * Math.PI/180;
		ThreeDee.model_mesh.name = "model";

		ThreeDee.initial_rotation_x = ThreeDee.model_mesh.rotation.x;
		ThreeDee.initial_rotation_y = ThreeDee.model_mesh.rotation.y;
		ThreeDee.initial_rotation_z = ThreeDee.model_mesh.rotation.z;

		if (Detector.webgl) {
			ThreeDee.model_mesh.castShadow = true;
			ThreeDee.model_mesh.receiveShadow = true;
		}
		ThreeDee.scene.add( ThreeDee.model_mesh );
		ThreeDee.group.add( ThreeDee.model_mesh );

	}


	if (typeof(ThreeDee.loader.byteLength)!=='undefined') {
		var precision = 2;
		if (parseFloat((ThreeDee.loader.byteLength/1048576).toFixed(2))==0) precision = 3;
		jQuery('#ThreeDee-file-stats-size').html((ThreeDee.loader.byteLength/1048576).toFixed(precision));
	}

	if (typeof(ThreeDee.model_mesh)!=='undefined') {
		if (ThreeDee.object.type=='Scene') {
/*			ThreeDee.object.traverse( function( object ) { //todo count faces (expensive)
				if ( object.isMesh ) {
				}
			} );
*/
		}
		else {
			jQuery('#ThreeDee-file-stats-polygons').html(ThreeDee.model_mesh.geometry.faces.length);
		}
	}



}


/*
function ThreeDeeMakeShadow() {
	var model_dim = new Array();
	model_dim.x = ThreeDee.boundingBox.max.x - ThreeDee.boundingBox.min.x;
	model_dim.y = ThreeDee.boundingBox.max.y - ThreeDee.boundingBox.min.y;
	model_dim.z = ThreeDee.boundingBox.max.z - ThreeDee.boundingBox.min.z;

	var max_side = Math.max(model_dim.x, model_dim.y, model_dim.z)
//  	var bias = -0.001;
	var d = max_side;
//	if (d<30) bias = -0.0001;

  	var bias = -0.00001;
	directionalLight2.shadow.camera.left = directionalLight.shadow.camera.left = -d;
	directionalLight2.shadow.camera.right = directionalLight.shadow.camera.right = d;
	directionalLight2.shadow.camera.top = directionalLight.shadow.camera.top = d;
	directionalLight2.shadow.camera.bottom = directionalLight.shadow.camera.bottom = -d;
	directionalLight2.shadow.camera.near = directionalLight.shadow.camera.near = 1;
	directionalLight2.shadow.camera.far = directionalLight.shadow.camera.far = ThreeDee.camera.far;
	directionalLight2.shadow.mapSize.width = directionalLight.shadow.mapSize.width = 2048;
	directionalLight2.shadow.mapSize.height = directionalLight.shadow.mapSize.height = 2048;
	directionalLight2.shadow.bias = directionalLight.shadow.bias = bias;

	if (directionalLight.shadow.map) {
		directionalLight.shadow.map.dispose(); 
		directionalLight.shadow.map = null;
		directionalLight2.shadow.map.dispose(); 
		directionalLight2.shadow.map = null;
	}
}
*/


function ThreeDeeOnWindowResize() {

	var ThreeDee_canvas_width = jQuery('#ThreeDee-cv').width()
	var ThreeDee_canvas_height = jQuery('#ThreeDee-cv').height()
	ThreeDee.camera.aspect = ThreeDee_canvas_width / ThreeDee_canvas_height;
	ThreeDee.camera.updateProjectionMatrix();
	ThreeDee.renderer.setSize( ThreeDee_canvas_width, ThreeDee_canvas_height );


	ThreeDeeCanvasDetails();
}

function ThreeDeeCanvasDetails() {
	jQuery("#ThreeDee-file-loading").css({
		top: jQuery("#ThreeDee-cv").position().top+jQuery("#ThreeDee-cv").height()/2-jQuery("#ThreeDee-file-loading").height()/2,
		left: jQuery("#ThreeDee-cv").position().left + jQuery("#ThreeDee-cv").width()/2-jQuery("#ThreeDee-file-loading").width()/2
	}) ;
}


ThreeDee.frame_count=0;
function ThreeDeeAnimate() {
	window.requestAnimationFrame( ThreeDeeAnimate );
	ThreeDee.group.rotation.y += ( ThreeDee.targetRotation - ThreeDee.group.rotation.y ) * 0.05;
	ThreeDee.controls.update();

	if (typeof(ThreeDee.boundingBox.max)!=='undefined' && typeof(ThreeDee.spritey_x)!=='undefined') {
		var mesh_width = ThreeDee.boundingBox.max.x - ThreeDee.boundingBox.min.x;
		var mesh_length = ThreeDee.boundingBox.max.y - ThreeDee.boundingBox.min.y;
		var mesh_height = ThreeDee.boundingBox.max.z - ThreeDee.boundingBox.min.z;
		
		var fraction = ThreeDeeGetFraction(ThreeDee.font_size);
		ThreeDee.spritey_x.position.set(((fraction*(mesh_width/2))+10),0,0);
		ThreeDee.spritey_y.position.set(0,0,((fraction*(mesh_length/2))+10));
		ThreeDee.spritey_z.position.set(0,((fraction*(mesh_height/2))+10),0);
		var spritey_scale_x = 0.5 * ThreeDee.font_size * fraction;
		var spritey_scale_y = 0.25 * ThreeDee.font_size * fraction;
		var spritey_scale_z = 0.75 * ThreeDee.font_size * fraction;

	        ThreeDee.spritey_x.scale.set(spritey_scale_x, spritey_scale_y, spritey_scale_z);
	        ThreeDee.spritey_y.scale.set(spritey_scale_x, spritey_scale_y, spritey_scale_z);
	        ThreeDee.spritey_z.scale.set(spritey_scale_x, spritey_scale_y, spritey_scale_z);
	}

	if ( ThreeDee.mixer ) ThreeDee.mixer.update( ThreeDee.clock.getDelta() );
	ThreeDeeRender();

}

function ThreeDeeRender() {

	if (Detector.webgl && ThreeDee.ground_mirror=='on' && typeof(ThreeDee.groundMirror)!=='undefined')
		ThreeDee.groundMirror.render();
	ThreeDee.renderer.render( ThreeDee.scene, ThreeDee.camera );

}







function ThreeDeeSkinlessMeshesNumber(object) {
	var num=0;
	object.traverse( function ( child ) {
		if ( child.isMesh && !child.isSkinnedMesh) {
			if (ThreeDee.object.children.length == 1) {
				num++;
			}
		}
	})
//	if (num>1) todo warning?
	return num;
}

function ThreeDeeChangeModelColor(model_color) {
	if (!ThreeDee.model_mesh) return;

	ThreeDee.model_mesh.material.color.set(model_color);
	ThreeDee.model_mesh.material.color.offsetHSL(0, 0, -0.1);
	if (Detector.webgl) {
		var model_shininess = ThreeDeeGetCurrentShininess();
		ThreeDee.model_mesh.material.shininess = model_shininess.shininess;
		if (typeof(ThreeDee.model_mesh.material.specular)!=='undefined') {
			ThreeDee.model_mesh.material.specular.set(model_shininess.specular);
		}

		var model_transparency = ThreeDeeGetCurrentTransparency();
		ThreeDee.model_mesh.material.opacity = model_transparency;


		if (ThreeDee.object && ThreeDee.object.type=='Group' && !(ThreeDee.mtl && ThreeDee.mtl.length>0)) {
			for (var i=0;i<ThreeDee.object.children.length;i++) {
				ThreeDee.object.children[i].material=ThreeDee.model_mesh.material;

			}

		}
		else if (ThreeDee.object.type=='Scene') {

			ThreeDee.object.traverse( function ( child ) {
				if ( child.isMesh && !child.isSkinnedMesh && !child.material.map && !child.material.envMap) {
					if (ThreeDeeSkinlessMeshesNumber(ThreeDee.object)==1) {
						child.material = ThreeDee.model_mesh.material;
					}
					else {
						//todo option to set a color for each mesh
					}
				}
				else if (child.isSkinnedMesh) {
//					child.material.color.set(model_color); //todo make configurable
				}
//				else console.log(child);
			} );
		}
	}
	jQuery('#ThreeDee_model_color').val(model_color)

};


function ThreeDeeGetCurrentShininess() {

	switch(ThreeDee.model_shininess) {
		case 'plastic':
			var shininess = 150;
			var specular = 0x111111;
	        break;
		case 'wood':
			var shininess = 15;
			var specular = 0x111111;
	        break;
		case 'metal':
			var shininess = 500;
			var specular = 0xc9c9c9;
	        break;
		default:
			var shininess = 150;
			var specular = 0x111111;

	}
	return {shininess: shininess, specular: specular};
}

function ThreeDeeSetCurrentShininess(model_shininess) {
	switch(model_shininess) {
		case 'plastic':
			var shininess = 150;
	        break;
		case 'wood':
			var shininess = 15;
	        break;
		case 'metal':
			var shininess = 500;
	        break;
		default:
			var shininess = 150;
	}
	jQuery('#ThreeDee_model_shininess').val(model_shininess)
	ThreeDee.model_mesh.material.shininess=shininess;
}

function ThreeDeeGetCurrentTransparency() {

	switch(ThreeDee.model_transparency) {
		case 'opaque':
			var transparency = 1;
	        break;
		case 'resin':
			var transparency = 0.8;
	        break;
		case 'glass':
			var transparency = 0.6;
	        break;
		default:
			var transparency = 1;

	}
	return transparency;
}

function ThreeDeeSetCurrentTransparency(model_transparency) {

	switch(model_transparency) {
		case 'opaque':
			var transparency = 1;
	        break;
		case 'resin':
			var transparency = 0.8;
	        break;
		case 'glass':
			var transparency = 0.6;
	        break;
		default:
			var transparency = 1;

	}
	jQuery('#ThreeDee_model_transparency').val(model_transparency)
	ThreeDee.model_mesh.material.opacity=transparency;
}




function ThreeDeeDisplayUserDefinedProgressBar(show) {
	if(show) {
		jQuery('#ThreeDee-file-loading').show();
	}
	else {
		if (!ThreeDee.repairing) {
			jQuery('#ThreeDee-file-loading').hide();
		}
	}
}



function ThreeDeeNoEnter(e) {
    if (e.which == 13) {
        return false;
    }
}

THREE.STLLoader.prototype.parseASCII = function ( data ) {
		var geometry, length, normal, patternFace, patternNormal, patternVertex, result, text;
		geometry = new THREE.BufferGeometry();
		patternFace = /facet([\s\S]*?)endfacet/g;



		var vertices = new Array();
		var normals = new Array();

		while ( ( result = patternFace.exec( data ) ) !== null ) {

			text = result[ 0 ];
			patternNormal = /normal[\s]+([\-+]?[0-9]+\.?[0-9]*([eE][\-+]?[0-9]+)?)+[\s]+([\-+]?[0-9]*\.?[0-9]+([eE][\-+]?[0-9]+)?)+[\s]+([\-+]?[0-9]*\.?[0-9]+([eE][\-+]?[0-9]+)?)+/g;

			while ( ( result = patternNormal.exec( text ) ) !== null ) {

				normal = new THREE.Vector3( parseFloat( result[ 1 ] ), parseFloat( result[ 3 ] ), parseFloat( result[ 5 ] ) );

				normals.push(result[ 1 ]);
				normals.push(result[ 3 ]);
				normals.push(result[ 5 ]);
			}


			patternVertex = /vertex[\s]+([\-+]?[0-9]+\.?[0-9]*([eE][\-+]?[0-9]+)?)+[\s]+([\-+]?[0-9]*\.?[0-9]+([eE][\-+]?[0-9]+)?)+[\s]+([\-+]?[0-9]*\.?[0-9]+([eE][\-+]?[0-9]+)?)+/g;
			tetrahedron = new Array();
			var i = 1;

			while ( ( result = patternVertex.exec( text ) ) !== null ) {

				tetrahedron[i] = new Array();
				tetrahedron[i].push(parseFloat( result[ 1 ] ));
				tetrahedron[i].push(parseFloat( result[ 3 ] ));
				tetrahedron[i].push(parseFloat( result[ 5 ] ));

				vertices.push(parseFloat(result[ 1 ]));
				vertices.push(parseFloat(result[ 3 ]));
				vertices.push(parseFloat(result[ 5 ]));

				i++;
			}



		}

		var vertices32 = new Float32Array(vertices);
		var normals32 = new Float32Array(normals);
		geometry.addAttribute( 'position', new THREE.BufferAttribute( vertices32, 3 ) );
		geometry.addAttribute( 'normal', new THREE.BufferAttribute( normals32, 3 ) );

		geometry.computeBoundingBox();
		geometry.computeBoundingSphere();

		return geometry;
}
function ThreeDeeUniqid() {
    var ts=String(new Date().getTime()), i = 0, out = '';
    for(i=0;i<ts.length;i+=2) {        
       out+=Number(ts.substr(i, 2)).toString(36);    
    }
    return ('d'+out);
}


function ThreeDeeRotateModel(axis, degree) {

//console.log(axis, degree);
	if (isNaN(degree)) degree=0;

	if (axis=='x') {
		jQuery("#rotation_x").focus();
		if (ThreeDee.object.type=='Group' || ThreeDee.object.type=='Scene') {
			ThreeDee.object.rotation.x=ThreeDee.initial_rotation_x+ThreeDeeAngleToRadians(degree);
		}
		else ThreeDee.model_mesh.rotation.x=ThreeDee.initial_rotation_x+ThreeDeeAngleToRadians(degree);
	}
	if (axis=='y') {
		jQuery("#rotation_y").focus();

		if (ThreeDee.object.type=='Group' || ThreeDee.object.type=='Scene') {
			ThreeDee.object.rotation.y=ThreeDee.initial_rotation_y+ThreeDeeAngleToRadians(degree);
		}
		else ThreeDee.model_mesh.rotation.y=ThreeDee.initial_rotation_y+ThreeDeeAngleToRadians(degree);

	}
	if (axis=='z') {
		jQuery("#rotation_z").focus();
		if (ThreeDee.object.type=='Group' || ThreeDee.object.type=='Scene') {
			ThreeDee.object.rotation.z=ThreeDee.initial_rotation_z+ThreeDeeAngleToRadians(degree);
		}
		else ThreeDee.model_mesh.rotation.z=ThreeDee.initial_rotation_z+ThreeDeeAngleToRadians(degree);

	}


/*
	if (ThreeDee.object.type=='Scene') {
		//calculate new dimensions
		var bbox = new THREE.Box3().setFromObject(ThreeDee.object);
		var mesh_height = bbox.max.y - bbox.min.y;
		var mesh_width = bbox.max.x - bbox.min.x;
		var mesh_length = bbox.max.z - bbox.min.z;
		ThreeDee.object.position.y = ThreeDee.scene.getObjectByName('ground').position.y+(mesh_height/2)
//		ThreeDee.object.position.y = ThreeDee.scene.getObjectByName('ground').position.y
	}
*/
	        	
	if (ThreeDee.object.type=='Group' ) {
		//calculate new dimensions
		var bbox = new THREE.Box3().setFromObject(ThreeDee.object);
		var mesh_height = bbox.max.y - bbox.min.y;
		var mesh_width = bbox.max.x - bbox.min.x;
		var mesh_length = bbox.max.z - bbox.min.z;
		ThreeDee.object.position.y = ThreeDee.scene.getObjectByName('ground').position.y+(mesh_height/2)
	}
	else if (ThreeDee.object.type=='Scene') {
		//calculate new dimensions
		var bbox = new THREE.Box3().setFromObject(ThreeDee.scene);
		var mesh_height = bbox.max.y - bbox.min.y;
		var mesh_width = bbox.max.x - bbox.min.x;
		var mesh_length = bbox.max.z - bbox.min.z;
		ThreeDee.object.position.y = ThreeDee.scene.getObjectByName('ground').position.y
	}
	else {
		//calculate new dimensions
		var bbox = new THREE.Box3().setFromObject(ThreeDee.model_mesh);
		var mesh_height = bbox.max.y - bbox.min.y;
		var mesh_width = bbox.max.x - bbox.min.x;
		var mesh_length = bbox.max.z - bbox.min.z;
		ThreeDee.model_mesh.position.y = ThreeDee.scene.getObjectByName('ground').position.y+(mesh_height/2)
	}

	ThreeDee.axis.position.y = ThreeDee.scene.getObjectByName('ground').position.y+(mesh_height/2);

	ThreeDee.spritey_z.position.y = ThreeDee.scene.getObjectByName('ground').position.y+mesh_height+10;

	ThreeDee.spritey_x.position.y = ThreeDee.scene.getObjectByName('ground').position.y+(mesh_height/2);
	ThreeDee.spritey_x.position.x = ThreeDee.scene.getObjectByName('ground').position.x+(mesh_width/2)+10;

	ThreeDee.spritey_y.position.y = ThreeDee.scene.getObjectByName('ground').position.y+(mesh_height/2);
	ThreeDee.spritey_y.position.z = ThreeDee.scene.getObjectByName('ground').position.z+(mesh_length/2)+10;

	if (!isNaN(ThreeDee.offset_z) && ThreeDee.offset_z!=0) {
		if (ThreeDee.object.type=='Scene' || ThreeDee.object.type=='Group') {
			ThreeDee.object.position.y = ThreeDee.offset_z;
			jQuery('#z_offset').val(ThreeDee.object.position.y);
		}
		else {
			//ThreeDee.model_mesh.position.y = ThreeDee.offset_z;
			jQuery('#z_offset').val(ThreeDee.model_mesh.position.y);
		}
	}

}

function ThreeDeeAngleToRadians (angle) {
	return angle * (Math.PI / 180);
}
function ThreeDeeFitCameraToObject( camera, object, offset, controls ) {


	if (ThreeDee.object.type!='Scene') {
		var mesh_width = ThreeDee.boundingBox.max.x - ThreeDee.boundingBox.min.x;
		var mesh_length = ThreeDee.boundingBox.max.y - ThreeDee.boundingBox.min.y;
		var mesh_height = ThreeDee.boundingBox.max.z - ThreeDee.boundingBox.min.z;
		var max_side = Math.max(mesh_width, mesh_length, mesh_height)

	    	const plane_width = max_side * 100;
		var aspect = Math.max(mesh_width, mesh_length)/mesh_height;

		ThreeDee.camera.position.set(max_side*ThreeDee.resize_scale, max_side*ThreeDee.resize_scale, max_side*ThreeDee.resize_scale);
/*
		if (aspect>1) {
			ThreeDee.controls.target = new THREE.Vector3(0, 0, 0);
		}
		else {
			ThreeDee.controls.target = new THREE.Vector3(0, mesh_height/2, 0);
		}
*/
		ThreeDee.controls.target = new THREE.Vector3(0, 0, 0);

		ThreeDee.camera.far=plane_width*5;
		ThreeDee.camera.updateProjectionMatrix();
		return;
	}


	offset =  offset || 1.35;


	const boundingBox = new THREE.Box3().setFromObject(object);
	const center = boundingBox.getCenter(new THREE.Vector3());
	const size = boundingBox.getSize(new THREE.Vector3());


	const maxDim = Math.max( size.x, size.y, size.z );
	const fov = camera.fov * ( Math.PI / 180 );
    	const plane_width = maxDim * 100;


	cameraZ = Math.abs( maxDim / 2 * Math.tan( fov * 2 ) ); 
	r=camera.position.z*offset;
	cameraZ *= offset; 

	ThreeDee.scene.updateMatrixWorld(); 

        var objectWorldPosition = new THREE.Vector3(); 
        objectWorldPosition.setFromMatrixPosition( object.matrixWorld );
	const directionVector = camera.position.sub(objectWorldPosition);   
        const unitDirectionVector = directionVector.normalize(); 
        camera.position = unitDirectionVector.multiplyScalar(cameraZ); 
        camera.lookAt(objectWorldPosition); 


        const minZ = boundingBox.min.z;
        const cameraToFarEdge = ( minZ < 0 ) ? -minZ + cameraZ : cameraZ - minZ;
    


        camera.far = plane_width * 5;

        camera.updateProjectionMatrix();
    
        if ( controls ) {
    
            controls.target = center;
        
            //controls.maxDistance = cameraToFarEdge * 2;
	    if (typeof(controls.saveState)!='undefined')
	            controls.saveState();
    
        } else {
            camera.lookAt( center )
        }

    
}


function ThreeDeeLineLength(point1, point2) {

	return Math.sqrt( Math.pow((point1.x-point2.x),2) + Math.pow((point1.y-point2.y),2));

}

function ThreeDeeOffsetZ(z_offset) {

	if (ThreeDee.object.type=='Scene' || ThreeDee.object.type=='Group') {
		ThreeDee.object.position.y = z_offset;
	}
	else {
		ThreeDee.model_mesh.position.y = z_offset;
	}
}

function ThreeDeeChangeBackgroundColor(color) {
	if (typeof(ThreeDee.scene)=='undefined') return;
	color = color.replace('#', '0x');
	ThreeDee.scene.background = new THREE.Color(parseInt(color, 16));
}


function ThreeDeeToggleGround(color) {
	if (typeof(ThreeDee.scene)=='undefined') return;
	if (!ThreeDee.scene.getObjectByName('ground').visible) {
		ThreeDee.scene.getObjectByName('ground').visible = true;
	}
	else {
		ThreeDee.scene.getObjectByName('ground').visible = false;
	}
}

function ThreeDeeChangeGroundColor(color) {
	if (typeof(ThreeDee.scene)=='undefined') return;
	color = color.replace('#', '0x');
	ThreeDee.scene.getObjectByName('ground').material.color = new THREE.Color(parseInt(color, 16));
}

function ThreeDeeChangeFogColor(color) {
	if (typeof(ThreeDee.scene)=='undefined') return;
	color = color.replace('#', '0x');
	ThreeDee.scene.fog.color = new THREE.Color(parseInt(color, 16));
}

function ThreeDeeToggleGrid() {
	if (typeof(ThreeDee.scene)=='undefined') return;
	if (!ThreeDee.scene.getObjectByName('grid').visible) {
		ThreeDee.scene.getObjectByName('grid').visible = true;
	}
	else {
		ThreeDee.scene.getObjectByName('grid').visible = false;
	}
}

function ThreeDeeToggleMirror() {
	if (typeof(ThreeDee.scene)=='undefined') return;
	if (!ThreeDee.scene.getObjectByName('mirror').visible) {
		ThreeDee.scene.getObjectByName('ground').material.transparent = true;
		ThreeDee.scene.getObjectByName('ground').material.opacity = 0.6;
		ThreeDee.scene.getObjectByName('ground').material.shininess = 2500;
		ThreeDee.scene.getObjectByName('mirror').visible = true;
	}
	else {
		ThreeDee.scene.getObjectByName('ground').material.transparent = false;
		ThreeDee.scene.getObjectByName('ground').material.opacity = 1;
		ThreeDee.scene.getObjectByName('ground').material.shininess = 30;
		ThreeDee.scene.getObjectByName('mirror').visible = false;

	}
}
function ThreeDeeToggleShadow() {
	if (typeof(ThreeDee.scene)=='undefined') return;
	if (!ThreeDee.renderer.shadowMap.enabled) {
		ThreeDee.renderer.shadowMap.enabled = true;
	}
	else {
		ThreeDee.renderer.shadowMap.enabled = false;
	}
}
function ThreeDeeToggleRotation(checked) {
//console.log(checked);
	if (typeof(ThreeDee.scene)=='undefined') return;
	if (!ThreeDee.controls.autoRotate && checked) {
		ThreeDee.controls.autoRotate = true;
		ThreeDee.controls.autoRotateSpeed = 6;
	}
	else if (ThreeDee.controls.autoRotate && !checked) {
		ThreeDee.controls.autoRotate = false;
	}

}
//ThreeDeeChangeGridColor
function ThreeDeeChangeGridColor(color) {
	if (typeof(ThreeDee.scene)=='undefined') return;
	color = color.replace('#', '0x');
	ThreeDee.scene.getObjectByName('grid').material.color = new THREE.Color(parseInt(color, 16));
}

function ThreeDeeToggleFog() {
	if (typeof(ThreeDee.scene)=='undefined') return;
	if (ThreeDee.scene.fog.far==Infinity) {
		ThreeDee.scene.fog.far=ThreeDee.scene.fog.oldfar
	}
	else {
		ThreeDee.scene.fog.far=Infinity
	}
}


ThreeDee.tab_warning_shown = false;
