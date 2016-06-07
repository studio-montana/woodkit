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
 * Register shortcode to TinyMce
*/
function tool_googlemaps_shortcode_init() {
	if (tool_googlemaps_shortcode_has_permissions() && tool_googlemaps_shortcode_is_edit_screen()) {
		add_filter('mce_external_plugins', 'tool_googlemaps_shortcode_tiny_mce_plugins');
		add_filter('mce_buttons', 'tool_googlemaps_shortcode_tiny_mce_plugins_buttons');
	}
}
add_action('init', 'tool_googlemaps_shortcode_init');

/**
 * Register mce plugin button
*/
function tool_googlemaps_shortcode_tiny_mce_plugins_buttons($buttons) {
	$buttons[] = 'toolgooglemapsshortcode';
	return $buttons;
}
add_filter('mce_buttons', 'tool_googlemaps_shortcode_tiny_mce_plugins_buttons');

/**
 * Register mce plugin javascript
*/
function tool_googlemaps_shortcode_tiny_mce_plugins($plugin_array) {
	$plugin_array['toolgooglemapsshortcode'] = WOODKIT_PLUGIN_URI.WOODKIT_PLUGIN_TOOLS_FOLDER.GOOGLEMAPS_TOOL_NAME.'/shortcode/shortcode.js';
	return $plugin_array;
}

/**
 * Register external javascript
 */
function tool_googlemaps_shortcode_admin_head() {
	if (tool_googlemaps_shortcode_has_permissions() && tool_googlemaps_shortcode_is_edit_screen()) {
		?>
<script type='text/javascript'>
		var tool_googlemaps_shortcode = null;
		function tool_googlemaps_shortcode_open(ed, ed_selection, on_googlemaps_generated){
			if (tool_googlemaps_shortcode == null) {
				tool_googlemaps_shortcode = jQuery("body").googlemapsgenerator({
					ondone: function(id, adress, title, zoom, type, width, height, style){
						on_googlemaps_generated.call(null, ed, ed_selection, id, adress, title, zoom, type, width, height, style);
					}
				});
				tool_googlemaps_shortcode.open();
			} else {
				tool_googlemaps_shortcode.options({
					ondone: function(id, adress, title, zoom, type, width, height, style){
						on_googlemaps_generated.call(null, ed, ed_selection, id, adress, title, zoom, type, width, height, style);
					}
				});
				tool_googlemaps_shortcode.open();
			}
		}
</script>
<?php
	}
}
add_action('admin_head', 'tool_googlemaps_shortcode_admin_head');

/**
 * Make shortcode
*/
function tool_googlemaps_shortcode($atts, $content = null, $name='') {
	$atts = shortcode_atts( array(
			"id"		=> '',
			"adress"	=> '',
			"title"		=> '',
			"type"		=> '',
			"zoom"		=> '',
			"width"		=> '',
			"height"	=> '',
			"style"		=> ''
	), $atts );
	$id = sanitize_text_field($atts['id']);
	$adress = sanitize_text_field($atts['adress']);
	$title = sanitize_text_field($atts['title']);
	$width = sanitize_text_field($atts['width']);
	$height = sanitize_text_field($atts['height']);
	$style = sanitize_text_field($atts['style']);
	$zoom = sanitize_text_field($atts['zoom']);
	$type = "google.maps.MapTypeId.".sanitize_text_field($atts['type']);
	ob_start();
	?>
	<div style="overflow:hidden; width:<?php echo $width; ?>; height:<?php echo $height; ?>;">
		<div id='<?php echo $id; ?>' class="googlemaps-canvas" style="width:<?php echo $width; ?>; height:<?php echo $height; ?>;"></div>
		<div>
			<small><a href="http://embedgooglemaps.com">google maps carte</a></small>
		</div>
		<div>
			<small><a href="http://youtubeembedcode.com">embed youtube code</a></small>
		</div>
	</div>
	<script type="text/javascript">
		google.maps.event.addDomListener(window, 'load', function(){
			var map = new google.maps.Map(document.getElementById('<?php echo $id; ?>'), {zoom:<?php echo $zoom; ?>, mapTypeId: <?php echo $type; ?>});
			geocode_adress(map, new google.maps.Geocoder(), "<?php echo $adress; ?>", "<?php echo $title; ?>");
		});
	</script>
	<?php
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
add_shortcode('googlemaps', 'tool_googlemaps_shortcode');

/**
 * Is edit screen
*/
function tool_googlemaps_shortcode_is_edit_screen() {
	global $pagenow;
	$allowed_screens = apply_filters('cpsh_allowed_screens', array('post-new.php', 'page-new.php', 'post.php', 'page.php'));
	if (in_array($pagenow, $allowed_screens))
		return true;
	return false;
}

/**
 * has permissions
 */
function tool_googlemaps_shortcode_has_permissions() {
	if (current_user_can('edit_posts') && current_user_can('edit_pages'))
		return true;
	return false;
}
