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
 * Load Modules
*/
function Woodkit_Divi_Modules(){
	if(class_exists("ET_Builder_Module")){

		do_action("woodkit_divi_add_module_before_commons");

		require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_DIVI_FOLDER.'modules/commons.php');

		do_action("woodkit_divi_add_module_after_commons");

		do_action("woodkit_divi_add_module_before");

		require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_DIVI_FOLDER.'modules/icon-button.php');
		if (class_exists("WPCF7_ContactForm"))
			require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_DIVI_FOLDER.'modules/contactform7.php');
		if (woodkit_is_activated_tool("wall")){
			require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_DIVI_FOLDER.'modules/wall-integration.php');
			require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_DIVI_FOLDER.'modules/fullwidth-wall-integration.php');
		}

		do_action("woodkit_divi_add_module_after");

	}
}
function Prep_Woodkit_Divi_Modules(){
	global $pagenow;

	$is_admin = is_admin();
	$action_hook = $is_admin ? 'wp_loaded' : 'wp';
	$required_admin_pages = array( 'edit.php', 'post.php', 'post-new.php', 'admin.php', 'customize.php', 'edit-tags.php', 'admin-ajax.php', 'export.php' ); // list of admin pages where we need to load builder files
	$specific_filter_pages = array( 'edit.php', 'admin.php', 'edit-tags.php' );
	$is_edit_library_page = 'edit.php' === $pagenow && isset( $_GET['post_type'] ) && 'et_pb_layout' === $_GET['post_type'];
	$is_role_editor_page = 'admin.php' === $pagenow && isset( $_GET['page'] ) && 'et_divi_role_editor' === $_GET['page'];
	$is_import_page = 'admin.php' === $pagenow && isset( $_GET['import'] ) && 'wordpress' === $_GET['import'];
	$is_edit_layout_category_page = 'edit-tags.php' === $pagenow && isset( $_GET['taxonomy'] ) && 'layout_category' === $_GET['taxonomy'];

	if ( ! $is_admin || ( $is_admin && in_array( $pagenow, $required_admin_pages ) && ( ! in_array( $pagenow, $specific_filter_pages ) || $is_edit_library_page || $is_role_editor_page || $is_edit_layout_category_page || $is_import_page ) ) ) {
		add_action($action_hook, 'Woodkit_Divi_Modules', 9789);
	}
}
Prep_Woodkit_Divi_Modules();

/**
 * Enqueue scripts and styles for the back end.
 *
 * @return void
*/
function woodkit_divi_modules_builder_admin_scripts_styles() {

	if(class_exists("ET_Builder_Module")){

		do_action("woodkit_divi_admin_enqueue_scripts_before");

		/**
		 * JS
		*/
		wp_enqueue_script("woodkit-divi-modules-builder-script", WOODKIT_PLUGIN_URI.WOODKIT_PLUGIN_COMMONS_DIVI_FOLDER."js/builder.js", array('jquery'), '1.0', true);

		do_action("woodkit_divi_admin_enqueue_scripts_after");

		do_action("woodkit_divi_admin_enqueue_styles_before");

		/**
		 * CSS
		*/
		wp_enqueue_style("woodkit-divi-modules-builder-style", WOODKIT_PLUGIN_URI.WOODKIT_PLUGIN_COMMONS_DIVI_FOLDER."css/builder.css", array(), '1.0');

		do_action("woodkit_divi_admin_enqueue_styles_after");

	}
}
add_action('admin_enqueue_scripts', 'woodkit_divi_modules_builder_admin_scripts_styles');

/**
 Module field types
 'tiny_mce'
 'textarea'
 'custom_css'
 'select'
 'yes_no_button'
 'font'
 'color'
 'color-alpha'
 'upload'
 'checkbox'
 'multiple_checkboxes'
 'hidden'
 'custom_margin'
 'custom_padding'
 'text':
 'date_picker':
 'range'
 */