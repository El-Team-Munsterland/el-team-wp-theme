<?php
/**
 * Übersichtsseite einer Kategorie: Seiteninhalt und darunter alle Beiträge der Kategorie
 * als Tabelle (Datum, Titel), nach Jahren gruppiert. Zeitungskürzel im Titel ("rn: …")
 * erscheinen als Logo.
 *
 * Genutzt von page-presse.php, page-werkstatt.php und page-scm.php:
 * get_template_part( 'template-parts/content/kategorie-uebersicht', null, array( 'kategorie' => 'presse', 'bezeichnung' => 'Presse' ) );
 *
 * @var array $args kategorie (Slug), bezeichnung (für den Hinweis ohne Beiträge)
 */

$el_team_kategorie   = isset( $args['kategorie'] ) ? $args['kategorie'] : '';
$el_team_bezeichnung = isset( $args['bezeichnung'] ) ? $args['bezeichnung'] : $el_team_kategorie;

get_header();
?>
<div class="content-wrapper <?php echo el_team_has_subpages() ? 'has-sidebar' : ''; ?>">
	<main id="site-content" role="main" class="main-content">
		<header class="page-header">
			<h1 class="page-title"><?php the_title(); ?></h1>
		</header>

		<div class="page-content">
			<?php the_content(); ?>
		</div>

		<table class="kategorie-uebersicht kategorie-uebersicht--<?php echo esc_attr( $el_team_kategorie ); ?>">
			<tbody>
			<?php
			$el_team_query = new WP_Query( array(
				'category_name'  => $el_team_kategorie,
				'posts_per_page' => -1,
				'orderby'        => 'date',
				'order'          => 'DESC',
				'no_found_rows'  => true,
			) );

			if ( $el_team_query->have_posts() ) :
				$el_team_current_year = null;

				while ( $el_team_query->have_posts() ) :
					$el_team_query->the_post();
					$el_team_post_year = get_the_date( 'Y' );

					// Wenn Jahr sich ändert, Jahres-Header-Zeile einfügen
					if ( $el_team_post_year !== $el_team_current_year ) {
						?>
						<tr class="kategorie-uebersicht__jahr">
							<td colspan="2"><?php echo esc_html( $el_team_post_year ); ?></td>
						</tr>
						<?php
						$el_team_current_year = $el_team_post_year;
					}
					?>
					<tr>
						<td class="kategorie-uebersicht__datum"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'd.m.Y' ) ); ?></time></td>
						<td>
							<a href="<?php echo esc_url( get_permalink() ); ?>">
								<?php echo el_team_title_with_presselogo(); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in der Funktion. ?>
							</a>
						</td>
					</tr>
					<?php
				endwhile;
				wp_reset_postdata();
			else :
				?>
				<tr>
					<td colspan="2">
						<?php
						/* translators: %s: Name der Kategorie */
						echo esc_html( sprintf( __( 'Keine Beiträge in der Kategorie „%s“ gefunden.', 'el-team-wp-theme' ), $el_team_bezeichnung ) );
						?>
					</td>
				</tr>
				<?php
			endif;
			?>
			</tbody>
		</table>

	</main>

	<?php if ( el_team_has_subpages() ) get_sidebar(); ?>
</div>

<?php
get_footer();
