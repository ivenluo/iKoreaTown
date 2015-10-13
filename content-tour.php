<?php
    /**
     * The template used for displaying page content
     *
     * @package WordPress
     * @subpackage Twenty_Fifteen_Child
     * @since Twenty Fifteen 1.0
     */
    ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
	// Post thumbnail.
	//twentyfifteen_post_thumbnail();
    ?>
    
    <header class="entry-header">
	<?php
	    if ( is_single() ) :
		the_title( '<h1 class="entry-title">', '</h1>' );
	    else :
		the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
	    endif;
	?>
    </header><!-- .entry-header -->

<div class="entry-content">
<?php
    
    // Display shop meta
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
    $kt_others = ( ! empty($kt_tour_meta['others']) ) ? $kt_tour_meta['ohters'] : ''; ?>
    
    <h4>Tour Place Info</h4>
    <table>
	<tr>
            <td><?php _e( 'Ticket Price', 'ikoreatown' ); ?> :</td>
            <td><?php echo $kt_price; ?></td>
        </tr>
	<tr>
            <td> <?php _e( 'Address', 'ikoreatown' ); ?> : </td>
            <td> <?php echo $kt_addr; ?> </td>
        </tr>
	<tr>
	    <td> <?php _e( 'Rest', 'ikoreatown' ); ?> </td>
	    <td> <?php echo $kt_rest; ?> </td>
	</tr>
	<tr>
	    <td> <?php _e( 'Service Time', 'ikoreatown' ); ?> </td>
	    <td> <?php echo $kt_time_start . " ~ " . $kt_time_end; ?> </td>
	</tr>
	<tr>
            <td><?php _e( 'Tel', 'ikoreatown' ); ?> :</td>
            <td><?php echo $kt_tel; ?></td>
        </tr>
        <tr>
            <td> <?php _e( 'Rating', 'ikoreatown' ); ?> : </td>
            <td> <?php echo $kt_rating; ?> </td>
        </tr> 
    </table>
    
    <?php if ( ! empty( $kt_others ) ) : ?>
	<h4>Others</h4>
	<?php echo $kt_others ?>
    <?php endif ?>
    
    <?php
	echo "<h3>About the Tour Place</h3>";
	/* translators: %s: Name of current post */
	the_content( sprintf(
	    __( 'Continue reading %s', 'twentyfifteen' ),
	    the_title( '<span class="screen-reader-text">', '</span>', false )
	) );

	wp_link_pages( array(
	    'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentyfifteen' ) . '</span>',
	    'after'       => '</div>',
	    'link_before' => '<span>',
	    'link_after'  => '</span>',
	    'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>%',
	    'separator'   => '<span class="screen-reader-text">, </span>',
	) );
	
    ?>
    </div><!-- .entry-content -->
    
    <footer class="entry-footer">
	<?php echo 'Last updated on '; ?>
	<?php print_r( get_the_modified_date() ); ?>
	<?php //twentyfifteen_entry_meta(); ?>
	<?php edit_post_link( __( 'Edit', 'twentyfifteen' ), '<span class="edit-link">', '</span>' ); ?>
    </footer><!-- .entry-footer -->
    
</article><!-- #post-## -->
