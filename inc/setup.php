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

	// Add support for RSS Feeds
	add_theme_support( 'automatic-feed-links' );

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

	// Add support for editor styles
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/custom.css' );
	add_editor_style( 'style.css' );

	// Add support for custom header
	add_theme_support( 'custom-header', array(
		'default-image'      => '',
		'default-text-color' => '000000',
		'height'             => 300,
		'width'              => 1200,
		'flex-height'        => true,
		'flex-width'         => true,
	) );

	// Add support for custom background
	add_theme_support( 'custom-background', array(
		'default-color'      => 'ffffff',
		'default-image'      => '',
		'default-repeat'     => 'repeat',
		'default-position-x' => 'left',
		'default-position-y' => 'top',
	) );

	// Register navigation menus
	register_nav_menus( array(
		'primary'   => esc_html__( 'Primary Menu', 'el-team-wp-theme' ),
		'secondary' => esc_html__( 'Secondary Menu', 'el-team-wp-theme' ),
	) );

	// Load textdomain for translations
	load_theme_textdomain( 'el-team-wp-theme', EL_TEAM_THEME_DIR . '/languages' );
}

/**
 * Register widget areas / sidebars
 */
function el_team_register_sidebars() {
	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'el-team-wp-theme' ),
		'id'            => 'primary',
		'description'   => esc_html__( 'Main sidebar', 'el-team-wp-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'el-team-wp-theme' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Footer widget area', 'el-team-wp-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'el_team_register_sidebars' );
