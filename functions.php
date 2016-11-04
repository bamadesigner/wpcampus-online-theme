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
 * Enqueue front styles and scripts.
 */
function wpc_online_enqueue_styles_scripts() {

	// Add our main stylesheet
	wp_enqueue_style( 'wpc-online', get_stylesheet_directory_uri() . '/assets/css/styles.css' );

}
add_action( 'wp_enqueue_scripts', 'wpc_online_enqueue_styles_scripts' );