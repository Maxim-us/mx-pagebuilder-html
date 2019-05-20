jQuery( document ).ready( function( $ ) {

	$( '.mxmph_builder_switcher_button' ).on( 'click', function( e ) {

		e.preventDefault();

		var get_button_id = $( this ).attr( 'id' );

		var button_id = get_button_id;

		var post_id = $( this ).attr( 'data-post-id' );

		var data = {
			'action'		: 'mxmph_update_mx_builder_option',
			'nonce'			: mx_builder_builder_button_switcher_localize.mx_sequre,
			'button_id' 	: button_id,
			'post_id' 		: post_id
		};

		// console.log( data );

		mxmph_update_switcher_button_option( data );


	} );

} );

// update post type options
function mxmph_update_switcher_button_option( data ) {

	jQuery.post( ajaxurl, data, function( response ) {

		// console.log( response );
		location.reload();

	} );

}