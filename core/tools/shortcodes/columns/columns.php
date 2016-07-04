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

require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_TOOLS_FOLDER.SHORTCODES_TOOL_NAME.'/columns/columnspicker/columnspicker.php');

/**
 * Register shortcode to TinyMce
*/
function tool_shortcodes_columns_init() {
	if (tool_shortcodes_columns_has_permissions() && tool_shortcodes_columns_is_edit_screen()) {
		add_filter('mce_external_plugins', 'tool_shortcodes_columns_tiny_mce_plugins');
		add_filter('mce_buttons', 'tool_shortcodes_columns_tiny_mce_plugins_buttons');
	}
}
add_action('init', 'tool_shortcodes_columns_init');

/**
 * Register mce plugin button
*/
function tool_shortcodes_columns_tiny_mce_plugins_buttons($buttons) {
	$buttons[] = 'toolshortcodescolumns';
	return $buttons;
}
add_filter('mce_buttons', 'tool_shortcodes_columns_tiny_mce_plugins_buttons');

/**
 * Register mce plugin javascript
*/
function tool_shortcodes_columns_tiny_mce_plugins($plugin_array) {
	$plugin_array['toolshortcodescolumns'] = WOODKIT_PLUGIN_URI.WOODKIT_PLUGIN_TOOLS_FOLDER.SHORTCODES_TOOL_NAME.'/columns/columns.js';
	return $plugin_array;
}

/**
 * Register external javascript
 */
function tool_shortcodes_columns_admin_head() {
	if (tool_shortcodes_columns_has_permissions() && tool_shortcodes_columns_is_edit_screen()) {
		?>
<script type='text/javascript'>
		var tool_shortcode_columnspicker = null;
		function tool_shortcode_columns_open_columnspicker(ed, ed_selection, on_columnspick){
			if (tool_shortcode_columnspicker == null) {
				tool_shortcode_columnspicker = jQuery("body").columnspicker({
					onpick: function(columns, style){
						on_columnspick.call(null, ed, ed_selection, columns, style);
					}
				});
				tool_shortcode_columnspicker.open();
			} else {
				tool_shortcode_columnspicker.options({
					onpick: function(columns, style){
						on_columnspick.call(null, ed, ed_selection, columns, style);
					}
				});
				tool_shortcode_columnspicker.open();
			}
		}
</script>
<?php
	}
}
add_action('admin_head', 'tool_shortcodes_columns_admin_head');

/**
 * Make shortcode
*/
function tool_shortcodes_columns($atts, $content = null, $name='') {
	$atts = shortcode_atts( array(
			"class"	=> '',
			"style"	=> ''
	), $atts );
	$init_name = $name;
	if (endsWith($name, "_last")){
		$name = str_replace("_last", "", $name);
	}
	$style = sanitize_text_field($atts['style']);
	$class = "shortcode-columns ".$name." ".sanitize_text_field($atts['class']);
	$output = '<div class="'.$class.'" style="'.$style.'"><div class="shortcode-columns-content">'.do_shortcode($content).'</div></div>';
	if (endsWith($init_name, "_last")){
		$output .= '<div class="shortcode-columns col_clear"></div>';
	}
	$output = str_replace("<p></div>", "</div>", $output);
	$output = str_replace("<p><div", "<div", $output);
	$output = str_replace("</div></p>", "</div>", $output);
	$output = str_replace('<div class="shortcode-columns-content"></p>', '<div class="shortcode-columns-content">', $output);
	trace_info("outut : ".$output);
	return $output;
}
add_shortcode('col_one', 'tool_shortcodes_columns');
add_shortcode('col_one_half', 'tool_shortcodes_columns');
add_shortcode('col_one_half_last', 'tool_shortcodes_columns');
add_shortcode('col_one_third', 'tool_shortcodes_columns');
add_shortcode('col_one_third_last', 'tool_shortcodes_columns');
add_shortcode('col_one_fourth', 'tool_shortcodes_columns');
add_shortcode('col_one_fourth_last', 'tool_shortcodes_columns');
add_shortcode('col_two_third', 'tool_shortcodes_columns');
add_shortcode('col_two_third_last', 'tool_shortcodes_columns');
add_shortcode('col_three_fourth', 'tool_shortcodes_columns');
add_shortcode('col_three_fourth_last', 'tool_shortcodes_columns');
add_shortcode('col_one_fifth', 'tool_shortcodes_columns');
add_shortcode('col_one_fifth_last', 'tool_shortcodes_columns');
add_shortcode('col_two_fifth', 'tool_shortcodes_columns');
add_shortcode('col_two_fifth_last', 'tool_shortcodes_columns');
add_shortcode('col_three_fifth', 'tool_shortcodes_columns');
add_shortcode('col_three_fifth_last', 'tool_shortcodes_columns');
add_shortcode('col_four_fifth', 'tool_shortcodes_columns');
add_shortcode('col_four_fifth_last', 'tool_shortcodes_columns');
add_shortcode('col_one_sixth', 'tool_shortcodes_columns');
add_shortcode('col_one_sixth_last', 'tool_shortcodes_columns');
add_shortcode('col_five_sixth', 'tool_shortcodes_columns');
add_shortcode('col_five_sixth_last', 'tool_shortcodes_columns');

/**
 * Is edit screen
*/
function tool_shortcodes_columns_is_edit_screen() {
	global $pagenow;
	$allowed_screens = apply_filters('cpsh_allowed_screens', array('post-new.php', 'page-new.php', 'post.php', 'page.php'));
	if (in_array($pagenow, $allowed_screens))
		return true;
	return false;
}

/**
 * has permissions
 */
function tool_shortcodes_columns_has_permissions() {
	if (current_user_can('edit_posts') && current_user_can('edit_pages'))
		return true;
	return false;
}
