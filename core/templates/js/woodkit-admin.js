/**
 * @package WordPress
 * @version 1.0
 * @author Sébastien Chandonay www.seb-c.com / Cyril Tissot www.cyriltissot.com This file, like this theme, like WordPress, is licensed under the GPL.
 */

(function($) {
	$(document).ready(function() {

		/**
		 * date picker on date fields (require jquery-ui-datepicker)
		 */
		$("input[type='date']").datepicker({
			dateFormat : 'dd/mm/yy'
		});
		$("input.datepicker").datepicker({
			dateFormat : 'dd/mm/yy'
		});

		/**
		 * custom color picker options
		 */
		function woodkit_customize_color_picker($elem) {
			var options = {
					palettes: CustomColorPicker.palettes,
			};
			$elem.iris(options);
		}

		$("input[name='backgroundcolor-code']").each(function() {
			woodkit_customize_color_picker($(this));
		});

		/** must be called on modal box load */
		function woodkit_customize_color_picker_divi() {
			$(".et-pb-color-picker-hex").each(function() {
				woodkit_customize_color_picker($(this));
			});
			$(".et-builder-color-picker-alpha").each(function() {
				woodkit_customize_color_picker($(this));
			});
		}
		$(document).on("woodkit-on-divi-modal-box-opened", function(e) {
			woodkit_customize_color_picker_divi();
		});

	});
})(jQuery);