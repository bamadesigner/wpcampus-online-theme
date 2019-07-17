<?php

// Template Name: Watch

function wpc_online_print_watch_pre_message() {
	/*$pre_content = '<div class="wpc-watch-container">
		<div class="callout center"><strong>This conference is a free event.</strong><br>WPCampus Online uses <a href="https://www.crowdcast.io/" target="_blank" rel="noopener">crowdcast</a> to stream live, virtual sessions. <a href="http://docs.crowdcast.io/faq/what-are-the-compatible-devices">View crowdcast\'s list of compatible devices</a>. To join the conference, simply visit one of our two streaming rooms: <a href="/watch/1/">Room 1</a> and <a href="/watch/2/">Room 2</a>. If you want to chat about the event, <a href="https://wpcampus.org/get-involved/">join us in Slack</a>. If you want to interact on social media, use <a href="https://twitter.com/search?q=wpcampus">the #WPCampus hashtag</a>.</div>
	</div>';*/
	?>
	<div class="wpc-watch-container">
		<p><strong>WPCampus Online 2019 has come to an end.</strong> If you want to chat about the event, <a href="https://wpcampus.org/get-involved/">join us in Slack</a> in our #attendees-online channel. If you want to interact on social media, use <a href="https://twitter.com/search?q=wpcampus">the #WPCampus hashtag</a>.</p>
		<div class="callout light-royal-blue center"><strong><a href="/thank-you/">Thank you</a></strong> to our wonderful organizers, volunteers, speakers, and sponsors for their support.</div>
		<p>All sessions were recorded and will be uploaded as soon as possible. In the meantime, you can <a href="/schedule/">view slides on the schedule</a> and video recordings from previous WPCampus Online events.</p>
		<p><a href="http://wpcampus.org/videos/">Visit the main WPCampus videos page</a> to watch sessions from other events.</p>
	</div>
	<?php
}
//add_action( 'wpc_add_before_content', 'wpc_online_print_watch_pre_message' );

function wpc_online_enable_watch_videos() {
	if ( function_exists( 'wpcampus_network_enable' ) ) {
		wpcampus_network_enable( 'videos' );
	}
}
add_action( 'get_header', 'wpc_online_enable_watch_videos' );

/**
 * Prints watch videos page.
 */
function wpc_online_print_watch_videos_content( $content ) {
	if ( function_exists( 'wpcampus_print_watch_videos' ) ) {

		?>
		<h2>Previous WPCampus Online videos</h2>
		<?php

		wpcampus_print_watch_videos( 'wpc-videos', array(
			'playlist'     => 'wpcampus-online-2017,wpcampus-online-2018',
			'show_event'   => true,
			'show_filters' => false,
		));
	}
}
add_action( 'wpc_add_after_content', 'wpc_online_print_watch_videos_content' );

get_template_part( 'index' );
