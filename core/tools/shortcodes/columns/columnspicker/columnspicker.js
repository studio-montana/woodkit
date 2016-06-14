/**
 * @package WordPress
 * @version 1.0
 * @author Sébastien Chandonay www.seb-c.com / Cyril Tissot www.cyriltissot.com This file, like this theme, like WordPress, is licensed under the GPL.
 */

(function($) {
	$.columnspicker = function(element, options) {
		var plugin = this;
		var settings = $.extend({
			onpick : null, // function(columns)
			onopen : null, // function()
			onclose : null, // function()
			done_button_text : Columnspicker.doneButtonText
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
			$body.append('<div id="columnspicker" class="woodkit-modal-box" style="display: none;"></div>');
			$picker = $("#columnspicker");
		};

		plugin.update_interface = function() {
			$picker.empty();
			// close button
			$picker.append('<div id="columnspicker-close" class="woodkit-modal-box-close"><i class="fa fa-times"></i></div>');
			$pickerclose = $("#columnspicker-close");
			$pickerclose.on('click', function(e) {
				plugin.close();
			});
			// content
			$picker.append('<div id="columnspicker-content" class="woodkit-modal-box-content"></div>');
			$pickercontent = $("#columnspicker-content");
			// footer
			$picker.append('<div id="postpicker-footer" class="woodkit-modal-box-footer"></div>');
			$("#postpicker-footer").append('<span id="postpicker-done" class="button button-primary button-large">' + settings['done_button_text'] + '</span>');
			$pickerdone = $("#postpicker-done");
			$pickerdone.on('click', function(e) {
				plugin.done();
			});

			// column side
			$pickercontent.append('<div class="columns-items"></div>');

			// title
			$pickercontent.find(".columns-items").append('<h2 class="title">' + Columnspicker.title + '</h3>');

			// col_one
			$pickercontent.find(".columns-items").append(
					'<div class="columns-item" id="col_one"><span>' + Columnspicker.col_one + '</span><table><tr><td colspan="6" class="a"></td></tr></table></div>');
			$("#col_one").on('click', function(e) {
				plugin.onpick("col_one", "");
			});
			// col_one_half
			$pickercontent.find(".columns-items").append(
					'<div class="columns-item" id="col_one_half"><span>' + Columnspicker.col_one_half + '</span><table><tr><td class="a"></td><td></td></tr></table></div>');
			$("#col_one_half").on('click', function(e) {
				plugin.onpick("col_one_half", "");
			});
			// col_one_half_last
			$pickercontent.find(".columns-items").append(
					'<div class="columns-item" id="col_one_half_last"><span>' + Columnspicker.col_one_half_last + '</span><table><tr><td></td><td class="a"></td></tr></table></div>');
			$("#col_one_half_last").on('click', function(e) {
				plugin.onpick("col_one_half_last", "");
			});
			// col_one_third
			$pickercontent.find(".columns-items").append(
					'<div class="columns-item" id="col_one_third"><span>' + Columnspicker.col_one_third + '</span><table><tr><td class="a"></td><td></td><td></td></tr></table></div>');
			$("#col_one_third").on('click', function(e) {
				plugin.onpick("col_one_third", "");
			});
			// col_one_third_last
			$pickercontent.find(".columns-items").append(
					'<div class="columns-item" id="col_one_third_last"><span>' + Columnspicker.col_one_third_last + '</span><table><tr><td></td><td></td><td class="a"></td></tr></table></div>');
			$("#col_one_third_last").on('click', function(e) {
				plugin.onpick("col_one_third_last", "");
			});
			// col_one_fourth
			$pickercontent.find(".columns-items").append(
					'<div class="columns-item" id="col_one_fourth"><span>' + Columnspicker.col_one_fourth + '</span><table><tr><td class="a"></td><td></td><td></td><td></td></tr></table></div>');
			$("#col_one_fourth").on('click', function(e) {
				plugin.onpick("col_one_fourth", "");
			});
			// col_one_fourth_last
			$pickercontent.find(".columns-items").append(
					'<div class="columns-item" id="col_one_fourth_last"><span>' + Columnspicker.col_one_fourth_last
							+ '</span><table><tr><td></td><td></td><td></td><td class="a"></td></tr></table></div>');
			$("#col_one_fourth_last").on('click', function(e) {
				plugin.onpick("col_one_fourth_last", "");
			});
			// col_two_third
			$pickercontent.find(".columns-items").append(
					'<div class="columns-item" id="col_two_third"><span>' + Columnspicker.col_two_third
							+ '</span><table><tr class="inv"><td></td><td></td><td></td></tr><tr><td colspan="2" class="a"></td><td></td></tr></table></div>');
			$("#col_two_third").on('click', function(e) {
				plugin.onpick("col_two_third", "");
			});
			// col_two_third_last
			$pickercontent.find(".columns-items").append(
					'<div class="columns-item" id="col_two_third_last"><span>' + Columnspicker.col_two_third_last
							+ '</span><table><tr class="inv"><td></td><td></td><td></td></tr><tr><td></td><td colspan="2" class="a"></td></tr></table></div>');
			$("#col_two_third_last").on('click', function(e) {
				plugin.onpick("col_two_third_last", "");
			});
			// col_three_fourth
			$pickercontent.find(".columns-items").append(
					'<div class="columns-item" id="col_three_fourth"><span>' + Columnspicker.col_three_fourth
							+ '</span><table><tr class="inv"><td></td><td></td><td></td><td></td></tr><tr><td colspan="3" class="a"></td><td></td></tr></table></div>');
			$("#col_three_fourth").on('click', function(e) {
				plugin.onpick("col_three_fourth", "");
			});
			// col_three_fourth_last
			$pickercontent.find(".columns-items").append(
					'<div class="columns-item" id="col_three_fourth_last"><span>' + Columnspicker.col_three_fourth_last
							+ '</span><table><tr class="inv"><td></td><td></td><td></td><td></td></tr><tr><td></td><td colspan="3" class="a"></td></tr></table></div>');
			$("#col_three_fourth_last").on('click', function(e) {
				plugin.onpick("col_three_fourth_last", "");
			});
			// col_one_fifth
			$pickercontent.find(".columns-items").append(
					'<div class="columns-item" id="col_one_fifth"><span>' + Columnspicker.col_one_fifth
							+ '</span><table><tr><td class="a"></td><td></td><td></td><td></td><td></td></tr></table></div>');
			$("#col_one_fifth").on('click', function(e) {
				plugin.onpick("col_one_fifth", "");
			});
			// col_one_fifth_last
			$pickercontent.find(".columns-items").append(
					'<div class="columns-item" id="col_one_fifth_last"><span>' + Columnspicker.col_one_fifth_last
							+ '</span><table><tr><td></td><td></td><td></td><td></td><td class="a"></td></tr></table></div>');
			$("#col_one_fifth_last").on('click', function(e) {
				plugin.onpick("col_one_fifth_last", "");
			});
			// col_two_fifth
			$pickercontent.find(".columns-items").append(
					'<div class="columns-item" id="col_two_fifth"><span>' + Columnspicker.col_two_fifth
							+ '</span><table><tr class="inv"><td></td><td></td><td></td><td></td><td></td></tr> <tr><td colspan="2" class="a"><td></td><td></td><td></td></tr></table></div>');
			$("#col_two_fifth").on('click', function(e) {
				plugin.onpick("col_two_fifth", "");
			});
			// col_two_fifth_last
			$pickercontent.find(".columns-items").append(
					'<div class="columns-item" id="col_two_fifth_last"><span>' + Columnspicker.col_two_fifth_last
							+ '</span><table><tr class="inv"><td></td><td></td><td></td><td></td><td></td></tr> <tr><td></td><td></td><td></td><td colspan="2" class="a"></td></tr></table></div>');
			$("#col_two_fifth_last").on('click', function(e) {
				plugin.onpick("col_two_fifth_last", "");
			});
			// col_three_fifth
			$pickercontent.find(".columns-items").append(
					'<div class="columns-item" id="col_three_fifth"><span>' + Columnspicker.col_three_fifth
							+ '</span><table><tr class="inv"><td></td><td></td><td></td><td></td><td></td></tr> <tr><td colspan="3" class="a"></td><td></td><td></td></tr></table></div>');
			$("#col_three_fifth").on('click', function(e) {
				plugin.onpick("col_three_fifth", "");
			});
			// col_three_fifth_last
			$pickercontent.find(".columns-items").append(
					'<div class="columns-item" id="col_three_fifth_last"><span>' + Columnspicker.col_three_fifth_last
							+ '</span><table><tr class="inv"><td></td><td></td><td></td><td></td><td></td></tr> <tr><td></td><td></td><td colspan="3" class="a"></td></tr></table></div>');
			$("#col_three_fifth_last").on('click', function(e) {
				plugin.onpick("col_three_fifth_last", "");
			});
			// col_four_fifth
			$pickercontent.find(".columns-items").append(
					'<div class="columns-item" id="col_four_fifth"><span>' + Columnspicker.col_four_fifth
							+ '</span><table><tr class="inv"><td></td><td></td><td></td><td></td><td></td></tr> <tr><td colspan="4" class="a"></td><td></td></tr></table></div>');
			$("#col_four_fifth").on('click', function(e) {
				plugin.onpick("col_four_fifth", "");
			});
			// col_four_fifth_last
			$pickercontent.find(".columns-items").append(
					'<div class="columns-item" id="col_four_fifth_last"><span>' + Columnspicker.col_four_fifth_last
							+ '</span><table><tr class="inv"><td></td><td></td><td></td><td></td><td></td></tr> <tr><td></td><td colspan="4" class="a"></td></tr></table></div>');
			$("#col_four_fifth_last").on('click', function(e) {
				plugin.onpick("col_four_fifth_last", "");
			});
			// col_one_sixth
			$pickercontent.find(".columns-items").append(
					'<div class="columns-item" id="col_one_sixth"><span>' + Columnspicker.col_one_sixth
							+ '</span><table><tr><td class="a"></td><td></td><td></td><td></td><td></td><td></td></tr></table></div>');
			$("#col_one_sixth").on('click', function(e) {
				plugin.onpick("col_one_sixth", "");
			});
			// col_one_sixth_last
			$pickercontent.find(".columns-items").append(
					'<div class="columns-item" id="col_one_sixth_last"><span>' + Columnspicker.col_one_sixth_last
							+ '</span><table><tr><td></td><td></td><td></td><td></td><td></td><td class="a"></td></tr></table></div>');
			$("#col_one_sixth_last").on('click', function(e) {
				plugin.onpick("col_one_sixth_last", "");
			});
			// col_five_sixth
			$pickercontent.find(".columns-items").append(
					'<div class="columns-item" id="col_five_sixth"><span>' + Columnspicker.col_five_sixth
							+ '</span><table><tr class="inv"><td></td><td></td><td></td><td></td><td></td><td></td></tr> <tr><td colspan="5" class="a"></td><td></td></tr></table></div>');
			$("#col_five_sixth").on('click', function(e) {
				plugin.onpick("col_five_sixth", "");
			});
			// col_five_sixth_last
			$pickercontent.find(".columns-items").append(
					'<div class="columns-item" id="col_five_sixth_last"><span>' + Columnspicker.col_five_sixth_last
							+ '</span><table><tr class="inv"><td></td><td></td><td></td><td></td><td></td><td></td></tr> <tr><td></td><td colspan="5" class="a"></td></tr></table></div>');
			$("#col_five_sixth_last").on('click', function(e) {
				plugin.onpick("col_five_sixth_last", "");
			});

			// style side
			$pickercontent.append('<div class="columns-style"></div>');

			// title
			$pickercontent.find(".columns-style").append('<h2 class="style">' + Columnspicker.style + '</h3>');
			
			var padding_top = "0";
			var padding_right = "0";
			var padding_bottom = "0";
			var padding_left = "0";
			if (!empty($.cookie('columns-picker-padding-top')))
				padding_top = $.cookie('columns-picker-padding-top');
			if (!empty($.cookie('columns-picker-padding-right')))
				padding_right = $.cookie('columns-picker-padding-right');
			if (!empty($.cookie('columns-picker-padding-bottom')))
				padding_bottom = $.cookie('columns-picker-padding-bottom');
			if (!empty($.cookie('columns-picker-padding-left')))
				padding_left = $.cookie('columns-picker-padding-left');
			
			$pickercontent.find(".columns-style").append('<div class="style-wrapper"></div>');
			$pickercontent.find(".columns-style .style-wrapper").append('<div class="columns-style-field columns-style-top"><input type="number" id="columns-style-top" value="'+padding_top+'" /></div>');
			$pickercontent.find(".columns-style .style-wrapper").append('<div class="columns-style-field columns-style-right"><input type="number" id="columns-style-right" value="'+padding_right+'" /></div>');
			$pickercontent.find(".columns-style .style-wrapper").append('<div class="columns-style-field columns-style-bottom"><input type="number" id="columns-style-bottom" value="'+padding_bottom+'" /></div>');
			$pickercontent.find(".columns-style .style-wrapper").append('<div class="columns-style-field columns-style-left"><input type="number" id="columns-style-left" value="'+padding_left+'" /></div>');
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

		plugin.onpick = function(columns, style) {
			style = plugin.get_style(style);
			plugin.trigger_onpick(columns, style);
			plugin.done();
		}

		plugin.done = function() {
			plugin.trigger_ondone();
			plugin.close();
		}

		plugin.get_style = function(style) {
			var padding_top = $("#columns-style-top").val();
			var padding_right = $("#columns-style-right").val();
			var padding_bottom = $("#columns-style-bottom").val();
			var padding_left = $("#columns-style-left").val();
			
			if ((!empty(padding_top) && padding_top != "0") || (!empty(padding_right) && padding_right != "0") || (!empty(padding_bottom) && padding_bottom != "0")
					|| (!empty(padding_left) && padding_left != "0")) {
				$.cookie('columns-picker-padding-top', padding_top, {path: '/'});
				$.cookie('columns-picker-padding-right', padding_right, {path: '/'});
				$.cookie('columns-picker-padding-bottom', padding_bottom, {path: '/'});
				$.cookie('columns-picker-padding-left', padding_left, {path: '/'});
				style += "padding:" + padding_top + "px " + padding_right + "px " + padding_bottom + "px " + padding_left + "px;";
			}
			return style;
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
		plugin.trigger_onpick = function(columns, style) {
			if (isset(settings['onpick']) && $.isFunction(settings['onpick'])) {
				settings['onpick'].call(null, columns, style);
			}
		};

		plugin.init();

		return plugin;
	};

	$.fn.columnspicker = function(options) {
		var plugin = new $.columnspicker($(this), options);
		$(this).data('columnspicker', plugin);
		return $(this).data('columnspicker');
	};

})(jQuery);