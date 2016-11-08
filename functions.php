<?php

/**
 * Sets up theme defaults and registers
 * support for various WordPress features.
 *
 * @since 1.0.0
 */
function wpc_online_theme_setup() {

	// Make theme available for translation
	load_theme_textdomain( 'wpc-online', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages
	add_theme_support( 'post-thumbnails' );

	// @TODO define post thumbnail size
	//set_post_thumbnail_size( 1200, 9999 );

	// Register menu locations
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'wpc-online' ),
	));

	/*
	 * Switch default core markup for search form,
	 * comment form, and comments to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

}
add_action( 'after_setup_theme', 'wpc_online_theme_setup' );

/**
 * Load favicons.
 */
add_action( 'wp_head', 'wpc_online_add_favicons' );
add_action( 'admin_head', 'wpc_online_add_favicons' );
add_action( 'login_head', 'wpc_online_add_favicons' );
function wpc_online_add_favicons() {

	// Set the images folder
	$favicons_folder = get_stylesheet_directory_uri() . '/assets/images/favicons/';

	// Print the default icons
	?><link rel="shortcut icon" href="<?php echo $favicons_folder; ?>wpcampus-favicon-60.png"/>
	<link rel="apple-touch-icon" href="<?php echo $favicons_folder; ?>wpcampus-favicon-60.png"/><?php

	// Set the image sizes
	$image_sizes = array( 57, 72, 76, 114, 120, 144, 152 );

	foreach( $image_sizes as $size ) {
		?><link rel="apple-touch-icon" sizes="<?php echo "{$size}x{$size}"; ?>" href="<?php echo $favicons_folder; ?>wpcampus-favicon-<?php echo $size; ?>.png"/><?php
	}

}

/**
 * Enqueue front styles and scripts.
 */
function wpc_online_enqueue_styles_scripts() {

	// Register our fonts
	// @TODO make sure we remove what we're not using
	wp_register_style( 'wpc-online-fonts', 'https://fonts.googleapis.com/css?family=Libre+Franklin:400,500,600' );

	// Add our main stylesheet
	wp_enqueue_style( 'wpc-online', get_stylesheet_directory_uri() . '/assets/css/styles.css', array( 'wpc-online-fonts' ) );

	// Add our main script
	wp_enqueue_script( 'wpc-online', get_stylesheet_directory_uri() . '/assets/js/wpcampus-online.min.js', array( 'jquery' ), null, true );

	// Pass data
	wp_localize_script( 'wpc-online', 'wpc_online', array(
		'url'   => get_bloginfo( 'url' ),
		'title' => get_bloginfo( 'name' ),
	));

}
add_action( 'wp_enqueue_scripts', 'wpc_online_enqueue_styles_scripts' );

/**
 * Add our rewrite rules.
 */
function wpc_online_add_rewrite_rules() {
	add_rewrite_rule( '^(about|speakers|conduct|subscribe|contact)/?', 'index.php', 'top' );
}
add_action('init', 'wpc_online_add_rewrite_rules' );