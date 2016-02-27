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
 * register JS
 */
function wall_ajax_admin_enqueue_scripts(){
	$wall_ajax_js_file = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.WALL_TOOL_NAME.'/ajax/wall-ajax.js');
	if (!empty($wall_ajax_js_file)){
		wp_enqueue_script('wall-ajax', $wall_ajax_js_file, array('jquery'), "1.0");
		wp_localize_script('wall-ajax', 'GalleryAjax', array(
		'ajaxUrl' => admin_url('admin-ajax.php'),
		'ajaxNonce' => wp_create_nonce('wall-ajax-nonce'),
		)
		);
	}
}
add_action('admin_enqueue_scripts', 'wall_ajax_admin_enqueue_scripts');

/**
 * retrieve configuration's form for wall présentation
*/
function wall_ajax_get_wall_presentation_results() {
	if (!check_ajax_referer('wall-ajax-nonce', 'ajaxNonce', false)){
		die ('Busted!');
	}

	$response = array('what'=>'wall_ajax_get_wall_presentation_results',
			'action'=>'wall_ajax_get_wall_presentation_results',
			'id'=>'1'
	);
	$wall_args = array();
	foreach ($_POST as $k => $v){
		if (startsWith($k, "meta_wall_"))
			$wall_args[$k] = $v;
	}

	ob_start();
	$wall_template = locate_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.WALL_TOOL_NAME.'/templates/tool-wall-display.php');
	if (!empty($wall_template))
		include($wall_template);
	$results = ob_get_contents();
	ob_end_clean();

	$response['data'] = $results;

	$xmlResponse = new WP_Ajax_Response($response);
	$xmlResponse->send();
	exit();
}
add_action('wp_ajax_get_wall_presentation_results', 'wall_ajax_get_wall_presentation_results');
add_action('wp_ajax_nopriv_get_wall_presentation_results', 'wall_ajax_get_wall_presentation_results');