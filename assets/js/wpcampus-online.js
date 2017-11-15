(function( $ ) {
	'use strict';

	// Get the banner and main menu.
	var $nav_container = jQuery( '#wpc-online-nav' );
	var $main_menu = jQuery( '.wpc-online-menu' );
	var $nav_social = jQuery( '.wpc-online-social' );

	// Add listener to all elements who have the class to toggle the main menu
	jQuery( '.toggle-main-menu' ).on( 'touchstart click', function( $event ) {

		// Stop stuff from happening
		$event.stopPropagation();
		$event.preventDefault();

		// If banner isn't open, open it
		if ( ! $nav_container.hasClass( 'open-menu' ) ) {

			$nav_social.hide();
			$nav_container.addClass( 'open-menu' );
			$main_menu.slideDown( 400 );

		} else {

			$main_menu.slideUp( 400, function() {
				$nav_container.removeClass( 'open-menu' );
				$nav_social.fadeIn();
			});
		}
	});
})( jQuery );