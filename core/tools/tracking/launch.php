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
function tool_tracking_woodkit_admin_enqueue_styles_tools($dependencies) {

	$css_googleanalyticseventsmanager = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.TRACKING_TOOL_NAME.'/js-googleanalyticseventsmanager/css/admin-googleanalyticseventsmanager.css');
	if (!empty($css_googleanalyticseventsmanager))
		wp_enqueue_style('tool-tracking-googleanalyticseventsmanager-css', $css_googleanalyticseventsmanager, $dependencies, '1.1');

	$js_googleanalyticseventsmanager = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.TRACKING_TOOL_NAME.'/js-googleanalyticseventsmanager/js/admin-googleanalyticseventsmanager.js');
	if (!empty($js_googleanalyticseventsmanager))
		wp_enqueue_script('tool-tracking-googleanalyticseventsmanager-js', $js_googleanalyticseventsmanager, array('jquery'), '1.1', true);

	$css_facebookpixeleventsmanager = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.TRACKING_TOOL_NAME.'/js-facebookpixeleventsmanager/css/admin-facebookpixeleventsmanager.css');
	if (!empty($css_facebookpixeleventsmanager))
		wp_enqueue_style('tool-tracking-facebookpixeleventsmanager-css', $css_facebookpixeleventsmanager, $dependencies, '1.1');

	$js_facebookpixeleventsmanager = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.TRACKING_TOOL_NAME.'/js-facebookpixeleventsmanager/js/admin-facebookpixeleventsmanager.js');
	if (!empty($js_facebookpixeleventsmanager))
		wp_enqueue_script('tool-tracking-facebookpixeleventsmanager-js', $js_facebookpixeleventsmanager, array('jquery'), '1.1', true);
}
add_action('woodkit_admin_enqueue_styles_tools', 'tool_tracking_woodkit_admin_enqueue_styles_tools');

/**
 * WP_Head hook
 *
 * @since Woodkit 1.0
 * @return void
*/
function tool_tracking_wp_head() {
	$googleanalytics_code = woodkit_get_tool_option(TRACKING_TOOL_NAME, 'googleanalytics-code');
	$googleanalytics_googletagmanager_code = woodkit_get_tool_option(TRACKING_TOOL_NAME, 'googletagmanager-code');
	
	if (!empty($googleanalytics_code) || !empty($googleanalytics_googletagmanager_code)){
		$is_gtag = startsWith($googleanalytics_code, 'G-');
		if ($is_gtag) { ?>
			<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $googleanalytics_code; ?>"></script>
		<?php } ?>
		<!-- Woodkit Tracking Helpers - based on RGPD cookie compliance -->
		<script>
			const woodkit_tool_tracking_cookies = {
					'cookies-accept-condition' : 'true', // RGPD cookie compliance from Woodkit plugin
					'cookielawinfo-checkbox-analytics' : 'yes', // RGPD cookie compliance from GDPR Cookie Concent plugin
			}
			let woodkit_tool_tracking_launched = false;
	
			function woodkit_tool_tracking_launch() {
				if (!woodkit_tool_tracking_launched) {
					woodkit_tool_tracking_launched = true;
					<?php if(!empty($googleanalytics_code) && $is_gtag) { ?>
						console.log('woodkit launch GTAG');
						<!-- Google tag (gtag.js) -->
						  window.dataLayer = window.dataLayer || [];
						  function gtag(){dataLayer.push(arguments);}
						  gtag('js', new Date());
						  gtag('config', '<?php echo $googleanalytics_code; ?>');
					<?php } else if (!empty($googleanalytics_code)) { ?>
						console.log('woodkit launch GA');
						(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
						(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
						m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
						})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
						ga('create', '<?php echo $googleanalytics_code; ?>', 'auto');
						ga('send', 'pageview');
					<?php } else if (!empty($googleanalytics_googletagmanager_code)){ ?>
						console.log('woodkit launch GTM');
						(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
						new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
						j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
						'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
						})(window,document,'script','dataLayer','<?php echo $googleanalytics_googletagmanager_code; ?>');
					<?php } ?>
				}
			}			
	
			function woodkit_tool_tracking_listen_cookie_change(callback, interval = 1000) {
				let lastCookie = document.cookie;
				setInterval(()=> {
					let cookie = document.cookie;
					if (cookie !== lastCookie) {
						try {
							callback({oldValue: lastCookie, newValue: cookie});
						} finally {
							lastCookie = cookie;
						}
					}
				}, interval);
			}
	
			function woodkit_tool_tracking_get_cookie(cname) {
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

			function woodkit_tool_tracking_is_allowed_by_cookie() {
				let allowed = false;
				for (const cookie_name in woodkit_tool_tracking_cookies) {
					// console.log('woodkit_tool_tracking_cookie \''+cookie_name+'\' : ', woodkit_tool_tracking_get_cookie(cookie_name));
					if (woodkit_tool_tracking_get_cookie(cookie_name) == woodkit_tool_tracking_cookies[cookie_name]) {
						allowed = true;
						break;
					}
				}
				return allowed;
			}
		</script>
		<!-- End Google Tag Manager -->
		<?php
	} ?>
	
	<!-- Google Analytics / Google Tag Manager -->
	<script>

		if (woodkit_tool_tracking_is_allowed_by_cookie()) {
			woodkit_tool_tracking_launch();
		} else {
			woodkit_tool_tracking_listen_cookie_change(({oldValue, newValue})=> {
				if (woodkit_tool_tracking_is_allowed_by_cookie()) {
					woodkit_tool_tracking_launch();
				}
			}, 1000);
		}

		<?php if (!empty($googleanalytics_code) && $is_gtag){ ?>
		/** GTAG Event Tracking */
		function woodkit_tool_tracking_event_tracking(eventCategory, eventAction, eventLabel){
			gtag('send', 'event', eventCategory, eventAction, eventLabel);
		}
		<?php } else if (!empty($googleanalytics_code)){ ?>
		/** Google Analytics Event Tracking */
		function woodkit_tool_tracking_event_tracking(eventCategory, eventAction, eventLabel){
			ga('send', 'event', eventCategory, eventAction, eventLabel);
		}
		<?php } ?>
	</script>
	<!-- End Google Analytics / Google Tag Manager -->
	
	<?php
	/** FaceBook Pixel */
	$facebook_pixel = woodkit_clean_php_to_javascript_var(woodkit_get_tool_option(TRACKING_TOOL_NAME, 'facebook-pixel'));
	if (!empty($facebook_pixel)){
		echo $facebook_pixel;
	}
}
add_action('wp_head', 'tool_tracking_wp_head', 1);

/**
 * WP_Head hook
 *
 * @since Woodkit 1.0
 * @return void
 */
function tool_tracking_wp_footer() {
	$googleanalytics_code = woodkit_get_tool_option(TRACKING_TOOL_NAME, 'googleanalytics-code');
	$googleanalytics_googletagmanager_code = woodkit_get_tool_option(TRACKING_TOOL_NAME, 'googletagmanager-code');
	if (empty($googleanalytics_googletagmanager_code) && !empty($googleanalytics_code)){
		?>
		<!-- Google Analytics Events Tracking -->
		<script>
			<?php $events = woodkit_get_tool_option(TRACKING_TOOL_NAME, "googleanalytics-events");			
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
	$googleanalytics_googletagmanager_code = woodkit_get_tool_option(TRACKING_TOOL_NAME, 'googletagmanager-code');
	if (!empty($googleanalytics_googletagmanager_code)){
		?>
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $googleanalytics_googletagmanager_code; ?>"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
		<?php
	}
	/** FaceBook Pixel */
	$facebook_pixel = woodkit_get_tool_option(TRACKING_TOOL_NAME, 'facebook-pixel');	
	$facebook_pixel_events = woodkit_get_tool_option(TRACKING_TOOL_NAME, "facebook-pixel-events");
	if (!empty($facebook_pixel) && !empty($facebook_pixel_events)){
		foreach ($facebook_pixel_events as $facebook_pixel_event){
			if (!empty($facebook_pixel_event['url']) && !empty($facebook_pixel_event['code'])){
				if (!empty($facebook_pixel_event['parameters']) && $facebook_pixel_event['parameters'] == 'on'){
					$current_url = get_current_url(true);
					$pixel_event_url = $facebook_pixel_event['url'];
				}else{
					$current_url = trim(get_current_url(false), '/');
					$pixel_event_url = trim($facebook_pixel_event['url'], '/');
				}
				if ($current_url == $pixel_event_url){
					echo woodkit_clean_php_to_javascript_var($facebook_pixel_event['code']);
				}
			}
		}
	}
}
add_action('wp_start_body', 'tool_tracking_wp_start_body', 1);
