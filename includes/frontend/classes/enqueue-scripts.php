<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXMPH_Enqueue_Scripts_Frontend
{

	/*
	* MXMPH_Enqueue_Scripts_Frontend
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
		add_action( 'wp_enqueue_scripts', array( 'MXMPH_Enqueue_Scripts_Frontend', 'mxmph_enqueue' ) );

	}

		public static function mxmph_enqueue()
		{

			wp_enqueue_style( 'mxmph_font_awesome', MXMPH_PLUGIN_URL . 'assets/font-awesome-4.6.3/css/font-awesome.min.css' );
			
			wp_enqueue_style( 'mxmph_style', MXMPH_PLUGIN_URL . 'includes/frontend/assets/css/style.css', array( 'mxmph_font_awesome' ), MXMPH_PLUGIN_VERSION, 'all' );
			
			wp_enqueue_script( 'mxmph_script', MXMPH_PLUGIN_URL . 'includes/frontend/assets/js/script.js', array( 'jquery' ), MXMPH_PLUGIN_VERSION, false );
		
		}

}