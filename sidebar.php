<?php
/**
 * Sidebar Template
 */

if ( is_active_sidebar( 'primary' ) ) {
	?>
	<aside id="secondary" class="primary-sidebar">
		<?php dynamic_sidebar( 'primary' ); ?>
	</aside>
	<?php
}
