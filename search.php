<?php
/**
 * Search Results Template
 */

get_header();
?>

<main id="site-content" class="site-main site-main--list">
	<header class="page-header">
		<h1 class="page-title">
			<?php
			printf(
				/* translators: %s: Suchbegriff */
				esc_html__( 'Suchergebnisse für: %s', 'el-team-wp-theme' ),
				'<span>' . get_search_query() . '</span>'
			);
			?>
		</h1>
	</header>

	<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
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
					<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' ); ?>

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

				<div class="entry-content">
					<?php
					the_excerpt();
					?>
				</div>

				<footer class="entry-footer">
					<?php
					$categories = get_the_category();
					if ( ! empty( $categories ) ) {
						echo '<span class="cat-links">' . esc_html__( 'Kategorien: ', 'el-team-wp-theme' );
						
						$category_links = array();
						foreach ( $categories as $category ) {
							$category_links[] = sprintf(
								'<a href="%s" rel="category tag">%s</a>',
								esc_url( get_category_link( $category->term_id ) ),
								esc_html( $category->name )
							);
						}
						
						echo wp_kses_post( implode( ', ', $category_links ) );
						echo '</span>';
					}
					?>
				</footer>
			</article>
			<?php
		}

		the_posts_pagination(
			array(
				'mid_size'           => 1,
				'prev_text'          => esc_html__( '← Vorherige Treffer', 'el-team-wp-theme' ),
				'next_text'          => esc_html__( 'Weitere Treffer →', 'el-team-wp-theme' ),
				'screen_reader_text' => esc_html__( 'Seiten der Suchergebnisse', 'el-team-wp-theme' ),
				'aria_label'         => esc_html__( 'Suchergebnisse', 'el-team-wp-theme' ),
			)
		);
	} else {
		?>
		<p><?php esc_html_e( 'Es wurden keine Ergebnisse gefunden.', 'el-team-wp-theme' ); ?></p>
		<?php
		get_search_form();
	}
	?>
</main>

<?php
get_footer();
