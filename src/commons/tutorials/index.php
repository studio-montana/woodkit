<?php
/**
 Theme Name: BETTI
Author: S. Chandonay - C. Tissot
Author URI: https://www.seb-c.com
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
defined ( 'ABSPATH' ) or die ( "Go Away!" );

/**
 * Plugin tutorials page
 */
if (is_admin ()) {
	
	if (apply_filters('woodkit_enable_tutorials', true) === true) {
		add_action ('admin_menu', function () {
			$page_name = __ ( "Tutorials", 'woodkit' );
			$menu_name = __ ( "Tutorials", 'woodkit' );
			$callback = "woodkit_page_tutorials_callback_function";
			if (function_exists ( $callback )) {
				add_menu_page ( $page_name, $menu_name, "read", "woodkit-tutorials-page", $callback, 'dashicons-welcome-learn-more');
			}
		});
		function woodkit_page_tutorials_callback_function() {
			require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_TUTORIALS_FOLDER.'render.php');
			new WK_Tutorials();
		}
	}
}