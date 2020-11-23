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
 * Enqueue scripts/styles for the back end.
*/
add_action('admin_enqueue_scripts', function () {
	wp_enqueue_style('tool-tracking-googleanalyticseventsmanager-css', WOODKIT_PLUGIN_URI.WOODKIT_PLUGIN_TOOLS_FOLDER.TRACKING_TOOL_NAME.'/js-googleanalyticseventsmanager/css/admin-googleanalyticseventsmanager.css', array(), WOODKIT_PLUGIN_WEB_CACHE_VERSION);
	wp_enqueue_script('tool-tracking-googleanalyticseventsmanager-js', WOODKIT_PLUGIN_URI.WOODKIT_PLUGIN_TOOLS_FOLDER.TRACKING_TOOL_NAME.'/js-googleanalyticseventsmanager/js/admin-googleanalyticseventsmanager.js', array('jquery'), WOODKIT_PLUGIN_WEB_CACHE_VERSION, true);
}, 100);

/**
 * WP_Head hook
 *
 * @since Woodkit 1.0
 * @return void
*/
function tool_tracking_wp_head() {
	$googleanalytics_code = $GLOBALS['woodkit']->tools->get_tool_option(TRACKING_TOOL_NAME, 'googleanalytics-code');
	$googleanalytics_gtag_code = $GLOBALS['woodkit']->tools->get_tool_option(TRACKING_TOOL_NAME, 'gtag-code');
	$googleanalytics_googletagmanager_code = $GLOBALS['woodkit']->tools->get_tool_option(TRACKING_TOOL_NAME, 'googletagmanager-code');
	if (!empty($googleanalytics_gtag_code)){
		?>
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $googleanalytics_gtag_code; ?>"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());
		  gtag('config', '<?php echo $googleanalytics_gtag_code; ?>');
		</script>
		<!-- End Global site tag (gtag.js) - Google Analytics -->
		<?php
	}else if (!empty($googleanalytics_googletagmanager_code)){
		?>
		<!-- Google Tag Manager -->
		<script>
			(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','<?php echo $googleanalytics_googletagmanager_code; ?>');
		</script>
		<!-- End Google Tag Manager -->
		<?php
	}else if (!empty($googleanalytics_code)){
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
			function woodkit_tool_tracking_event_tracking(eventCategory, eventAction, eventLabel){
				ga('send', 'event', eventCategory, eventAction, eventLabel);
			}
		</script>
		<!-- End Google Analytics -->
		<?php
	}
}
add_action('wp_head', 'tool_tracking_wp_head');

/**
 * WP_Head hook
 *
 * @since Woodkit 1.0
 * @return void
 */
function tool_tracking_wp_footer() {
	$googleanalytics_code = $GLOBALS['woodkit']->tools->get_tool_option(TRACKING_TOOL_NAME, 'googleanalytics-code');
	$googleanalytics_googletagmanager_code = $GLOBALS['woodkit']->tools->get_tool_option(TRACKING_TOOL_NAME, 'googletagmanager-code');
	if (empty($googleanalytics_googletagmanager_code) && !empty($googleanalytics_code)){
		?>
		<!-- Google Analytics Events Tracking -->
		<script>
			<?php $events = $GLOBALS['woodkit']->tools->get_tool_option(TRACKING_TOOL_NAME, "googleanalytics-events");	
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
								woodkit_tool_tracking_event_tracking("<?php echo $category; ?>", "<?php echo $action; ?>", "<?php echo $name; ?>");
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
add_action('wp_footer', 'tool_tracking_wp_footer', 1);

function tool_tracking_wp_start_body(){
	/** Google Tag Manager */
	$googleanalytics_googletagmanager_code = $GLOBALS['woodkit']->tools->get_tool_option(TRACKING_TOOL_NAME, 'googletagmanager-code');
	if (!empty($googleanalytics_googletagmanager_code)){
		?>
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $googleanalytics_googletagmanager_code; ?>"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
		<?php
	}
}
add_action('wp_start_body', 'tool_tracking_wp_start_body', 1);