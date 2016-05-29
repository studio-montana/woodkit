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

function tool_wip_is_active($active){
	return true;
}
add_filter("woodkit_is_tool_wip_active", "tool_wip_is_active", 1, 1);

function tool_wip_get_config_options_section_description(){
	echo '<p class="tool-description">';
	printf( '%s, <a class="field-info" href="'.esc_url(get_admin_url(null, 'customize.php')).'">%s</a>', __("close your site for maintenance or update. Customize wip page appearence", WOODKIT_PLUGIN_TEXT_DOMAIN), __("manage here ", WOODKIT_PLUGIN_TEXT_DOMAIN));
	echo '</p>';
}

function tool_wip_get_config_options_section_documentation_url(){
	return WOODKIT_URL_DOCUMENTATION.'/wip';
}