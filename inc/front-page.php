<?php
/**
 * Startseite (front-page.php) und ihre Einstellungen unter Design → Startseite.
 *
 * Die Startseite zeigt: Begrüßung (Inhalt und Beitragsbild der unter Einstellungen → Lesen
 * gewählten Startseite) mit bis zu zwei Schaltflächen, Kacheln zu ausgewählten Seiten,
 * die neuesten Beiträge als Karten und die neuesten Presseartikel mit Zeitungslogo.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'EL_TEAM_FRONT_OPTION', 'el_team_front_settings' );

/**
 * Standardwerte der Startseiten-Einstellungen.
 *
 * @return array
 */
function el_team_front_defaults() {
	return array(
		/* translators: %s: Name der Website */
		'hero_title'  => sprintf( __( 'Willkommen beim %s!', 'el-team-wp-theme' ), get_bloginfo( 'name' ) ),
		'buttons'     => array(
			array( 'page' => 0, 'label' => '' ),
			array( 'page' => 0, 'label' => '' ),
		),
		'tiles_title' => __( 'Was wir machen', 'el-team-wp-theme' ),
		'tiles'       => array(),
		'news_title'  => __( 'Neues aus dem Team', 'el-team-wp-theme' ),
		'news_count'  => 2,
		'press_title' => __( 'Presse', 'el-team-wp-theme' ),
		'press_cat'   => 'presse',
		'press_count' => 3,
	);
}

/**
 * Gespeicherte Startseiten-Einstellungen, ergänzt um die Standardwerte.
 *
 * @return array
 */
function el_team_front_settings() {
	$saved = get_option( EL_TEAM_FRONT_OPTION );
	return wp_parse_args( is_array( $saved ) ? $saved : array(), el_team_front_defaults() );
}

/**
 * Bereinigt die Eingaben der Einstellungsseite.
 *
 * @param array $input Rohdaten aus dem Formular
 * @return array
 */
function el_team_front_sanitize( $input ) {
	$defaults = el_team_front_defaults();
	$input    = is_array( $input ) ? $input : array();
	$text     = function ( $key ) use ( $input, $defaults ) {
		return isset( $input[ $key ] ) ? sanitize_text_field( $input[ $key ] ) : $defaults[ $key ];
	};
	$count    = function ( $key, $max ) use ( $input, $defaults ) {
		return isset( $input[ $key ] ) ? max( 0, min( $max, (int) $input[ $key ] ) ) : $defaults[ $key ];
	};

	$buttons = array();
	for ( $i = 0; $i < 2; $i++ ) {
		$button    = isset( $input['buttons'][ $i ] ) && is_array( $input['buttons'][ $i ] ) ? $input['buttons'][ $i ] : array();
		$buttons[] = array(
			'page'  => isset( $button['page'] ) ? absint( $button['page'] ) : 0,
			'label' => isset( $button['label'] ) ? sanitize_text_field( $button['label'] ) : '',
		);
	}

	// Kacheln in der Reihenfolge des Formulars; Zeilen ohne Seite entfallen
	$tiles = array();
	if ( isset( $input['tiles'] ) && is_array( $input['tiles'] ) ) {
		foreach ( $input['tiles'] as $tile ) {
			$page = isset( $tile['page'] ) ? absint( $tile['page'] ) : 0;
			if ( $page ) {
				$tiles[] = array(
					'page' => $page,
					'text' => isset( $tile['text'] ) ? sanitize_text_field( $tile['text'] ) : '',
				);
			}
		}
	}

	return array(
		'hero_title'  => $text( 'hero_title' ),
		'buttons'     => $buttons,
		'tiles_title' => $text( 'tiles_title' ),
		'tiles'       => $tiles,
		'news_title'  => $text( 'news_title' ),
		'news_count'  => $count( 'news_count', 12 ),
		'press_title' => $text( 'press_title' ),
		'press_cat'   => isset( $input['press_cat'] ) ? sanitize_title( $input['press_cat'] ) : $defaults['press_cat'],
		'press_count' => $count( 'press_count', 10 ),
	);
}

/**
 * Registriert die Einstellung.
 */
function el_team_front_register_setting() {
	register_setting( 'el_team_front', EL_TEAM_FRONT_OPTION, array(
		'type'              => 'array',
		'sanitize_callback' => 'el_team_front_sanitize',
	) );
}
add_action( 'admin_init', 'el_team_front_register_setting' );

/**
 * Menüpunkt Design → Startseite.
 */
function el_team_front_admin_menu() {
	add_theme_page(
		__( 'Startseite', 'el-team-wp-theme' ),
		__( 'Startseite', 'el-team-wp-theme' ),
		'edit_theme_options',
		'el-team-startseite',
		'el_team_front_render_settings_page'
	);
}
add_action( 'admin_menu', 'el_team_front_admin_menu' );

/**
 * Kacheln hinzufügen, entfernen und verschieben auf der Einstellungsseite.
 *
 * @param string $hook_suffix Kennung der aktuellen Admin-Seite
 */
function el_team_front_admin_scripts( $hook_suffix ) {
	if ( 'appearance_page_el-team-startseite' !== $hook_suffix ) {
		return;
	}
	wp_enqueue_script( 'el-team-front-admin', EL_TEAM_THEME_URI . '/assets/js/admin-startseite.js', array(), EL_TEAM_THEME_VERSION, true );
}
add_action( 'admin_enqueue_scripts', 'el_team_front_admin_scripts' );

/**
 * Auswahlliste der veröffentlichten Seiten.
 *
 * @param string $name     Feldname
 * @param int    $selected ID der gewählten Seite
 * @param string $id       HTML-ID (optional)
 * @return string HTML
 */
function el_team_front_page_dropdown( $name, $selected, $id = '' ) {
	return wp_dropdown_pages( array(
		'name'              => $name,
		'id'                => $id,
		'selected'          => (int) $selected,
		'show_option_none'  => __( '— keine —', 'el-team-wp-theme' ),
		'option_none_value' => '0',
		'echo'              => 0,
	) );
}

/**
 * Eine Zeile der Kachel-Tabelle.
 *
 * @param string|int $index Laufende Nummer oder Platzhalter für die Vorlage
 * @param array      $tile  page, text
 * @return string HTML
 */
function el_team_front_tile_row( $index, $tile ) {
	$name = EL_TEAM_FRONT_OPTION . '[tiles][' . $index . ']';
	ob_start();
	?>
	<tr class="el-team-tile-row">
		<td><?php echo el_team_front_page_dropdown( $name . '[page]', $tile['page'] ); // phpcs:ignore WordPress.Security.EscapeOutput -- von WordPress erzeugt. ?></td>
		<td><input type="text" class="regular-text" name="<?php echo esc_attr( $name . '[text]' ); ?>" value="<?php echo esc_attr( $tile['text'] ); ?>" placeholder="<?php esc_attr_e( 'leer: Textauszug der Seite', 'el-team-wp-theme' ); ?>"></td>
		<td class="el-team-tile-actions">
			<button type="button" class="button el-team-tile-up" aria-label="<?php esc_attr_e( 'Nach oben', 'el-team-wp-theme' ); ?>">↑</button>
			<button type="button" class="button el-team-tile-down" aria-label="<?php esc_attr_e( 'Nach unten', 'el-team-wp-theme' ); ?>">↓</button>
			<button type="button" class="button el-team-tile-remove" aria-label="<?php esc_attr_e( 'Entfernen', 'el-team-wp-theme' ); ?>">✕</button>
		</td>
	</tr>
	<?php
	return ob_get_clean();
}

/**
 * Einstellungsseite Design → Startseite.
 */
function el_team_front_render_settings_page() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	$settings = el_team_front_settings();
	$name     = EL_TEAM_FRONT_OPTION;
	$tiles    = $settings['tiles'];
	// Ohne JavaScript: immer eine leere Zeile für eine weitere Kachel
	$tiles[] = array( 'page' => 0, 'text' => '' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Startseite', 'el-team-wp-theme' ); ?></h1>
		<p><?php esc_html_e( 'Die Startseite zeigt eine Begrüßung, Kacheln zu ausgewählten Seiten, die neuesten Beiträge und die neuesten Presseartikel. Begrüßungstext und Foto sind Inhalt und Beitragsbild der Seite, die unter Einstellungen → Lesen als Startseite gewählt ist.', 'el-team-wp-theme' ); ?></p>

		<?php if ( 'page' !== get_option( 'show_on_front' ) || ! get_option( 'page_on_front' ) ) : ?>
			<div class="notice notice-warning inline"><p>
				<?php esc_html_e( 'Unter Einstellungen → Lesen ist keine statische Startseite gewählt. Solange dort „Deine letzten Beiträge“ eingestellt ist, zeigt die Startseite die Beitragsliste und diese Einstellungen wirken nicht.', 'el-team-wp-theme' ); ?>
			</p></div>
		<?php else : ?>
			<p>
				<?php
				printf(
					/* translators: %s: Link zum Bearbeiten der Startseite */
					esc_html__( 'Begrüßungstext und Foto bearbeiten: %s', 'el-team-wp-theme' ),
					'<a href="' . esc_url( get_edit_post_link( get_option( 'page_on_front' ) ) ) . '">' . esc_html( get_the_title( get_option( 'page_on_front' ) ) ) . '</a>'
				);
				?>
			</p>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'el_team_front' ); ?>

			<h2><?php esc_html_e( 'Begrüßung', 'el-team-wp-theme' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="el-team-hero-title"><?php esc_html_e( 'Überschrift', 'el-team-wp-theme' ); ?></label></th>
					<td><input type="text" id="el-team-hero-title" class="regular-text" name="<?php echo esc_attr( $name ); ?>[hero_title]" value="<?php echo esc_attr( $settings['hero_title'] ); ?>"></td>
				</tr>
				<?php foreach ( $settings['buttons'] as $i => $button ) : ?>
					<tr>
						<th scope="row">
							<?php
							/* translators: %d: Nummer der Schaltfläche */
							echo esc_html( sprintf( __( 'Schaltfläche %d', 'el-team-wp-theme' ), $i + 1 ) );
							?>
						</th>
						<td>
							<label><?php esc_html_e( 'Seite', 'el-team-wp-theme' ); ?>
								<?php echo el_team_front_page_dropdown( $name . '[buttons][' . $i . '][page]', $button['page'] ); // phpcs:ignore WordPress.Security.EscapeOutput -- von WordPress erzeugt. ?>
							</label>
							<label><?php esc_html_e( 'Beschriftung', 'el-team-wp-theme' ); ?>
								<input type="text" name="<?php echo esc_attr( $name . '[buttons][' . $i . '][label]' ); ?>" value="<?php echo esc_attr( $button['label'] ); ?>" placeholder="<?php esc_attr_e( 'leer: Titel der Seite', 'el-team-wp-theme' ); ?>">
							</label>
							<?php if ( 0 === $i ) : ?>
								<p class="description"><?php esc_html_e( 'Ohne gewählte Seite entfällt die Schaltfläche. Die erste ist blau, die zweite gelb.', 'el-team-wp-theme' ); ?></p>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>

			<h2><?php esc_html_e( 'Kacheln', 'el-team-wp-theme' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="el-team-tiles-title"><?php esc_html_e( 'Überschrift', 'el-team-wp-theme' ); ?></label></th>
					<td><input type="text" id="el-team-tiles-title" class="regular-text" name="<?php echo esc_attr( $name ); ?>[tiles_title]" value="<?php echo esc_attr( $settings['tiles_title'] ); ?>"></td>
				</tr>
			</table>
			<p><?php esc_html_e( 'Jede Zeile ist eine Kachel mit dem Titel der Seite und einem kurzen Text, in dieser Reihenfolge. Ohne Kacheln entfällt der Bereich.', 'el-team-wp-theme' ); ?></p>
			<table class="widefat striped el-team-tiles" style="max-width: 980px;">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Seite', 'el-team-wp-theme' ); ?></th>
						<th><?php esc_html_e( 'Kurzer Text', 'el-team-wp-theme' ); ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ( $tiles as $i => $tile ) {
						echo el_team_front_tile_row( $i, $tile ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in der Funktion.
					}
					?>
				</tbody>
			</table>
			<template id="el-team-tile-template"><?php echo el_team_front_tile_row( '__INDEX__', array( 'page' => 0, 'text' => '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in der Funktion. ?></template>
			<p><button type="button" class="button el-team-tile-add" hidden><?php esc_html_e( 'Kachel hinzufügen', 'el-team-wp-theme' ); ?></button></p>

			<h2><?php esc_html_e( 'Neueste Beiträge und Presse', 'el-team-wp-theme' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="el-team-news-title"><?php esc_html_e( 'Überschrift Beiträge', 'el-team-wp-theme' ); ?></label></th>
					<td><input type="text" id="el-team-news-title" class="regular-text" name="<?php echo esc_attr( $name ); ?>[news_title]" value="<?php echo esc_attr( $settings['news_title'] ); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="el-team-news-count"><?php esc_html_e( 'Anzahl Beiträge', 'el-team-wp-theme' ); ?></label></th>
					<td>
						<input type="number" id="el-team-news-count" class="small-text" min="0" max="12" name="<?php echo esc_attr( $name ); ?>[news_count]" value="<?php echo esc_attr( $settings['news_count'] ); ?>">
						<p class="description"><?php esc_html_e( 'Die neuesten Beiträge ohne die Presse-Kategorie, als Karten mit Beitragsbild. 0 blendet den Bereich aus.', 'el-team-wp-theme' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="el-team-press-title"><?php esc_html_e( 'Überschrift Presse', 'el-team-wp-theme' ); ?></label></th>
					<td><input type="text" id="el-team-press-title" class="regular-text" name="<?php echo esc_attr( $name ); ?>[press_title]" value="<?php echo esc_attr( $settings['press_title'] ); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="el-team-press-cat"><?php esc_html_e( 'Presse-Kategorie', 'el-team-wp-theme' ); ?></label></th>
					<td>
						<?php
						wp_dropdown_categories( array(
							'id'                => 'el-team-press-cat',
							'name'              => $name . '[press_cat]',
							'taxonomy'          => 'category',
							'value_field'       => 'slug',
							'selected'          => $settings['press_cat'],
							'hide_empty'        => false,
							'hierarchical'      => true,
							'show_option_none'  => __( '— keine —', 'el-team-wp-theme' ),
							'option_none_value' => '',
						) );
						?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="el-team-press-count"><?php esc_html_e( 'Anzahl Presseartikel', 'el-team-wp-theme' ); ?></label></th>
					<td>
						<input type="number" id="el-team-press-count" class="small-text" min="0" max="10" name="<?php echo esc_attr( $name ); ?>[press_count]" value="<?php echo esc_attr( $settings['press_count'] ); ?>">
						<p class="description"><?php esc_html_e( '0 blendet den Bereich aus. „Alle“ führt zur Seite mit der Vorlage „Presse Übersicht“.', 'el-team-wp-theme' ); ?></p>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

/**
 * Kategorie-ID der Presse-Kategorie aus Design → Startseite.
 *
 * @return int 0, wenn keine gewählt ist
 */
function el_team_front_press_cat_id() {
	$slug     = el_team_front_settings()['press_cat'];
	$category = '' !== $slug ? get_category_by_slug( $slug ) : false;
	return $category ? (int) $category->term_id : 0;
}

/**
 * IDs der Presse-Kategorie und ihrer Unterkategorien (wie auf der Seite „Presse Übersicht“).
 *
 * @return int[] leer, wenn keine Presse-Kategorie gewählt ist
 */
function el_team_front_press_cat_ids() {
	$press_cat_id = el_team_front_press_cat_id();
	if ( ! $press_cat_id ) {
		return array();
	}
	$children = get_term_children( $press_cat_id, 'category' );
	return array_merge( array( $press_cat_id ), is_array( $children ) ? array_map( 'intval', $children ) : array() );
}

/**
 * Ist ein Beitrag nur der Presse-Kategorie (oder ihren Unterkategorien) zugeordnet?
 *
 * @param int|WP_Post $post Beitrag
 * @return bool
 */
function el_team_is_press_only( $post ) {
	$press_cat_ids = el_team_front_press_cat_ids();
	if ( ! $press_cat_ids ) {
		return false;
	}
	$categories = array_map( 'intval', wp_get_post_categories( is_object( $post ) ? $post->ID : $post ) );
	return $categories && ! array_diff( $categories, $press_cat_ids );
}

/**
 * Neueste Beiträge, die eine Bedingung erfüllen, in Blöcken von 20 gelesen.
 *
 * @param array    $args   Abfrage für get_posts (ohne posts_per_page/paged)
 * @param callable $filter Bedingung je Beitrag
 * @param int      $count  gewünschte Anzahl
 * @return WP_Post[]
 */
function el_team_front_filtered_posts( $args, $filter, $count ) {
	$found = array();
	// Höchstens 10 Blöcke (200 Beiträge) durchsehen, falls passende Beiträge sehr selten sind
	for ( $page = 1; $page <= 10 && count( $found ) < $count; $page++ ) {
		$posts = get_posts( array_merge( $args, array(
			'posts_per_page'      => 20,
			'paged'               => $page,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		) ) );
		foreach ( $posts as $post ) {
			if ( $filter( $post ) ) {
				$found[] = $post;
				if ( count( $found ) >= $count ) {
					break;
				}
			}
		}
		if ( count( $posts ) < 20 ) {
			break;
		}
	}
	return $found;
}

/**
 * Neueste Beiträge für die Startseite: alle außer reinen Presseartikeln.
 *
 * Ein Beitrag in Presse und Werkstatt erscheint hier, einer nur in Presse unter „Presse“.
 *
 * @return WP_Post[]
 */
function el_team_front_news_posts() {
	$count = el_team_front_settings()['news_count'];
	if ( $count < 1 ) {
		return array();
	}
	return el_team_front_filtered_posts(
		array( 'post_type' => 'post' ),
		function ( $post ) {
			return ! el_team_is_press_only( $post );
		},
		$count
	);
}

/**
 * Neueste Presseartikel für die Startseite: alle Beiträge der Presse-Kategorie, auch solche
 * mit weiteren Kategorien. Was schon unter „Neues aus dem Team“ steht, erscheint hier nicht
 * ein zweites Mal.
 *
 * @param WP_Post[] $exclude Beiträge, die schon auf der Startseite stehen
 * @return WP_Post[]
 */
function el_team_front_press_posts( $exclude = array() ) {
	$count         = el_team_front_settings()['press_count'];
	$press_cat_ids = el_team_front_press_cat_ids();
	if ( $count < 1 || ! $press_cat_ids ) {
		return array();
	}
	return get_posts( array(
		'post_type'           => 'post',
		'category__in'        => $press_cat_ids,
		'post__not_in'        => wp_list_pluck( $exclude, 'ID' ),
		'posts_per_page'      => $count,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	) );
}

/**
 * Ziel für „Alle Presseartikel“: die Seite mit der Vorlage „Presse Übersicht“, sonst das Kategorie-Archiv.
 *
 * @return string URL oder leer
 */
function el_team_front_press_url() {
	$pages = get_pages( array(
		'meta_key'   => '_wp_page_template',
		'meta_value' => 'page-presse.php',
		'number'     => 1,
	) );
	if ( $pages ) {
		return get_permalink( $pages[0] );
	}
	$category = get_category_by_slug( el_team_front_settings()['press_cat'] );
	return $category ? get_category_link( $category ) : '';
}

/**
 * Ziel für „Alle Beiträge“: die unter Einstellungen → Lesen gewählte Beitragsseite.
 *
 * @return string URL oder leer
 */
function el_team_front_posts_url() {
	$page_for_posts = (int) get_option( 'page_for_posts' );
	return $page_for_posts ? get_permalink( $page_for_posts ) : '';
}
