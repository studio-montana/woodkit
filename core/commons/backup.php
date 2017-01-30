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

if (!function_exists("woodkit_backup_action_admin_menu_config")):
/**
 * Load backup options page on Woodkit submenu
*/
function woodkit_backup_action_admin_menu_config() {
	add_submenu_page("woodkit_options", __("Backup", WOODKIT_PLUGIN_TEXT_DOMAIN), __("Backup", WOODKIT_PLUGIN_TEXT_DOMAIN), "manage_options", "woodkit_options_backup", "woodkit_option_backup");
}
// add_action('admin_menu', 'woodkit_backup_action_admin_menu_config');
endif;

if (!function_exists("woodkit_option_backup")):
/**
 * Load backup options page on Woodkit submenu
*/
function woodkit_option_backup() {
	$return = array();
	// exec("mysqldump --user=... --password=... --host=... DB_NAME > /path/to/output/file.sql", $return);
	// trace_info("MysqlDump : ".var_export($return, true));
}
endif;