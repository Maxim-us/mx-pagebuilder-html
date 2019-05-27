<?php
/*
Plugin Name: MX PageBuilder HTML
Plugin URI: https://github.com/Maxim-us/mx-pagebuilder-html
Description: This plugin will help you create fully editable content on your website.
Author: Marko Maksym
Version: 1.0
Author URI: https://github.com/Maxim-us
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/*
* Unique string - MXMPH
*/

/*
* Define MXMPH_PLUGIN_PATH
*
* E:\OpenServer\domains\my-domain.com\wp-content\plugins\mx-pagebuilder-html\mx-pagebuilder-html.php
*/
if ( ! defined( 'MXMPH_PLUGIN_PATH' ) ) {

	define( 'MXMPH_PLUGIN_PATH', __FILE__ );

}

/*
* Define MXMPH_PLUGIN_URL
*
* Return http://my-domain.com/wp-content/plugins/mx-pagebuilder-html/
*/
if ( ! defined( 'MXMPH_PLUGIN_URL' ) ) {

	define( 'MXMPH_PLUGIN_URL', plugins_url( '/', __FILE__ ) );

}

/*
* Define MXMPH_PLUGN_BASE_NAME
*
* 	Return mx-pagebuilder-html/mx-pagebuilder-html.php
*/
if ( ! defined( 'MXMPH_PLUGN_BASE_NAME' ) ) {

	define( 'MXMPH_PLUGN_BASE_NAME', plugin_basename( __FILE__ ) );

}

/*
* Define MXMPH_TABLE_SLUG
*/
if ( ! defined( 'MXMPH_TABLE_SLUG' ) ) {

	define( 'MXMPH_TABLE_SLUG', 'mxmph_mx_builder_options' );

}

/*
* Define MXMPH_PLUGIN_ABS_PATH
* 
* E:\OpenServer\domains\my-domain.com\wp-content\plugins\mx-pagebuilder-html/
*/
if ( ! defined( 'MXMPH_PLUGIN_ABS_PATH' ) ) {

	define( 'MXMPH_PLUGIN_ABS_PATH', dirname( MXMPH_PLUGIN_PATH ) . '/' );

}

/*
* Define MXMPH_PLUGIN_VERSION
*/
if ( ! defined( 'MXMPH_PLUGIN_VERSION' ) ) {

	// version
	define( 'MXMPH_PLUGIN_VERSION', '1.0' ); // Must be replaced before production on for example '1.0'

}

/*
* Define MXMPH_MAIN_MENU_SLUG
*/
if ( ! defined( 'MXMPH_MAIN_MENU_SLUG' ) ) {

	// version
	define( 'MXMPH_MAIN_MENU_SLUG', 'mxmph-mx-pagebuilder-html-menu' );

}

/**
 * activation|deactivation
 */
require_once plugin_dir_path( __FILE__ ) . 'install.php';

/*
* Registration hooks
*/
// Activation
register_activation_hook( __FILE__, array( 'MXMPH_Basis_Plugin_Class', 'activate' ) );

// Deactivation
register_deactivation_hook( __FILE__, array( 'MXMPH_Basis_Plugin_Class', 'deactivate' ) );


/*
* Include the main MXMPHMXPageBuilderHTML class
*/
if ( ! class_exists( 'MXMPHMXPageBuilderHTML' ) ) {

	require_once plugin_dir_path( __FILE__ ) . 'includes/final-class.php';

	/*
	* Translate plugin
	*/
	add_action( 'plugins_loaded', 'mxmph_translate' );

	function mxmph_translate()
	{

		load_plugin_textdomain( 'mxmph-domain', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

	}

}