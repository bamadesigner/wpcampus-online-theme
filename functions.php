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

	// Don't print MailChimp signup on the application.
	if ( is_page( 'call-for-speakers/application' ) ) {
		remove_action( 'wpc_add_after_content', 'wpcampus_print_mailchimp_signup', 1000 );
	}

	// Disable network notifications on specific pages.
	/*if ( function_exists( 'wpcampus_network_disable' ) ) {

		if ( is_page( 'watch' ) ) {
			wpcampus_network_disable( 'notifications' );
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
	$version = 5;
	wp_enqueue_style( 'wpcampus-online', $wpcampus_dir_css . 'styles.min.css', array( 'wpcampus-parent' ), $version );
	wp_enqueue_script( 'wpcampus-online', $wpcampus_dir_js . 'wpc-online.min.js', array( 'jquery' ), $version );

	if ( is_page( 'watch' ) ) {

		$room = wpc_online_get_watch_room();

		wp_enqueue_script( 'wpcampus-online-watch', $wpcampus_dir_js . 'wpc-watch.min.js', array( 'jquery' ), $version );
		wp_localize_script( 'wpcampus-online-watch', 'wpc_online', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'room' => $room,
		));
	}
}
add_action( 'wp_enqueue_scripts', 'wpcampus_online_enqueue_theme', 10 );

/**
 * Add rewrite rules.
 */
function wpcampus_online_add_rewrite_rules() {

	// For watch pages.
	add_rewrite_rule( '^watch\/([1-3]{1})\/?', 'index.php?pagename=watch&room=$matches[1]', 'top' );

	// For session feedback.
	add_rewrite_rule( '^feedback\/confirmation\/?', 'index.php?pagename=feedback/confirmation', 'top');
	add_rewrite_rule( '^feedback\/([^\/]+)\/?', 'index.php?pagename=feedback&session=$matches[1]', 'top');

}
add_action( 'init', 'wpcampus_online_add_rewrite_rules' );

/**
 * Add rewrite tags.
 */
function wpcampus_online_add_rewrite_tags() {

	// Will hold watch room ID.
	add_rewrite_tag( '%room%', '([1-3]+)' );

}
add_action( 'init', 'wpcampus_online_add_rewrite_tags' );

/**
 * Filter the feedback URL.
 *
 * @access  public
 * @param   $feedback_url - string - the default feedback URL.
 * @param   $post - object - the post information.
 * @return  string - the filtered feedback URL.
 */
function wpc_online_filter_feedback_url( $feedback_url, $post ) {

	// Only for certain event types.
	if ( ! has_term( 'session', 'event_types', $post ) ) {
		return $feedback_url;
	}

	// Survey page is watch/{session post name}.
	$session_post_name = get_post_field( 'post_name', $post->ID );
	if ( ! empty( $session_post_name ) ) {
		return "/feedback/{$session_post_name}/";
	}

	return '';
}
add_filter( 'conf_sch_feedback_url', 'wpc_online_filter_feedback_url', 100, 2 );

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

function get_wpc_online_location_id( $room ) {
	switch ( $room ) {
		case 1:
			return 8;
		case 2:
			return 10;
		case 3:
			return 798;
	}
	return null;
}

/**
 * Filter the locations permalink.
 */
function wpcampus_online_filter_locations_link( $post_link, $post ) {

	if ( empty( $post->post_type ) || 'locations' != $post->post_type ) {
		return $post_link;
	}

	$blog_url = trailingslashit( get_bloginfo( 'url' ) );

	// Set permalink to watch rooms.
	if ( get_wpc_online_location_id( 1 ) == $post->ID ) {
		return $blog_url . 'watch/1/';
	} elseif ( get_wpc_online_location_id( 2 ) == $post->ID ) {
		return $blog_url . 'watch/2/';
	} elseif ( get_wpc_online_location_id( 3 ) == $post->ID ) {
		return $blog_url . 'watch/3/';
	}

	return $post_link;
}
add_filter( 'post_type_link', 'wpcampus_online_filter_locations_link', 100, 2 );

function wpc_online_get_watch_room() {
	$room = get_query_var( 'room' );
	if ( in_array( $room, array( 1, 2, 3 ) ) ) {
		return $room;
	}
	return null;
}

function wpc_online_has_started() {
	return new DateTime() >= new DateTime( '2019-01-31T08:30:00' );
}

function wpc_online_has_ended() {
	return new DateTime() >= new DateTime( '2019-01-31T16:30:00' );
}

function wpc_online_is_active() {
	return wpc_online_has_started() && ! wpc_online_has_ended();
}

function wpc_online_get_watch_area() {
	ob_start();

	// Get room.
	$room = ! empty( $_GET['room'] ) ? (int) $_GET['room'] : 1;
	if ( ! is_numeric( $room ) || ! in_array( $room, array( 1, 2, 3 ) ) ) {
		$room = 1;
	}

	//$offsetMinutes = ! empty( $_GET['offset'] ) ? (int) $_GET['offset'] : 0;

	$locationID = get_wpc_online_location_id( $room );

	$args = array(
		'date'           => '2019-01-31',
		'event_location' => $locationID,
		'bust_cache'     => true,
	);

	$scheduleItem = conference_schedule()->get_current_schedule_item( $args );

	if ( empty( $scheduleItem ) ) {
		exit;
	}

	// Get the YouTube embed URL.
	$youtube_id = get_post_meta( $scheduleItem->id, 'yt_live_watch_id', true );
	$yt_embed_src = 'https://www.youtube.com/embed/' . $youtube_id;

	$domain = $_SERVER['HTTP_HOST'];
	$yt_chat_embed = 'https://www.youtube.com/live_chat';
	$yt_chat_embed = add_query_arg( array( 'v' => $youtube_id, 'embed_domain' => $domain ), $yt_chat_embed );

	$caption_embed = get_post_meta( $scheduleItem->id, 'live_caption_url', true );

	$sessionTitle = $scheduleItem->title->rendered;

	/*<div class="wpc-live-chat-message">
		<h3>About Chat</h3>
		<ul>
			<li>Begin any questions with ? so that it is easily identifiable.</li>
			<li>Questions will be addressed at the end of the session</li>
		</ul>
	</div>*/

	?>
	<div id="wpc-watch-room">
		<div class="wpc-live-header">
			<div class="wpc-live-headers">
				<h1><?php printf( __( 'Room %d', 'wpcampus-online' ), $room ); ?><span class="sep" aria-hidden="true">:</span></h1>
				<h2><?php echo $sessionTitle; ?></h2>
			</div>
			<button class="header-button refresh-button wpc-live-refresh-button" href="/watch"><span>Refresh the watch area</span></button>
			<a class="header-button join-button" href="/watch">Join another room</a>
		</div>
		<?php

		if ( ! empty( $scheduleItem->isNext ) ) :

			//$startDate = new DateTime( $scheduleItem->event_dt_gmt );

			/*if ( $offsetMinutes != 0 ) {

				if ( $offsetMinutes > 0 ) {
					$offsetMinutes = 0 - $offsetMinutes;
				} else {
					$offsetMinutes = abs( $offsetMinutes );
				}

				$startDate->modify( '+' . $offsetMinutes . ' minutes' );

			}*/

			?>
			<div class="wpc-live-next">
				<p class="next-message">WPCampus Online is taking a short break. The next session will begin soon!</p>
				<?php

				/*if ( 1 == $room ) {
						echo 'WPCampus Online is taking a short break. The next session will begin soon!';
					} else {
						echo 'There is no session in this room for this hour. This room continues at 1 p.m. CST. <a href="/watch/1">Join the session in Room 1</a>';
					}*/

				?>
			</div>
			<?php
		endif;
		?>
		<div id="wpc-watch-area">
			<div class="wpc-live-watch">
				<div class="wpc-live-video">
					<div class="wpc-live-yt">
						<iframe class="wpc-live-yt" title="<?php printf( __( 'Join YouTube stream for WPCampus Online Room %d', 'wpcampus-online' ), $room ); ?>" frameborder="0" marginheight="0" marginwidth="0" allowtransparency="true" src="<?php echo $yt_embed_src; ?>" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"></iframe>
					</div>
				</div>
				<div class="wpc-live-chat">
					<iframe class="wpc-live-chat" src="<?php echo $yt_chat_embed; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
			</div>
			<div class="wpc-live-captions">
				<iframe class="wpc-live-captions" src="<?php echo $caption_embed; ?>"></iframe>
			</div>
			<div class="wpc-live-captions-actions"><button class="wpc-live-captions-open" data-url="<?php echo $caption_embed; ?>" data-title="Captions for WPCampus Online Room <?php echo $room; ?>">Open captions in new window</button></div>
			<div class="wpc-live-captioning-sponsor">
				<p class="sponsor-label">Live captioning for this session is sponsored by:</p>
				<a href="https://pantheon.io/"><img class="sponsor-logo" alt="Pantheon" src="/wp-content/uploads/sites/6/2019/01/Pantheon-logo.png"></a>
			</div>
		</div>
		<?php

		if ( $scheduleItem->speakers ) :

			?>
			<div class="wpc-watch-container speakers">
				<h2>The Speaker<?php echo count( $scheduleItem->speakers ) > 1 ? 's' : null; ?></h2>
				<div class="conf-schedule-speakers">
					<?php

					foreach ( $scheduleItem->speakers as $speaker ) {

						?>
						<div class="conf-schedule-speaker">
							<h3 class="speaker-name"><?php echo $speaker->display_name; ?></h3>
							<?php

							if ( ! empty( $speaker->headshot ) ) :
								?>
								<img class="speaker-headshot" src="<?php echo $speaker->headshot; ?>" alt="Headshot of <?php echo $speaker->display_name; ?>">
								<?php
							endif;

							$speakerMeta = '';

							if ( ! empty( $speaker->company_position ) ) {
								$speakerMeta .= '<span class="speaker-position">' . $speaker->company_position . '</span>';
							}

							if ( ! empty( $speaker->company ) ) {

								$company = $speaker->company;

								if ( ! empty( $speaker->company_website ) ) {
									$company = '<a href="' . $speaker->company_website . '">' . $company . '</a>';
								}

								if ( $speakerMeta ) {
									$speakerMeta .= ', ';
								}

								$speakerMeta .= '<span class="speaker-company">' . $company . '</span>';

							}

							if ( ! empty( $speakerMeta ) ) :
								?>
								<div class="speaker-meta"><?php echo $speakerMeta; ?></div>
								<?php
							endif;

							if ( ! empty( $speaker->website ) ) {
								?>
								<div class="speaker-website"><a href="<?php echo $speaker->website; ?>"><?php echo $speaker->website; ?></a></div>
								<?php
							}

							$speakerSocial = '';

							if ( ! empty( $speaker->facebook ) ) {
								$speakerSocial .= '<li class="event-link event-social event-facebook"><a href="' . $speaker->facebook . '"><i class="conf-sch-icon conf-sch-icon-facebook-square"></i> <span class="icon-label">Facebook</span></a></li>';
							}

							if ( ! empty( $speaker->twitter ) ) {
								$twitter = preg_replace( '/[^a-z0-9\_]/i', '', $speaker->twitter );
								$speakerSocial .= '<li class="event-link event-social event-twitter"><a href="https://twitter.com/' . $twitter . '"><i class="conf-sch-icon conf-sch-icon-twitter"></i> <span class="icon-label">@' . $twitter . '</span></a></li>';
							}

							if ( ! empty( $speaker->linkedin ) ) {
								$speakerSocial .= '<li class="event-link event-social event-instagram"><a href="https://www.instagram.com/' . $speaker->instagram . '"><i class="conf-sch-icon conf-sch-icon-instagram"></i> <span class="icon-label">Instagram</span></a></li>';
							}

							if ( ! empty( $speakerSocial ) ) :
								?>
								<ul class="conf-sch-event-buttons"><?php echo $speakerSocial; ?></ul>
								<?php
							endif;

							if ( ! empty( $speaker->content->rendered ) ) :
								?>
								<div class="speaker-bio">
									<?php echo $speaker->content->rendered; ?>
								</div>
								<?php
							endif;

							?>
						</div>
						<?php
					}

				endif;

				?>
			</div>
		</div>
		<div class="wpc-live-loading"></div>
	</div>
	<?php

	echo json_encode( array(
		'session' => $scheduleItem,
		'html' => ob_get_clean(),
	));

	exit;
}
add_action( 'wp_ajax_wpc_online_get_watch_area', 'wpc_online_get_watch_area' );
add_action( 'wp_ajax_nopriv_wpc_online_get_watch_area', 'wpc_online_get_watch_area' );
