<?php
/**
 * The content template for displaying shop list
 *
 * @package iKoreaTown
 * @since iKoreaTown 0.0.0
 */
?>

<article <?php hybrid_attr( 'list' ); ?>>
	
	<div class="list-thumbnail">
		<?php if ( has_post_thumbnail() ) : ?>
			<a href="<?php esc_url( the_permalink() ); ?>" >
				<?php the_post_thumbnail( 'thumbnail' ); ?>
			</a>
		<?php endif ?>
	</div><!-- .list-thumbnail -->
	
	<div class="list-info">
		<header class="list-header">
			<?php the_title( sprintf( '<h5 class="list-title"><a href="%s" rel="bookmark"><ul>',
					 esc_url( get_permalink() ) ), '</ul></a></h5>' ); ?>
		</header>
		
		<?php
		// Shop meta data
		$kt_shop_meta = get_post_meta( $post->ID, '_my_shop_data', TRUE );
		$kt_shop_ppp = get_post_meta( $post->ID, '_kt_shop_ppp', TRUE );
		$kt_shop_rating = get_post_meta( $post->ID, '_kt_shop_rating', TRUE );


		$shop_category = get_the_terms( $post->ID, 'shop_category' );
		$location_category = get_the_terms( $post->ID, 'location_category' );
		$kt_rating = ( ! empty( $kt_shop_rating ) ) ? $kt_shop_rating : '0';
		$kt_event = ( ! empty($kt_shop_meta['event']) ) ? $kt_shop_meta['event'] : '';
		?>
		<ul>
			<li> 
				<?php echo '평점: ';
					$integer = round( $kt_rating * 2, 0, PHP_ROUND_HALF_DOWN );
					$star_class = 'star-' . $integer * 5;
					echo '<span class="star-rating"><i class="' . $star_class .  '"></i></span>';
				?> 
			</li>
			<?php if ( !empty( $kt_shop_ppp ) ) : ?>
				<li> <?php echo $kt_shop_ppp; ?>RMB </li>
			<?php endif ?>
		</ul>
		<ul>
			<?php foreach( $shop_category as $item ) { ?>
				<li> <?php echo  $item->name; ?> </li>
			<?php } ?>
		</ul>
		<ul>
			<?php foreach( $location_category as $item ) { ?>
				<li> <?php echo  $item->name; ?> </li>
			<?php } ?>
		</ul>
	</div><!-- .list-info -->
	
	<?php if ( ! empty( $kt_event ) ) : ?>
		<div class="list-event">
			<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/img/sale20.jpg" alt="Discount 20%">
		</div><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-## -->
