<?php
/**
 * Header Navigation
 */

?>
<nav class="site-navigation primary-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'el-team-theme' ); ?>">
	<?php
	wp_nav_menu( array(
		'theme_location' => 'primary',
		'menu_class'     => 'menu',
		'fallback_cb'    => 'wp_page_menu',
	) );
	?>
</nav>
