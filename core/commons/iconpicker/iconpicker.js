/**
 * @package WordPress
 * @version 1.0
 * @author Sébastien Chandonay www.seb-c.com / Cyril Tissot www.cyriltissot.com This file, like this theme, like WordPress, is licensed under the GPL.
 */

(function($) {
	$.iconpicker = function(element, options) {
		var plugin = this;
		var settings = $.extend({
			postypes : null,
			exclude : null,
			selected : null,
			multi_select : false,
			onpick : null, // function(icon)
			onopen : null, // function()
			onclose : null, // function()
			oncontentupdated : null, // function()
			oncontentupdatefail : null, // function()
			done_button_text : Iconpicker.doneButtonText
		}, options);

		var $body = $("body");
		var $picker = null;
		var $pickercontent = null;
		var $pickerordering = null;
		var $pickerordering_list = null;
		var $pickerordering_close = null;
		var $pickerclose = null;
		var $pickerorder = null;
		var $pickerdone = null;
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
			// wrapper
			$body.append('<div id="iconpicker" class="woodkit-modal-box" style="display: none;"></div>');
			$picker = $("#iconpicker");
		};

		plugin.update_interface = function() {
			$picker.empty();
			// close button
			$picker.append('<div id="iconpicker-close" class="woodkit-modal-box-close"><i class="fa fa-times"></i></div>');
			$pickerclose = $("#iconpicker-close");
			$pickerclose.on('click', function(e) {
				plugin.close();
			});
			// content
			$picker.append('<div id="iconpicker-content" class="woodkit-modal-box-content"></div>');
			$pickercontent = $("#iconpicker-content");
			// footer
			$picker.append('<div id="postpicker-footer" class="woodkit-modal-box-footer"></div>');
			$("#postpicker-footer").append('<span id="postpicker-done" class="button button-primary button-large">' + settings['done_button_text'] + '</span>');
			$pickerdone = $("#postpicker-done");
			$pickerdone.on('click', function(e) {
				plugin.done();
			});
		}

		/**
		 * update options/settings
		 */
		plugin.options = function(options) {
			settings = $.extend(settings, options);
		}

		/**
		 * open plugin interface (draw if doesn't exist)
		 */
		plugin.open = function() {
			$picker.fadeIn(0);
			plugin.update_interface();
			plugin.trigger_onopen();
			plugin.updatecontent();
		}

		/**
		 * close plugin interface
		 */
		plugin.close = function() {
			if ($picker != null) {
				$picker.fadeOut(0);
				plugin.trigger_onclose();
			}
		}

		plugin.updatecontent = function() {
			wait($picker);
			$pickercontent.empty();
			if (isset($pickerordering_list)) {
				$pickerordering_list.empty();
			}
			jQuery.post(Iconpicker.ajaxUrl, {
				'action' : 'iconpicker_get_icons',
				'ajaxNonce' : Iconpicker.ajaxNonce
			}, function(response) {
				$pickercontent.append($(response).text());
				// on click
				$pickercontent.find(".icon-item").on('click', function(e) {
					plugin.onpick($(this).data('icon'));
				});
				plugin.trigger_oncontentupdated();
			}).fail(function() {
				plugin.trigger_oncontentupdatefail();
			}).always(function() {
				unwait($picker);
			});
		}

		plugin.onpick = function(icon) {
			plugin.trigger_onpick(icon);
			plugin.done();
		}
		
		plugin.done = function() {
			plugin.trigger_ondone();
			plugin.close();
		}

		/**
		 * resize
		 */
		plugin.resize = function() {
		};

		/**
		 * trigger ondone
		 */
		plugin.trigger_ondone = function() {
			if (isset(settings['ondone']) && $.isFunction(settings['ondone'])) {
				settings['ondone'].call(null);
			}
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

		/**
		 * trigger onpick
		 */
		plugin.trigger_onpick = function(icon) {
			if (isset(settings['onpick']) && $.isFunction(settings['onpick'])) {
				settings['onpick'].call(null, icon);
			}
		};

		/**
		 * trigger oncontentupdated
		 */
		plugin.trigger_oncontentupdated = function() {
			if (isset(settings['oncontentupdated']) && $.isFunction(settings['oncontentupdated'])) {
				settings['oncontentupdated'].call(null);
			}
		};

		/**
		 * trigger oncontentupdatederror
		 */
		plugin.trigger_oncontentupdatefail = function() {
			if (isset(settings['oncontentupdatefail']) && $.isFunction(settings['oncontentupdatefail'])) {
				settings['oncontentupdatefail'].call(null);
			}
		};

		plugin.init();

		return plugin;
	};

	$.fn.iconpicker = function(options) {
		var plugin = new $.iconpicker($(this), options);
		$(this).data('iconpicker', plugin);
		return $(this).data('iconpicker');
	};

})(jQuery);