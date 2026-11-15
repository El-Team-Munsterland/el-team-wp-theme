<?php
/**
 * Enqueue scripts and styles
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue theme scripts and styles
 */
function el_team_enqueue_scripts() {
	// Enqueue main stylesheet
	wp_enqueue_style(
		'el-team-style',
		EL_TEAM_THEME_URI . '/style.css',
		array(),
		EL_TEAM_THEME_VERSION
	);

	// Enqueue custom stylesheet
	wp_enqueue_style(
		'el-team-custom',
		EL_TEAM_THEME_URI . '/assets/css/custom.css',
		array( 'el-team-style' ),
		EL_TEAM_THEME_VERSION
	);

	// Enqueue main script
	wp_enqueue_script(
		'el-team-script',
		EL_TEAM_THEME_URI . '/assets/js/main.js',
		array(),
		EL_TEAM_THEME_VERSION,
		true
	);

	// Enqueue comment reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'el_team_enqueue_scripts' );

/**
 * Normale und fette Schrift früh laden, damit der Text nicht erst in der Ersatzschrift erscheint.
 */
function el_team_preload_fonts() {
	foreach ( array( 'regular', 'bold' ) as $el_team_weight ) {
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( EL_TEAM_THEME_URI . '/assets/fonts/atkinson-hyperlegible-next-' . $el_team_weight . '.woff2' )
		);
	}
}
add_action( 'wp_head', 'el_team_preload_fonts', 1 );
