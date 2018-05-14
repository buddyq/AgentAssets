jQuery(document).ready(function() {
        
        jQuery('.ajax-loader').hide();
        
        jQuery('a.blog-button-toggle').click(function(e) {
            e.preventDefault();
            
            var elem = jQuery(this);
            console.log('elem = '+elem);
            var blog_id     = jQuery(this).attr('role'); 
            var live_status = jQuery(this).attr('rel');
            elem.attr('disabled', true);
            // console.log(e.parent());
            jQuery(this).parent().show();
            jQuery.ajax({
                url: ajaxurl, 
                type: 'POST',
                dataType: 'json',
                data: { 
                  action: 'toggle_livesite', 
                  id: blog_id,
                  live_status: live_status
                },
                success: function( response ){
                  if(true == response.success){
                    // console.log(elem);
                    elem.prop('disabled', false);
                    jQuery('.ajax-loader').hide();
                    // change rel attribute
                    // console.log("live_status = "+live_status);
                    if ( live_status == 'isLive'){
                      elem.attr('rel', 'notLive');
                      elem.html('Go Live');
                      elem.removeClass('isLive');
                      elem.addClass('notLive');
                    }else{
                      elem.attr('rel', 'isLive');
                      elem.html('Live Site');
                      elem.removeClass('notLive');
                      elem.addClass('isLive');
                    }
                  }

                },
                error: function( error ){  
                  alert("Error!");
                }  
            }); 

    }); 
}); 
