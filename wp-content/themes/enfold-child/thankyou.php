<?php
/*
  Template Name: Thankyou page
 */

get_header();

?>
<div class="container_wrap main_color">
    <div class="container">
      <?php
        if( get_post_meta(get_the_ID(), 'header', true) != 'no') echo avia_title();
      ?>
        <div class="template-page">

            <div class="entry-content-wrapper clearfix">

                <div class="thank-you-page">
                    <div class=" flex_column_div   avia-builder-el-13  el_after_av_one_half  avia-builder-el-last  column-top-margin">

                        <div class="avia_message_box avia-color-green avia-size-normal avia-icon_select-yes avia-border-  avia-builder-el-14  avia-builder-el-no-sibling ">
                            <!--<div class="thank-you-image">

                            </div>-->
                            <div class="thank-you-text">
                                <img src="<?php echo get_site_url(); ?>/wp-content/themes/enfold-child/images/green-check.png"/>
                                <div class="avia_message_box_content">
                                    <!--<span class="avia_message_box_icon" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello"></span>-->
                                    <p class="thank-you">Thank You <?php
                                            echo "<em>" . $_POST['first_name'] . " ";
                                            echo $_POST['last_name'] . "</em>";
                                            ?> for purchasing the<br><span style="color:#333"><?php echo $_POST['item_name']; ?></span> package.</p>
                                    <p class="transaction">Your Transaction has been completed Successfully</p>
                                </div>
                            </div>
                            <div class="avia_message_box_content">
                              <?php print_r($_POST) ?>
                                <span>You will be e-mailed a receipt at <?php echo $_POST['receiver_email']; ?></span>
                            </div>

                        </div>

                     		<div class='container_wrap container_wrap_first main_color <?php avia_layout_class( 'main' ); ?>'>

                     			<div class='container'>

                     				<main class='template-page content  <?php avia_layout_class( 'content' ); ?> units' <?php avia_markup_helper(array('context' => 'content','post_type'=>'page'));?>>

                               <?php
                               /* Run the loop to output the posts.
                               * If you want to overload this in a child theme then include a file
                               * called loop-page.php and that will be used instead.
                               */

                               $avia_config['size'] = avia_layout_class( 'main' , false) == 'entry_without_sidebar' ? '' : 'entry_with_sidebar';
                               get_template_part( 'includes/loop', 'page' );
                               ?>

                     				<!--end content-->
                     				</main>

                     				<?php

                     				//get the sidebar
                     				$avia_config['currently_viewing'] = 'page';
                     				get_sidebar();

                     				?>

                     			</div><!--end container-->

                     		</div><!-- close default .container_wrap element -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>
