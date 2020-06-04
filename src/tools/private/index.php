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
 * Constants
 */
define('PRIVATE_TOOL_NAME', 'private');

/**
 * Tool instance
 */
class WK_Tool_Private extends WK_Tool{

	public function __construct(){
		parent::__construct(array(
				'slug' => 'private',
				'documentation' => WOODKIT_URL_DOCUMENTATION.'/private'
			));
	}

	public function get_name() {
		return __("Private", 'woodkit');
	}

	public function get_description() {
		return __("Make your site private (Intranet), or just few pages", 'woodkit');
	}

	public function launch() {
		require_once ($this->path.'launch.php');
	}

	public function get_config_default_values(){
		return array(
				'active' => 'off'
		);
	}

}
add_filter("woodkit-register-tool", function($tools){
	// $tools[] = new WK_Tool_Private();
	return $tools;
});
