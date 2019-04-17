<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// require Route-Registrar.php
require_once MXMPH_PLUGIN_ABS_PATH . 'includes/core/Route-Registrar.php';

/*
* Routes class
*/
class MXMPH_Route
{

	public function __construct()
	{
		// ...
	}
	
	public static function mxmph_get( ...$args )
	{

		return new MXMPH_Route_Registrar( ...$args );

	}
	
}