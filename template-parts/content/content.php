<?php
/**
 * Post Content Template
 *
 * Einzelansicht: Titel als h1. In Listen (Blog, Archive): Titel als verlinktes h2.
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		} else {
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		}
		?>

		<div class="entry-meta">
			<?php
			echo wp_kses_post(
				sprintf(
					'<time class="entry-date published updated" datetime="%1$s">%2$s</time>',
					esc_attr( get_the_date( 'c' ) ),
					esc_html( get_the_date() )
				)
			);
			?>
		</div>
	</header>

	<?php
	if ( has_post_thumbnail() ) {
		?>
		<div class="post-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>
		<?php
	}
	?>

	<div class="entry-content">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Titel des Beitrags, nur für Screenreader */
					__( 'Weiterlesen<span class="screen-reader-text"> „%s“</span>', 'el-team-wp-theme' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				esc_html( get_the_title() )
			)
		);
		?>
	</div>

	<footer class="entry-footer">
		<?php
		$categories = get_the_category_list( ', ' );
		if ( $categories ) {
			echo '<span class="cat-links">' . esc_html__( 'Kategorien: ', 'el-team-wp-theme' );
			echo wp_kses_post( $categories );
			echo '</span>';
		}
		?>
	</footer>
</article>
