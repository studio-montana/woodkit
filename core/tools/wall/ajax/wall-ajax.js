/**
 * WALL Tool
 * @package WordPress
 * @subpackage Woodkit
 * @since Woodkit 1.0
 * @author Sébastien Chandonay www.seb-c.com / Cyril Tissot www.cyriltissot.com
 */

function get_wall_presentation_results(
		meta_wall_display_current_post_id, 
		meta_wall_display_post_type, 
		meta_wall_display_ids, 
		meta_wall_display_tax, 
		meta_wall_display_term_slug, 
		meta_wall_display_orderby, 
		meta_wall_display_order, 
		meta_wall_display_number, 
		meta_wall_display_parent, 
		meta_wall_display_presentation, 
		meta_wall_display_presentation_filtering, 
		meta_wall_display_presentation_slider_autoplay, 
		meta_wall_display_presentation_slider_thumb_nav,
		meta_wall_display_presentation_slider_carousel,
		meta_wall_display_presentation_slider_carousel_columns,
		meta_wall_display_presentation_slider_carousel_item_width, 
		meta_wall_display_presentation_slider_carousel_item_margin,
		meta_wall_display_presentation_setup, 
		meta_wall_display_presentation_columns, 
		meta_wall_display_presentation_initial_height, 
		meta_wall_display_presentation_format, 
		meta_wall_display_presentation_masonry_width,  
		meta_wall_display_presentation_masonry_width_customized, 
		meta_wall_display_presentation_masonry_height,
		meta_wall_display_presentation_margin_vertical,
		meta_wall_display_presentation_margin_horizontal, 
		success, 
		failure) {
	jQuery.post(GalleryAjax.ajaxUrl, {
		'action' : 'get_wall_presentation_results',
		'ajaxNonce' : GalleryAjax.ajaxNonce,
		'meta_wall_display_current_post_id' : meta_wall_display_current_post_id,
		'meta_wall_display_post_type' : meta_wall_display_post_type,
		'meta_wall_display_ids' : meta_wall_display_ids,
		'meta_wall_display_tax' : meta_wall_display_tax,
		'meta_wall_display_term_slug' : meta_wall_display_term_slug,
		'meta_wall_display_orderby' : meta_wall_display_orderby,
		'meta_wall_display_order' : meta_wall_display_order,
		'meta_wall_display_number' : meta_wall_display_number,
		'meta_wall_display_parent' : meta_wall_display_parent,
		'meta_wall_display_presentation' : meta_wall_display_presentation,
		'meta_wall_display_presentation_filtering' : meta_wall_display_presentation_filtering,
		'meta_wall_display_presentation_slider_autoplay' : meta_wall_display_presentation_slider_autoplay,
		'meta_wall_display_presentation_slider_thumb_nav' : meta_wall_display_presentation_slider_thumb_nav,
		'meta_wall_display_presentation_slider_carousel' : meta_wall_display_presentation_slider_carousel,
		'meta_wall_display_presentation_slider_carousel_columns' : meta_wall_display_presentation_slider_carousel_columns,
		'meta_wall_display_presentation_slider_carousel_item_width' : meta_wall_display_presentation_slider_carousel_item_width,
		'meta_wall_display_presentation_slider_carousel_item_margin' : meta_wall_display_presentation_slider_carousel_item_margin,
		'meta_wall_display_presentation_setup' : meta_wall_display_presentation_setup,
		'meta_wall_display_presentation_columns' : meta_wall_display_presentation_columns,
		'meta_wall_display_presentation_initial_height' : meta_wall_display_presentation_initial_height,
		'meta_wall_display_presentation_format' : meta_wall_display_presentation_format,
		'meta_wall_display_presentation_masonry_width' : meta_wall_display_presentation_masonry_width,
		'meta_wall_display_presentation_masonry_width_customized' : meta_wall_display_presentation_masonry_width_customized,
		'meta_wall_display_presentation_masonry_height' : meta_wall_display_presentation_masonry_height,
		'meta_wall_display_presentation_margin_vertical' : meta_wall_display_presentation_margin_vertical,
		'meta_wall_display_presentation_margin_horizontal' : meta_wall_display_presentation_margin_horizontal
	}, function(response) {
		success.call(null, response);
	}).fail(function() {
		failure.call(null);
	}).always(function() {
	});
}

function get_wall_element(
		wall_element_id,
		success, 
		failure) {
	jQuery.post(GalleryAjax.ajaxUrl, {
		'action' : 'get_wall_element',
		'ajaxNonce' : GalleryAjax.ajaxNonce,
		'wall_element_id' : wall_element_id
	}, function(response) {
		success.call(null, response);
	}).fail(function() {
		failure.call(null);
	}).always(function() {
	});
}