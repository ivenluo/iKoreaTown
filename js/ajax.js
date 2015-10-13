/**
 * Ajax for iKoreaTown theme
 */

( function( $ ) {
	$( document ).ready( function() {

		$( '#bookmark' ).click( function() {
			var post_id = $( this ).attr( 'rel' );
			
			if ( kt_ajax_objects.ajaxurl != '') {
				jQuery.ajax({
					url: kt_ajax_objects.ajaxurl, 
					type:'GET', 
					timeout: 5000,
					dataType: 'html',
					data: { action: 'shop_bookmark', post: post_id, 'nonce_field': kt_ajax_objects.auth },
					error: function( xml) {
						alert( 'There is something error.' );
					},
					success: function( response ) {
						if ( response != -1 ) {
							alert( 'Got the message from server: ' + response );
						} else {
							alert( 'Server returns error, Error number is ' + response );
						}
						
					},
					complete: function() {
						// A function to be called when the request finishes (after success and error callbacks are executed). 
					}
				});
			}
		} );

	});
})( jQuery );