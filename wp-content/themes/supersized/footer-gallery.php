                  </div>
            </div>  

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

            jQuery(function($){

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
            });

        </script>
    </body>
</html>
