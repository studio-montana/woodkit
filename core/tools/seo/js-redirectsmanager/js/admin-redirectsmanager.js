/**
 * @package Woodcars
 * @author Sébastien Chandonay www.seb-c.com License: GPL2 Text Domain: woodcars
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
	$.redirectsmanager = function(element, options) {
		var plugin = this;
		var settings = null;
		var $redirectsmanager = element;
		var $redirectsmanager_container = null;
		var $redirectsmanager_container_add = null;

		/**
		 * init/update options
		 */
		plugin.options = function(options) {
			settings = $.extend({
				label_add_item : "Add redirect rule",
				label_confirm_remove_item : "Do you realy want remove this rule ?",
				label_disable : "disable",
				label_to : "redirect to",
				label_from_url : "/my-old-page",
				label_to_url : "/my-new-page",
				label_test_equals : "equals",
				label_test_matches : "matches (regexp)",
			}, options);
		}

		/**
		 * initialization
		 */
		plugin.init = function() {
			plugin.options(options);

			/**
			 * Html structure
			 */
			$redirectsmanager_container = $('<div class="optionsmanager-container sortable redirectsmanager-container"></div>').appendTo($redirectsmanager);
			$redirectsmanager_container_add = $('<div class="add-redirect add btn"><i class="fa fa-plus"></i><span>' + settings['label_add_item'] + '</span></div>').appendTo(
					$redirectsmanager);
			
			$redirectsmanager_container.sortable({
				items: '.redirect.item',
				placeholder: 'sortable-placeholder',
				revert: 300,
				stop: function(){
					plugin.update_ranks();
				},
			});
			$redirectsmanager_container.disableSelection();

			/**
			 * Listener
			 */
			$redirectsmanager_container_add.on('click', function(e) {
				plugin.add_redirect(1, "", "", "equals", "");
			});
			$redirectsmanager_container.on('click', '.delete-redirect', function(e) {
				plugin.remove_redirect($(this).data('id'));
			});

		};

		/**
		 * initialization
		 */
		plugin.reinit = function(options) {
			plugin.options(options);
		};

		/**
		 *  Update item ranks (hidden field)
		 */
		plugin.update_ranks = function() {
			$redirectsmanager_container.find(".redirect.item").each(function(i){
				$(this).find("input[name='seo-redirect-rank-"+$(this).attr('data-id')+"']").val(i);
			});
		}

		/**
		 *  Set data (redirects) - passed parameter must be an object
		 */
		plugin.set_data = function(data) {
			for ( var k in data) {
				if (data.hasOwnProperty(k)) {
					var obj = data[k];
					plugin.add_redirect(obj.id, obj.fromurl, obj.tourl, obj.test, obj.disable);
				}
			}
		}

		/**
		 * Add redirect html container
		 */
		plugin.add_redirect = function(id, fromurl, tourl, test, disable) {

			var redirect_id = plugin.get_unique_id("seo-redirect-", id); // item ID for JS manipulations

			var html = '';
			html += '<div class="redirect item" id="seo-redirect-' + redirect_id + '" data-id="' + redirect_id + '">';
			html += '<span class="move-redirect move" data-id="seo-redirect-' + redirect_id + '"><i class="fa fa-ellipsis-v"></i></span>';
			html += '<span class="delete-redirect delete" data-id="seo-redirect-' + redirect_id + '"><i class="fa fa-times"></i></span>';
			
			html += '<select name="seo-redirect-test-' + redirect_id + '">';
			var test_checked = "";
			if (empty(test) || test == 'equals')
				test_checked = ' selected="selected"';
			html += '<option value="equals"'+test_checked+'>'+settings['label_test_equals']+'</option>';
			test_checked = "";
			if (!empty(test) && test == 'matches')
				test_checked = ' selected="selected"';
			html += '<option value="matches"'+test_checked+'>'+settings['label_test_matches']+'</option>';
			html += '</select>';
			
			html += '<input type="text" name="seo-redirect-fromurl-' + redirect_id + '" value="'+fromurl+'" placeholder="' + settings['label_from_url'] + '" />';
			html += '<span class="label">' + settings['label_to'] + '</span>';
			html += '<input type="text" name="seo-redirect-tourl-' + redirect_id + '" value="'+tourl+'" placeholder="' + settings['label_to_url'] + '" />';
			html += '<span class="label" style="color: #888;">' + settings['label_disable'] + ' : </span>';
			$disable_checked = "";
			if (!empty(disable) && disable == 'on')
				$disable_checked = ' checked="checked"';
			html += '<input type="checkbox" name="seo-redirect-disable-' + redirect_id + '"'+$disable_checked+' />';
			
			html += '<input type="hidden" name="seo-redirect-id-' + redirect_id + '" value="' + redirect_id + '" />';
			html += '<input type="hidden" name="seo-redirect-rank-' + redirect_id + '" value="" />';
			html += '</div>';

			var $redirect_container = $(html).appendTo($redirectsmanager_container);
			
			plugin.update_ranks();

			return $redirect_container;
		}

		/**
		 * Remove redirect
		 */
		plugin.remove_redirect = function($redirect_id) {
			if ($("#" + $redirect_id).length > 0 && confirm(settings['label_confirm_remove_item'])) {
				$("#" + $redirect_id).remove();
			}
		}

		/**
		 * get unique redirect ID
		 */
		plugin.get_unique_id = function(prefix, id) {
			if (id < 1 || $redirectsmanager_container.find("#" + prefix + id).length > 0) {
				id++;
				return plugin.get_unique_id(prefix, id);
			} else {
				return id;
			}
		}

		plugin.init();

		return plugin;
	};

	$.fn.redirectsmanager = function(options) {
		var redirectsmanager = $(this).data('redirectsmanager');
		if (empty(redirectsmanager)) {
			redirectsmanager = new $.redirectsmanager($(this), options);
			$(this).data('redirectsmanager', redirectsmanager);
		} else {
			redirectsmanager.reinit(options);
		}
		return redirectsmanager;
	};

})(jQuery);