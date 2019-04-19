<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXMPH_Get_Template_Files
{

	public $template_array = array();

	public $template_dir =  MXMPH_PLUGIN_ABS_PATH . 'includes/admin/build-templates/';

	/*
	* MXMPHCPTclass constructor
	*/
	public function __construct()
	{		
		
	}
	
	// disable tinyMCE
	public function mx_builder_parse_template_folder()
	{

		$this->mx_builder_scan_dir( $this->template_dir );

	}

	public function mx_builder_scan_dir( $dir )
	{

		$current_dirs = scandir( $dir );
		
		// each of all folders and files
		foreach ( $current_dirs as $key => $value ) {

			// exclude '.', '..'
			if( ! in_array( $value, array( '.', '..' ) ) ) :

				// find fiels
				if( is_file( $dir . $value ) ) :

					// create data array
					$this->mx_builder_create_array_data( $value );					
					
				// find directories
				else :

					$this->mx_builder_scan_dir( $dir . $value . '/' );

				endif;	

			endif;

		}

		// wp_localize_script
		$this->mx_builder_wp_localize_script();		

		// register shortcode
		$this->mx_builder_create_shortcode();

		// $args = array(
		// 	'elements_array' => $this->template_array
		// );

		// place to header
		// add_action( 'admin_head', function() use ( $args ) {

		// 	var_dump( $args['elements_array'] );

		// }, 10, 1 );

	}

	// create data
	public function mx_builder_create_array_data( $file )
	{

		// get template name
		$file_content = $this->mx_builder_get_contents( $this->template_dir . $file );

		preg_match('/.*<!--\sTemplate\sname:\s\'(.*)\'\s-->.*\r*\n*/', $file_content, $template_name_array);

		$template_name = 'Build Element';

		if( $template_name_array[1] !== null ) {

			$template_name = $template_name_array[1];

		}

		// template short name
		preg_match('/.*<!--\sTemplate\sshort\sname:\s\'(.*)\'\s-->.*\r*\n*/', $file_content, $template_short_name_array);

		$template_short_name = 'Element';

		if( $template_short_name_array[1] !== null ) {

			$template_short_name = $template_short_name_array[1];

		}

		$element_array = array(
			'file' 					=> $file,
			'template_name' 		=> $template_name,
			'template_short_name' 	=> $template_short_name
		);

		array_push( $this->template_array, $element_array );

	}

	/*
	* localize script
	*/ 
	public function mx_builder_wp_localize_script()
	{

		$arra_items = array();

		foreach ( $this->template_array as $key => $value ) {

			array_push( $arra_items, array(

				'element_id' 			=> $key,
				'template_name' 		=> $value['template_name'],
				'template_short_name' 	=> $value['template_short_name']

			) );		

		}

		$args = array( 'arra_items' => $arra_items );

		add_action( 'admin_enqueue_scripts', function() use ( $args ) {

			// localize like object
			wp_localize_script( 'mxmph_mx_builder', 'mx_builder_localize', array(

				'mx_builder_list_of_items' 		=> $args['arra_items']

			) );

		} );		

	}	

	/*
	* create shortcode
	*/
	public function mx_builder_create_shortcode()
	{


		add_shortcode( 'mx_builder_elemet', function( $atts ) {

			$path_to_template_folser = $this->template_dir;

			$get_file = $this->template_array[$atts['shortcode_id']]['file'];

			ob_start();

				echo $this->mx_builder_get_contents( $path_to_template_folser . $get_file );

			return ob_get_clean();

			// return $atts['shortcode_id'];

		} );

	}

		/*
		* get contents
		*/
		public function mx_builder_get_contents( $input_file )
		{

			$input = $input_file;

			// Get data from the source
			$current_content = file_get_contents( $input );

			return $current_content;

		}
	
}