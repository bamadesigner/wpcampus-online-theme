<?php

// Template Name: Watch Live

// Make sure the schedule knows to load.
conference_schedule()->load_schedule();

function wpc_online_watch_stuff() {
	$room = wpc_online_get_watch_room();
	if ( $room ) {
		remove_action( 'wpc_add_before_main', 'wpcampus_print_network_notifications' );
		remove_action( 'wpc_add_before_content', 'wpcampus_parent_print_page_title', 10 );
	}
}
add_action( 'wp_head', 'wpc_online_watch_stuff' );

/**
 * Filter the <body> class to add the watch room slug.
 */
function wpc_online_filter_watch_body_class( $class ) {

	// Are we in a particular room?
	$room = wpc_online_get_watch_room();
	if ( $room ) {
		$class[] = 'page-watch-room';
		$class[] = "page-watch-{$room}";
	} elseif ( is_page( 'watch' ) ) {
		$class[] = 'page-watch-main';
	}

	return $class;
}
add_action( 'body_class', 'wpc_online_filter_watch_body_class' );

function wpc_online_begin_watch_container() {
	echo '<div class="wpc-watch-container">';
}
add_action( 'wpc_add_before_page_title', 'wpc_online_begin_watch_container' );

function wpc_online_end_watch_container() {

	// Need to close .wpc-watch-container
	echo '</div>';

}
add_action( 'wpc_add_after_page_title', 'wpc_online_end_watch_container' );

// @TODO: update messaging
function wpc_online_print_watch_pre_message() {

	if ( wpc_online_is_active() ) {

		// Reminder for code of conduct
		// #attendees-online channel
		// How to ask questions, will be answered at the end of session
		// Page will auto update

	} else if ( wpc_online_has_ended() ) {

		/*?>
		<div class="wpc-watch-container">
			<p><strong>WPCampus Online 2019 has come to an end.</strong> If you want to chat about the event, <a href="https://wpcampus.org/get-involved/">join us in Slack</a> in our     - #attendees-online channel. If you want to interact on social media, use <a href="https://twitter.com/search?q=wpcampus">the #WPCampus hashtag</a>.</p>
			<div class="callout light-royal-blue center"><strong><a href="/thank-you/">Thank you</a></strong> to all of our wonderful volunteers, speakers, and attendees for their time and beautiful brains.</div>
		</div>
		<?php*/

	} else {
		//To attend the WPCampus Online conference, all you have to do is visit this page during event on Thursday, January 31, 2019.
		/*$pre_content = '<div class="wpc-watch-container">
			<div class="callout center"><strong>This conference is a free event.</strong><br>WPCampus Online uses <a href="https://www.crowdcast.io/" target="_blank" rel="noopener">crowdcast</a> to stream live, virtual sessions. <a href="http://docs.crowdcast.io/faq/what-are-the-compatible-devices">View crowdcast\'s list of compatible devices</a>. To join the conference, simply visit one of our two streaming rooms: <a href="/watch/1/">Room 1</a> and <a href="/watch/2/">Room 2</a>. If you want to chat about the event, <a href="https://wpcampus.org/get-involved/">join us in Slack</a>. If you want to interact on social media, use <a href="https://twitter.com/search?q=wpcampus">the #WPCampus hashtag</a>.</div>
		</div>';*/
	}
}
add_action( 'wpc_add_before_content', 'wpc_online_print_watch_pre_message' );

function wpc_online_get_sponsors() {
	return '<div class="wpc-watch-container sponsors">
		<h2>The Sponsors</h2>
		<div class="wpc-watch-sponsors">
			<div class="wpc-watch-sponsor pantheon">
				<p class="sponsor-label">Live captioning for today\'s sessions is sponsored by Pantheon.</p>
				<a href="https://pantheon.io/"><img class="sponsor-logo" alt="Pantheon" src="/wp-content/uploads/sites/6/2019/01/Pantheon-logo.png"></a>
			</div>
			<div class="wpc-watch-sponsor-row">
				<div class="wpc-watch-sponsor campuspress">
					<a href="https://campuspress.com/"><img class="sponsor-logo" alt="CampusPress" src="/wp-content/uploads/sites/6/2019/01/CampusPress-logo.png"></a>
				</div>
				<div class="wpc-watch-sponsor eridesign">
					<a href="https://www.eridesignstudio.com/higher-education/?utm_source=WPCampus"><img class="sponsor-logo" alt="Eri Design" src="/wp-content/uploads/sites/6/2019/01/ed_logo.png"></a>
				</div>
				<div class="wpc-watch-sponsor wpexplorer">
					<a href="https://www.wpexplorer.com/"><img class="sponsor-logo" alt="WPExplorer" src="/wp-content/uploads/sites/6/2019/01/wpe-logo.png"></a>
				</div>
			</div>
		</div>
	</div>';
}

/**
 * Prints content for watch page during event.
 */
function wpc_online_print_watch_live_content( $content ) {

	// Are we in a particular room?
	$room = wpc_online_get_watch_room();

	if ( $room ) {

		$content .= '<div id="wpc-watch-room">
			<div class="wpc-live-loading"></div>
		</div>';

		//$content .= '<div class="callout blue center"><a href="http://docs.crowdcast.io/faq/what-are-the-compatible-devices" target="_blank">View crowdcast\'s list of compatible devices</a> to make sure your browser is able to view the event.</div>';

	} else {

		$content .= '<div class="wpc-watch-buttons">
			<div class="wpc-watch-button">
				<a href="/watch/1/">
					<span class="watch-text">			
						<span class="watch-label">' . __( 'Join Room 1', 'wpcampus-online' ) . '</span>
						<span class="watch-title">General</span>
					</span>
				</a>
			</div>
		</div>';

		/*<div class="wpc-watch-button">
				<a href="/watch/2/">
					<span class="watch-text">
						<span class="watch-label">' . __( 'Join Room 2', 'wpcampus-online' ) . '</span>
						<span class="watch-title">General</span>
					</span>
				</a>
			</div>
			<div class="wpc-watch-button">
				<a href="/watch/3/">
					<span class="watch-text">
						<span class="watch-label">' . __( 'Join Room 3', 'wpcampus-online' ) . '</span>
						<span class="watch-title">Accessibility</span>
					</span>
				</a>
			</div>*/

		$content .= wpc_online_get_sponsors();

	}

	// Print the schedule.
	$schedule = do_shortcode( '[print_conference_schedule date="2019-01-31" event="194" header="h3"]' );
	if ( ! empty( $schedule ) ) {
		$content .= '<div class="wpc-watch-container schedule"><h2>The Schedule</h2>' . $schedule . '</div>';
	}

	if ( $room ) {

		$content .= wpc_online_get_sponsors();

	}

	return $content;
}
add_filter( 'the_content', 'wpc_online_print_watch_live_content' );

get_template_part( 'index' );
