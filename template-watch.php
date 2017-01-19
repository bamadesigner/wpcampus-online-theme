<?php

// Template Name: Watch

global $post;

// Make sure the schedule knows to load.
conference_schedule()->load_schedule();

get_header();

// Get the crowdcast embed source.
$crowdcast_embed_src = get_post_meta( $post->ID, 'crowdcast_embed_src', true );

?>
<div id="wpc-online-content" style="padding-top:10px;">
	<div class="inside">
		<div class="panel gray"><strong>This conference is a free event.</strong> WPCampus Online will be using <a href="https://www.crowdcast.io/" target="_blank">crowdcast</a> to stream live, virtual sessions. To join the conference, you'll simply need to <a href="https://www.crowdcast.io/" target="_blank">setup an account with crowdcast</a>, our streaming service, and visit this website on Monday, January 23.</div>
		<div class="panel blue"><a href="http://docs.crowdcast.io/faq/what-are-the-compatible-devices" target="_blank">View crowdcast's list of compatible devices</a> to make sure your browser is able to view the event.</div>
	</div>
	<?php

	if ( ! empty( $crowdcast_embed_src ) ) :

		// Add crowdcast query args.
		$crowdcast_embed_src = add_query_arg( array( 'navlinks' => 'false', 'embed' => 'true' ), $crowdcast_embed_src );

		?>
		<div id="wpc-crowdcast">
			<iframe frameborder="0" marginheight="0" marginwidth="0" allowtransparency="true" src="<?php echo $crowdcast_embed_src; ?>"></iframe>
		</div>
		<?php

	endif;

	// Print the schedule.
	$schedule = do_shortcode( '[print_conference_schedule]' );
	if ( ! empty( $schedule ) ) :

		?>
		<div id="wpc-crowdcast-schedule">
			<h2><?php _e( "What's Up Next", 'wpc-online' ); ?></h2>
			<?php echo $schedule; ?>
		</div>
		<?php

	endif;

	wpc_online_print_coc();

	?>
</div>
<?php

get_footer();
