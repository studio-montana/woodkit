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

require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_TOOLS_FOLDER.'tool.class.php');

class ToolsManager {
	
	private $tools = array();
	private $tools_activated = array();
	
	public function __construct() {
		/** load tools */
		$this->load();
		
		/** display menu admin config menu */
		add_action('admin_menu', array($this, 'add_config_menu'));
	}
	
	/**
	 * Load tools from active theme (including parent theme if exists) first and from current plugin (core) in second
	 * Note that themes's tools override core tools if they use same slug or same folder name
	 */
	private function load () {
		$this->tools = array();
		$this->tools_activated = array();
		$tools_paths = array();
		/** active theme tools path (including parent theme if exists) */
		$theme = wp_get_theme();
		if ($theme) {
			if (!empty($theme->theme_root) && !empty($theme->stylesheet)) {
				$tools_paths[] = $theme->theme_root.'/'.$theme->stylesheet.'/'.WOODKIT_PLUGIN_TOOLS_FOLDER;
			}
			if (!empty($theme->theme_root) && !empty($theme->template) && $theme->stylesheet !== $theme->template) {
				$tools_paths[] =$theme->theme_root.'/'.$theme->template.'/'.WOODKIT_PLUGIN_TOOLS_FOLDER;
			}
		}
		/** current plugin tools path */
		$tools_paths[] = WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_TOOLS_FOLDER;

		/** scan paths and include tool's index.php - prevent duplicate tool folder name */
		$loaded_tool_folders = array();
		foreach ($tools_paths as $path) {
			if (is_dir($path)){
				$tools_folders = scandir($path);
				if ($tools_folders){
					foreach ($tools_folders as $tool_folder){
						if ($tool_folder != '.' && $tool_folder != '..' && $tool_folder != '.DS_Store' && $tool_folder != 'index.php' && !in_array($tool_folder, $loaded_tool_folders)){
							$tool_path = $path.$tool_folder.'/index.php';
							if (file_exists($tool_path)){
								$loaded_tool_folders[] = $tool_folder;
								require_once $tool_path; // load tool index.php file which must add_filter : "woodkit-register-tool" to register themself (see below)
							}
						}
					}
				}
			}
		}
		
		/** apply filter to register tools - construct tools array with slug as key - prevent duplicate tool slug */
		$arr = apply_filters("woodkit-register-tool", array());
		foreach ($arr as $tool) {
			if (!isset($this->tools[$tool->slug])) {
				$this->tools[$tool->slug] = $tool;
				if ($tool->is_activated()) {
					$this->tools_activated[$tool->slug] = $tool;
				}
			}
		}
		
		/** sort tools by name */
		uasort($this->tools, 'woodkit_cmp_tools_by_name');
	}
	
	public function get_tools ($reload = false) {
		if ($reload) {
			$this->load();
		}
		return $this->tools;
	}
	
	public function get_tool_option ($tool_slug, $name, $default = null) {
		$tool = isset($this->tools[$tool_slug]) ? $this->tools[$tool_slug] : null;
		return $tool ? $tool->get_option($name, $default) : $default;
	}
	
	public function get_tool_path ($tool_slug) {
		$tool = isset($this->tools[$tool_slug]) ? $this->tools[$tool_slug] : null;
		return $tool ? $tool->get_path() : '';
	}
	
	/**
	 * Proceed to specified tool activation
	 * @param string $tool_slug
	 */
	public function activate_tool ($tool_slug) {
		$tool = isset($this->tools[$tool_slug]) ? $this->tools[$tool_slug] : null;
		if ($tool && !$tool->is_activated()) {
			$tool->activate();
			/** reload tools */
			$this->load();
		}
	}
	
	/**
	 * Proceed to specified tool deactivation
	 * @param string $tool_slug
	 */
	public function deactivate_tool ($tool_slug) {
		$tool = isset($this->tools[$tool_slug]) ? $this->tools[$tool_slug] : null;
		if ($tool && $tool->is_activated()) {
			$tool->deactivate();
			/** reload tools */
			$this->load();
		}
	}
	
	/**
	 * Add tool menu entry if needed
	 */
	public function add_config_menu () {
		if (!empty($this->tools_activated)){
			foreach ($this->tools_activated as $tool) {
				if ($tool->has_config){
					if ($tool->add_config_in_menu){
						add_submenu_page("woodkit_options", $tool->get_name(), '<span style="margin: 0 6px 0 3px;">-</span>'.$tool->get_name(), "manage_options", "woodkit_options_tool_".$tool->slug, array($tool, 'render_config'));
					}else{
						add_submenu_page(null, $tool->get_name(), $tool->get_name(), "manage_options", "woodkit_options_tool_".$tool->slug, array($tool, 'render_config'));
					}
				}
			}
		}
	}
	
	/**
	 * Save all tool's config
	 */
	public function save_config () {
		if (!empty($this->tools_activated)){
			foreach ($this->tools_activated as $tool) {
				if ($tool->has_config){
					$tool->save_config();
				}
			}
		}
	}
	
	/**
	 * Launch tools which are activated
	 */
	public function launch () {
		if (!empty($this->tools)) {
			foreach ($this->tools as $slug => $tool) {
				if ($tool->is_activated()) {
					$tool->launch();
				}
			}
		}
	}
	
	/**
	 * Perform activation process for all activated tools
	 * Useful when core plugin is activated to manage tool's cronjob or others
	 */
	public function plugin_activation () {
		if (!empty($this->tools_activated)){
			foreach ($this->tools_activated as $tool){
				$tool->activate();
			}
		}
	}
	
	/**
	 * Perform deactivation process for all activated tools
	 * Useful when core plugin is deactivated to manage tool's cronjob or others
	 */
	public function plugin_deactivation () {
		if (!empty($this->tools_activated)){
			foreach ($this->tools_activated as $tool){
				$tool->deactivate();
			}
		}
	}
	
}