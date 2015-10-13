<?php
/**
 * The page template for user who can edit ikoreatown.
 *
 * @package iKoreaTown
 * @since 0.0.0
 */

get_header(); ?>

<main <?php hybrid_attr( 'content' ); ?> >
	<?php if ( is_user_logged_in() ) : ?>
		<h1 <?php hybrid_attr( 'entry-title' ); ?>>Edit My Profile</h1>

		<?php /* Get user info. */
		global $current_user, $wp_roles;
		
		$error = array();    
		/* If profile was saved, update profile. */
		if ( isset( $_POST['kt_nonce_field'] ) && wp_verify_nonce( $_POST['kt_nonce_field'], 'kt_update_user' ) ) {

    		/* Update user password. */
    		if ( ! empty($_POST['pass1'] ) && ! empty( $_POST['pass2'] ) ) {
        		if ( $_POST['pass1'] == $_POST['pass2'] )
            		wp_update_user( array( 'ID' => $current_user->ID, 'user_pass' => esc_attr( $_POST['pass1'] ) ) );
        		else
            		$error[] = __('The passwords you entered do not match.  Your password was not updated.', 'ikoreatown');
			}

    		/* Update user information. */
        	if ( ! empty( $_POST['first-name'] ) )
        		update_user_meta( $current_user->ID, 'first_name', esc_attr( $_POST['first-name'] ) );

    		if ( ! empty( $_POST['last-name'] ) )
        		update_user_meta($current_user->ID, 'last_name', esc_attr( $_POST['last-name'] ) );

    		if ( ! empty( $_POST['description'] ) )
        		update_user_meta( $current_user->ID, 'description', esc_attr( $_POST['description'] ) );
    	}	

    	/* Redirect so the page will show updated info.*/
  		/* I am not Author of this Code- i dont know why but it worked for me after changing below line to if ( count($error) == 0 ){ */
    	if ( count($error) == 0 ) {
        	//action hook for plugins and extra fields saving
        	do_action('edit_user_profile_update', $current_user->ID);
        	//wp_redirect( get_permalink() );
        	//exit;
    	}

		if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        	<div class="entry-content entry">
                <?php if ( count($error) > 0 ) echo '<p class="error">' . implode("<br />", $error) . '</p>'; ?>

                <form method="post" id="adduser" action="<?php the_permalink(); ?>">

                	<p class="form-email">
                        <label for="email"><?php _e('E-mail *', 'ikoreatown'); ?></label>
                        <input class="text-input" name="email" type="text" id="email" disabled="disabled" value="<?php the_author_meta( 'user_email', $current_user->ID ); ?>" />
                    </p><!-- .form-email -->
                    <p class="form-username">
                        <label for="first-name"><?php _e('First Name', 'ikoreatown'); ?></label>
                        <input class="text-input" name="first-name" type="text" id="first-name" value="<?php the_author_meta( 'first_name', $current_user->ID ); ?>" />
                    </p><!-- .form-username -->
                    <p class="form-username">
                        <label for="last-name"><?php _e('Last Name', 'ikoreatown'); ?></label>
                        <input class="text-input" name="last-name" type="text" id="last-name" value="<?php the_author_meta( 'last_name', $current_user->ID ); ?>" />
                    </p><!-- .form-username -->
                    <p class="form-password">
                        <label for="pass1"><?php _e('New Password *', 'ikoreatown'); ?> </label>
                        <input class="text-input" name="pass1" type="password" id="pass1" />
                    </p><!-- .form-password -->
                    <p class="form-password">
                        <label for="pass2"><?php _e('Repeat New Password *', 'ikoreatown'); ?></label>
                        <input class="text-input" name="pass2" type="password" id="pass2" />
                    </p><!-- .form-password -->
                    <p class="form-textarea">
                        <label for="description"><?php _e('Biographical Information', 'ikoreatown') ?></label>
                        <textarea name="description" id="description" rows="3" cols="50"><?php the_author_meta( 'description', $current_user->ID ); ?></textarea>
                    </p><!-- .form-textarea -->

                    <?php 
                        //action hook for plugin and extra fields
                        do_action('show_user_ikoreatown', $current_user);
                    ?>
                    <p class="form-submit">
                        <input name="updateuser" type="submit" id="updateuser" class="submit button" value="<?php _e('Update', 'ikoreatown'); ?>" />
                    </p><!-- .form-submit -->
                    <?php wp_nonce_field( 'kt_update_user', 'kt_nonce_field' ) ?>
                </form><!-- #adduser -->
        	</div><!-- .entry-content -->
    	<?php endwhile; ?>
		<?php else: ?>
    		<p class="no-data">
        		<?php _e('Sorry, no page matched your criteria.', 'ikoreatown'); ?>
    		</p><!-- .no-data -->
		<?php endif; ?>

    <?php else : ?>
        <div>Please <a href="<?php echo wp_login_url( get_permalink() ); ?>" title="Login">Login</a> First.</diV>
    <?php endif ?>

</main>

<?php hybrid_get_sidebar( 'user-sidebar' ); ?>
<?php get_footer() ?>