<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// require Display_Error.php
require_once MXMPH_PLUGIN_ABS_PATH . 'includes/core/error_handle/Display-Error.php';

// handle error
require_once MXMPH_PLUGIN_ABS_PATH . 'includes/core/error_handle/Error-Handle.php';

/*
* Cathing errors calss
*/
class MXMPH_Catching_Errors
{

	/**
	* Show notification missing class or methods
	*/
	public static function mxmph_catch_class_attributes_error( $class_name, $method )
	{

		$error_class_inst = new MXMPH_Error_Handle();

		$error_display = $error_class_inst->mxmph_class_attributes_error( $class_name, $method );

		$error = NULL;

		if( $error_display !== true ) {

			$error = $error_display;

		}		

		return $error;

	}

}