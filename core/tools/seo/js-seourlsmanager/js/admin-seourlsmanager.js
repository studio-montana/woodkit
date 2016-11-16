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
				label_add_url : "Add URL",
				label_url : "url",
				label_url_exclude : "exclude",
				label_confirm_remove_url : "Do you realy want remove this url ?",
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
			$seourlsmanager_container = $('<table class="seourlsmanager-container"></table>').appendTo($('<div class="seourlsmanager-wrapper"></div>').appendTo($seourlsmanager));
			$seourlsmanager_container_add = $('<div class="add-url add btn"><i class="fa fa-plus"></i><span>' + settings['label_add_url'] + '</span></div>').appendTo(
					$seourlsmanager);

			/**
			 * Listener
			 */
			$seourlsmanager_container_add.on('click', function(e) {
				plugin.add_url("", "");
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
					plugin.add_url(obj.url, obj.exclude);
				}
			}
		}

		/**
		 * Add url html container
		 */
		plugin.add_url = function(url, exclude) {

			var url_id = plugin.get_unique_id("seo-sitemap-url-id-", 0);
			var exclude_checked = '';
			if (exclude == "on")
				exclude_checked = ' checked="checked"';
			
			var html = '';
			html += '<tr valign="top" class="url" id="seo-sitemap-url-id-' + url_id + '">';
			html += '<td valign="middle" class="seo-sitemap-url"><input type="text" name="seo-sitemap-url-' + url_id + '" value="'+url+'" placeholder="' + settings['label_url'] + '" /></td>';
			html += '<td valign="middle" class="seo-sitemap-url-exclude"><label for="seo-sitemap-url-exclude-' + url_id + '">' + settings['label_url_exclude'] + '</label><input type="checkbox" name="seo-sitemap-url-exclude-' + url_id + '" id="seo-sitemap-url-exclude-' + url_id + '" '+exclude_checked+'/></td>';
			html += '<td valign="middle" class="seo-sitemap-url-id"><div class="delete delete-url btn" data-id="seo-sitemap-url-id-' + url_id + '"><i class="fa fa-times"></i></div><input type="hidden" name="seo-sitemap-url-id-' + url_id + '" value="' + url_id + '" /></td>';
			html += '</tr>';

			var $url_container = $(html).appendTo($seourlsmanager_container);

			return $url_container;
		}

		/**
		 * Remove url
		 */
		plugin.remove_url = function($url_id) {
			if ($("#" + $url_id).length > 0 && confirm(settings['label_confirm_remove_url'])) {
				$("#" + $url_id).remove();
			}
		}

		/**
		 * get unique url ID
		 */
		plugin.get_unique_id = function(prefix, id) {
			if ($seourlsmanager_container.find("#" + prefix + id).length > 0) {
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