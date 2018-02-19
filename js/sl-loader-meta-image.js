/* 
 * Contains the code to set an image from the Media Library
 */

jQuery(document).ready(function($) {
	

	var mediaUploader;
	var mediaUploader2;

	$('#upload_reviewer_img_button').click(function(e) {
		e.preventDefault();
		// If the uploader object has already been created, reopen the dialog
		if(mediaUploader) {
			mediaUploader.open();
			return;
		}

		// Extend the wp.media object
		mediaUploader = wp.media.frames.file_frame = wp.media({
			title: 'Choose Image',
			button: {
			text: 'Choose Image'
		}, multiple: false });

		// When a file is selected, grab the URL and set it as the text field's value
		mediaUploader.on('select', function() {
			attachment = mediaUploader.state().get('selection').first().toJSON();
			$('#sl_rloader_reviewer_img').val(attachment.url);
			$('td#rProfile').html('');
			$('td#rProfile').html('<div class="reviewerImg"><img id="meta_reviewer_img" src="" alt="Reviewer profile" width="150" /></div>');
			$('#meta_reviewer_img').attr('src',$('#sl_rloader_reviewer_img').val() );
		});
		// Open the uploader dialog
		mediaUploader.open();
	});

	$('#upload_company_logo_button').click(function(e) {
		e.preventDefault();
		// If the uploader object has already been created, reopen the dialog
		if(mediaUploader2) {
			mediaUploader2.open();
			return;
		}

		// Extend the wp.media object
		mediaUploader2  = wp.media.frames.file_frame = wp.media({
			title: 'Choose Image',
			button: {
				text:'Choose Image'
			}, multiple: false 
		});

		// When a file is selected, grab the URL and set it as the text field's value
		mediaUploader2.on('select', function() {
			attachment2 = mediaUploader2.state().get('selection').first().toJSON();
			$('#sl_rloader_company_logo').val(attachment2.url);
			$('td#rLogo').html('');
			$('td#rLogo').html('<div class="reviewerLogo"><img id="meta_company_logo" src="" alt="Reviewer image" width="150" /></div>');
			$('img#meta_company_logo').attr('src', $('#sl_rloader_company_logo').val() );
		});
		// Open the uploader dialog
		mediaUploader2.open();
	});

});


