jQuery(document).ready(function($){
 jQuery('.upload_image_button').click(function() {

    var send_attachment_bkp = wp.media.editor.send.attachment;

    wp.media.editor.send.attachment = function(props, attachment) {

        jQuery('.attachment-thumbnail').attr('src', attachment.url);
        jQuery('#upload_image').val(attachment.url);

        wp.media.editor.send.attachment = send_attachment_bkp;
    }

    wp.media.editor.open();

    return false;       
});
});