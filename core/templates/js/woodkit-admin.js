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
 * 
 * NOTE : this file is loaded only in wp back-end
 */

(function($) {
	$(document).ready(function() {

		/**
		 * date picker on date fields (require jquery-ui-datepicker)
		 */
		$("input[type='date']").datepicker({
			dateFormat : 'dd/mm/yy'
		});
		$("input.datepicker").datepicker({
			dateFormat : 'dd/mm/yy'
		});

		/**
		 * custom color picker options
		 */
		function woodkit_customize_color_picker($elem) {
			var options = {
				palettes : CustomColorPicker.palettes,
			};
			$elem.iris(options);
		}

		$("input[name='backgroundcolor-code']").each(function() {
			woodkit_customize_color_picker($(this));
		});

		/** must be called on modal box load */
		function woodkit_customize_color_picker_divi() {
			$(".et-pb-color-picker-hex").each(function() {
				woodkit_customize_color_picker($(this));
			});
			$(".et-builder-color-picker-alpha").each(function() {
				woodkit_customize_color_picker($(this));
			});
		}
		$(document).on("woodkit-on-divi-modal-box-opened", function(e) {
			woodkit_customize_color_picker_divi();
		});

	});
})(jQuery);