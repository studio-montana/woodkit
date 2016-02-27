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
	$(".tool-secure-input-wrapper .tool-secure-show-info").on("click", function(e){
		var $text = $(this).parent().find(".tool-secure-info-text");
		if ($text.length > 0){
			if ($text.is(":visible") == true){
				$text.fadeOut();
			}else{
				$text.fadeIn();
			}
		}
	});
	$(".tool-secure-input-wrapper .tool-secure-input").on("click", function(e){
		var $info = $(this).parent().find(".tool-secure-show-info");
		if ($info.length > 0){
			$info.fadeIn();
		}
	});
})(jQuery);