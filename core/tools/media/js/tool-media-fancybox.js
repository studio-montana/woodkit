/**
 * MEDIA Tool
 * 
 * @package WordPress
 * @subpackage Woodkit
 * @since Woodkit 1.0
 * @author Sébastien Chandonay www.seb-c.com / Cyril Tissot www.cyriltissot.com
 */
(function($) {
	$(".fancybox").fancybox({
		beforeShow : function() {
	        this.title = $(this.element).attr('data-fancybox-title');
	    },
		helpers : {
			title : {
				type : 'inside'
			},
			overlay : {
				css : {
					'background' : 'rgba(0, 0, 0, 0.85)'
				}
			}
		},
		padding : 0
	});
})(jQuery);
