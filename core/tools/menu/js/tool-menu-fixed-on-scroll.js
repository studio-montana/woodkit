/**
 * MENU Tool
 * @package WordPress
 * @subpackage Woodkit
 * @since Woodkit 1.0
 * @author Sébastien Chandonay www.seb-c.com / Cyril Tissot www.cyriltissot.com
 */

/**
 * Add fixed class on menu when page is scrolling over
 */
(function($) {

	// initial main menu position
	var main_menu = $('.site-navigation');
	var main_menu_initial_position = 0;
	if (main_menu.length > 0) {
		main_menu_initial_position = main_menu.offset().top;

		// listen scroll page
		$(window).on('scroll', function(e) {
			tool_menu_fixed_on_scroll();
		});

		// init
		tool_menu_fixed_on_scroll();
	}

	function tool_menu_fixed_on_scroll() {
		if ($(window).scrollTop() >= main_menu_initial_position) {
			// fixed
			$('.site-navigation').addClass("scrollover");
		} else {
			// relative
			$('.site-navigation').removeClass("scrollover");
		}
	}
})(jQuery);