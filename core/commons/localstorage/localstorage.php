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
 * Clear local storage - WARNING : used when WP_DEBUG == true | never in production site | useful to develop Divi Modules
 */
function woodkit_clear_local_storage () {
	wp_enqueue_script('woodkit-clear-local-storage-script', WOODKIT_PLUGIN_URI.WOODKIT_PLUGIN_COMMONS_LOCALSTORAGE_FOLDER.'js/clearlocalstorage.js');
}
if (WP_DEBUG){
	add_action('admin_enqueue_scripts', 'woodkit_clear_local_storage', 9999);
}
