                  </div>
            </div>  

                <footer id="footer" class="footer-wrapper">
                    <div class="container">
                        <div class="col-sm-6">
                            <div class="broker-wrapper">
                                <div id="brokerLogo">
                                    <a href="<?php echo get_user_meta($users['0']->data->ID,'broker_website',true);?>" rel="nofollow" target="_blank">
                                        <?php 
                                        $current_blog_id = get_current_blog_id();
                                        
                                        $users = get_users(array('blog_id'=>$current_blog_id,'role'=>'administrator'));
                                        
                                        $broker_attach_id = get_user_meta($users['0']->data->ID,'broker_logo',true);
                                        switch_to_blog(1);  # Switching to Admin
                                        $broker_attach_details = wp_get_attachment_image_src($broker_attach_id,'full');
                                        $broker_logo = $broker_attach_details[0];
                                        //$broker_logo = $user_data['agent_company_logo'];
                                        restore_current_blog();
                                        if($broker_logo != "")
                                        {
                                            ?>
                                            <?php echo do_shortcode('[agentinformation_broker_logo_url size=ss-broker-logo]'); ?>
                                            <!-- <img src="<?php echo $broker_logo;?>" height="80" alt="<?php echo get_user_meta($users['0']->data->ID,'broker',true);?>"> -->
                                            <?php
                                        }
                                        else
                                        {
                                            ?>

                                            <!-- <img src="<?php echo get_template_directory_uri();?>/images/broker_logo.jpg" height="80" alt="<?php echo get_user_meta($users['0']->data->ID,'broker',true);?>"> -->
                                            <?php
                                        }
                                        ?>
                                    </a>
                                </div>
                                <p class="tiny">Information contained herein believed accurate, but not guaranteed.</p>
                                <p class="siteby tiny">Single Property Websites by: <a href="http://www.agentassets.com?ref=footerlink" title="Get your own site!"><span>AgentAssets.com</span></a></p>
                            </div>
                        
                    </div>
                    <div class="col-sm-6">
                        
                            <div class="agent-wrapper">
                                <div class="agent-info col-sm-9">
                                    <?php 
                                    
                                    if(isset($users['0']->data->display_name) && !empty($users['0']->data->display_name)){ ?>
                                    <h2><?php echo $users['0']->data->display_name;?></h2>
                                    <?php } else { ?>
                                    <h2>Agent Name</h2>
                                    <?php } ?>
                                    <ul>
                                        <?php 
                                        
                                        $business_phone = get_user_meta($users['0']->data->ID,'business_phone',true);
                                        if($business_phone != "")
                                        {
                                            ?>
                                            <li>c: <?php echo $business_phone;?></li>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <li>c: 512-555-1234</li>
                                            <?php
                                        }

                                        $mobile_phone = get_user_meta($users['0']->data->ID,'mobile_phone',true);
                                        if($mobile_phone != "")
                                        {
                                            ?>
                                            <li>o: <?php echo $mobile_phone;?></li>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <li>o: 512-555-1234</li>
                                            <?php
                                        }
                                        ?>

                                        <li>
                                            <a  class="cu-agent-mail" href="mailto:<?php echo $users['0']->data->user_email;?>"><?php echo $users['0']->data->user_email;?></a>
                                        </li>
                                        <!-- if twitter / facebook / or google plus is entered -->
                                        <li class="social">
                                            <?php

                                    // $attachment_id = get_user_meta($users['0']->data->ID,'profile_picture',true);
                                    
                                    $facebook_url = get_user_meta($users['0']->data->ID,'facebook',true);
                                    $twitter_url = get_user_meta($users['0']->data->ID,'twitter',true);
                                    $googleplus_url = get_user_meta($users['0']->data->ID,'googleplus',true);
                                          
                                            ?>
                                            <a target="_blank" class="twitter" title="Follow me on Twitter!" href="http://twitter.com/<?php echo $twitter_url; ?>"><span><img src="<?php echo get_template_directory_uri();?>/images/Twitter.png"></span></a>
                                            <a target="_blank" class="facebook" title="Friend me on Facebook!" href="http://facebook.com/<?php echo $facebook_url; ?>"><span><img src="<?php echo get_template_directory_uri();?>/images/Facebook.png"></span></a>
                                            <a target="_blank" class="googleplus" title="Add me to your circles on Google+" href="http://plus.google.com/<?php echo $googleplus_url;?>"><span><img src="<?php echo get_template_directory_uri();?>/images/Google.png"></span></a>
                                        </li>
                                    </ul>
                                </div><!-- End agent info -->

                                <div id="agent-pic" class="col-sm-3">
                                    <?php 
                                    $profilepic = do_shortcode('[agentinformation_profile_picture_url size=ss-agent-img]');
                                    // $attachment_id = get_user_meta($users['0']->data->ID,'profile_picture',true);
                                    $facebook_url = get_user_meta($users['0']->data->ID,'facebook',true);
                                    $twitter_url = get_user_meta($users['0']->data->ID,'twitter',true);
                                    $googleplus_url = get_user_meta($users['0']->data->ID,'googleplus',true);
                                    switch_to_blog(1);  # Switching to Admin
                                    // $attach_details = wp_get_attachment_image_src($attachment_id,'full');
                                    
                                // $profilepic = $attach_details[0];
                                //$profilepic = $user_data['agent_image'];
                                    restore_current_blog();
                                    if($profilepic !="")
                                    {
                                      echo $profilepic;
                                    }
                                    else
                                    {
                                      ?>
                                        <img style="width:auto; height:136px;" src="<?php echo get_template_directory_uri();?>/images/agent_pic.jpg" alt="Agent Photo">
                                        <?php
                                    }
                                    ?>
                                </div>

                            </div><!-- End agent-wrapper -->
                    </div>
                    
                    </div>
                </footer>

        </div>
        <div class="contact-us-trigger">
          <a data-toggle="modal" data-target="#contact-us-modal">
            <img src="<?php echo get_template_directory_uri();?>/images/contact_us.png" alt="Contact Us"/>
          </a>
        </div>
        <div class="modal fade" id="contact-us-modal" tabindex="-1" role="dialog" aria-labelledby="Contact Us">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Contact Us</h4>
                    </div>
                    <div class="modal-body">
                        <?php //$contact_shortcode = get_option('contact_form_shortcode');?>
                        <?php //echo do_shortcode($contact_shortcode); ?>
                        <form class="form-horizontal" method="POST">
                            <div class="form-field">
                                <label for="name">Name <span class="error">*</span></label>
                                <input id="contact-name" type="text" name="name" value="" placeholder="Name"/>
                            </div>
                            <div class="form-field">
                                <label for="email">Email <span class="error">*</span></label>
                                <input id="contact-email" type="text" name="email" value="" placeholder="Email"/>
                            </div>
                            <div class="form-field">
                                <label for="phone">Phone </label>
                                <input id="contact-phone" type="text" name="phone" value="" placeholder="Phone"/>
                            </div>
                            <div class="form-field">
                                <label for="subject">Subject </label>
                                <select id="contact-subject" name="subject">
                                    <option value="0">Schedule a viewing</option>
                                    <option value="1">Property still available?</option>
                                    <option value="2">Learn more details</option>
                                    <option value="3">Alert me on similar homes</option>
                                    <option value="4">Make an offer</option>
                                    <option value="5">Other</option>
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="message">Message <span class="error">*</span></label>
                                <textarea id="contact-message" name="name" placeholder="Message"></textarea>
                            </div>
                            <div class="form-field">
                                <input class="btn pull-left" id="contact-us-submit" type="button" name="contact-us-submit" value="Send" />
                                <div class="msg"></div>
                            </div>
                        </form>
                    </div>
                    <script type="text/javascript">
                        jQuery(document).ready(function(){
                            jQuery("#contact-us-submit").click(function(e){
                                var name = jQuery('#contact-name').val();
                                var email = jQuery('#contact-email').val();
                                var phone = jQuery('#contact-phone').val();
                                var subject = jQuery('#contact-subject').val();
                                var message = jQuery('#contact-message').val();
                                var flag = false;
                                if(name == ""){
                                    jQuery('#contact-name').attr('style','border: 1px solid red !important');
                                    flag = true;
                                }else{
                                    jQuery('#contact-name').attr('style','border: 1px solid #000000 !important');
                                }

                                if(email == ""){
                                    jQuery('#contact-email').attr('style','border: 1px solid red !important');
                                    flag = true;
                                }else{
                                    jQuery('#contact-email').attr('style','border: 1px solid #000000 !important');
                                }

                                if(message == ""){
                                    jQuery('#contact-message').attr('style','border: 1px solid red !important');
                                    flag = true;
                                }else{
                                    jQuery('#contact-message').attr('style','border: 1px solid #000000 !important');
                                }

                                if(flag == true){
                                    return false;
                                }
                                var data = {
                                    'action': 'send_contact_details',
                                    'name': jQuery('#contact-name').val(),
                                    'email': jQuery('#contact-email').val(),
                                    'phone': jQuery('#contact-phone').val(),
                                    'subject': jQuery('#contact-subject').val(),
                                    'message': jQuery('#contact-message').val(),
                                };
                                jQuery('.msg').removeClass('success').removeClass('error').addClass('info').html('Sending Mail... Please Wait...');
                                // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                                jQuery.post('<?php echo site_url()."/wp-admin/admin-ajax.php"; ?>', data, function(response) {
                                    if('sent' == response){
                                        jQuery('.msg').removeClass('info').removeClass('error').addClass('success').html('Mail sent successfully.');
                                    }else if('fail' == response){
                                        jQuery('.msg').removeClass('info').removeClass('success').addClass('error').html('Sending mail failed. Please try again.');
                                    }
                                });
                            }); 
                        });
                    </script>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        
        <?php
        $args = array(
            'post_type' => 'gallery',
            'post_status' => 'publish',
            'posts_per_page' => '10',
            'orderby' => 'menu_order, ID',
            'order' => 'ASC'

        );
        $gallery_items = get_posts($args);
        ?>
        <script type="text/javascript">

            jQuery(document).ready(function(){

                jQuery('#supersized-slider').supersized({

                    // Functionality
                    slideshow               :   1,			// Slideshow on/off
                    autoplay				:	1,			// Slideshow starts playing automatically
                    start_slide             :   1,			// Start slide (0 is random)
                    stop_loop				:	0,			// Pauses slideshow on last slide
                    random					: 	0,			// Randomize slide order (Ignores start slide)
                    slide_interval          :   3000,		// Length between transitions
                    transition              :   1, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
                    transition_speed		:	1000,		// Speed of transition
                    new_window				:	1,			// Image links open in new window/tab
                    pause_hover             :   0,			// Pause slideshow on hover
                    keyboard_nav            :   1,			// Keyboard navigation on/off
                    performance				:	1,			// 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
                    image_protect			:	1,			// Disables image dragging and right click with Javascript

                    // Size & Position						   
                    min_width		        :   0,			// Min width allowed (in pixels)
                    min_height		        :   0,			// Min height allowed (in pixels)
                    vertical_center         :   1,			// Vertically center background
                    horizontal_center       :   1,			// Horizontally center background
                    fit_always				:	0,			// Image will never exceed browser width or height (Ignores min. dimensions)
                    fit_portrait         	:   1,			// Portrait images will not exceed browser height
                    fit_landscape			:   0,			// Landscape images will not exceed browser width

                    // Components							
                    slide_links				:	'blank',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')
                    thumb_links				:	1,			// Individual thumb links for each slide
                    thumbnail_navigation    :   0,
                    slides 					:  	[			// Slideshow Images
                        <?php
                        if(count($gallery_items)>0){
                            foreach($gallery_items AS $gallery_item){
                                echo '{image : "'.wp_get_attachment_url(get_post_thumbnail_id($gallery_item->ID,'full')).'",title : "'.get_the_title($gallery_item->ID).'", thumb : "'.wp_get_attachment_url(get_post_thumbnail_id($gallery_item->ID,'post-thumbnails')).'" },';
                            }
                        }else{
                                echo '{image : "'.  get_template_directory_uri().'/images/slide1.jpg",title : "Slide1", thumb : "'.  get_template_directory_uri().'/images/slide1.jpg" },';
                                echo '{image : "'.  get_template_directory_uri().'/images/slide2.jpg",title : "Slide2", thumb : "'.  get_template_directory_uri().'/images/slide2.jpg" },';
                        }
                        ?>


                    ]

                });
                jQuery.supersized.vars.image_path = "<?=get_template_directory_uri();?>/img/";  
            });
            
            

        </script>
    </body>
</html>
