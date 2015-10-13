<?php if ( has_nav_menu( 'primary' ) ) : // Check if there's a menu assigned to the 'primary' location. ?>

	<nav <?php hybrid_attr( 'menu', 'primary' ); ?>>

		<h3 id="menu-primary-title" class="menu-toggle">
			<button class="screen-reader-text">Login</button>
		</h3><!-- .menu-toggle -->
		<div class="wrap">
			<?php wp_nav_menu(
				array(
					'theme_location'  => 'primary',
					'container'       => '',
					'menu_id'         => 'menu-primary-items',
					'menu_class'      => 'menu-items',
					'fallback_cb'     => '',
					'items_wrap'      => '<ul id="%s" class="%s">%s</ul>'
			)
			); ?>
		
			<div class="nav-tools">
				<?php //get_search_form();
				$button = '<ul>';
				if ( is_user_logged_in() ) : ?>
					<?php $current_user = wp_get_current_user(); ?>
					<?php $button .= '<li><a id="logged-in" href="' . home_url() . '/edit-profile' . '">' . $current_user->display_name . ' 님</a></li>'; ?>
					<div id="login-panel">
						<ul>
							<li><a href="<?php echo home_url() . '/edit-profile'; ?>">Edit Profile</a></li>
							<li><a href="<?php echo home_url() . '/user-reviews'; ?>">User Reviews</a></li>
							<li><a href="<?php echo home_url() . '/shop-bookmarks'; ?>">Shop Bookmarks</a></li>
							<li><a href="<?php echo wp_logout_url( get_permalink() ); ?>">Log out</a></li>
						</ul>	
					</div>
				<?php else: ?>
					<?php $button .= '<li><a href="' . wp_login_url( get_permalink() ) . '" title="Login">Login</a></li>'; ?>
				<?php endif ?>
				<?php $button .= '</ul>';
				
				echo $button; ?>
			</div>
		</div>
	</nav><!-- #menu-primary -->

<?php endif; // End check for menu. ?>