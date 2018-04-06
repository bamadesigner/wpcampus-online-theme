<?php

/**
 * TODO:
 * - Add "turn the lights off" functionality.
 */

$includes_path = STYLESHEETPATH . '/inc/';
require_once $includes_path . 'theme-parts.php';

/**
 * Setup the theme:
 *
 * - Load the textdomain.
 * - Register the navigation menus.
 */
function wpcampus_online_setup_theme() {

	// Load the textdomain.
	load_theme_textdomain( 'wpcampus-online', get_stylesheet_directory() . '/languages' );

	// Register the nav menus.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'wpcampus-online' ),
	));

	/*
	 * Register actions for theme parts.
	 */
	if ( function_exists( 'wpcampus_print_code_of_conduct_message' ) ) {
		add_action( 'wpc_add_after_main', 'wpcampus_print_code_of_conduct_message' );
	}
}
add_action( 'after_setup_theme', 'wpcampus_online_setup_theme', 10 );

/**
 * Add theme components.
 *
 * Runs in "wp" action since this is first
 * hook available after WP object is setup
 * and we can use conditional tags.
 */
function wpcampus_online_setup_theme_parts() {

	// Disable network notifications on specific pages.
	/*if ( function_exists( 'wpcampus_disable_network_notifications' ) ) {

		if ( is_page( 'watch' ) ) {
			wpcampus_disable_network_notifications();
		}
	}*/
}
add_action( 'wp', 'wpcampus_online_setup_theme_parts', 10 );

/**
 * Make sure the Open Sans
 * font weights we need are added.
 *
 * They're loaded in the parent theme.
 */
function wpcampus_online_load_open_sans_weights( $weights ) {
	return array_merge( $weights, array( 300, 400, 600 ) );
}
add_filter( 'wpcampus_open_sans_font_weights', 'wpcampus_online_load_open_sans_weights' );

/**
 * Setup/enqueue styles and scripts for theme.
 */
function wpcampus_online_enqueue_theme() {

	// Set the directories.
	$wpcampus_dir     = trailingslashit( get_stylesheet_directory_uri() );
	$wpcampus_dir_css = $wpcampus_dir . 'assets/build/css/';
	$wpcampus_dir_js  = $wpcampus_dir . 'assets/build/js/';

	// Enqueue the base styles and script.
	wp_enqueue_style( 'wpcampus-online', $wpcampus_dir_css . 'styles.min.css', array( 'wpcampus-parent' ), null );
	wp_enqueue_script( 'wpcampus-online', $wpcampus_dir_js . 'wpc-online.min.js', array( 'jquery' ), null );

}
add_action( 'wp_enqueue_scripts', 'wpcampus_online_enqueue_theme', 10 );

/**
 * Add rewrite rules.
 */
function wpcampus_online_add_rewrite_rules() {

	// For watch pages.
	add_rewrite_rule( '^watch\/([1-2]{1})\/?', 'index.php?pagename=watch&room=$matches[1]', 'top' );

}
add_action( 'init', 'wpcampus_online_add_rewrite_rules' );

/**
 * Add rewrite tags.
 */
function wpcampus_online_add_rewrite_tags() {

	// Will hold watch room ID.
	add_rewrite_tag( '%room%', '([1-2]+)' );

}
add_action( 'init', 'wpcampus_online_add_rewrite_tags' );

/**
 * Filter the livestream URL.
 */
function wpcampus_online_filter_livestream_url( $livestream_url, $post ) {

	// Get the event's location ID.
	$location_id = get_post_meta( $post->ID, 'conf_sch_event_location', true );
	if ( $location_id > 0 ) {

		$location_post_type = get_post_type( $location_id );
		if ( 'locations' == $location_post_type ) {

			$event_permalink = get_permalink( $location_id );
			if ( ! empty( $event_permalink ) ) {
				return $event_permalink;
			}
		}
	}

	return '/schedule/';
}
add_filter( 'conf_sch_livestream_url', 'wpcampus_online_filter_livestream_url', 100, 2 );

/**
 * Filter the locations permalink.
 */
function wpcampus_online_filter_locations_link( $post_link, $post ) {

	if ( empty( $post->post_type ) || 'locations' != $post->post_type ) {
		return $post_link;
	}

	// Set permalink to watch rooms.
	if ( 8 == $post->ID ) {
		return '/watch/1/';
	} elseif ( 10 == $post->ID ) {
		return '/watch/2/';
	}

	return $post_link;
}
add_filter( 'post_type_link', 'wpcampus_online_filter_locations_link', 100, 2 );
