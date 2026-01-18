<?php
/**
 * Header Navigation
 */

?>
<nav class="site-navigation primary-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'el-team-theme' ); ?>">
	<?php
	wp_nav_menu( array(
		'theme_location'  => 'primary',
		'menu_class'      => 'menu',
		'container'       => false,
		'fallback_cb'     => 'wp_page_menu',
		'depth'           => 2,
	) );
	?>
</nav>
