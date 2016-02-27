/**
 * @package WordPress
 * @version 1.0
 * @author Sébastien Chandonay www.seb-c.com / Cyril Tissot www.cyriltissot.com This file, like this theme, like WordPress, is licensed under the GPL.
 */

(function($) {
	$.woodkit_slider_thumb_nav = function(element, options) {
		var plugin = this;
		var $plugin = element;
		var plugin_ready = false;
		var resize_timer = null;
		var settings = $.extend({
			items_container_selector : '.container',
			item_selector : '.item',
			prev_control_selector : '.prev-control',
			next_control_selector : '.next-control'
		}, options);

		var $container = null;
		var container_width = 0;
		var items_width = 0;
		var item_max_height = 0;
		var container_position = 0;

		// controllers
		var $prev_control = null;
		var $next_control = null;

		// listen resize (on finish only)
		$(window).resize(function() {
			clearTimeout(resize_timer);
			resize_timer = setTimeout(plugin.done_resizing, 100);
		});
		plugin.done_resizing = function() {
			plugin.resize();
		};

		/**
		 * initialization
		 */
		plugin.init = function() {
			$container = $plugin.find(settings['items_container_selector']);
			$prev_control = $plugin.find(settings['prev_control_selector']);
			$next_control = $plugin.find(settings['next_control_selector']);

			if (isset($prev_control)) {
				$prev_control.on('click', function(e) {
					container_position = container_position + $plugin.width();
					if (container_position > 0){
						container_position = 0;
					}
					$container.animate({left: container_position}, 500);
				});
			}
			if (isset($next_control)) {
				$next_control.on('click', function(e) {
					container_position = container_position - $plugin.width();
					if (container_position < -(container_width - $plugin.width())){
						container_position = -(container_width - $plugin.width());
					}
					$container.animate({left: container_position}, 500);
				});
			}
			plugin.draw();
		};

		/**
		 * draw plugin interface
		 */
		plugin.draw = function() {
			container_width = 0;
			items_width = 0;
			item_max_height = 0;
			container_position = 0;
			
			var prev_item_right_position = 0;
			$plugin.find(settings['item_selector']).each(function(i) {
				$(this).css('position', 'absolute');
				$(this).css('left', prev_item_right_position);
				prev_item_right_position += $(this).outerWidth(true);
				items_width += $(this).outerWidth(true);
				container_width += $(this).outerWidth(true);
				if ($(this).outerHeight(true) > item_max_height) {
					item_max_height = $(this).outerHeight(true);
				}
			});
			$plugin.css('position', 'relative');
			$plugin.css('width', '100%');
			$plugin.css('overflow', 'hidden');
			$plugin.css('height', item_max_height + 'px');
			if (container_width > $plugin.width()) {
				$container.css('position', 'absolute');
				$container.css('left', container_position);
				if (isset($prev_control) && !$prev_control.is(':visible')){
					$prev_control.fadeIn();
				}
				if (isset($next_control) && !$next_control.is(':visible')){
					$next_control.fadeIn();
				}
			} else {
				$
				$container.css('position', 'relative');
				$container.css('left', 'auto');
				if (isset($prev_control) && $prev_control.is(':visible')){
					$prev_control.fadeOut();
				}
				if (isset($next_control) && $next_control.is(':visible')){
					$next_control.fadeOut();
				}
			}
			$container.css('width', container_width + 'px');
			$container.css('height', item_max_height + 'px');
		}

		/**
		 * resize
		 */
		plugin.resize = function() {
			plugin.draw();
		};

		plugin.init();

		return plugin;
	};

	$.fn.woodkit_slider_thumb_nav = function(options) {
		return this.each(function() {
			if (!isset($(this).data('woodkit_slider_thumb_nav'))) {
				var plugin = new $.woodkit_slider_thumb_nav($(this), options);
				$(this).data('woodkit_slider_thumb_nav', plugin);
			} else {
				$(this).data('woodkit_slider_thumb_nav').resize();
			}
		});
	};

})(jQuery);