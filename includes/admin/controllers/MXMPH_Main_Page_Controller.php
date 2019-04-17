<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXMPH_Main_Page_Controller extends MXMPH_Controller
{
	
	public function index()
	{

		// $model_inst = new MXMPH_Main_Page_Model();

		// $data = $model_inst->mxmph_get_row( NULL, 'id', 1 );

		return new MXMPH_View( 'main-page' );

	}

	public function submenu()
	{

		return new MXMPH_View( 'sub-page' );

	}

	public function hidemenu()
	{

		return new MXMPH_View( 'hidemenu-page' );

	}

}