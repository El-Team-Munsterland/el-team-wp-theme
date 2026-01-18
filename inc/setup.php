<?php
/**
 * Theme Setup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Setup theme
 */
function el_team_setup_theme() {
	// Add support for title tag
	add_theme_support( 'title-tag' );

	// Add support for custom logo
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 100,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	// Add support for post thumbnails
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 825, 550, true );

	// Add support for responsive embeds
	add_theme_support( 'responsive-embeds' );

	// Register navigation menus
	register_nav_menus( array(
		'primary'   => esc_html__( 'Primary Menu', 'el-team-theme' ),
		'secondary' => esc_html__( 'Secondary Menu', 'el-team-theme' ),
	) );

	// Register widget areas
	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'el-team-theme' ),
		'id'            => 'primary',
		'description'   => esc_html__( 'Main sidebar', 'el-team-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'el-team-theme' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Footer widget area', 'el-team-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	// Load textdomain for translations
	load_theme_textdomain( 'el-team-theme', EL_TEAM_THEME_DIR . '/languages' );
}
