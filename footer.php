<?php

// Get the theme directory.
$theme_dir = trailingslashit( get_stylesheet_directory_uri() );

				?>
				<div id="wpc-online-subscribe">
					<div class="inside">
						<h2><?php printf( __( 'Subscribe to the %s mailing list', 'wpc-online' ), 'WPCampus' ); ?></h2>
						<?php echo do_shortcode( '[gravityform id="2" title="false" description="false"]' ); ?>
					</div>
				</div>
				<div id="wpc-online-footer">
					<a class="wpc-logo" href="https://wpcampus.org/"><img src="<?php echo $theme_dir; ?>assets/images/wpcampus-logo-tagline.svg" alt="<?php printf( __( '%s: Where WordPress Meets Higher Education', 'wpcampus' ), 'WPCampus' ); ?>" /></a>
					<?php

					// Print the footer menu.
					wp_nav_menu( array(
						'theme_location'    => 'footer',
						'container'         => false,
						'menu_id'           => 'wpc-footer-menu',
						'menu_class'        => 'wpc-footer-menu',
						'fallback_cb'       => false,
					));

					?>
					<p><strong>WPCampus is a community of networking, resources, and events for those using WordPress in the world of higher education.</strong><br />If you are not a member of the WPCampus community, we'd love for you to <a href="https://wpcampus.org/get-involved/">get involved</a>.</p>
					<p class="disclaimer">This site is powered by <a href="https://wordpress.org/">WordPress</a>. You can view, and contribute to, the theme on <a href="https://github.com/wpcampus/wpcampus-online-theme">GitHub</a>.<br />WPCampus events are not WordCamps and are not affiliated with the WordPress Foundation.</p>
					<?php wpc_online_print_social_media_icons(); ?>
					<p class="copyright">&copy; <?php echo date( 'Y' ); ?> WPCampus</p>
				</div> <!-- #wpc-online-footer -->
			</div><!-- #wpc-online-main -->
		</div><!-- #wpc-online-wrapper -->
		<?php wp_footer(); ?>
	</body>
</html>
