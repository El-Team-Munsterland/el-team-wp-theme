<?php
/**
 * El Team Theme Functions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define constants
// Version nur in style.css pflegen; sie hängt an den CSS/JS-Adressen, damit Browser Änderungen neu laden.
define( 'EL_TEAM_THEME_VERSION', wp_get_theme( get_template() )->get( 'Version' ) );
define( 'EL_TEAM_THEME_DIR', get_template_directory() );
define( 'EL_TEAM_THEME_URI', get_template_directory_uri() );

/**
 * Include theme setup functions
 */
require_once EL_TEAM_THEME_DIR . '/inc/setup.php';
require_once EL_TEAM_THEME_DIR . '/inc/enqueue.php';
require_once EL_TEAM_THEME_DIR . '/inc/plugin-compat.php';
require_once EL_TEAM_THEME_DIR . '/inc/footer-posts.php';
require_once EL_TEAM_THEME_DIR . '/inc/external-links.php';

/**
 * Include theme custom functions
 */
require_once EL_TEAM_THEME_DIR . '/inc/theme-dokumentation.php';

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
 * Zerlegt einen Titel in Präfix (Schlüssel aus el_team_get_presselogo_map, z. B. "rn") und Resttitel.
 *
 * @param string $title Titel, z. B. "rn: Begeisterung auf drei Rädern"
 * @return array Präfix (oder null) und Titel ohne Präfix
 */
function el_team_split_title_prefix( $title ) {
	foreach ( el_team_get_presselogo_map() as $prefix => $logo_file ) {
		// Präfix case-insensitive mit Doppelpunkt
		$pattern = '/^' . preg_quote( $prefix, '/' ) . ':\s*/i';
		if ( preg_match( $pattern, $title ) ) {
			return array( $prefix, preg_replace( $pattern, '', $title, 1 ) );
		}
	}
	return array( null, $title );
}

/**
 * Prüft, ob ein Titel mit einem definierten Präfix beginnt und ersetzt diesen durch ein Logo
 *
 * Erwartet den Titel so, wie er gespeichert ist (mit Präfix), z. B. aus el_team_title_with_presselogo().
 *
 * @param string $title Der Artikel-Titel
 * @return string Der Titel mit Logo oder Original-Titel (HTML, escaped)
 */
function el_team_replace_title_prefix_with_logo( $title ) {
	static $sizes = array();

	list( $prefix, $clean_title ) = el_team_split_title_prefix( $title );
	$clean_title = esc_html( wptexturize( $clean_title ) );
	if ( null === $prefix ) {
		return $clean_title;
	}

	$logo_file = el_team_get_presselogo_map()[ $prefix ];
	if ( ! isset( $sizes[ $logo_file ] ) ) {
		$size                 = @getimagesize( EL_TEAM_THEME_DIR . '/assets/images/presselogo/' . $logo_file );
		$sizes[ $logo_file ] = $size ? sprintf( ' width="%d" height="%d"', $size[0], $size[1] ) : '';
	}

	return sprintf(
		'<img src="%s" alt="%s"%s class="presselogo">%s',
		esc_url( EL_TEAM_THEME_URI . '/assets/images/presselogo/' . $logo_file ),
		/* translators: %s: Kürzel der Zeitung, z. B. RN */
		esc_attr( sprintf( __( '%s Logo', 'el-team-wp-theme' ), strtoupper( $prefix ) ) ),
		$sizes[ $logo_file ],
		$clean_title
	);
}

/**
 * Titel eines Beitrags mit Logo statt Präfix (für Übersichten und die Beitragsseite).
 *
 * @param int|WP_Post|null $post Beitrag, Standard: aktueller Beitrag
 * @return string HTML, escaped
 */
function el_team_title_with_presselogo( $post = null ) {
	return el_team_replace_title_prefix_with_logo( get_post_field( 'post_title', $post ) );
}

/**
 * Entfernt das Präfix ("rn: ") aus Titeln außerhalb des Adminbereichs: im Footer, in Listen,
 * in der Suche, im RSS-Feed und im Titel des Browser-Tabs. Im Adminbereich bleibt es stehen,
 * damit es beim Bearbeiten sichtbar ist.
 *
 * @param string $title Titel
 * @return string
 */
function el_team_strip_title_prefix( $title ) {
	if ( is_admin() || ! is_string( $title ) ) {
		return $title;
	}
	list( , $clean_title ) = el_team_split_title_prefix( $title );
	return $clean_title;
}
add_filter( 'the_title', 'el_team_strip_title_prefix' );
add_filter( 'single_post_title', 'el_team_strip_title_prefix' );

/**
 * Liefert Werkstattberichte für ein Fahrzeug zurück.
 *
 * Die Daten (Inhaltstypen, Zuordnung) verwaltet das Plugin "CityEL Werkstatt";
 * ohne Plugin wird direkt über das Meta-Feld abgefragt.
 *
 * @param int $fahrzeug_id Fahrzeug-Post-ID
 * @return WP_Query
 */
function el_team_get_werkstattberichte_for_fahrzeug( $fahrzeug_id ) {
	if ( function_exists( 'cityel_vehicle_reports' ) ) {
		return cityel_vehicle_reports( $fahrzeug_id );
	}
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
 * Linkempfehlungen einer Seite, sortiert nach Reihenfolge.
 *
 * @param int $post_id Seiten-ID
 * @return array
 */
function el_team_get_link_recommendations( $post_id ) {
	if ( function_exists( 'cityel_link_recommendations' ) ) {
		return cityel_link_recommendations( $post_id );
	}
	$links = get_post_meta( $post_id, '_el_team_links', true );
	if ( empty( $links ) || ! is_array( $links ) ) {
		return array();
	}
	usort( $links, function ( $a, $b ) {
		return ( isset( $a['link_order'] ) ? (int) $a['link_order'] : 0 ) - ( isset( $b['link_order'] ) ? (int) $b['link_order'] : 0 );
	} );
	return $links;
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
