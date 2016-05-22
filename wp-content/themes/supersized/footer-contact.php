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
                                            <img src="<?php echo  $broker_logo;?>" height="80" alt="<?php echo get_user_meta($users['0']->data->ID,'broker',true);?>">
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <img src="<?php echo get_template_directory_uri();?>/images/broker_logo.jpg" height="80" alt="<?php echo get_user_meta($users['0']->data->ID,'broker',true);?>">
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

                                    $attachment_id = get_user_meta($users['0']->data->ID,'profile_picture',true);
                                    
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

                                    $attachment_id = get_user_meta($users['0']->data->ID,'profile_picture',true);
                                    $facebook_url = get_user_meta($users['0']->data->ID,'facebook',true);
                                    $twitter_url = get_user_meta($users['0']->data->ID,'twitter',true);
                                    $googleplus_url = get_user_meta($users['0']->data->ID,'googleplus',true);
                                    switch_to_blog(1);  # Switching to Admin
                                    $attach_details = wp_get_attachment_image_src($attachment_id,'full');
                                    
                                $profilepic = $attach_details[0];
                                //$profilepic = $user_data['agent_image'];
                                    restore_current_blog();
                                    if($profilepic !="")
                                    {
                                        ?>
                                        <img style="width:auto; height:136px;" src="<?php echo $profilepic;?>" alt="Agent Photo">
                                        <?php
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
                    slideshow       :   1,			// Slideshow on/off
                    autoplay				:	1,			// Slideshow starts playing automatically
                    start_slide     :   1,			// Start slide (0 is random)
                    stop_loop				:	0,			// Pauses slideshow on last slide
                    random					: 	0,			// Randomize slide order (Ignores start slide)
                    slide_interval  :   3000,		// Length between transitions
                    transition      :   1, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
                    transition_speed	:	1000,		// Speed of transition
                    new_window				:	1,			// Image links open in new window/tab
                    pause_hover       :   0,			// Pause slideshow on hover
                    keyboard_nav      :   1,			// Keyboard navigation on/off
                    performance				:	1,			// 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
                    image_protect			:	1,			// Disables image dragging and right click with Javascript

                    // Size & Position						   
                    min_width		      :   0,			// Min width allowed (in pixels)
                    min_height		    :   0,			// Min height allowed (in pixels)
                    vertical_center   :   1,			// Vertically center background
                    horizontal_center :   1,			// Horizontally center background
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
