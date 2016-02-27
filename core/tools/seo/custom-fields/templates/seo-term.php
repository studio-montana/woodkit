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
<table class="form-table">
	<tr class="form-field seo-box seo-title">
		<td colspan="2"><h3>SEO</h3></td>
	</tr>
	<!-- meta-title -->
	<tr class="form-field seo-box">
		<th class="seo-label">
			<label for="<?php echo SEO_CUSTOMFIELD_METATITLE; ?>"><?php _e("Meta-title", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></label>
		</th>
		<td class="seo-input">
			<input type="text" name="<?php echo SEO_CUSTOMFIELD_METATITLE; ?>" id="<?php echo SEO_CUSTOMFIELD_METATITLE; ?>" value="<?php echo get_option("term_".$term->term_id."_".SEO_CUSTOMFIELD_METATITLE); ?>" />
		</td>
	</tr>
	<!-- meta-description -->
	<tr class="form-field seo-box">
		<th class="seo-label">
			<label for="<?php echo SEO_CUSTOMFIELD_METADESCRIPTION; ?>"><?php _e("Meta-description", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></label>
		</th>
		<td class="seo-input">
			<input type="text" name="<?php echo SEO_CUSTOMFIELD_METADESCRIPTION; ?>" id="<?php echo SEO_CUSTOMFIELD_METADESCRIPTION; ?>" value="<?php echo get_option("term_".$term->term_id."_".SEO_CUSTOMFIELD_METADESCRIPTION); ?>" />
		</td>
	</tr>
	<!-- meta-keywords -->
	<tr class="form-field seo-box">
		<th class="seo-label">
			<label for="<?php echo SEO_CUSTOMFIELD_METAKEYWORDS; ?>"><?php _e("Meta-keyword", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></label>
		</th>
		<td class="seo-input">
			<input type="text" name="<?php echo SEO_CUSTOMFIELD_METAKEYWORDS; ?>" id="<?php echo SEO_CUSTOMFIELD_METAKEYWORDS; ?>" value="<?php echo get_option("term_".$term->term_id."_".SEO_CUSTOMFIELD_METAKEYWORDS); ?>" />
		</td>
	</tr>
</table>