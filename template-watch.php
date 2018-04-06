<?php

// Template Name: Watch

// Make sure the schedule knows to load.
//conference_schedule()->load_schedule();

/**
 * Filter the <body> class to add the watch room slug.
 */
function wpc_online_filter_watch_body_class( $class ) {

	// Are we in a particular room?
	$room = get_query_var( 'room' );
	if ( in_array( $room, array( 1, 2 ) ) ) {
		$class[] = 'page-watch-room';
		$class[] = "page-watch-{$room}";
	}

	return $class;
}
//add_action( 'body_class', 'wpc_online_filter_watch_body_class' );

function wpc_online_begin_watch_container() {
	echo '<div class="wpc-watch-container">';
}
//add_action( 'wpc_add_before_page_title', 'wpc_online_begin_watch_container' );

function wpc_online_end_watch_container() {

	// Are we in a particular room?
	/*$room = get_query_var( 'room' );
	if ( in_array( $room, array( 1, 2 ) ) ) {

		$other_room = ( 1 == $room ? 2 : 1 );
		echo '<a id="wpc-watch-other-room" class="button" href="/watch/' . $other_room . '/">' . sprintf( __( 'Join Room %d', 'wpcampus-online' ), $other_room ) . '</a>';

	}*/

	// Need to close .wpc-watch-container
	echo '</div>';

}
//add_action( 'wpc_add_after_page_title', 'wpc_online_end_watch_container' );

function wpc_online_print_watch_pre_message() {
	?>
	<div class="wpc-watch-container">
		<p><strong>WPCampus Online 2018 has come to an end.</strong> If you want to chat about the event, <a href="https://wpcampus.org/get-involved/">join us in Slack</a> in our #wpconline channel. If you want to interact on social media, use <a href="https://twitter.com/search?q=wpcampus">the #WPCampus hashtag</a>.</p>
		<div class="callout light-royal-blue center"><strong><a href="/thank-you/">Thank you</a></strong> to all of our wonderful volunteers, speakers, and attendees for their time and beautiful brains.</div>
	</div>
	<?php
}

/**
 * Prints content for watch page during event.
 */
function wpc_online_print_watch_live_content( $content ) {

	// Are we in a particular room?
	$room = get_query_var( 'room' );
	if ( ! in_array( $room, array( 1, 2 ) ) ) {
		$room = false;
	}

	/*$pre_content = '<div class="wpc-watch-container">
		<div class="callout center"><strong>This conference is a free event.</strong><br>WPCampus Online uses <a href="https://www.crowdcast.io/" target="_blank" rel="noopener">crowdcast</a> to stream live, virtual sessions. <a href="http://docs.crowdcast.io/faq/what-are-the-compatible-devices">View crowdcast\'s list of compatible devices</a>. To join the conference, simply visit one of our two streaming rooms: <a href="/watch/1/">Room 1</a> and <a href="/watch/2/">Room 2</a>. If you want to chat about the event, <a href="https://wpcampus.org/get-involved/">join us in Slack</a>. If you want to interact on social media, use <a href="https://twitter.com/search?q=wpcampus">the #WPCampus hashtag</a>.</div>
	</div>';*/

	$pre_content = wpc_online_get_watch_pre_message();

	$post_content = '';

	if ( $room ) {

		// Get the crowdcast embed source.
		$crowdcast_embed_src = 'https://www.crowdcast.io/e/wpcampus-online-2018-' . $room;

		// Add crowdcast query args.
		$crowdcast_embed_src = add_query_arg( array( 'navlinks' => 'false', 'embed' => 'true' ), $crowdcast_embed_src );

		$post_content .= '<div id="wpc-crowdcast">
			<iframe title="' . sprintf( __( 'Join crowdcast stream for WPCampus Online Room %d', 'wpcampus-online' ), $room ) . '" width="100%" height="800" frameborder="0" marginheight="0" marginwidth="0" allowtransparency="true" src="' . $crowdcast_embed_src . '" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
		</div>';

		$post_content .= '<div class="callout blue center"><a href="http://docs.crowdcast.io/faq/what-are-the-compatible-devices" target="_blank">View crowdcast\'s list of compatible devices</a> to make sure your browser is able to view the event.</div>';

	} else {

		$post_content .= '<div id="wpc-watch-buttons">
			<div class="wpc-watch-button"><a href="/watch/1/">
				<span class="watch-text">
					<span class="watch-title">Developing a Culture of Mentorship</span>
					<span class="watch-label">' . __( 'Join Room 1', 'wpcampus-online' ) . '</span>
				</span>
			</a></div>
			<div class="wpc-watch-button"><a href="/watch/2/">
				<span class="watch-text">
					<span class="watch-title">Which Way Does Your Duck Face</span>
					<span class="watch-label">' . __( 'Join Room 2', 'wpcampus-online' ) . '</span>
				</span>
			</a></div>
		</div>';

	}

	// Print the schedule.
	$schedule = do_shortcode( '[print_conference_schedule date="2018-01-30" event="104"]' );
	if ( ! empty( $schedule ) ) {
		$post_content .= '<div class="wpc-watch-container">
			<div id="wpc-crowdcast-schedule">
				<h2 id="wpc-next-header">' . __( "What's Up Next", 'wpcampus-online' ) . '</h2><a id="wpc-schedule-button" class="button light-gray" href="/schedule/">' . __( 'View full schedule', 'wpcampus-online' ) . '</a>' . $schedule .
			'</div>
		</div>';
	}

	return $pre_content . $content . $post_content;

}

function wpc_online_enable_watch_videos() {
	if ( function_exists( 'wpcampus_enable_watch_videos' ) ) {
		wpcampus_enable_watch_videos();
	}
}
add_action( 'get_header', 'wpc_online_enable_watch_videos' );

/**
 * Prints watch videos page.
 */
function wpc_online_print_watch_videos_content( $content ) {
	if ( function_exists( 'wpcampus_print_watch_videos' ) ) {
		wpcampus_print_watch_videos( array(
			'playlist'   => 'wpcampus-online-2017,wpcampus-online-2018',
			'show_event' => true,
		));
	}
}
add_action( 'wpc_add_after_content', 'wpc_online_print_watch_videos_content' );

get_template_part( 'index' );
