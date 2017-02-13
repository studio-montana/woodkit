/**
 * @package Woodkit
 * @author Sébastien Chandonay www.seb-c.com / Cyril Tissot www.cyriltissot.com
 * License: GPL2
 * Text Domain: woodkit
 *
 * Copyright 2016 Sébastien Chandonay (email : please contact me from my website)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * 
 * NOTE : this file is loaded only in wp login
 */

/**
 * Tool Secure
 */
(function($) {
	$(".tool-secure-input-wrapper .tool-secure-show-info").on("click", function(e) {
		var $text = $(this).parent().find(".tool-secure-info-text");
		if ($text.length > 0) {
			if ($text.is(":visible") == true) {
				$text.fadeOut();
			} else {
				$text.fadeIn();
			}
		}
	});
	$(".tool-secure-input-wrapper .tool-secure-input").on("click", function(e) {
		var $info = $(this).parent().find(".tool-secure-show-info");
		if ($info.length > 0) {
			$info.fadeIn();
		}
	});
})(jQuery);
