<?php
/**
 * functions for initializing shop custom post type
 *
 * @since 0.0.0
 */


/**
 * Define the shops custom post type.
 *
 * @since 0.0.0
 */
function kt_register_shop_post_type() {
    
    $labels = array(
        'name'                  => __( 'Shops', 'ikoreatown' ),
        'singular_name'         => __( 'Shop', 'ikoreatown' ),
        'add_new'               => __( 'Add New', 'ikoreatown' ),
        'add_new_item'          => __( 'Add New Shop', 'ikoreatown' ),
        'edit_item'             => __( 'Edit Shop', 'ikoreatown' ),
        'new_item'              => __( 'New Shop', 'ikoreatown' ),
        'all_item'              => __( 'All Shops', 'ikoreatown' ),
        'view_item'             => __( 'View Shops', 'ikoreatown' ),
        'search_items'          => __( 'Search Shop', 'ikoreatown' ),
        'not_found'             => __( 'No shop found', 'ikoreatown' ),
        'not_found_in_trash'    => __( 'No shop found in trash', 'ikoreatown' ),
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
            'excerpt',
	    'comments'
        )
    );
    
    register_post_type( 'my-shops', $args );
}
add_action( 'init', 'kt_register_shop_post_type' );

/**
 * Define shop taxonomy sport taxonomy
 *
 * @since 0.0.0
 */
function kt_register_shop_taxonomy() {
    
    $labels = array(
        'name'              => 'Shop Categories',
        'singular_name'     => 'Shop Category',
        'search_items'      => 'Search Shop Categories',
        'all_items'         => 'All Shop Category',
        'parent_item'       => 'Parent Shop Category',
        'parent_item_colon' => 'Parent Category:',
        'edit_item'         => 'Edit Shop Category',
        'update_item'       => 'Update Shop Category',
        'add_new_item'      => 'Add New Shop Category',
        'new_item_name'     => 'New Shop Category Name',
        'menu_name'         => 'Shop Category',
        'view_item'         => 'View Shop Category'
    );
    
    $args = array(
        'labels' => $labels,
        'hierarchical' => TRUE,
        'query_var' => TRUE,
        'rewrite' => TRUE,
	'show_admin_column' => TRUE
    );
    
    register_taxonomy( 'shop_category', 'my-shops', $args );
    
    $labels = array(
        'name'              => 'Location Categories',
        'singular_name'     => 'Location Category',
        'search_items'      => 'Search Location Categories',
        'all_items'         => 'All Location Category',
        'parent_item'       => 'Parent Location Category',
        'parent_item_colon' => 'Parent Category:',
        'edit_item'         => 'Edit Location Category',
        'update_item'       => 'Update Location Category',
        'add_new_item'      => 'Add New Location Category',
        'new_item_name'     => 'New Location Category Name',
        'menu_name'         => 'Location Category',
        'view_item'         => 'View Location Category'
    );
    
    $args = array(
        'labels' => $labels,
        'hierarchical' => TRUE,
        'query_var' => TRUE,
        'rewrite' => TRUE,
	'show_admin_column' => TRUE
    );
    
    register_taxonomy( 'location_category', 'my-shops', $args );
    
    $labels = array(
        'name'              => 'Shop Tags',
        'singular_name'     => 'Shop Tag',
        'search_items'      => 'Search Tags',
        'all_items'         => 'All Tags',
        'parent_item'       => 'Parent Tag',
        'parent_item_colon' => 'Parent Tag:',
        'edit_item'         => 'Edit Tag',
        'update_item'       => 'Update Tag',
        'add_new_item'      => 'Add New Tag',
        'new_item_name'     => 'New Locale Name',
        'menu_name'         => 'Shop Tags',
        'view_item'         => 'View Tag'
    );
    
    $args = array(
        'labels' => $labels,
        'hierarchical' => FALSE,
        'query_var' => TRUE,
        'rewrite' => TRUE
    );
    register_taxonomy( 'shop_tag', 'my-shops', $args );
}
add_action( 'init', 'kt_register_shop_taxonomy' );

/**
 * Define meta boxes in shop post type
 *
 * @since 0.0.0
*/
function kt_register_shop_meta_box() {
    
    // Create our custom meta box
    add_meta_box(
        'kt-shop-meta-box',
        'Shop Information',
        'kt_shop_meta_box_callback',
        'my-shops',
        'normal',
        'default'
    );
}
add_action( 'add_meta_boxes', 'kt_register_shop_meta_box' );

// Shop meta box callback function
function kt_shop_meta_box_callback( $post, $box ) {
    
    // retrieve the custom meta box values
    $kt_shop_meta = get_post_meta( $post->ID, '_my_shop_data', TRUE );
    $kt_shop_ppp = get_post_meta( $post->ID, '_kt_shop_ppp', TRUE );
    $kt_shop_rating = get_post_meta( $post->ID, '_kt_shop_rating', TRUE );
    
    // Basic Info
    $kt_tel = ( ! empty( $kt_shop_meta['tel']) ) ? $kt_shop_meta['tel'] : '';
    $kt_addr = ( ! empty( $kt_shop_meta['addr']) ) ? $kt_shop_meta['addr'] : '';

    $kt_price_per_person = ( empty($kt_shop_ppp) ) ? '' : $kt_shop_ppp;
    $kt_shop_rating = ( empty( $kt_shop_rating ) ) ? '' : $kt_shop_rating;
	
    // More Info
    $kt_reservation = ( ! empty( $kt_shop_meta['reservation']) ) ? $kt_shop_meta['reservation'] : '';
    $kt_lang = ( ! empty($kt_shop_meta['lang']) ) ? $kt_shop_meta['lang'] : '';
    $kt_rest = ( ! empty($kt_shop_meta['rest']) ) ? $kt_shop_meta['rest'] : '';
    $kt_time_start = ( ! empty($kt_shop_meta['time_start']) ) ? $kt_shop_meta['time_start'] : '';
    $kt_time_end = ( ! empty($kt_shop_meta['time_end']) ) ? $kt_shop_meta['time_end'] : '';
    $kt_parking = ( ! empty($kt_shop_meta['parking']) ) ? $kt_shop_meta['parking'] : '';
    $kt_bath = ( ! empty($kt_shop_meta['bath']) ) ? $kt_shop_meta['bath'] : '';
    
    $kt_wifi = ( ! empty($kt_shop_meta['wifi']) ) ? $kt_shop_meta['wifi'] : '';
    $kt_table = ( ! empty($kt_shop_meta['table']) ) ? $kt_shop_meta['table'] : '';
    $kt_room = ( ! empty($kt_shop_meta['room']) ) ? $kt_shop_meta['room'] : '';
    $kt_email = ( ! empty($kt_shop_meta['email']) ) ? $kt_shop_meta['email'] : '';
    $kt_site = ( ! empty($kt_shop_meta['site']) ) ? $kt_shop_meta['site'] : '';
    $kt_delivery = ( ! empty($kt_shop_meta['delivery']) ) ? $kt_shop_meta['delivery'] : '';
    
    // Event
    $kt_event = ( ! empty($kt_shop_meta['event']) ) ? $kt_shop_meta['event'] : '';
    // VIP
    $kt_vip = ( ! empty($kt_shop_meta['vip']) ) ? $kt_shop_meta['vip'] : '';
    // Price
    $kt_price = ( ! empty($kt_shop_meta['price']) ) ? $kt_shop_meta['price'] : '';
    // Other Info
    $kt_others = ( ! empty($kt_shop_meta['others']) ) ? $kt_shop_meta['ohters'] : '';
    
    // nonce for security
    wp_nonce_field( 'kt-shop-meta-box-nonce-check', 'kt_save_meta_box' );
    
    // custom meta box form elements
    ?>
    <h4>Basic Info</h4>
    <table>
        <tr>
            <td><?php echo '<label for="kt_shop[tel]">' . __( 'Tel', 'ikoreatown' ) . '</label>'; ?> :</td>
            <td><?php echo '<input type="tel" id="kt_shop[tel]" name="kt_shop[tel]" value="' . esc_attr( $kt_tel ) . '" size="30">'; ?></td>
        </tr>
        <tr>
            <td><?php echo '<label for="kt_shop[addr]">' . __( 'Address', 'ikoreatown' ) . '</label>'; ?> :</td>
            <td><?php echo '<textarea type="textarea" id="kt_shop[addr]" name="kt_shop[addr]" rows="3" cols="50">' . esc_textarea( $kt_addr) . '</textarea>'; ?></td>
        </tr>
        <tr>
            <td><?php _e( 'Rating', 'ikoreatown' ); ?> :</td>
            <td><?php echo '<input type="text" id="kt_shop[rating]" name="kt_shop[rating]" value="' . esc_attr( $kt_shop_rating ) . '" size="30">'; ?></td>
        </tr>
        <tr>
            <td><?php echo '<label for="kt_shop[price_per_person]">' . __( 'Average Price Per Person', 'ikoreatown' ) . '</label>'; ?> :</td>
            <td><?php echo '<input type="text" id="kt_shop[price_per_person]" name="kt_shop[price_per_person]" value="' . esc_attr( $kt_price_per_person ) . '" size="30">'; ?></td>
        </tr>
    </table>

    <h4>More Info</h4>
    <table>
        <tr>
            <td><?php _e( 'Reservation', 'ikoreatown' ); ?> :</td>
            <td>
                <?php echo  '<input type="radio" name="kt_shop[reservation]" value="yes"' . checked( $kt_reservation, 'yes', FALSE ) . '> Yes'; ?>
                <?php echo  '<input type="radio" name="kt_shop[reservation]" value="no"' . checked( $kt_reservation, 'no', FALSE ) . '> No'; ?>
                <?php echo  '<input type="radio" name="kt_shop[reservation]" value=""' . checked( $kt_reservation, '', FALSE ) . '> Unset'; ?>
            </td>
        </tr>
        <tr>
            <td><?php _e( 'Language', 'ikoreatown' ); ?> :</td>
            <td><?php echo '<input type="text" name="kt_shop[lang]" value="' . esc_attr( $kt_lang ) . '" size="30">'; ?></td>
        </tr>
        <tr>
            <td><?php _e( 'Days for resting', 'ikoreatown' ); ?> :</td>
            <td><?php echo  '<input type="text" name="kt_shop[rest]" value="' . esc_attr( $kt_rest ) . '" size="30">'; ?></td>
        </tr>
        <tr>
            <td><?php _e( 'Time Start', 'ikoreatown' ); ?> :</td>
            <td><?php echo  '<input type="time" name="kt_shop[time_start]" value="' . esc_attr( $kt_time_start ) . '">'; ?></td>
        </tr>
        <tr>
            <td><?php _e( 'Time End', 'ikoreatown' ); ?> :</td>
            <td><?php echo  '<input type="time" name="kt_shop[time_end]" value="' . esc_attr( $kt_time_end ) . '">'; ?></td>
        </tr>
        <tr>
            <td><?php _e( 'WiFi', 'ikoreatown' ); ?> :</td>
            <td><?php echo '<input type="text" name="kt_shop[wifi]" value="' . esc_attr( $kt_wifi ) . '" size="30">'; ?></td>
        </tr>
        <tr>
            <td><?php _e( 'Parking', 'ikoreatown' ); ?> :</td>
            <td><?php echo '<input type="text" name="kt_shop[parking]" value="' . esc_attr( $kt_parking ) . '" size="30">'; ?></td>
        </tr>
        <tr>
	    <td><?php _e( 'Room', 'ikoreatown' ); ?> :</td>
	    <td><?php echo '<input type="text" name="kt_shop[room]" value="' . esc_attr( $kt_room ) . '" size="30">' ; ?></td>
        </tr>
        <tr>
	    <td><?php _e( 'Table', 'ikoreatown' ); ?> :</td>
	    <td><?php echo '<input type="text" name="kt_shop[table]" value="' . esc_attr( $kt_table ) . '" size="30">' ; ?></td>
        </tr>
        <tr>
	    <td><?php _e( 'Bathroom', 'ikoreatown' ); ?> :</td>
	    <td>
            <?php echo '<input type="radio" name="kt_shop[bath]" value="yes"' . checked( $kt_bath, 'yes', FALSE ) . '>Yes  '; ?>
            <?php echo '<input type="radio" name="kt_shop[bath]" value="no"' . checked( $kt_bath, 'no', FALSE ) . '>No  '; ?>
            <?php echo '<input type="radio" name="kt_shop[bath]" value=""' . checked( $kt_bath, '', FALSE ) . '>Unset  '; ?>
	    </td>
	</tr>
        <tr>
            <td><?php _e( 'Delivery', 'ikoreatown' ); ?> :</td>
            <td><?php echo '<input type="text" name="kt_shop[delivery]" value="' . esc_attr( $kt_delivery ) . '" size="30">' ; ?></td>
        </tr>
        <tr>
            <td><?php _e( 'Email', 'ikoreatown' ); ?> :</td>
            <td><?php echo '<input type="text" name="kt_shop[email]" value="' . esc_attr( $kt_email ) . '" size="30">'; ?></td>
        </tr>
        <tr>
            <td><?php _e( 'Website', 'ikoreatown' ); ?> :</td>
            <td><?php echo '<input type="text" name="kt_shop[site]" value="' . esc_attr( $kt_site ) . '" size="30">'; ?></td>
        </tr>
    </table>

    <h4>Event</h4>
    <?php echo '<textarea type="textarea" name="kt_shop[event]" rows="3" cols="50">' . esc_textarea( $kt_event) . '</textarea>'; ?>

    <h4>Price</h4>
    <?php echo '<textarea type="textarea" name="kt_shop[price]" rows="3" cols="50">' . esc_textarea( $kt_price) . '</textarea>'; ?>
    
    <h4>VIP</h4>
    <?php echo '<textarea type="textarea" name="kt_shop[vip]" rows="3" cols="50">' . esc_textarea( $kt_vip) . '</textarea>'; ?>
    
    <h4>Others</h4>
    <?php echo '<textarea type="textarea" name="kt_shop[others]" rows="3" cols="50">' . esc_textarea( $kt_others) . '</textarea>';
}

/**
 * Save shop meta box data when the shop post is saved
 *
 * @since 0.0.0
 */
function kt_shop_save_meta_box( $post_id ) {
    
    // Process shop data if $_POST is set
    if ( get_post_type( $post_id ) == 'my-shops' && isset( $_POST['kt_shop'] ) ) {
        
        // if auto saving skip saving our meta box data
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return;
        
        // Check nonce for security
        wp_verify_nonce( 'kt-shop-meta-box-nonce-check', 'kt_save_meta_box' );
        
        // Save the meta box data as post meta using the post ID as a unique prefix
        $kt_shop_data = array_map( 'sanitize_text_field', $_POST['kt_shop'] );
        update_post_meta( $post_id, '_my_shop_data', $kt_shop_data );
		update_post_meta( $post_id, '_kt_shop_ppp', $kt_shop_data['price_per_person'] );

	   if ( ! empty( $kt_shop_data['event'] ) ) {
	       wp_set_object_terms( $post_id, 'event', 'shop_tag', TRUE );
	   } else {
	       wp_set_object_terms( $post_id, null, 'shop_tag' );
	   }
    }
    
    $count = get_post_meta( $post_id, '_kt_view_count', TRUE );
    if ( empty( $count ) ) {
        add_post_meta( $post_id, '_kt_view_count', 0, TRUE );
    }
    $rating = get_post_meta( $post_id, '_kt_shop_rating', TRUE );
    if ( empty( $rating ) ) {
        add_post_meta( $post_id, '_kt_shop_rating', 0, TRUE );
    }
}
add_action( 'save_post', 'kt_shop_save_meta_box' );