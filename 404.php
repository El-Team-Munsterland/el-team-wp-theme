<?php
/**
 * Seite nicht gefunden (404)
 *
 * Hinweis, Suche, Schaltfläche zur Startseite und – falls unter Design → Startseite
 * eingerichtet – die Kacheln der Startseite als Wegweiser.
 */

get_header();
?>

<main id="site-content" class="site-main not-found">
	<header class="page-header">
		<p class="not-found__code" aria-hidden="true">404</p>
		<h1 class="page-title"><?php esc_html_e( 'Diese Seite gibt es nicht (mehr)', 'el-team-wp-theme' ); ?></h1>
	</header>

	<div class="page-content">
		<p><?php esc_html_e( 'Vielleicht hat sich die Adresse geändert, oder der Link war fehlerhaft. Probier es mit der Suche oder schau auf der Startseite vorbei.', 'el-team-wp-theme' ); ?></p>

		<div class="not-found__search">
			<?php get_search_form(); ?>
		</div>

		<div class="front-buttons">
			<a class="front-btn front-btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Zur Startseite', 'el-team-wp-theme' ); ?></a>
		</div>
	</div>

	<?php if ( el_team_front_tiles() ) : ?>
		<section class="not-found__tiles" aria-labelledby="not-found-tiles-title">
			<h2 id="not-found-tiles-title"><?php esc_html_e( 'Oder direkt zu einem unserer Bereiche', 'el-team-wp-theme' ); ?></h2>
			<div class="front-tiles">
				<?php get_template_part( 'template-parts/front/kacheln' ); ?>
			</div>
		</section>
	<?php endif; ?>
</main>

<?php
get_footer();
