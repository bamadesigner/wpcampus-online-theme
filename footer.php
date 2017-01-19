<?php

// Get the theme directory.
$theme_dir = trailingslashit( get_stylesheet_directory_uri() );

			?>
			<div id="wpc-online-subscribe">
				<div class="inside">
					<h2>Subscribe to the mailing list</h2>
					<?php echo do_shortcode( '[gravityform id="2" title="false" description="false"]' ); ?>
				</div>
			</div>
			<div id="wpc-online-footer">
				<a class="wpc-logo" href="https://wpcampus.org/"><img src="<?php echo $theme_dir; ?>assets/images/wpcampus-logo-tagline.svg" alt="<?php printf( __( '%s: Where WordPress Meets Higher Education', 'wpcampus' ), 'WPCampus' ); ?>" /></a>
				<ul class="wpc-footer-menu" role="navigation">
					<li><a href="https://wpcampus.org/code-of-conduct/">Code of Conduct</a></li>
					<li><a href="https://wpcampus.org/contact/">Contact Us</a></li>
				</ul>
				<p><strong>WPCampus is a <a href="https://wpcampus.org/" title="Learn more about the WPCampus community">community</a> for those using WordPress in the world of higher education.</strong><br />
					If you are not already a member of the WPCampus community, we hope you'll join us. <a href="https://wpcampus.org/get-involved/">Get involved</a>.<br />
					<span class="github-message">This site is powered by <a href="https://wordpress.org/">WordPress</a>. You can view, and contribute to, the theme on <a href="https://github.com/wpcampus/wpcampus-online-theme">GitHub</a>.</span></p>
				<p class="icons">
					<span class="icon twitter"><a href="https://twitter.com/wpcampusorg/"><img src="<?php echo $theme_dir; ?>assets/images/twitter-black.svg" alt="Follow WPCampus on Twitter" /></a></span>
					<span class="icon facebook"><a href="https://www.facebook.com/wpcampus/"><img src="<?php echo $theme_dir; ?>assets/images/facebook-black.svg" alt="Follow WPCampus on Facebook" /></a></span>
					<span class="icon youtube"><a href="https://www.youtube.com/wpcampusorg"><img src="<?php echo $theme_dir; ?>assets/images/youtube-black.svg" alt="Follow WPCampus on YouTube" /></a></span>
				</p>
			</div> <!-- #wpc-online-footer -->

			</div><!-- #wpc-online-main -->
		</div><!-- #wpc-online-wrapper -->
		<?php

		wp_footer();

		?>
	</body>
</html>
