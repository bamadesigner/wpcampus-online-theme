<?php

// Get the theme directory
$theme_dir = trailingslashit( get_stylesheet_directory_uri() );

// Get the blog URL
$blog_url = get_bloginfo( 'url' );

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<div id="wpc-online-wrapper">

		<div id="wpc-online-nav">
			<div class="wpc-online-tiles"></div>
			<div class="wpc-online-social">
				<span class="icon"><a href="https://twitter.com/wpcampusorg/"><img src="<?php echo $theme_dir; ?>assets/images/twitter-white.svg" alt="Follow WPCampus on Twitter" /></a></span>
				<span class="icon"><a href="https://www.facebook.com/wpcampus/"><img src="<?php echo $theme_dir; ?>assets/images/facebook-white.svg" alt="Follow WPCampus on Facebook" /></a></span>
				<span class="icon"><a href="https://www.youtube.com/wpcampusorg"><img src="<?php echo $theme_dir; ?>assets/images/youtube-white.svg" alt="Follow WPCampus on YouTube" /></a></span>
				<span class="hashtag">#WPCampus</span>
			</div>
			<div class="wpc-online-logo">
				<a href="<?php echo $blog_url; ?>"><img src="<?php echo $theme_dir; ?>assets/images/wpcampus-online-logo.svg" alt="WPCampus Online: Where WordPress Meets Higher Education" /></a>
			</div>
			<div class="wpc-online-menu">
				<ul>
					<li><a href="#about">About</a></li>
					<li class="highlight"><a href="#speakers">Call for Speakers</a></li>
					<li><a href="#wpcampus">What is WPCampus?</a></li>
					<li><a href="#conduct">Code of Conduct</a></li>
					<li><a href="#contact">Contact Us</a></li>
					<li><a href="#subscribe">Subscribe</a></li>
				</ul>
			</div>
			<div class="wpc-online-subscribe"></div>
		</div>
		<div id="wpc-online-main">