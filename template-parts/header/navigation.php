<?php
/**
 * Header Navigation
 *
 * Auf schmalen Bildschirmen klappt der Knopf das Menü auf und zu (assets/js/main.js).
 * Ohne JavaScript bleibt der Knopf verborgen und das Menü offen.
 */

?>
<nav id="site-navigation" class="site-navigation primary-navigation" aria-label="<?php esc_attr_e( 'Hauptmenü', 'el-team-wp-theme' ); ?>">
	<button type="button" class="menu-toggle" aria-controls="primary-menu-container" aria-expanded="false" hidden>
		<span class="menu-toggle__icon" aria-hidden="true"></span>
		<?php esc_html_e( 'Menü', 'el-team-wp-theme' ); ?>
	</button>
	<div id="primary-menu-container" class="primary-navigation__menu">
		<?php
		wp_nav_menu( array(
			'theme_location'  => 'primary',
			'menu_class'      => 'menu',
			'container'       => false,
			'fallback_cb'     => 'wp_page_menu',
			'depth'           => 2,
		) );
		?>
	</div>
</nav>
