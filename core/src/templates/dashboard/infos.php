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

?>

<div class="woodkit-dashboard-widget">
	<p><?php _e("Thanks for using woodkit.", 'woodkit'); ?></p>
	<p><?php _e("Woodkit offers you lots of awesome tools to improve your experience on wordpress, on the Web. SEO, security, private site, social publication, ...", 'woodkit'); ?></p>
	<p><?php _e("You can discover and manage tools", 'woodkit'); ?>&nbsp;<a href="<?php echo esc_url(get_admin_url(null, 'options-general.php?page=woodkit_options')); ?>"><?php _e("here", 'woodkit'); ?></a>.</p>
	<p><?php _e("Do you need some", 'woodkit'); ?>&nbsp;<a href="<?php echo esc_url(WOODKIT_URL_DOCUMENTATION); ?>" target="_blank"><?php _e("documentation", 'woodkit'); ?></a> ?</p>
	<p style="text-align: right;"><a href="<?php echo esc_url("http://www.studio-montana.com"); ?>" target="_blank">Studio Montana</a></p>
</div>