var mx_builder_list_of_items = [
	{
		shortcode_name: 'mx_builder_element',
		element_id: 1
	},
	{
		shortcode_name: 'mx_builder_element',
		element_id: 2
	},
	{
		shortcode_name: 'mx_builder_element',
		element_id: 3
	}
];

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

		mx_builder_app.moving_build_elements();

	}

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
		$( '#mx_builder_add_item_field' ).append( '<div id="mx_builder_add_button_wrap"><button id="mx_builder_add_button">+</button></div>' );

	/*
	* set builder elements to the list
	*/
	$.each( mx_builder_list_of_items, function() {

		// console.log( this );
		$( '#mx_builder_list_of_items_box' ).append( mx_builder_element_body( this.shortcode_name, this.element_id ) );

	} );

	/*
	* add element to the stream event
	*/
	$( '#mx_builder_list_of_items_box' ).on( 'click', '.mx_builder_virtual_element', function() {

		var _this = $( this );

		var _data = {
			type_shortcode: _this.attr( 'data-type-shortcode' ),
			shortcode_id: _this.attr( 'data-shortcode-id' )
		};

		var new_element = mx_builder_create_new_b_e_for_stream( _data.type_shortcode, _data.shortcode_id );

		$( new_element ).appendTo( '#mx_builder_elemets_container' );

		// management
		mx_builder_app.show_management_button();

		// insert shortcodes to the textarea
		mx_builder_app.placed_shortcodes();

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

	}

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

			}, 500 );

		} );

	};

	/*
	* get shortcodes
	*/
	mx_builder_app.generate_shortcodes = function() {

		var return_shortcodes = '';

		$( '#mx_builder_elemets_container' ).find( '.mx_builder_build_stream_element' ).each( function() {

			var return_shortcode = '[mx_builder_elemet';

			var type_shortcode = $( this ).attr( 'data-type-shortcode' );

			return_shortcode += ' type_shortcode="' + type_shortcode + '"';

			var shortcode_id = $( this ).attr( 'data-shortcode-id' );

			return_shortcode += ' shortcode_id="' + shortcode_id + '"';

			return_shortcode += ']';

			return_shortcodes += return_shortcode + ' ';

		} );

		return return_shortcodes;

	}

	/*
	*  place shortcode to the textarea
	*/
	mx_builder_app.placed_shortcodes = function() {

		$( '#content' ).val( '' );

		$( '#content' ).val( mx_builder_app.generate_shortcodes() );

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

		}

		/*
		* move element to bottom
		*/
		mx_builder_app.effect_move_to_bottom = function( element ) {

			$( element ).addClass( 'mx_builder_effect_move_to_bottom' );

			setTimeout( function() {

				$( element ).removeClass( 'mx_builder_effect_move_to_bottom' );

			}, 400 );

		}

	// init
	mx_builder_app.init();

} );

// skeleton of builder element
function mx_builder_element_body( type_shortcode, shortcode_id ) {

	var html = '';

	// _________

	html += '<div class="mx_builder_virtual_element" data-type-shortcode="' + type_shortcode + '" data-shortcode-id="' + shortcode_id + '">'; // start wrap

		html += '<div class="mx_builder_v_e_title">';

			html += shortcode_id;

		html += '</div>';

	html += '</div>'; // end wrap

	return html;

}

// new element to the build stream
function mx_builder_create_new_b_e_for_stream( type_shortcode, shortcode_id ) {

	var html = '';

	html += '<div class="mx_builder_build_stream_element" data-type-shortcode="' + type_shortcode + '" data-shortcode-id="' + shortcode_id + '">';

		html += '<div class="mx_builder_build_stream_element_header">';

			html += '<div>Element #' + shortcode_id + '</div>';

			html += '<div>Element shortcode' + type_shortcode + '</div>';

			html += '<div class="mx_builder_build_stream_element_management"><span class="mx_builder_b_s_e_lift_item">To top</span><span class="mx_builder_b_s_e_drop_item">To bottom</span></div>';

		html += '</div>';

		html += '<div class="mx_builder_build_stream_element_body">';

			html += 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur, similique, illo. Asperiores consequatur vero aliquid repudiandae, nesciunt recusandae, qui minima, illo delectus aspernatur ducimus, eius facere consequuntur sint cumque dolor.';

		html += '</div>';

	html += '</div>';

	return html;

}