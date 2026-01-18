<?php
/**
 * Post Content Template
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

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
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'el-team-theme' ),
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
		$categories = get_the_category();
		if ( ! empty( $categories ) ) {
			echo '<span class="cat-links">' . esc_html__( 'Categories: ', 'el-team-theme' );
			echo wp_kses_post( implode( ', ', array_map( 'the_category', $categories ) ) );
			echo '</span>';
		}
		?>
	</footer>
</article>
