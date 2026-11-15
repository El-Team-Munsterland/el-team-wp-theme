<?php
/**
 * Startseite
 *
 * Begrüßung (Inhalt und Beitragsbild der Startseite), Kacheln, neueste Beiträge und Presse.
 * Einstellungen: Design → Startseite (inc/front-page.php). Ist unter Einstellungen → Lesen
 * keine statische Startseite gewählt, zeigt die Startseite die Beitragsliste (index.php).
 */

if ( is_home() ) {
	require get_template_directory() . '/index.php';
	return;
}

$el_team_front = el_team_front_settings();

get_header();
?>

<main id="site-content" class="site-main front">
	<?php
	while ( have_posts() ) :
		the_post();
		$el_team_buttons = array();
		foreach ( $el_team_front['buttons'] as $el_team_button ) {
			if ( $el_team_button['page'] && 'publish' === get_post_status( $el_team_button['page'] ) ) {
				$el_team_buttons[] = $el_team_button;
			}
		}
		?>
		<section class="front-section front-hero<?php echo has_post_thumbnail() ? '' : ' front-hero--ohne-bild'; ?>" aria-labelledby="front-hero-title">
			<div class="front-hero__text">
				<h1 id="front-hero-title" class="front-hero__title"><?php echo esc_html( $el_team_front['hero_title'] ); ?></h1>
				<div class="front-hero__content">
					<?php the_content(); ?>
				</div>
				<?php if ( $el_team_buttons ) : ?>
					<div class="front-buttons">
						<?php foreach ( $el_team_buttons as $el_team_i => $el_team_button ) : ?>
							<a class="front-btn <?php echo 0 === $el_team_i ? 'front-btn--primary' : 'front-btn--secondary'; ?>" href="<?php echo esc_url( get_permalink( $el_team_button['page'] ) ); ?>">
								<?php echo esc_html( '' !== $el_team_button['label'] ? $el_team_button['label'] : get_the_title( $el_team_button['page'] ) ); ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="front-hero__bild">
					<?php the_post_thumbnail( 'large', array( 'class' => 'front-hero__img', 'loading' => 'eager' ) ); ?>
				</div>
			<?php endif; ?>
		</section>
		<?php
	endwhile;

	// Nächste Termine (Plugin "El-Team Termine")
	$el_team_termine = el_team_front_termine();
	if ( $el_team_termine ) :
		?>
		<section class="front-section front-termine" aria-labelledby="front-termine-title">
			<div class="front-section__head">
				<h2 id="front-termine-title"><?php echo esc_html( $el_team_front['termine_title'] ); ?></h2>
				<a class="front-section__more" href="<?php echo esc_url( get_post_type_archive_link( 'termin' ) ); ?>"><?php esc_html_e( 'Alle Termine →', 'el-team-wp-theme' ); ?></a>
			</div>
			<?php echo el_team_termine_liste_html( $el_team_termine ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped im Plugin. ?>
		</section>
		<?php
	endif;

	// Kacheln zu ausgewählten Seiten
	if ( el_team_front_tiles() ) :
		?>
		<section class="front-section" aria-labelledby="front-tiles-title">
			<div class="front-section__head">
				<h2 id="front-tiles-title"><?php echo esc_html( $el_team_front['tiles_title'] ); ?></h2>
			</div>
			<div class="front-tiles">
				<?php get_template_part( 'template-parts/front/kacheln' ); ?>
			</div>
		</section>
		<?php
	endif;

	$el_team_news      = el_team_front_news_posts();
	$el_team_press     = el_team_front_press_posts( $el_team_news );
	$el_team_posts_url = el_team_front_posts_url();
	$el_team_press_url = $el_team_press ? el_team_front_press_url() : '';
	if ( $el_team_news || $el_team_press ) :
		?>
		<div class="front-cols<?php echo ( $el_team_news && $el_team_press ) ? '' : ' front-cols--eine'; ?>">
			<?php if ( $el_team_news ) : ?>
				<section class="front-section" aria-labelledby="front-news-title">
					<div class="front-section__head">
						<h2 id="front-news-title"><?php echo esc_html( $el_team_front['news_title'] ); ?></h2>
						<?php if ( $el_team_posts_url ) : ?>
							<a class="front-section__more" href="<?php echo esc_url( $el_team_posts_url ); ?>"><?php esc_html_e( 'Alle Beiträge →', 'el-team-wp-theme' ); ?></a>
						<?php endif; ?>
					</div>
					<div class="front-cards">
						<?php
						foreach ( $el_team_news as $post ) :
							setup_postdata( $post );
							// Kategorie für die Zeile über dem Titel: die erste, die nicht Presse ist
							$el_team_categories = array_values( array_filter( get_the_category(), function ( $category ) {
								return ! in_array( (int) $category->term_id, el_team_front_press_cat_ids(), true );
							} ) );
							?>
							<a class="front-card" href="<?php the_permalink(); ?>">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'medium_large', array( 'class' => 'front-card__img', 'alt' => '' ) ); ?>
								<?php else : ?>
									<span class="front-card__img front-card__img--ohne-bild" aria-hidden="true">
										<?php
										$el_team_logo_id = get_theme_mod( 'custom_logo' );
										if ( $el_team_logo_id ) {
											echo wp_get_attachment_image( $el_team_logo_id, 'medium', false, array( 'alt' => '' ) );
										}
										?>
									</span>
								<?php endif; ?>
								<span class="front-card__body">
									<span class="front-card__meta">
										<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time><?php echo $el_team_categories ? ' · ' . esc_html( $el_team_categories[0]->name ) : ''; ?>
									</span>
									<strong class="front-card__title"><?php the_title(); ?></strong>
									<span class="front-card__text"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 16 ) ); ?></span>
								</span>
							</a>
						<?php endforeach; ?>
						<?php wp_reset_postdata(); ?>
					</div>
				</section>
			<?php endif; ?>

			<?php if ( $el_team_press ) : ?>
				<section class="front-section" aria-labelledby="front-press-title">
					<div class="front-section__head">
						<h2 id="front-press-title"><?php echo esc_html( $el_team_front['press_title'] ); ?></h2>
						<?php if ( $el_team_press_url ) : ?>
							<a class="front-section__more" href="<?php echo esc_url( $el_team_press_url ); ?>"><?php esc_html_e( 'Alle →', 'el-team-wp-theme' ); ?></a>
						<?php endif; ?>
					</div>
					<ul class="front-press">
						<?php
						foreach ( $el_team_press as $el_team_press_post ) :
							list( $el_team_prefix, $el_team_press_title ) = el_team_split_title_prefix( $el_team_press_post->post_title );
							?>
							<li class="front-press__item">
								<?php
								// Ohne Zeitungskürzel: eigenes Logo, sonst ein leeres Feld, damit die Titel bündig bleiben
								$el_team_logo = $el_team_prefix ? el_team_presselogo_img( $el_team_prefix ) : el_team_own_presselogo_img();
								echo $el_team_logo ? $el_team_logo : '<span class="presselogo presselogo--leer" aria-hidden="true"></span>'; // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in der Funktion.
								?>
								<span>
									<a href="<?php echo esc_url( get_permalink( $el_team_press_post ) ); ?>"><?php echo esc_html( wptexturize( $el_team_press_title ) ); ?></a>
									<time datetime="<?php echo esc_attr( get_the_date( 'c', $el_team_press_post ) ); ?>"><?php echo esc_html( get_the_date( 'd.m.Y', $el_team_press_post ) ); ?></time>
								</span>
							</li>
						<?php endforeach; ?>
					</ul>
				</section>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</main>

<?php
get_footer();
