<?php
/**
 * El Team Theme Functions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define constants
define( 'EL_TEAM_THEME_VERSION', '1.0.0' );
define( 'EL_TEAM_THEME_DIR', get_template_directory() );
define( 'EL_TEAM_THEME_URI', get_template_directory_uri() );

/**
 * Include theme setup functions
 */
require_once EL_TEAM_THEME_DIR . '/inc/setup.php';
require_once EL_TEAM_THEME_DIR . '/inc/enqueue.php';

/**
 * Theme Setup
 */
add_action( 'after_setup_theme', 'el_team_setup_theme' );
