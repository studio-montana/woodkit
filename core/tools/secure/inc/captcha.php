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

/**
 * called to generate WP login form
*/
function secure_captcha_login_form($display = true){
	$field = secure_captcha_generate_field(SECURE_CAPTCHA_FIELD.'-login');
	if ($display)
		echo $field;
	else
		return $field;
}

/**
 * called to generate WooCommerce login form
 */
function secure_captcha_woocommerce_login_form(){
	echo '<p class="form-row form-row-wide">';
	echo secure_captcha_generate_field(SECURE_CAPTCHA_FIELD.'-woocommerce-login');
	echo '</p>';
}

/**
 * called to generate WooCommerce checkout registration form
 */
function secure_captcha_woocommerce_checkout_registration_form(){
	echo '<p class="form-row form-row form-row-wide address-field validate-required" id="billing_captcha_field" data-o_class="form-row form-row form-row-wide address-field validate-required">';
	echo '<label for="'.SECURE_CAPTCHA_FIELD.'-register" class="">'.__("Captcha", WOODKIT_PLUGIN_TEXT_DOMAIN).'<abbr class="required" title="requis">*</abbr></label>';
	echo secure_captcha_generate_field(SECURE_CAPTCHA_FIELD.'-register');
	echo '</p>';
}

/**
 * called to generate WP registration and WooCommerce registration/checkout registration form
 */
function secure_captcha_register_form(){
	echo '<p class="form-row form-row-wide">';
	echo secure_captcha_generate_field(SECURE_CAPTCHA_FIELD.'-register');
	echo '</p>';
}

/**
 * called to validate WP login form
 */
function secure_captcha_validate_login_form($args){
	if (isset($_POST['log']) && isset($_POST['pwd'])){
		if (!secure_captcha_validate_result(SECURE_CAPTCHA_FIELD.'-login')){
			$redirect_to = "";
			if (isset($_REQUEST['redirect_to']))
				$redirect_to = $_REQUEST['redirect_to'];
			header('Location: '.get_current_url()."?redirect_to=".urlencode($redirect_to));
			exit;
		}
	}
}

/**
 * called to validate WP registration form
 */
function secure_captcha_validate_register_form($errors){
	if (isset($_POST['user_login']) && isset($_POST['user_email'])){
		if (!secure_captcha_validate_result(SECURE_CAPTCHA_FIELD.'-register')){
			$errors->add('captcha-error', "<strong>".__("ERROR", WOODKIT_PLUGIN_TEXT_DOMAIN)." : </strong>".__("invalid captcha", WOODKIT_PLUGIN_TEXT_DOMAIN));
		}
	}
	return $errors;
}

/**
 * called to validate WooCommerce login form
 */
function secure_captcha_validate_woocommerce_login_form($validation_error, $user, $password){
	if (!secure_captcha_validate_result(SECURE_CAPTCHA_FIELD.'-woocommerce-login')){
		$validation_error = new WP_Error('captcha-error', __("invalid captcha", WOODKIT_PLUGIN_TEXT_DOMAIN));
	}
	return $validation_error;
}

/**
 * called to validate WooCommerce register form
 */
function secure_captcha_validate_woocommerce_register_form($validation_error, $username, $email){
	if (!secure_captcha_validate_result(SECURE_CAPTCHA_FIELD.'-register')){
		$validation_error = new WP_Error('captcha-error', __("invalid captcha", WOODKIT_PLUGIN_TEXT_DOMAIN));
	}
	return $validation_error;
}

/**
 * called when WP constructs fields for comment form
 */
function secure_captcha_comment_form_field($fields){
	$fields[SECURE_CAPTCHA_FIELD.'-comment'] = secure_captcha_generate_field(SECURE_CAPTCHA_FIELD.'-comment');
	return $fields;
}

/**
 * called when WP attemps to insert new comment
 */
function secure_captcha_comment_validate($comment_post_ID){
	if (!secure_captcha_validate_result(SECURE_CAPTCHA_FIELD.'-comment')){
		wp_die(__('<strong>ERROR</strong>: invalid captcha', WOODKIT_PLUGIN_TEXT_DOMAIN), 200);
	}
}

/**
 * generic form field
 */
function secure_captcha_generic_form_field($field_name = "", $display = true, $use_placeholder = true, $use_label = false){
	if (empty($field_name)) $field_name = SECURE_CAPTCHA_FIELD;
	$field = secure_captcha_generate_field($field_name, $use_placeholder, $use_label);
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
	if (!secure_captcha_validate_result($field_name)){
		$errors[] = new WP_Error('captcha-error', __("invalid captcha", WOODKIT_PLUGIN_TEXT_DOMAIN));
	}
	return $errors;
}

/**
 * generate captcha field
 */
function secure_captcha_generate_field($field_name, $use_placeholder = true, $use_label = false){
	$field = "";
	$is_validated = woodkit_session_get($field_name.'-validate', "");
	$old_result = woodkit_session_get($field_name.'-result', "");
	if ($is_validated == 1 || empty($old_result)){
		$captcha_1 = rand(1, 15);
		$captcha_2 = rand(1, 15);
		woodkit_session_set($field_name.'-result', $captcha_1 + $captcha_2);
		woodkit_session_set($field_name.'-value-1', $captcha_1);
		woodkit_session_set($field_name.'-value-2', $captcha_2);
		woodkit_session_set($field_name.'-validate', 0);
	}else{
		$captcha_1 = woodkit_session_get($field_name.'-value-1');
		$captcha_2 = woodkit_session_get($field_name.'-value-2');
		// this captcha field has never be submited... don't change result value
		// this way to fix bug due to multiple loads of theme's functions.php which changes session values but not front captcha field
	}
	$input_classes = 'input tool-secure-input '.SECURE_CAPTCHA_FIELD;
	$error = woodkit_session_get($field_name.'-error', "");
	woodkit_session_set($field_name.'-error', ""); // clear captcha error in session (otherwise, captcha-error appear when form is not submited)
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
	$field .= '<input class="'.$input_classes.'" size="20" type="number" id="'.$field_name.'" name="'.$field_name.'" '.$placeholder.' />';
	$field .= '<span class="fa fa-question-circle tool-secure-show-info"></span>';
	$field .= '<span class="tool-secure-info-text">'.__("Please solve the problem. This is an anti-spam security check.", WOODKIT_PLUGIN_TEXT_DOMAIN).'</span>';
	$field .= '</span>';
	return $field;
}

/**
 * validate captcha result for specified field
 */
function secure_captcha_validate_result($field_name){
	woodkit_session_set($field_name.'-validate', 1);
	$valid = false;
	if (isset($_POST[$field_name])){
		if (!empty($_POST[$field_name])){
			$captcha_result = woodkit_session_get($field_name.'-result', "");
			if ($_POST[$field_name] == $captcha_result){
				$valid = true;
			}
		}
	}else{ // no submition
		$valid = true;
	}
	if ($valid)
		woodkit_session_set($field_name.'-error', "");
	else
		woodkit_session_set($field_name.'-error', __("invalid captcha", WOODKIT_PLUGIN_TEXT_DOMAIN));
	return $valid;
}