<?php
/* If a post password is required or no comments are given and comments/pings are closed, return. */
if ( post_password_required() || ( !have_comments() && !comments_open() && !pings_open() ) )
	return;
?>

<section id="comments-template">

	<?php if ( have_comments() ) : // Check if there are any comments. ?>

		<div id="comments">

			<h3 id="comments-number"><?php comments_number(); ?></h3>

			<ol class="comment-list">
				<?php wp_list_comments(
					array(
						'style'        => 'ol',
						'callback'     => 'hybrid_comments_callback',
						'end-callback' => 'hybrid_comments_end_callback'
					)
				); ?>
			</ol><!-- .comment-list -->

			<?php locate_template( array( 'misc/comments-nav.php' ), true ); // Loads the misc/comments-nav.php template. ?>

		</div><!-- #comments-->

	<?php endif; // End check for comments. ?>

	<?php locate_template( array( 'misc/comments-error.php' ), true ); // Loads the misc/comments-error.php template. ?>

    <?php // Revised by Iven at 21:40 22/10/2015 ?>
    <?php //comment_form(); // Loads the comment form. ?>
    <?php 
        // add images uploader and smilies for comment
        $image_upload_atts = array(
            'allowed_mime_types' => 'jpg, jpeg, jpe, gif, png, bmp, tif, tiff, ico',
            'max_file_size' => 5 );
        $comnts_field_arg = array(
            'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label>' .
                                get_wpml_comment() .
                                '<textarea id="comment" name="comment" cols="45" rows="8" aria-required="true">' .
                                '</textarea></p>',
            'comment_notes_after' => wp_multi_file_uploader_shortcode($image_upload_atts) );            

        comment_form($comnts_field_arg);
    ?>

</section><!-- #comments-template -->
