<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXMPH_Admin_Main
{

	// list of model names used in the plugin
	public $models_collection = [
		'MXMPH_Main_Page_Model'
	];

	/*
	* MXMPH_Admin_Main constructor
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
		mxmph_require_class_file_admin( 'enqueue-scripts.php' );

		MXMPH_Enqueue_Scripts::mxmph_register();

		// page builder area
		mxmph_require_class_file_admin( 'page-builder-area.php' );

		$mx_builder_instance = new MXMPH_Page_Builder_Area();

		$mx_builder_instance->mx_builder_enable_html_editor();

	}

	/*
	* Models Connection
	*/
	public function mxmph_models_collection()
	{

		// require model file
		foreach ( $this->models_collection as $model ) {
			
			mxmph_use_model( $model );

		}		

	}

	/**
	* registration ajax actions
	*/
	public function mxmph_registration_ajax_actions()
	{

		// ajax requests to main page
		MXMPH_Main_Page_Model::mxmph_wp_ajax();

	}

	/*
	* Routes collection
	*/
	public function mxmph_routes_collection()
	{

		// main menu item
		// MXMPH_Route::mxmph_get( 'MXMPH_Main_Page_Controller', 'index', '', [
		// 	'page_title' => 'Main Menu title',
		// 	'menu_title' => 'Main menu'
		// ] );

		// // sub menu item
		// MXMPH_Route::mxmph_get( 'MXMPH_Main_Page_Controller', 'submenu', '', [
		// 	'page_title' => 'Sub Menu title',
		// 	'menu_title' => 'Sub menu'
		// ], 'sub_menu' );

		// // sub menu item
		// MXMPH_Route::mxmph_get( 'MXMPH_Main_Page_Controller', 'hidemenu', 'NULL', [
		// 	'page_title' => 'Hidden Menu title',
		// ], 'hide_menu' );

	}

}

// Initialize
$initialize_admin_class = new MXMPH_Admin_Main();

// include classes
$initialize_admin_class->mxmph_additional_classes();

// include models
$initialize_admin_class->mxmph_models_collection();

// ajax requests
$initialize_admin_class->mxmph_registration_ajax_actions();

// include controllers
$initialize_admin_class->mxmph_routes_collection();