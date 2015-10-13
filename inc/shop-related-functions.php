<?php
/**
 * Shop custom post type related functions.
 *
 * @package iKoreaTown
 * @since 0.0.0
 */

/**
 * Show related shop custom post.
 *
 * @since 0.0.0
 */
if( ! function_exists( 'kt_related_shop' ) ) {
    function kt_related_shop( $post, $term ) {

      if ( empty($post) )
        return ;
    
      $post_type = get_post_type( $post );
      $category = get_the_terms( $post->ID, $term );
       
      $args = array(
                    'post_type' => $post_type,
                    'post__not_in' => array( $post->ID ),
                    'tax_query' => array(
                                         array(
                                               'taxonomy' => $category[0]->taxonomy,
                                               'field' => 'term_id',
                                               'terms' => $category[0]->term_id
                                               )
                                         ),
                    'posts_per_page' => 5,
                    'orderby' => 'meta_value_num',
                    'meta_key' => '_kt_view_count'
      );

      $kt_query = new WP_Query( $args );
      if ( $kt_query->have_posts() ) :
          while ( $kt_query->have_posts() ) : $kt_query->the_post(); ?>
              <li>
  		          <a href="<?php the_permalink(); ?>">
  		            <figure>
  			           <?php the_post_thumbnail( 'medium' ) ?>
  			             <figcaption>
  			               <?php the_title(); ?>
  			             </figcaption>
  		            </figure>
  		          </a>
  	         </li>
          <?php endwhile;
      else :
        echo '<p>죄송합니다, 다른 ' . $category[0]->name . ' 없습니다</p>'; 
      endif;
    
      wp_reset_postdata();
  }
}

/**
 * Update post view count
 *
 * @since 0.0.0
 */
if( ! function_exists( 'kt_update_post_view_count' ) ) {
  function kt_update_post_view_count( $post_id ) {

    $count = get_post_meta( $post_id, '_kt_view_count', TRUE );
    if ( empty( $count ) ) {
        $count = 1;
    } elseif ( empty( $_SESSION["post_view[$post_id]"] ) ) {
        $count ++;
        $_SESSION["post_view[$post_id]"] = TRUE;
    }
    update_post_meta( $post_id, '_kt_view_count', $count );
    return $count;
  }
}

/**
 * Update post view count
 *
 * @since 0.0.0
 */
if( ! function_exists( 'kt_update_post_view_count' ) ) {
  function kt_update_post_view_count( $post_id ) {

    $count = get_post_meta( $post_id, '_kt_view_count', TRUE );
    if ( empty( $count ) ) {
        $count = 1;
    } elseif ( empty( $_SESSION["post_view[$post_id]"] ) ) {
        $count ++;
        $_SESSION["post_view[$post_id]"] = TRUE;
    }
    update_post_meta( $post_id, '_kt_view_count', $count );
    return $count;
  }
}


/**
 * Display the most popular shops in a given category
 *
 * @since 0.0.0
 */
if ( ! function_exists( 'kt_most_popular_shop' ) ) {
  function kt_most_popular_shop( $category ) {
    $args = array(
        'post_type' => 'my-shops',
        'tax_query' => array(
                            array(
                                'taxonomy' => 'shop_category',
                                'field' => 'slug',
                                'terms' => $category
                                )
                            ),
        'posts_per_page' => 6,
        'orderby' => 'meta_value_num',
        'meta_key' => '_kt_view_count'
    );
    $kt_query = new WP_Query( $args );
    if ( $kt_query->have_posts() ) :
      while ( $kt_query->have_posts() ) : 
        $kt_query->the_post(); ?>
          <li>
            <a href="<?php the_permalink(); ?>">
              <figure>
                <?php the_post_thumbnail( 'thumbnail' ) ?>
                <figcaption>
                  <ul>
                    <?php the_title(); ?>
                  </ul>
                </figcaption>
              </figure>
            </a>
          </li>
      <?php endwhile;
    endif;
    wp_reset_postdata();
  }
}
