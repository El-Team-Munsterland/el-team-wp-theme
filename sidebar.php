<?php
/**
 * Sidebar Template
 */

if ( el_team_has_subpages() ) {
	$subpages = el_team_get_subpages();
	?>
	<aside id="secondary" class="primary-sidebar">
		<div class="widget">
			<h3 class="widget-title"><?php esc_html_e( 'Unterseiten', 'el-team-wp-theme' ); ?></h3>
			<ul class="subpages-list">
				<?php foreach ( $subpages as $subpage ) : ?>
					<li class="subpage-item">
						<a href="<?php echo esc_url( get_permalink( $subpage->ID ) ); ?>" class="subpage-link">
							<?php echo esc_html( $subpage->post_title ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</aside>
	<?php
} elseif ( is_active_sidebar( 'primary' ) ) {
	?>
	<aside id="secondary" class="primary-sidebar">
		<?php dynamic_sidebar( 'primary' ); ?>
	</aside>
	<?php
}
