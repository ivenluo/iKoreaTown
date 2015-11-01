<aside class="sidebar list-sidebar">
	<section class="widget">
		<h3 class="widget-title font-headlines">
			<?php echo "카테고리"; ?>
		</h3>

	<?php 
		$taxonomy_object = get_queried_object();
		$args = array(
		    'orderby' => 'id',
		    'order' => 'asc',
		    'parent' => $taxonomy_object->term_id,
		    'taxonomy' => $taxonomy_object->taxonomy,
		    'hide_empty' => 0,
		    'hierarchical' => true,
		);
		$terms = get_categories( $args );
		if ( ! empty( $terms ) ) {
		    echo '<ul><li class="selected"><a href="' . esc_url( get_term_link( $taxonomy_object ) ) . '">' . $taxonomy_object->name . '</a></li>';
		    foreach ( $terms as $term ) {	
				// The $term is an object, so we don't need to specify the $taxonomy.
				$term_link = get_term_link( $term );
  
				// If there was an error, continue to the next term.
				if ( is_wp_error( $term_link ) ) {
			    	continue;
				}
				// We successfully got a link. Print it out.
				echo '<li><a href="' . esc_url( $term_link ) . '">' . $term->name . '</a></li>';
		    }
		    echo '</ul>';
		} else {
			echo '<ul><li>' . get_queried_object()->name . '</li></ul>';
		}?>
	</section>

	<section class="widget">
	    <h3 class="widget-title font-headlines"> <?php echo "지역"; ?> </h3>

	    <?php if ( isset( $_GET['district'] ) ) {
			$district = $_GET['district'];
			$terms = get_terms( 'location_category', array( 'fields' => 'id=>slug' ) );
			if ( in_array( $district, $terms ) ) {
		    	$class = '';
			} else {
		    	$class = 'selected';
			}
	    } else {
			$class = 'selected';
		}

	    $current_url = html_entity_decode( get_pagenum_link() );
	    $current_url = remove_query_arg( 'district', $current_url );
	    $terms = get_terms( 'location_category' );
	    
	    if ( ! empty( $terms ) ) {
		    echo '<ul>';
		    echo '<li class="' . $class . '"><a href="' . esc_url( $current_url ) . '">전부</a></li>';
		    foreach ( $terms as $term ) {
			
				if ( !empty( $district ) && $district == $term->slug ) {
					$class = 'selected';
				} else {
					$class = '';
				}
			
				$current_url = esc_url( add_query_arg( array( 'district' => $term->slug ), $current_url ) );
				echo '<li class="' . $class . '"><a href="' . esc_url( $current_url ) . '">' . $term->name . '</a></li>';
		    }
		    echo '</ul>';
		}?>
	</section>
</aside> <!-- .shop-sidebar -->