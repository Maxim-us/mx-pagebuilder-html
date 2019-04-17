<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXMPH_Enqueue_Scripts
{

	/*
	* MXMPH_Enqueue_Scripts
	*/
	public function __construct()
	{

	}

	/*
	* Registration of styles and scripts
	*/
	public static function mxmph_register()
	{

		// register scripts and styles
		add_action( 'admin_enqueue_scripts', array( 'MXMPH_Enqueue_Scripts', 'mxmph_enqueue' ) );

	}

		public static function mxmph_enqueue()
		{

			wp_enqueue_style( 'mxmph_font_awesome', MXMPH_PLUGIN_URL . 'assets/font-awesome-4.6.3/css/font-awesome.min.css' );

			wp_enqueue_style( 'mxmph_admin_style', MXMPH_PLUGIN_URL . 'includes/admin/assets/css/style.css', array( 'mxmph_font_awesome' ), MXMPH_PLUGIN_VERSION, 'all' );

			wp_enqueue_script( 'mxmph_admin_script', MXMPH_PLUGIN_URL . 'includes/admin/assets/js/script.js', array( 'jquery' ), MXMPH_PLUGIN_VERSION, false );

			// mx builder
			wp_enqueue_script( 'mxmph_mx_builder', MXMPH_PLUGIN_URL . 'includes/admin/assets/js/mx_builder.js', array( 'mxmph_admin_script' ), MXMPH_PLUGIN_VERSION, false );

		}

}