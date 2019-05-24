jQuery( document ).ready( function( $ ) {

	// add button before #content
	$( '#content' ).parent().before( '<div id="mx_builder_area"></div>' );

	// main object
	var mx_builder_app = {};

	// container
	mx_builder_app.container = $( '#mx_builder_area' );

	/*
	* Add list of items
	* (buttons - html elements)
	*/
	mx_builder_app.container.append( '<div id="mx_builder_components_container"></div>' );

	/*
	* Set up default value
	*
	*/
	mx_builder_app.init = function() {

		// movement elements of stream
		mx_builder_app.moving_build_elements();

		// remove element of stream
		mx_builder_app.remove_element();

		// meta
		mx_builder_app.repair_builder();

		// WP Editor
			// open editor
			mx_builder_app.open_editor();

			// close editor
			mx_builder_app.close_editor_save_data();

		// Simple Editor
			// open
			mx_builder_app.open_simple_editor();

			// close
			mx_builder_app.close_simple_editor_save_data();

		// media lib
		mx_builder_app.media_lib_init();

		// insert shortcodes to the textarea
		mx_builder_app.placed_shortcodes();

	};

	/*
	* build elemets container
	*/
	$( '#mx_builder_components_container' ).append( '<div id="mx_builder_elemets_container"></div>' );

	/*
	* plus container
	*/
	$( '#mx_builder_components_container' ).append( '<div id="mx_builder_add_item_field"></div>' );

		/*
		* plus container - list box
		*/
		$( '#mx_builder_add_item_field' ).append( '<div id="mx_builder_list_of_items_box"></div>' );

		/*
		* plus container - list add button
		*/
		// $( '#mx_builder_add_item_field' ).append( '<div id="mx_builder_add_button_wrap"><button id="mx_builder_add_button">+</button></div>' );

	/*
	* set builder elements to the list
	*/
	$.each( mx_builder_localize.mx_builder_list_of_items, function() {

		// console.log( this );
		$( '#mx_builder_list_of_items_box' ).append( mx_builder_element_body( this.element_id, this.template_name, this.template_short_name ) );

	} );

	/*
	* add element to the stream event
	*/
	$( '#mx_builder_list_of_items_box' ).on( 'click', '.mx_builder_virtual_element', function() {

		var _this = $( this );

		var _data = {
			shortcode_id: 			_this.attr( 'data-shortcode-id' ),
			template_name: 			_this.attr( 'data-template-name' ),
			template_short_name: 	_this.attr( 'data-template-short-name' )
		};

		var new_element = mx_builder_create_new_b_e_for_stream( _data.shortcode_id, _data.template_name, _data.template_short_name );

		$( new_element ).appendTo( '#mx_builder_elemets_container' );

		// management
		mx_builder_app.show_management_button();

		// insert shortcodes to the textarea
		mx_builder_app.placed_shortcodes();

		// create metadeta
		mx_builder_app.save_meta_box();


	} );

	/*
	* show management button
	*/
	mx_builder_app.show_management_button = function() {

		var count_of_elements = $( '#mx_builder_elemets_container' ).find( '.mx_builder_build_stream_element' ).length;

		$( '#mx_builder_elemets_container' ).find( '.mx_builder_build_stream_element' ).each( function() {

			// remove none class
			$( this ).find( '.mx_builder_b_s_e_lift_item, .mx_builder_b_s_e_drop_item' ).removeClass( 'mx_builder_button_none' );

			// find top element
			if( $( this ).index() === 0 ) {

				$( this ).find( '.mx_builder_b_s_e_lift_item' ).addClass( 'mx_builder_button_none' );

			}

			if( $( this ).index() === count_of_elements - 1 ) {

				$( this ).find( '.mx_builder_b_s_e_drop_item' ).addClass( 'mx_builder_button_none' );

			}

		} );

	};

	/*
	* remove element
	*/
	mx_builder_app.remove_element = function() {

		$( '#mx_builder_elemets_container' ).on( 'click', '.mx_builder_build_stream_element_remove_element', function() {

			if( confirm( 'Do you want to remove this element?' ) ) {

				// remove element
				$( this ).parent().parent().remove();

				// management
				mx_builder_app.show_management_button();

				// insert shortcodes to the textarea
				mx_builder_app.placed_shortcodes();

				// create metadeta
				mx_builder_app.save_meta_box();

			}			

		} );

	};

	/*
	* moving build elements
	*/
	mx_builder_app.moving_build_elements = function() {

		// move to top
		$( '#mx_builder_elemets_container' ).on( 'click', '.mx_builder_b_s_e_lift_item', function() {

			var current_element = $( this ).parent().parent().parent();

			var prev_element = $( this ).parent().parent().parent().prev();

			mx_builder_app.effect_move_to_top( current_element );

			setTimeout( function() {

				prev_element.before( current_element );

				// management buttons
				mx_builder_app.show_management_button();

				// insert shortcodes to the textarea
				mx_builder_app.placed_shortcodes();

				// create metadeta
				mx_builder_app.save_meta_box();

			}, 500 );

		} );

		// move to bottom
		$( '#mx_builder_elemets_container' ).on( 'click', '.mx_builder_b_s_e_drop_item', function() {

			var current_element = $( this ).parent().parent().parent();

			var prev_element = $( this ).parent().parent().parent().next();

			mx_builder_app.effect_move_to_bottom( current_element );

			setTimeout( function() {

				prev_element.after( current_element );

				// management buttons
				mx_builder_app.show_management_button();

				// insert shortcodes to the textarea
				mx_builder_app.placed_shortcodes();

				// create metadeta
				mx_builder_app.save_meta_box();

			}, 500 );

		} );

	};

	/*
	* get shortcodes
	*/
	mx_builder_app.generate_shortcodes = function() {

		var return_shortcodes = '';

		$( '#mx_builder_elemets_container' ).find( '.mx_builder_build_stream_element' ).each( function() {

			var full_content = $( this ).find( '.mx_builder_build_stream_element_body' ).html();

			full_content = mx_builder_encode_html( full_content );

			var return_shortcode = '[mx_builder_elemet';

			var shortcode_id = $( this ).attr( 'data-shortcode-id' );

			return_shortcode += ' shortcode_id="' + shortcode_id + '"';

			return_shortcode += ' full_content="' + full_content + '"';

			return_shortcode += ']';

			return_shortcodes += return_shortcode + ' ';

		} );

		return return_shortcodes;

	};

	/*
	*  place shortcode to the textarea
	*/
	mx_builder_app.placed_shortcodes = function() {

		$( '#content' ).val( '' );

		$( '#content' ).val( mx_builder_app.generate_shortcodes() );

	};

	/*
	* Repair builder
	*/ 
	mx_builder_app.repair_builder = function() {		

		var meta_data_array = mx_builder_app.get_meta_box();

		// console.log( meta_data_array );

		$.each( meta_data_array, function() {

			var _this = this;

			var new_element = mx_builder_create_new_b_e_for_stream( _this.shortcode_id, _this.template_name, _this.template_short_name, _this.full_content );

			$( new_element ).appendTo( '#mx_builder_elemets_container' );

			// management
			mx_builder_app.show_management_button();

		} );
		
	}

	/*
	* save meta data
	*/
	mx_builder_app.save_meta_box = function() {

		var _data = [];

		$( '#mx_builder_elemets_container' ).find( '.mx_builder_build_stream_element' ).each( function() {

			var _full_content = $( this ).find( '.mx_builder_build_stream_element_body' ).html();

			var full_content = mx_builder_encode_html( _full_content );

			var shortcode_id 		= $( this ).attr( 'data-shortcode-id' );
			var template_name 		= $( this ).attr( 'data-template-name' );
			var template_short_name = $( this ).attr( 'data-template-short-name' );

			_data.push( {
				shortcode_id: shortcode_id,
				template_name: template_name,
				template_short_name: template_short_name,
				full_content: full_content
			} );

		} );

		var serialize_data = JSON.stringify( _data );

		// console.log( serialize_data );

		$( '#mx_builder_array_input' ).val( serialize_data );

	};	

	/*
	* get meta data
	*/
	mx_builder_app.get_meta_box = function() {

		var _meta_data = $( '#mx_builder_array_input' ).val();

		if( !mx_builder_is_valid_json( _meta_data ) ) {

			_meta_data = '[]';

		}

		return JSON.parse( _meta_data );

	};

	// WordPress Editor
	/*
	* open editor
	*/
	mx_builder_app.open_editor = function() {

		$( '#mx_builder_elemets_container' ).on( 'click', '.mx-builder-editable-content', function() {

			// mark element
			$( this ).addClass( 'mx_builder_edit_process' );

			var content = $( this ).html();

			$( '#mx_builder_editor' ).html( content );

			// show editor
			$( '.mx_builder_text_editor_wrap' ).addClass( 'mx_builder_text_editor_visible' );

			
			tinymce.get('mx_builder_editor').setContent( content );

			// tinymce.get("mx_builder_editor").execCommand('mceInsertContent', false, content);

			// console.log( tinymce.get('mx_builder_editor') );


			
		} );


	};

	/*
	* close editor and save data
	*/
	mx_builder_app.close_editor_save_data = function() {

		$( '.mx_builder_save_content' ).on( 'click', function() {

			var _content = tinymce.get('mx_builder_editor').getContent();

			$( '.mx_builder_edit_process' ).html( _content );

			setTimeout( function() {

				var html_current_builder_element = $( '.mx_builder_edit_process' ).parent().html();

				// console.log( mx_builder_encode_html( html_current_builder_element ) );

				$( '.mx_builder_edit_process' ).removeClass( 'mx_builder_edit_process' );

				// insert shortcodes to the textarea
				mx_builder_app.placed_shortcodes();

				// create metadeta
				mx_builder_app.save_meta_box();

				// close editor
				$( '.mx_builder_text_editor_wrap' ).removeClass( 'mx_builder_text_editor_visible' );

			}, 500 );			

		} );

		// click on empty space around the editor
		$( '.mx_builder_text_editor_wrap' ).on( 'click', function( e ) {

			var editor = $( '#wp-mx_builder_editor-wrap' );
			
			if( !editor.is( e.target ) && editor.has( e.target).length === 0 ){

				setTimeout( function() {

					// close editor
					$( '.mx_builder_text_editor_wrap' ).removeClass( 'mx_builder_text_editor_visible' );

				},500 );

			}
			
		} );
		
	};

	// Simple Editor
	/*
	* Open simple editor
	*/
	mx_builder_app.open_simple_editor = function() {

		$( '#mx_builder_elemets_container' ).on( 'click', '.mx-builder-editable-text', function() {

			// mark element
			$( this ).addClass( 'mx_builder_edit_process' );

			var content = $( this ).html();

			console.log( content );
			
			$( '#mx_builder_simple_text_editor' ).val( content );

			// show editor
			$( '.mx_builder_simple_text_editor_wrap' ).addClass( 'mx_builder_text_editor_visible' );

		} );

	};

	/*
	* Close simple editor
	*/
	mx_builder_app.close_simple_editor_save_data = function() {

		// save data
		$( '.mx_builder_save_simple_text' ).on( 'click', function() {

			var _content = $( '#mx_builder_simple_text_editor' ).val();

			$( '.mx_builder_edit_process' ).html( _content );

			setTimeout( function() {

				$( '.mx_builder_edit_process' ).removeClass( 'mx_builder_edit_process' );

				// insert shortcodes to the textarea
				mx_builder_app.placed_shortcodes();

				// create metadeta
				mx_builder_app.save_meta_box();

				// close editor
				$( '.mx_builder_simple_text_editor_wrap' ).removeClass( 'mx_builder_text_editor_visible' );

			}, 500 );			

		} );

		// click on empty space around the editor
		$( '.mx_builder_simple_text_editor_wrap' ).on( 'click', function( e ) {

			var editor = $( '#mx_builder_simple_text_editor' );
			
			if( !editor.is( e.target ) && editor.has( e.target).length === 0 ){

				setTimeout( function() {

					// close editor
					$( '.mx_builder_simple_text_editor_wrap' ).removeClass( 'mx_builder_text_editor_visible' );

				},500 );

			}
			
		} );

	};


	/*****************
	* effects
	*/
		/*
		* move element to top
		*/
		mx_builder_app.effect_move_to_top = function( element ) {

			$( element ).addClass( 'mx_builder_effect_move_to_top' );

			setTimeout( function() {

				$( element ).removeClass( 'mx_builder_effect_move_to_top' );

			}, 400 );

		};

		/*
		* move element to bottom
		*/
		mx_builder_app.effect_move_to_bottom = function( element ) {

			$( element ).addClass( 'mx_builder_effect_move_to_bottom' );

			setTimeout( function() {

				$( element ).removeClass( 'mx_builder_effect_move_to_bottom' );

			}, 400 );

		};

		/*
		* media library
		*/
		mx_builder_app.media_lib_init = function() {

			$( '#mx_builder_elemets_container' ).on( 'click', '.mx-builder-editable-img', function() {

				var _this = $( this );

		        var upload = wp.media( {

			        title:'Choose Image',

			        multiple:false

		        } ).on('select', function(){

		            var select = upload.state().get('selection');

		            var attach = select.first().toJSON();

		            _this.attr( 'src', attach.url );

		            // insert shortcodes to the textarea
					mx_builder_app.placed_shortcodes();

					// create metadeta
					mx_builder_app.save_meta_box();

		        } ).open();

			} );

		}
	
	// init
	mx_builder_app.init();

} );

// builder element icon
function mx_builder_element_body( shortcode_id, template_name, template_short_name ) {

	var html = '';

	// _________

	html += '<div class="mx_builder_virtual_element" data-template-short-name="' + template_short_name + '" data-template-name="' + template_name + '" data-shortcode-id="' + shortcode_id + '" title="' + template_name + '">'; // start wrap

		html += '<div class="mx_builder_v_e_title">';

			html += '<span>' + template_short_name + '</span>';

		html += '</div>';

	html += '</div>'; // end wrap

	return html;

}

// new element to the build stream
function mx_builder_create_new_b_e_for_stream( shortcode_id, template_name, template_short_name, full_content ) {

	var get_full_content = mx_builder_get_full_content( shortcode_id );

	if( full_content !== undefined ) {

		get_full_content = mx_builder_decode_html( full_content );

	}

	var html = '';

	html += '<div class="mx_builder_build_stream_element" data-template-short-name="' + template_short_name + '" data-template-name="' + template_name + '" data-shortcode-id="' + shortcode_id + '">';

		html += '<div class="mx_builder_build_stream_element_header">';

			html += '<div class="mx_template_short_name">' + template_short_name + '</div>';

			html += '<div class="mx_builder_build_stream_element_management"><span class="mx_builder_b_s_e_lift_item">To top</span><span class="mx_builder_b_s_e_drop_item">To bottom</span></div>';

			html += '<div class="mx_builder_build_stream_element_remove_element"><span>x</span></div>';

		html += '</div>';

		html += '<div class="mx_builder_build_stream_element_body">';

			html += get_full_content;

		html += '</div>';

	html += '</div>';

	return html;

}

// get full content
function mx_builder_get_full_content( shortcode_id ) {

	var _this_content = '';

	$.each( mx_builder_localize.mx_builder_list_of_items, function() {

		if( this.element_id === parseInt( shortcode_id ) ) {

			_this_content = this.full_content;

		}

	} );

	return _this_content;

}

// encode html
function mx_builder_encode_html( str ) {

    return String( str )
    .replace( /&/g, '&amp;' )
    .replace( /</g, '&lt;' )
    .replace( />/g, '&gt;' )
    .replace( /\"/g, '&quot;' )
    .replace( /\'/g, '&apos;' );

}

// decode html
function mx_builder_decode_html( str ) {

    return String( str )
    .replace( /&amp;/g, '&' )
    .replace( /&lt;/g, '<' )
    .replace( /&gt;/g, '>' )
    .replace( /&quot;/g, '\"' )
    .replace( /&apos;/g, '\'' );

}

// check JSON data
function mx_builder_is_valid_json( str ) {

	if ( str.length ) {

		return true;

	} else {

		return false;

	}

}