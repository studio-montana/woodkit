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
 * Register admin scripts on tinymce load
 */
function tool_shortcodes_heightspace_tiny_mce_plugins($plugins) {
	if (tool_shortcodes_heightspace_has_permissions() && tool_shortcodes_heightspace_is_edit_screen()) {
		wp_enqueue_script('tool-shortcodes-script-heightspace', WOODKIT_PLUGIN_URI.WOODKIT_PLUGIN_TOOLS_FOLDER.SHORTCODES_TOOL_NAME.'/heightspace/heightspace.js', array('jquery'), '1.0');
	}
	return $plugins;
}
add_filter('tiny_mce_plugins', 'tool_shortcodes_heightspace_tiny_mce_plugins');

/**
 * Make shortcode
*/
function tool_shortcodes_heightspace($atts, $content = null, $name='') {
	$atts = shortcode_atts( array(
			"height"	=> '36px',
	), $atts );
	$height = sanitize_text_field($atts['height']);
	$output = '<span class="shortcode-heightspace" style=" display: block; width: 100%; height:'.$height.';">'.do_shortcode($content).'</span>';
	return $output;
}
add_shortcode('heightspace', 'tool_shortcodes_heightspace');
add_shortcode('lineheight', 'tool_shortcodes_heightspace'); /* old version compatibility */

/**
 * Is edit screen
*/
function tool_shortcodes_heightspace_is_edit_screen() {
	global $pagenow;
	$allowed_screens = apply_filters('cpsh_allowed_screens', array('post-new.php', 'page-new.php', 'post.php', 'page.php'));
	if (in_array($pagenow, $allowed_screens))
		return true;
	return false;
}

/**
 * has permissions
 */
function tool_shortcodes_heightspace_has_permissions() {
	if (current_user_can('edit_posts') && current_user_can('edit_pages'))
		return true;
	return false;
}

/**
 * Add buttons to TimyMCE
 */
function tool_shortcodes_heightspace_add_editor_buttons() {
	if (!tool_shortcodes_heightspace_has_permissions() || !tool_shortcodes_heightspace_is_edit_screen())
		return false;
	add_action('media_buttons', 'tool_shortcodes_heightspace_add_button', 100);
}
add_action('admin_init', 'tool_shortcodes_heightspace_add_editor_buttons');

/**
 * Add shortcode button to TimyMCE
*/
function tool_shortcodes_heightspace_add_button($id_editor = null) {
	?>
<span class="tool-shortcodes-insert-shortcode tool-shortcodes-heightspace-insert-shortcode button"
	title="<?php _e('Height Space', WOODKIT_PLUGIN_TEXT_DOMAIN); ?>"
	data-id-editor="<?php echo $id_editor; ?>">
	<i class="fa fa-arrows-v"></i>
</span>
<?php
}