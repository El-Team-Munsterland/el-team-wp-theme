<?php
/**
 * Zusammenspiel mit dem Plugin "CityEL Werkstatt".
 *
 * Inhaltstypen (Fahrzeuge, Werkstattberichte), Meta-Boxen, Linkempfehlungen und die
 * Seitenmatrix verwaltet seit Theme 1.1 das Plugin. Das Theme liefert nur noch Vorlagen
 * und Styles. Ist das Plugin nicht aktiv, registriert diese Datei die beiden Inhaltstypen
 * minimal weiter, damit bestehende Fahrzeug- und Werkstattbericht-Seiten erreichbar
 * bleiben, und weist im Adminbereich auf das fehlende Plugin hin.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ist das Plugin "CityEL Werkstatt" aktiv?
 *
 * @return bool
 */
function el_team_werkstatt_plugin_active() {
	return defined( 'CEW_VERSION' );
}

/**
 * Notfall-Registrierung der Inhaltstypen ohne Plugin (gleiche Slugs wie bisher).
 */
function el_team_fallback_post_types() {
	if ( el_team_werkstatt_plugin_active() ) {
		return;
	}
	if ( ! post_type_exists( 'fahrzeug' ) ) {
		register_post_type( 'fahrzeug', array(
			'labels'       => array(
				'name'          => esc_html_x( 'Fahrzeuge', 'Post Type General Name', 'el-team-wp-theme' ),
				'singular_name' => esc_html_x( 'Fahrzeug', 'Post Type Singular Name', 'el-team-wp-theme' ),
			),
			'public'       => true,
			'has_archive'  => false,
			'rewrite'      => array( 'slug' => 'fahrzeug' ),
			'show_in_rest' => true,
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
			'menu_icon'    => 'dashicons-car',
		) );
	}
	if ( ! post_type_exists( 'werkstattbericht' ) ) {
		register_post_type( 'werkstattbericht', array(
			'labels'       => array(
				'name'          => esc_html_x( 'Werkstattberichte', 'Post Type General Name', 'el-team-wp-theme' ),
				'singular_name' => esc_html_x( 'Werkstattbericht', 'Post Type Singular Name', 'el-team-wp-theme' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => 'werkstattberichte' ),
			'show_in_rest' => true,
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'author', 'revisions' ),
			'menu_icon'    => 'dashicons-hammer',
		) );
	}
}
add_action( 'init', 'el_team_fallback_post_types', 20 );

/**
 * Hinweis im Adminbereich, solange das Plugin fehlt.
 */
function el_team_plugin_missing_notice() {
	if ( el_team_werkstatt_plugin_active() || ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	echo '<div class="notice notice-warning"><p>'
		. esc_html__( 'Das Theme erwartet das Plugin „CityEL Werkstatt“. Ohne das Plugin fehlen Fahrzeug-Steckbriefe, die Zuordnung von Werkstattberichten, die Eingabe der Linkempfehlungen und die Seitenmatrix.', 'el-team-wp-theme' )
		. '</p></div>';
}
add_action( 'admin_notices', 'el_team_plugin_missing_notice' );
