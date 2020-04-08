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
<table>
	<tr>
		<td><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'woodkit'); ?> : </label></td>
		<td><input type="text" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo esc_attr($title); ?>" /></td>
	</tr>
	<tr>
		<td><label for="<?php echo $this->get_field_id('nb'); ?>"><?php _e('Number', 'woodkit'); ?> : </label></td>
		<td><input type="number" name="<?php echo $this->get_field_name('nb'); ?>" id="<?php echo $this->get_field_id('nb'); ?>" value="<?php echo esc_attr($nb); ?>" /></td>
	</tr>
</table>