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
$selected = 'selected="selected"';
?>
<table class="tool-navigation-widget-options">
	<tr>
		<?php 
		$field_name = $sidebar_id.$widget_obj->id."orderby";
		$orderby = @get_post_meta($post_id, $field_name, true);
		?>
		<td>
			<label for="<?php echo $field_name; ?>"><?php _e('Order by', WOODKIT_PLUGIN_TEXT_DOMAIN); ?> : </label>
		</td>
		<td>
			<select name="<?php echo $field_name; ?>" id="<?php echo $field_name; ?>">
				<option value="default"<?php if(empty($orderby) || $orderby == 'default'){ echo $selected; }; ?>><?php _e("default", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></option>
				<option value="menu_order"<?php if(!empty($orderby) && $orderby == 'menu_order'){ echo $selected; }; ?>><?php _e("position", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></option>
				<option value="post_date"<?php if(!empty($orderby) && $orderby == 'post_date'){ echo $selected; }; ?>><?php _e("date", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></option>
				<option value="post_modified"<?php if(!empty($orderby) && $orderby == 'post_modified'){ echo $selected; }; ?>><?php _e("modification date", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></option>
				<option value="post_title"<?php if(!empty($orderby) && $orderby == 'post_title'){ echo $selected; }; ?>><?php _e("title", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></option>
			</select>
		</td>
	</tr>
	<tr>
		<?php 
		$field_name = $sidebar_id.$widget_obj->id."order";
		$order = @get_post_meta($post_id, $field_name, true);
		?>
		<td>
			<label for="<?php echo $field_name; ?>"><?php echo __("Order", WOODKIT_PLUGIN_TEXT_DOMAIN); ?> : </label>
		</td>
		<td>
			<select name="<?php echo $field_name; ?>" id="<?php echo $field_name; ?>">
				<option value="default"<?php if(empty($order) || $order == 'default'){ echo $selected; }; ?>><?php _e("default", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></option>
				<option value="asc"<?php if(!empty($order) && $order == 'asc'){ echo $selected; }; ?>><?php _e("ascendant", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></option>
				<option value="desc"<?php if(!empty($order) && $order == 'desc'){ echo $selected; }; ?>><?php _e("descendant", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></option>
			</select>
		</td>
	</tr>
</table>