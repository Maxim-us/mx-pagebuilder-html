<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXMPHCPTclass
{

	/*
	* MXMPHCPTclass constructor
	*/
	public function __construct()
	{		

	}

	/*
	* Observe function
	*/
	public static function createCPT()
	{

		add_action( 'init', array( 'MXMPHCPTclass', 'mxmph_custom_init' ) );

	}

	/*
	* Create a Custom Post Type
	*/
	public static function mxmph_custom_init()
	{
		
		register_post_type( 'mxmph_books', array(

			'labels'             => array(
				'name'               => 'Books',
				'singular_name'      => 'Book',
				'add_new'            => 'Add a new one',
				'add_new_item'       => 'Add a new book',
				'edit_item'          => 'Edit the book',
				'new_item'           => 'New book',
				'view_item'          => 'See the book',
				'search_items'       => 'Find a book',
				'not_found'          =>  'Books not found',
				'not_found_in_trash' => 'No books found in the trash',
				'parent_item_colon'  => '',
				'menu_name'          => 'Books'

			  ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => true,
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )

		) );

		// Rewrite rules
		if( is_admin() && get_option( 'mxmph_flush_rewrite_rules' ) == 'go_flush_rewrite_rules' )
		{

			delete_option( 'mxmph_flush_rewrite_rules' );

			flush_rewrite_rules();

		}

	}

}