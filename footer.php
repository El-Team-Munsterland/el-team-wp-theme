<?php
/**
 * Footer Template
 */

?>
	<footer id="colophon" class="site-footer">
		<div class="site-footer__inner">
			<?php
			// Die Startseite zeigt die neuesten Beiträge schon groß (front-page.php); dort entfällt die Liste im Footer.
			if ( ! ( is_front_page() && ! is_home() ) ) {
				get_template_part( 'template-parts/footer/latest-posts' );
			}
			?>

			<div class="site-footer__content">
				<?php
				if ( is_active_sidebar( 'footer-1' ) ) {
					dynamic_sidebar( 'footer-1' );
				}
				?>
			</div>

			<div class="site-footer__bottom">
				<p class="site-footer__copyright">
					&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'Alle Rechte vorbehalten.', 'el-team-wp-theme' ); ?>
					<?php
					// Impressum (Seite mit der Adresse /impressum/) und Datenschutzerklärung (Einstellungen → Datenschutz)
					$el_team_legal_links = array();
					$impressum_page      = get_page_by_path( 'impressum' );
					if ( $impressum_page ) {
						$el_team_legal_links[] = '<a href="' . esc_url( get_permalink( $impressum_page->ID ) ) . '" class="site-footer__copyright-link">' . esc_html__( 'Impressum', 'el-team-wp-theme' ) . '</a>';
					}
					$el_team_privacy_link = get_the_privacy_policy_link();
					if ( $el_team_privacy_link ) {
						$el_team_legal_links[] = $el_team_privacy_link;
					}
					echo implode( '<span class="site-footer__legal-sep" aria-hidden="true">·</span>', $el_team_legal_links ); // phpcs:ignore WordPress.Security.EscapeOutput -- oben escaped bzw. von WordPress erzeugt.
					?>
				</p>
			</div>
		</div>
	</footer>

	<?php wp_footer(); ?>
</body>
</html>
