/**
 * MENU Tool
 * @package WordPress
 * @subpackage Woodkit
 * @since Woodkit 1.0
 * @author Sébastien Chandonay www.seb-c.com / Cyril Tissot www.cyriltissot.com
 */

/**
 * Add "current_menu_ancestor" class on menu items, and his parents, which are contained by current url (except home url)
 */
(function($) {
	var tool_menu_current_url = ToolMenu.current_url;
	var tool_menu_home_url = ToolMenu.home_url;
	var tool_menu_home_multisite_url = ToolMenu.home_multisite_url;
	var tool_menu_blog_url = ToolMenu.blog_url;
	var tool_menu_is_post = ToolMenu.is_post;
	$(".nav a").each(
			function(i) {
				if ($(this).attr("href") != undefined) {
					if (tool_menu_current_url.indexOf($(this).attr("href")) >= 0 && $(this).attr("href") != tool_menu_home_url && $(this).attr("href") != tool_menu_home_url + "/"
							&& $(this).attr("href") != tool_menu_home_multisite_url + "/") {
						activate_menu_item($(this).parent());
					} else if (tool_menu_is_post == "1" && $(this).attr("href") == tool_menu_blog_url) {
						activate_menu_item($(this).parent());
					}
				}
			});
	function activate_menu_item($menu_item) {
		if ($menu_item.prop("tagName") == "LI") {
			$menu_item.addClass("current_menu_ancestor");
		}
		if (!$menu_item.hasClass("nav")) {
			activate_menu_item($menu_item.parent()); // recursive
		}
	}
})(jQuery);