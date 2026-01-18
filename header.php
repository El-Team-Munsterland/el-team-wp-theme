<?php
/**
 * Header Template
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			if ( function_exists( 'the_custom_logo' ) ) {
				the_custom_logo();
			}
			?>
			<div class="site-header-content">
				<div class="site-title-wrapper">
					<h1 class="site-title">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<?php bloginfo( 'name' ); ?>
						</a>
					</h1>
					<p class="site-description">
						<?php bloginfo( 'description' ); ?>
					</p>
				</div>

				<div class="site-header-bottom">
					<?php
					get_template_part( 'template-parts/header/navigation' );
					?>
					<div class="site-search">
						<?php get_search_form(); ?>
					</div>
				</div>
			</div>
		</div>
	</header>
