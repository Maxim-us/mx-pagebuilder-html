<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXMPH_Get_Template_Files
{

	/*
	* MXMPH_Get_Template_Files constructor
	*/
	public function __construct()
	{		
		
	}

	public $template_array = array();

	public $template_dir =  MXMPH_PLUGIN_ABS_PATH . 'includes/admin/build-templates/';
	
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

		// full content
		$file_content = trim( preg_replace('/\s\s+/', ' ', $file_content) );

		$file_content = trim( preg_replace('/(<!--.*-->)/', ' ', $file_content) );

		$element_array = array(
			'file' 					=> $file,
			'template_name' 		=> $template_name,
			'template_short_name' 	=> $template_short_name,
			'full_content' 			=> $file_content
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
			
			$_content = $value['full_content'];

			preg_match_all('/<img.*?src=["\']+(.*?)["\']+/', $_content, $image_src_array);

			if( $image_src_array[1] !== NULL ) {

				foreach ( $image_src_array[1] as $_key => $_value ) {
					
					$_content = str_replace( $_value, MXMPH_PLUGIN_URL . 'includes/admin/assets/img/default_image.jpg', $_content );

				}			

			}

			array_push( $arra_items, array(

				'element_id' 			=> $key,
				'template_name' 		=> $value['template_name'],
				'template_short_name' 	=> $value['template_short_name'],
				'full_content' 			=> $_content

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