<?php
/**
 * @package Woodkit
 * @author Sébastien Chandonay www.seb-c.com / Cyril Tissot www.cyriltissot.com
 * License: GPL2
 * Text Domain: woodkit
 * 
 * Copyright 2016 Sébastien Chandonay (email : please contact me from my website)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
defined('ABSPATH') or die("Go Away!");

/**
 * Page builder templates (admin)
*/
function woodkit_et_pb_after_page_builder(){
	/**
	 * Font Icons Picker
	 */
	printf(
	'<script type="text/template" id="woodkit-et-builder-font-iconpicker-template">
			<div class="woodkit-et-font-icon">
				%1$s
			</div>
			</script>',
			woodkit_pb_get_font_iconpicker_template()
	);
}
add_action('et_pb_after_page_builder', 'woodkit_et_pb_after_page_builder');

/**
 * Retrieve HTML Font iconpicker template
*/
function woodkit_pb_get_font_iconpicker() {
	$output = is_customize_preview() ? woodkit_pb_get_font_iconpicker_template() : '<%= window.woodkit_et_builder.woodkit_font_iconpicker_template() %>';
	$output = sprintf('<div class="woodkit-et-font-icon">%1$s</div>', $output);
	return $output;
}

/**
 * Retrieve HTML Font iconpicker template part
*/
function woodkit_pb_get_font_iconpicker_template() {
	$output = '<span class="button button-primary" id="woodkit-et-font-icon-choose">'.__("Choose", WOODKIT_PLUGIN_TEXT_DOMAIN).'</span>';
	$output .= '<span id="woodkit-et-font-icon-preview"><i class=""></i></span>';
	return $output;
}
