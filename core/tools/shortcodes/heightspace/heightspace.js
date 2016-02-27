(function($) {
	/**
	 * Send shortcode to editor
	 * 
	 */
	$(document).ready(function() {
		$('.tool-shortcodes-heightspace-insert-shortcode').on('click', function(e) {
			var selectedText = tinyMCE.activeEditor.selection.getContent({
				format : "text"
			});
			window.send_to_editor('[heightspace height="36px"/]' + selectedText);
		});
	});
})(jQuery);