/**
 * @package Woodkit
 * @author Sébastien Chandonay www.seb-c.com License: GPL2 Text Domain: woodevents
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
	$.facebookpixeleventsmanager = function(element, events) {
		var plugin = this;
		var settings = null;
		var $facebookpixeleventsmanager = element;
		var $facebookpixeleventsmanager_container = null;
		var $facebookpixeleventsmanager_container_add = null;

		/**
		 * init/update events
		 */
		plugin.events = function(events) {
			settings = $.extend({
				label_add_event : "Add Pixel Event",
				label_event_url : "URL",
				label_event_code : "Event code",
				label_event_parameters : "keep url parameters",
				label_confirm_remove_event : "Do you realy want remove this event ?",
			}, events);
		}

		/**
		 * initialization
		 */
		plugin.init = function() {
			plugin.events(events);

			/**
			 * Html structure
			 */
			$facebookpixeleventsmanager_container = $('<div class="multiple-items-manager facebookpixeleventsmanager-container"></div>').appendTo($('<div class="facebookpixeleventsmanager-wrapper"></div>').appendTo($facebookpixeleventsmanager));
			$facebookpixeleventsmanager_container_add = $('<div class="woodkit-btn add-event add"><span>' + settings['label_add_event'] + '</span></div>').appendTo(
					$facebookpixeleventsmanager);

			/**
			 * Listener
			 */
			$facebookpixeleventsmanager_container_add.on('click', function(e) {
				plugin.add_event("", "", "", "");
			});
			$facebookpixeleventsmanager_container.on('click', '.delete-event', function(e) {
				plugin.remove_event($(this).data('id'));
			});

		};

		/**
		 * initialization
		 */
		plugin.reinit = function(events) {
			plugin.events(events);
		};

		/**
		 *  Set data (events) - passed parameter must be an object
		 */
		plugin.set_data = function(data) {
			for ( var k in data) {
				if (data.hasOwnProperty(k)) {
					var obj = data[k];
					plugin.add_event(obj.url, obj.code, obj.parameters);
				}
			}
		}

		/**
		 * Add event html container
		 */
		plugin.add_event = function(url, code, parameters) {

			var event_id = plugin.get_unique_id("facebookpixel-event-id-", 0);
			
			var type_selected = '';
			var html = '';
			html += '<div class="item event" id="facebookpixel-event-id-' + event_id + '">';
			html += '<input type="text" class="large facebookpixel-event-url" name="facebookpixel-event-url-' + event_id + '" value="'+url+'" placeholder="' + settings['label_event_url'] + '" />';
			var parameters_checked = "";
			if (!empty(parameters) && parameters == 'on')
				parameters_checked = ' checked="checked"';
			html += '<span style="display: inline-block; margin-left: 12px;"></span><input type="checkbox" name="facebookpixel-event-parameters-' + event_id + '"'+parameters_checked+' />';
			html += '<span class="label" style="color: #888; font-style: italic; font-size: 12px;">' + settings['label_event_parameters'] + '</span>';
			html += '<br /><textarea class="xlarge" name="facebookpixel-event-code-' + event_id + '" placeholder="'+settings['label_event_code']+'">'+code+'</textarea>';
			html += '<span class="delete delete-event btn" data-id="facebookpixel-event-id-' + event_id + '"><i class="fa fa-times"></i></div><input type="hidden" name="facebookpixel-event-id-' + event_id + '" value="' + event_id + '" /></span>';
			html += '</div>';

			var $event_container = $(html).appendTo($facebookpixeleventsmanager_container);

			return $event_container;
		}

		/**
		 * Remove event
		 */
		plugin.remove_event = function($event_id) {
			if ($("#" + $event_id).length > 0 && confirm(settings['label_confirm_remove_event'])) {
				$("#" + $event_id).remove();
			}
		}

		/**
		 * get unique event ID
		 */
		plugin.get_unique_id = function(prefix, id) {
			if ($facebookpixeleventsmanager_container.find("#" + prefix + id).length > 0) {
				id++;
				return plugin.get_unique_id(prefix, id);
			} else {
				return id;
			}
		}

		plugin.init();

		return plugin;
	};

	$.fn.facebookpixeleventsmanager = function(options) {
		var facebookpixeleventsmanager = $(this).data('facebookpixeleventsmanager');
		if (empty(facebookpixeleventsmanager)) {
			facebookpixeleventsmanager = new $.facebookpixeleventsmanager($(this), options);
			$(this).data('facebookpixeleventsmanager', facebookpixeleventsmanager);
		} else {
			facebookpixeleventsmanager.reinit(options);
		}
		return facebookpixeleventsmanager;
	};

})(jQuery);