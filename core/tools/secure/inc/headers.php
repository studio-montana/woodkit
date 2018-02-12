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

function woodkit_tool_secure_headers() {
	if ( headers_sent() ) {
		trace_err("Headers already sent. Woodkit secure tool unable to process");
	}

	// HSTS - have to uncomment in next version
	/*
	if (is_ssl()){
		$time = esc_attr(woodkit_get_option("tool-secure-headers-hsts-time"));
		$subdomain = esc_attr(woodkit_get_option("tool-secure-headers-hsts-subdomains"));
		$preload = esc_attr(woodkit_get_option("tool-secure-headers-hsts-preload"));
		if ( ctype_digit($time)  ) {
			$subdomain_output = $subdomain > 0 ? "; includeSubDomains" : "";
			$preload_output = $preload > 0 ? "; preload" : "";
			header("Strict-Transport-Security: max-age=$time$subdomain_output$preload_output");
		}
	}
	*/

	// No Sniff
	$nosniff = esc_attr(woodkit_get_option("tool-secure-headers-nosniff"));
	if ($nosniff == 'on') {
		send_nosniff_header();
	}

	// XSS
	$xss = esc_attr(woodkit_get_option("tool-secure-headers-xss"));
	if ($xss == 'on') {
		header("X-XSS-Protection: 1; mode=block");
	}

	// Frame Options
	$frame = esc_attr(woodkit_get_option("tool-secure-headers-frame"));
	if ($frame == 'on') {
		send_frame_options_header();
	}

	// Powered by
	$poweredby = esc_attr(woodkit_get_option("tool-secure-headers-poweredby"));
	if ($poweredby == 'on') {
		header("X-Powered-By: unknown");
	}

	// HPKP - have to uncomment in next version
	/*
	if (is_ssl()){
		$pinkey1 = esc_attr(woodkit_get_option("tool-secure-headers-hpkp-key1"));
		$pinkey2 = esc_attr(woodkit_get_option("tool-secure-headers-hpkp-key2"));
		$pinkey3 = esc_attr(woodkit_get_option("tool-secure-headers-hpkp-key3"));
		$pintime = esc_attr(woodkit_get_option("tool-secure-headers-hpkp-time"));
		$pinsubdomain = esc_attr(woodkit_get_option("tool-secure-headers-hpkp-subdomains"));
		$pinuri = woodkit_get_option("tool-secure-headers-hpkp-uri");
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

	// Referrer Policy
	$referrer = esc_attr(woodkit_get_option("tool-secure-headers-referrer"));
	if (!empty($referrer)){
		header("Referrer-Policy: $referrer");
	}
}
add_action('send_headers', 'woodkit_tool_secure_headers');
// admin section doesn't have a send_headers action so we abuse init
// https://codex.wordpress.org/Plugin_API/Action_Reference
add_action('admin_init', 'woodkit_tool_secure_headers');