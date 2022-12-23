// (function( $ ) {
// 	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

// })( jQuery );

// jQuery( "#accordion" ).accordion();

// Uploading files
var file_frame;

jQuery('#upload_image_button').live('click', function( event ){

event.preventDefault();

// If the media frame already exists, reopen it.
if ( file_frame ) {
  file_frame.open();
  return;
}

// Create the media frame.
file_frame = wp.media.frames.file_frame = wp.media({
  title: jQuery( this ).data( 'uploader_title' ),
  button: {
    text: jQuery( this ).data( 'uploader_button_text' ),
  },
  multiple: false  // Set to true to allow multiple files to be selected
});

// When an image is selected, run a callback.
file_frame.on( 'select', function() {
  // We set multiple to false so only get one image from the uploader
  attachment = file_frame.state().get('selection').first().toJSON();

  // Do something with attachment.id and/or attachment.url here
  $( '#image_attachment_url' ).attr( 'value', attachment.url );
});

// Finally, open the modal
file_frame.open();
});