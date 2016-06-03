<?php
/**
 * Template: Footer.php
 *
 * @package Aveone
 * @subpackage Template
 */
 $blog_id = get_current_blog_id();
 switch_to_blog($blog_id);
 $user_email = get_option('admin_email',true);
 
 $user = get_user_by('email',$user_email);
 $user_id = $user->ID;
 restore_current_blog();

?>
		<!--END #content-->
		</div>
    
    	<!--END .container-->
	</div> 

      	<!--END .content-->
	</div> 

     <!--BEGIN .content-bottom--> 
  <div class="content-bottom">
  
       	<!--END .content-bottom-->
  </div>
		
     <div class="agent-information row">
            <div class="col-sm-6">
                <div class="agent-info col-sm-12">
                    <div class="col-sm-4 agent-img-container">
                        <?php 
                        switch_to_blog($blog_id);

                        $current_blog_id = get_current_blog_id();

                        $users = get_users(array('blog_id'=>$current_blog_id,'role'=>'administrator'));
                        
                        $admin_email = $users['0']->data->user_email;
                        $user_details = get_user_by('email',$admin_email);
                        $user_id = $users['0']->data->ID;
                       
                        if($user_id == 0 || $user == null)
                        {
                            switch_to_blog(1);
                            $admin_email = get_option('admin_email');
                            $user_details = get_user_by('email',$admin_email);
                            $user_id = $user_details->ID;
                            switch_to_blog($blog_id);
                        }
                        $user_details = get_user_meta($user_id,'',true);
                        // echo "<pre>"; print_r ($user_details); die("</pre>");
                        $attachment_id = get_user_meta($user_id,'profile_picture',true);
                        // if ( is_numeric($attachment_id) && $attachment_id>0 )
                        //                         {
                        //                           switch_to_blog(1);
                        //                           $attachment_id_url = wp_get_attachment_image_src($attachment_id,'aveone_agent_img');
                        //                           if ( is_array($attachment_id_url) ) 
                        //                           {
                        //                             $attachment_id_url = $attachment_id_url[0];
                        //                           }
                        //                             switch_to_blog( $current_blog_id );
                        //                         }
                        //                         else
                        //                         {
                        //                             $attachment_id_url = $attachment_id;
                        //                         }
                        // echo "<pre>"; print_r ($attachment_id); die("</pre>");
                        $attach_details = wp_get_attachment_image($attachment_id);
                        // echo $attach_details;
                        $image = wp_get_image_editor($attachment_id);
                        // echo "<pre>"; print_r ($image); die("</pre>");
                        $agent_profile_picture = $attachment_id;
                        // echo "<pre>"; print_r ($agent_profile_picture); die("</pre>");
                        // echo "<pre>"; print_r ($attach_detail); die("</pre>");
                        $broker_logo_id = get_user_meta($user_id,'broker_logo');
                        // echo "PROFILE PICTURE: " . $attachment_id_url;
                        // get_image_tag(350,'Agent Image','Agent Name','',$atts['size']);
                      if(!empty($agent_profile_picture))
                      { 
                        echo do_shortcode( '[agentinformation_profile_picture_url size=aveone-agent-img]' );
                      }else
                      { 
                      ?>
                        <img style="height:100px; width:auto;" src="<?php echo plugins_url('medma-site-manager'); ?>/images/dummy_agent_pic.png" alt="Profile Picture"/>
                      <?php 
                      } 
                      ?>
                    </div>
                    <div class="agent-contact col-sm-8">
						<!--$firstName = get_user_meta($user_id, 'first_name', true);-->
                        <h3><?php echo get_user_meta($user_id,'first_name',true);?></h3>
                        <p class="designation"><span class="label"><?php echo get_user_meta($user_id,'designation',true)?></span></p>
                        <p class="phone"><span class="label">o: </span><?php if(get_user_meta($user_id,'business_phone',true)){ echo get_user_meta($user_id,'business_phone',true); } else { echo aveone_get_option('evl_agent_phone1'); }?></p>
                        <p class="phone"><span class="label">c: </span><?php if(get_user_meta($user_id,'mobile_phone',true)){ echo get_user_meta($user_id,'mobile_phone',true); }else { echo aveone_get_option('evl_agent_phone2'); }?></p>
                        <p class="email"><span class="label">e: </span><a href="mailto:<?php echo $user_email;//echo aveone_get_option('evl_agent_email');?>"><?php echo $user_email;//echo aveone_get_option('evl_agent_email');?></a></p>
                            <?php get_template_part('social-buttons', 'header'); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="logos-container row">
                    <div class="logo col-sm-8">
                        <?php 
                        $blog_id = get_current_blog_id();
                        switch_to_blog($blog_id);
                        //$agent_broker_logo = get_user_meta($user_id,'broker_logo',true);
                        $agent_broker_logo = get_template_directory_uri()."/images/kw.jpg";
                        switch_to_blog(1);
                        //$agent_broker_logo_url = wp_get_attachment_image_src($agent_broker_logo,'full'); 
                        switch_to_blog($blog_id);
                        ?>
                        
                        <a href="http://www.austinportfoliorealestate.com/" title="Click here to go to Austin Portfolio Real Estate website" target="_blank">
                        <img src="<?php echo $agent_broker_logo;//echo aveone_get_option('evl_agent_company_logo');?>" height="60" alt="Austin Portfolio Real Estate">
                        </a>
                        <?php  ?>
                    </div>
                    <div class="logo col-sm-4">
                        <?php if(aveone_get_option('evl_header_logo')){ ?>
                        <a href="http://www.austinportfoliorealestate.com/" title="Click here to go to Austin Portfolio Real Estate website" target="_blank">
                            <img src="<?php echo aveone_get_option('evl_header_logo');?>" height="110" alt="Austin Portfolio Real Estate">
                        </a>
                        <?php }else{ ?>
                        <a href="http://www.austinportfoliorealestate.com/" title="Click here to go to Austin Portfolio Real Estate website" target="_blank">
                            <img src="<?php echo get_template_directory_uri();?>/images/logo.png" height="110" alt="Austin Portfolio Real Estate">
                        </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
     
     
		<!--BEGIN .footer-->
		<div class="footer">
    
    
   	<!--BEGIN .container-->
	<div class="container container-footer">    
  
  

<div class="clearfix"></div> 
  
<div id="copyright col-sm-12">
<p class="info col-sm-8">© Copyright — 2015. <i>All Rights Reserved by Austin Portfolio Real Estate<br>Information contained herein believed accurate, but not guaranteed.</i></p>
<p class="poweredby col-sm-4"><a href="<?php echo network_site_url();?>?ref=<?php echo geT_option('siteurl');?>" title="Need Real Estate websites? Click here!"><span>Property Sites by: </span>AgentAssets.com</a></p>
		</div>

			<!-- Theme Hook -->

<script type="text/javascript">
var $jx = jQuery.noConflict();
  $jx("div.post").mouseover(function() {
    $jx(this).find("span.edit-post").css('visibility', 'visible');
  }).mouseout(function(){
    $jx(this).find("span.edit-post").css('visibility', 'hidden');
  });
  
    $jx("div.type-page").mouseover(function() {
    $jx(this).find("span.edit-page").css('visibility', 'visible');
  }).mouseout(function(){
    $jx(this).find("span.edit-page").css('visibility', 'hidden');
  });
  
      $jx("div.type-attachment").mouseover(function() {
    $jx(this).find("span.edit-post").css('visibility', 'visible');
  }).mouseout(function(){
    $jx(this).find("span.edit-post").css('visibility', 'hidden');
  });
  
  $jx("li.comment").mouseover(function() {
    $jx(this).find("span.edit-comment").css('visibility', 'visible');
  }).mouseout(function(){
    $jx(this).find("span.edit-comment").css('visibility', 'hidden');
  });
</script> 

 

<script type="text/javascript">
//
//
// 
// Animated Buttons
//
//
//      
var $animated = jQuery.noConflict();
$animated('.post-more').hover(
       function(){ $animated(this).addClass('animated pulse') },
       function(){ $animated(this).removeClass('animated pulse') }
)   
$animated('.read-more').hover(
       function(){ $animated(this).addClass('animated pulse') },
       function(){ $animated(this).removeClass('animated pulse') }
)
$animated('#submit').hover(
       function(){ $animated(this).addClass('animated pulse') },
       function(){ $animated(this).removeClass('animated pulse') }
)
$animated('input[type="submit"]').hover(
       function(){ $animated(this).addClass('animated pulse') },
       function(){ $animated(this).removeClass('animated pulse') }
)

</script>




<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery("#slides").zAccordion({
		timeout: 4500,
		speed: 500,
		slideClass: 'slide',
		animationStart: function () {
			jQuery('#slides').find('li.slide-previous div').fadeOut();
		},
		animationComplete: function () {
			jQuery('#slides').find('li.slide-open div').fadeIn();
		},
		buildComplete: function () {
			jQuery('#slides').find('li.slide-closed div').css('display', 'none');
			jQuery('#slides').find('li.slide-open div').fadeIn();
		},
		startingSlide: 1,
		
		tabWidth: "15%",
                width: "100%",
		height: 310
	});
});
</script>

 



<script type="text/javascript">
var $par = jQuery.noConflict(); 
  $par('#da-slider').cslider({
					autoplay	: true,
					bgincrement	: 450,
          interval	: 4000				});

</script>


<script type="text/javascript">
var $carousel = jQuery.noConflict();
$carousel('#myCarousel').carousel({
interval: 7000
})
$carousel('#carousel-nav a').click(function(q){
q.preventDefault();
targetSlide = $carousel(this).attr('data-to')-1;
$carousel('#myCarousel').carousel(targetSlide);
$carousel(this).addClass('active').siblings().removeClass('active');
});

$carousel('#bootstrap-slider').carousel({
interval: 7000})
$carousel('#carousel-nav a').click(function(q){
q.preventDefault();
targetSlide = $carousel(this).attr('data-to')-1;
$carousel('#bootstrap-slider').carousel(targetSlide);
$carousel(this).addClass('active').siblings().removeClass('active');
});
    
// $('#carousel-rel a').click(function(q){
//         console.log('Clicked');
//         targetSlide = (parseInt($('#carousel-rel a.active').data('to')) + 1) % 3;
//         console.log('targetSlide');
//         $('#carousel-rel a[data-to='+ targetSlide +']').addClass('active').siblings().removeClass('active');
//     });
</script>


<!--END .container-->  
	</div> 

		
		<!--END .footer-->
		</div>

<!--END body-->  



  <?php $aveone_pos_button = aveone_get_option('evl_pos_button','right');
  if ($aveone_pos_button == "disable" || $aveone_pos_button == "") { ?>
  
   <?php } else { ?>
   
     <div id="backtotop"><a href="#top" id="top-link"></a></div>   

<?php } ?>

<?php $aveone_custom_background = aveone_get_option('evl_custom_background','0'); if ($aveone_custom_background == "1") { ?>
</div>
<?php } ?>
<script type="text/javascript">
    
    jQuery(window).load(function() {
         // The slider being synced must be initialized first
         jQuery('#carousel').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            itemWidth: 210,
            itemMargin: 5,
            asNavFor: '#slider',
            smoothHeight: true
         });

         jQuery('#slider').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            sync: "#carousel"
         });
    }); 

</script>
<?php wp_footer(); ?> 

</body>
<!--END html(kthxbye)-->
</html>
