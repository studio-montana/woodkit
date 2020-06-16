/**
 * @package Woodkit
 * @author Sébastien Chandonay www.seb-c.com / Cyril Tissot www.cyriltissot.com License: GPL2 Text Domain: woodkit
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
 * 
 * NOTE : this file is loaded only in wp back-end
 */


/**
 * JQuery
 */
(function($) {

	/**
	 * Modal Box
	 */
	$.wk_modalbox = (function() {
		var settings = '';
		var $wk_modalbox = null;
		var $wk_modalboxcontent = null;
		var $wk_modalboxwrapper = null;
		var $wk_modalboxclose = null;
		var resize_timer = null;
	
		function init (options) {
			settings = $.extend({
				content : '',
				fullscreen: false,
				onopen : null, // function()
				onclear : null, // function()
				onclose : null, // function()
				style: 'dark', // available style : dark|light|none
				classes: [],
			}, options);
			if ($wk_modalbox == null) {
				var additional_modal_classes = '';
				if (isset(settings.fullscreen) && settings.fullscreen == true){
					additional_modal_classes += ' fullscreen';
				}
				if (isset(settings.style)){
					additional_modal_classes += ' style-'+settings.style;
				}
				if (isset(settings.classes) && settings.classes.length > 0){
					for (let i = 0; i < settings.classes.length; i++){
						additional_modal_classes += ' '+settings.classes[i];
					}
				}
				$("body").append('<div id="wkmodalbox" class="wk-modalbox'+additional_modal_classes+'" style="display: none;"></div>');
				$("#wkmodalbox").append('<div id="wkmodalbox-wrapper" class="wk-modalbox-wrapper"></div>');
				$("#wkmodalbox-wrapper").append('<div id="wkmodalbox-content-wrapper" class="wk-modalbox-content-wrapper"><div id="wkmodalbox-close" class="wk-modalbox-close"><i class="fa fa-times"></i></div><div id="wkmodalbox-content" class="wk-modalbox-content"></div></div>');
				$wk_modalbox = $("#wkmodalbox");
				$wk_modalboxclose = $("#wkmodalbox-close");
				$wk_modalboxclose.on('click', function(e) {
					close();
				});
				$wk_modalboxcontent = $("#wkmodalbox-content");
				$wk_modalboxwrapper = $("#wkmodalbox-wrapper");
				$wk_modalboxcontent.empty();
				$(document).keyup(function(e) {
					if (e.keyCode === 27)
						close();
				});
				$(document).on('click', function(e) { // close on click outside
					if (!$wk_modalboxcontent.is(e.target) && $wk_modalboxcontent.has(e.target).length === 0 && ($wk_modalbox.is(e.target) || $wk_modalboxwrapper.is(e.target))) {
						close();
					}
				});
			}
			clear();
			if (isset(settings.content)) {
				$wk_modalboxcontent.append(settings.content);
			}
			open();
		}
		
		function getContent(){
			return $wk_modalboxcontent;
		}
		
		function open(){
			$wk_modalbox.fadeIn(0);
			trigger_onopen();
		}
		
		function clear(){
			if ($wk_modalboxcontent.length > 0){
				$wk_modalboxcontent.html('');
				trigger_onclear();
			}
		}
		
		function close(){
			if ($wk_modalbox != null) {
				$wk_modalbox.fadeOut(0);
				$wk_modalboxcontent.empty();
				trigger_onclose();
			}
		}
		
		/**
		 * trigger onopen
		 */
		function trigger_onopen(){
			if (isset(settings.onopen) && $.isFunction(settings.onopen)) {
				settings.onopen.call(null);
			}
		};
		/**
		 * trigger onclear
		 */
		function trigger_onclear(){
			if (isset(settings.onclear) && $.isFunction(settings.onclear)) {
				settings.onclear.call(null);
			}
		};
		/**
		 * trigger onclose
		 */
		function trigger_onclose(){
			if (isset(settings.onclose) && $.isFunction(settings.onclose)) {
				settings.onclose.call(null);
			}
		};
	
		return { // public interface
			open: function (options) {
				init(options);
			},
			clear: function () {
				clear();
			},
			close: function () {
				close();
			},
			getContent: function () {
				return getContent();
			}
		};
	})();

})(jQuery);