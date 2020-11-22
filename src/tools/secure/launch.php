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
require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_TOOLS_FOLDER.SECURE_TOOL_NAME.'/inc/headers.php');
require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_TOOLS_FOLDER.SECURE_TOOL_NAME.'/inc/captcha.php');
require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_TOOLS_FOLDER.SECURE_TOOL_NAME.'/inc/failtoban.php');

/**
 * Force login/password authentication (user can not use email)
 */
remove_filter('authenticate', 'wp_authenticate_email_password', 20);

/**
 * Hide WP version in HTML meta data
 */
remove_action("wp_head", "wp_generator");

/**
 * Hide WP version in RSS feed
 */
add_filter('the_generator', function(){
	return '';
});

/**
 * Is secure captcha active
 * @return boolean
*/
function secure_is_captcha_active(){
	static $res = -1;
	if ($res === -1) {
		$res = $GLOBALS['woodkit']->tools->get_tool_option(SECURE_TOOL_NAME, 'captcha-active');
		$res = !empty($res) && $res == "on";
	}
	return $res;
}

/**
 * Retrieve captcha type
 * @return boolean
*/
function secure_get_captcha_type(){
	static $res = -1;
	if ($res === -1) {
		$res = $GLOBALS['woodkit']->tools->get_tool_option(SECURE_TOOL_NAME, 'captcha-type');
	}
	return $res;
}

/**
 * Is secure captcha numeric (default)
 * @return boolean
*/
function secure_is_captcha_type_numeric(){
	$captcha_type = secure_get_captcha_type(); 
	return !empty($captcha_type) && $captcha_type === 'numeric';
}

/**
 * Is secure captcha Google Recaptcha V2
 * @return boolean
*/
function secure_is_captcha_type_google_v2(){
	$captcha_type = secure_get_captcha_type(); 
	return !empty($captcha_type) && $captcha_type === 'google-v2';
}

/**
 * Retrieve Google Recaptcha public key
 * @return string
*/
function secure_get_captcha_google_public_key(){
	static $res = -1;
	if ($res === -1) {
		$res = $GLOBALS['woodkit']->tools->get_tool_option(SECURE_TOOL_NAME, 'captcha-google-key-public');
	}
	return $res;
}

/**
 * Retrieve Google Recaptcha private key
 * @return string
*/
function secure_get_captcha_google_private_key(){
	static $res = -1;
	if ($res === -1) {
		$res = $GLOBALS['woodkit']->tools->get_tool_option(SECURE_TOOL_NAME, 'captcha-google-key-private');
	}
	return $res;
}

/**
 * Is secure failtoban active
 * @return boolean
 */
function secure_is_failtoban_active(){
	static $res = -1;
	if ($res === -1) {
		$res = $GLOBALS['woodkit']->tools->get_tool_option(SECURE_TOOL_NAME, "failtoban-active");
		$res = !empty($res) && $res == "on";
	}
	return $res;
}

/**
 * Add captchanum to Contact Form 7 plugin
 */
if (secure_is_captcha_active() && secure_is_captcha_type_numeric() && class_exists("WPCF7_ContactForm")){
	require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_TOOLS_FOLDER.SECURE_TOOL_NAME.'/inc/contactform7/captchanum.php');
}

/**
 * Add Google Recaptcha V2 to Contact Form 7 plugin
 */
if (secure_is_captcha_active() && secure_is_captcha_type_google_v2() && class_exists("WPCF7_ContactForm")){
	require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_TOOLS_FOLDER.SECURE_TOOL_NAME.'/inc/contactform7/googlerecaptchav2.php');
}

/**
 * WP head
 */
add_action('wp_head', 'secure_wp_head');

/**
 * WP login head
 */
add_action('login_head', 'secure_login_head');

/**
 * WP uses this action to generate login form
 */
add_action('login_form', 'secure_login_form');
add_filter('login_form_middle', 'secure_login_form_filter', 10, 1);

/**
 * WP uses this action to generate lost password form
 */
add_action('lostpassword_form', 'secure_lostpassword_form');

/**
 * WooCommerce uses this action to generate login form
*/
add_action('woocommerce_login_form', 'secure_woocommerce_login_form');

/**
 * WooCommerce uses this action to generate register form
 */
add_action('woocommerce_register_form', 'secure_woocommerce_register_form');

/**
 * WooCommerce uses this action to generate lost password form
 */
add_action('woocommerce_lostpassword_form', 'secure_woocommerce_lostpassword_form', 10);

/**
 * WP and WooCommerce uses this action to generate registration form
*/
add_action('register_form', 'secure_register_form');

/**
 * WP uses this action during login process
*/
add_action('wp_authenticate', 'secure_validate_login_form', 1, 1);

/**
 * WP / WooCommerce uses this action during lost password process
 */
add_action('lostpassword_post', 'secure_validate_lostpassword_form', 10, 1);

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
add_action('woocommerce_register_post', 'secure_validate_woocommerce_register_form', 10, 3);

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
 * CONTACTFORM7 TOOL uses this action to display Google Recaptcha V2
*/
add_filter('tool_contactform7_googlerecaptchav2_field', 'secure_contactform7_form_field', 1, 3);

/**
 * CONTACTFORM7 TOOL uses this action to validate captchanum field
*/
add_filter('tool_contactform7_captchanum_validatation', 'secure_contactform7_form_validate', 1, 1);

/**
 * CONTACTFORM7 TOOL uses this action to validate Google Recaptcha V2
*/
add_filter('tool_contactform7_googlerecaptchav2_validatation', 'secure_contactform7_form_validate', 1, 1);

/**
 * called to generate WP head
*/
function secure_wp_head() {
	if (secure_is_failtoban_active()){
		secure_failtoban_wp_head();
	}
	if (secure_is_captcha_active()){
		secure_captcha_wp_head();
	}
}

/**
 * called to generate WP login head
*/
function secure_login_head(){
	if (secure_is_failtoban_active()){
		secure_failtoban_login_head();
	}
	if (secure_is_captcha_active()){
		secure_captcha_login_head();
	}
}

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
 * called by filter to generate WP lost password form
 */
function secure_lostpassword_form(){
	if (secure_is_failtoban_active()){
		secure_failtoban_lostpassword_form();
	}
	if (secure_is_captcha_active()){
		secure_captcha_lostpassword_form();
	}
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
 * called to generate WooCommerce login form
 */
function secure_woocommerce_register_form(){
	if (secure_is_failtoban_active()){
		secure_failtoban_woocommerce_register_form();
	}
	if (secure_is_captcha_active()){
		secure_captcha_woocommerce_register_form();
	}
}

/**
 * called to generate WooCommerce lost password form
 */
function secure_woocommerce_lostpassword_form(){
	if (secure_is_failtoban_active()){
		secure_failtoban_woocommerce_lostpassword_form();
	}
	if (secure_is_captcha_active()){
		secure_captcha_woocommerce_lostpassword_form();
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

function secure_validate_lostpassword_form($errors) {
	if (secure_is_failtoban_active()){
		secure_failtoban_validate_lostpassword_form($errors);
	}
	if (secure_is_captcha_active()){
		secure_captcha_validate_lostpassword_form($errors);
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
function secure_validate_woocommerce_register_form ($username, $email, $validation_errors) {
	if (secure_is_failtoban_active()){
		$validation_errors = secure_failtoban_validate_woocommerce_register_form($validation_errors);
	}
	if (secure_is_captcha_active()){
		$validation_errors = secure_captcha_validate_woocommerce_register_form($validation_errors);
	}
	return $validation_errors;
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