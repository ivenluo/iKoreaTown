<li <?php hybrid_attr( 'comment' ); ?>>

	<article>
		<header class="comment-meta">
			<?php echo get_avatar( $comment ); ?>
			<cite <?php hybrid_attr( 'comment-author' ); ?>><?php comment_author_link(); ?></cite><br />
			<time <?php hybrid_attr( 'comment-published' ); ?>><?php printf( __( '%s ago', 'stargazer' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ); ?></time>
			<?php edit_comment_link(); ?>
		</header><!-- .comment-meta -->

		<?php if( $comment_rating = get_comment_meta( get_comment_ID(), 'rating', true ) ) {
				$comment_rating = '<div class="comment-star-rating"><span>Rating: </span><span class="star-rating"><i class="star-' . $comment_rating * 10 . '"></i></span></div>';
				echo $comment_rating;
		}?>

		<div <?php hybrid_attr( 'comment-content' ); ?>>
			<?php comment_text(); ?>
		</div><!-- .comment-content -->

		<?php hybrid_comment_reply_link(); ?>
	</article>

<?php /* No closing </li> is needed.  WordPress will know where to add it. */ ?>