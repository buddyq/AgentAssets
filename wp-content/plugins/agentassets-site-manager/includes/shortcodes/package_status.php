<?php

add_shortcode('package_status','mism_package_status_display');

function mism_package_status_display($atts)
{
    $atts = shortcode_atts(
        array(
            'title' => '',
        ), $atts, 'package_status' );

    $assigned_package = get_user_meta(get_current_user_id(),'assigned_package',TRUE);
    if($assigned_package)
    {
        $package_status = get_the_title($assigned_package);
    }
    else
    {
        $package_status = __('No Current Package found','mism').", ".  sprintf('<a href="%s">Click here</a> to purchase new package.','#');
    }
    ?>
    <div class="mism-package-status av_promobox">
       <div class="avia-promocontent">
           <p><span><?php _e('Current Package ','mism');?></span><?php echo $package_status;?></p>
       </div>
    </div>
    <?php
}
?>
