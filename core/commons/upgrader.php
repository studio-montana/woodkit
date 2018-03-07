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

function woodkit_upgrader_admin_init(){

	$upgrader_version = get_option("woodkit-upgrader-version", "0.0.0");

	/**
	 * Upgrade to 1.3.0
	 */
	if (version_compare($upgrader_version, "1.3.0") < 0){
		woodkit_upgrader_version_1_3_0();
		update_option("woodkit-upgrader-version", "1.3.0");
	}

}
add_action('admin_init', 'woodkit_upgrader_admin_init');

/**
 * Migrate all old tool options in new format
 * Since 1.3.0 tool options format is : array('tool_slug' => array('option1' => 'value1', 'option2' => 'value2', ...), 'tool_slug' => array('option1' => 'value1', 'option2' => 'value2', ...))
 */
function woodkit_upgrader_version_1_3_0(){
	trace_info("==============================================================");
	trace_info("=======================UPGRADE 1.3.0==========================");
	trace_info("==============================================================");
	/**
	 * Options in Woodkit options
	 */
	$tool_options = array (
			'backgroundimage' => array (
					'tool-backgroundimage-active',
					'tool-backgroundimage-auto-insert'
			),
			'breadcrumb' => array (
					'tool-breadcrumb-active'
			),
			'display' => array (
					'tool-display-active'
			),
			'event' => array (
					'tool-event-active'
			),
			'excerpt' => array (
					'tool-excerpt-active',
					'tool-excerpt-editor-autop'
			),
			'fancybox' => array (
					'tool-fancybox-active',
					'tool-fancybox-wordpress-contents'
			),
			'favicon' => array (
					'tool-favicon-active'
			),
			'googleanalytics' => array (
					'tool-googleanalytics-active',
					'tool-googleanalytics-code',
					'tool-googleanalytics-googletagmanager-code',
					'woodkit-tool-googleanalytics-options-events',
			),
			'googlemaps' => array (
					'tool-googlemaps-active',
					'tool-googlemaps-apikey',
					'tool-googlemaps-enqueueapi'
			),
			'login' => array (
					'tool-login-active'
			),
			'logo' => array (
					'tool-logo-active'
			),
			'media' => array (
					'tool-media-active'
			),
			'navigation' => array (
					'tool-navigation-active'
			),
			'pagination' => array (
					'tool-pagination-active',
					'tool-pagination-taxnav-active',
					'tool-pagination-loop-active'
			),
			'portfolio' => array (
					'tool-portfolio-active'
			),
			'private' => array (
					'tool-private-active'
			),
			'secure' => array (
					'tool-secure-captcha-active',
					'tool-secure-failtoban-active',
					'tool-secure-headers-nosniff',
					'tool-secure-headers-xss',
					'tool-secure-headers-frame',
					'tool-secure-headers-referrer',
					'tool-secure-headers-poweredby'
			),
			'seo' => array (
					'tool-seo-active',
					'tool-seo-opengraph-active',
					'tool-seo-xmlsitemap-active',
					'tool-seo-xmlsitemap-notification-active',
					'woodkit-tool-seo-default-description',
					'woodkit-tool-seo-default-keywords',
					'woodkit-tool-seo-options-sitemap-urls',
					'woodkit-tool-seo-options-redirects'
			),
			'shortcodes' => array (
					'tool-shortcodes-active'
			),
			'splashscreen' => array (
					'tool-splashscreen-active',
					'tool-splashscreen-fadeoutspeed'
			),
			'updatenotifier' => array (
					'tool-updatenotifier-active',
					'tool-updatenotifier-emails'
			),
			'video' => array (
					'tool-video-active',
					'tool-video-auto-insert',
					'tool-video-default-width',
					'tool-video-default-height'
			),
			'wall' => array (
					'tool-wall-active',
					'tool-wall-imagesize'
			),
			'widgetmanager' => array (
					'tool-widgetmanager-active'
			)
	);
	foreach ($tool_options as $tool_slug => $options){
		trace_info("===================> tool [{$tool_slug}]");
		$new_tool_options = array();
		foreach ($options as $option){
			$old_option = null;
			$get_default = false;
			if (startsWith($option, "woodkit-tool-")){
				$old_option = get_option($option, 'doesnotexists');
				$option_name = str_replace("woodkit-tool-{$tool_slug}-", "", $option);
				if ($old_option == 'doesnotexists'){
					$old_option = woodkit_get_tool_option_default_value($tool_slug, $option_name);
					$get_default = true;
				}
				$new_tool_options[$option_name] = $old_option;
			}else{
				$old_option = woodkit_get_option($option, 'doesnotexists');
				$option_name = str_replace("tool-{$tool_slug}-", "", $option);
				if ($old_option == 'doesnotexists'){
					$old_option = woodkit_get_tool_option_default_value($tool_slug, $option_name);
					$get_default = true;
				}
				$new_tool_options[$option_name] = $old_option;
			}
			trace_info("= option {$option} (default: {$get_default}) : ".var_export($old_option, true));
		}
		/**
		 * 'googleanalytics' tool renamed to 'tracking'
		 */
		if ($tool_slug == 'googleanalytics'){
			$tool_slug = 'tracking';
			// rename option name 'code' to 'googleanalytics-code'
			if (isset($new_tool_options['code'])){
				$new_tool_options['googleanalytics-code'] = $new_tool_options['code'];
				unset($new_tool_options['code']);
			}
			// rename option name 'options-events' to 'googleanalytics-events'
			if (isset($new_tool_options['options-events'])){
				$new_tool_options['googleanalytics-events'] = $new_tool_options['options-events'];
				unset($new_tool_options['options-events']);
			}
		}
		/**
		 * 'googlemaps' tool renamed to 'maps'
		 */
		if ($tool_slug == 'googlemaps'){
			$tool_slug = 'maps';
			// rename option name 'apikey' to 'googlemaps-apikey'
			if (isset($new_tool_options['apikey'])){
				$new_tool_options['googlemaps-apikey'] = $new_tool_options['apikey'];
				unset($new_tool_options['apikey']);
			}
			// rename option name 'enqueueapi' to 'googlemaps-enqueueapi'
			if (isset($new_tool_options['enqueueapi'])){
				$new_tool_options['googlemaps-enqueueapi'] = $new_tool_options['enqueueapi'];
				unset($new_tool_options['enqueueapi']);
			}	
		}
		
		/**
		 * Save new options for this tool
		 */
		woodkit_save_tool_options($tool_slug, $new_tool_options);
		trace_info("=====> after upgrade options [{$tool_slug}] : ".var_export(woodkit_get_tool_options($tool_slug), true));
	}
	
	/**
	 * add 'activation' option on 'cookies' tool - default => 'on'
	 */
	woodkit_save_tool_options('cookies', array('active' => 'on'));
	
	/**
	 * Fire activation on all activated tools
	 */
	woodkit_tools_fire_activation();
	
	trace_info("==============================================================");
	trace_info("========================END UPGRADE===========================");
	trace_info("==============================================================");
}