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
	 * DynamicNumber
	 */
	$.dynamicnumber = function(element, options) {
		var plugin = this;
		var settings = $.extend({
			activate_when_appear: true
		}, options);
		var $dynamicnumber = element;
		var animated = false;
		var initial_value = $dynamicnumber.data('dynamicnumber');
		plugin.init = function() {
			$(window).scroll(function(){
				plugin.is_displayed();
			});
			plugin.is_displayed();
		};
		
		// Start animation when element appears
		plugin.is_displayed = function(){
			if(!animated){
				var window_height = $(window).height();
				var scroll = $(window).scrollTop();
				var offset = $dynamicnumber.offset();
				if ((scroll) > (offset.top -  window_height) && (scroll) < offset.top){
					plugin.animate_number(0, 5000, plugin.easing_linear);
				}
			}
		}

		// Animate number
		plugin.animate_number = function(start, duration, easing) {
			animated = true;
			var end = parseFloat(initial_value);
			if (end != 'NaN'){
				end = end.toFixed(2);
				end = end * 100;
				var range = end - start;
				var current = start;
				var increment = end > start ? 1 : -1;
				var startTime = new Date();
				var offset = 1;
				var step = function() {
					current += increment;
					$dynamicnumber.html(current/100);
					if (current != end) {
						setTimeout(step, easing(duration, range, current));
					}else{
						$dynamicnumber.html(initial_value);
					}
				};
				setTimeout(step, easing(duration, range, start));
			}else{
				$dynamicnumber.html(initial_value);
			}
		}	
		
		//No easing
		plugin.easing_constant = function(duration, range, current) {
		  return duration / range;
		}

		//Linear easing
		plugin.easing_linear = function(duration, range, current) {
		  return ((duration * 2) / Math.pow(range, 2)) * current;
		}

		//Quadratic easing
		plugin.easing_quadratic = function(duration, range, current) {
		  return ((duration * 3) / Math.pow(range, 3)) * Math.pow(current, 2);
		}
		plugin.init();
		return plugin;
	};
	$.fn.dynamicnumber = function(options) {
		var dynamicnumber = $(this).data('dynamicnumberplugin');
		if (empty(dynamicnumber)) {
			dynamicnumber = new $.dynamicnumber($(this), options);
			$(this).data('dynamicnumberplugin', dynamicnumber);
		} else {
			dynamicnumber.reinit(options);
		}
		return dynamicnumber;
	};
	$(document).ready(function(){
		$("*[data-dynamicnumber]").each(function(i){
			$(this).dynamicnumber({});
		});
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