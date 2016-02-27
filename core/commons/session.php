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

add_action('init', 'woodkit_session_start', 1);

/**
 * start the session, after this call the PHP $_SESSION super global is available
*/
function woodkit_session_start() {
	//trace_info("woodkit_session_start");
	if(!session_id())session_start();
}

/**
 * destroy the session
 */
function woodkit_session_destroy() {
	//trace_info("woodkit_session_destroy");
	session_destroy();
}

/**
 * get a value from the session array
 * @param type $key the key in the array
 * @param type $default the value to use if the key is not present. empty string if not present
 * @return type the value found or the default if not found
 */
function woodkit_session_get($key, $default='') {
	//trace_info("woodkit_session_get($key, $default)");
	if(isset($_SESSION[$key]))
		return $_SESSION[$key];
	return $default;
}

/**
 * set a value in the session array
 * @param type $key the key in the array
 * @param type $value the value to set
 */
function woodkit_session_set($key, $value) {
	//trace_info("woodkit_session_set($key, $value)");
	$_SESSION[$key] = $value;
}


/**
 * unset a value in the session array
 * @param type $key the key in the array
 */
function woodkit_session_unset($key) {
	//trace_info("woodkit_session_unset($key)");
	if(isset($_SESSION[$key]))
		unset($_SESSION[$key]);
}
