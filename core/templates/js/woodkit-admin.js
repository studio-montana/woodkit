/**
 * @package WordPress
 * @version 1.0
 * @author Sébastien Chandonay www.seb-c.com / Cyril Tissot www.cyriltissot.com
 * This file, like this theme, like WordPress, is licensed under the GPL.
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
	});
})(jQuery);