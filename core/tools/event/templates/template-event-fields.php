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
<div id="tool-gallery-display-gallery" class="custom-fields-section custom-fields-section-side">
	<div class="custom-fields-section-content">
		<input type="hidden" name="<?php echo EVENT_NONCE_ACTION; ?>" value="<?php echo wp_create_nonce(EVENT_NONCE_ACTION);?>" />
		<table class="fields">
			<tr valign="top">
				<th colspan="2" class="metabox_label_column" align="left" valign="middle"><label
					for="meta_event_date_begin"><?php _e('Begin', WOODKIT_PLUGIN_TEXT_DOMAIN); ?></label>
				</th>
			</tr>
			<tr valign="top">
				<?php 
				$meta_date_begin = !empty($post) ? get_post_meta($post->ID, "meta_event_date_begin", true) : "";
				$meta_date_begin_s = "";
				$meta_hour_begin = "";
				$meta_minute_begin = "";
				if (!empty($meta_date_begin) && is_numeric($meta_date_begin)){
					$meta_date_begin = new DateTime("@".$meta_date_begin);
					if ($meta_date_begin){
						$meta_date_begin_s = $meta_date_begin->format("d")."/".$meta_date_begin->format("m")."/".$meta_date_begin->format("Y");
						$meta_hour_begin = $meta_date_begin->format("H");
						$meta_minute_begin = $meta_date_begin->format("i");
					}
				}
				if (empty($meta_date_begin_s)){
					$meta_date_begin_s = date("d/m/Y");
						$meta_hour_begin = "08";
						$meta_minute_begin = "00";
				}
				?>
				<td colspan="2" valign="middle">
					<input type="text" class="datepicker" name="meta_event_date_begin" id="meta_event_date_begin" value="<?php echo $meta_date_begin_s; ?>" placeholder="<?php _e('dd/mm/yyyy', WOODKIT_PLUGIN_TEXT_DOMAIN); ?>"/>
				</td>
			</tr>
			<tr valign="top">
				<td valign="middle">
					<select name="meta_event_hour_begin" id="meta_event_hour_begin">
						<option value="00" <?php if ($meta_hour_begin == '00'){ echo ' selected="selected"'; } ?>>00</option>
						<option value="01" <?php if ($meta_hour_begin == '01'){ echo ' selected="selected"'; } ?>>01</option>
						<option value="02" <?php if ($meta_hour_begin == '02'){ echo ' selected="selected"'; } ?>>02</option>
						<option value="03" <?php if ($meta_hour_begin == '03'){ echo ' selected="selected"'; } ?>>03</option>
						<option value="04" <?php if ($meta_hour_begin == '04'){ echo ' selected="selected"'; } ?>>04</option>
						<option value="05" <?php if ($meta_hour_begin == '05'){ echo ' selected="selected"'; } ?>>05</option>
						<option value="06" <?php if ($meta_hour_begin == '06'){ echo ' selected="selected"'; } ?>>06</option>
						<option value="07" <?php if ($meta_hour_begin == '07'){ echo ' selected="selected"'; } ?>>07</option>
						<option value="08" <?php if ($meta_hour_begin == '08'){ echo ' selected="selected"'; } ?>>08</option>
						<option value="09" <?php if ($meta_hour_begin == '09'){ echo ' selected="selected"'; } ?>>09</option>
						<option value="10" <?php if ($meta_hour_begin == '10'){ echo ' selected="selected"'; } ?>>10</option>
						<option value="11" <?php if ($meta_hour_begin == '11'){ echo ' selected="selected"'; } ?>>11</option>
						<option value="12" <?php if ($meta_hour_begin == '12'){ echo ' selected="selected"'; } ?>>12</option>
						<option value="13" <?php if ($meta_hour_begin == '13'){ echo ' selected="selected"'; } ?>>13</option>
						<option value="14" <?php if ($meta_hour_begin == '14'){ echo ' selected="selected"'; } ?>>14</option>
						<option value="15" <?php if ($meta_hour_begin == '15'){ echo ' selected="selected"'; } ?>>15</option>
						<option value="16" <?php if ($meta_hour_begin == '16'){ echo ' selected="selected"'; } ?>>16</option>
						<option value="17" <?php if ($meta_hour_begin == '17'){ echo ' selected="selected"'; } ?>>17</option>
						<option value="18" <?php if ($meta_hour_begin == '18'){ echo ' selected="selected"'; } ?>>18</option>
						<option value="19" <?php if ($meta_hour_begin == '19'){ echo ' selected="selected"'; } ?>>19</option>
						<option value="20" <?php if ($meta_hour_begin == '20'){ echo ' selected="selected"'; } ?>>20</option>
						<option value="21" <?php if ($meta_hour_begin == '21'){ echo ' selected="selected"'; } ?>>21</option>
						<option value="22" <?php if ($meta_hour_begin == '22'){ echo ' selected="selected"'; } ?>>22</option>
						<option value="23" <?php if ($meta_hour_begin == '23'){ echo ' selected="selected"'; } ?>>23</option>
					</select>
				</td>
				<td valign="middle">
					<select name="meta_event_minute_begin" id="meta_event_minute_begin">
						<option value="00" <?php if ($meta_minute_begin == '00'){ echo ' selected="selected"'; } ?>>00</option>
						<option value="15" <?php if ($meta_minute_begin == '15'){ echo ' selected="selected"'; } ?>>15</option>
						<option value="30" <?php if ($meta_minute_begin == '30'){ echo ' selected="selected"'; } ?>>30</option>
						<option value="45" <?php if ($meta_minute_begin == '45'){ echo ' selected="selected"'; } ?>>45</option>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<td colspan="2">
					<hr />
				</td>
			</tr>
			<tr valign="top">
				<th colspan="2" class="metabox_label_column" align="left" valign="middle"><label
					for="meta_event_date_end"><?php _e('End', WOODKIT_PLUGIN_TEXT_DOMAIN); ?></label>
				</th>
			</tr>
			<tr valign="top">
				<?php 
				$meta_date_end = !empty($post) ? get_post_meta($post->ID, "meta_event_date_end", true) : "";
				$meta_date_end_s = "";
				$meta_hour_end = "";
				$meta_minute_end = "";
				if (!empty($meta_date_end) && is_numeric($meta_date_end)){
					$meta_date_end = new DateTime("@".$meta_date_end);
					if ($meta_date_end){
						$meta_date_end_s = $meta_date_end->format("d")."/".$meta_date_end->format("m")."/".$meta_date_end->format("Y");
						$meta_hour_end = $meta_date_end->format("H");
						$meta_minute_end = $meta_date_end->format("i");
					}
				}
				if (empty($meta_date_end_s)){
					$meta_date_end_s = date("d/m/Y");
						$meta_hour_end = "18";
						$meta_minute_end = "00";
				}
				?>
				<td colspan="2" valign="middle">
					<input type="text" class="datepicker" name="meta_event_date_end" id="meta_event_date_end" value="<?php echo $meta_date_end_s; ?>" placeholder="<?php _e('dd/mm/yyyy', WOODKIT_PLUGIN_TEXT_DOMAIN); ?>"/>
				</td>
			</tr>
			<tr valign="top">
				<td valign="middle">
					<select name="meta_event_hour_end" id="meta_event_hour_end">
						<option value="00" <?php if ($meta_hour_end == '00'){ echo ' selected="selected"'; } ?>>00</option>
						<option value="01" <?php if ($meta_hour_end == '01'){ echo ' selected="selected"'; } ?>>01</option>
						<option value="02" <?php if ($meta_hour_end == '02'){ echo ' selected="selected"'; } ?>>02</option>
						<option value="03" <?php if ($meta_hour_end == '03'){ echo ' selected="selected"'; } ?>>03</option>
						<option value="04" <?php if ($meta_hour_end == '04'){ echo ' selected="selected"'; } ?>>04</option>
						<option value="05" <?php if ($meta_hour_end == '05'){ echo ' selected="selected"'; } ?>>05</option>
						<option value="06" <?php if ($meta_hour_end == '06'){ echo ' selected="selected"'; } ?>>06</option>
						<option value="07" <?php if ($meta_hour_end == '07'){ echo ' selected="selected"'; } ?>>07</option>
						<option value="08" <?php if ($meta_hour_end == '08'){ echo ' selected="selected"'; } ?>>08</option>
						<option value="09" <?php if ($meta_hour_end == '09'){ echo ' selected="selected"'; } ?>>09</option>
						<option value="10" <?php if ($meta_hour_end == '10'){ echo ' selected="selected"'; } ?>>10</option>
						<option value="11" <?php if ($meta_hour_end == '11'){ echo ' selected="selected"'; } ?>>11</option>
						<option value="12" <?php if ($meta_hour_end == '12'){ echo ' selected="selected"'; } ?>>12</option>
						<option value="13" <?php if ($meta_hour_end == '13'){ echo ' selected="selected"'; } ?>>13</option>
						<option value="14" <?php if ($meta_hour_end == '14'){ echo ' selected="selected"'; } ?>>14</option>
						<option value="15" <?php if ($meta_hour_end == '15'){ echo ' selected="selected"'; } ?>>15</option>
						<option value="16" <?php if ($meta_hour_end == '16'){ echo ' selected="selected"'; } ?>>16</option>
						<option value="17" <?php if ($meta_hour_end == '17'){ echo ' selected="selected"'; } ?>>17</option>
						<option value="18" <?php if ($meta_hour_end == '18'){ echo ' selected="selected"'; } ?>>18</option>
						<option value="19" <?php if ($meta_hour_end == '19'){ echo ' selected="selected"'; } ?>>19</option>
						<option value="20" <?php if ($meta_hour_end == '20'){ echo ' selected="selected"'; } ?>>20</option>
						<option value="21" <?php if ($meta_hour_end == '21'){ echo ' selected="selected"'; } ?>>21</option>
						<option value="22" <?php if ($meta_hour_end == '22'){ echo ' selected="selected"'; } ?>>22</option>
						<option value="23" <?php if ($meta_hour_end == '23'){ echo ' selected="selected"'; } ?>>23</option>
					</select>
				</td>
				<td valign="middle">
					<select name="meta_event_minute_end" id="meta_event_minute_end">
						<option value="00" <?php if ($meta_minute_end == '00'){ echo ' selected="selected"'; } ?>>00</option>
						<option value="15" <?php if ($meta_minute_end == '15'){ echo ' selected="selected"'; } ?>>15</option>
						<option value="30" <?php if ($meta_minute_end == '30'){ echo ' selected="selected"'; } ?>>30</option>
						<option value="45" <?php if ($meta_minute_end == '45'){ echo ' selected="selected"'; } ?>>45</option>
					</select>
				</td>
			</tr>
		</table>
	</div>
</div>
