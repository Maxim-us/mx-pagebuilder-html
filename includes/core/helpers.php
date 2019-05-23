<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/*
* Require class for admin panel
*/
function mxmph_require_class_file_admin( $file ) {

	require_once MXMPH_PLUGIN_ABS_PATH . 'includes/admin/classes/' . $file;

}


/*
* Require class for frontend panel
*/
function mxmph_require_class_file_frontend( $file ) {

	require_once MXMPH_PLUGIN_ABS_PATH . 'includes/frontend/classes/' . $file;

}

/*
* Require a Model
*/
function mxmph_use_model( $model ) {

	require_once MXMPH_PLUGIN_ABS_PATH . 'includes/admin/models/' . $model . '.php';

}

/*
* Check if builder is enable on current page
*/
function mxmph_builder_enable() {

	$post_id = $_GET['post'];

	$get_builder_switcher_array_option = get_option( 'mx_builder_switcher_post_array' );

	$builder_switcher_option = maybe_unserialize( $get_builder_switcher_array_option );

	$builder_enable = false;

	if( $builder_switcher_option !== false ) {

		foreach ( $builder_switcher_option as $key => $value ) {

			if( intval( $post_id ) == intval( $value ) ) {

				$builder_enable = true;

			}
			
		}

	}

	return $builder_enable;

}

/*
* Check if classic editor is enable
*/
function mxmph_classic_editor_is_anable() {

	$active_plugins = get_option( 'active_plugins' );

	$array_of_active_plugins = maybe_unserialize( $active_plugins );

	$classic_editor_enable = false;

	foreach ( $array_of_active_plugins as $key => $value) {

		if( $value == 'classic-editor/classic-editor.php' ) {

			$classic_editor_enable = true;

		}

	}

	return $classic_editor_enable;

}

/*
* The notification about the require for a classic editor
*/
function mxmph_classic_editor_notification() {

	add_action( 'admin_notices', function() {

		?>
	    <div class="notice notice-warning is-dismissible">

	        <p>Plugin "MX PageBuilder HTML" require the <a href="https://wordpress.org/plugins/classic-editor/" target="_blank">Classic Editor</a></p> 
	        <p>
	        	<a href="<?php echo admin_url(); ?>plugin-install.php?s=Classic+Editor&tab=search&type=term">Install</a> Classic Editor now.
	        </p>       
	    </div>
	    <?php

	} );

}