<?php
/**
 * The page template for displaying user reviews.
 *
 * @package iKoreaTown
 * @since 0.0.0
 */

get_header(); ?>

<main <?php hybrid_attr( 'content' ); ?> >

    <?php if ( is_user_logged_in() ) : ?>
        <?php if ( isset( $_POST['kt_nonce_field'] ) && wp_verify_nonce( $_POST['kt_nonce_field'], 'kt_update_reviews' ) ) {
            if ( isset( $_POST['delete'] ) ) {
                $comment_id = $_POST['delete'];
                wp_delete_comment( $comment_id );
            }
        }?>
        <h1 <?php hybrid_attr( 'entry-title' ); ?>>My Reviews</h1>
            
            <?php $current_user_id = get_current_user_ID();
            
            # The comment functions use the query var 'cpage', so we'll ensure that's set
            $page = intval( get_query_var( 'cpage' ) );
            if ( 0 == $page ) {
                $page = 1;
                set_query_var( 'cpage', $page );
            }

            # We'll do 10 comments per page...
            # Note that the 'page_comments' option in /wp-admin/options-discussion.php must be checked
            $comments_per_page = 10;
            $args = array(
                    'user_id' => $current_user_id,
                    'status' => 'approve',
            );
            $comments = get_comments( $args );?>

            <ul start="<?php echo $comments_per_page * $page - $comments_per_page + 1 ?>">
                <?php wp_list_comments( array (
                    'style' => 'ul',
                    'per_page' => $comments_per_page,
                    'page' => $page,
                    'reverse_top_level' => false,
                    'callback' => 'kt_user_reviews_list_callback'
                ), $comments ); ?>
            </ul>

            <?php # Now you can either use paginate_comments_links ... ?>
            <?php paginate_comments_links(); ?>

    <?php else : ?>
        <a href="<?php echo wp_login_url( get_permalink() ); ?>" title="Login">Login</a>
    <?php endif ?>

</main>

<?php hybrid_get_sidebar( 'user-sidebar' ); ?>
<?php get_footer(); // Loads the footer.php template. ?>