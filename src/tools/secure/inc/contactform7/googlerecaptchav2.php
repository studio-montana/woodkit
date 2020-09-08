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
 * CONTACTFORM7 Tool - Add module [googlerecaptchav2] to Contact Form 7 plugin
 * @package WordPress
 * @subpackage Woodkit
 * @since Woodkit 1.0
 * @author Sébastien Chandonay www.seb-c.com / Cyril Tissot www.cyriltissot.com
*/

/**
 * Shortcode handler
*/
function wpcf7_add_shortcode_googlerecaptchav2() {
	// wpcf7_add_form_tag - Contact Form 7 - from version 4.6
	if (function_exists("wpcf7_add_form_tag")){
		wpcf7_add_form_tag(array('googlerecaptchav2'),
		'wpcf7_googlerecaptchav2_shortcode_handler', true);
	}else{
		wpcf7_add_shortcode(array('googlerecaptchav2'),
		'wpcf7_googlerecaptchav2_shortcode_handler', true);
	}
}
add_action( 'wpcf7_init', 'wpcf7_add_shortcode_googlerecaptchav2');

function wpcf7_googlerecaptchav2_shortcode_handler($tag) {
	if (class_exists('WPCF7_FormTag')){
		$tag = new WPCF7_FormTag($tag);
	}else{
		$tag = new WPCF7_Shortcode($tag);
	}
	if (empty($tag->name))
		return '';

	$use_placeholder = false;
	if ($tag->has_option('useplaceholder')) {
		$use_placeholder = true;
	}

	$use_label = false;
	if ($tag->has_option('uselabel')) {
		$use_label = true;
	}

	if ($use_placeholder == false && $use_label == false){ // old version support
		$use_placeholder = true;
	}

	$validation_error = wpcf7_get_validation_error($tag->name);
	$html = '<span class="wpcf7-form-control-wrap '.sanitize_html_class($tag->name).'">';
	$html .= apply_filters('tool_contactform7_googlerecaptchav2_field', $tag->name, $use_placeholder, $use_label);
	$html .= '</span>';
	return $html;
}

/**
 * Validation filter
*/
function wpcf7_googlerecaptchav2_validation_filter($result, $tag) {
	if (class_exists('WPCF7_FormTag')){
		$tag = new WPCF7_FormTag($tag);
	}else{
		$tag = new WPCF7_Shortcode($tag);
	}
	$errors = apply_filters('tool_contactform7_googlerecaptchav2_validatation', $tag->name);
	if (!empty($errors)){
		foreach ($errors as $error){
			$result->invalidate($tag, $error->get_error_message());
		}
	}
	return $result;
}
add_filter( 'wpcf7_validate_googlerecaptchav2', 'wpcf7_googlerecaptchav2_validation_filter', 10, 2 );

/**
 * Tag generator
*/
if (is_admin()){
	add_action('admin_init', 'wpcf7_add_tag_generator_googlerecaptchav2', 20);
}

function wpcf7_add_tag_generator_googlerecaptchav2() {
	$tag_generator = WPCF7_TagGenerator::get_instance();
	$tag_generator->add( 'googlerecaptchav2', __( 'Google Recaptcha V2', 'woodkit'),
			'wpcf7_tag_generator_googlerecaptchav2' );
}

function wpcf7_tag_generator_googlerecaptchav2( $contact_form, $args = '' ) {
	$args = wp_parse_args( $args, array() );
	$type = 'googlerecaptchav2';
	$description = __("Generate a form-tag for Google Recaptcha V2.", 'woodkit');

	?>
<div class="control-box">
	<fieldset>
		<legend>
			<?php echo esc_html($description); ?>
		</legend>

		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><label
						for="<?php echo esc_attr( $args['content'] . '-name' ); ?>"><?php echo esc_html( __( 'Name', 'contact-form-7' ) ); ?>
					</label></th>
					<td><input type="text" name="name" class="tg-name oneline"
						id="<?php echo esc_attr( $args['content'] . '-name' ); ?>" /></td>
				</tr>
			</tbody>
		</table>
	</fieldset>
</div>

<div class="insert-box">
	<input type="text" name="<?php echo $type; ?>" class="tag code"
		readonly="readonly" onfocus="this.select()" />

	<div class="submitbox">
		<input type="button" class="button button-primary insert-tag"
			value="<?php echo esc_attr( __( 'Insert Tag', 'contact-form-7' ) ); ?>" />
	</div>

	<br class="clear" />

	<p class="description mail-tag">
		<label for="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>"><?php echo sprintf( esc_html( __( "To use the value input through this field in a mail field, you need to insert the corresponding mail-tag (%s) into the field on the Mail tab.", 'contact-form-7' ) ), '<strong><span class="mail-tag"></span></strong>' ); ?><input
			type="text" class="mail-tag code hidden" readonly="readonly"
			id="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>" /> </label>
	</p>
</div>
<?php
}
