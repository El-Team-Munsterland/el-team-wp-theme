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
	<a class="skip-link screen-reader-text" href="#site-content"><?php esc_html_e( 'Zum Inhalt springen', 'el-team-wp-theme' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			if ( function_exists( 'the_custom_logo' ) ) {
				the_custom_logo();
			}
			?>
			<div class="site-header-content">
				<div class="site-title-wrapper">
					<?php
					// Nur auf der Blog-Startseite ist der Seitenname die Hauptüberschrift; sonst hat jede Seite ihr eigenes h1.
					$el_team_title_tag = ( is_front_page() && is_home() ) ? 'h1' : 'p';
					?>
					<<?php echo $el_team_title_tag; ?> class="site-title">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
							<?php bloginfo( 'name' ); ?>
						</a>
					</<?php echo $el_team_title_tag; ?>>
					<p class="site-description">
						<?php bloginfo( 'description' ); ?>
					</p>
				</div>

				<div class="site-navigation-top">
					<?php
					get_template_part( 'template-parts/header/navigation' );
					?>
				</div>
			</div>
		</div>

		<div class="site-header-bottom">
			<div class="site-search">
				<?php get_search_form(); ?>
			</div>
		</div>
	</header>
