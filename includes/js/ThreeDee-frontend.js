/**
 * @author Sergey Burkov, http://www.wp3dprinting.com
 * @copyright 2017
 */

ThreeDee.aabb = new Array();
ThreeDee.resize_scale = 1;
ThreeDee.default_scale = 100;
ThreeDee.cookie_expire = parseInt(ThreeDee.cookie_expire);
ThreeDee.boundingBox=[];
ThreeDee.initial_rotation_x = 0;
ThreeDee.initial_rotation_y = 0;
ThreeDee.initial_rotation_z = 0;
ThreeDee.current_model = '';
ThreeDee.current_mtl = '';
ThreeDee.font_size = 25;
ThreeDee.wireframe = false;
ThreeDee.vec = new THREE.Vector3();
ThreeDee.product_offset_z = false;

jQuery(document).ready(function(){

	if (!document.getElementById('ThreeDee-cv')) return;
	if (jQuery('.ThreeDee-canvas').length>1) {
		alert(ThreeDee.text_multiple);
	}
	if (jQuery('#ThreeDee_view3d_button').val()=='on') return;
	ThreeDeeInit3D();

})

function ThreeDeeInit3D() {

	jQuery('.ThreeDee-view3d-button-wrapper').hide();
	jQuery('.ThreeDee-main-image').hide();
	jQuery('#ThreeDee-viewer').show();

	//workaround for shortcode pages
	ThreeDee.model_url = jQuery('#ThreeDee_model_url').val();
	ThreeDee.model_mtl = jQuery('#ThreeDee_model_mtl').val();
	ThreeDee.model_color = jQuery('#ThreeDee_model_color').val().replace('#', '0x');
	ThreeDee.model_transparency = jQuery('#ThreeDee_model_transparency').val();
	ThreeDee.model_shininess = jQuery('#ThreeDee_model_shininess').val();
	ThreeDee.model_rotation_x = jQuery('#ThreeDee_model_rotation_x').val();
	ThreeDee.model_rotation_y = jQuery('#ThreeDee_model_rotation_y').val();
	ThreeDee.model_rotation_z = jQuery('#ThreeDee_model_rotation_z').val();
	ThreeDee.stored_position_x = parseFloat(jQuery('#ThreeDee_camera_position_x').val());
	ThreeDee.stored_position_y = parseFloat(jQuery('#ThreeDee_camera_position_y').val());
	ThreeDee.stored_position_z = parseFloat(jQuery('#ThreeDee_camera_position_z').val());
	ThreeDee.stored_lookat_x = parseFloat(jQuery('#ThreeDee_camera_lookat_x').val());
	ThreeDee.stored_lookat_y = parseFloat(jQuery('#ThreeDee_camera_lookat_y').val());
	ThreeDee.stored_lookat_z = parseFloat(jQuery('#ThreeDee_camera_lookat_z').val());
	ThreeDee.stored_controls_target_x = parseFloat(jQuery('#ThreeDee_controls_target_x').val());
	ThreeDee.stored_controls_target_y = parseFloat(jQuery('#ThreeDee_controls_target_y').val());
	ThreeDee.stored_controls_target_z = parseFloat(jQuery('#ThreeDee_controls_target_z').val());
	ThreeDee.offset_z = parseFloat(jQuery('#ThreeDee_offset_z').val());
	if (jQuery('#ThreeDee_show_light_source1').val().length>1) ThreeDee.show_light_source1 = jQuery('#ThreeDee_show_light_source1').val();
	if (jQuery('#ThreeDee_show_light_source2').val().length>1) ThreeDee.show_light_source2 = jQuery('#ThreeDee_show_light_source2').val();
	if (jQuery('#ThreeDee_show_light_source3').val().length>1) ThreeDee.show_light_source3 = jQuery('#ThreeDee_show_light_source3').val();
	if (jQuery('#ThreeDee_show_light_source4').val().length>1) ThreeDee.show_light_source4 = jQuery('#ThreeDee_show_light_source4').val();
	if (jQuery('#ThreeDee_show_light_source5').val().length>1) ThreeDee.show_light_source5 = jQuery('#ThreeDee_show_light_source5').val();
	if (jQuery('#ThreeDee_show_light_source6').val().length>1) ThreeDee.show_light_source6 = jQuery('#ThreeDee_show_light_source6').val();
	if (jQuery('#ThreeDee_show_light_source7').val().length>1) ThreeDee.show_light_source7 = jQuery('#ThreeDee_show_light_source7').val();
	if (jQuery('#ThreeDee_show_light_source8').val().length>1) ThreeDee.show_light_source8 = jQuery('#ThreeDee_show_light_source8').val();
	if (jQuery('#ThreeDee_show_light_source9').val().length>1) ThreeDee.show_light_source9 = jQuery('#ThreeDee_show_light_source9').val();
	

	if (jQuery('#ThreeDee_show_grid').val().length>1) ThreeDee.show_grid = jQuery('#ThreeDee_show_grid').val();
	if (jQuery('#ThreeDee_grid_color').val().length>1) ThreeDee.grid_color = jQuery('#ThreeDee_grid_color').val().replace('#', '0x');
	if (jQuery('#ThreeDee_show_ground').val().length>1) ThreeDee.show_ground = jQuery('#ThreeDee_show_ground').val();
	if (jQuery('#ThreeDee_ground_color').val().length>1) ThreeDee.ground_color = jQuery('#ThreeDee_ground_color').val().replace('#', '0x');
	if (jQuery('#ThreeDee_show_shadow').val().length>1) ThreeDee.show_shadow = jQuery('#ThreeDee_show_shadow').val();
	if (jQuery('#ThreeDee_ground_mirror').val().length>1) ThreeDee.ground_mirror = jQuery('#ThreeDee_ground_mirror').val();
	if (jQuery('#ThreeDee_auto_rotation').val().length>1) ThreeDee.auto_rotation = jQuery('#ThreeDee_auto_rotation').val();



	ThreeDee.upload_url = jQuery('#ThreeDee_upload_url').val();

	window.ThreeDee_canvas = document.getElementById('ThreeDee-cv');

	window.ThreeDee_canvas.addEventListener('dblclick', function(){ 
		ThreeDeeToggleFullScreen();
	});

	ThreeDeeCanvasDetails();

	var logoTimerID = 0;

	ThreeDee.targetRotation = 0;

	var model_type=ThreeDee.model_url.split('.').pop().toLowerCase();
	ThreeDeeViewerInit(ThreeDee.model_url, ThreeDee.model_mtl, model_type);

	ThreeDeeAnimate();
}





function ThreeDeeViewerInit(model, mtl, ext) {
	var ThreeDee_canvas = document.getElementById('ThreeDee-cv');
	var ThreeDee_canvas_width = jQuery('#ThreeDee-cv').width()
	var ThreeDee_canvas_height = jQuery('#ThreeDee-cv').height()

	ThreeDee.current_model = model;
	ThreeDee.current_mtl = mtl;

	ThreeDee.mtl=mtl;

	//3D Renderer
	ThreeDee.renderer = Detector.webgl? new THREE.WebGLRenderer({ antialias: true, canvas: ThreeDee_canvas, preserveDrawingBuffer: true }): new THREE.CanvasRenderer({canvas: ThreeDee_canvas});
	ThreeDee.renderer.setClearColor( parseInt(ThreeDee.background1, 16) );
	ThreeDee.renderer.setPixelRatio( window.devicePixelRatio );
	ThreeDee.renderer.setSize( ThreeDee_canvas_width, ThreeDee_canvas_height );


	if (Detector.webgl) {

		ThreeDee.renderer.gammaInput = true;
		ThreeDee.renderer.gammaOutput = true;
		ThreeDee.renderer.shadowMap.enabled = true;
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

	if (jQuery('#ThreeDee_background1').val().length>0) {
		ThreeDee.scene.background = new THREE.Color(parseInt(jQuery('#ThreeDee_background1').val().replace('#', '0x'), 16));
	}


	ThreeDee.clock = new THREE.Clock();
	//ThreeDee.scene.fog = new THREE.Fog( 0x72645b, 1, 300 );

	//Group
	if (ThreeDee.group) ThreeDee.scene.remove(ThreeDee.group);
	ThreeDee.group = new THREE.Group();
	ThreeDee.group.position.set( 0, 0, 0 )
	ThreeDee.group.name = "group";
	ThreeDee.scene.add( ThreeDee.group );


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
	if (ThreeDee.auto_rotation=='on' && !(ThreeDee.mobile_no_animation=='on' && ThreeDeeMobileCheck())) {
		ThreeDee.controls.autoRotate = true; 
	}

	ThreeDee.controls.addEventListener( 'start', function() {
		ThreeDee.controls.autoRotate = false;
	});

	if (ThreeDee.enable_controls!='on') {
		ThreeDee.controls.enabled = false; 
	}


	//Initialize with supported ObjectLoaders https://threejs.org/docs/#api/en/loaders/ObjectLoader
	if (ext=='stl') {
		ThreeDee.loader = new THREE.STLLoader();
	}

	else if (ext=='obj') {
		ThreeDee.loader = new THREE.OBJLoader();
	}
	else if (ext=='wrl') {
		ThreeDee.loader = new THREE.VRMLLoader();
	}
	else if (ext=='gltf' || ext=='glb') {
		THREE.DRACOLoader.setDecoderPath( ThreeDee.plugin_url+'includes/ext/threejs/js/libs/draco/gltf/' );
		ThreeDee.loader = new THREE.GLTFLoader();
		ThreeDee.loader.setDRACOLoader( new THREE.DRACOLoader() );
	}

	if (model.length>0) {
		ThreeDeeDisplayUserDefinedProgressBar(true);
		var mtlLoader = new THREE.MTLLoader();
		mtlLoader.setPath( ThreeDee.upload_url );

		if (ext=='obj' && mtl && mtl.length>0) {

			mtlLoader.load( mtl, function( materials ) {
				materials.preload();
				//var objLoader = new THREE.OBJLoader();
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
			} );
		}
	}

	window.addEventListener( 'resize', ThreeDeeOnWindowResize, false );
}

function ThreeDeeMobileCheck () {
	var check = false;
	(function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
	return check;
};

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
        
            controls.maxDistance = cameraToFarEdge * 2;
	    if (typeof(controls.saveState)!='undefined')
	            controls.saveState();
    
        } else {
            camera.lookAt( center )
        }

    
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


	//Model
	ThreeDeeCreateModel(object, geometry, material, ThreeDee.shading);
	ThreeDeeChangeModelColor(ThreeDee.model_color);


	if ((object.type=='Group'&& object.children.length>1) || object.type=='Scene') {
		new THREE.Box3().setFromObject( ThreeDee.object ).getCenter( ThreeDee.object.position ).multiplyScalar( - 1 );
	    	ThreeDee.boundingBox = new THREE.Box3().setFromObject(object);
	}
	else {
		geometry.center();
	}


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
//mesh_diagonal
	var canvas_diagonal = Math.sqrt(canvas_width * canvas_width + canvas_height * canvas_height);
	var model_dim = new Array();
	model_dim.x = ThreeDee.boundingBox.max.x - ThreeDee.boundingBox.min.x;
	model_dim.y = ThreeDee.boundingBox.max.y - ThreeDee.boundingBox.min.y;
	model_dim.z = ThreeDee.boundingBox.max.z - ThreeDee.boundingBox.min.z;

	var max_side = Math.max(mesh_width, mesh_length, mesh_height)
//	var max_side_xy = Math.max(mesh_width, mesh_length)

//	var axis_length = Math.max(mesh_width, mesh_length);
///	var axis_width = Math.min(mesh_width, mesh_length);

//	console.log(Math.max(canvas_width , canvas_height));
//	var font_size = (Math.max(canvas_width , canvas_height)/30);	
//console.log(font_size);

	var plane_width = max_side * 100;
	var grid_step = plane_width/100;


	if (ThreeDee.show_fog=='on') {
		ThreeDee.scene.background = new THREE.Color( parseInt(ThreeDee.fog_color, 16) );
		ThreeDee.scene.fog = new THREE.Fog( parseInt(ThreeDee.fog_color, 16), max_side*3, plane_width/2 ); 
	}
//0xa0a0a0




	//Camera
	//todo if remember camera pos
	if (ThreeDee.stored_position_x!=0 || ThreeDee.stored_position_y!=0 || ThreeDee.stored_position_z!=0) {//manually set 
	        var objectWorldPosition = new THREE.Vector3(ThreeDee.stored_lookat_x, ThreeDee.stored_lookat_y, ThreeDee.stored_lookat_z); //params?
	        ThreeDee.camera.lookAt(objectWorldPosition); 

		ThreeDee.camera.position.set(ThreeDee.stored_position_x, ThreeDee.stored_position_y, ThreeDee.stored_position_z);

		ThreeDee.controls.target = new THREE.Vector3(ThreeDee.stored_controls_target_x, ThreeDee.stored_controls_target_y, ThreeDee.stored_controls_target_z); 
//console.log(plane_width);
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
		if (ThreeDee.ground_mirror=='on') {
			var plane_shininess = 2500;
			var plane_transparent = true;
			var plane_opacity = 0.6;
		}
		else {
			var plane_shininess = 30;
			var plane_transparent = false;
			var plane_opacity = 1;
		}
		if (ThreeDeeMobileCheck()) {
			var plane_material = new THREE.MeshLambertMaterial( { color: parseInt(ThreeDee.ground_color, 16), wireframe: false, flatShading:true, precision: 'mediump' } );
		}
		else {
			var plane_material = new THREE.MeshPhongMaterial ( { color: parseInt(ThreeDee.ground_color, 16), transparent:plane_transparent, opacity:plane_opacity, shininess: plane_shininess, precision: 'mediump' } ) 
		}
		plane = new THREE.Mesh(
			new THREE.PlaneBufferGeometry( plane_width, plane_width ),
			new THREE.MeshPhongMaterial ( { color: parseInt(ThreeDee.ground_color, 16), transparent:plane_transparent, opacity:plane_opacity, shininess: plane_shininess } ) 
		);
		if (ThreeDee.show_ground!='on') {
			plane.visible = false;
		}

		plane.rotation.x = -Math.PI/2;
		plane.position.y = ThreeDee.boundingBox.min.z;

		plane.receiveShadow = true;
		plane.castShadow = true;
		plane.name = 'ground';
		ThreeDee.scene.add( plane );
		if (ThreeDee.ground_mirror=='on') {
			var planeGeo = new THREE.PlaneBufferGeometry( plane_width, plane_width );
			ThreeDee.groundMirror = new THREE.Mirror( ThreeDee.renderer, ThreeDee.camera, { clipBias: 0.003, textureWidth: canvas_width, textureHeight: canvas_height, color: 0xaaaaaa } );
			var mirrorMesh = new THREE.Mesh( planeGeo, ThreeDee.groundMirror.material );
			mirrorMesh.position.y = ThreeDee.boundingBox.min.z-1;
			mirrorMesh.add( ThreeDee.groundMirror );
			mirrorMesh.rotateX( - Math.PI / 2 );
			mirrorMesh.name = 'mirror';
			ThreeDee.scene.add( mirrorMesh );
		}

	}

	if (ThreeDee.object.type=='Scene') {
		//calculate new dimensions
		var bbox = new THREE.Box3().setFromObject(ThreeDee.object);
		var mesh_height = bbox.max.y - bbox.min.y;
		var mesh_width = bbox.max.x - bbox.min.x;
		var mesh_length = bbox.max.z - bbox.min.z;
		ThreeDee.object.position.y = ThreeDee.scene.getObjectByName('ground').position.y
	}
//	else {
//		ThreeDee.model_mesh.position.y = ThreeDee.scene.getObjectByName('ground').position.y ;
//	}

	//Grid
	if (ThreeDee.show_grid=='on' && ThreeDee.grid_color.length>0) {
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

	if (jQuery("#ThreeDee_model_rotation_x").val()!=0)
		ThreeDeeRotateModel('x', jQuery("#ThreeDee_model_rotation_x").val());
	if (jQuery("#ThreeDee_model_rotation_y").val()!=0)
		ThreeDeeRotateModel('y', jQuery("#ThreeDee_model_rotation_y").val());
	if (jQuery("#ThreeDee_model_rotation_z").val()!=0)
		ThreeDeeRotateModel('z', jQuery("#ThreeDee_model_rotation_z").val());

	var variation_id = jQuery('input[name=variation_id]').val();

	if (variation_id) {
		//ThreeDeeLoadVariationOptions(variation_id);
	}

	if (!isNaN(ThreeDee.offset_z) && parseInt(ThreeDee.offset_z)!=0) {
		if (ThreeDee.object.type=='Scene' || ThreeDee.object.type=='Group') {
			ThreeDee.object.position.y = ThreeDee.offset_z;
		}
		else {
			//ThreeDee.model_mesh.position.y = ThreeDee.offset_z;
		}
	}


}

function ThreeDeeCreateMaterial(model_shading) {

	var color = new THREE.Color( parseInt(ThreeDee.model_color, 16) );
	var shininess = ThreeDeeGetCurrentShininess(null);
	var transparency = ThreeDeeGetCurrentTransparency(null);

	color.offsetHSL(0, 0, -0.1);
//console.log(ThreeDeeMobileCheck());
	if (Detector.webgl && !ThreeDeeMobileCheck()) {
//	if (Detector.webgl) {
		if (model_shading=='smooth') {
			var flat_shading = false;
		}
		else {
			var flat_shading = true;
		}


		var material = new THREE.MeshPhongMaterial( { color: color, specular: shininess.specular, shininess: shininess.shininess, transparent:true, opacity:transparency, wireframe:false, flatShading:flat_shading, precision: 'mediump' } );
	}
	else {

		var material = new THREE.MeshLambertMaterial( { color: color, transparent:true, opacity:transparency, wireframe: false, flatShading:true, precision: 'mediump'} );
	}
	return material;
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
	if (Detector.webgl && ThreeDee.show_shadow=='on') {
		directionalLight.castShadow = true;
		ThreeDeeMakeShadow(directionalLight);
	}
	ThreeDee.scene.add( directionalLight );
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

			ThreeDee.object.traverse( function ( child ) {
				if ( child.isMesh ) {
					child.castShadow = true;
					child.receiveShadow = true;
				}
			} );
		ThreeDee.scene.add( ThreeDee.object );
		ThreeDee.group.add( ThreeDee.object );
	}
	else if (ThreeDee.object.type=='Scene') { //wrl, gltf

		ThreeDee.object.position.set( 0, 0, 0 );

		ThreeDee.object.rotation.z = 90 * Math.PI/180;
		ThreeDee.object.rotation.x = -90 * Math.PI/180;
		ThreeDee.object.name = "object";

		ThreeDee.initial_rotation_x = ThreeDee.object.rotation.x;
		ThreeDee.initial_rotation_y = ThreeDee.object.rotation.y;
		ThreeDee.initial_rotation_z = ThreeDee.object.rotation.z;

		if (Detector.webgl) {
			ThreeDee.object.traverse( function ( child ) {
//console.log(child.type);
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
//		ThreeDee.model_mesh.position.set( 0, (ThreeDee.boundingBox.max.y - ThreeDee.boundingBox.min.y)/2, 0 );
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




}

function ThreeDeeMakeLight(idx) {
	var intensity = ThreeDeeGetLightIntensity();
	var directionalLight = new THREE.DirectionalLight( 0xffffff, intensity );
	directionalLight.name = "light"+idx;
	return directionalLight;
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

function ThreeDeeOnWindowResize() {

	if (jQuery('div.product').length>0) { //product page
		var ThreeDee_canvas_width = jQuery('#ThreeDee-viewer').parent().width()
		var ThreeDee_canvas_height = jQuery('#ThreeDee-viewer').width()
	}
	else {
		var ThreeDee_canvas_width = jQuery('#ThreeDee-viewer').width()
		var ThreeDee_canvas_height = jQuery('#ThreeDee-viewer').height()
	}

	if (THREEx.FullScreen.activated()) {
		ThreeDee_canvas_width = window.innerWidth;
		ThreeDee_canvas_height = window.innerHeight;
	}
	ThreeDee.camera.aspect = ThreeDee_canvas_width / ThreeDee_canvas_height;
	ThreeDee.camera.updateProjectionMatrix();
	ThreeDee.renderer.setSize( ThreeDee_canvas_width, ThreeDee_canvas_height );


	ThreeDeeCanvasDetails();
}

function ThreeDeeCanvasDetails() {
/*	jQuery("#ThreeDee-file-loading").css({
		top: jQuery("#ThreeDee-cv").position().top+jQuery("#ThreeDee-cv").height()/2-jQuery("#ThreeDee-file-loading").height()/2,
		left: jQuery("#ThreeDee-cv").position().left + jQuery("#ThreeDee-cv").width()/2-jQuery("#ThreeDee-file-loading").width()/2
	}) ;
*/
}

function ThreeDeeAnimate() {
	window.requestAnimationFrame( ThreeDeeAnimate );
	ThreeDee.group.rotation.y += ( ThreeDee.targetRotation - ThreeDee.group.rotation.y ) * 0.05;
	ThreeDee.controls.update();

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
	model_color = model_color.replace('#', '0x');
	ThreeDee.model_mesh.material.color.set(parseInt(model_color, 16));
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

};

function ThreeDeeGetCurrentShininess(shininess) {
	if (!shininess) shininess = ThreeDee.model_shininess;
	switch(shininess) {
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

function ThreeDeeGetCurrentTransparency(transparency) {
	if (!transparency) transparency = ThreeDee.model_transparency;
	switch(transparency) {
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

function ThreeDeeRotateModel(axis, degree) {
//console.log(axis, degree);
	if (isNaN(degree)) degree=0;

	if (axis=='x') {
		jQuery("#rotation_x").focus();
		ThreeDee.model_mesh.rotation.x=ThreeDee.initial_rotation_x+ThreeDeeAngleToRadians(degree);

		if (ThreeDee.object.type=='Group' || ThreeDee.object.type=='Scene') {
			ThreeDee.object.rotation.x=ThreeDee.initial_rotation_x+ThreeDeeAngleToRadians(degree);
		}
	}
	if (axis=='y') {
		jQuery("#rotation_y").focus();
		ThreeDee.model_mesh.rotation.y=ThreeDee.initial_rotation_y+ThreeDeeAngleToRadians(degree);
		if (ThreeDee.object.type=='Group' || ThreeDee.object.type=='Scene') {
			ThreeDee.object.rotation.y=ThreeDee.initial_rotation_y+ThreeDeeAngleToRadians(degree);
		}
	}
	if (axis=='z') {
		jQuery("#rotation_z").focus();
		ThreeDee.model_mesh.rotation.z=ThreeDee.initial_rotation_z+ThreeDeeAngleToRadians(degree);
		if (ThreeDee.object.type=='Group' || ThreeDee.object.type=='Scene') {
			ThreeDee.object.rotation.z=ThreeDee.initial_rotation_z+ThreeDeeAngleToRadians(degree);
		}
	}

	if (typeof(ThreeDee.scene.getObjectByName('ground'))!=='undefined' || ThreeDee.object.type=='Scene') {
		if (ThreeDee.object.type=='Group') {
			//calculate new dimensions
			var bbox = new THREE.Box3().setFromObject(ThreeDee.object);
			var mesh_height = bbox.max.y - bbox.min.y;
			var mesh_width = bbox.max.x - bbox.min.x;
			var mesh_length = bbox.max.z - bbox.min.z;
			ThreeDee.object.position.y = ThreeDee.scene.getObjectByName('ground').position.y+(mesh_height/2)
		}
		else if (ThreeDee.object.type=='Scene') {
			//calculate new dimensions
			var bbox = new THREE.Box3().setFromObject(ThreeDee.object);
			var mesh_height = bbox.max.y - bbox.min.y;
			var mesh_width = bbox.max.x - bbox.min.x;
			var mesh_length = bbox.max.z - bbox.min.z;
//			ThreeDee.object.position.y = ThreeDee.scene.getObjectByName('ground').position.y
		}
		else {
			//calculate new dimensions
			var bbox = new THREE.Box3().setFromObject(ThreeDee.model_mesh);
			var mesh_height = bbox.max.y - bbox.min.y;
			var mesh_width = bbox.max.x - bbox.min.x;
			var mesh_length = bbox.max.z - bbox.min.z;
			ThreeDee.model_mesh.position.y = ThreeDee.scene.getObjectByName('ground').position.y+(mesh_height/2)
		}
	}

	if (!isNaN(ThreeDee.offset_z) && parseInt(ThreeDee.offset_z)!=0) {
		if (ThreeDee.object.type=='Scene' || ThreeDee.object.type=='Group') {
			ThreeDee.object.position.y = ThreeDee.offset_z;
		}
		else {
			//ThreeDee.model_mesh.position.y = ThreeDee.offset_z;
		}
	}

}

function ThreeDeeAngleToRadians (angle) {
	return angle * (Math.PI / 180);
}

function ThreeDeeGoScreen() {
	if (!THREEx.FullScreen.available()) {
		alert(ThreeDee.text_not_available);
	}
	THREEx.FullScreen.request(document.getElementById('ThreeDee-cv'));
}

function ThreeDeeToggleFullScreen() {
	if (THREEx.FullScreen.activated()) {
		THREEx.FullScreen.cancel();
	}
	else {
		if (!THREEx.FullScreen.available()) {
			alert(ThreeDee.text_not_available);
			return;
		}
//		THREEx.FullScreen.request(jQuery(this).closest('.ThreeDee-viewer').get(0));
		THREEx.FullScreen.request(jQuery('#ThreeDee-viewer').get(0));
	}
}

function ThreeDeeToggleWireframe() {
	if (Detector.webgl) {

		if (ThreeDee.model_mesh && typeof(ThreeDee.model_mesh.material)!=='undefined') {
			ThreeDee.model_mesh.material.wireframe = ThreeDee.model_mesh.material.wireframe;
		}

		if (ThreeDee.object && ThreeDee.object.type=='Group') {
			for (var i=0;i<ThreeDee.object.children.length;i++) {
				ThreeDee.object.children[i].material.wireframe = !ThreeDee.object.children[i].material.wireframe;
			}
		}
		else if (ThreeDee.object && ThreeDee.object.type=='Scene') { 
			ThreeDee.object.traverse( function ( child ) {
				if ( child.isMesh || child.isSkinnedMesh ) {
					child.material.wireframe = !ThreeDee.wireframe;
//					child.material.wireframe = !child.material.wireframe;
				}
			} );
		}
		ThreeDee.wireframe = !ThreeDee.wireframe;
	}
}

function ThreeDeeZoomIn() {
	var offset = 0.8;
	ThreeDee.camera.position.set(ThreeDee.camera.position.x*offset, ThreeDee.camera.position.y*offset, ThreeDee.camera.position.z*offset);
}

function ThreeDeeZoomOut() {
	var offset = 1.2;
	ThreeDee.camera.position.set(ThreeDee.camera.position.x*offset, ThreeDee.camera.position.y*offset, ThreeDee.camera.position.z*offset);
}

function ThreeDeeToggleRotation() {
	ThreeDee.controls.autoRotate = !ThreeDee.controls.autoRotate;
}

function ThreeDeeScreenshot() {
	var file_name = ThreeDee.model_url.split('/').reverse()[0]+'.png';
	document.getElementById("ThreeDee-screenshot").download = file_name;
	document.getElementById("ThreeDee-screenshot").href = document.getElementById("ThreeDee-cv").toDataURL("image/png").replace(/^data:image\/[^;]/, 'data:application/octet-stream');
}