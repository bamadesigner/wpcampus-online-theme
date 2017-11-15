<?php

// Get the theme directory.
$theme_dir = trailingslashit( get_stylesheet_directory_uri() );

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="wpc-online-wrapper">

		<div id="wpc-online-banner">
			<div class="inside">
				<a class="wpc-online-logo" href="/"><img src="<?php echo $theme_dir; ?>assets/images/wpcampus-online-logo.svg" alt="WPCampus Online: Where WordPress Meets Higher Education" /></a>
				<div class="banner-text">
					<span class="date"><?php _e( 'Join us online Tuesday, January 30, 2018', 'wpcampus' ); ?></span>
					<span class="tagline"><?php printf( __( 'A Virtual Conference for %s in Higher Education', 'wpcampus' ), 'WordPress' ); ?></span>
				</div>
				<div style="clear:both;"></div>
			</div>
		</div>
		<div id="wpc-online-nav">
			<div class="inside">
				<div class="toggle-main-menu">
					<div class="toggle-icon">
						<div class="bar one"></div>
						<div class="bar two"></div>
						<div class="bar three"></div>
					</div>
					<div class="open-menu-label"><?php _e( 'Menu', 'wpcampus' ); ?></div>
					<div class="close-menu-label"><?php _e( 'Close', 'wpcampus' ); ?></div>
				</div>
				<?php

				// Print the main menu.
				wp_nav_menu( array(
					'theme_location'    => 'primary',
					'container_class'   => 'wpc-online-menu',
					'menu_id'           => false,
				));

				?>
				<div class="wpc-online-social">
					<span class="icon"><a href="https://twitter.com/wpcampusorg/"><img src="<?php echo $theme_dir; ?>assets/images/twitter-white.svg" alt="Follow WPCampus on Twitter" /></a></span>
					<span class="icon"><a href="https://www.facebook.com/wpcampus/"><img src="<?php echo $theme_dir; ?>assets/images/facebook-white.svg" alt="Follow WPCampus on Facebook" /></a></span>
					<span class="icon"><a href="https://www.youtube.com/wpcampusorg"><img src="<?php echo $theme_dir; ?>assets/images/youtube-white.svg" alt="Follow WPCampus on YouTube" /></a></span>
					<span class="hashtag">#WPCampus</span>
				</div>
			</div>
		</div>
		<?php

		// Include notifications.
		require( STYLESHEETPATH . '/partials/notifications.html' );

		if ( ! is_front_page() ) :

			// Get the breadcrumbs.
			$breadcrumbs = ''; //wpc_online_get_breadcrumbs_html();

			?>
			<div id="wpc-online-main-page-title"<?php echo $breadcrumbs ? ' class="has-breadcrumbs"' : ''; ?>>
				<div class="inside">
					<h1><?php echo apply_filters( 'wpcampus_page_title', get_the_title() ); ?></h1>
					<?php echo $breadcrumbs; ?>
				</div>
			</div>
			<?php

		endif;

		?>
		<div id="wpc-online-main">
			<div id="wpc-online-content">
				<div class="inside">
					<?php

					wpcampus_online_print_main_callout();
