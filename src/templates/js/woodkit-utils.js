/**
 * @package WordPress
 * @version 1.0
 * @author Sébastien Chandonay www.seb-c.com / Cyril Tissot www.cyriltissot.com This file, like this theme, like WordPress, is licensed under the GPL.
 */

/**
 * Set cookie
 */
function setCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays*24*60*60*1000));
	var expires = "expires="+ d.toUTCString();
	document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

/**
 * Get cookie
 */
function getCookie(cname) {
	var name = cname + "=";
	var decodedCookie = decodeURIComponent(document.cookie);
	var ca = decodedCookie.split(';');
	for(var i = 0; i <ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
}

/**
 * Check cookie
 */
function checkCookie(cname, value) {
	var cvalue = getCookie(cname);
	if (isset(value)) {
		return cvalue == value;
	}
	return !empty(cvalue);
}

function escapeSpecialChars(string){
    return string.replace(/\\n/g, "\\n")
               .replace(/\\'/g, "\\'")
               .replace(/\\"/g, '\\"')
               .replace(/\\&/g, "\\&")
               .replace(/\\r/g, "\\r")
               .replace(/\\t/g, "\\t")
               .replace(/\\b/g, "\\b")
               .replace(/\\f/g, "\\f");
};

function isFloat(n) {
	return !isNaN(parseFloat(n)) && isFinite(n);
}

function isInt(n) {
	return !isNaN(parseInt(n)) && isFinite(n);
}

function getTotalOuterWidth(items_selector) {
	var w_total = 0;
	jQuery(items_selector).each(function(index) {
		var w_item = jQuery(this).outerWidth(true);
		// on n'aime pas les chiffres impaires ...
		if (w_item % 2 == 1) {
			w_item += 1;
		}
		w_total += w_item;
	});
	return w_total;
}

function isset(variable) {
	if (typeof (variable) == undefined || variable == null) {
		return false;
	}
	return true;
}

function empty(variable) {
	if (!isset(variable) || variable == '') {
		return true;
	}
	return false;
}

function indexOf(value, array) {
	var res = -1;
	if (!empty(array)) {
		for ( var i = 0; i < array.length; i++) {
			if (array[i] === value)
				res = i;
		}
	}
	return res;
}

/**
 * Get url parameter
 */
function get_url_parameter(param) {
	var vars = {};
	window.location.href.replace(location.hash, '').replace(/[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
	function(m, key, value) { // callback
		vars[key] = value !== undefined ? value : '';
	});

	if (param) {
		return vars[param] ? decodeURIComponent(vars[param]) : null;
	}
	return vars;
}

/**
 * Show wait box
 */
function wait($element, label, background, z_index) {
	if ($element.children('.woodkit-wait').length <= 0) {
		if (!isset(label)){
			label = Utils.wait_label;
		}
		if (!isset(background)){
			background = Utils.wait_background;
		}
		if (!isset(z_index)){
			z_index = 200000;
		}
		$element.append('<div class="woodkit-wait"><span>'+label+'</span></div>');
		$element.children('.woodkit-wait').css('position', 'absolute');
		$element.children('.woodkit-wait').css('top', '0');
		$element.children('.woodkit-wait').css('left', '0');
		if (isset(Utils.wait_background) && !empty(Utils.wait_background)){
			$element.children('.woodkit-wait').css('background', background);
		}
		$element.children('.woodkit-wait').css('color', '#777');
		$element.children('.woodkit-wait').css('width', '100%');
		$element.children('.woodkit-wait').css('height', '100%');
		$element.children('.woodkit-wait').css('text-align', 'center');
		$element.children('.woodkit-wait').css('z-index', z_index);
		$element.children('.woodkit-wait').css('box-sizing', 'border-box');
		$element.children('.woodkit-wait').css('-moz-box-sizing', 'border-box');
		$element.children('.woodkit-wait').css('-webkit-box-sizing', 'border-box');
		/* flex */
		$element.children('.woodkit-wait').css('display', '-webkit-flex');
		$element.children('.woodkit-wait').css('display', '-moz-flex');
		$element.children('.woodkit-wait').css('display', '-ms-flex');
		$element.children('.woodkit-wait').css('display', 'flex');
		$element.children('.woodkit-wait').css('-webkit-justify-content', 'center');
	    $element.children('.woodkit-wait').css('-moz-justify-content', 'center');
	    $element.children('.woodkit-wait').css('-ms-justify-content', 'center');
	    $element.children('.woodkit-wait').css(' justify-content', 'center');
		 /* flex */
		$element.children('.woodkit-wait').find('span').css('-webkit-align-self', 'center');
		$element.children('.woodkit-wait').find('span').css('-moz-align-self', 'center');
		$element.children('.woodkit-wait').find('span').css('-ms-align-self', 'center');
		$element.children('.woodkit-wait').find('span').css('align-self', 'center');
	}
}

/**
 * hide wait box
 */
function unwait($element) {
	$element.children('.woodkit-wait').remove();
}

/**
 * convert hexadecimal color to rgb
 * 
 * @param hex
 * @returns
 */
function hexToRgb(hex) {
	var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
	return result ? {
		r : parseInt(result[1], 16),
		g : parseInt(result[2], 16),
		b : parseInt(result[3], 16)
	} : null;
}

/**
 * add marker on GoogleMap
 * @param map
 * @param geocoder
 * @param address
 * @param titre
 */
function geocode_adress(map, geocoder, address, titre) {
	var infowindow = null;
	if (!empty(titre)) {
		var infowindow = new google.maps.InfoWindow({
			content : titre
		});
	}
	if (!empty(address)) {
		geocoder.geocode({
			'address' : address
		}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				map.setCenter(results[0].geometry.location);
				var marker = new google.maps.Marker({
					map : map,
					position : results[0].geometry.location
				});
				google.maps.event.addListener(marker, 'click', function() {
					infowindow.open(map, marker);
				});
			} else {
				console.error('Geocode was not successful for the following reason: ' + status);
			}
		});
	}
}

/**
 * Animated scroll-to on each <a> tag which references an anchor and has data-scrollto="true"
 */
(function($) {
	$(document).ready(function(){
		$("a[href^='#']").on('click', function(e) {
			if ($(this).attr("data-scrollto") == true || $(this).attr("data-scrollto") == "true" || $(this).attr("data-scrollto") == "1") {
				e.preventDefault();
				var anchor = $(this).attr('href');
				var speed = $(this).attr("data-scrollto-speed"); // ms
				if (!empty(speed)){
					speed = parseInt(speed);
				}else{
					speed = 750;
				}
				var top = $(this).attr("data-scrollto-top"); // px
				if (!empty(top)){
					top = parseInt(top);
				}else{
					top = 0;
				}
				/**
				 * Add anchor to history
				 */
				if (!isset($(this).attr("data-notaddtohistory"))) {
					window.history.pushState(null, null, anchor);
				}
				$('html, body').animate({
					scrollTop : ($(anchor).offset().top - top)
				}, speed);
				return false;
			}
		});
	});
})(jQuery);

/**
 * Image Loader jQuery Plugin
 */
(function($) {
	$.woodkit_image_load = function($element, on_load_function) {
		var load_timer = null;
		if ($element.prop("tagName") == 'IMG') {
			load_timer = setInterval(function() {
				if ($element.get(0).complete) {
					clearInterval(load_timer);
					on_load_function.call($element);
				}
			}, 200);
		}
		return this;
	};
	$.fn.woodkit_image_load = function(on_load_function) {
		return this.each(function() {
			if (!isset($(this).data('woodkit_image_load'))) {
				var plugin = new $.woodkit_image_load($(this), on_load_function);
				$(this).data('woodkit_image_load', plugin);
			} else {
				// already instanciated - nothing to do
			}
		});
	};
})(jQuery);