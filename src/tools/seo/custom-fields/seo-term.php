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
 * Register action for seo extra fields for native taxonomies
 */
add_action('category_edit_form_fields', 'woodkit_seo_add_taxonomy_fields');
add_action('edited_category', 'woodkit_seo_save_taxonomy_fields');
add_action('post_tag_edit_form_fields', 'woodkit_seo_add_taxonomy_fields');
add_action('edited_post_tag', 'woodkit_seo_save_taxonomy_fields');

/**
 * Register action for seo extra fields for custom taxonomies
*/
add_action('registered_taxonomy', function ($taxonomy, $object_type) {
	$exluded_taxonomies = apply_filters('woodkit-seo-customfields-excluded-taxonomies', array());
	if (!in_array($taxonomy, $exluded_taxonomies)){
		add_action($taxonomy.'_edit_form_fields', 'woodkit_seo_add_taxonomy_fields');
		add_action('edited_'.$taxonomy, 'woodkit_seo_save_taxonomy_fields');
	}
}, 10, 2);

/**
 * Save seo taxonomy extra fields
*/
function woodkit_seo_save_taxonomy_fields($term_id) {
	if (!empty($_POST['_seo_meta_title'])){
		update_term_meta($term_id, '_seo_meta_title', sanitize_text_field($_POST['_seo_meta_title']));
	}else{
		delete_term_meta($term_id, '_seo_meta_title');
	}
	if (!empty($_POST['_seo_meta_description'])){
		update_term_meta($term_id, '_seo_meta_description', sanitize_text_field($_POST['_seo_meta_description']));
	}else{
		delete_term_meta($term_id,'_seo_meta_description');
	}
	if (!empty($_POST['_seo_meta_keywords'])){
		update_term_meta($term_id, '_seo_meta_keywords', sanitize_text_field($_POST['_seo_meta_keywords']));
	}else{
		delete_term_meta($term_id,'_seo_meta_keywords');
	}
}

/**
 * Add seo extra fields
*/
function woodkit_seo_add_taxonomy_fields($term) { ?>
<div class="form-field term-group" >
	<table class="form-table">
		<tbody>
			<!-- meta-title -->
			<tr class="form-field seo-box">
				<th scope="row" class="seo-label">
					<label for="_seo_meta_title"><?php _e("Meta-title", 'woodkit'); ?></label>
				</th>
				<td class="seo-input">
					<input type="text" name="_seo_meta_title" id="_seo_meta_title" value="<?php echo get_term_meta($term->term_id, '_seo_meta_title', true); ?>" />
				</td>
			</tr>
			<!-- meta-description -->
			<tr class="form-field term-name-wrap seo-box">
				<th scope="row" class="seo-label">
					<label for="_seo_meta_description"><?php _e("Meta-description", 'woodkit'); ?></label>
				</th>
				<td class="seo-input">
					<input type="text" name="_seo_meta_description" id="_seo_meta_description" value="<?php echo get_term_meta($term->term_id, '_seo_meta_description', true); ?>" />
				</td>
			</tr>
			<!-- meta-keywords -->
			<tr class="form-field term-name-wrap seo-box">
				<th scope="row" class="seo-label">
					<label for="_seo_meta_keywords"><?php _e("Meta-keyword", 'woodkit'); ?></label>
				</th>
				<td class="seo-input">
					<input type="text" name="_seo_meta_keywords" id="_seo_meta_keywords" value="<?php echo get_term_meta($term->term_id, '_seo_meta_keywords', true); ?>" />
				</td>
			</tr>
		</tbody>
	</table>
</div>
<?php }
