<?php
/**
 * Define the tour custom post type.
 *
 * @since 0.0.0
 */
function kt_register_tour_post_type() {
    
    $labels = array(
        'name'                  => __( 'Tour', 'ikoreatown' ),
        'singular_name'         => __( 'Tour', 'ikoreatown' ),
        'add_new'               => __( 'Add New', 'ikoreatown' ),
        'add_new_item'          => __( 'Add New Tour', 'ikoreatown' ),
        'edit_item'             => __( 'Edit Tour', 'ikoreatown' ),
        'new_item'              => __( 'New Tour', 'ikoreatown' ),
        'all_item'              => __( 'All Tour', 'ikoreatown' ),
        'view_item'             => __( 'View Tour', 'ikoreatown' ),
        'search_items'          => __( 'Search Tour', 'ikoreatown' ),
        'not_found'             => __( 'No tour found', 'ikoreatown' ),
        'not_found_in_trash'    => __( 'No tour found in trash', 'ikoreatown' ),
        'menu_home'             => __( 'Menu Home', 'ikoreatown' )
    );
    
    $args = array(
        'labels'            => $labels,
        'public'            => TRUE,
        'public_queryable'  => TRUE,
        'show_ui'           => TRUE,
        'show_ui_menu'      => TRUE,
        'query_var'         => TRUE,
        'rewrite'           => TRUE,
        'capability_type'   => 'post',
        'has_archive'       => TRUE,
        'hierarchical'      => FALSE,
        'menu_postion'      => NULL,
        'supports'          => array(
            'title',
            'author',
            'editor',
            'thumbnail',
            'excerpt'
        )
    );
    
    register_post_type( 'tour', $args );
}
add_action( 'init', 'kt_register_tour_post_type');

/**
 * Define Tour taxonomy sport taxonomy
 *
 * @since 0.0.0
 */
function kt_register_tour_taxonomy() {
    
    $labels = array(
        'name'              => 'Tour Categories',
        'singular_name'     => 'Tour Category',
        'search_items'      => 'Search Tour Categories',
        'all_items'         => 'All Tour Category',
        'parent_item'       => 'Parent Tour Category',
        'parent_item_colon' => 'Parent Category:',
        'edit_item'         => 'Edit Tour Category',
        'update_item'       => 'Update Tour Category',
        'add_new_item'      => 'Add New Tour Category',
        'new_item_name'     => 'New Tour Category Name',
        'menu_name'         => 'Tour Category',
        'view_item'         => 'View Tour Category'
    );
    
    $args = array(
        'labels' => $labels,
        'hierarchical' => TRUE,
        'query_var' => TRUE,
        'rewrite' => TRUE,
    'show_admin_column' => TRUE
    );
    
    register_taxonomy( 'tour_category', 'tour', $args );
    
    $labels = array(
        'name'              => 'Tour Tags',
        'singular_name'     => 'Tour Tag',
        'search_items'      => 'Search Tags',
        'all_items'         => 'All Tags',
        'parent_item'       => 'Parent Tag',
        'parent_item_colon' => 'Parent Tag:',
        'edit_item'         => 'Edit Tag',
        'update_item'       => 'Update Tag',
        'add_new_item'      => 'Add New Tag',
        'new_item_name'     => 'New Locale Name',
        'menu_name'         => 'Tour Tags',
        'view_item'         => 'View Tag'
    );
    
    $args = array(
        'labels' => $labels,
        'hierarchical' => FALSE,
        'query_var' => TRUE,
        'rewrite' => TRUE
    );
    register_taxonomy( 'tour_tag', 'tour', $args );
}
add_action( 'init', 'kt_register_tour_taxonomy' );
           
/**
 * Define meta boxes in tour post type
 *
 * @since 0.0.0
*/
function kt_register_tour_meta_box() {
    
    // Create our custom meta box
    add_meta_box(
        'kt-tour-meta-box',
        'Tour Information',
        'kt_tour_meta_box_callback',
        'tour',
        'normal',
        'default'
    );
}
add_action( 'add_meta_boxes', 'kt_register_tour_meta_box' );

function kt_tour_meta_box_callback( $post, $box ) {
    // retrieve the custom meta box values
    $kt_tour_meta = get_post_meta( $post->ID, '_kt_tour_data', TRUE );
    
    // Basic Info
    $kt_price = ( ! empty($kt_tour_meta['price']) ) ? $kt_tour_meta['price'] : '';
    $kt_addr = ( ! empty($kt_tour_meta['addr']) ) ? $kt_tour_meta['addr'] : '';
    $kt_rest = ( ! empty($kt_tour_meta['rest']) ) ? $kt_tour_meta['rest'] : '';
    $kt_time_start = ( ! empty($kt_tour_meta['time_start']) ) ? $kt_tour_meta['time_start'] : '';
    $kt_time_end = ( ! empty($kt_tour_meta['time_end']) ) ? $kt_tour_meta['time_end'] : '';
    $kt_tel = ( ! empty($kt_tour_meta['tel']) ) ? $kt_tour_meta['tel'] : '';
    $kt_addr = ( ! empty($kt_tour_meta['addr']) ) ? $kt_tour_meta['addr'] : '';
    $kt_rating = ( ! empty($kt_tour_meta['rating']) ) ? $kt_tour_meta['rating'] : '';
    
    // Other Info
    $kt_others = ( ! empty($kt_tour_meta['others']) ) ? $kt_tour_meta['ohters'] : '';
    
    // nonce for security
    wp_nonce_field( 'kt-tour-meta-box-nonce-check', 'kt_save_meta_box' );
    
    // custom meta box form elements
    ?>
    <h4>Basic Info</h4>
    <table>
        <tr>
            <td><?php _e( 'Ticket', 'ikoreatown' ); ?> :</td>
            <td><?php echo '<input type="tel" name="kt_tour[price]" value="' . esc_attr( $kt_price ) . '" size="30">'; ?></td>
        </tr>
        <tr>
            <td><?php _e( 'Address', 'ikoreatown' ); ?> :</td>
            <td><?php echo '<textarea type="textarea" name="kt_tour[addr]" rows="3" cols="50">' . esc_textarea( $kt_addr) . '</textarea>'; ?></td>
        </tr>
        <tr>
            <td><?php _e( 'Tel', 'ikoreatown' ); ?> :</td>
            <td><?php echo '<input type="tel" name="kt_tour[tel]" value="' . esc_attr( $kt_tel ) . '" size="30">'; ?></td>
        </tr>
        <tr>
            <td><?php _e( 'Days for resting', 'ikoreatown' ); ?> :</td>
            <td><?php echo  '<input type="text" name="kt_tour[rest]" value="' . esc_attr( $kt_rest ) . '" size="30">'; ?></td>
        </tr>
        <tr>
            <td><?php _e( 'Time Start', 'ikoreatown' ); ?> :</td>
            <td><?php echo  '<input type="time" name="kt_tour[time_start]" value="' . esc_attr( $kt_time_start ) . '">'; ?></td>
        </tr>
        <tr>
            <td><?php _e( 'Time End', 'ikoreatown' ); ?> :</td>
            <td><?php echo  '<input type="time" name="kt_tour[time_end]" value="' . esc_attr( $kt_time_end ) . '">'; ?></td>
        </tr>
        <tr>
            <td><?php _e( 'Rating', 'ikoreatown' ); ?> :</td>
            <td><?php echo  '<input type="range" name="kt_tour[rating]" value="' . esc_attr( $kt_rating ) . '" min="1" max="5"'; ?></td>
        </tr>
    </table>

    <h4>Others</h4>
    <?php echo '<textarea type="textarea" name="kt_tour[others]" rows="3" cols="100">' . esc_textarea( $kt_others) . '</textarea>';
}

/**
 * Save tour meta box data when the tour post is saved
 *
 * @since 0.0.0
 */
function kt_tour_save_meta_box( $post_id ) {
    
    // Process tour data if $_POST is set
    if ( get_post_type( $post_id ) == 'tour' && isset( $_POST['kt_tour'] ) ) {
        
        // if auto saving skip saving our meta box data
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return;
        
        // Check nonce for security
        wp_verify_nonce( 'kt-tour-meta-box-nonce-check', 'kt_save_meta_box' );
        
        // Save the meta box data as post meta using the post ID as a unique prefix
        $kt_tour_data = array_map( 'sanitize_text_field', $_POST['kt_tour'] );
        update_post_meta( $post_id, '_kt_tour_data', $kt_tour_data );   
    }
    
    $count = get_post_meta( $post_id, '_kt_view_count', TRUE );
    if ( empty( $count ) ) {
        add_post_meta( $post_id, '_kt_view_count', 0, TRUE );
    }
    $rating = get_post_meta( $post_id, '_kt_tour_rating', TRUE );
    if ( empty( $rating ) ) {
        add_post_meta( $post_id, '_kt_tour_rating', 0 , TRUE );
    }
}
add_action( 'save_post', 'kt_tour_save_meta_box' );