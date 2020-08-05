<?php

function wpc_online_print_header() {

	$theme_dir = trailingslashit( get_stylesheet_directory_uri() );

	?>
	<div class="wpc-container">
		<div class="wpc-logo"><a href="/"><img src="<?php echo $theme_dir; ?>assets/images/wpcampus-online-logo-inverse.svg" alt="<?php echo sprintf( esc_attr__( '%s Online', 'wpcampus-online' ), 'WPCampus' ); ?>" /></a></div>
		<div class="wpc-menu-container" role="navigation">
			<button class="wpc-toggle-menu" data-toggle="wpc-header" aria-label="<?php _e( 'Toggle menu', 'wpcampus-online' ); ?>">
				<div class="wpc-open-menu-label"><?php _e( 'Menu', 'wpcampus-online' ); ?></div>
				<div class="wpc-close-menu-label"><?php _e( 'Close', 'wpcampus-online' ); ?></div>
			</button>
			<?php

			// Print the header menu.
			wp_nav_menu( array(
				'theme_location'    => 'primary',
				'container'         => false,
				'menu_id'           => 'wpc-online-main-menu',
				'menu_class'        => 'wpc-menu',
			));
			
			if ( function_exists( 'wpcampus_print_social_media_icons' ) ) {
				wpcampus_print_social_media_icons();
			}

			?>
		</div>
	</div>
	<?php
}
add_action( 'wpc_add_to_header', 'wpc_online_print_header', 0 );

function wpc_online_print_subheader() {

	if ( is_page( 'watch' ) ) {

		$room = wpc_online_get_watch_room();
		if ( $room ) {
			return;
		}
	}

	?>
	<div id="wpc-subheader" role="complementary">
		<div class="wpc-container">
			<div class="wpc-container-item tagline">A free, virtual conference for accessibility and WordPress in Higher Education</div>
			<div class="wpc-container-item date"><strong>January 31, 2019</strong></div>
		</div>
	</div>
	<?php
}
add_action( 'wpc_add_after_header', 'wpc_online_print_subheader', 0 );

/**
 * Filter the nav menu item CSS.
 *
 * @param   $classes - array - The CSS classes that are applied to the menu item's `<li>` element.
 * @param   $item - WP_Post - The current menu item.
 * @return  array - the filtered classes array.

function wpcampus_online_filter_menu_css( $classes, $item ) {
	if ( is_page( 'speakers' ) && 'Schedule' == $item->title ) {
		$classes[] = 'current-menu-item';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'wpcampus_online_filter_menu_css', 100, 2 );*/

/**
 * Make sure we know the schedule archive link.
 */
function wpc_online_filter_post_type_archive_link( $link, $post_type ) {

	switch( $post_type ) {

		case 'schedule':
			return '/schedule/';
			break;
	}

	return $link;
}
add_filter( 'wpcampus_post_type_archive_link', 'wpc_online_filter_post_type_archive_link', 10, 2 );

/**
 * Filter the page title.
 */
function wpcampus_online_filter_page_title( $title ) {

	/*if ( is_page( 'watch' ) ) {

		// Are we in a particular room?
		$room = wpc_online_get_watch_room();

		if ( $room ) {
			$title = sprintf( __( 'Room %d', 'wpcampus-online' ), $room );
		}
	}*/

	/*if ( is_page( 'schedule' ) ) {
		return $title . ' <span class="button wpc-schedule-action" role="button">' . __( 'Go to current session', 'wpcampus-online' ) . '</span>';
	}

	// Modify page titles
	if ( is_singular( 'schedule' ) ) {
		return '<span class="wpc-title-with-action">' . __( 'Schedule', 'wpcampus-online' ) . '</span><a class="wpc-online-action" href="/schedule/">' . __( 'View the full schedule', 'wpcampus-online' ) . '</a>';
	} elseif ( is_post_type_archive( 'speakers' ) ) {
		return '<span class="wpc-title-with-action">' . __( 'Presenters', 'wpcampus-online' ) . '</span><a class="wpc-online-action" href="/schedule/">' . __( 'View the full schedule', 'wpcampus-online' ) . '</a>';
	} elseif ( is_page( 'watch/1' ) ) {
		return '<span class="wpc-title-with-action">' . $title . '</span><a class="wpc-online-action join-room-action" href="/watch/2/">' . __( 'Join Room Two', 'wpcampus-online' ) . '</a>';
	} elseif ( is_page( 'watch/2' ) ) {
		return '<span class="wpc-title-with-action">' . $title . '</span><a class="wpc-online-action join-room-action" href="/watch/1/">' . __( 'Join Room One', 'wpcampus-online' ) . '</a>';
	}*/

	return $title;
}
add_filter( 'wpcampus_page_title', 'wpcampus_online_filter_page_title' );

/**
 *
 */
function wpc_online_add_pre_message() {

	if ( is_page( array( 'watch'. 'sponsors', 'thank-you', 'archive' ) ) ) {
		return;
	}

	?>
	<div class="panel light-blue center">
		<p style="font-size:130%;margin: 0 0 0.5rem 0;"><strong>WPCampus Online 2019 has come to an end</strong>
		<p style="margin:0;"><a href="/thank-you/">Thank you</a> to our wonderful organizers, volunteers, speakers, and sponsors for their support. All sessions were recorded and will be uploaded as soon as possible. In the meantime, you can <a href="/schedule/">view slides on the schedule</a> and <a href="/watch/">video recordings</a> from previous WPCampus Online events.</p>
	</div>
	<?php
}
//add_action( 'wpcampus_before_article', 'wpc_online_add_pre_message' );

/**
 * Adds post-event messaging to schedule pages.
 *
 * Adds after title at priority 10.
 */
function wpcampus_online_add_schedule_post_message() {
	
	if ( is_page( 'schedule' ) || is_singular( 'schedule' ) ) :

		?>
		<div class="callout light-royal-blue"><strong>WPCampus Online 2018 has come to an end.</strong> All sessions were recorded and are being uploaded to the website. You can <a href="/schedule/">view them on the schedule</a> during the process. If you want to chat about the event, <a href="https://wpcampus.org/get-involved/">join us in Slack</a> in our #wpconline channel. If you want to interact on social media, use <a href="https://twitter.com/search?q=wpcampus">the #WPCampus hashtag</a>.</div>
		<?php

	endif;
}
//add_action( 'wpc_add_before_content', 'wpcampus_online_add_schedule_post_message', 20 );
