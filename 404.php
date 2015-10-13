<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package iKoreaTown
 * @since  0.0.0
 */

get_header(); ?>

	<main <?php hybrid_attr( 'content' ); ?>>

		<section class="error-404 not-found">
			<header class="entry-header">
				<h1 class="entry-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'ikoreatown' ); ?></h1>
			</header><!-- .page-header -->

			<div class="entry-content">
				<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'ikoreatown' ); ?></p>
			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- .site-main -->

<?php get_footer(); ?>
