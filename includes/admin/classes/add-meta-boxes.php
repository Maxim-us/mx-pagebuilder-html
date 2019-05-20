<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXMPH_Add_Meta_Boxes
{

	/*
	* MXMPH_Add_Meta_Boxes constructor
	*/
	public function __construct()
	{		
		
	}
	
	/*
	* create meta box for saveing data array of builder
	*/
	public function mx_builder_create_meta_box()
	{

		// create meta box
		add_action( 'add_meta_boxes', array( $this, 'mx_builder_add_custom_box' ) );

		// meta data save
		add_action( 'save_post', array( $this, 'mx_builder_add_custom_box_save_postdata' ) );

	}

	// 
	public function mx_builder_add_custom_box()
	{

		add_meta_box( 'mx_builder_data_array_builder', 'Array of data. Builder stream.', array( $this, 'mx_builder_data_array_builder_callback' ) );

	}

	// html
	public function mx_builder_data_array_builder_callback( $post, $meta )
	{

		$data = get_post_meta( $post->ID, '_mx_builder_meta_key', true );

		wp_nonce_field( MXMPH_PLUGN_BASE_NAME, 'mx_builder_noncename' );

		// var_dump( htmlspecialchars( $data, ENT_QUOTES ) );

		echo '<style>';

			echo '#mx_builder_data_array_builder {';

			    echo 'display: none;';
			    
			echo '}';

		echo '</style>';

		echo '<input type="text" id="mx_builder_array_input" name="mx_builder_array_input" value="' . htmlspecialchars( $data, ENT_QUOTES ) . '" />';

	}

	// save data
	public function mx_builder_add_custom_box_save_postdata( $post_id )
	{

		// isset
		if ( ! isset( $_POST['mx_builder_array_input'] ) )
			return;

		// nonce
		if ( ! wp_verify_nonce( $_POST['mx_builder_noncename'], MXMPH_PLUGN_BASE_NAME ) )
			return;

		// no autosave
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
			return;

		// user permissions
		if( ! current_user_can( 'edit_post', $post_id ) )
			return;

		// save data
		$save_data = sanitize_text_field( $_POST['mx_builder_array_input'] );

		update_post_meta( $post_id, '_mx_builder_meta_key', $save_data );

	}
	
}