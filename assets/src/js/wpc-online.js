(function($) {
	'use strict';

	$(document).ready(function() {

		// Making the main menu keyboard accessible:

		$('.wpc-menu > li.menu-item-has-children a').on('focus',function(){
			$(this).closest('.menu-item-has-children').addClass('has-focus');
		});

		$('.wpc-menu > li.menu-item-has-children').on('mouseleave',function(){
			$(this).removeClass('has-focus');
		});

		$('.wpc-menu > li:not(.menu-item-has-children) a').on('focus',function(){
			$(this).closest('.wpc-menu').find('.menu-item-has-children.has-focus').removeClass('has-focus');
        });

        $('.wpc-menu > li:not(.menu-item-has-children) a').on('hover',function(){
			$(this).closest('.wpc-menu').find('.menu-item-has-children.has-focus').removeClass('has-focus');
		});

        $('.wpc-menu').on('mouseleave',function(){
			$(this).find('.has-focus').removeClass('has-focus');
        });
	});
})(jQuery);