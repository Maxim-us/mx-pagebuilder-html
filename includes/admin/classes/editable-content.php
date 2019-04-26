<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXMPH_Editable_Content
{

	/*
	* MXMPH_Editable_Content constructor
	*/
	public function __construct()
	{		
		
	}

	public function mx_builder_add_editor()
	{

		add_action( 'admin_footer', array( $this, 'mx_builder_editor_body' ) );

	}

	public function mx_builder_editor_body()
	{

		echo '<div class="mx_builder_text_editor_wrap">';

			// wp_editor( '', 'mx_builder_editor', array(
			// 	'textarea_name' => 'mx_builder_content',
			// 	'media_buttons' => 0
			// ) );
			echo '<textarea id="mx_builder_editor"></textarea>';

			echo '<button class="mx_builder_save_content button button-primary button-large">Save Data</button>';

		echo '</div>';

	}
	
}