/**
 * Theme javascript functions file.
 *
 * @since 0.0.0
 */

( function( $ ) {
	$( document ).ready( function() {

		// Shop content tabbed panel
		$('.tabbedPanels').tabs();

		// Login Panel for logged-in user
		$( '#logged-in' ).click( function( event ) {
            event.preventDefault();
            $( '#login-panel' ).slideToggle(100);
    	});
    	
	});
})( jQuery );