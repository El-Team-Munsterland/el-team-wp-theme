<?php
/**
 * Kennzeichnung externer Links.
 *
 * Das Symbol selbst steht als SVG in assets/css/custom.css und erscheint hinter allen
 * Links im Inhaltsbereich, deren Adresse mit http beginnt. Diese Datei nimmt Links auf
 * die eigene Domain davon aus und stellt den Shortcode [externer_link] bereit, mit dem
 * sich das Symbol z. B. im Haftungshinweis zeigen lässt.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Links mit voller Adresse der eigenen Website (mit und ohne www) bekommen kein Symbol,
 * auch nicht als Schaltfläche in den Linkempfehlungen.
 */
function el_team_external_links_inline_style() {
	$host = wp_parse_url( home_url(), PHP_URL_HOST );
	if ( ! $host ) {
		return;
	}
	$host      = preg_replace( '/^www\./i', '', $host );
	$selectors = array();
	foreach ( array( '.entry-content', '.page-content', '.el-team-links-grid' ) as $area ) {
		foreach ( array( $host, 'www.' . $host ) as $domain ) {
			$selectors[] = sprintf( '%s a[href*="//%s"]::after', $area, esc_attr( $domain ) );
		}
	}
	wp_add_inline_style( 'el-team-custom', implode( ',', $selectors ) . '{content:none}' );
}
add_action( 'wp_enqueue_scripts', 'el_team_external_links_inline_style', 20 );

/**
 * Shortcode [externer_link]: Muster-Link mit Symbol, z. B. für den Haftungshinweis.
 *
 * [externer_link]                       – nur das Symbol
 * [externer_link text="Beispiel-Link"]  – unterstrichener Text mit Symbol, nicht klickbar
 *
 * @param array $atts Attribute des Shortcodes
 * @return string
 */
function el_team_external_link_shortcode( $atts ) {
	$atts = shortcode_atts( array( 'text' => '' ), $atts, 'externer_link' );
	if ( '' === $atts['text'] ) {
		return '<span class="el-team-external-icon" role="img" aria-label="' . esc_attr__( 'Symbol für externe Links', 'el-team-wp-theme' ) . '"></span>';
	}
	return '<span class="el-team-external-sample">' . esc_html( $atts['text'] ) . '</span>';
}
add_shortcode( 'externer_link', 'el_team_external_link_shortcode' );
