/**
 * SASS
 */
import '../sass/frontend.scss';

/**
 * JavaScript
 */

/**
 * Add here your JavasScript code
 */

 (function ($) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 */

	$(document).on('submit', '#gs-post-form', function (e) {
		e.preventDefault();
		var formData = new FormData();
		formData.append("gs_post_featured_image", $('#gs_post_featured_image')[0].files[0]);
		formData.append("action", "gs_do_create_post");
		formData.append("gs_nonce", plugin_frontend_script.nonce);
		formData.append("gs_post_title", $('#gs_post_title').val());
		formData.append("gs_post_type", $('#gs_post_type').val());
		formData.append("gs_post_content", $('#gs_post_content').val());
		formData.append("gs_post_excerpt", $('#gs_post_excerpt').val());

		$.ajax({
			url: plugin_frontend_script.ajaxurl,
			type: 'post',
			processData: false,
			contentType: false,
			data: formData,
            success: function(data) {
                $(".gs-result").html(data);
            },
		});
	});

})(jQuery);