<?php
    $shop_category = get_the_terms( $post->ID, 'shop_category' );
    //$location_category = get_the_terms( $post->ID, 'location_category' );
    ?>
	
    <aside class="shop-sidebar">    
	    <section class="widget">
            <h3 class="widget-title font-headlines">
                        <?php echo "다른 ". $shop_category[0]->name ." 찾으세요?"; ?>
            </h3>
            
            <ul id="related-shops">
                <?php kt_related_shop( $post, $shop_category[0]->taxonomy ); ?>
            </ul>
	    </section>
    </aside> <!-- .entry-more-info -->