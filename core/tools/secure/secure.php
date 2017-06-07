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
 * IMPORTANT : this secure tool use $_SESSION and similare keys for all securized forms, in particular usage you can be failtoban because of an other form failed to ban
*/

/**
 * REQUIREMENTS
*/
require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_TOOLS_FOLDER.SECURE_TOOL_NAME.'/inc/captcha.php');
require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_TOOLS_FOLDER.SECURE_TOOL_NAME.'/inc/failtoban.php');

/**
 * Force login/password authentication (user can not use email)
 */
remove_filter( 'authenticate', 'wp_authenticate_email_password', 20 );

/**
 * Hide generator in HTML meta data
 */
add_filter('the_generator', function(){
	return '';
});

/**
 * Is secure captcha active
 * @return boolean
*/
function secure_is_captcha_active(){
	$captcha_active = woodkit_get_option("tool-secure-captcha-active");
	if (!empty($captcha_active) && $captcha_active == "on")
		return true;
	return false;
}

/**
 * Is secure failtoban active
 * @return boolean
 */
function secure_is_failtoban_active(){
	$failtoban_active = woodkit_get_option("tool-secure-failtoban-active");
	if (!empty($failtoban_active) && $failtoban_active == "on")
		return true;
	return false;
}

/**
 * Add captchanum to Contact Form 7 plugin
 */
if (secure_is_captcha_active() && class_exists("WPCF7_ContactForm")){
	require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_TOOLS_FOLDER.SECURE_TOOL_NAME.'/inc/contactform7/captchanum.php');
}

/**
 * WP uses this action to generate login form
 */
add_action('login_form', 'secure_login_form');
add_filter('login_form_middle', 'secure_login_form_filter', 10, 1);

/**
 * WooCommerce uses this action to generate login form
*/
add_action('woocommerce_login_form', 'secure_woocommerce_login_form');

/**
 * WooCommerce uses this action to generate checkout registration form
*/
add_action('woocommerce_after_checkout_registration_form', 'secure_woocommerce_checkout_registration_form');

/**
 * WP and WooCommerce uses this action to generate registration form
*/
add_action('register_form', 'secure_register_form');

/**
 * WP uses this action during login process
*/
add_action('wp_authenticate', 'secure_validate_login_form', 1, 1);

/**
 * WP uses this action during registration process
*/
add_action('registration_errors', 'secure_validate_register_form', 1, 1);

/**
 * WooCommerce uses this action during login process
*/
add_action('woocommerce_process_login_errors', 'secure_validate_woocommerce_login_form', 1, 3);

/**
 * WooCommerce uses this action during register process
*/
add_action('woocommerce_registration_errors', 'secure_validate_woocommerce_register_form', 1, 3);

/**
 * WP uses this filter to accepts new fields in comment form - old : add_filter('comment_form_default_fields', 'secure_comment_form_field', 10, 1);
*/
add_filter('comment_form_fields', 'secure_comment_form_field', 10, 1);

/**
 * WP uses this action before insert new comment
*/
add_action('pre_comment_on_post', 'secure_comment_validate', 1, 1);

/**
 * CONTACTFORM7 TOOL uses this action to display captchanum field
*/
add_filter('tool_contactform7_captchanum_field', 'secure_contactform7_form_field', 1, 3);

/**
 * CONTACTFORM7 TOOL uses this action to validate captchanum field
*/
add_filter('tool_contactform7_captchanum_validatation', 'secure_contactform7_form_validate', 1, 1);

/**
 * called to generate WP login form
*/
function secure_login_form(){
	if (secure_is_failtoban_active()){
		secure_failtoban_login_form();
	}
	if (secure_is_captcha_active()){
		secure_captcha_login_form();
	}
}

/**
 * called by filter to generate WP login form
 */
function secure_login_form_filter(){
	$field = "";
	if (secure_is_failtoban_active()){
		$field .= secure_failtoban_login_form(false);
	}
	if (secure_is_captcha_active()){
		$field .= secure_captcha_login_form(false);
	}
	return $field;
}

/**
 * called to generate WooCommerce login form
 */
function secure_woocommerce_login_form(){
	if (secure_is_failtoban_active()){
		secure_failtoban_woocommerce_login_form();
	}
	if (secure_is_captcha_active()){
		secure_captcha_woocommerce_login_form();
	}
}

/**
 * called to generate WooCommerce checkout registration form
 */
function secure_woocommerce_checkout_registration_form(){
	if (secure_is_failtoban_active()){
		secure_failtoban_woocommerce_checkout_registration_form();
	}
	if (secure_is_captcha_active()){
		secure_captcha_woocommerce_checkout_registration_form();
	}
}

/**
 * called to generate WP and WooCommerce registration form
 */
function secure_register_form(){
	if (secure_is_failtoban_active()){
		secure_failtoban_register_form();
	}
	if (secure_is_captcha_active()){
		secure_captcha_register_form();
	}
}

/**
 * called to validate WP login form
 */
function secure_validate_login_form($args){
	if (secure_is_failtoban_active()){
		secure_failtoban_validate_login_form($args);
	}
	if (secure_is_captcha_active()){
		secure_captcha_validate_login_form($args);
	}
}

/**
 * called to validate WP registration form
 */
function secure_validate_register_form($errors){
	$error_codes = $errors->get_error_codes();
	if (empty($error_codes)){
		if (secure_is_failtoban_active()){
			$errors = secure_failtoban_validate_register_form($errors);
		}
		if (empty($error_codes)){
			if (secure_is_captcha_active()){
				$errors = secure_captcha_validate_register_form($errors);
			}
		}
	}
	return $errors;
}

/**
 * called to validate WooCommerce login form
 */
function secure_validate_woocommerce_login_form($validation_error, $user, $password){
	if (!$validation_error->get_error_code()){
		if (secure_is_failtoban_active()){
			$validation_error = secure_failtoban_validate_woocommerce_login_form($validation_error, $user, $password);
		}
		if (!$validation_error->get_error_code()){
			if (secure_is_captcha_active()){
				$validation_error = secure_captcha_validate_woocommerce_login_form($validation_error, $user, $password);
			}
		}
	}
	return $validation_error;
}

/**
 * called to validate WooCommerce register form
 */
function secure_validate_woocommerce_register_form($validation_error, $user, $email){
	if (!$validation_error->get_error_code()){
		if (secure_is_failtoban_active()){
			$validation_error = secure_failtoban_validate_woocommerce_register_form($validation_error, $user, $email);
		}
		if (!$validation_error->get_error_code()){
			if (secure_is_captcha_active()){
				$validation_error = secure_captcha_validate_woocommerce_register_form($validation_error, $user, $email);
			}
		}
	}
	return $validation_error;
}

/**
 * called when WP constructs fields for comment form
 */
function secure_comment_form_field($fields){
	if (secure_is_failtoban_active()){
		$fields = secure_failtoban_comment_form_field($fields);
	}
	if (secure_is_captcha_active()){
		$fields = secure_captcha_comment_form_field($fields);
	}
	return $fields;
}

/**
 * called when WP attemps to insert new comment
 */
function secure_comment_validate($comment_post_ID){
	if (secure_is_failtoban_active()){
		secure_failtoban_comment_validate($comment_post_ID);
	}
	if (secure_is_captcha_active()){
		secure_captcha_comment_validate($comment_post_ID);
	}
}

/**
 * called when CONTACTFORM7 TOOL displays captchanum field
 */
function secure_contactform7_form_field($field_name, $use_placeholder, $use_label){
	$field = "";
	if (secure_is_failtoban_active()){
		$field .= secure_failtoban_generic_form_field(false);
	}
	if (secure_is_captcha_active()){
		$field .= secure_captcha_generic_form_field($field_name, false, $use_placeholder, $use_label);
	}
	return $field;
}

/**
 * called when CONTACTFORM7 TOOL validates captchanum field
 */
function secure_contactform7_form_validate($field_name){
	$errors = array();
	if (secure_is_failtoban_active()){
		$errors = secure_failtoban_generic_form_validate($errors);
	}
	if (empty($errors)){
		if (secure_is_captcha_active()){
			$errors = secure_captcha_generic_form_validate($field_name, $errors);
		}
	}
	return $errors;
}