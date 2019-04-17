<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXMPH_Page_Builder_Area
{

	/*
	* MXMPHCPTclass constructor
	*/
	public function __construct()
	{		
		
	}
	
	// disable tinyMCE
	public function mx_builder_enable_html_editor()
	{

		add_filter( 'wp_default_editor', create_function('', 'return "html";') ); 

	}
	
}