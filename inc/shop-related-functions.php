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
  			           <?php the_post_thumbnail( 'thumbnail' ) ?>
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
