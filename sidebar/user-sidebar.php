<?php
/**
 * This template is for user related page sidebar.
 *
 * @since 0.0.0
 */

if ( ! is_user_logged_in() ) : ?>
	<?php return; ?>
<?php else : ?>
	<?php $current_user = wp_get_current_user(); ?>
	<aside class="sidebar">
		<h3>My Profile</h3>
		<div>
			<?php echo get_avatar( $current_user->ID, 256 ); ?>
			<?php echo '<p>' . $current_user->display_name . ' 님</p>'; ?>
		</div>
		<ul>
			<li><a href="<?php echo home_url() . '/edit-profile'; ?>">Edit Profile</a></li>
			<li><a href="<?php echo home_url() . '/user-reviews'; ?>">User Reviews</a></li>
			<li><a href="<?php echo home_url() . '/shop-bookmarks'; ?>">Shop Bookmarks</a></li>
		</ul>
	</aside><!-- #sidebar-subsidiary -->
<?php endif ?>




