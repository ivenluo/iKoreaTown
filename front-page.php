<?php
 /**
  * The template for front page
  *
  * @package iKoreaTown
  * @since 0.0.0
  */
    
get_header(); ?>
<main <?php hybrid_attr( 'page' ); ?>>

	<div class="featured-box">
		<header class="entry-header">
			<h2 <?php hybrid_attr( 'page-title' ); ?>>Featured 맛집/오락</h2>
		</header> <!-- .page-header -->
		<ul>
			<?php kt_most_popular_shop( 'restaurant_entertainment' ); ?>
		</ul>
	</div>
	
    <div class="featured-box">
		<header class="entry-header">
			<h2 <?php hybrid_attr( 'page-title' ); ?>>Featured 라이프/서비스</h2>
		</header> <!-- .page-header -->
		<ul>
			<?php kt_most_popular_shop( 'life_service' ); ?>
		</ul>
    </div>
    <div class="featured-box">
		<header class="entry-header">
			<h2 <?php hybrid_attr( 'page-title' ); ?>>Featured 스포츠</h2>
		</header> <!-- .page-header -->
		<ul>
			<?php kt_most_popular_shop( 'sports' ); ?>
		</ul>
    </div> 
   
</main><!-- #content  -->

<?php get_footer();