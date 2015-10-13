<?php
/**
 * The Template for displaying shop post type
 *
 * @package iKoreaTown
 * @since 0.0.0
 */

get_header(); ?>

<main <?php hybrid_attr( 'content' ); ?>>
		
	<?php
	// Update shop view count
	kt_update_post_view_count( $post->ID );
		
	if ( have_posts() ) :
		// Start the Loop.
		while ( have_posts() ) : the_post();
				
			get_template_part( 'content', 'shop' );
			
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template( '', true ); // Loads the comments.php template. ?>
			<?php endif;

		// End the loop.
		endwhile;
	else :
		get_template_part( 'content', 'none' ); // Loads the content/error.php template.
	endif ?>
	
</main><!-- #content -->
	
<?php hybrid_get_sidebar( 'shop-sidebar' ); // Loads the sidebar/shop-sidebar.php template. ?>
<?php get_footer(); ?>