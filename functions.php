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

/**
 * Presselogo Mapping: Definiert Präfixe und zugehörige Logo-Dateien
 * Format: 'präfix' => 'dateiname.png'
 * Die Logos befinden sich in assets/images/presselogo/
 * 
 * @return array
 */
function el_team_get_presselogo_map() {
	return array(
		'hallo'  => 'hallo.png',
		'wmtv'  => 'wmtv.png',
		'wn'  => 'wn.png',
		'az'  => 'az.png',
		'mlz' => 'mlz.png',
		'rn' => 'rn.png',
		// Weitere Präfixe können hier hinzugefügt werden
		// 'prefix' => 'image.png',
		// Die Bilder liegen unter EL_TEAM_THEME_URI . '/assets/images/presselogo/'
	);
}

/**
 * Prüft, ob ein Titel mit einem definierten Präfix beginnt und ersetzt diesen durch ein Logo
 * 
 * @param string $title Der Artikel-Titel
 * @return string Der Titel mit Logo oder Original-Titel
 */
function el_team_replace_title_prefix_with_logo( $title ) {
	$logo_map = el_team_get_presselogo_map();
	
	foreach ( $logo_map as $prefix => $logo_file ) {
		// Prüfe Präfix case-insensitive mit Doppelpunkt
		$pattern = '/^' . preg_quote( $prefix, '/' ) . ':\s*/i';
		
		if ( preg_match( $pattern, $title ) ) {
			// Entferne Präfix aus Titel
			$clean_title = preg_replace( $pattern, '', $title );
			
			// Erstelle Logo-URL
			$logo_url = EL_TEAM_THEME_URI . '/assets/images/presselogo/' . $logo_file;
			
			// Erstelle HTML mit Logo und Titel
			$html = sprintf(
				'<img src="%s" alt="%s Logo" style="height:1.2em; max-height:100%%; width:auto; margin-right:5px; vertical-align:middle; display:inline-block;"> %s',
				esc_url( $logo_url ),
				esc_attr( $prefix ),
				esc_html( $clean_title )
			);
			
			return $html;
		}
	}
	
	// Falls kein Präfix gefunden, Original-Titel zurückgeben
	return esc_html( $title );
}

/**
 * Liefert Werkstattberichte für ein Fahrzeug zurück.
 *
 * @param int $fahrzeug_id Fahrzeug-Post-ID
 * @return WP_Query
 */
function el_team_get_werkstattberichte_for_fahrzeug( $fahrzeug_id ) {
	return new WP_Query( array(
		'post_type'      => 'werkstattbericht',
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'meta_query'     => array(
			array(
				'key'     => '_el_team_werkstatt_fahrzeug_id',
				'value'   => absint( $fahrzeug_id ),
				'compare' => '=',
			),
		),
	) );
}

/**
 * Prüft, ob die aktuelle Seite Unterseiten hat.
 *
 * @return bool True wenn Unterseiten existieren, false sonst.
 */
function el_team_has_subpages() {
	if ( ! is_page() ) {
		return false;
	}

	global $post;
	if ( ! $post ) {
		return false;
	}

	$subpages = get_pages( array(
		'child_of'    => $post->ID,
		'post_type'   => 'page',
		'post_status' => 'publish',
	) );

	return ! empty( $subpages );
}

/**
 * Gibt eine Liste der Unterseiten der aktuellen Seite zurück.
 *
 * @return array Array von Unterseiten-Objekten.
 */
function el_team_get_subpages() {
	if ( ! is_page() ) {
		return array();
	}

	global $post;
	if ( ! $post ) {
		return array();
	}

	return get_pages( array(
		'child_of'    => $post->ID,
		'post_type'   => 'page',
		'post_status' => 'publish',
		'sort_column' => 'menu_order,post_title',
		'sort_order'  => 'ASC',
	) );
}

