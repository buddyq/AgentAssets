jQuery(document).ready(function($){
var aveone_upload;
var aveone_selector;
function aveone_add_file(event, selector) {
var upload = $(".uploaded-file"), frame;
var $el = $(this);
aveone_selector = selector;
event.preventDefault();
// Create the media frame.
aveone_upload = wp.media.frames.aveone_upload = wp.media({
title: $el.data('choose'),
button: {
text: $el.data('update'),
close: false
}
});
// When an image is selected, run a callback.
aveone_upload.on( 'select', function() {
    
// Grab the selected attachment.
var attachment = aveone_upload.state().get('selection').first();
aveone_upload.close();
aveone_selector.find('.upload').val(attachment.attributes.url);
if ( attachment.attributes.type == 'image' ) {
aveone_selector.find('.screenshot').empty().hide().append('<img src="' + attachment.attributes.url + '">').slideDown('fast');
}
selector.find('.button').val(aveoneframework_l10n.remove);
aveone_selector.find('.of-background-properties').slideDown();

});

// Finally, open the modal.
aveone_upload.open();
}

function aveone_remove_file(selector) {
    selector.find('.upload').val('');
    selector.find('.of-background-properties').hide();
    selector.find('.screenshot').slideUp();
    selector.find('.button').val(aveoneframework_l10n.upload);
// We don't display the upload button if .upload-notice is present
// This means the user doesn't have the WordPress 3.5 Media Library Support
if ( $('.section-upload .upload-notice').length > 0 ) {
$('.upload-button').remove();
}
//selector.find('.upload-button').show();
}
$('.remove-image, .remove-file, .upload-button').on('click', function(event) {
    var parent_section_id=$(this).attr('id');
    parent_section_id=parent_section_id.replace("remove","section").replace("upload","section"); ;
    if($(this).val()==aveoneframework_l10n.remove)
     aveone_remove_file( $("#"+parent_section_id) );
    else
     aveone_add_file(event, $("#"+parent_section_id));
});

});