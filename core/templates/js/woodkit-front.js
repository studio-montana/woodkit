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
 * NOTE : this file is loaded only in wp front-end
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
	
	/**
	 * ModalBox
	 */
	$.modalbox = function(options) {
		var plugin = this;
		var settings = $.extend({
			content : '',
			onopen : null, // function()
			onclose : null, // function()
		}, options);
		var $body = $("body");
		var $modalbox = null;
		var $modalboxcontent = null;
		var $modalboxclose = null;
		var resize_timer = null;
		/**
		 * window resize
		 */
		$(window).resize(function() {
			if (resize_timer != null)
				clearTimeout(resize_timer);
			resize_timer = setTimeout(plugin.resize, 500);
		});
		/**
		 * initialization
		 */
		plugin.init = function() {
			if ($("#modalbox").length < 1) {
				$body.append('<div id="modalbox" class="woodkit-modal-box" style="display: none;"></div>');
				$("#modalbox").append('<div id="modalbox-close" class="woodkit-modal-box-close"><i class="fa fa-times"></i></div>');
				$("#modalbox").append('<div id="modalbox-content" class="woodkit-modal-box-content"></div>');
			}
			$modalbox = $("#modalbox");
			$modalboxclose = $("#modalbox-close");
			$modalboxclose.on('click', function(e) {
				plugin.close();
			});
			$modalboxcontent = $("#modalbox-content");
			$modalboxcontent.empty();
			$(document).keyup(function(e) {
				if (e.keyCode === 27)
					plugin.close();
			});
			$(document).on('click', function(e) { // close on click outside
				if (!$modalboxcontent.is(e.target) && $modalboxcontent.has(e.target).length === 0 && $modalbox.is(e.target)) {
					plugin.close();
				}
			});
			if (isset(settings['content'])) {
				$modalboxcontent.append(settings['content']);
			}
			plugin.open();
		};
		/**
		 * open plugin interface (draw if doesn't exist)
		 */
		plugin.open = function() {
			$modalbox.fadeIn(0);
			plugin.trigger_onopen();
		}
		/**
		 * close plugin interface
		 */
		plugin.close = function() {
			if ($modalbox != null) {
				$modalbox.fadeOut(0);
				$modalboxcontent.empty();
				plugin.trigger_onclose();
			}
		}
		/**
		 * resize
		 */
		plugin.resize = function() {
		};
		/**
		 * trigger onopen
		 */
		plugin.trigger_onopen = function() {
			if (isset(settings['onopen']) && $.isFunction(settings['onopen'])) {
				settings['onopen'].call(null);
			}
		};
		/**
		 * trigger onclose
		 */
		plugin.trigger_onclose = function() {
			if (isset(settings['onclose']) && $.isFunction(settings['onclose'])) {
				settings['onclose'].call(null);
			}
		};
		plugin.init();
		return plugin;
	};
	
})(jQuery);