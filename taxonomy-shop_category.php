<?php
 /**
  * The template for displaying Shop Category pages
  *
  * @package iKoreaTown
  * @since 0.0.0
  */
    
get_header(); ?>

<main <?php hybrid_attr( 'content' ); ?>>

	<?php if ( have_posts() ) : ?>
		<header class="entry-header">
			<?php //the_archive_title( '<h2 class="entry-title">', '</h2>' ); ?>
		</header><!-- .page-header -->
	
		<?php 
	    	$url_parts = explode( '?', $current_url );
	    	$orderby = array( 
	    		'popularity' => 'unselected',
	    		'title' => 'unselected',
	    		'price' => 'unselected',
	    		'rating' => 'unselected',
	    	);

	    	if ( isset( $_GET['orderby'] ) ) {
	    		$current_order = $_GET['orderby'];
	    		if ( in_array( $current_order, array_keys( $orderby ) ) ) {
	    			$orderby[ $current_order ] = 'selected';
	    		}
	    	} else {
	    		// Default list is orderby popularity
	    		$orderby[ 'popularity' ] = 'selected';
	    	}

	    	if ( empty( $_GET['event'] ) ) {
		    	$event_url = esc_url( add_query_arg( array( 'event' => 1 ), $current_url ) );
		    	$event_icon_class = "event-unchecked";
			} else if ( $_GET['event'] == 1 ){
		    	$event_url = esc_url( remove_query_arg( 'event', $current_url ) );
		    	$event_icon_class = "event-checked";
			}
		?>
		<div class="list-filter">
			<ul class="filter-left">
				<?php foreach( $orderby as $key => $class) {
					echo '<li> <a class="' . $class . '" href="' . esc_url( add_query_arg( array( 'orderby' => $key ), $current_url ) ) . '">' . $key . '</a></li>';
				}?>
			</ul>

			<ul class="filter-right">
	    		<li>
					<a href="<?php echo $event_url ?>">
		    			<span>Event</span>
		    			<span class="<?php esc_attr_e( $event_icon_class ); ?>"></span>
					</a>
	    		</li>
			</ul>			
	    </div>
	    
    	<?php if ( isset( $_GET['event'] ) && $_GET['event'] == 1 ) {
			$listchanged = TRUE;
			$args_event = array(
				'tax_query' => array(
		    		array(
						'taxonomy' => 'shop_tag',
						'field' => 'slug',
						'terms' => 'event'
		    		)
				)
	    	);
	
			if ( empty( $_GET['orderby'] ) ) {
	    		$args_orderby = array(
					'orderby' => 'meta_value_num',
					'meta_key' => '_kt_view_count'
	    		);
	    		$args_event = array_merge( $args_event, $args_orderby );
			}
    	}
	    
    	if ( isset( $_GET['orderby'] ) ) {
			if ( $_GET['orderby'] == 'popularity' ) {
	    		$args_orderby = array(
					'orderby' => 'meta_value_num',
					'meta_key' => '_kt_view_count'
	    		);
	    		$listchanged = TRUE;
			} else if ( $_GET['orderby'] == 'title' ) {
	    		$args_orderby = array(
					'orderby' => 'title',
					'order' => 'asc'
	    		);
	    		$listchanged = TRUE;
			} else if ( $_GET['orderby'] == 'price' ) {
	    		$args_orderby = array(
	        		'orderby' => 'meta_value_num',
	        		'meta_key' => '_kt_shop_ppp'
	    		);
	    		$listchanged = TRUE;
			}
    	}
    
    	if ( isset( $_GET['district'] ) ) {
			$district = $_GET['district'];
			$terms = get_terms( 'location_category', array( 'fields' => 'id=>slug' ) );
	
			if ( in_array( $district, $terms ) ) {
	    		$args_district = array(
					'tax_query' => array(
		    			array(
							'taxonomy' => 'location_category',
							'field' => 'slug',
							'terms' => $district
		    			)
					)	
	    		);
	    		$listchanged = TRUE;
	    		if ( isset( $_GET['event'] ) && $_GET['event'] == 1 ) {
	        		$args_district = array_merge_recursive( $args_district, array(
				    	'tax_query' => array(
						'relation' => 'AND'
				    ) ) );
	    		}
			}
    	}
	    
    	if ( ! empty( $listchanged ) ) {
			$args= array();
			if ( ! empty( $args_event ) ) {
	    		$args = array_merge_recursive( $args_event, $args );
			}
			if ( ! empty( $args_orderby ) ) {
	    		$args = array_merge( $args_orderby, $args );
			}
			if ( ! empty( $args_district ) ) {
	    		$args = array_merge_recursive( $args_district, $args );
			}
			if ( ! empty( $args ) ) {
	    		$args = array_merge( $wp_query->query, $args );
				query_posts( $args );
			}
    	}

        // Start the Loop.
        if ( have_posts()) {
        	while ( have_posts() ) : the_post();
	            get_template_part( 'content', 'list' );
	        // End the Loop.
	        endwhile;
        } else {
        	get_template_part( 'content', 'none' );
        }
        
                
	   	//locate_template( array( 'misc/loop-nav.php' ), true ); // Loads the misc/loop-nav.php template.
	   	if ( function_exists( 'wp_pagenavi' )) 
			wp_pagenavi();

		if ( ! empty( $listchanged ) ) :
            wp_reset_query();
        endif;
    else :
        // If no content, include the "No posts found" template.
        get_template_part( 'content', 'none' ); // Loads the content/error.php template.
	endif; ?>
</main><!-- .site-main -->

<?php hybrid_get_sidebar( 'list-sidebar' ); ?>
<?php get_footer();
