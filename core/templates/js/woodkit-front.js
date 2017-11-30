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
	 * Standardize item heights
	 */
	$.standardizechildheights = function($element, options) {
		var plugin = this;
		var settings = $.extend({
			child_selector : '.item',
			onstart : null, // function()
			ondone : null, // function()
		}, options);
		var resize_timer = null;
		/**
		 * Process
		 */
		plugin.process = function() {			
			plugin.trigger_onstart();
			var has_item_to_resize = false;
			var resize_height = 0;
			var selector = "";
			$element.find(settings['child_selector']).each(function(i){
				has_item_to_resize = true;
				if ($(this).length > 0 && $(this).outerHeight() > resize_height)
					resize_height = $(this).outerHeight();
			});
			if (has_item_to_resize)
				$element.find(settings['child_selector']).css('min-height', resize_height+'px');
			plugin.trigger_ondone();
		};
		/**
		 * resize
		 */
		$(window).resize(function() {
			if (resize_timer != null)
				clearTimeout(resize_timer);
			resize_timer = setTimeout(plugin.resize, 500);
		});
		plugin.resize = function() {
			// disable previous height
			$element.find(settings['child_selector']).css('min-height', '0px');
			plugin.process();
		};
		/**
		 * trigger onstart
		 */
		plugin.trigger_onstart = function() {
			if (isset(settings['onstart']) && $.isFunction(settings['onstart'])) {
				settings['onstart'].call(null);
			}
		};
		/**
		 * trigger ondone
		 */
		plugin.trigger_ondone = function() {
			if (isset(settings['ondone']) && $.isFunction(settings['ondone'])) {
				settings['ondone'].call(null);
			}
		};
		plugin.process();
		return plugin;
	};
	$.fn.standardizechildheights = function(options) {
		var standardizechildheights = $(this).data('standardizechildheightsplugin');
		if (empty(standardizechildheights)) {
			standardizechildheights = new $.standardizechildheights($(this), options);
			$(this).data('standardizechildheightsplugin', standardizechildheights);
		} else {
			standardizechildheights.process(options);
		}
		return standardizechildheights;
	};
	
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
		var animate_number = $dynamicnumber.data('dynamicnumber'); // int or float value - required
		var animate_start = $dynamicnumber.data('dynamicnumber-start'); // int or float value - default: 0
		var animate_step = $dynamicnumber.data('dynamicnumber-step'); // int or float value - default: 1
		var animate_duration = $dynamicnumber.data('dynamicnumber-duration'); // int value - default: 5000
		var animate_easing = $dynamicnumber.data('dynamicnumber-easing'); // "constant" or "linear" or "quadratic" - default: "linear"
		var animate_number_type = $dynamicnumber.data('dynamicnumber-type'); // "int" or "float" - default: "float"
		plugin.init = function() {
			// animate_start
			if (empty(animate_start) || parseInt(animate_start) == 'NaN')
				animate_start = 0;
			
			// animate_duration
			if (empty(animate_duration) || parseInt(animate_duration) == 'NaN')
				animate_duration = 3000;
			
			// animate_step
			if (empty(animate_step) || parseInt(animate_step) == 'NaN' || parseInt(animate_step) <= 1)
				animate_step = 1;
			
			// animate_easing
			if (animate_easing == 'constant')
				animate_easing = plugin.easing_constant;
			else if (animate_easing == 'quadratic')
				animate_easing = plugin.easing_quadratic;
			else
				animate_easing = plugin.easing_linear;
			
			// animate_number_type
			if (empty(animate_number_type) || (animate_number_type != 'int' && animate_number_type != 'float'))
				animate_number_type = 'float';
			
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
					plugin.start_animation(animate_start, animate_duration, animate_easing);
				}
			}
		}

		// Animate number
		plugin.start_animation = function(start, duration, easing) {
			animated = true;
			var end = 'NaN';
			var range = 0;
			var current = 0;
			if (animate_number_type == 'int'){
				end = parseInt(animate_number);
				if (end != 'NaN'){
					range = end - start;
					current = start;
				}
			}else{
				end = parseFloat(animate_number);
				end = end * 100;
				end = end.toFixed(2);
				start = start * 100;
				if (end != 'NaN'){
					range = end - start;
					current = start;
				}
			}
			if (end != 'NaN'){
				if (end != start){
					var increment = end > start ? animate_step : -(animate_step);
					var increment_dir = end > start ? 'asc' : 'desc';
					var step = function() {
						current += increment;
						if (animate_number_type == 'int'){
							$dynamicnumber.html(current);
						}else{
							$dynamicnumber.html(current/100);
						}
						if ((increment_dir == 'asc' && current < end) || (increment_dir == 'desc' && current > end)) {
							setTimeout(step, easing(duration, range, current));
						}else{
							$dynamicnumber.html(animate_number);
						}
					};
					setTimeout(step, easing(duration, range, start));
				}else{
					$dynamicnumber.html(animate_number);
				}
			}else{
				$dynamicnumber.html(animate_number);
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
		var $modalboxwrapper = null;
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
				$("#modalbox").append('<div id="modalbox-wrapper" class="woodkit-modal-box-wrapper"></div>');
				$("#modalbox-wrapper").append('<div id="modalbox-close" class="woodkit-modal-box-close"><i class="fa fa-times"></i></div>');
				$("#modalbox-wrapper").append('<div id="modalbox-content" class="woodkit-modal-box-content"></div>');
			}
			$modalbox = $("#modalbox");
			$modalboxclose = $("#modalbox-close");
			$modalboxclose.on('click', function(e) {
				plugin.close();
			});
			$modalboxcontent = $("#modalbox-content");
			$modalboxwrapper = $("#modalbox-wrapper");
			$modalboxcontent.empty();
			$(document).keyup(function(e) {
				if (e.keyCode === 27)
					plugin.close();
			});
			$(document).on('click', function(e) { // close on click outside
				if (!$modalboxcontent.is(e.target) && $modalboxcontent.has(e.target).length === 0 && ($modalbox.is(e.target) || $modalboxwrapper.is(e.target))) {
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