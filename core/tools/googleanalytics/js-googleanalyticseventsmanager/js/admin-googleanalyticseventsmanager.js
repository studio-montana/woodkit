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
	$.googleanalyticseventsmanager = function(element, events) {
		var plugin = this;
		var settings = null;
		var $googleanalyticseventsmanager = element;
		var $googleanalyticseventsmanager_container = null;
		var $googleanalyticseventsmanager_container_add = null;

		/**
		 * init/update events
		 */
		plugin.events = function(events) {
			settings = $.extend({
				label_add_event : "Add Google Analytics Event",
				label_event_selector : "css selector",
				label_event_name : "event label",
				label_event_action : "action name",
				label_event_category : "category name",
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
			$googleanalyticseventsmanager_container = $('<table class="googleanalyticseventsmanager-container"></table>').appendTo($('<div class="googleanalyticseventsmanager-wrapper"></div>').appendTo($googleanalyticseventsmanager));
			$googleanalyticseventsmanager_container_add = $('<div class="add-event add btn"><i class="fa fa-plus"></i><span>' + settings['label_add_event'] + '</span></div>').appendTo(
					$googleanalyticseventsmanager);

			/**
			 * Listener
			 */
			$googleanalyticseventsmanager_container_add.on('click', function(e) {
				plugin.add_event("", "", "", "");
			});
			$googleanalyticseventsmanager_container.on('click', '.delete-event', function(e) {
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
					plugin.add_event(obj.selector, obj.name, obj.action, obj.category);
				}
			}
		}

		/**
		 * Add event html container
		 */
		plugin.add_event = function(selector, name, action, category) {

			var event_id = plugin.get_unique_id("googleanalytics-event-id-", 0);
			
			var html = '';
			html += '<tr valign="top" class="event" id="googleanalytics-event-id-' + event_id + '">';
			html += '<td valign="middle" class="googleanalytics-event-selector"><input type="text" name="googleanalytics-event-selector-' + event_id + '" value="'+selector+'" placeholder="' + settings['label_event_selector'] + '" /></td>';
			html += '<td valign="middle" class="googleanalytics-event-name"><input type="text" name="googleanalytics-event-name-' + event_id + '" value="'+name+'" placeholder="' + settings['label_event_name'] + '" /></td>';
			html += '<td valign="middle" class="googleanalytics-event-action"><input type="text" name="googleanalytics-event-action-' + event_id + '" value="'+action+'" placeholder="' + settings['label_event_action'] + '" /></td>';
			html += '<td valign="middle" class="googleanalytics-event-category"><input type="text" name="googleanalytics-event-category-' + event_id + '" value="'+category+'" placeholder="' + settings['label_event_category'] + '" /></td>';
			html += '<td valign="middle"><div class="delete delete-event btn" data-id="googleanalytics-event-id-' + event_id + '"><i class="fa fa-times"></i></div><input type="hidden" name="googleanalytics-event-id-' + event_id + '" value="' + event_id + '" /></td>';
			html += '</tr>';

			var $event_container = $(html).appendTo($googleanalyticseventsmanager_container);

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
			if ($googleanalyticseventsmanager_container.find("#" + prefix + id).length > 0) {
				id++;
				return plugin.get_unique_id(prefix, id);
			} else {
				return id;
			}
		}

		plugin.init();

		return plugin;
	};

	$.fn.googleanalyticseventsmanager = function(options) {
		var googleanalyticseventsmanager = $(this).data('googleanalyticseventsmanager');
		if (empty(googleanalyticseventsmanager)) {
			googleanalyticseventsmanager = new $.googleanalyticseventsmanager($(this), options);
			$(this).data('googleanalyticseventsmanager', googleanalyticseventsmanager);
		} else {
			googleanalyticseventsmanager.reinit(options);
		}
		return googleanalyticseventsmanager;
	};

})(jQuery);