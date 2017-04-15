/**
 * @package WordPress
 * @version 1.0
 * @author Sébastien Chandonay www.seb-c.com / Cyril Tissot www.cyriltissot.com This file, like this theme, like WordPress, is licensed under the GPL.
 */

(function($) {
	$.googlemapsgenerator = function(element, options) {
		var plugin = this;
		var settings = $.extend({
			postypes : null,
			exclude : null,
			selected : null,
			multi_select : false,
			ondone : null, // function(args)
			onclose : null, // function()
			done_button_text : Googlemapsgenerator.doneButtonText,
			address_text : Googlemapsgenerator.address_text,
			title_text : Googlemapsgenerator.title_text,
			zoom_text : Googlemapsgenerator.zoom_text,
			type_text : Googlemapsgenerator.type_text,
			width_text : Googlemapsgenerator.width_text,
			height_text : Googlemapsgenerator.height_text,
			zoomcontrol_text : Googlemapsgenerator.zoomcontrol_text,
			streetviewcontrol_text : Googlemapsgenerator.streetviewcontrol_text,
			scalecontrol_text : Googlemapsgenerator.scalecontrol_text,
			maptypecontrol_text : Googlemapsgenerator.maptypecontrol_text,
			rotatecontrol_text : Googlemapsgenerator.rotatecontrol_text,
			scrollwheel_text : Googlemapsgenerator.scrollwheel_text
		}, options);

		var $body = $("body");
		var $generator = null;
		var $generatorcontent = null;
		var $generatorcontent_fields = null;
		var $generatorclose = null;
		var $generatordone = null;
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
			$body.append('<div id="googlemapsgenerator" class="woodkit-modal-box" style="display: none;"></div>');
			$generator = $("#googlemapsgenerator");
		};

		plugin.update_interface = function() {
			$generator.empty();
			// close button
			$generator.append('<div id="googlemapsgenerator-close" class="woodkit-modal-box-close"><i class="fa fa-times"></i></div>');
			$generatorclose = $("#googlemapsgenerator-close");
			$generatorclose.on('click', function(e) {
				plugin.close();
			});
			// content
			$generator.append('<div id="googlemapsgenerator-content" class="woodkit-modal-box-content"></div>');
			$generatorcontent = $("#googlemapsgenerator-content");
			// footer
			$generator.append('<div id="googlemapsgenerator-footer" class="woodkit-modal-box-footer"></div>');
			$("#googlemapsgenerator-footer").append('<span id="googlemapsgenerator-done" class="button button-primary button-large">' + settings['done_button_text'] + '</span>');
			$generatordone = $("#googlemapsgenerator-done");
			$generatordone.on('click', function(e) {
				plugin.done();
			});
			// generator content
			$generatorcontent.append('<h1 class="googlemapsgenerator-title">GoogleMaps</h1>');
			$generatorcontent.append('<table id="googlemapsgenerator-fields"></table>');
			$generatorcontent_fields = $("#googlemapsgenerator-fields");
			$generatorcontent_fields.append('<tr><td colspan="2"><input type="text" name="address" placeholder="' + settings['address_text'] + '" /></td></tr>');
			$generatorcontent_fields.append('<tr><td colspan="2"><input type="text" name="title" placeholder="' + settings['title_text'] + '" /></td></tr>');
			$generatorcontent_fields
					.append('<tr><td>'
							+ settings['zoom_text']
							+ ' : </td><td><select name="zoom"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12" selected="selected">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option></select></td></tr>');
			$generatorcontent_fields
					.append('<tr><td>'
							+ settings['type_text']
							+ ' : </td><td><select name="type"><option value="ROADMAP" selected="selected">ROADMAP</option><option value="SATELLITE">SATELLITE</option><option value="HYBRID">HYBRID</option><option value="TERRAIN">TERRAIN</option></select></td></tr>');
			$generatorcontent_fields.append('<tr><td>' + settings['width_text'] + '</td><td><input type="text" name="width" value="100%" /></td></tr>');
			$generatorcontent_fields.append('<tr><td>' + settings['height_text'] + '</td><td><input type="text" name="height" value="400px" /></td></tr>');
			$generatorcontent_fields.append('<tr><td>' + settings['zoomcontrol_text']
					+ ' : </td><td><select name="zoomcontrol"><option value="true" selected="selected">true</option><option value="false">false</option></select></td></tr>');
			$generatorcontent_fields.append('<tr><td>' + settings['streetviewcontrol_text']
					+ ' : </td><td><select name="streetviewcontrol"><option value="true" selected="selected">true</option><option value="false">false</option></select></td></tr>');
			$generatorcontent_fields.append('<tr><td>' + settings['scalecontrol_text']
					+ ' : </td><td><select name="scalecontrol"><option value="false" selected="selected">false</option><option value="true">true</option></select></td></tr>');
			$generatorcontent_fields.append('<tr><td>' + settings['maptypecontrol_text']
					+ ' : </td><td><select name="maptypecontrol"><option value="true" selected="selected">true</option><option value="false">false</option></select></td></tr>');
			$generatorcontent_fields.append('<tr><td>' + settings['rotatecontrol_text']
					+ ' : </td><td><select name="rotatecontrol"><option value="false" selected="selected">false</option><option value="true">true</option></select></td></tr>');
			$generatorcontent_fields.append('<tr><td>' + settings['scrollwheel_text']
					+ ' : </td><td><select name="scrollwheel"><option value="true" selected="selected">true</option><option value="false">false</option></select></td></tr>');
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
			$generator.fadeIn(0);
			plugin.update_interface();
		}

		/**
		 * close plugin interface
		 */
		plugin.close = function() {
			if ($generator != null) {
				$generator.fadeOut(0);
				plugin.trigger_onclose();
			}
		}

		plugin.done = function() {
			var id = "gmaps" + new Date().getTime();
			var adress = $("#googlemapsgenerator-fields input[name='address']").val();
			var title = $("#googlemapsgenerator-fields input[name='title']").val();
			var zoom = $("#googlemapsgenerator-fields select[name='zoom']").val();
			var type = $("#googlemapsgenerator-fields select[name='type']").val();
			var width = $("#googlemapsgenerator-fields input[name='width']").val();
			var height = $("#googlemapsgenerator-fields input[name='height']").val();
			var zoomcontrol = $("#googlemapsgenerator-fields select[name='zoomcontrol']").val();
			var streetviewcontrol = $("#googlemapsgenerator-fields select[name='streetviewcontrol']").val();
			var scalecontrol = $("#googlemapsgenerator-fields select[name='scalecontrol']").val();
			var maptypecontrol = $("#googlemapsgenerator-fields select[name='maptypecontrol']").val();
			var rotatecontrol = $("#googlemapsgenerator-fields select[name='rotatecontrol']").val();
			var scrollwheel = $("#googlemapsgenerator-fields select[name='scrollwheel']").val();

			adress = adress.replace(new RegExp('"', 'g'), '');
			title = title.replace(new RegExp('"', 'g'), '');
			width = width.replace(new RegExp('"', 'g'), '');
			height = height.replace(new RegExp('"', 'g'), '');
			plugin.trigger_ondone(id, adress, title, zoom, type, width, height, zoomcontrol, streetviewcontrol, scalecontrol, maptypecontrol, rotatecontrol, scrollwheel, "");
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
		plugin.trigger_ondone = function(id, adress, title, zoom, type, width, height, zoomcontrol, streetviewcontrol, scalecontrol, maptypecontrol, rotatecontrol, scrollwheel, style) {
			if (isset(settings['ondone']) && $.isFunction(settings['ondone'])) {
				settings['ondone'].call(null, id, adress, title, zoom, type, width, height, zoomcontrol, streetviewcontrol, scalecontrol, maptypecontrol, rotatecontrol, scrollwheel, style);
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

	$.fn.googlemapsgenerator = function(options) {
		var plugin = new $.googlemapsgenerator($(this), options);
		$(this).data('googlemapsgenerator', plugin);
		return $(this).data('googlemapsgenerator');
	};

})(jQuery);