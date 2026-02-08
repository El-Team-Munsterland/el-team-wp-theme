<?php
/**
 * Theme Setup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Setup theme
 */
function el_team_setup_theme() {
	// Add support for title tag
	add_theme_support( 'title-tag' );

	// Add support for RSS Feeds
	add_theme_support( 'automatic-feed-links' );

	// Add support for custom logo
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 100,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	// Add support for post thumbnails
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 825, 550, true );

	// Add support for responsive embeds
	add_theme_support( 'responsive-embeds' );

	// Add support for editor styles
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/custom.css' );
	add_editor_style( 'style.css' );

	// Add support for custom header
	add_theme_support( 'custom-header', array(
		'default-image'      => '',
		'default-text-color' => '000000',
		'height'             => 300,
		'width'              => 1200,
		'flex-height'        => true,
		'flex-width'         => true,
	) );

	// Add support for custom background
	add_theme_support( 'custom-background', array(
		'default-color'      => 'ffffff',
		'default-image'      => '',
		'default-repeat'     => 'repeat',
		'default-position-x' => 'left',
		'default-position-y' => 'top',
	) );

	// Register navigation menus
	register_nav_menus( array(
		'primary'   => esc_html__( 'Primary Menu', 'el-team-wp-theme' ),
		'secondary' => esc_html__( 'Secondary Menu', 'el-team-wp-theme' ),
	) );

	// Load textdomain for translations
	load_theme_textdomain( 'el-team-wp-theme', EL_TEAM_THEME_DIR . '/languages' );
}

/**
 * Register widget areas / sidebars
 */
function el_team_register_sidebars() {
	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'el-team-wp-theme' ),
		'id'            => 'primary',
		'description'   => esc_html__( 'Main sidebar', 'el-team-wp-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'el-team-wp-theme' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Footer widget area', 'el-team-wp-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'el_team_register_sidebars' );

/**
 * Register meta box for link recommendations
 */
function el_team_register_link_recommendations_meta_box() {
	global $post;
	
	// Only show meta box if the current page template is 'page-linkempfehlungen.php'
	if ( ! isset( $post ) || $post->post_type !== 'page' ) {
		return;
	}
	
	$page_template = get_post_meta( $post->ID, '_wp_page_template', true );
	if ( 'page-linkempfehlungen.php' !== $page_template ) {
		return;
	}
	
	add_meta_box(
		'el_team_link_recommendations',
		esc_html__( 'Linkempfehlungen', 'el-team-wp-theme' ),
		'el_team_render_link_recommendations_meta_box',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'el_team_register_link_recommendations_meta_box' );

/**
 * Render the link recommendations meta box
 */
function el_team_render_link_recommendations_meta_box( $post ) {
	wp_nonce_field( 'el_team_link_recommendations_nonce', 'el_team_link_recommendations_nonce' );
	
	$links = get_post_meta( $post->ID, '_el_team_links', true );
	if ( empty( $links ) ) {
		$links = array();
	}
	
	?>
	<div id="el-team-links-container">
		<?php foreach ( $links as $index => $link ) : 
			$link_title = isset( $link['title'] ) ? $link['title'] : '';
			$link_url = isset( $link['url'] ) ? $link['url'] : '';
			$link_description = isset( $link['description'] ) ? $link['description'] : '';
			$link_image_id = isset( $link['image_id'] ) ? $link['image_id'] : '';

			$link_order = isset( $link['link_order'] ) ? $link['link_order'] : 0;
		?>
			<div class="el-team-link-item" data-index="<?php echo esc_attr( $index ); ?>">
				<button type="button" class="button button-small el-team-remove-link" style="float:right; margin-bottom:10px;">
					<?php esc_html_e( 'Entfernen', 'el-team-wp-theme' ); ?>
				</button>
				<h4><?php esc_html_e( 'Link', 'el-team-wp-theme' ); ?> #<?php echo esc_html( $index + 1 ); ?></h4>
				
				<p>
					<label for="el_team_link_title_<?php echo esc_attr( $index ); ?>">
						<?php esc_html_e( 'Titel:', 'el-team-wp-theme' ); ?>
					</label><br>
					<input type="text" id="el_team_link_title_<?php echo esc_attr( $index ); ?>" 
						   name="el_team_links[<?php echo esc_attr( $index ); ?>][title]" 
						   value="<?php echo esc_attr( $link_title ); ?>" 
						   style="width:100%;" />
				</p>
				
				<p>
					<label for="el_team_link_url_<?php echo esc_attr( $index ); ?>">
						<?php esc_html_e( 'URL:', 'el-team-wp-theme' ); ?>
					</label><br>
					<input type="url" id="el_team_link_url_<?php echo esc_attr( $index ); ?>" 
						   name="el_team_links[<?php echo esc_attr( $index ); ?>][url]" 
						   value="<?php echo esc_attr( $link_url ); ?>" 
						   style="width:100%;" />
				</p>
				
				<p>
					<label for="el_team_link_description_<?php echo esc_attr( $index ); ?>">
						<?php esc_html_e( 'Beschreibung:', 'el-team-wp-theme' ); ?>
					</label><br>
					<textarea id="el_team_link_description_<?php echo esc_attr( $index ); ?>" 
							  name="el_team_links[<?php echo esc_attr( $index ); ?>][description]" 
							  rows="3" 
							  style="width:100%;"><?php echo esc_textarea( $link_description ); ?></textarea>
				</p>
				
				<p>
					<label for="el_team_link_order_<?php echo esc_attr( $index ); ?>">
						<?php esc_html_e( 'Reihenfolge:', 'el-team-wp-theme' ); ?>
					</label><br>
					<input type="number" id="el_team_link_order_<?php echo esc_attr( $index ); ?>" 
						   name="el_team_links[<?php echo esc_attr( $index ); ?>][link_order]" 
						   value="<?php echo esc_attr( $link_order ); ?>" 
						   min="0" 
						   style="width:100px;" />
					<span class="hint"><?php esc_html_e( '(kleinere Nummern zuerst)', 'el-team-wp-theme' ); ?></span>
				</p>
				
				<p>
					<label for="el_team_link_image_<?php echo esc_attr( $index ); ?>">
						<?php esc_html_e( 'Logo (optional):', 'el-team-wp-theme' ); ?>
					</label><br>
					<div class="el-team-image-upload">
						<input type="hidden" id="el_team_link_image_<?php echo esc_attr( $index ); ?>" 
							   name="el_team_links[<?php echo esc_attr( $index ); ?>][image_id]" 
							   value="<?php echo esc_attr( $link_image_id ); ?>" />
						<button type="button" class="button el-team-upload-image" data-index="<?php echo esc_attr( $index ); ?>">
							<?php esc_html_e( 'Logo auswählen', 'el-team-wp-theme' ); ?>
						</button>
						<div id="el_team_link_preview_<?php echo esc_attr( $index ); ?>" class="el-team-image-preview" style="margin-top:10px;">
							<?php 
							if ( ! empty( $link_image_id ) ) {
								echo wp_get_attachment_image( $link_image_id, array( 80, 80 ) );
							}
							?>
						</div>
					</div>
				</p>
				<hr>
			</div>
		<?php endforeach; ?>
	</div>
	
	<button type="button" id="el-team-add-link" class="button button-primary">
		<?php esc_html_e( '+ Neuer Link', 'el-team-wp-theme' ); ?>
	</button>
	
	<script>
	jQuery(document).ready(function($) {
		var nextIndex = <?php echo count( $links ); ?>;
		
		$('#el-team-add-link').on('click', function(e) {
			e.preventDefault();
			var html = `
				<div class="el-team-link-item" data-index="${nextIndex}">
					<button type="button" class="button button-small el-team-remove-link" style="float:right; margin-bottom:10px;">
						<?php esc_html_e( 'Entfernen', 'el-team-wp-theme' ); ?>
					</button>
					<h4><?php esc_html_e( 'Link', 'el-team-wp-theme' ); ?> #${nextIndex + 1}</h4>
					
					<p>
						<label for="el_team_link_title_${nextIndex}">
							<?php esc_html_e( 'Titel:', 'el-team-wp-theme' ); ?>
						</label><br>
						<input type="text" id="el_team_link_title_${nextIndex}" 
							   name="el_team_links[${nextIndex}][title]" 
							   style="width:100%;" />
					</p>
					
					<p>
						<label for="el_team_link_url_${nextIndex}">
							<?php esc_html_e( 'URL:', 'el-team-wp-theme' ); ?>
						</label><br>
						<input type="url" id="el_team_link_url_${nextIndex}" 
							   name="el_team_links[${nextIndex}][url]" 
							   style="width:100%;" />
					</p>
					
					<p>
						<label for="el_team_link_description_${nextIndex}">
							<?php esc_html_e( 'Beschreibung:', 'el-team-wp-theme' ); ?>
						</label><br>
						<textarea id="el_team_link_description_${nextIndex}" 
								  name="el_team_links[${nextIndex}][description]" 
								  rows="3" 
								  style="width:100%;"></textarea>
					</p>
					
					<p>
						<label for="el_team_link_order_${nextIndex}">
							<?php esc_html_e( 'Reihenfolge:', 'el-team-wp-theme' ); ?>
						</label><br>
						<input type="number" id="el_team_link_order_${nextIndex}" 
							 name="el_team_links[${nextIndex}][link_order]" 
							 value="0" 
							 min="0" 
							 style="width:100px;" />
						<span class="hint"><?php esc_html_e( '(kleinere Nummern zuerst)', 'el-team-wp-theme' ); ?></span>
					</p>
					
					<p>
						<label for="el_team_link_image_${nextIndex}">
							<?php esc_html_e( 'Logo (optional):', 'el-team-wp-theme' ); ?>
						</label><br>
						<div class="el-team-image-upload">
							<input type="hidden" id="el_team_link_image_${nextIndex}" 
								   name="el_team_links[${nextIndex}][image_id]" 
								   value="" />
							<button type="button" class="button el-team-upload-image" data-index="${nextIndex}">
								<?php esc_html_e( 'Logo auswählen', 'el-team-wp-theme' ); ?>
							</button>
							<div id="el_team_link_preview_${nextIndex}" class="el-team-image-preview" style="margin-top:10px;"></div>
						</div>
					</p>
					<hr>
				</div>
			`;
			$('#el-team-links-container').append(html);
			nextIndex++;
		});
		
		$(document).on('click', '.el-team-remove-link', function(e) {
			e.preventDefault();
			$(this).closest('.el-team-link-item').remove();
		});
		
		$(document).on('click', '.el-team-upload-image', function(e) {
			e.preventDefault();
			var index = $(this).data('index');
			var frame = wp.media({
				title: '<?php esc_html_e( 'Logo auswählen', 'el-team-wp-theme' ); ?>',
				button: { text: '<?php esc_html_e( 'Auswählen', 'el-team-wp-theme' ); ?>' },
				multiple: false
			});
			
			frame.on('select', function() {
				var attachment = frame.state().get('selection').first().toJSON();
				$('#el_team_link_image_' + index).val(attachment.id);
				$('#el_team_link_preview_' + index).html(
					'<img src="' + attachment.url + '" style="max-width:80px; height:auto;" />'
				);
			});
			
			frame.open();
		});
	});
	</script>
	<?php
}

/**
 * Save link recommendations meta box
 */
function el_team_save_link_recommendations( $post_id ) {
	if ( ! isset( $_POST['el_team_link_recommendations_nonce'] ) ) {
		return;
	}
	
	if ( ! wp_verify_nonce( $_POST['el_team_link_recommendations_nonce'], 'el_team_link_recommendations_nonce' ) ) {
		return;
	}
	
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	
	$links = isset( $_POST['el_team_links'] ) ? $_POST['el_team_links'] : array();
	
	// Sanitize the links
	$sanitized_links = array();
	foreach ( $links as $link ) {
			if ( ! empty( $link['title'] ) || ! empty( $link['url'] ) ) {
			$sanitized_links[] = array(
			'title'       => sanitize_text_field( isset( $link['title'] ) ? $link['title'] : '' ),
			'url'         => esc_url_raw( isset( $link['url'] ) ? $link['url'] : '' ),
			'description' => sanitize_textarea_field( isset( $link['description'] ) ? $link['description'] : '' ),
			'image_id'    => absint( isset( $link['image_id'] ) ? $link['image_id'] : 0 ),
			'link_order'  => absint( isset( $link['link_order'] ) ? $link['link_order'] : 0 ),
			);
		}
	}
	
	update_post_meta( $post_id, '_el_team_links', $sanitized_links );
}
add_action( 'save_post_page', 'el_team_save_link_recommendations' );
