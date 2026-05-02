<?php
/**
 * Template Name: Fahrzeuge
 * Template Description: Listet alle Fahrzeuge in einer Übersicht
 * Template Post Type: page
 */
get_header();
get_header();
?>
<div class="content-wrapper <?php echo el_team_has_subpages() ? 'has-sidebar' : ''; ?>">
	<main id="site-content" role="main" class="main-content">
		<header class="page-header">
			<h1 class="page-title"><?php the_title(); ?></h1>
		</header>

		<div class="page-content">
			<?php
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					the_content();
				}
			}
			?>
		</div>

		<?php
		// Aktive Fahrzeuge
		$aktive_query = new WP_Query( array(
			'post_type'      => 'fahrzeug',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
			'meta_query'     => array(
				array(
					'key'     => '_fahrzeug_status',
					'value'   => 'aktiv',
					'compare' => '=',
				),
			),
		) );

		if ( $aktive_query->have_posts() ) {
			?>
			<section class="fahrzeuge-aktiv">
				<h2><?php esc_html_e( 'Aktive Fahrzeuge', 'el-team-wp-theme' ); ?></h2>
				<?php
				while ( $aktive_query->have_posts() ) {
					$aktive_query->the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'fahrzeug-aktiv' ); ?>>
						<?php
						if ( has_post_thumbnail() ) {
							?>
							<div class="search-post-thumbnail">
								<a href="<?php echo esc_url( get_permalink() ); ?>">
									<?php the_post_thumbnail( 'medium' ); ?>
								</a>
							</div>
							<?php
						}
						?>

						<header class="entry-header">
							<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' ); ?>
						</header>

						<div class="entry-content">
							<?php
							the_excerpt();
							?>
						</div>

						<footer class="entry-footer">
							<a href="<?php the_permalink(); ?>" class="read-more">
								<?php esc_html_e( 'Zum Fahrzeug &rarr;', 'el-team-wp-theme' ); ?>
							</a>
						</footer>
					</article>
					<div class="wp-block-spacer" style="height: 20px;"></div>
					<?php
				}
				?>
			</section>
			<?php
		}

		wp_reset_postdata();

		// Inaktive Fahrzeuge
		$inaktive_query = new WP_Query( array(
			'post_type'      => 'fahrzeug',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
			'meta_query'     => array(
				array(
					'key'     => '_fahrzeug_status',
					'value'   => 'inaktiv',
					'compare' => '=',
				),
			),
		) );

		if ( $inaktive_query->have_posts() ) {
			?>
			<section class="fahrzeuge-archiv">
				<h2><?php esc_html_e( 'Archivierte Fahrzeuge', 'el-team-wp-theme' ); ?></h2>
				<?php
				while ( $inaktive_query->have_posts() ) {
					$inaktive_query->the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'fahrzeug-inaktiv' ); ?>>
						<?php
						if ( has_post_thumbnail() ) {
							?>
							<div class="search-post-thumbnail">
								<a href="<?php echo esc_url( get_permalink() ); ?>">
									<?php the_post_thumbnail( 'medium' ); ?>
								</a>
							</div>
							<?php
						}
						?>

						<header class="entry-header">
							<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' ); ?>
						</header>

						<div class="entry-content">
							<?php
							the_excerpt();
							?>
						</div>

						<footer class="entry-footer">
							<a href="<?php the_permalink(); ?>" class="read-more">
								<?php esc_html_e( 'Zum Fahrzeug &rarr;', 'el-team-wp-theme' ); ?>
							</a>
						</footer>
					</article>
					<div class="wp-block-spacer" style="height: 20px;"></div>
					<?php
				}
				?>
			</section>
			<?php
		}

		wp_reset_postdata();

		// Fallback für Fahrzeuge ohne Status
		$ohne_status_query = new WP_Query( array(
			'post_type'      => 'fahrzeug',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
			'meta_query'     => array(
				array(
					'key'     => '_fahrzeug_status',
					'compare' => 'NOT EXISTS',
				),
			),
		) );

		if ( $ohne_status_query->have_posts() ) {
			?>
			<section class="fahrzeuge-ohne-status">
				<h2><?php esc_html_e( 'Fahrzeuge ohne Status', 'el-team-wp-theme' ); ?></h2>
				<p><?php esc_html_e( 'Diese Fahrzeuge haben noch keinen Status zugewiesen bekommen.', 'el-team-wp-theme' ); ?></p>
				<?php
				while ( $ohne_status_query->have_posts() ) {
					$ohne_status_query->the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'fahrzeug-ohne-status' ); ?>>
						<?php
						if ( has_post_thumbnail() ) {
							?>
							<div class="search-post-thumbnail">
								<a href="<?php echo esc_url( get_permalink() ); ?>">
									<?php the_post_thumbnail( 'medium' ); ?>
								</a>
							</div>
							<?php
						}
						?>

						<header class="entry-header">
							<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' ); ?>
						</header>

						<div class="entry-content">
							<?php
							the_excerpt();
							?>
						</div>

						<footer class="entry-footer">
							<a href="<?php the_permalink(); ?>" class="read-more">
								<?php esc_html_e( 'Zum Fahrzeug &rarr;', 'el-team-wp-theme' ); ?>
							</a>
						</footer>
					</article>
					<div class="wp-block-spacer" style="height: 20px;"></div>
					<?php
				}
				?>
			</section>
			<?php
		}

		wp_reset_postdata();

		if ( ! $aktive_query->have_posts() && ! $inaktive_query->have_posts() && ! $ohne_status_query->have_posts() ) {
			?>
			<p><?php esc_html_e( 'Keine Fahrzeuge gefunden.', 'el-team-wp-theme' ); ?></p>
			<?php
		}
		?>
	</main>

	<?php if ( el_team_has_subpages() ) get_sidebar(); ?>
</div>

<?php get_footer(); get_footer();
