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

		// create WP editor
		add_action( 'admin_footer', array( $this, 'mx_builder_editor_body' ) );

		// create simple textarea
		add_action( 'admin_footer', array( $this, 'mx_builder_simple_textarea_body' ) );
			
	}

	/*
	* Create WP editor
	*/
	public function mx_builder_editor_body()
	{

		echo '<div class="mx_builder_text_editor_wrap">';

			echo '<textarea id="mx_builder_editor"></textarea>';

			// подключаем стили, скрипты
			wp_enqueue_editor();

			// запускаем скрипт
			?>
			<script>
				jQuery( document ).ready( function( $ ) {

					wp.editor.initialize( 'mx_builder_editor', {
						tinymce: {
							wpautop  : false,
							theme    : 'modern',
							skin     : 'lightgray',
							language : 'en',
							formats  : {
								alignleft  : [
									{ selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li', styles: { textAlign: 'left' } },
									{ selector: 'img,table,dl.wp-caption', classes: 'alignleft' }
								],
								aligncenter: [
									{ selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li', styles: { textAlign: 'center' } },
									{ selector: 'img,table,dl.wp-caption', classes: 'aligncenter' }
								],
								alignright : [
									{ selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li', styles: { textAlign: 'right' } },
									{ selector: 'img,table,dl.wp-caption', classes: 'alignright' }
								],
								strikethrough: { inline: 'del' }
							},
							relative_urls       : false,
							remove_script_host  : false,
							convert_urls        : false,
							browser_spellcheck  : true,
							fix_list_elements   : true,
							entities            : '38,amp,60,lt,62,gt',
							entity_encoding     : 'raw',
							keep_styles         : false,
							paste_webkit_styles : 'font-weight font-style color',
							preview_styles      : 'font-family font-size font-weight font-style text-decoration text-transform',
							tabfocus_elements   : ':prev,:next',
							plugins    : 'charmap,hr,media,paste,tabfocus,textcolor,fullscreen,wordpress,wpeditimage,wpgallery,wplink,wpdialogs,wpview',
							resize     : 'vertical',
							menubar    : false,
							indent     : false,
							toolbar1   : 'bold,italic,strikethrough,bullist,numlist,blockquote,hr,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,fullscreen,wp_adv',
							toolbar2   : 'formatselect,underline,alignjustify,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help',
							toolbar3   : '',
							toolbar4   : '',
							body_class : 'id post-type-post post-status-publish post-format-standard',
							wpeditimage_disable_captions: false,
							wpeditimage_html5_captions  : true
						},
						mediaButtons: true,
						quicktags: true
					});

				} );
			</script>
			<?php

			echo '<button class="mx_builder_save_content button button-primary button-large">Save Data</button>';

		echo '</div>';

	}

	/*
	* Create simple textarea
	*/
	public function mx_builder_simple_textarea_body()
	{

		echo '<div class="mx_builder_simple_text_editor_wrap">';

			echo '<div class="mx_builder_simple_text_editor_body">';

				echo '<textarea id="mx_builder_simple_text_editor"></textarea>';

				echo '<button class="mx_builder_save_simple_text button button-primary button-large">Save Data</button>';

			echo '</div>';

		echo '</div>';

	}
	
}