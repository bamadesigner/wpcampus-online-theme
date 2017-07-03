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

	// Register menu locations.
	register_nav_menus( array(
		'primary'   => __( 'Primary Menu', 'wpc-online' ),
		'footer'    => __( 'Footer Menu', 'wpc-online' ),
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
function wpc_online_add_favicons() {

	// Set the images folder
	$favicons_folder = get_stylesheet_directory_uri() . '/assets/images/favicons/';

	// Print the default icons
	?><link rel="shortcut icon" href="<?php echo $favicons_folder; ?>wpcampus-favicon-60.png"/>
	<link rel="apple-touch-icon" href="<?php echo $favicons_folder; ?>wpcampus-favicon-60.png"/><?php

	// Set the image sizes
	$image_sizes = array( 57, 72, 76, 114, 120, 144, 152 );

	foreach ( $image_sizes as $size ) :

		?>
		<link rel="apple-touch-icon" sizes="<?php echo "{$size}x{$size}"; ?>" href="<?php echo $favicons_folder; ?>wpcampus-favicon-<?php echo $size; ?>.png"/>
		<?php

	endforeach;

}
add_action( 'wp_head', 'wpc_online_add_favicons' );
add_action( 'admin_head', 'wpc_online_add_favicons' );
add_action( 'login_head', 'wpc_online_add_favicons' );

/**
 * Enqueue front styles and scripts.
 */
function wpc_online_enqueue_styles_scripts() {
	$wpcampus_version = '0.11';

	// Get the directory.
	$wpcampus_dir = trailingslashit( get_stylesheet_directory_uri() );

	/*
	 * Register our fonts.
	 *
	 * @TODO make sure we remove what we're not using.
	 */
	//wp_register_style( 'wpc-online-fonts', 'https://fonts.googleapis.com/css?family=Libre+Franklin:400,500,600' );

	// Add our main stylesheet.
	wp_enqueue_style( 'wpc-online', $wpcampus_dir . 'assets/css/styles.css', array(), $wpcampus_version );

	// Add our main script.
	wp_enqueue_script( 'wpc-online', $wpcampus_dir . 'assets/js/wpcampus-online.min.js', array( 'jquery' ), $wpcampus_version, true );

	// Pass data to our script.
	wp_localize_script( 'wpc-online', 'wpc_online', array(
		'url'   => get_bloginfo( 'url' ),
		'title' => get_bloginfo( 'name' ),
	));
}
add_action( 'wp_enqueue_scripts', 'wpc_online_enqueue_styles_scripts' );

/**
 * Filter the page title.
 */
function wpc_online_filter_page_title( $title ) {

	if ( is_404() ) {
		return 'Page Not Found';
	}

	// Modify page titles
	if ( is_singular( 'schedule' ) ) {
		return '<span class="wpc-title-with-action">' . __( 'Schedule', 'wpc-online' ) . '</span><a class="wpc-online-action" href="' . get_bloginfo( 'url' ) . '/schedule/">' . __( 'View the full schedule', 'wpc-online' ) . '</a>';
	} elseif ( is_page( 'watch/room-1' ) ) {
		return '<span class="wpc-title-with-action">' . $title . '</span><a class="wpc-online-action join-room-action" href="' . get_bloginfo( 'url' ) . '/watch/room-2/">' . __( 'Join Room Two', 'wpc-online' ) . '</a>';
	} elseif ( is_page( 'watch/room-2' ) ) {
		return '<span class="wpc-title-with-action">' . $title . '</span><a class="wpc-online-action join-room-action" href="' . get_bloginfo( 'url' ) . '/watch/room-1/">' . __( 'Join Room One', 'wpc-online' ) . '</a>';
	}

	return $title;
}
add_filter( 'wpcampus_page_title', 'wpc_online_filter_page_title' );

/**
 * Add the schedule event title before the content.
 */
function wpc_online_add_schedule_event_title( $content ) {

	// Add the schedule event title before the content.
	if ( is_singular( 'schedule' ) ) {
		return '<h2>' . get_the_title() . '</h2>' . $content;
	}

	return $content;
}
add_filter( 'the_content', 'wpc_online_add_schedule_event_title' );

/**
 * Get breadcrumbs.
 */
function wpc_online_get_breadcrumbs_html() {

	/*
	 * Build array of breadcrumbs.
	 *
	 * Start with home.
	 */
	$breadcrumbs = array(
		array(
			'url'   => get_bloginfo( 'url' ),
			'label' => __( 'Home', 'wpc-online' ),
		),
	);

	// Get post type.
	$post_type = get_query_var( 'post_type' );

	// Make sure its not an array.
	if ( is_array( $post_type ) ) {
		$post_type = reset( $post_type );
	}

	// Add archive(s).
	if ( is_archive() ) {

		// Add the archive breadcrumb.
		if ( is_post_type_archive() ) {

			// Get the info.
			$post_type_archive_link = get_post_type_archive_link( $post_type );
			$post_type_archive_title = post_type_archive_title( '', false );

			// Add the breadcrumb.
			if ( $post_type_archive_link && $post_type_archive_title ) {
				$breadcrumbs[] = array(
					'url'   => $post_type_archive_link,
					'label' => $post_type_archive_title,
				);
			}
		}
	} else {

		// Add links to archive.
		if ( is_singular() ) {

			// Get the information.
			$post_type_archive_link = get_post_type_archive_link( $post_type );
			$post_type_archive_title = post_type_archive_title( '', false );

			if ( $post_type_archive_link ) {
				$breadcrumbs[] = array( 'url' => $post_type_archive_link, 'label' => $post_type_archive_title );
			}
		}

		// Print info for the current post.
		if ( ( $post = get_queried_object() ) && is_a( $post, 'WP_Post' ) ) {

			// Get ancestors.
			$post_ancestors = isset( $post ) ? get_post_ancestors( $post->ID ) : array();

			// Add the ancestors.
			foreach ( $post_ancestors as $post_ancestor_id ) {

				// Add ancestor.
				$breadcrumbs[] = array(
					'ID'    => $post_ancestor_id,
					'url'   => get_permalink( $post_ancestor_id ),
					'label' => get_the_title( $post_ancestor_id ),
				);

			}

			// Add current page - if not home page.
			if ( isset( $post ) ) {
				$breadcrumbs['current'] = array(
					'ID'    => $post->ID,
					'url'   => get_permalink( $post ),
					'label' => get_the_title( $post->ID ),
				);
			}
		}
	}

	// Build breadcrumbs HTML.
	$breadcrumbs_html = null;

	foreach ( $breadcrumbs as $crumb_key => $crumb ) {

		// Make sure we have what we need.
		if ( empty( $crumb['label'] ) ) {
			continue;
		}

		// If no string crumb key, set as ancestor.
		if ( ! $crumb_key || is_numeric( $crumb_key ) ) {
			$crumb_key = 'ancestor';
		}

		// Setup classes.
		$crumb_classes = array( $crumb_key );

		// Add if current.
		if ( isset( $crumb['current'] ) && $crumb['current'] ) {
			$crumb_classes[] = 'current';
		}

		$breadcrumbs_html .= '<li role="menuitem"' . ( ! empty( $crumb_classes ) ? ' class="' . implode( ' ', $crumb_classes ) . '"' : null ) . '>';

		// Add URL and label.
		if ( ! empty( $crumb['url'] ) ) {
			$breadcrumbs_html .= '<a href="' . $crumb['url'] . '"' . ( ! empty( $crumb['title'] ) ? ' title="' . $crumb['title'] . '"' : null ) . '>' . $crumb['label'] . '</a>';
		} else {
			$breadcrumbs_html .= $crumb['label'];
		}

		$breadcrumbs_html .= '</li>';

	}

	// Wrap them in nav.
	$breadcrumbs_html = '<div class="breadcrumbs-wrapper"><nav class="breadcrumbs" role="menubar" aria-label="breadcrumbs">' . $breadcrumbs_html . '</nav></div>';

	//  We change up the variable so it doesn't interfere with global variable.
	return $breadcrumbs_html;
}

// Print the code of conduct message.
function wpc_online_print_coc() {

	?>
	<div id="wpc-online-coc">
		<h2>Code of Conduct</h2>
		<p>WPCampus seeks to provide a friendly, safe environment in which all participants can engage in productive dialogue, sharing, and learning with each other in an atmosphere of mutual respect. In order to promote such an environment, we require all participants to adhere to our <a href="https://wpcampus.org/code-of-conduct/">code of conduct</a>, which applies to all community interaction and events.</p>
	</div>
	<?php

}

// Filter the locations permalink.
function wpc_online_filter_post_type_link( $post_link, $post, $leavename, $sample ) {

	if ( 8 == $post->ID ) {
		return get_bloginfo( 'url' ) . '/watch/room-1/';
	} elseif ( 10 == $post->ID ) {
		return get_bloginfo( 'url' ) . '/watch/room-2/';
	}

	return $post_link;
}
add_filter( 'post_type_link', 'wpc_online_filter_post_type_link', 100, 4 );

// Filter the livestream URL
function wpc_online_filter_livestream_url( $livestream_url, $post ) {

	// Get location.
	if ( class_exists( 'Conference_Schedule_Event' ) ) {

		$event = new Conference_Schedule_Event( $post->ID );
		$event_location = $event->get_location();

		if ( ! empty( $event_location->permalink ) ) {
			return $event_location->permalink;
		}
	}

	return $livestream_url;
}
add_filter( 'conf_sch_livestream_url', 'wpc_online_filter_livestream_url', 100, 2 );

/**
 * Prints list of social media icons.
 *
 * @param   $color - string - color of icon, black is default.
 */
function wpc_online_print_social_media_icons( $color = 'black' ) {

	// Get the theme directory.
	$theme_dir = trailingslashit( get_template_directory_uri() );
	$images_dir = "{$theme_dir}assets/images/";

	// If color, prefix with dash.
	if ( $color ) {
		$color = "-{$color}";
	}

	?>
	<ul class="social-media-icons">
		<li class="icon slack"><a href="https://wpcampus.org/get-involved/"><img src="<?php echo $images_dir; ?>slack<?php echo $color; ?>.svg" alt="<?php printf( __( 'Join %1$s on %2$s', 'wpcampus' ), 'WPCampus', 'Slack' ); ?>" /></a></li>
		<li class="icon twitter"><a href="https://twitter.com/wpcampusorg"><img src="<?php echo $images_dir; ?>twitter<?php echo $color; ?>.svg" alt="<?php printf( __( 'Follow %1$s on %2$s', 'wpcampus' ), 'WPCampus', 'Twitter' ); ?>" /></a></li>
		<li class="icon facebook"><a href="https://www.facebook.com/wpcampus"><img src="<?php echo $images_dir; ?>facebook<?php echo $color; ?>.svg" alt="<?php printf( __( 'Follow %1$s on %2$s', 'wpcampus' ), 'WPCampus', 'Facebook' ); ?>" /></a></li>
		<li class="icon youtube"><a href="https://www.youtube.com/wpcampusorg"><img src="<?php echo $images_dir; ?>youtube<?php echo $color; ?>.svg" alt="<?php printf( __( 'Follow %1$s on %2$s', 'wpcampus' ), 'WPCampus', 'YouTube' ); ?>" /></a></li>
		<li class="icon github"><a href="https://github.com/wpcampus/"><img src="<?php echo $images_dir; ?>github<?php echo $color; ?>.svg" alt="<?php printf( __( 'Follow %1$s on %2$s', 'wpcampus' ), 'WPCampus', 'GitHub' ); ?>" /></a></li>
	</ul>
	<?php
}

/**
 * Decide which main callout to print.
 */
function wpcampus_online_print_main_callout() {
	wpcampus_online_print_2017_callout();
}

/**
 * Print the 2017 callout.
 */
function wpcampus_online_print_2017_callout() {

	?>
	<div class="panel gray" style="text-align:center;margin:20px 0 40px 0;padding-bottom:10px;">
		<h2>WPCampus 2017 Conference on July 14-15</h2>
		<p><a href="https://2017.wpcampus.org/" style="color:inherit;">WPCampus 2017</a> will take place July 14-15 on the campus of Canisius College in Buffalo, New York. <strong>Ticket sales have closed</strong> but, if you can't join us in person, all sessions will be live-streamed and made available online after the event. Gather with other WordPress users on your campus and create your own WPCampus experience!</p>
		<a class="button panel blue block" style="margin-bottom:0;font-weight:bold;font-size:110%;background:#770000;display:block;" href="https://2017.wpcampus.org/">Visit the WPCampus 2017 website</a>
	</div>
	<?php
}

/**
 * Print the education survey callout.
 */
function wpcampus_online_print_ed_survey_callout() {

	?>
	<div class="panel gray" style="text-align:center;margin:20px 0 40px 0;padding-bottom:10px;">
		<h2>The "WordPress in Education" Survey</h2>
		<p>After an overwhelming response to our 2016 survey, WPCampus is back this year to dig a little deeper on key topics that schools and campuses care about most when it comes to WordPress and website development. We’d love to include your feedback in our results this year. The larger the data set, the more we all benefit. <strong>The survey will close on June 23rd, 2017.</strong></p>
		<a class="button panel blue block" style="margin-bottom:0;font-weight:bold;font-size:110%;background:#770000;display:block;" href="https://2017.wpcampus.org/announcements/wordpress-in-education-survey/">Take the "WordPress in Education" survey</a>
	</div>
	<?php
}
