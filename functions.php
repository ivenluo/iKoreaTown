<?php
/**
 * Stargazer-Child functions and definitions
 *
 * @package iKoreaTown
 * @since iKoreaTown 0.0.0
 */

/**
 * Session init
 *
 * @since 0.0.0
 */
function kt_session_start() {
    if ( ! session_id() ) {
        session_start();
    }
}
add_action( 'init', 'kt_session_start', 1);

/**
 * Register ikoreatown text domain.
 *
 * @since 0.0.0
 */
function kt_load_textdomain() {
    load_plugin_textdomain( 'ikoreatown', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'kt_load_textdomain' );

/**
 * Gravatar using ssl
 *
 * @since 0.0.0
 */
function kt_get_ssl_avatar( $avatar ) {
   $avatar = preg_replace(
            '/.*\/avatar\/(.*)\?s=([\d]+)&.*/',
            '<img src="https://secure.gravatar.com/avatar/$1?s=$2" class="avatar avatar-$2" height="$2" width="$2">',
            $avatar);
   return $avatar;
}
add_filter('get_avatar', 'kt_get_ssl_avatar');

/**
 * Init shop custom post type 
 *
 * @since 0.0.0
 */
require_once get_stylesheet_directory() . '/inc/shop-init.php';

/**
 * Init tour custom post type
 *
 * @since 0.0.0
 */
require_once get_stylesheet_directory() . '/inc/tour-init.php';

/**
 * Custom template tags for this theme.
 *
 * @since 0.0.0
 */
require_once get_stylesheet_directory() . '/inc/template-tags.php';

/**
 * Comment functions.
 *
 * @since 0.0.0
 */
require_once get_stylesheet_directory() . '/inc/comment-functions.php';

/**
 * AJAX functions.
 *
 * @since 0.0.0
 */
require_once get_stylesheet_directory() . '/inc/ajax-functions.php';

/**
 * Shop custom post type related functions.
 *
 * @since 0.0.0
 */
require_once get_stylesheet_directory() . '/inc/shop-related-functions.php';

/**
 * Loads javascript files.
 *
 * @since 0.0.0
 */
add_action( 'wp_enqueue_scripts', 'kt_load_scripts' );

function kt_load_scripts() {

    // Load jQuery
    //wp_enqueue_script( 'jquery' );

    // Register functions javascript files
    wp_register_script( 'kt_js_functions', get_stylesheet_directory_uri() . '/js/functions.js', array( 'jquery-ui-tabs' ), '0.0.0', true );

    // Enqueue functions javascript files
    wp_enqueue_script( 'kt_js_functions' );

    // Register jQuery UI CSS files
    wp_register_style( 'jquery-ui-css', get_stylesheet_directory_uri() . '/css/jquery-ui-blitzer.css');

    // Enqueue jQuery UI CSS
    wp_enqueue_style( 'jquery-ui-css' );

    // Register ajax javascript files
    wp_register_script( 'kt_js_ajax', get_stylesheet_directory_uri() . '/js/ajax.js', array( 'jquery' ), '0.0.0', true );

    $localize = array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'auth' => wp_create_nonce( '_kt_ajax_check_nonce' )
        );
    wp_localize_script( 'kt_js_ajax', 'kt_ajax_objects', $localize );

    // Enqueue ajax javascript files
    wp_enqueue_script( 'kt_js_ajax' );
}

/**
 * Chage the main loop order of taxonomy archive
 *
 * @since 0.0.0
 */
add_action( 'pre_get_posts', 'kt_change_main_loop_order' );

function kt_change_main_loop_order( $query ) {
    
    if ( is_tax( 'shop_category' ) || is_tax( 'shop_tag' ) ) {
        if ( $query->is_main_query() && ! is_admin() ) {
            $query->set( 'orderby', 'meta_value_num' );
            $query->set( 'meta_key', '_kt_view_count' );
        }
    }
}

/**
 * Add view count column to the manage screen
 *
 * @since 0.0.0
 */
add_filter( 'manage_posts_columns', 'kt_add_view_count_column' );

function kt_add_view_count_column( $columns ) {
    return array_merge(
        $columns, array(
            'post_view_count' => __('Views')
        )
    );
}


/**
 * Display post view count to the views column of manage screen
 *
 * @since 0.0.0
 */
add_action( 'manage_posts_custom_column', 'kt_display_view_count_column', 10, 2 );

function kt_display_view_count_column( $column, $post_id ) {
    switch ( $column ) {
        case 'post_view_count' :
            echo get_post_meta( $post_id, '_kt_view_count', TRUE );
    }
}

/**
 * Login iKoreaTown with user email
 *
 * @since 0.0.0
 */
add_action( 'wp_authenticate', 'kt_authenticate_by_email' );

function kt_authenticate_by_email( &$username ) {
    $user = get_user_by( 'email', $username );

    if( ! empty( $user ) )
      $username = $user->user_login;

    return;
}

/**
 * Change the Username of wp-login.php
 *
 * @since 0.0.0
 */
add_action( 'login_form_login', function(){
    add_filter( 'gettext', function($text){
        if( 'Username' === $text ){
            return 'Email or Username';
        }else{
            return $text;
        }
    }, 20);
});