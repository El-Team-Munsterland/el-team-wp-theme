<?php
/**
 * Page Template
 *
 * Seiten ohne eigene Vorlage: Titel, Beitragsbild und Inhalt, ohne Datum und Kategorien.
 */

get_header();
?>

<main id="site-content" class="site-main">
	<?php
	while ( have_posts() ) {
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="post-thumbnail">
					<?php the_post_thumbnail(); ?>
				</div>
			<?php endif; ?>

			<div class="entry-content">
				<?php
				the_content();
				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Seiten:', 'el-team-wp-theme' ),
						'after'  => '</div>',
					)
				);
				?>
			</div>
		</article>
		<?php
	}
	?>
</main>

<?php
get_footer();
