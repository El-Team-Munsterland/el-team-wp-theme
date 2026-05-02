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
 * Register custom post types for Fahrzeuge and Werkstattberichte
 */
function el_team_register_custom_post_types() {
    $fahrzeug_labels = array(
        'name'                  => esc_html_x( 'Fahrzeuge', 'Post Type General Name', 'el-team-wp-theme' ),
        'singular_name'         => esc_html_x( 'Fahrzeug', 'Post Type Singular Name', 'el-team-wp-theme' ),
        'menu_name'             => esc_html__( 'Fahrzeuge', 'el-team-wp-theme' ),
        'name_admin_bar'        => esc_html__( 'Fahrzeug', 'el-team-wp-theme' ),
        'add_new'               => esc_html__( 'Neues Fahrzeug', 'el-team-wp-theme' ),
        'add_new_item'          => esc_html__( 'Neues Fahrzeug hinzufügen', 'el-team-wp-theme' ),
        'new_item'              => esc_html__( 'Neues Fahrzeug', 'el-team-wp-theme' ),
        'edit_item'             => esc_html__( 'Fahrzeug bearbeiten', 'el-team-wp-theme' ),
        'view_item'             => esc_html__( 'Fahrzeug ansehen', 'el-team-wp-theme' ),
        'all_items'             => esc_html__( 'Alle Fahrzeuge', 'el-team-wp-theme' ),
        'search_items'          => esc_html__( 'Fahrzeuge durchsuchen', 'el-team-wp-theme' ),
        'not_found'             => esc_html__( 'Keine Fahrzeuge gefunden.', 'el-team-wp-theme' ),
        'not_found_in_trash'    => esc_html__( 'Keine Fahrzeuge im Papierkorb gefunden.', 'el-team-wp-theme' ),
    );

    $fahrzeug_args = array(
        'labels'             => $fahrzeug_labels,
        'public'             => true,
        'has_archive'        => false,
        'rewrite'            => array( 'slug' => 'fahrzeug' ),
        'show_in_rest'       => true,
        'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
        'menu_icon'          => 'dashicons-car',
    );
    register_post_type( 'fahrzeug', $fahrzeug_args );

    $werkstatt_labels = array(
        'name'                  => esc_html_x( 'Werkstattberichte', 'Post Type General Name', 'el-team-wp-theme' ),
        'singular_name'         => esc_html_x( 'Werkstattbericht', 'Post Type Singular Name', 'el-team-wp-theme' ),
        'menu_name'             => esc_html__( 'Werkstattberichte', 'el-team-wp-theme' ),
        'name_admin_bar'        => esc_html__( 'Werkstattbericht', 'el-team-wp-theme' ),
        'add_new'               => esc_html__( 'Neuen Bericht', 'el-team-wp-theme' ),
        'add_new_item'          => esc_html__( 'Neuen Werkstattbericht hinzufügen', 'el-team-wp-theme' ),
        'new_item'              => esc_html__( 'Neuer Werkstattbericht', 'el-team-wp-theme' ),
        'edit_item'             => esc_html__( 'Werkstattbericht bearbeiten', 'el-team-wp-theme' ),
        'view_item'             => esc_html__( 'Werkstattbericht ansehen', 'el-team-wp-theme' ),
        'all_items'             => esc_html__( 'Alle Werkstattberichte', 'el-team-wp-theme' ),
        'search_items'          => esc_html__( 'Werkstattberichte durchsuchen', 'el-team-wp-theme' ),
        'not_found'             => esc_html__( 'Keine Werkstattberichte gefunden.', 'el-team-wp-theme' ),
        'not_found_in_trash'    => esc_html__( 'Keine Werkstattberichte im Papierkorb gefunden.', 'el-team-wp-theme' ),
    );

    $werkstatt_args = array(
        'labels'             => $werkstatt_labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => array( 'slug' => 'werkstattberichte' ),
        'show_in_rest'       => true,
        'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'author', 'revisions' ),
        'menu_icon'          => 'dashicons-hammer',
    );
    register_post_type( 'werkstattbericht', $werkstatt_args );
}
add_action( 'init', 'el_team_register_custom_post_types' );

// Meta Box für Fahrzeug-Status als Dropdown
add_action( 'add_meta_boxes', 'el_team_add_fahrzeug_status_meta_box' );
add_action( 'save_post_fahrzeug', 'el_team_save_fahrzeug_status_meta_box' );

// Admin-Spalte für Fahrzeug-Status
add_filter( 'manage_fahrzeug_posts_columns', 'el_team_add_fahrzeug_status_column' );
add_action( 'manage_fahrzeug_posts_custom_column', 'el_team_fahrzeug_status_column_content', 10, 2 );

// Admin-Spalte für Werkstattbericht -> Fahrzeug Zuordnung
add_filter( 'manage_werkstattbericht_posts_columns', 'el_team_add_werkstattbericht_fahrzeug_column' );
add_action( 'manage_werkstattbericht_posts_custom_column', 'el_team_werkstattbericht_fahrzeug_column_content', 10, 2 );

// Admin Styles für Fahrzeug-Status
add_action( 'admin_head', 'el_team_add_admin_styles' );

/**
 * Register meta box for Werkstattbericht -> Fahrzeug Zuordnung
 */
function el_team_register_werkstattbericht_meta_box() {
    add_meta_box(
        'el_team_werkstatt_fahrzeug',
        esc_html__( 'Zugehöriges Fahrzeug', 'el-team-wp-theme' ),
        'el_team_render_werkstattbericht_meta_box',
        'werkstattbericht',
        'side',
        'default'
    );
}
add_action( 'add_meta_boxes', 'el_team_register_werkstattbericht_meta_box' );

/**
 * Render the Fahrzeug-Auswahl im Werkstattbericht-Editor
 */
function el_team_render_werkstattbericht_meta_box( $post ) {
    wp_nonce_field( 'el_team_werkstatt_fahrzeug_nonce', 'el_team_werkstatt_fahrzeug_nonce' );

    $selected_fahrzeug = get_post_meta( $post->ID, '_el_team_werkstatt_fahrzeug_id', true );
    $fahrzeuge = get_posts( array(
        'post_type'      => 'fahrzeug',
        'numberposts'    => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'post_status'    => 'publish',
    ) );
    ?>
    <p>
        <label for="el_team_werkstatt_fahrzeug_id"><?php esc_html_e( 'Wähle das zugehörige Fahrzeug:', 'el-team-wp-theme' ); ?></label>
    </p>
    <select name="el_team_werkstatt_fahrzeug_id" id="el_team_werkstatt_fahrzeug_id" style="width:100%;">
        <option value=""><?php esc_html_e( 'Kein Fahrzeug auswählen', 'el-team-wp-theme' ); ?></option>
        <?php foreach ( $fahrzeuge as $fahrzeug ) : ?>
            <option value="<?php echo esc_attr( $fahrzeug->ID ); ?>" <?php selected( $selected_fahrzeug, $fahrzeug->ID ); ?>>
                <?php echo esc_html( get_the_title( $fahrzeug ) ); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php
}

/**
 * Save the Fahrzeug-Zuordnung für Werkstattberichte
 */
function el_team_save_werkstattbericht_meta_box( $post_id ) {
    if ( ! isset( $_POST['el_team_werkstatt_fahrzeug_nonce'] ) ) {
        return;
    }

    if ( ! wp_verify_nonce( $_POST['el_team_werkstatt_fahrzeug_nonce'], 'el_team_werkstatt_fahrzeug_nonce' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( get_post_type( $post_id ) !== 'werkstattbericht' ) {
        return;
    }

    $fahrzeug_id = isset( $_POST['el_team_werkstatt_fahrzeug_id'] ) ? absint( $_POST['el_team_werkstatt_fahrzeug_id'] ) : 0;
    if ( $fahrzeug_id > 0 ) {
        update_post_meta( $post_id, '_el_team_werkstatt_fahrzeug_id', $fahrzeug_id );
    } else {
        delete_post_meta( $post_id, '_el_team_werkstatt_fahrzeug_id' );
    }
}
add_action( 'save_post_werkstattbericht', 'el_team_save_werkstattbericht_meta_box' );

/**
 * Meta Box für Fahrzeug-Status als Dropdown
 */
function el_team_add_fahrzeug_status_meta_box() {
    add_meta_box(
        'fahrzeug_status_meta_box',
        esc_html__( 'Fahrzeug-Status', 'el-team-wp-theme' ),
        'el_team_fahrzeug_status_meta_box_callback',
        'fahrzeug',
        'side',
        'default'
    );
}

/**
 * Callback für Fahrzeug-Status Meta Box
 */
function el_team_fahrzeug_status_meta_box_callback( $post ) {
    wp_nonce_field( 'fahrzeug_status_meta_box', 'fahrzeug_status_meta_box_nonce' );

    $status = get_post_meta( $post->ID, '_fahrzeug_status', true );
    // Standardwert für neue Fahrzeuge
    if ( empty( $status ) ) {
        $status = 'aktiv';
    }
    ?>
    <p>
        <label for="fahrzeug_status"><?php esc_html_e( 'Status:', 'el-team-wp-theme' ); ?></label>
    </p>
    <select name="fahrzeug_status" id="fahrzeug_status" style="width: 100%;">
        <option value="aktiv" <?php selected( $status, 'aktiv' ); ?>><?php esc_html_e( 'Aktiv', 'el-team-wp-theme' ); ?></option>
        <option value="inaktiv" <?php selected( $status, 'inaktiv' ); ?>><?php esc_html_e( 'Inaktiv', 'el-team-wp-theme' ); ?></option>
    </select>
    <p class="description">
        <?php esc_html_e( 'Aktiv: Fahrzeug ist noch im Besitz. Inaktiv: Fahrzeug ist nicht mehr vorhanden oder verschrottet.', 'el-team-wp-theme' ); ?>
    </p>
    <?php
}

/**
 * Speichere Fahrzeug-Status Meta Box
 */
function el_team_save_fahrzeug_status_meta_box( $post_id ) {
    if ( ! isset( $_POST['fahrzeug_status_meta_box_nonce'] ) ) {
        return;
    }

    if ( ! wp_verify_nonce( $_POST['fahrzeug_status_meta_box_nonce'], 'fahrzeug_status_meta_box' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['fahrzeug_status'] ) ) {
        $status = sanitize_text_field( $_POST['fahrzeug_status'] );
        update_post_meta( $post_id, '_fahrzeug_status', $status );
    }
}

/**
 * Füge Status-Spalte zur Fahrzeug-Admin-Übersicht hinzu
 */
function el_team_add_fahrzeug_status_column( $columns ) {
    $columns['fahrzeug_status'] = esc_html__( 'Status', 'el-team-wp-theme' );
    return $columns;
}

/**
 * Inhalt der Status-Spalte
 */
function el_team_fahrzeug_status_column_content( $column, $post_id ) {
    if ( 'fahrzeug_status' === $column ) {
        $status = get_post_meta( $post_id, '_fahrzeug_status', true );
        if ( empty( $status ) ) {
            $status = 'aktiv'; // Standardwert für bestehende Fahrzeuge ohne Status
        }

        $status_label = ( $status === 'aktiv' ) ? esc_html__( 'Aktiv', 'el-team-wp-theme' ) : esc_html__( 'Inaktiv', 'el-team-wp-theme' );
        $status_class = ( $status === 'aktiv' ) ? 'fahrzeug-status-aktiv' : 'fahrzeug-status-inaktiv';

        echo '<span class="' . esc_attr( $status_class ) . '">' . esc_html( $status_label ) . '</span>';
    }
}

/**
 * Admin Styles für Fahrzeug-Status hinzufügen
 */
function el_team_add_admin_styles() {
    global $post_type;
    if ( 'fahrzeug' === $post_type ) {
        ?>
        <style>
            .fahrzeug-status-aktiv {
                background-color: #d4edda;
                color: #155724;
                padding: 2px 6px;
                border-radius: 3px;
                font-weight: bold;
                display: inline-block;
            }
            .fahrzeug-status-inaktiv {
                background-color: #f8d7da;
                color: #721c24;
                padding: 2px 6px;
                border-radius: 3px;
                font-weight: bold;
                display: inline-block;
            }
        </style>
        <?php
    }
}

/**
 * Füge Fahrzeug-Spalte zur Werkstattbericht-Admin-Übersicht hinzu
 */
function el_team_add_werkstattbericht_fahrzeug_column( $columns ) {
    $columns['zugeordnetes_fahrzeug'] = esc_html__( 'Fahrzeug', 'el-team-wp-theme' );
    return $columns;
}

/**
 * Inhalt der Fahrzeug-Spalte für Werkstattberichte
 */
function el_team_werkstattbericht_fahrzeug_column_content( $column, $post_id ) {
    if ( 'zugeordnetes_fahrzeug' === $column ) {
        $fahrzeug_id = get_post_meta( $post_id, '_el_team_werkstatt_fahrzeug_id', true );

        if ( ! empty( $fahrzeug_id ) ) {
            $fahrzeug = get_post( $fahrzeug_id );
            if ( $fahrzeug ) {
                $fahrzeug_title = get_the_title( $fahrzeug );
                $edit_link = get_edit_post_link( $fahrzeug_id );
                echo '<a href="' . esc_url( $edit_link ) . '" title="' . esc_attr__( 'Fahrzeug bearbeiten', 'el-team-wp-theme' ) . '">' . esc_html( $fahrzeug_title ) . '</a>';
            } else {
                echo '<span style="color: #999;">' . esc_html__( 'Fahrzeug nicht gefunden', 'el-team-wp-theme' ) . '</span>';
            }
        } else {
            echo '<span style="color: #999;">' . esc_html__( 'Kein Fahrzeug zugeordnet', 'el-team-wp-theme' ) . '</span>';
        }
    }
}

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
