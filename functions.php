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
		// Weitere Präfixe können hier hinzugefügt werden
		// 'prefix' => 'image.png',
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

