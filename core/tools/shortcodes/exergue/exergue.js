(function($) {
	/**
	 * Send shortcode to editor
	 * 
	 */
	$(document).ready(function() {
		$('.tool-shortcodes-exergue-insert-shortcode').on('click', function(e) {
			var selectedText = tinyMCE.activeEditor.selection.getContent({
				format : "text"
			});
			window.send_to_editor('[exergue]' + selectedText + '[/exergue]');
		});
	});
})(jQuery);