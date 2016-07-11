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

		var woodkit_font_iconpicker = {};
		window.woodkit_et_builder = {};
		var woodkit_iconpicker = null;

		/**
		 * Font icon list renderer
		 */
		woodkit_font_iconpicker = {
			woodkit_font_iconpicker_template : function() {
				var template = $('#woodkit-et-builder-font-iconpicker-template').html();
				return template;
			},
			woodkit_font_icon_dom_node_inserted : function(e) {
				if ($("#et_pb_module_icon").length > 0){
					if ($("#woodkit-et-font-icon-preview").length > 0) {
						$("#woodkit-et-font-icon-preview i").attr('class', $("#et_pb_module_icon").val());
					}
				}
			},
			woodkit_font_icon_activate : function() {
				$(document).on('click', "#woodkit-et-font-icon-choose", function(e) {
					if (woodkit_iconpicker == null) {
						woodkit_iconpicker = jQuery("body").iconpicker({
							onpick : function(icon) {
								$("#woodkit-et-font-icon-preview i").attr('class', icon);
								$("#et_pb_module_icon").val(icon);
							}
						});
						woodkit_iconpicker.open();
					} else {
						woodkit_iconpicker.options({
							onpick : function(icon) {
								$("#woodkit-et-font-icon-preview i").attr('class', icon);
								$("#et_pb_module_icon").val(icon);
							}
						});
						woodkit_iconpicker.open();
					}
				});
			}
		};
		$.extend(window.woodkit_et_builder, woodkit_font_iconpicker);

		/**
		 * Activation
		 */
		window.woodkit_et_builder.woodkit_font_icon_activate();

		/**
		 * On template load actions
		 */
		$(document).on("DOMNodeInserted", function(e) {
			window.woodkit_et_builder.woodkit_font_icon_dom_node_inserted(e);
		});

		/**
		 * Other field renderer
		 */

	});

})(jQuery);