/**
 * @package WordPress
 * @version 1.0
 * @author Sébastien Chandonay www.seb-c.com / Cyril Tissot www.cyriltissot.com This file, like this theme, like WordPress, is licensed under the GPL.
 */

(function($) {
	$.postpicker = function(element, options) {
		var plugin = this;
		var settings = $.extend({
			postypes : null,
			exclude : null,
			selected : null,
			multi_select : false,
			order : false,
			ondone : null, // function(id_post / array(ids_post)) depends of multi_select
			onpick : null, // function(id_post)
			onunpick : null, // function()
			onopen : null, // function()
			onclose : null, // function()
			oncontentupdated : null, // function()
			oncontentupdatefail : null,
			done_button_text : Postpicker.doneButtonText,
			order_button_text : Postpicker.orderButtonText
		}, options);
		if (settings['multi_select'] == false) {
			settings['order'] = false;
		}
		var selected_id = null;
		var selected_ids = new Array;
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
			$body.append('<div id="postpicker" class="woodkit-modal-box" style="display: none;"></div>');
			$picker = $("#postpicker");

		};

		plugin.update_interface = function() {
			$picker.empty();
			// close button
			$picker.append('<div id="postpicker-close" class="woodkit-modal-box-close"><i class="fa fa-times"></i></div>');
			$pickerclose = $("#postpicker-close");
			$pickerclose.on('click', function(e) {
				plugin.close();
			});
			// content
			$picker.append('<div id="postpicker-content" class="woodkit-modal-box-content"></div>');
			$pickercontent = $("#postpicker-content");
			// ordering box
			if (settings['order'] == true) {
				$picker.append('<div id="postpicker-ordering"></div>');
				$pickerordering = $("#postpicker-ordering");
				$("#postpicker-ordering").append('<div id="postpicker-ordering-content"></div>');
				$("#postpicker-ordering-content").append('<div id="postpicker-ordering-close"><i class="fa fa-times"></i></div>');
				$pickerordering_close = $("#postpicker-ordering-close");
				$pickerordering_close.on('click', function(e) {
					plugin.close_order();
				});
				$("#postpicker-ordering-content").append('<ul id="postpicker-ordering-list"></ul>');
				$pickerordering_list = $("#postpicker-ordering-list");
				$pickerordering_list.sortable({});
				$pickerordering_list.disableSelection();
			}
			// footer
			$picker.append('<div id="postpicker-footer" class="woodkit-modal-box-footer"></div>');
			$("#postpicker-footer").append('<span id="postpicker-done" class="button button-primary button-large">' + settings['done_button_text'] + '</span>');
			if (settings['order'] == true) {
				$("#postpicker-footer").append('<span id="postpicker-order" class="button button-primary button-large">' + settings['order_button_text'] + '</span>');
			}
			$pickerorder = $("#postpicker-order");
			$pickerorder.on('click', function(e) {
				plugin.order();
			});
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

		/**
		 * order plugin interface
		 */
		plugin.order = function() {
			if ($pickerordering.is(":visible") == true) {
				$pickerordering.fadeOut(0);
			} else {
				$pickerordering.fadeIn(0);
			}
		}

		plugin.close_order = function() {
			$pickerordering.fadeOut(0);
		}

		/**
		 * done plugin interface
		 */
		plugin.done = function() {
			plugin.trigger_ondone();
			plugin.close();
		}

		plugin.updatecontent = function() {
			wait($picker);
			$pickercontent.empty();
			if (isset($pickerordering_list)) {
				$pickerordering_list.empty();
			}
			jQuery.post(Postpicker.ajaxUrl, {
				'action' : 'postpicker_get_posts',
				'ajaxNonce' : Postpicker.ajaxNonce,
				'postypes' : settings['postypes'],
				'exclude' : settings['exclude']
			}, function(response) {
				$pickercontent.append($(response).text());
				// selected
				selected_id = null; // reset
				selected_ids = new Array; // reset
				var to_select = {};
				if (!empty(settings['selected'])) {
					to_select = settings['selected'].split(",");
					for ( var i = 0; i < to_select.length; i++) {
						plugin.select(to_select[i], false, false);
					}
				}
				// on click
				$pickercontent.find(".post-item").on('click', function(e) {
					plugin.select($(this).data('id'), true, true);
				});
				plugin.trigger_oncontentupdated();
			}).fail(function() {
				plugin.trigger_oncontentupdatefail();
			}).always(function() {
				unwait($picker);
			});
		}

		plugin.select = function(id, trigger_onpick, trigger_onunpick) {
			id = parseInt(id);
			var $selected_item = $pickercontent.find(".post-item[data-id='" + id + "']");
			if ($selected_item.length > 0) {
				if (empty(settings['multi_select']) || settings['multi_select'] == false) {
					if (!empty(selected_id) && selected_id == id) {
						selected_id = null;
						$selected_item.removeClass("selected");
						plugin.onunpick(id, trigger_onunpick);
					} else {
						$pickercontent.find(".post-item").removeClass("selected");
						selected_id = id;
						$selected_item.addClass("selected");
						plugin.onpick(id, trigger_onpick);
					}
				} else {
					var index = indexOf(id, selected_ids);
					if (index > -1) {
						selected_ids.splice(index, 1);
						$selected_item.removeClass("selected");
						plugin.onunpick(id, trigger_onunpick);
					} else {
						selected_ids.push(id);
						$selected_item.addClass("selected");
						plugin.onpick(id, trigger_onpick);
					}
				}
			} else {
				console.log("PostPicker error : unknown selected id -> " + id);
			}
		}

		plugin.onpick = function(id, trigger) {
			if (settings['order'] == true) {
				$pickerordering_list.append('<li class="order-item" data-id="' + id + '"></li>');
				// content
				var $order_item = $pickerordering_list.find("li[data-id='" + id + "']");
				if ($order_item.length > 0) {
					wait($order_item);
					jQuery.post(Postpicker.ajaxUrl, {
						'action' : 'postpicker_get_post',
						'ajaxNonce' : Postpicker.ajaxNonce,
						'post_id' : id
					}, function(response) {
						$order_item.append($(response).text());
						$order_item.append('<div class="mask"></div>');
					}).fail(function() {
					}).always(function() {
						unwait($order_item);
					});
				} else {
					console.log("PostPicker error : unknown order item id -> " + id);
				}
			}
			if (trigger == true)
				plugin.trigger_onpick(id);
		}

		plugin.onunpick = function(id, trigger) {
			$pickerordering_list.find("li[data-id='" + id + "']").remove();
			if (trigger == true)
				plugin.trigger_onunpick(id);
		}

		/**
		 * resize
		 */
		plugin.resize = function() {
		};

		/**
		 * retrieve ordered ids
		 */
		plugin.get_ordered_ids = function() {
			if (settings['order'] == true) {
				var ordered_ids = new Array;
				if (!empty(selected_ids)) {
					var i = 0;
					$pickerordering_list.find('li.order-item').each(function(i) {
						ordered_ids[i] = parseInt($(this).data('id'));
						i++;
					});
				}
				return ordered_ids;
			}
			return selected_ids;
		}

		/**
		 * trigger ondone
		 */
		plugin.trigger_ondone = function() {
			if (isset(settings['ondone']) && $.isFunction(settings['ondone'])) {
				if (empty(settings['multi_select']) || settings['multi_select'] == false) {
					settings['ondone'].call(null, selected_id);
				} else {
					settings['ondone'].call(null, plugin.get_ordered_ids());
				}
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
		plugin.trigger_onpick = function(id) {
			if (isset(settings['onpick']) && $.isFunction(settings['onpick'])) {
				settings['onpick'].call(null, id);
			}
		};

		/**
		 * trigger onunpick
		 */
		plugin.trigger_onunpick = function(id) {
			if (isset(settings['onunpick']) && $.isFunction(settings['onunpick'])) {
				settings['onunpick'].call(null, id);
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

	$.fn.postpicker = function(options) {
		var plugin = new $.postpicker($(this), options);
		$(this).data('postpicker', plugin);
		return $(this).data('postpicker');
	};

})(jQuery);