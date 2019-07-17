(function( $ ) {
	'use strict';

	$(document).ready(function() {
		wpc_online_populate_watch_area();

		$('body').on('click','.wpc-live-refresh-button, .schedule-refresh',function(e){
			e.preventDefault();
			wpc_online_populate_watch_area();
		});

		$('#wpc-watch-room').on('click','.wpc-live-captions-open',function(e){
			e.preventDefault();
			var $button = $(this);
			var url = $button.data('url');
			if (!url) {
				return;
			}
			var title = $button.data('title');
			window.open(
				url,
				title
			);
		});
	});

	function wpc_online_populate_watch_area() {

		var $watchRoom = $('#wpc-watch-room').addClass('loading');
		if ( $watchRoom.length ) {

			const getWatchArea = get_wpc_online_watch_area();
			getWatchArea.done(function(watchArea){

				if ( ! watchArea || ! watchArea.html ) {
					return;
				}

				var $newWatchArea = $(watchArea.html);

				$watchRoom.html( $newWatchArea.html() ).removeClass('loading');

			});
		}
	}

	function get_wpc_online_watch_area() {
		return $.ajax({
			url: wpc_online.ajaxurl,
			type: 'GET',
			dataType: 'json',
			async: true,
			cache: true,
			data: {
				action: 'wpc_online_get_watch_area',
				room: wpc_online.room,
				offset: new Date().getTimezoneOffset()
			}
		});
	};
})(jQuery);
