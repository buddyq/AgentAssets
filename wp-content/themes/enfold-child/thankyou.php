<?php
/*
  Template Name: Thankyou page
 */

get_header();

?>
<div class="container_wrap main_color">
    <div class="container">
        <div class="template-page">

            <div class="entry-content-wrapper clearfix">

                <div class="thank-you-page">
                    <div class="flex_column av_one_half  flex_column_div   avia-builder-el-13  el_after_av_one_half  avia-builder-el-last  column-top-margin">

                        <div class="avia_message_box avia-color-green avia-size-normal avia-icon_select-yes avia-border-  avia-builder-el-14  avia-builder-el-no-sibling ">
                            <!--<div class="thank-you-image">
                                
                            </div>-->
                            <div class="thank-you-text">
                                <img src="<?php echo get_site_url(); ?>/wp-content/themes/enfold/images/smily-icon-50x50.png"/>
                                <div class="avia_message_box_content">
                                    <!--<span class="avia_message_box_icon" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello"></span>-->
                                    <p class="thank-you">Thank You <?php
                                            echo $_POST['first_name'];
                                            echo $_POST['last_name'];
                                            ?> FOR PURCHASING <?php echo $_POST['item_name']; ?></p>
                                    <br>
                                    <p class="transaction">Your Transaction has been completed Successfully</p>
                                </div>
                            </div>
                            <div class="avia_message_box_content">
                                <span>You will be e-mailed a receipt at <?php echo $_POST['receiver_email']; ?></span>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>
