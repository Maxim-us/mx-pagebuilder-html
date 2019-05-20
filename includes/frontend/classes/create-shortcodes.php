<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXMPH_Create_Shortcodes
{

	/*
	* MXMPH_Create_Shortcodes constructor
	*/
	public function __construct()
	{		
		
	}

	/*
	* create shortcode
	*/
	public static function mx_builder_create_shortcode()
	{

		add_shortcode( 'mx_builder_elemet', function( $atts ) {

			ob_start();

				echo htmlspecialchars_decode( $atts['full_content'] );

			return ob_get_clean();


		} );

	}
	
}