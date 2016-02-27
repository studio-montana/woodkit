/**
 * SHORTCODES Tool
 * 
 * @package WordPress
 * @subpackage Woodkit
 * @since Woodkit 1.0
 * @author Sébastien Chandonay www.seb-c.com / Cyril Tissot www.cyriltissot.com
 */

(function($) {
	$(".tool-shortcodes-icons-box").each(function(i){
		var first_box_content = true;
		$(this).find(".tool-shortcodes-icons-box-familly").each(function(i){
			if (first_box_content == true){
				$(this).find(".tool-shortcodes-icons-box-familly-content").fadeIn(0);
				$(this).find("i.closed").fadeOut(0);
				$(this).find("i.opened").fadeIn(0);
			}else{
				$(this).find(".tool-shortcodes-icons-box-familly-content").fadeOut(0);
				$(this).find("i.closed").fadeIn(0);
				$(this).find("i.opened").fadeOut(0);
			}
			first_box_content = false;
		});
	});
	$(".tool-shortcodes-icons-box-familly-title").on('click', function(e){
		$(".tool-shortcodes-icons-box-familly-content").fadeOut(0);
		$(".tool-shortcodes-icons-box-familly-title i.closed").fadeIn(0);
		$(".tool-shortcodes-icons-box-familly-title i.opened").fadeOut(0);
		$(this).parent().find(".tool-shortcodes-icons-box-familly-content").fadeIn();
		$(this).find("i.closed").fadeOut(0);
		$(this).find("i.opened").fadeIn();
	});
})(jQuery);