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
define('WIP_TOOL_NAME', 'wip');

/**
 * Tool instance
 */
class WoodkitToolWip extends WoodkitTool{
	
	public function __construct(){
		parent::__construct(
				'wip', 									// slug
				__("WIP", 'woodkit'),				// name
				__("Add maintenance page on your website", 'woodkit'),	// description
				false,											// has config page
				false,											// add config page in woodkit submenu
				WOODKIT_URL_DOCUMENTATION.'/wip'			// documentation url
			);
	}
	
	public function get_config_default_values(){
		return array(
				'active' => 'on'
		);
	}
	
}
add_filter("woodkit-register-tool", function($tools){
	$tools[] = new WoodkitToolWip();
	return $tools;
});
