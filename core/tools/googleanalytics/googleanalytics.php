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
 * Enqueue styles for the back end.
*/
function tool_googleanalytics_woodkit_admin_enqueue_styles_tools($dependencies) {

	$css_googleanalyticseventsmanager = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.GOOGLEANALYTICS_TOOL_NAME.'/js-googleanalyticseventsmanager/css/admin-googleanalyticseventsmanager.css');
	if (!empty($css_googleanalyticseventsmanager))
		wp_enqueue_style('tool-googleanalytics-googleanalyticseventsmanager-css', $css_googleanalyticseventsmanager, $dependencies, '1.0');

	$js_googleanalyticseventsmanager = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.GOOGLEANALYTICS_TOOL_NAME.'/js-googleanalyticseventsmanager/js/admin-googleanalyticseventsmanager.js');
	if (!empty($js_googleanalyticseventsmanager))
		wp_enqueue_script('tool-googleanalytics-googleanalyticseventsmanager-js', $js_googleanalyticseventsmanager, array('jquery'), '1.0', true);
}
add_action('woodkit_admin_enqueue_styles_tools', 'tool_googleanalytics_woodkit_admin_enqueue_styles_tools');

/**
 * WP_Head hook
 *
 * @since Woodkit 1.0
 * @return void
*/
function tool_googleanalytics_wp_head() {
	$googleanalytics_code = woodkit_get_option('tool-googleanalytics-code');
	if (!empty($googleanalytics_code)){
		?>
<!-- Google Analytics -->
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

ga('create', '<?php echo $googleanalytics_code; ?>', 'auto');
ga('send', 'pageview');

/**
 * Google Analytics Event Tracking
 */
function woodkit_tool_googleanalytics_event_tracking(eventCategory, eventAction, eventLabel){
	// console.log("event on "+eventCategory+", "+eventAction+", "+eventLabel);
	ga('send', 'event', eventCategory, eventAction, eventLabel);
}
<?php $events = get_option("woodkit-tool-googleanalytics-options-events", array());
if (!empty($events)){ ?>

// Google Analytics Events 
(function($) {
	$(document).ready(function() {
		<?php
		foreach ($events as $event){
			$selector = str_replace('"', '\"', str_replace('\\\\', '', $event['selector']));
			$name = str_replace('"', '\"', str_replace('\\\\', '', $event['name']));
			$action = str_replace('"', '\"', str_replace('\\\\', '', $event['action']));
			$category = str_replace('"', '\"', str_replace('\\\\', '', $event['category']));
			?>
			$(document).on('click', '<?php echo $selector; ?>', function(e){
				woodkit_tool_googleanalytics_event_tracking("<?php echo $category; ?>", "<?php echo $action; ?>", "<?php echo $name; ?>");
			});
			<?php
		} ?>
	});
})(jQuery);

<?php } ?>

</script>
<!-- End Google Analytics -->
<?php
	}
}
add_action('wp_head', 'tool_googleanalytics_wp_head');