<?php
/**
 * Kacheln zu Seiten (Startseite und 404-Seite), Auswahl unter Design → Startseite.
 *
 * Ohne eigenen Kurztext zeigt eine Kachel den Textauszug der Seite.
 */

foreach ( el_team_front_tiles() as $el_team_tile ) :
	?>
	<a class="front-tile" href="<?php echo esc_url( get_permalink( $el_team_tile['page'] ) ); ?>">
		<strong class="front-tile__title"><?php echo esc_html( get_the_title( $el_team_tile['page'] ) ); ?></strong>
		<span class="front-tile__text">
			<?php echo esc_html( '' !== $el_team_tile['text'] ? $el_team_tile['text'] : wp_trim_words( get_the_excerpt( $el_team_tile['page'] ), 14 ) ); ?>
		</span>
	</a>
	<?php
endforeach;
