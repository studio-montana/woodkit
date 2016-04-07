/**
 * @package WordPress
 * @version 1.0
 * @author Sébastien Chandonay www.seb-c.com / Cyril Tissot www.cyriltissot.com This file, like this theme, like WordPress, is licensed under the GPL.
 */

var gold_number = 1.618;

(function($) {

	/**
	 * ISOTOPE & MASONRY GALLERY RESPONSIVE FUNCTION
	 */
	function woodkit_resize_isotope_items($isotope, item_selector) {
		var isotope_matrice = woodkit_resize_gallery_matrix();
		var isotope_data_columns = parseInt($isotope.data('columns'));
		if (isset(isotope_data_columns) && !isNaN(isotope_data_columns)) {
			var resized = false;
			for ( var window_size in isotope_matrice) {
				if (isotope_matrice.hasOwnProperty(window_size) && $(window).width() < parseInt(window_size)) {
					var window_matrice = isotope_matrice[window_size];
					if (window_matrice.hasOwnProperty(isotope_data_columns)) {
						var columns_matrice = window_matrice[isotope_data_columns];
						$isotope.find(item_selector).each(function(i) {
							// width
							var item_data_columns = parseInt($(this).data('columns'));
							if (columns_matrice.hasOwnProperty(item_data_columns)) {
								var new_width = columns_matrice[item_data_columns];
								$(this).css("width", new_width);
							}
							// height
							woodkit_resize_gallery_items_height($(this), window_matrice.columns);
						});
					}
					// isotope columnWidth
					var larg = $isotope[0].getBoundingClientRect().width / window_matrice.columns;
					$isotope.isotope({
						itemSelector : item_selector,
						resizable : false,
						layout : 'masonry',
						masonry : {
							columnWidth : larg
						}
					});
					resized = true;
					break;
				}
			}
			if (resized == false) { // initial values
				$isotope.find(item_selector).each(function(i) {
					// width
					var item_data_columns = parseInt($(this).data('columns'));
					var new_width = (100 / isotope_data_columns) * item_data_columns;
					$(this).css("width", new_width + '%');
					// height
					woodkit_resize_gallery_items_height($(this), isotope_data_columns);
				});
				// isotope columnWidth
				var larg = $isotope[0].getBoundingClientRect().width / isotope_data_columns;
				$isotope.isotope({
					itemSelector : item_selector,
					resizable : false,
					layout : 'masonry',
					masonry : {
						columnWidth : larg
					}
				});
			}
		} else {
			$isotope.isotope({
				itemSelector : item_selector,
				layout : 'masonry',
				masonry : {
					columnWidth : 1
				}
			});
		}
	}

	/**
	 * CLASSIC GALLERY RESPONSIVE FUNCTION
	 */
	function woodkit_resize_classic_items($classic, item_selector) {
		var classic_matrice = woodkit_resize_gallery_matrix();
		var classic_data_columns = parseInt($classic.data('columns'));
		if (isset(classic_data_columns) && !isNaN(classic_data_columns)) {
			var resized = false;
			for ( var window_size in classic_matrice) {
				if (classic_matrice.hasOwnProperty(window_size) && $(window).width() < parseInt(window_size)) {
					var window_matrice = classic_matrice[window_size];
					if (window_matrice.hasOwnProperty(classic_data_columns)) {
						var columns_matrice = window_matrice[classic_data_columns];
						$classic.find(item_selector).each(function(i) {
							// width
							var item_data_columns = parseInt($(this).data('columns'));
							if (columns_matrice.hasOwnProperty(item_data_columns)) {
								var new_width = columns_matrice[item_data_columns];
								$(this).css("width", new_width);
							}
							// height
							woodkit_resize_gallery_items_height($(this), window_matrice.columns);
						});
					}
					// isotope columnWidth
					var larg = $classic[0].getBoundingClientRect().width / window_matrice.columns;
					$classic.isotope({
						itemSelector : item_selector,
						resizable : false,
						layout : 'masonry',
						masonry : {
							columnWidth : larg
						}
					});
					resized = true;
					break;
				}
			}
			if (resized == false) { // initial values
				$classic.find(item_selector).each(function(i) {
					// width
					var item_data_columns = parseInt($(this).data('columns'));
					var new_width = (100 / classic_data_columns) * item_data_columns;
					$(this).css("width", new_width + '%');
					// height
					woodkit_resize_gallery_items_height($(this), classic_data_columns);
				});
				// isotope columnWidth
				var larg = $classic[0].getBoundingClientRect().width / classic_data_columns;
				$classic.isotope({
					itemSelector : item_selector,
					resizable : false,
					layout : 'masonry',
					masonry : {
						columnWidth : larg
					}
				});
			}
		} else {
			$classic.isotope({
				itemSelector : item_selector,
				layout : 'masonry',
				masonry : {
					columnWidth : 1
				}
			});
		}
	}

	/**
	 * ISOTOPE & MASONRY & CLASSIC GALLERY HEIGHT RESIZING
	 */
	function woodkit_resize_gallery_items_height($gallery_item, gallery_columns) {
		if ($gallery_item.data("autoresponsive") != true) {
			var item_width = $gallery_item[0].getBoundingClientRect().width;
			var ratio_width_height = $gallery_item.data('ratio-width-height'); // masonry only
			if (!empty(ratio_width_height)) {
				$gallery_item.css("height", Math.ceil(parseInt(item_width) * parseFloat(ratio_width_height)) + "px");
			} else {
				var format = $gallery_item.data('format'); // isotope only
				var lines = $gallery_item.data('lines'); // isotope only
				var columns = $gallery_item.data('columns'); // isotope only
				var height = 0;
				if (empty(format)) {
					format = "square";
				}
				if (empty(lines)) {
					lines = 1;
				}
				if (empty(columns) || columns == 0) {
					columns = 1;
				}
				if (columns > gallery_columns) {
					columns = gallery_columns;
				}
				var width_unite = item_width / columns;
				if (format == "portrait") {
					height = (width_unite * gold_number) * lines;
				} else if (format == "landscape") {
					height = (width_unite / gold_number) * lines;
				} else {
					height = width_unite * lines;
				}
				if (height != 0) {
					$gallery_item.css("height", Math.ceil(height) + "px");
				}
			}
		}
	}
	
	/**
	 * UPDATE ISOTOPE & MASONRY & CLASSIC GALLERY
	 */
	function woodkit_refresh_galleries() {
		$(".isotope[data-columns]").each(function(i) {
			woodkit_resize_isotope_items($(this), '.isotope-item');
		});
		$(".masonry[data-columns]").each(function(i) {
			woodkit_resize_isotope_items($(this), '.masonry-item');
		});
		$(".classic[data-columns]").each(function(i) {
			woodkit_resize_classic_items($(this), '.classic-item');
		});
	}

	/**
	 * ISOTOPE & MASONRY & CLASSIC GALLERY ON WIDOW RESIZE
	 */
	var woodkit_resize_gallery_timer = null;
	$(window).resize(function() {
		clearTimeout(woodkit_resize_gallery_timer);
		woodkit_resize_gallery_timer = setTimeout(woodkit_refresh_galleries, 300);
	});

	/**
	 * ISOTOPE & MASONRY & CLASSIC GALLERY ON WIDOW RESIZE
	 */
	$(window).load(function() {
		woodkit_refresh_galleries();
	});

	/**
	 * ISOTOPE & MASONRY GALLERY INIT - LISTEN TRIGGER EVENT 'gallery-isotope-ready'
	 */
	$(document).on('gallery-isotope-ready', function(e, $isotope, item_selector) {
		woodkit_resize_isotope_items($isotope, item_selector);
	});

	/**
	 * CLASSIC GALLERY INIT - LISTEN TRIGGER EVENT 'gallery-classic-ready'
	 */
	$(document).on('gallery-classic-ready', function(e, $classic, item_selector) {
		woodkit_resize_classic_items($classic, item_selector);
	});

})(jQuery);