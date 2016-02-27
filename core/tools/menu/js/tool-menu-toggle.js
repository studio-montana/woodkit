/**
 * MENU Tool
 * @package WordPress
 * @subpackage Woodkit
 * @since Woodkit 1.0
 * @author Sébastien Chandonay www.seb-c.com / Cyril Tissot www.cyriltissot.com
 */

/**
 * Responsive Menu Toogle
 */
(function($) {
	$('.menu-toggle').on('click', function(e) {
		if ($("body").hasClass("menu-toggled")){
			$("body").removeClass("menu-toggled");
		}else{
			$("body").addClass("menu-toggled");
		}
	});
})(jQuery);