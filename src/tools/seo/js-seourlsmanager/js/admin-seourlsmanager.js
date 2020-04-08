/**
 * @package Woodkit
 * @author Sébastien Chandonay www.seb-c.com License: GPL2 Text Domain: woodurls
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
	$.seourlsmanager = function(element, urls) {
		var plugin = this;
		var settings = null;
		var $seourlsmanager = element;
		var $seourlsmanager_container = null;
		var $seourlsmanager_container_add = null;

		/**
		 * init/update urls
		 */
		plugin.urls = function(urls) {
			settings = $.extend({
				label_add_item : "Add sitemap rule",
				label_confirm_remove_item : "Do you realy want remove this url ?",
				label_url : "url",
				label_url_exclude : "exclude",
				label_action_add : "add",
				label_action_exclude_if_equals : "exclude if equals",
				label_action_exclude_if_contains : "exclude if contains",
				label_action_exclude_if_regexp : "exclude if matches regexp",
			}, urls);
		}

		/**
		 * initialization
		 */
		plugin.init = function() {
			plugin.urls(urls);

			/**
			 * Html structure
			 */
			$seourlsmanager_container = $('<div class="multiple-items-manager seourlsmanager-container"></div>').appendTo($seourlsmanager);
			$seourlsmanager_container_add = $('<div class="add-url add woodkit-btn"><span>' + settings['label_add_item'] + '</span></div>').appendTo(
					$seourlsmanager);

			/**
			 * Listener
			 */
			$seourlsmanager_container_add.on('click', function(e) {
				plugin.add_url(1, "", "add");
			});
			$seourlsmanager_container.on('click', '.delete-url', function(e) {
				plugin.remove_url($(this).data('id'));
			});

		};

		/**
		 * initialization
		 */
		plugin.reinit = function(urls) {
			plugin.urls(urls);
		};

		/**
		 *  Set data (urls) - passed parameter must be an object
		 */
		plugin.set_data = function(data) {
			for ( var k in data) {
				if (data.hasOwnProperty(k)) {
					var obj = data[k];
					plugin.add_url(obj.id, obj.url, obj.action);
				}
			}
		}

		/**
		 * Add url html container
		 */
		plugin.add_url = function(id, url, action) {

			var url_id = plugin.get_unique_id("sitemap-url-id-", id);
			
			var html = '';
			html += '<div class="url item" id="sitemap-url-id-' + url_id + '" data-id="' + url_id + '">';
			html += '<span class="delete delete-url" data-id="sitemap-url-id-' + url_id + '"><i class="fa fa-times"></i></span>';
			
			html += '<select name="sitemap-url-action-' + url_id + '">';
			var action_checked = "";
			if (empty(action) || action == 'add')
				action_checked = ' selected="selected"';
			html += '<option value="add"'+action_checked+'>'+settings['label_action_add']+'</option>';
			action_checked = "";
			if (!empty(action) && action == 'exclude_if_equals')
				action_checked = ' selected="selected"';
			html += '<option value="exclude_if_equals"'+action_checked+'>'+settings['label_action_exclude_if_equals']+'</option>';
			action_checked = "";
			if (!empty(action) && action == 'exclude_if_contains')
				action_checked = ' selected="selected"';
			html += '<option value="exclude_if_contains"'+action_checked+'>'+settings['label_action_exclude_if_contains']+'</option>';
			action_checked = "";
			if (!empty(action) && action == 'exclude_if_regexp')
				action_checked = ' selected="selected"';
			html += '<option value="exclude_if_regexp"'+action_checked+'>'+settings['label_action_exclude_if_regexp']+'</option>';
			html += '</select>';
			
			html += '<input type="text" class="large" name="sitemap-url-' + url_id + '" value="'+url+'" placeholder="' + settings['label_url'] + '" />';
			
			html += '<input type="hidden" name="sitemap-url-id-' + url_id + '" value="' + url_id + '" />';
			html += '</div>';
			
			var $url_container = $(html).appendTo($seourlsmanager_container);

			return $url_container;
		}

		/**
		 * Remove url
		 */
		plugin.remove_url = function($url_id) {
			if ($("#" + $url_id).length > 0 && confirm(settings['label_confirm_remove_item'])) {
				$("#" + $url_id).remove();
			}
		}

		/**
		 * get unique url ID
		 */
		plugin.get_unique_id = function(prefix, id) {
			if (id < 1 || $seourlsmanager_container.find("#" + prefix + id).length > 0) {
				id++;
				return plugin.get_unique_id(prefix, id);
			} else {
				return id;
			}
		}

		plugin.init();

		return plugin;
	};

	$.fn.seourlsmanager = function(options) {
		var seourlsmanager = $(this).data('seourlsmanager');
		if (empty(seourlsmanager)) {
			seourlsmanager = new $.seourlsmanager($(this), options);
			$(this).data('seourlsmanager', seourlsmanager);
		} else {
			seourlsmanager.reinit(options);
		}
		return seourlsmanager;
	};

})(jQuery);