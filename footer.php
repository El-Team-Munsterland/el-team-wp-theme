<?php
/**
 * Footer Template
 */

?>
	<footer id="colophon" class="site-footer">
		<div class="site-footer__inner">
			<div class="site-footer__content">
				<?php
				if ( is_active_sidebar( 'footer-1' ) ) {
					dynamic_sidebar( 'footer-1' );
				}
				?>
			</div>

			<div class="site-footer__bottom">
				<p class="site-footer__copyright">
					&copy; <?php echo date( 'Y' );
					echo ' ';
					bloginfo( 'name' );
					esc_html_e( ' All rights reserved.', 'el-team-wp-theme' );?> 
					<?php
					$impressum_page = get_page_by_path( 'impressum' );
					if ( $impressum_page ) {
						echo '<a href="' . esc_url( get_permalink( $impressum_page->ID ) ) . '" class="site-footer__copyright-link">' . esc_html( 'Impressum' ) . '</a>';
					}
					?>. 
					<?php  ?>
				</p>
			</div>
		</div>
	</footer>

	<?php wp_footer(); ?>
</body>
</html>
