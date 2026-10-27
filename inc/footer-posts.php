<?php
/**
 * Footer mit den neuesten Beiträgen.
 *
 * Einstellungen unter Design → Footer: welche Inhaltstypen ausgelesen werden, wie viele
 * Beiträge erscheinen, die Überschrift und die Hintergrundfarbe des Footers.
 * Ausgabe: template-parts/footer/latest-posts.php, Styles in assets/css/custom.css.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'EL_TEAM_FOOTER_OPTION', 'el_team_footer_settings' );

/**
 * Inhaltstypen, die im Footer zur Auswahl stehen (alle öffentlichen außer Medien).
 *
 * @return WP_Post_Type[]
 */
function el_team_footer_available_post_types() {
	$post_types = get_post_types( array( 'public' => true ), 'objects' );
	unset( $post_types['attachment'] );
	return $post_types;
}

/**
 * Standardwerte der Footer-Einstellungen.
 *
 * Ohne gespeicherte Auswahl werden alle öffentlichen Inhaltstypen außer Seiten ausgelesen.
 *
 * @return array
 */
function el_team_footer_defaults() {
	$post_types = array_keys( el_team_footer_available_post_types() );
	return array(
		'post_types' => array_values( array_diff( $post_types, array( 'page' ) ) ),
		'count'      => 6,
		'title'      => __( 'Neueste Beiträge', 'el-team-wp-theme' ),
		'bg_color'   => '#000000',
	);
}

/**
 * Gespeicherte Footer-Einstellungen, ergänzt um die Standardwerte.
 *
 * @return array
 */
function el_team_footer_settings() {
	$saved = get_option( EL_TEAM_FOOTER_OPTION );
	if ( ! is_array( $saved ) ) {
		$saved = array();
	}
	return wp_parse_args( $saved, el_team_footer_defaults() );
}

/**
 * Bereinigt die Eingaben der Einstellungsseite.
 *
 * @param array $input Rohdaten aus dem Formular
 * @return array
 */
function el_team_footer_sanitize( $input ) {
	$defaults = el_team_footer_defaults();
	$input    = is_array( $input ) ? $input : array();

	$post_types = isset( $input['post_types'] ) ? (array) $input['post_types'] : array();
	$post_types = array_map( 'sanitize_key', $post_types );
	// Gespeichert werden auch Typen, deren Plugin gerade inaktiv ist; die Abfrage filtert sie.
	$post_types = array_values( array_unique( array_filter( $post_types ) ) );

	$count = isset( $input['count'] ) ? absint( $input['count'] ) : $defaults['count'];
	$count = max( 1, min( 24, $count ) );

	$title = isset( $input['title'] ) ? sanitize_text_field( $input['title'] ) : $defaults['title'];

	$bg_color = isset( $input['bg_color'] ) ? sanitize_hex_color( $input['bg_color'] ) : '';
	if ( empty( $bg_color ) ) {
		$bg_color = $defaults['bg_color'];
	}

	return array(
		'post_types' => $post_types,
		'count'      => $count,
		'title'      => $title,
		'bg_color'   => $bg_color,
	);
}

/**
 * Registriert die Einstellung.
 */
function el_team_footer_register_setting() {
	register_setting( 'el_team_footer', EL_TEAM_FOOTER_OPTION, array(
		'type'              => 'array',
		'sanitize_callback' => 'el_team_footer_sanitize',
	) );
}
add_action( 'admin_init', 'el_team_footer_register_setting' );

/**
 * Menüpunkt Design → Footer.
 */
function el_team_footer_admin_menu() {
	add_theme_page(
		__( 'Footer', 'el-team-wp-theme' ),
		__( 'Footer', 'el-team-wp-theme' ),
		'edit_theme_options',
		'el-team-footer',
		'el_team_footer_render_settings_page'
	);
}
add_action( 'admin_menu', 'el_team_footer_admin_menu' );

/**
 * Farbwähler von WordPress auf der Einstellungsseite.
 *
 * @param string $hook_suffix Kennung der aktuellen Admin-Seite
 */
function el_team_footer_admin_scripts( $hook_suffix ) {
	if ( 'appearance_page_el-team-footer' !== $hook_suffix ) {
		return;
	}
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_add_inline_script( 'wp-color-picker', 'jQuery( function ( $ ) { $( ".el-team-footer-color" ).wpColorPicker(); } );' );
}
add_action( 'admin_enqueue_scripts', 'el_team_footer_admin_scripts' );

/**
 * Einstellungsseite Design → Footer.
 */
function el_team_footer_render_settings_page() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	$settings   = el_team_footer_settings();
	$defaults   = el_team_footer_defaults();
	$name       = EL_TEAM_FOOTER_OPTION;
	$post_types = el_team_footer_available_post_types();
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Footer', 'el-team-wp-theme' ); ?></h1>
		<p><?php esc_html_e( 'Der Footer zeigt die neuesten Beiträge aus den gewählten Inhaltstypen. Copyright und Impressum-Link stehen weiterhin darunter.', 'el-team-wp-theme' ); ?></p>

		<form method="post" action="options.php">
			<?php settings_fields( 'el_team_footer' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><?php esc_html_e( 'Inhaltstypen', 'el-team-wp-theme' ); ?></th>
					<td>
						<fieldset>
							<legend class="screen-reader-text"><?php esc_html_e( 'Inhaltstypen', 'el-team-wp-theme' ); ?></legend>
							<?php // Leerer Wert, damit "nichts ausgewählt" gespeichert werden kann. ?>
							<input type="hidden" name="<?php echo esc_attr( $name ); ?>[post_types][]" value="">
							<?php foreach ( $post_types as $post_type ) : ?>
								<label>
									<input type="checkbox" name="<?php echo esc_attr( $name ); ?>[post_types][]" value="<?php echo esc_attr( $post_type->name ); ?>" <?php checked( in_array( $post_type->name, $settings['post_types'], true ) ); ?>>
									<?php echo esc_html( $post_type->labels->name ); ?>
									<code><?php echo esc_html( $post_type->name ); ?></code>
								</label><br>
							<?php endforeach; ?>
							<p class="description"><?php esc_html_e( 'Aus diesen Inhaltstypen werden die neuesten veröffentlichten Beiträge gemischt nach Datum angezeigt. Ist nichts ausgewählt, entfällt der Bereich.', 'el-team-wp-theme' ); ?></p>
						</fieldset>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="el-team-footer-count"><?php esc_html_e( 'Anzahl Beiträge', 'el-team-wp-theme' ); ?></label></th>
					<td>
						<input type="number" id="el-team-footer-count" name="<?php echo esc_attr( $name ); ?>[count]" value="<?php echo esc_attr( $settings['count'] ); ?>" min="1" max="24" class="small-text">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="el-team-footer-title"><?php esc_html_e( 'Überschrift', 'el-team-wp-theme' ); ?></label></th>
					<td>
						<input type="text" id="el-team-footer-title" name="<?php echo esc_attr( $name ); ?>[title]" value="<?php echo esc_attr( $settings['title'] ); ?>" class="regular-text">
						<p class="description"><?php esc_html_e( 'Leer lassen, um keine Überschrift anzuzeigen.', 'el-team-wp-theme' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="el-team-footer-bg"><?php esc_html_e( 'Hintergrundfarbe', 'el-team-wp-theme' ); ?></label></th>
					<td>
						<input type="text" id="el-team-footer-bg" name="<?php echo esc_attr( $name ); ?>[bg_color]" value="<?php echo esc_attr( $settings['bg_color'] ); ?>" class="el-team-footer-color" data-default-color="<?php echo esc_attr( $defaults['bg_color'] ); ?>">
						<p class="description"><?php esc_html_e( 'Die Schriftfarbe wird automatisch hell oder dunkel gewählt, damit der Text lesbar bleibt.', 'el-team-wp-theme' ); ?></p>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

/**
 * Neueste Beiträge aus den gewählten Inhaltstypen.
 *
 * @return WP_Query|null null, wenn kein (registrierter) Inhaltstyp gewählt ist
 */
function el_team_footer_latest_posts() {
	$settings   = el_team_footer_settings();
	$post_types = array_values( array_filter( $settings['post_types'], 'post_type_exists' ) );
	if ( empty( $post_types ) ) {
		return null;
	}
	return new WP_Query( array(
		'post_type'           => $post_types,
		'post_status'         => 'publish',
		'posts_per_page'      => (int) $settings['count'],
		'orderby'             => 'date',
		'order'               => 'DESC',
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
		'has_password'        => false,
	) );
}

/**
 * Anzahl der Wörter eines Beitrags (ohne HTML, Shortcodes und Block-Kommentare).
 *
 * @param WP_Post|int|null $post Beitrag, Standard: aktueller Beitrag
 * @return int
 */
function el_team_post_word_count( $post = null ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return 0;
	}
	$text  = wp_strip_all_tags( strip_shortcodes( $post->post_content ) );
	$words = preg_split( '/\s+/u', trim( html_entity_decode( $text, ENT_QUOTES, 'UTF-8' ) ), -1, PREG_SPLIT_NO_EMPTY );
	return is_array( $words ) ? count( $words ) : 0;
}

/**
 * Schriftfarbe, die auf der gewählten Hintergrundfarbe lesbar ist.
 *
 * @param string $hex Hintergrundfarbe (#rgb oder #rrggbb)
 * @return string
 */
function el_team_footer_text_color( $hex ) {
	$hex = ltrim( $hex, '#' );
	if ( 3 === strlen( $hex ) ) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}
	$channels = array_map( 'hexdec', str_split( $hex, 2 ) );
	// Relative Helligkeit nach WCAG
	$linear = array_map( function ( $c ) {
		$c = $c / 255;
		return $c <= 0.03928 ? $c / 12.92 : pow( ( $c + 0.055 ) / 1.055, 2.4 );
	}, $channels );
	$luminance = 0.2126 * $linear[0] + 0.7152 * $linear[1] + 0.0722 * $linear[2];
	return $luminance > 0.179 ? '#111111' : '#ffffff';
}

/**
 * Farben des Footers als CSS-Variablen.
 */
function el_team_footer_inline_style() {
	$settings = el_team_footer_settings();
	$css      = sprintf(
		'.site-footer{--el-footer-bg:%1$s;--el-footer-fg:%2$s;}',
		esc_html( $settings['bg_color'] ),
		esc_html( el_team_footer_text_color( $settings['bg_color'] ) )
	);
	wp_add_inline_style( 'el-team-custom', $css );
}
add_action( 'wp_enqueue_scripts', 'el_team_footer_inline_style', 20 );
