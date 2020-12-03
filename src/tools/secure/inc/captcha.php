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
define('SECURE_CAPTCHA_FIELD', 'secure-captcha-field');
define('SECURE_CAPTCHA_RESULT', 'secure-captcha-result');
define('SECURE_CAPTCHA_RECAPTCHA_API_JS', 'https://www.recaptcha.net/recaptcha/api.js');

/**
 * called to generate WP head
 */
function secure_captcha_wp_head () {
	if (secure_is_captcha_type_google_v2()) {
		?><script src="<?php echo SECURE_CAPTCHA_RECAPTCHA_API_JS; ?>" async defer></script><?php
	}
}

/**
 * called to generate WP login head
 */
function secure_captcha_login_head () {
	if (secure_is_captcha_type_google_v2()) {
		?><script src="<?php echo SECURE_CAPTCHA_RECAPTCHA_API_JS; ?>" async defer></script><?php
	}
}

/**
 * called to generate WP login form
*/
function secure_captcha_login_form($display = true){
	$field = secure_captcha_generate_field(array('field_name' => SECURE_CAPTCHA_FIELD.'-login'));
	if ($display)
		echo $field;
	else
		return $field;
}

/**
 * called to generate WP lost password form
 */
function secure_captcha_lostpassword_form() {
	echo secure_captcha_generate_field(array('field_name' => SECURE_CAPTCHA_FIELD.'-lostpassword'));
}

/**
 * called to generate WooCommerce login form
 */
function secure_captcha_woocommerce_login_form(){
	echo '<p class="form-row form-row-wide">';
	echo secure_captcha_generate_field(array('field_name' => SECURE_CAPTCHA_FIELD.'-woocommerce-login'));
	echo '</p>';
}

/**
 * called to generate WooCommerce register form
 */
function secure_captcha_woocommerce_register_form(){
	echo '<p class="form-row form-row-wide">';
	echo secure_captcha_generate_field(array('field_name' => SECURE_CAPTCHA_FIELD.'-woocommerce-register'));
	echo '</p>';
}

/**
 * called to generate WooCommerce lostpassword form
 */
function secure_captcha_woocommerce_lostpassword_form(){
	echo '<p class="form-row form-row-wide">';
	echo secure_captcha_generate_field(array('field_name' => SECURE_CAPTCHA_FIELD.'-lostpassword'));
	echo '</p>';
}

/**
 * called to generate WooCommerce checkout account form
 */
function secure_captcha_woocommerce_checkout_account_fields_form(){
	echo '<p class="form-row form-row-wide">';
	echo secure_captcha_generate_field(array('field_name' => SECURE_CAPTCHA_FIELD.'-woocommerce-checkout'));
	echo '</p>';
}

/**
 * called to generate WP registration and WooCommerce registration/checkout registration form
 */
function secure_captcha_register_form(){
	echo '<p class="form-row form-row-wide">';
	echo secure_captcha_generate_field(array('field_name' => SECURE_CAPTCHA_FIELD.'-register'));
	echo '</p>';
}

/**
 * called to validate WP login form
 */
function secure_captcha_validate_login_form($args){
	if (isset($_POST['log']) && isset($_POST['pwd'])){
		if (!secure_captcha_validate_result(array('field_name' => SECURE_CAPTCHA_FIELD.'-login'))){
			$redirect_to = "";
			if (isset($_REQUEST['redirect_to']))
				$redirect_to = $_REQUEST['redirect_to'];
			header('Location: '.get_current_url()."?redirect_to=".urlencode($redirect_to));
			exit;
		}
	}
}

/**
 * called to validate WP lost password form
 */
function secure_captcha_validate_lostpassword_form($errors){
	if (!secure_captcha_validate_result(array('field_name' => SECURE_CAPTCHA_FIELD.'-lostpassword'))){
		$errors->add('captcha-error', "<strong>".__("ERROR", 'woodkit')." : </strong>".__("invalid captcha", 'woodkit'));
	}
	return $errors;
}

/**
 * called to validate WP registration form
 */
function secure_captcha_validate_register_form($errors){
	if (isset($_POST['user_login']) && isset($_POST['user_email'])){
		if (!secure_captcha_validate_result(array('field_name' => SECURE_CAPTCHA_FIELD.'-register'))){
			$errors->add('captcha-error', "<strong>".__("ERROR", 'woodkit')." : </strong>".__("invalid captcha", 'woodkit'));
		}
	}
	return $errors;
}

/**
 * called to validate WooCommerce login form
 */
function secure_captcha_validate_woocommerce_login_form($validation_error, $user, $password){
	if (!secure_captcha_validate_result(array('field_name' => SECURE_CAPTCHA_FIELD.'-woocommerce-login'))){
		$validation_error = new WP_Error('captcha-error', __("invalid captcha", 'woodkit'));
	}
	return $validation_error;
}

/**
 * called to validate WooCommerce register form
 */
function secure_captcha_validate_woocommerce_register_form($validation_errors){
	// TODO tester si c'est une inscription à la volée...
	if (!secure_captcha_validate_result(array('field_name' => SECURE_CAPTCHA_FIELD.'-woocommerce-register'))){
		$validation_errors->add('captcha-error', __("invalid captcha", 'woodkit'));
	}
	return $validation_errors;
}

/**
 * called when WP constructs fields for comment form
 */
function secure_captcha_comment_form_field($fields){
	$fields[SECURE_CAPTCHA_FIELD.'-comment'] = secure_captcha_generate_field(array('field_name' => SECURE_CAPTCHA_FIELD.'-comment'));
	return $fields;
}

/**
 * called when WP attemps to insert new comment
 */
function secure_captcha_comment_validate($comment_post_ID){
	if (!is_user_logged_in()) { // le formulaire WP de commentaire n'affiche pas de champs autres que le textarea lorsque l'utilisateur est connecté, on ne test donc pas.
		if (!secure_captcha_validate_result(array('field_name' => SECURE_CAPTCHA_FIELD.'-comment'))){
			wp_die(__('<strong>ERROR</strong>: invalid captcha', 'woodkit'), 200);
		}
	}
}

/**
 * generic form field
 */
function secure_captcha_generic_form_field($field_name = "", $display = true, $use_placeholder = true, $use_label = false){
	if (empty($field_name)) $field_name = SECURE_CAPTCHA_FIELD;
	$field = secure_captcha_generate_field(array('field_name' => $field_name, 'use_placeholder' => $use_placeholder, 'use_label' => $use_label));
	if ($display)
		echo $field;
	else
		return $field;
}

/**
 * generic form validation
 */
function secure_captcha_generic_form_validate($field_name = "", $errors = array()){
	if (empty($field_name)) $field_name = SECURE_CAPTCHA_FIELD;
	if (!secure_captcha_validate_result(array('field_name' => $field_name))){
		$errors[] = new WP_Error('captcha-error', __("invalid captcha", 'woodkit'));
	}
	return $errors;
}

/********************************************************************************************************
 * Captcha field generation
 *******************************************************************************************************/

/**
 * Main
 */
function secure_captcha_generate_field($args = array()){
	$args = wp_parse_args($args, array(
			'field_name' => '',
			'use_placeholder' => true,
			'use_label' => false
	));
	if (secure_is_captcha_type_numeric()) {
		return secure_captcha_generate_field__numeric($args['field_name'], $args['use_placeholder'], $args['use_label']);
	} else if (secure_is_captcha_type_google_v2()) {
		return secure_captcha_generate_field__google_v2($args['field_name']);
	}
}

/**
 * Retrieve Google Recaptcha field
 */
function secure_captcha_generate_field__google_v2($field_name){
	$res = '';
	$google_public_key = secure_get_captcha_google_public_key();
	$google_private_key = secure_get_captcha_google_private_key();
	if (empty($google_public_key) || empty($google_private_key)) {
		return __("Google Recaptcha keys are missed", 'woodkit');
	}
	$error = WoodkitSession::get($field_name.'-error', "");
	WoodkitSession::set($field_name.'-error', ""); // clear captcha error in session (otherwise, captcha-error appear when form is not submited)
	if (!empty($error)){
		$res .= '<p class="error captcha-error">'.$error.'</p>';
	}
	$res .= '<div class="g-recaptcha" data-size="normal" data-theme="light" data-sitekey="'.$google_public_key.'"></div>';
	return $res;
}

/**
 * Retrieve numeric captcha field
 */
function secure_captcha_generate_field__numeric($field_name, $use_placeholder = true, $use_label = false){
	$field = "";
	$is_validated = WoodkitSession::get($field_name.'-validate', "");
	$old_result = WoodkitSession::get($field_name.'-result', "");
	if ($is_validated == 1 || empty($old_result)){
		$captcha_1 = rand(1, 15);
		$captcha_2 = rand(1, 15);
		WoodkitSession::set($field_name.'-result', $captcha_1 + $captcha_2);
		WoodkitSession::set($field_name.'-value-1', $captcha_1);
		WoodkitSession::set($field_name.'-value-2', $captcha_2);
		WoodkitSession::set($field_name.'-validate', 0);
	}else{
		$captcha_1 = WoodkitSession::get($field_name.'-value-1');
		$captcha_2 = WoodkitSession::get($field_name.'-value-2');
		// this captcha field has never be submited... don't change result value
		// this way to fix bug due to multiple loads of theme's functions.php which changes session values but not front captcha field
	}
	$input_classes = 'input tool-secure-input '.SECURE_CAPTCHA_FIELD;
	$error = WoodkitSession::get($field_name.'-error', "");
	WoodkitSession::set($field_name.'-error', ""); // clear captcha error in session (otherwise, captcha-error appear when form is not submited)
	if (!empty($error)){
		$field .= '<p class="error captcha-error">'.$error.'</p>';
		$input_classes .= ' error ';
	}
	$field .= '<span class="input-wrapper tool-secure-input-wrapper">';
	if ($use_label == true){
		$field .= '<label class="tool-secure-input-label" for="'.$field_name.'">'.$captcha_1." + ".$captcha_2.'</label>';
	}
	$placeholder = '';
	if ($use_placeholder == true){
		$placeholder =  'placeholder="'.$captcha_1." + ".$captcha_2.'"';
	}
	$field .= '<input class="'.$input_classes.'" size="20" type="number" id="'.$field_name.'" name="'.$field_name.'" '.$placeholder.' autocomplete="off" />';
	$field .= '<span class="fa fa-question-circle tool-secure-show-info"></span>';
	$field .= '<span class="tool-secure-info-text">'.__("Please solve the equation. This is an anti-spam security check.", 'woodkit').'</span>';
	$field .= '</span>';
	return $field;
}

/********************************************************************************************************
 * Captcha field validation
 *******************************************************************************************************/

/**
 * Main
 */
function secure_captcha_validate_result($args){
	$args = wp_parse_args($args, array(
			'field_name' => ''
	));
	if (secure_is_captcha_type_numeric()) {
		return secure_captcha_validate_result__numeric($args['field_name']);
	} else if (secure_is_captcha_type_google_v2()) {
		return secure_captcha_validate_result__google_v2($args['field_name']);
	}
}

/**
 * validate google recaptcha for specified field
 */
function secure_captcha_validate_result__google_v2($field_name){
	require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_ASSETS_FOLDER.'github.google.recaptcha/autoload.php');
	$valid = false;
	$google_private_key = secure_get_captcha_google_private_key();
	if (!empty($google_private_key)) {
		$recaptcha = new \ReCaptcha\ReCaptcha($google_private_key);
		$resp = $recaptcha->verify($_POST['g-recaptcha-response']);
		$valid = $resp->isSuccess();
	}
	if ($valid) {
		WoodkitSession::set($field_name.'-error', "");
	}else{
		WoodkitSession::set($field_name.'-error', __("invalid captcha", 'woodkit'));
	}
	return $valid;
}

/**
 * validate numeric captcha result for specified field
 */
function secure_captcha_validate_result__numeric($field_name){
	WoodkitSession::set($field_name.'-validate', 1);
	$valid = false;
	if (isset($_POST[$field_name])){
		if (!empty($_POST[$field_name])){
			$captcha_result = WoodkitSession::get($field_name.'-result', "");
			if ($_POST[$field_name] == $captcha_result){
				$valid = true;
			}
		}
	}else{ // no submition
		$valid = true;
	}
	if ($valid) {
		WoodkitSession::set($field_name.'-error', "");
	}else{
		WoodkitSession::set($field_name.'-error', __("invalid captcha", 'woodkit'));
	}
	return $valid;
}
