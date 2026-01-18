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
					&copy; <?php echo date( 'Y' ); ?> 
					<?php bloginfo( 'name' ); ?>. 
					<?php esc_html_e( 'All rights reserved.', 'el-team-theme' ); ?>
				</p>
			</div>
		</div>
	</footer>

	<?php wp_footer(); ?>
</body>
</html>
