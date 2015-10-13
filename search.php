<?php get_header(); ?>

<main <?php hybrid_attr( 'content' ); ?>>

	<?php if ( have_posts() && ! empty( get_search_query() ) ) : ?>

		<header class="page-header">
			<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'ikoreatown' ), get_search_query() ); ?></h1>
		</header><!-- .page-header -->

		<?php
		// Start the loop.
		while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'list' );

		// End the loop.
		endwhile;

		// page navigation.
		if ( function_exists( 'wp_pagenavi' ) ) {
			wp_pagenavi();
		} ?>
			
	<?php else : ?>
		<?php locate_template( array( 'content/error.php' ), true ); // Loads the content/error.php template. ?>

	<?php endif; ?>

</main><!-- .site-main -->

<?php get_footer(); ?>
