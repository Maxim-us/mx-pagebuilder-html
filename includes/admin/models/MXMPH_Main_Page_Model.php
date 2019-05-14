<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
* Main page Model
*/
class MXMPH_Main_Page_Model extends MXMPH_Model
{

	/*
	* Observe function
	*/
	public static function mxmph_wp_ajax()
	{

		// add_action( 'wp_ajax_mxmph_update', array( 'MXMPH_Main_Page_Model', 'prepare_update_database_column' ), 10, 1 );

	}
	
}