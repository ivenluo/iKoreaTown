<?php
/**
 * Add custom fields rating.
 *
 * @since 0.0.0
 */

add_action( 'comment_form_logged_in_after', 'kt_custom_comment_fields' );
//add_action( 'comment_form_after_fields', 'kt_custom_comment_fields' );

function kt_custom_comment_fields() {
    echo '<div class="comment-meta-box">';
    echo '<div class="comment-form-rating">' . '<label for="rating">'. __('Rating: ') . '<span class="required">*</span></label><span class="commentratingbox">';
    for( $i=1; $i <= 5; $i++ )
        echo '<span class="commentrating"><input type="radio" name="rating" id="rating" value="'. $i .'"/>'. $i .'</span>';
    echo '</span></div>';
}

/**
 * Save the comment meta data along with comment
 *
 * @since 0.0.0
 */
add_action( 'comment_post', 'kt_save_comment_meta_data' );

function kt_save_comment_meta_data( $comment_id ) {
    if ( ( isset( $_POST['rating'] ) ) && ( $_POST['rating'] != '') ) {
        $rating = wp_filter_nohtml_kses( $_POST['rating'] );
        add_comment_meta( $comment_id, 'rating', $rating, TRUE );
    }
}

/**
 * Update the commemt meta data 'rating' when comment status changed
 *
 * @since 0.0.0
 */
add_action( 'edit_comment', 'kt_recalculate_comment_meta_rating' );
add_action( 'comment_post', 'kt_recalculate_comment_meta_rating' );
add_action( 'comment_unapproved_to_approved', 'kt_recalculate_comment_meta_rating' );
add_action( 'comment_approved_to_unapproved', 'kt_recalculate_comment_meta_rating' );
add_action( 'comment_spam_to_approved', 'kt_recalculate_comment_meta_rating' );
add_action( 'comment_approved_to_spam', 'kt_recalculate_comment_meta_rating' );
add_action( 'comment_approved_to_trash', 'kt_recalculate_comment_meta_rating' );
add_action( 'comment_trash_to_approved', 'kt_recalculate_comment_meta_rating' );

function kt_recalculate_comment_meta_rating( $comment ) {
    if ( ! is_object( $comment ) ) {
        $comment = get_comment( $comment );
    }
    $post_id = $comment->comment_post_ID;
    $post_type = get_post_type( $post_id );

    if ( $post_type == 'my-shops' ) {
        $avg = 0;
        global $wpdb;
        $query = "SELECT AVG(meta_value) FROM $wpdb->commentmeta ";
        $query .= "INNER JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID ";
        $query .= "WHERE $wpdb->commentmeta.meta_key = %s ";
        $query .= "AND $wpdb->comments.comment_approved = %d ";
        $query .= "AND $wpdb->comments.comment_post_ID = %d";
        if( $result = $wpdb->get_var( $wpdb->prepare( $query, 'rating', 1, $post_id ) ) ) {
            $result = round( $result, 3 );
            update_post_meta( $post_id, '_kt_shop_rating', $result );
        }else{
            update_post_meta( $post_id, '_kt_shop_rating', 0 );
        }
    }


}

/**
 * Add the filter to check whether the comment meta data has been filled
 *
 * @since 0.0.0
 */

add_filter( 'preprocess_comment', 'kt_verify_comment_meta_data' );

function kt_verify_comment_meta_data( $commentdata ) {
    if ( ! isset( $_POST['rating'] ) )
        wp_die( __( 'Error: You did not add a rating.' ) );
    return $commentdata;
}

/**
 * Add an edit option to comment editing screen  
 *
 * @since 0.0.0
 */
add_action( 'add_meta_boxes_comment', 'extend_comment_add_meta_box' );

function extend_comment_add_meta_box() {
    add_meta_box( 'title', __( 'Comment Metadata - Extend Comment' ), 'extend_comment_meta_box', 'comment', 'normal', 'high' );
}

function extend_comment_meta_box ( $comment ) {
    $rating = get_comment_meta( $comment->comment_ID, 'rating', true );
    wp_nonce_field( 'extend_comment_update', 'extend_comment_update', false ); ?>
    <p>
        <label for="rating"><?php _e( 'Rating: ' ); ?></label>
        <span class="commentratingbox">
        <?php for( $i=1; $i <= 5; $i++ ) {
            echo '<span class="commentrating"><input type="radio" name="rating" id="rating" value="'. $i .'"';
            if ( $rating == $i ) echo ' checked="checked"';
                echo ' />'. $i .' </span>';
            }?>
        </span>
    </p>
    <?php
}

/**
 * Update comment meta data from comment editing screen 
 *
 * @since 0.0.0
 */

add_action( 'edit_comment', 'extend_comment_edit_metafields' );

function extend_comment_edit_metafields( $comment_id ) {
    if( ! isset( $_POST['extend_comment_update'] ) || ! wp_verify_nonce( $_POST['extend_comment_update'], 'extend_comment_update' ) ) 
        return;

    if ( ( isset( $_POST['rating'] ) ) && ( $_POST['rating'] != '') ):
            $rating = wp_filter_nohtml_kses($_POST['rating']);
            update_comment_meta( $comment_id, 'rating', $rating );
    else :
        delete_comment_meta( $comment_id, 'rating');
    endif;
}

/**
 * User comment list custom callback function.
 * 
 * @since 0.0.0
 */
function kt_user_reviews_list_callback( $comment, $args, $depth ) {

    $post_id = $comment->comment_post_ID;
    //$user_id = $args->user_id;
    $post = get_post( $post_id );
    $post_thumbnail = get_the_post_thumbnail( $post_id, 'thumbnail' );
    $shop_category = get_the_terms( $post_id, 'shop_category' );
    $location = get_the_terms( $post_id, 'location_category' );
    ?>
    <li <?php hybrid_attr( 'comment' ); ?>>

    <article>
        <header class="comment-meta">
            <div class="list-thumbnail">
                <a href=" <?php echo esc_url( $post->guid ); ?>">
                    <figure>
                        <?php echo $post_thumbnail; ?>
                    </figure>    
                </a>
            </div>
            <div class="list-info">
                <a href=" <?php echo esc_url( $post->guid ); ?>">
                    <ul>
                        <?php echo $post->post_title; ?>
                    </ul>
                </a>
                <ul>
                    <?php foreach( $shop_category as $item ) { ?>
                        <li> <?php echo  $item->name; ?> </li>
                    <?php } ?>
                </ul>
                <ul>
                    <?php foreach( $location as $item ) { ?>
                        <li> <?php echo  $item->name; ?> </li>
                    <?php } ?>
                </ul>
            </div>

        </header><!-- .comment-meta -->
        
        <div <?php hybrid_attr( 'comment-content' ); ?>>
            <section>
                <span> 
                    <time <?php hybrid_attr( 'comment-published' ); ?>><?php printf( __( '%s ago', 'stargazer' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ); ?></time>
                </span>
                <span>
                    <?php if( $comment_rating = get_comment_meta( get_comment_ID(), 'rating', true ) ) {
                        $comment_rating = '<div class="comment-rating"> Rating: <strong>'. $comment_rating . '</strong></div>'; 
                        echo $comment_rating;
                    }?>
                </span>
                </section>
            <?php comment_text(); ?>
            <footer>
                <?php edit_comment_link(); ?>
                <?php if ( ! empty( $comment->user_id ) && $comment->user_id == get_current_user_id() ) : ?>
                    <form method="post" action="<?php get_page_link(); ?>">
                        <?php wp_nonce_field( 'kt_update_reviews', 'kt_nonce_field' ) ?>
                        <button type="submit" name="delete" value="<?php echo $comment->comment_ID; ?>">Delete</button>
                    </form>
                <?php endif ?>
            </footer>
        </div><!-- .comment-content -->

        <?php hybrid_comment_reply_link(); ?>
    </article>
<?php
}