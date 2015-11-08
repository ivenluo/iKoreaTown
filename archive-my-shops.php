<?php
/**
 * The template for displaying Archive shop post
 *
 * @package iKoreaTown
 * @since iKoreaTown 0.0.0
 */

get_header(); ?>

<main id="main" class="site-main" role="main">

	<?php if ( have_posts() ) : ?>

		<header class="page-header">
			<?php
				the_archive_title( '<h1 class="entry-title">', '</h1>' );
			?>
		</header><!-- .page-header -->

		<?php
		// Start the Loop.
		while ( have_posts() ) : the_post();
		
			get_template_part( 'content', 'my-list' );

		// End the Loop.
		endwhile;
		
		// Previous/next page navigation.
		locate_template( array( 'misc/loop-nav.php' ), true ); // Loads the misc/loop-nav.php template.

	else :
		// If no content, include the "No posts found" template.
		locate_template( array( 'content/error.php' ), true ); // Loads the content/error.php template.

	endif; ?>

</main><!-- .site-main -->

<?php
get_footer();
