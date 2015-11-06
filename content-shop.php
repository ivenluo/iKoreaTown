<?php
/**
 * The template used for displaying shop content
 *
 * @package iKoreaTown
 * @since iKoreaTown 0.0.0
 */
?>

<article <?php hybrid_attr( 'post' ); ?>>

    <?php
    // Retrieve shop meta data
	$kt_shop_meta = get_post_meta( $post->ID, '_my_shop_data', TRUE );
	$kt_shop_ppp = get_post_meta( $post->ID, '_kt_shop_ppp', TRUE );
	$kt_shop_rating = get_post_meta( $post->ID, '_kt_shop_rating', TRUE );
	$shop_category = get_the_terms( $post->ID, 'shop_category' );
	$location_category = get_the_terms( $post->ID, 'location_category' );

	$comments_count = wp_count_comments( $post->ID );
    $comments_approved_count = $comments_count->approved;
    
    // Basic Info
    $kt_tel = ( ! empty($kt_shop_meta['tel']) ) ? $kt_shop_meta['tel'] : '';
    $kt_addr = ( ! empty($kt_shop_meta['addr']) ) ? $kt_shop_meta['addr'] : '';

    $kt_rating = ( empty( $kt_shop_rating ) ) ? 0 : $kt_shop_rating;
    $kt_price_per_person = ( empty( $kt_shop_ppp ) ) ? '' : $kt_shop_ppp;
    
    // More Info
    $kt_reservation = ( ! empty($kt_shop_meta['reservation']) ) ? $kt_shop_meta['reservation'] : '';
    $kt_delivery = ( ! empty($kt_shop_meta['delivery']) ) ? $kt_shop_meta['delivery'] : '';
    $kt_lang = ( ! empty($kt_shop_meta['lang']) ) ? $kt_shop_meta['lang'] : '';
    $kt_rest = ( ! empty($kt_shop_meta['rest']) ) ? $kt_shop_meta['rest'] : '';
    $kt_time_start = ( ! empty($kt_shop_meta['time_start']) ) ? $kt_shop_meta['time_start'] : '';
    $kt_time_end = ( ! empty($kt_shop_meta['time_end']) ) ? $kt_shop_meta['time_end'] : '';
    $kt_wifi = ( ! empty($kt_shop_meta['wifi']) ) ? $kt_shop_meta['wifi'] : '';
    $kt_parking = ( ! empty($kt_shop_meta['parking']) ) ? $kt_shop_meta['parking'] : '';
    $kt_bath = ( ! empty($kt_shop_meta['bath']) ) ? $kt_shop_meta['bath'] : '';
    $kt_email = ( ! empty($kt_shop_meta['email']) ) ? $kt_shop_meta['email'] : '';
    $kt_table = ( ! empty($kt_shop_meta['table']) ) ? $kt_shop_meta['table'] : '';
    $kt_room = ( ! empty($kt_shop_meta['room']) ) ? $kt_shop_meta['room'] : '';

    // VIP
    $kt_vip = ( ! empty($kt_shop_meta['vip']) ) ? $kt_shop_meta['vip'] : '';
    // Event
    $kt_event = ( ! empty($kt_shop_meta['event']) ) ? $kt_shop_meta['event'] : '';
    // Price
    $kt_price = ( ! empty($kt_shop_meta['price']) ) ? $kt_shop_meta['price'] : '';
    // Other Info
    $kt_others = ( ! empty($kt_shop_meta['others']) ) ? $kt_shop_meta['others'] : ''; ?>
	
    <header class="entry-header">
		<?php if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
			kt_shop_thumbnail( 'large' );
	    }?>
	    
	    <?php the_title( '<h2 class="shop-title"><ul>', '</ul></h2>' ); ?>
    </header><!-- .entry-header -->
    
    <section <?php hybrid_attr( 'entry-content' ); ?>>
	
	    <?php if ( ! empty($kt_event) ) : ?>
			<div class="extra-box">
			    <h3 class="widget-title font-headlines">이벤트</h3>
			    <?php echo '<p>'. $kt_event. '</p>'; ?>
			</div>
	    <?php endif ?>
	    <?php if ( ! empty( $kt_vip ) ) : ?>
		    <div class="extra-box">
				<h3 class="widget-title font-headlines">VIP</h3>
				<p> <?php echo $kt_vip ?> </p>
		    </div>
		<?php endif ?>
		
		<div class="tabbedPanels">
		    <ul>
				<li><a href="#basic-info">기본정보</a></li>
				<li><a href="#more-info">상세정보</a></li>
				<li><a href="#content-box">소개 & 갤러리</a></li>
				<?php if ( ! empty( $kt_price ) ) : ?>
				    <li><a href="#price-box">메뉴</a></li>
				<?php endif ?>
		    </ul>
		
		    <div id="basic-info" class="panel-box">
				<ul>
				    <li>
						<?php _e( '카테고리', 'ikoreatown' ); ?> :
						<?php echo $shop_category[0]->name; ?>
				    </li>
				    <li>
				        <?php _e( '구역', 'ikoreatown' ); ?> :
				        <?php echo $location_category[0]->name; ?>
				    </li>
				    <li>
				        <?php _e( 'Tel', 'ikoreatown' ); ?> :
				        <?php echo $kt_tel; ?>
				    </li>
                    <li>
                        <?php // Revised by Iven at 21:27 28/10/2015 ?>
				        <?php _e( '주소', 'ikoreatown' ); ?> :
                        <?php //echo '<address>' . $kt_addr . '</address>'; ?>
                        <?php echo '<a href = "http://api.map.baidu.com/geocoder?address=' 
                                        . get_chinese_addr($kt_addr) . get_chinese(get_the_title()) 
                                        . '&output=html&src=iKoreaTown" target="_blank"> <u>'; ?>
                        <?php echo '<address>' . $kt_addr . '</address>'; ?>
                        <?php echo '</u> </a>'; ?>
				    </li>
				    <li>
				        <?php _e( '평점', 'ikoreatown' ); ?> : 
						<?php echo '<span>' . $kt_rating . ' </span>';
						$integer = round( $kt_rating * 2, 0, PHP_ROUND_HALF_DOWN );
						$star_class = 'star-' . $integer * 5;
						echo '<span class="star-rating"><i class="' . $star_class .  '"></i></span>';
						?>
				    </li>
				    <li>
				    	<?php _e( '평가수', 'ikoreatown' ); ?> :
				    	<?php echo $comments_approved_count; ?>
				    </li>
				    <?php if ( ! empty( $kt_price_per_person ) ) : ?>
				    	<li>
							<?php _e( '일인당평균', 'ikoreatown' ); ?> :
							<?php echo $kt_price_per_person . " RMB"; ?>
				    	</li>
				    <?php endif ?>
				</ul>
		    </div> <!-- .basic-info -->
		    
		    <div id="more-info" class="panel-box">
				<ul>
				    <?php if ( ! empty( $kt_email ) ) : ?>
				        <li>
						    <?php _e( 'Email', 'ikoreatown' ); ?> :
						    <?php echo $kt_email; ?>
						</li>
				    <?php endif ?>
				    <?php if ( ! empty( $kt_reservation ) ) : ?>
				        <li>
				            <?php _e( '예약', 'ikoreatown' ); ?> : 
				            <?php echo $kt_reservation; ?>
				        </li>
				    <?php endif ?>
				    <?php if ( ! empty( $kt_delivery ) ) : ?>
				        <li>
					    <?php _e( '배달', 'ikoreatown' ); ?> :
					    <?php echo $kt_delivery; ?>
					</li>
				    <?php endif ?>
					<li>
					    <?php _e( '언어', 'ikoreatown' ); ?> :
					    <?php echo $kt_lang; ?>
					</li>
					<li>
					    <?php _e( '영업시간', 'ikoreatown' ); ?> :
					    <?php echo $kt_time_start . " ~ " . $kt_time_end; ?>
					</li>
				    <?php if ( ! empty( $kt_wifi ) ) : ?>
					<li>
					    <?php _e( 'WiFi', 'ikoreatown' ); ?> :
					    <?php echo $kt_wifi; ?> 
					</li>
				    <?php endif ?>
				    <?php if ( ! empty( $kt_room ) ) : ?>
				        <li>
				            <?php _e( '방수', 'ikoreatown' ); ?> :
				            <?php echo $kt_room; ?>
				        </li>
				    <?php endif ?>
				    <?php if ( ! empty( $kt_table ) ) : ?>
				        <li>
				            <?php _e( '테이블', 'ikoreatown' ); ?> :
				            <?php echo $kt_table; ?>
				        </li>
				    <?php endif ?>
				    <?php if ( ! empty( $kt_bath ) ) : ?>
				        <li>
				            <?php _e( '화장실', 'ikoreatown' ); ?> :
				            <?php echo $kt_bath; ?>
				        </li>
				    <?php endif ?>
				        <li>
				            <?php _e( '휴식일', 'ikoreatown' ); ?> :
				            <?php echo $kt_rest; ?>
				        </li>
				    <?php if ( ! empty( $kt_parking ) ) : ?>
				        <li>
				            <?php _e( '주차', 'ikoreatown' ); ?> :
				            <?php echo $kt_parking; ?>
				        </li>
				    <?php endif ?>
				</ul> 
		    </div> <!-- #more-info -->

		    <div id="content-box" class="panel-box">
		    	<?php the_content(); ?>
		    </div> <!-- #content-box" -->

		    <?php if ( ! empty( $kt_price ) ) : ?>
			    <div id="price-box" class="panel-box">
			    	<?php echo '<p>' . $kt_price . '</p>'; ?>
			    </div>
			<?php endif ?>

		</div> <!-- .tabbedPanels -->
		
    </section><!-- .entry-content -->
    
    <footer class="entry-footer">
    	<div class="footer-left">
    		<?php if ( is_user_logged_in() ) : ?>
    			<?php $current_user_id = get_current_user_ID(); ?>
    			<?php $bookmarks = get_user_meta( $current_user_id, '_kt_user_bookmark', FALSE ); ?>
    			<?php if ( ! empty( $bookmarks ) && in_array( $post->ID, $bookmarks ) ) : ?>
    				<button id="bookmark" rel="<?php echo $post->ID; ?>">Bookmark</button>
    			<?php else : ?>
    				<button id="bookmark" class="unbookmark" rel="<?php echo $post->ID; ?>">Bookmark</button>
    			<?php endif ?>
    		<?php else : ?>
    			<a href="<?php echo wp_login_url( get_permalink() ); ?>"><button>Login to Bookmark</button></a>
    		<?php endif ?>
    	</div>
		<div class="footer-right">
	    	<?php echo __( 'Updated ', 'ikoreatown' );
	    	print_r( get_the_modified_date() ); ?>
		</div>
    </footer><!-- .entry-footer -->
    
</article><!-- .entry -->
