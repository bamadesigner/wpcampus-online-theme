(function( $ ) {
	'use strict';

	/*// Changes .svg to .png if doesn't support SVG (Fallback)
	if ( ! Modernizr.svg ) {

		$( 'img[src*="svg"]' ).attr( 'src', function() {
			return $( this ).attr( 'src' ).replace( '.svg', '.png' );
		});

	}*/

	/*// Get the banner and main menu
	var $banner = jQuery( '#wpcampus-banner' );
	var $main_menu = jQuery( '#wpcampus-main-menu' );

	// Add listener to all elements who have the class to toggle the main menu
	jQuery( '.toggle-main-menu' ).on( 'touchstart click', function( $event ) {

		// Stop stuff from happening
		$event.stopPropagation();
		$event.preventDefault();

		// If banner isn't open, open it
		if ( ! $banner.hasClass( 'open-menu' ) ) {

			$banner.addClass( 'open-menu' );
			$main_menu.slideDown( 400 );

		} else {

			$banner.removeClass( 'open-menu' );
			$main_menu.slideUp( 400 );

		}

	});*/

	$( document ).ready(function() {

		// Scroll to the section when the page opens
		var url_path = window.location.pathname;
		if ( url_path != '' ) {
			var new_url = wpc_online.url + url_path;
			wpc_online_scroll_to( url_path, new_url ); //, , new_title );
		}

		// When we click links...
		$( 'a' ).on( 'click', function( event ) {

			// Get the href for the scroll position
			var href = $(this).attr( 'href' );
			if ( ! href ) {
				return true;
			}

			// Make sure it starts with a /
			if ( href.indexOf('/') == 0 ) {
				event.preventDefault();

				// Define the new URL and title
				var new_url = wpc_online.url + href;
				var new_title = $(this).text() + ' - ' + wpc_online.title;

				// Scroll to this element
				wpc_online_scroll_to( href, new_url, new_title );

			}

		});

	});

	function wpc_online_scroll_to( term, url, title ) {

		// Strip slashes from the term
		term = term.replace( /\//g, '' );

		// Make sure we have a term
		if ( ! term.length ) {
			return false;
		}

		// Make sure we have an element
		var $href_element = $( '#' + term );
		if ( ! $href_element.length ) {
			return true;
		}

		// Change the URL and title
		if ( typeof history.pushState != 'undefined' ) {
			if ( url !== undefined ) {

				// Make sure we have a title
				if ( title === undefined ) {
					title = $(this).text() + ' - ' + wpc_online.title;
				}

				// Create the history object
				var obj = {
					title: title,
					url: url
				};
				history.pushState( obj, obj.title, obj.url );
				document.title = obj.title;

			}
		}

		// Scroll to the section
		$( 'html, body' ).animate({
			scrollTop: $href_element.offset().top
		}, 1000 );

	}

})( jQuery );