<?php
/**
 * Enqueue scripts and styles
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue theme scripts and styles
 */
function el_team_enqueue_scripts() {
	// Enqueue main stylesheet
	wp_enqueue_style(
		'el-team-style',
		EL_TEAM_THEME_URI . '/style.css',
		array(),
		EL_TEAM_THEME_VERSION
	);

	// Enqueue custom stylesheet
	wp_enqueue_style(
		'el-team-custom',
		EL_TEAM_THEME_URI . '/assets/css/custom.css',
		array( 'el-team-style' ),
		EL_TEAM_THEME_VERSION
	);

	// Enqueue main script
	wp_enqueue_script(
		'el-team-script',
		EL_TEAM_THEME_URI . '/assets/js/main.js',
		array(),
		EL_TEAM_THEME_VERSION,
		true
	);

	// Enqueue comment reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'el_team_enqueue_scripts' );

/**
 * Enqueue admin scripts and styles
 */
function el_team_enqueue_admin_scripts( $hook ) {
	global $post;
	
	// Only load on page edit screens
	if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
		return;
	}
	
	// Check if this is a page
	if ( 'page' !== get_post_type( $post ) ) {
		return;
	}
	
	// Enqueue WordPress media uploader
	wp_enqueue_media();
	
	// Add admin styles for link recommendations
	wp_add_inline_style( 'wp-admin', '
		.el-team-link-item {
			background: #f9f9f9;
			border: 1px solid #e0e0e0;
			border-radius: 4px;
			padding: 15px;
			margin-bottom: 20px;
		}
		
		.el-team-link-item h4 {
			margin: 0 0 15px 0;
			color: #333;
		}
		
		.el-team-link-item p {
			margin: 10px 0;
		}
		
		.el-team-link-item label {
			font-weight: 500;
			color: #333;
		}
		
		.el-team-link-item input[type="text"],
		.el-team-link-item input[type="url"],
		.el-team-link-item textarea {
			padding: 8px;
			border: 1px solid #ddd;
			border-radius: 4px;
			font-family: inherit;
		}
		
		.el-team-image-preview {
			display: flex;
			gap: 10px;
			align-items: center;
		}
		
		.el-team-image-preview img {
			border-radius: 4px;
			border: 1px solid #ddd;
		}
		
		#el-team-add-link {
			margin-top: 20px;
		}
	' );
}
add_action( 'admin_enqueue_scripts', 'el_team_enqueue_admin_scripts' );
