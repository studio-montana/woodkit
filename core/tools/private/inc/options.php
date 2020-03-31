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
 * CONSTANTS
*/
define('TOOL_PRIVATE_OPTIONS_NONCE_ACTION', 'tool-private-options-nonce-action');
define('TOOL_PRIVATE_OPTIONS_GO_PRIVATE', 'tool-private-option-go-private');
define('TOOL_PRIVATE_OPTIONS_ITEMS', 'tool-private-option-items');
define('TOOL_PRIVATE_OPTIONS_MESSAGE', 'tool-private-option-message');

/**
 * create admin menu for private settings
*/
function tool_private_create_menu() {
	add_menu_page(__('Private settings', 'woodkit'), __('Private site', 'woodkit'), 'administrator', "tool-private-settings-page", 'tool_private_settings_template' , 'dashicons-lock');
}
add_action('admin_menu', 'tool_private_create_menu');

/**
 * load settings template
*/
function tool_private_settings_template() {
	tool_private_settings_save();
	?>
<form method="post" action="<?php echo get_current_url(true); ?>">
	<input type="hidden"
		name="<?php echo TOOL_PRIVATE_OPTIONS_NONCE_ACTION; ?>"
		value="<?php echo wp_create_nonce(TOOL_PRIVATE_OPTIONS_NONCE_ACTION);?>" />
	<?php
	require_once (locate_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.PRIVATE_TOOL_NAME.'/inc/options-fields.php'));
	submit_button();
	?>
</form>
<?php
}

/**
 * save settings
 */
function tool_private_settings_save() {
	if (!current_user_can('administrator'))
		return;
	if (!isset($_POST[TOOL_PRIVATE_OPTIONS_NONCE_ACTION]) || !wp_verify_nonce($_POST[TOOL_PRIVATE_OPTIONS_NONCE_ACTION], TOOL_PRIVATE_OPTIONS_NONCE_ACTION))
		return;

	// TOOL_PRIVATE_OPTIONS_GO_PRIVATE
	if (isset($_POST[TOOL_PRIVATE_OPTIONS_GO_PRIVATE]) && !empty($_POST[TOOL_PRIVATE_OPTIONS_GO_PRIVATE])){
		if (!get_option(TOOL_PRIVATE_OPTIONS_GO_PRIVATE))
			add_option(TOOL_PRIVATE_OPTIONS_GO_PRIVATE, sanitize_text_field($_POST[TOOL_PRIVATE_OPTIONS_GO_PRIVATE]));
		else
			update_option(TOOL_PRIVATE_OPTIONS_GO_PRIVATE, sanitize_text_field($_POST[TOOL_PRIVATE_OPTIONS_GO_PRIVATE]));
	}else{
		delete_option(TOOL_PRIVATE_OPTIONS_GO_PRIVATE);
	}

	// TOOL_PRIVATE_OPTIONS_ITEMS
	$key = TOOL_PRIVATE_OPTIONS_ITEMS."-".get_current_lang();
	$items = "";
	foreach ($_POST as $k => $v){
		if (startsWith($k, "tool-private-item-")){
			if ($v = "on"){
				$id = str_replace("tool-private-item-", "", $k);
				if (!empty($items))
					$items .= ",";
				$items .= $id;
			}
		}
	}
	if (!empty($items)){
		if (!get_option($key))
			add_option($key, $items);
		else
			update_option($key, $items);
	}else{
		delete_option($key);
	}
	
	// TOOL_PRIVATE_OPTIONS_MESSAGE
	$key = TOOL_PRIVATE_OPTIONS_MESSAGE."-".get_current_lang();
	if (isset($_POST[$key]) && !empty($_POST[$key])){
		if (!get_option($key))
			add_option($key, sanitize_text_field($_POST[$key]));
		else
			update_option($key, sanitize_text_field($_POST[$key]));
	}else{
		delete_option($key);
	}
}
