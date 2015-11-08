<?php
/**
 * Handle ajax request
 *
 * @since 0.0.0
 */
add_action( 'wp_ajax_shop_bookmark', 'kt_shop_bookmark_callback' );
//add_action( 'wp_ajax_nopriv_shop_bookmark', 'kt_shop_bookmark_callback' );

function kt_shop_bookmark_callback() {

	check_ajax_referer( '_kt_ajax_check_nonce', 'nonce_field', TRUE );

	if ( isset( $_GET['post'] ) ) {
		$post_id = sanitize_text_field( $_GET['post'] );
		$user_id = get_current_user_id();

		$bookmark = get_user_meta( $user_id, '_kt_user_bookmark', FALSE);
		if ( in_array( $post_id, $bookmark ) ) {
			$result = "Deleted current user's bookmark ";
			$result .= delete_user_meta( $user_id, '_kt_user_bookmark', $post_id );
		} else {
			$result = "Added current user's bookmark ";
			$result .= add_user_meta( $user_id, '_kt_user_bookmark', $post_id, FALSE );
		}
		echo $result;
	}
	
	wp_die(); // this is required to terminate immediately and return a proper response
}