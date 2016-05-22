<?php

get_header();

include_once('supersized-libs.inc');

?>

<div class="slider" id="supersized-slider">
	
</div>
<!--Thumbnail Navigation-->
<div id="prevthumb"></div>
<div id="nextthumb"></div>

<!--Arrow Navigation-->
<a id="prevslide" class="load-item"></a>
<a id="nextslide" class="load-item"></a>

<div id="thumb-tray" class="load-item">
        <div id="thumb-back"></div>
        <div id="thumb-forward"></div>
</div>

<!--Time Bar-->
<div id="progress-back" class="load-item">
        <div id="progress-bar"></div>
</div>

<!--Control Bar-->
<div id="controls-wrapper" class="load-item">
        <div id="controls">

            <a id="play-button"><img id="pauseplay" src="<?php echo get_template_directory_uri();?>/img/pause.png"/></a>

                <!--Slide counter-->
                <div id="slidecounter">
                        <span class="slidenumber"></span> / <span class="totalslides"></span>
                </div>

                <!--Slide captions displayed here-->
                <div id="slidecaption"></div>

                <!--Thumb Tray button-->
                <a id="tray-button"><img id="tray-arrow" src="<?php echo get_template_directory_uri();?>/img/button-tray-up.png"/></a>

                <!--Navigation-->
                <ul id="slide-list"></ul>

        </div>
</div>
<script type="text/javascript">
            jQuery(document).ready(function(){
    
                            headHeight = jQuery('.header-wrapper').height();
                            footerHeight = jQuery('.footer-wrapper').height();
                            
                            jQuery('.header-wrapper').hover(
                                function(){
                                    
                                        slideHeader(headHeight);
                                        jQuery('.header-wrapper h1').stop(true,true).fadeIn(700);
                                    },
                                function(){
                                    jQuery('.header-wrapper h1 ').stop(true,true).fadeOut(700, function(){
                                            slideHeader(32);
                                        })
                                    }
                                );
                             //Animate header if on the gallery page
                            jQuery('.header-wrapper h1 ').fadeOut(1500, function(){
					slideHeader(32);
                                });
                                function slideHeader(num){
                                    jQuery('.header-wrapper').stop().animate({
						height: num
						}, 'slow', function(){
							slideFooter(footerHeight);
						});
                                        }
                                  function slideFooter(num){
                                    // console.log("slideFooter");
					jQuery('.footer-wrapper').stop().animate({
                                                    bottom: -num
						}, 'slow');
		
                                        };
                                    jQuery(".footer-wrapper").css("position","fixed");
                   
                });                      
</script>
<?php get_footer('gallery');  ?>