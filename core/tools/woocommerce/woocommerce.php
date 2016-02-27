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
 * WooCommerce Tool (plugin's supports - http://docs.woothemes.com/document/third-party-woodkit-theme-compatibility/)
 * @package WordPress
 * @subpackage Woodkit
 * @since Woodkit 1.0
 * @author Sébastien Chandonay www.seb-c.com / Cyril Tissot www.cyriltissot.com
 */

/**
 * SUPPORTS
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_before_main_content', 'woodkit_woocommerce_support_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'woodkit_woocommerce_support_wrapper_end', 10);
function woodkit_woocommerce_support_wrapper_start() {
	echo '<section id="main">';
}
function woodkit_woocommerce_support_wrapper_end() {
	echo '</section>';
}
add_action('woodkit_after_setup_theme', 'woodkit_woocommerce_support_after_setup_theme');
function woodkit_woocommerce_support_after_setup_theme() {
    add_theme_support('woocommerce');
}