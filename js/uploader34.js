jQuery(document).ready(function() {
var backup = window.send_to_editor;	
jQuery('.upload_image_button').live("click", function() {								
 formfield = jQuery(this).prev().attr('name');
 tb_show('Upload Images', myUpload.uploader +'?type=image&amp;TB_iframe=true');
 
  window.send_to_editor = function(html) {
	imgurl = jQuery(html).filter("[href]").attr('href');
	jQuery('#upload_image').val(imgurl); 
	tb_remove();
	window.send_to_editor = backup;
};
 return false;
});



});