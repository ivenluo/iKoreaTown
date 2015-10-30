<?php

/**
 * Get Chinese address for Baidu Map
 * Added by Iven at 20:57 28/10/2015
 *
 * @param: $kt_addr, shop address
 * @return: Chinese address
 *
 * @author Iven
 * @since 0.0.0
 **/

function get_chinese_addr($kt_addr)
{
    $chn_addr_pat = '/[(（].+[)）]/u';
    if (preg_match($chn_addr_pat, $kt_addr, $chn_addr))
    {
        // expect "(街道地址,市名)"
        $chn_addr = $chn_addr[0];

        $dot_pos = strpos($chn_addr, ",");
        if ($dot_pos === false)
        {
            $dot_pos = strpos($chn_addr, "，");
        }

        if ($dot_pos !== false)
        {
            $chn_addr = substr($chn_addr, $dot_pos+1, -1) . substr($chn_addr, 1, $dot_pos-1);
        }
        else
        {
            $chn_addr = substr($chn_addr, 1, -1);    
        }
        
        return $chn_addr;
    }

    return '南京市';
}


/**
 * Get Chinese for Baidu Map 
 * Added by Iven at 22:44 28/10/2015
 *
 * @param 
 * @return 
 *
 * @author Iven
 * @since 0.0.0
 **/

function get_chinese($strName)
{
    $chn_pat = '/[\x{4e00}-\x{9fa5}]+/u';
    //if (preg_match_all($chn_pat, $strName, $chinese))
    if (preg_match($chn_pat, $strName, $chinese))
    {
        //return implode($chinese);
        return $chinese[0];
    }

    return '';
}


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

    // Revised by Iven at 15:26 18/10/2015
    // try to use WP's media-uploader
/*
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_script('my-upload');
    wp_enqueue_style('thickbox'); 
    echo '<input id="upload_image" type="text" value="Image URL" readonly="readonly" />';
    echo '<input id="upload_image_button" type="button" style="width:auto;height:50px;" value="Upload Image" />';
    echo '<script>
    jQuery(document).ready(function() {
        jQuery("#upload_image_button").click(function() {
         formfield = jQuery("#upload_image").attr("name");
         tb_show("", "<?php echo admin_url(); ?>media-upload.php?type=image&amp;TB_iframe=true");
         return false;
        });
        window.send_to_editor = function(html) {
         imgurl = jQuery("img",html).attr("src");
         jQuery("#upload_image").val(imgurl);
         tb_remove();
        }
    });
    </script>';
 */

    // Revised by Iven at 23:31 19/10/2015
    // add multi-file uploader by plugin
/* 
    $atts = array( 
        'allowed_mime_types' => 'jpg, jpeg, jpe, gif, png, bmp, tif, tiff, ico',
        'max_file_size' => 5);
    wp_multi_file_uploader($atts);
 */

    // Revised by Iven at 20:40 20/10/2015
    // add smilies by plugin
/*
    if(function_exists('wpml_comment')) 
    { 
        wpml_comment(); 
    } 
 */
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
