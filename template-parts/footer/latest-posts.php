<?php
/**
 * Footer: Logo und neueste Beiträge aus den unter Design → Footer gewählten Inhaltstypen.
 */

$el_team_footer_settings = el_team_footer_settings();
$el_team_footer_query    = el_team_footer_latest_posts();

if ( ! $el_team_footer_query || ! $el_team_footer_query->have_posts() ) {
	return;
}
?>
<div class="site-footer__latest">
	<div class="site-footer__brand">
		<?php if ( has_custom_logo() ) : ?>
			<div class="site-footer__logo"><?php the_custom_logo(); ?></div>
		<?php endif; ?>
		<p class="site-footer__site-name">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
		</p>
		<?php if ( get_bloginfo( 'description' ) ) : ?>
			<p class="site-footer__site-description"><?php bloginfo( 'description' ); ?></p>
		<?php endif; ?>
	</div>

	<div class="site-footer__posts">
		<?php if ( '' !== $el_team_footer_settings['title'] ) : ?>
			<h2 class="site-footer__posts-title"><?php echo esc_html( $el_team_footer_settings['title'] ); ?></h2>
		<?php endif; ?>

		<ul class="site-footer__posts-list">
			<?php
			while ( $el_team_footer_query->have_posts() ) :
				$el_team_footer_query->the_post();
				$el_team_post_type = get_post_type_object( get_post_type() );
				$el_team_words     = el_team_post_word_count();
				?>
				<li class="site-footer__post">
					<h3 class="site-footer__post-title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h3>
					<p class="site-footer__post-meta">
						<span class="site-footer__post-date">
							<svg class="site-footer__icon" viewBox="0 0 16 16" aria-hidden="true" focusable="false"><rect x="1.5" y="2.5" width="13" height="12" rx="1.5" fill="none" stroke="currentColor"/><path d="M1.5 6h13M5 1v3M11 1v3" stroke="currentColor"/></svg>
							<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
						</span>
						<?php if ( $el_team_post_type ) : ?>
							<span class="site-footer__post-type"><?php echo esc_html( $el_team_post_type->labels->singular_name ); ?></span>
						<?php endif; ?>
						<?php if ( $el_team_words > 0 ) : ?>
							<span class="site-footer__post-words">
								<svg class="site-footer__icon" viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="M3.5 1.5h6l3 3v10h-9z" fill="none" stroke="currentColor"/><path d="M5.5 7.5h5M5.5 10h5M5.5 12.5h3" stroke="currentColor"/></svg>
								<?php
								/* translators: %s: Anzahl der Wörter */
								echo esc_html( sprintf( _n( '%s Wort', '%s Wörter', $el_team_words, 'el-team-wp-theme' ), number_format_i18n( $el_team_words ) ) );
								?>
							</span>
						<?php endif; ?>
					</p>
				</li>
			<?php endwhile; ?>
		</ul>
	</div>
</div>
<?php
wp_reset_postdata();
