<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXMPH_Page_Builder_Switcher
{

	/*
	* MXMPH_Page_Builder_Switcher constructor
	*/
	public function __construct()
	{		
		
	}

	public static function mxmph_page_builder_switcher()
	{

		// create buttons
		self::mxmph_page_builder_switcher_button();

		// enqueue script
		self::mxmph_page_builder_switcher_script();

		// update option
		self::mxmph_update_option();

	}
	
	// create button
	public static function mxmph_page_builder_switcher_button()
	{

		$post_id = $_GET['post'];

		$mx_builder_enable = false;

		$get_builder_switcher_array_option = get_option( 'mx_builder_switcher_post_array' );

		$builder_switcher_option = maybe_unserialize( $get_builder_switcher_array_option );

		if( $builder_switcher_option !== false ) {

			foreach ( $builder_switcher_option as $key => $value ) {

				if( intval( $post_id ) == intval( $value ) ) {

					$mx_builder_enable = true;

				}
				
			}

		}
		
		if( $mx_builder_enable == false ) {

			add_action( 'edit_form_after_title', function() use ( $post_id ) { ?>

				<button data-post-id="<?php echo $post_id; ?>" id="mxmph_enable_mx_builder" class="mxmph_builder_switcher_button button button-primary button-large">Mx Builder</button>

			<?php } );

		} else {

			add_action( 'edit_form_after_title', function() use ( $post_id ) { ?>

				<button data-post-id="<?php echo $post_id; ?>" id="mxmph_enable_wp_editor" class="mxmph_builder_switcher_button button button-primary button-large">WP Editor</button>

			<?php } );

		}		

	}

	// enqueue script
	public static function mxmph_page_builder_switcher_script()
	{

		add_action( 'admin_enqueue_scripts', array( 'MXMPH_Page_Builder_Switcher', 'mxmph_enqueue_button_switcher_script' ) );

	}

		public static function mxmph_enqueue_button_switcher_script()
		{

			wp_enqueue_script( 'mxmph_button_switcher_script', MXMPH_PLUGIN_URL . 'includes/admin/assets/js/mx_builder_switcher.js', array( 'jquery' ), MXMPH_PLUGIN_VERSION, false );

			// localize like object
			wp_localize_script( 'mxmph_button_switcher_script', 'mx_builder_builder_button_switcher_localize', array(

				'mx_sequre' 		=> wp_create_nonce('mxmph_nonce_builder_switcher')

			) );

		}

	// update option
	public static function mxmph_update_option()
	{

		add_action( 'wp_ajax_mxmph_update_mx_builder_option', array( 'MXMPH_Page_Builder_Switcher', 'mxmph_prepare_update_mx_builder_option' ), 10, 1 );

	}

		public static function mxmph_prepare_update_mx_builder_option()
		{



			// Checked POST nonce is not empty
			if( empty( $_POST['nonce'] ) ) wp_die( '0' );

			// Checked or nonce match
			if( wp_verify_nonce( $_POST['nonce'], 'mxmph_nonce_builder_switcher' ) ) {

				// save image path
				self::mxmph_update_mx_builder_option( $_POST );

			}

			wp_die();

		}

		public static function mxmph_update_mx_builder_option( $_post )
		{

			// var_dump( $_post['button_id'] );

			// get option array
			$get_builder_switcher_array_option = get_option( 'mx_builder_switcher_post_array' );

			// if youser press enable builder button
			if( $_post['button_id'] == 'mxmph_enable_mx_builder' ) {				

				// if option not exists
				if( $get_builder_switcher_array_option == false ) {

					$get_builder_switcher_array_option = array( $_post['post_id'] );

					$builder_switcher_post_array = maybe_serialize( $get_builder_switcher_array_option );

					update_option( 'mx_builder_switcher_post_array', $builder_switcher_post_array );

				} else {

					// if option not exists
					$new_post_id = true;

					$builder_switcher_option = maybe_unserialize( $get_builder_switcher_array_option );

					foreach ( $builder_switcher_option as $key => $value ) {

						if( intval( $_post['post_id'] ) == intval( $value ) ) {

							$new_post_id = false;

						}

					}

					if( $new_post_id == true ) {

						// update options
						array_push( $builder_switcher_option, $_post['post_id'] );

						$builder_switcher_post_array = maybe_serialize( $builder_switcher_option );

						update_option( 'mx_builder_switcher_post_array', $builder_switcher_post_array );

					}

				}

			}

			// enable wp editor
			if( $_post['button_id'] == 'mxmph_enable_wp_editor' ) {

				// if option exists
				if( $get_builder_switcher_array_option !== false ) {

					$builder_switcher_post_array = maybe_unserialize( $get_builder_switcher_array_option );

					// if post id setted
					$enable_wp_editor = false;

					foreach ( $builder_switcher_post_array as $key => $value ) {

						if( intval( $_post['post_id'] ) == intval( $value ) ) {

							$enable_wp_editor = true;

							// remove array items
							unset( $builder_switcher_post_array[$key] );

						}

					}

					// update option
					if( $enable_wp_editor == true ) {						

						$builder_switcher_option = maybe_serialize( $builder_switcher_post_array );

						update_option( 'mx_builder_switcher_post_array', $builder_switcher_option );

					}					

				}				

			}

		}
	
}