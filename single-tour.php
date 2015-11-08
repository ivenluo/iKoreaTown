<?php
/**
 * The Template for displaying tour post type
 *
 * @package iKoreaTown
 * @since 0.0.0
 */

get_header(); ?>

<main id="main" class="site-main" role="main">
		
	<?php
	// Update shop view count
	kt_update_post_view_count( $post->ID );
			
	// Start the Loop.
	while ( have_posts() ) : the_post();
			
		/*
		 * Include the post format-specific template for the content. If you want to
		 * use this in a child theme, then include a file called called content-___.php
		 * (where ___ is the post format) and that will be used instead.
		 */
		get_template_part( 'content', 'tour' );
		
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;

	// End the loop.
	endwhile; ?>
	
</main><!-- .site-main -->

<?php get_footer(); ?>