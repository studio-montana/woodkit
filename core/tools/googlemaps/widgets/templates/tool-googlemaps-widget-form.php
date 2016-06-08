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
		<td><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', WOODKIT_PLUGIN_TEXT_DOMAIN); ?> : </label></td>
		<td><input type="text" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo esc_attr($title); ?>" /></td>
	</tr>
	<tr>
		<td><label for="<?php echo $this->get_field_id('gmapsaddress'); ?>"><?php _e('Address', WOODKIT_PLUGIN_TEXT_DOMAIN); ?> : </label></td>
		<td><input type="text" name="<?php echo $this->get_field_name('gmapsaddress'); ?>" id="<?php echo $this->get_field_id('gmapsaddress'); ?>" value="<?php echo esc_attr($gmapsaddress); ?>" /></td>
	</tr>
	<tr>
		<td><label for="<?php echo $this->get_field_id('gmapstitle'); ?>"><?php _e('Marker Title', WOODKIT_PLUGIN_TEXT_DOMAIN); ?> : </label></td>
		<td><input type="text" name="<?php echo $this->get_field_name('gmapstitle'); ?>" id="<?php echo $this->get_field_id('gmapstitle'); ?>" value="<?php echo esc_attr($gmapstitle); ?>" /></td>
	</tr>
	
	<tr>
		<td><label for="<?php echo $this->get_field_id('gmapszoom'); ?>"><?php _e('Zoom', WOODKIT_PLUGIN_TEXT_DOMAIN); ?> : </label></td>
		<td>
			<select name="<?php echo $this->get_field_name('gmapszoom'); ?>" id="<?php echo $this->get_field_id('gmapszoom'); ?>">
				<option value="1" <?php if ($gmapszoom == "1"){ ?>selected="selected" <?php } ?>>1</option>
				<option value="2" <?php if ($gmapszoom == "2"){ ?>selected="selected" <?php } ?>>2</option>
				<option value="3" <?php if ($gmapszoom == "3"){ ?>selected="selected" <?php } ?>>3</option>
				<option value="4" <?php if ($gmapszoom == "4"){ ?>selected="selected" <?php } ?>>4</option>
				<option value="5" <?php if ($gmapszoom == "5"){ ?>selected="selected" <?php } ?>>5</option>
				<option value="6" <?php if ($gmapszoom == "6"){ ?>selected="selected" <?php } ?>>6</option>
				<option value="7" <?php if ($gmapszoom == "7"){ ?>selected="selected" <?php } ?>>7</option>
				<option value="8" <?php if ($gmapszoom == "8"){ ?>selected="selected" <?php } ?>>8</option>
				<option value="9" <?php if ($gmapszoom == "9"){ ?>selected="selected" <?php } ?>>9</option>
				<option value="10" <?php if ($gmapszoom == "10"){ ?>selected="selected" <?php } ?>>10</option>
				<option value="11" <?php if ($gmapszoom == "11"){ ?>selected="selected" <?php } ?>>11</option>
				<option value="12" <?php if (empty($gmapszoom) || $gmapszoom == "12"){ ?>selected="selected" <?php } ?>>12</option>
				<option value="13" <?php if ($gmapszoom == "13"){ ?>selected="selected" <?php } ?>>13</option>
				<option value="14" <?php if ($gmapszoom == "14"){ ?>selected="selected" <?php } ?>>14</option>
				<option value="15" <?php if ($gmapszoom == "15"){ ?>selected="selected" <?php } ?>>15</option>
				<option value="16" <?php if ($gmapszoom == "16"){ ?>selected="selected" <?php } ?>>16</option>
			</select>
		</td>
	</tr>
	<tr>
		<td><label for="<?php echo $this->get_field_id('gmapstype'); ?>"><?php _e('Type', WOODKIT_PLUGIN_TEXT_DOMAIN); ?> : </label></td>
		<td>
			<select name="<?php echo $this->get_field_name('gmapstype'); ?>" id="<?php echo $this->get_field_id('gmapstype'); ?>">
				<option value="ROADMAP" <?php if (empty($gmapstype) || $gmapstype == "ROADMAP"){ ?>selected="selected" <?php } ?>>ROADMAP</option>
				<option value="SATELLITE" <?php if ($gmapstype == "SATELLITE"){ ?>selected="selected" <?php } ?>>SATELLITE</option>
				<option value="HYBRID" <?php if ($gmapstype == "HYBRID"){ ?>selected="selected" <?php } ?>>HYBRID</option>
				<option value="TERRAIN" <?php if ($gmapstype == "TERRAIN"){ ?>selected="selected" <?php } ?>>TERRAIN</option>
			</select>
		</td>
	</tr>
	<tr>
		<td><label for="<?php echo $this->get_field_id('gmapswidth'); ?>"><?php _e('Width', WOODKIT_PLUGIN_TEXT_DOMAIN); ?> : </label></td>
		<td><input type="text" name="<?php echo $this->get_field_name('gmapswidth'); ?>" id="<?php echo $this->get_field_id('gmapswidth'); ?>" value="<?php echo esc_attr($gmapswidth); ?>" /></td>
	</tr>
	<tr>
		<td><label for="<?php echo $this->get_field_id('gmapsheight'); ?>"><?php _e('Height', WOODKIT_PLUGIN_TEXT_DOMAIN); ?> : </label></td>
		<td><input type="text" name="<?php echo $this->get_field_name('gmapsheight'); ?>" id="<?php echo $this->get_field_id('gmapsheight'); ?>" value="<?php echo esc_attr($gmapsheight); ?>" /></td>
	</tr>
	<tr>
		<td><label for="<?php echo $this->get_field_id('gmapszoomcontrol'); ?>"><?php _e('Zoom control', WOODKIT_PLUGIN_TEXT_DOMAIN); ?> : </label></td>
		<td>
			<select name="<?php echo $this->get_field_name('gmapszoomcontrol'); ?>" id="<?php echo $this->get_field_id('gmapszoomcontrol'); ?>">
				<option value="true" <?php if (empty($gmapszoomcontrol) || $gmapszoomcontrol == "true"){ ?>selected="selected" <?php } ?>><?php _e("true", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></option>
				<option value="false" <?php if ($gmapszoomcontrol == "false"){ ?>selected="selected" <?php } ?>><?php _e("false", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></option>
			</select>
		</td>
	</tr>
	<tr>
		<td><label for="<?php echo $this->get_field_id('gmapsstreetviewcontrol'); ?>"><?php _e('StreetView control', WOODKIT_PLUGIN_TEXT_DOMAIN); ?> : </label></td>
		<td>
			<select name="<?php echo $this->get_field_name('gmapsstreetviewcontrol'); ?>" id="<?php echo $this->get_field_id('gmapsstreetviewcontrol'); ?>">
				<option value="true" <?php if (empty($gmapsstreetviewcontrol) || $gmapsstreetviewcontrol == "true"){ ?>selected="selected" <?php } ?>><?php _e("true", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></option>
				<option value="false" <?php if ($gmapsstreetviewcontrol == "false"){ ?>selected="selected" <?php } ?>><?php _e("false", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></option>
			</select>
		</td>
	</tr>
	<tr>
		<td><label for="<?php echo $this->get_field_id('gmapsscalecontrol'); ?>"><?php _e('Scale control', WOODKIT_PLUGIN_TEXT_DOMAIN); ?> : </label></td>
		<td>
			<select name="<?php echo $this->get_field_name('gmapsscalecontrol'); ?>" id="<?php echo $this->get_field_id('gmapsscalecontrol'); ?>">
				<option value="false" <?php if (empty($gmapsscalecontrol) || $gmapsscalecontrol == "false"){ ?>selected="selected" <?php } ?>><?php _e("false", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></option>
				<option value="true" <?php if ($gmapsscalecontrol == "true"){ ?>selected="selected" <?php } ?>><?php _e("true", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></option>
			</select>
		</td>
	</tr>
	<tr>
		<td><label for="<?php echo $this->get_field_id('gmapsmaptypecontrol'); ?>"><?php _e('Type control', WOODKIT_PLUGIN_TEXT_DOMAIN); ?> : </label></td>
		<td>
			<select name="<?php echo $this->get_field_name('gmapsmaptypecontrol'); ?>" id="<?php echo $this->get_field_id('gmapsmaptypecontrol'); ?>">
				<option value="true" <?php if (empty($gmapsmaptypecontrol) || $gmapsmaptypecontrol == "true"){ ?>selected="selected" <?php } ?>><?php _e("true", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></option>
				<option value="false" <?php if ($gmapsmaptypecontrol == "false"){ ?>selected="selected" <?php } ?>><?php _e("false", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></option>
			</select>
		</td>
	</tr>
	<tr>
		<td><label for="<?php echo $this->get_field_id('gmapsrotatecontrol'); ?>"><?php _e('Rotate control', WOODKIT_PLUGIN_TEXT_DOMAIN); ?> : </label></td>
		<td>
			<select name="<?php echo $this->get_field_name('gmapsrotatecontrol'); ?>" id="<?php echo $this->get_field_id('gmapsrotatecontrol'); ?>">
				<option value="false" <?php if (empty($gmapsrotatecontrol) || $gmapsrotatecontrol == "false"){ ?>selected="selected" <?php } ?>><?php _e("false", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></option>
				<option value="true" <?php if ($gmapsrotatecontrol == "true"){ ?>selected="selected" <?php } ?>><?php _e("true", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></option>
			</select>
		</td>
	</tr>
	<tr>
		<td><label for="<?php echo $this->get_field_id('gmapsscrollwheel'); ?>"><?php _e('Scroll wheel', WOODKIT_PLUGIN_TEXT_DOMAIN); ?> : </label></td>
		<td>
			<select name="<?php echo $this->get_field_name('gmapsscrollwheel'); ?>" id="<?php echo $this->get_field_id('gmapsscrollwheel'); ?>">
				<option value="true" <?php if (empty($gmapsscrollwheel) || $gmapsscrollwheel == "true"){ ?>selected="selected" <?php } ?>><?php _e("true", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></option>
				<option value="false" <?php if ($gmapsscrollwheel == "false"){ ?>selected="selected" <?php } ?>><?php _e("false", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></option>
			</select>
		</td>
	</tr>
</table>