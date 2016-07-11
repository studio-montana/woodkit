/**
 * @package Woodkit
 * @author Sébastien Chandonay www.seb-c.com / Cyril Tissot www.cyriltissot.com License: GPL2 Text Domain: woodkit
 * 
 * Copyright 2016 Sébastien Chandonay (email : please contact me from my website)
 * 
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301
 * USA
 */

(function($) {

	$(document).ready(function() {

		/**
		 * Divi modules - Icon button - center icons
		 */
		$(".woodkit_et_pb_icon_button i").each(function(i) {
			$(this).css("position", "absolute");
			$(this).css("top", "50%");
			$(this).css("left", "50%");
			$(this).css("margin", "-" + ($(this).outerHeight() / 2) + "px 0 0 -" + ($(this).outerWidth() / 2) + "px");
		});

	});

})(jQuery);