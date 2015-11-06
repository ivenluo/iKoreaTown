<?php
/**
 * The page template for displaying user shop bookmarks.
 *
 * @package iKoreaTown
 * @since 0.0.0
 */

get_header(); ?>

<main <?php hybrid_attr( 'content' ); ?> >

        <?php if ( is_user_logged_in() ) : ?>
            <h1 <?php hybrid_attr( 'entry-title' ); ?>>My Shop Bookmarks</h1>
            <?php $current_user_id = get_current_user_ID();

            if ( isset( $_POST['kt_nonce_field'] ) && wp_verify_nonce( $_POST['kt_nonce_field'], 'kt_update_bookmarks' ) ) {
                if ( isset( $_POST['delete'] ) ) {
                    $post_id = $_POST['delete'];
                    delete_user_meta( $current_user_id, '_kt_user_bookmark', $post_id );
                }
            }

            // Get user's shop bookmarks
            $shop_bookmarks = get_user_meta( $current_user_id, '_kt_user_bookmark', FALSE );

            if ( ! empty( $shop_bookmarks ) ) :
                $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
                $args = array(
                    'post_type' => 'my-shops',
                    'post__in' => $shop_bookmarks,
                    'posts_per_page' => 6,
                    'paged' => $paged
                    );
                $kt_query = new WP_Query( $args );

                if ( $kt_query->have_posts() ) : ?>
                    <?php echo '<div>'; ?>
                    <?php while ( $kt_query->have_posts() ) : $kt_query->the_post();

                        $post_id = get_the_ID();
                        $kt_shop_meta = get_post_meta( $post_id, '_my_shop_data', TRUE );
                        $kt_shop_ppp = get_post_meta( $post_id, '_my_shop_ppp', TRUE );
                        $kt_shop_rating = get_post_meta( $post_id, '_kt_shop_rating', TRUE );

                        $shop_category = get_the_terms( $post_id, 'shop_category' );
                        $location_category = get_the_terms( $post_id, 'location_category' );

                    ?>
                    <div class="bookmark-box">
                        <div class="shop-box">
                            <a href="<?php echo the_permalink(); ?>">
                                <figure>
                                    <?php echo the_post_thumbnail( 'thumbnail' ); ?>
                                    <figcaption>
                                        <ul>
                                            <?php echo the_title(); ?>
                                        </ul>
                                    </figcaption>
                                </figure>
                            </a>
                        </div>
                        <div class="shop-info">
                            <ul>
                                <li> <?php echo '평점: ' . $kt_shop_rating; ?> </li>
                                <?php if ( !empty( $kt_shop_ppp ) )
                                    echo '<li>일인당평균: ' . $kt_shop_ppp . 'RMB</li>'; ?>
                            </ul>
                            <ul>
                                <li> <?php echo  $shop_category[0]->name; ?> </li>
                                <li> <?php echo  $location_category[0]->name; ?> </li>
                            </ul>
                        </div>
                        <footer>
                            <form method="post" action="<?php get_page_link(); ?>">
                                <?php wp_nonce_field( 'kt_update_bookmarks', 'kt_nonce_field' ) ?>
                                <button type="submit" name="delete" value="<?php echo $post_id; ?>">Delete</button>
                            </form>
                        </footer>
                    </div>
                    
                    <?php endwhile; ?>
                    <?php echo '</div>';

                    if( function_exists('wp_pagenavi') ){
                        wp_pagenavi(array('query' => $kt_query));
                    }

                    wp_reset_postdata(); ?>

                <?php else : ?>
                    <?php locate_template( array( 'content/error.php' ), true ); // Loads the content/error.php template. ?>
                <?php endif; ?>
            <?php else : ?>
                <div>
                    <p>
                        There isn't any bookmark you added.
                    </p>
                </div>
            <?php endif; ?> 
    <?php else : ?>
        <a href="<?php echo wp_login_url( get_permalink() ); ?>" title="Login">Login</a>
    <?php endif ?>
</main>

<?php hybrid_get_sidebar( 'primary' ); ?>
<?php get_footer(); // Loads the footer.php template. ?>