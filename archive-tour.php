<?php
/**
 * The template for displaying Archive tour post
 *
 * @package iKoreaTown
 * @since iKoreaTown 0.0.0
 */

get_header(); ?>
<main id="main" class="site-main" role="main">

	<?php if ( have_posts() ) : ?>

		<header class="page-header">
			<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="taxonomy-description">', '</div>' );
			?>
		</header><!-- .page-header -->

		<?php
		// Start the Loop.
		while ( have_posts() ) : the_post();
		
			get_template_part( 'content', get_post_format() );

		// End the Loop.
		endwhile;

	else :
		locate_template( array( 'content/error.php' ), true ); // Loads the content/error.php template.

	endif;
	?>

</main><!-- .site-main -->

<?php
get_footer();
