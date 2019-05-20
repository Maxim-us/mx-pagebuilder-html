<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXMPH_FrontEnd_Main
{

	/*
	* MXMPH_FrontEnd_Main constructor
	*/
	public function __construct()
	{

	}

	/*
	* Additional classes
	*/
	public function mxmph_additional_classes()
	{

		// enqueue_scripts class
		mxmph_require_class_file_frontend( 'enqueue-scripts.php' );

		MXMPH_Enqueue_Scripts_Frontend::mxmph_register();

		// create shortcodes
		mxmph_require_class_file_frontend( 'create-shortcodes.php' );

		MXMPH_Create_Shortcodes::mx_builder_create_shortcode();

	}

}

// Initialize
$initialize_admin_class = new MXMPH_FrontEnd_Main();

// include classes
$initialize_admin_class->mxmph_additional_classes();