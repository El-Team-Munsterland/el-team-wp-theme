<?php
/**
 * Search Results Template
 */

get_header();
?>

<main id="main" class="site-main">
	<header class="page-header">
		<h1 class="page-title">
			<?php
			printf(
				esc_html__( 'Search Results for: %s', 'el-team-wp-theme' ),
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

		// Posts navigation
		?>
		<nav class="posts-navigation">
			<div class="nav-previous">
				<?php next_posts_link( esc_html__( '&larr; Ältere Beiträge', 'el-team-wp-theme' ) ); ?>
			</div>
			<div class="nav-next">
				<?php previous_posts_link( esc_html__( 'Neuere Beiträge &rarr;', 'el-team-wp-theme' ) ); ?>
			</div>
		</nav>
		<?php
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
