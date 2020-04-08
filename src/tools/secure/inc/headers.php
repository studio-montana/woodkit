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
 * CORS whitelist
 */
add_filter('allowed_http_origins', function($origins) {
	$corswhitelist = $GLOBALS['woodkit']->tools->get_tool_option(SECURE_TOOL_NAME, "headers-corswhitelist");
	if (!empty($corswhitelist)){
		$corswhitelist = explode("\n", $corswhitelist);
		if (!empty($corswhitelist)){
			foreach ($corswhitelist as $corswhitelist_item){
				$origins[] = trim($corswhitelist_item);
			}
		}
	}
	return $origins;
});

function woodkit_tool_secure_headers() {
	if (headers_sent()){
		trace_err("Headers already sent. Woodkit secure tool unable to process");
	}

	// TODO HSTS
	/*
	if (is_ssl()){
		$time = esc_attr($GLOBALS['woodkit']->tools->get_tool_option(SECURE_TOOL_NAME, "headers-hsts-time"));
		$subdomain = esc_attr($GLOBALS['woodkit']->tools->get_tool_option(SECURE_TOOL_NAME, "headers-hsts-subdomains"));
		$preload = esc_attr($GLOBALS['woodkit']->tools->get_tool_option(SECURE_TOOL_NAME, "headers-hsts-preload"));
		if ( ctype_digit($time)  ) {
			$subdomain_output = $subdomain > 0 ? "; includeSubDomains" : "";
			$preload_output = $preload > 0 ? "; preload" : "";
			header("Strict-Transport-Security: max-age=$time$subdomain_output$preload_output");
		}
	}
	*/

	// No Sniff - X-Content-Type-Options: nosniff
	$nosniff = esc_attr($GLOBALS['woodkit']->tools->get_tool_option(SECURE_TOOL_NAME, "headers-nosniff"));
	if ($nosniff == 'on') {
		send_nosniff_header();
	}

	// XSS - X-XSS-Protection: 1; mode=block
	$xss = esc_attr($GLOBALS['woodkit']->tools->get_tool_option(SECURE_TOOL_NAME, "headers-xss"));
	if ($xss == 'on') {
		header("X-XSS-Protection: 1; mode=block");
	}

	// Frame Options - X-Frame-Options: SAMEORIGIN
	$frame = esc_attr($GLOBALS['woodkit']->tools->get_tool_option(SECURE_TOOL_NAME, "headers-frame"));
	if ($frame == 'on') {
		send_frame_options_header();
	}

	// Powered by - X-Powered-By: unknown
	$poweredby = esc_attr($GLOBALS['woodkit']->tools->get_tool_option(SECURE_TOOL_NAME, "headers-poweredby"));
	if ($poweredby == 'on') {
		header_remove('X-Powered-By');
	}

	// Server - Server: unknown
	$server = esc_attr($GLOBALS['woodkit']->tools->get_tool_option(SECURE_TOOL_NAME, "headers-server"));
	if ($server == 'on') {
		header_remove('X-Server');
	}

	// TODO HPKP
	/*
	if (is_ssl()){
		$pinkey1 = esc_attr($GLOBALS['woodkit']->tools->get_tool_option(SECURE_TOOL_NAME, "headers-hpkp-key1"));
		$pinkey2 = esc_attr($GLOBALS['woodkit']->tools->get_tool_option(SECURE_TOOL_NAME, "headers-hpkp-key2"));
		$pinkey3 = esc_attr($GLOBALS['woodkit']->tools->get_tool_option(SECURE_TOOL_NAME, "headers-hpkp-key3"));
		$pintime = esc_attr($GLOBALS['woodkit']->tools->get_tool_option(SECURE_TOOL_NAME, "headers-hpkp-time"));
		$pinsubdomain = esc_attr($GLOBALS['woodkit']->tools->get_tool_option(SECURE_TOOL_NAME, "headers-hpkp-subdomains"));
		$pinuri = $GLOBALS['woodkit']->tools->get_tool_option(SECURE_TOOL_NAME, "headers-hpkp-uri");
		// Standard requires at least one backup key so insist on two keys before working
		if ( is_numeric($pintime) && !empty($pinkey1) && !empty($pinkey2)) {
			$pinheader="Public-Key-Pins: ";
			$pinheader .= 'pin-sha256="'. $pinkey1 .'";';
			$pinheader .= 'pin-sha256="'. $pinkey2 .'";';
			if (!empty($pinkey3)) { $pinheader .= 'pin-sha256="'. $pinkey3 .'";'; }
			$pinheader .= " max-age=$pintime;";
			if ($pinsubdomain > 0) { $pinheader .= ' includeSubDomains;'; }
			if (!empty($pinuri)) { $pinheader .= ' report-uri="'. $pinuri .'";'; }
			header($pinheader);
		}
	}
	*/
	
	// TODO Expect-CT
	/*
	if (is_ssl()){ // Should not be issued for http
		$ectage = esc_attr(get_option('security_headers_ect_time'));
		$ectenforce = esc_attr(get_option('security_headers_ect_enforce'));
		$ecturi = get_option('security_headers_ect_uri');
		if ( ctype_digit($ectage) ){
			$ectheader="Expect-CT: max-age=$ectage";
			if ($ectenforce > 0) { $ectheader .= ',enforce'; }
			if (!empty($ecturi)) { $ectheader .= ',report-uri="'. $ecturi .'"'; }
			header($ectheader);
		}
	}
	*/

	// Referrer Policy
	$referrer = esc_attr($GLOBALS['woodkit']->tools->get_tool_option(SECURE_TOOL_NAME, "headers-referrer"));
	if (!empty($referrer)){
		header("Referrer-Policy: $referrer");
	}
}
add_action('send_headers', 'woodkit_tool_secure_headers');
// admin section doesn't have a send_headers action so we abuse init
// https://codex.wordpress.org/Plugin_API/Action_Reference
add_action('admin_init', 'woodkit_tool_secure_headers');