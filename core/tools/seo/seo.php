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
 * REQUIREMENTS
 */
require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_TOOLS_FOLDER.SEO_TOOL_NAME.'/custom-fields/seo.php');
require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_TOOLS_FOLDER.SEO_TOOL_NAME.'/inc/customizer.php');
require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_TOOLS_FOLDER.SEO_TOOL_NAME.'/xmlsitemap/xmlsitemap.php');

/**
 * called after woodkit_setup_theme core function
*/
function tool_seo_setup_theme_action(){

	// seo image sizes
	add_image_size('tool-seo-thumb', 600);

	// can be override
	do_action('after_tool_seo_setup_theme_action');

}
add_action("woodkit_after_setup_theme", "tool_seo_setup_theme_action");