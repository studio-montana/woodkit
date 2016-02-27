(function($) {
	/**
	 * Send shortcode to editor
	 * 
	 */
	$(document).ready(function() {
		$(".tool-shortcodes-icons-box-close").on('click', function(e){
			var id_editor = $(this).data("id-editor");
			$("#tool-shortcodes-icons-box-"+id_editor).fadeOut();
		});
		$('.tool-shortcodes-icons-insert-shortcode').on('click', function(e) {
			var id_editor = $(this).data("id-editor");
			$("#tool-shortcodes-icons-box-"+id_editor).fadeIn();
		});
		$(".tool-shortcodes-icons-insert-action").on('click', function(e){
			var icon = $(this).data("icon");
			var id_editor = $(this).data("id-editor");
			var selectedText = tinyMCE.activeEditor.selection.getContent({
				format : "text"
			});
			window.send_to_editor('[icons class="'+icon+'" style=""/]' + selectedText);
			$("#tool-shortcodes-icons-box-"+id_editor).fadeOut();
		});
	});
})(jQuery);