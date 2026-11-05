<?php
/**
 * Main Template File
 *
 * Beitragsliste (Blog), Kategorie-, Schlagwort-, Autoren- und Datumsarchive.
 */

get_header();
?>

<main id="site-content" class="site-main">
	<?php
	if ( is_archive() ) {
		?>
		<header class="page-header">
			<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
			<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
		</header>
		<?php
	} elseif ( is_home() && ! is_front_page() ) {
		?>
		<header class="page-header">
			<h1 class="page-title"><?php single_post_title(); ?></h1>
		</header>
		<?php
	}

	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			get_template_part( 'template-parts/content/content' );
		}

		the_posts_pagination(
			array(
				'mid_size'           => 1,
				'prev_text'          => esc_html__( '← Neuere Beiträge', 'el-team-wp-theme' ),
				'next_text'          => esc_html__( 'Ältere Beiträge →', 'el-team-wp-theme' ),
				'screen_reader_text' => esc_html__( 'Seiten der Beitragsliste', 'el-team-wp-theme' ),
				'aria_label'         => esc_html__( 'Beitragsliste', 'el-team-wp-theme' ),
			)
		);
	} else {
		?>
		<p><?php esc_html_e( 'Hier gibt es noch keine Beiträge.', 'el-team-wp-theme' ); ?></p>
		<?php
	}
	?>
</main>

<?php
get_footer();
