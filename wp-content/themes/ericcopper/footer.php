		<?php
		
		do_action( 'ava_before_footer' );	
			
		global $avia_config;
		$blank = isset($avia_config['template']) ? $avia_config['template'] : "";

		//reset wordpress query in case we modified it
		wp_reset_query();


		//get footer display settings
		$the_id 				= avia_get_the_id(); //use avia get the id instead of default get id. prevents notice on 404 pages
		$footer 				= get_post_meta($the_id, 'footer', true);
		$footer_widget_setting 	= !empty($footer) ? $footer : avia_get_option('display_widgets_socket');


		//check if we should display a footer
		if(!$blank && $footer_widget_setting != 'nofooterarea' )
		{
			if( $footer_widget_setting != 'nofooterwidgets' )
			{
				//get columns
				$columns = avia_get_option('footer_columns');
		?>
		<?php 
		global $wpdb;
		$blog_id = get_current_blog_id();
		$blog_owner = $wpdb->get_var($wpdb->prepare("SELECT `user_id` FROM `$wpdb->usermeta` WHERE `meta_key` = 'primary_blog' AND `meta_value` = %d LIMIT 1", array($blog_id) ));
		 ?>
		<div class='container_wrap footer_color' id='footer'>

			<div class='container'><!-- originally here -->
				
				<div class='flex_column av_one_half first el_before_av_one_half'>
					<div class="agent-details">
						<div class="agent-image"><img class="alignnone size-full wp-image-938" src="http://ericcopper.agentassets.com/wp-content/uploads/sites/141/2017/12/thumb_Website_Headshot_-_Eric.jpg" alt="" width="150" height="150" /></div>
						
						<div class="contact">
							<h3>Eric Copper<br><img src="http://ericcopper.agentassets.com/wp-content/uploads/sites/141/2017/12/elite25_logo.png" alt="Elite 25" width="95" /></h3>
							<h4><?php echo do_shortcode('[bp_profile_field field="Designations" tab="Agent Profile Fields" user_id="'.$blog_owner.'"]');?></h4>
							<span class="phone"><?php echo do_shortcode('[bp_profile_field field="Your Phone Number" tab="Profile Info" user_id="'.$blog_owner.'"]')?> |
<?php echo do_shortcode('[bp_profile_field field="Broker Phone Number" tab="Agent Profile Fields" user_id="'.$blog_owner.'"]');?>
							</span>
							<span class="email">
								<a href="mailto:<?php echo do_shortcode("[bp_profile_field field='Lead Emails' tab='Agent Profile Fields' user_id='".$blog_owner."']");?>"><?php echo do_shortcode('[bp_profile_field field="Lead Emails" tab="Agent Profile Fields" user_id="'.$blog_owner.'"]');?></a>
							</span>
							<span class="website">
								<a href="<?php echo do_shortcode("[bp_profile_field field='Website' tab='Social Media' user_id='".$blog_owner."']");?>" target="_blank" rel="noopener"><?php echo do_shortcode('[bp_profile_field field="Website" tab="Social Media" user_id="'.$blog_owner.'"]');?></a>
							</span>
						</div> <!-- end contact div -->
						

				</div><!-- end agent-details div -->
			</div><!-- end flex-column div -->
			
			<div class="flex_column av_one_half el_after_av_one_half el_before_av_one_half">
				<section id="media_image-6" class="widget clearfix widget_media_image">
					<a href="http://www.livinginaustintx.com" style="position: relative; overflow: hidden;"><img width="262" height="300" src="http://ericcopper.agentassets.com/wp-content/uploads/sites/141/2017/12/StackedVertical_Break_Color-262x300.png" class="image wp-image-935  attachment-medium size-medium" alt="" style="max-width: 100%; height: auto;" srcset="http://ericcopper.agentassets.com/wp-content/uploads/sites/141/2017/12/StackedVertical_Break_Color-262x300.png 262w, http://ericcopper.agentassets.com/wp-content/uploads/sites/141/2017/12/StackedVertical_Break_Color.png 342w" sizes="(max-width: 262px) 100vw, 262px"><span class="image-overlay overlay-type-extern"><span class="image-overlay-inside"></span></span></a>
				</section>
			</div> <!-- end flex column-->
		</div>
		
		<?php do_action('avia_after_footer_columns'); ?>
		
	</div>
			<!-- end Profile additions -->
			
			

	<?php   } //endif nofooterwidgets ?>



			

			<?php

			//copyright
			$copyright = do_shortcode( avia_get_option('copyright', "&copy; ".__('Copyright','avia_framework')."  - <a href='".home_url('/')."'>".get_bloginfo('name')."</a>") );

			// you can filter and remove the backlink with an add_filter function
			// from your themes (or child themes) functions.php file if you dont want to edit this file
			// you can also remove the kriesi.at backlink by adding [nolink] to your custom copyright field in the admin area
			// you can also just keep that link. I really do appreciate it ;)
			$kriesi_at_backlink = kriesi_backlink(get_option(THEMENAMECLEAN."_initial_version"), 'Enfold');


			
			if($copyright && strpos($copyright, '[nolink]') !== false)
			{
				$kriesi_at_backlink = "";
				$copyright = str_replace("[nolink]","",$copyright);
			}

			if( $footer_widget_setting != 'nosocket' )
			{

			?>

				<footer class='container_wrap socket_color' id='socket' <?php avia_markup_helper(array('context' => 'footer')); ?>>
                    <div class='container'>

                        <span class='copyright'><?php echo $copyright . $kriesi_at_backlink; ?></span>

                        <?php
                        	if(avia_get_option('footer_social', 'disabled') != "disabled")
                            {
                            	$social_args 	= array('outside'=>'ul', 'inside'=>'li', 'append' => '');
								echo avia_social_media_icons($social_args, false);
                            }
                        
                            
                                $avia_theme_location = 'avia3';
                                $avia_menu_class = $avia_theme_location . '-menu';

                                $args = array(
                                    'theme_location'=>$avia_theme_location,
                                    'menu_id' =>$avia_menu_class,
                                    'container_class' =>$avia_menu_class,
                                    'fallback_cb' => '',
                                    'depth'=>1,
                                    'echo' => false,
                                    'walker' => new avia_responsive_mega_menu(array('megamenu'=>'disabled'))
                                );

                            $menu = wp_nav_menu($args);
                            
                            if($menu){ 
                            echo "<nav class='sub_menu_socket' ".avia_markup_helper(array('context' => 'nav', 'echo' => false)).">";
                            echo $menu;
                            echo "</nav>";
							}
                        ?>

                    </div>

	            <!-- ####### END SOCKET CONTAINER ####### -->
				</footer>


			<?php
			} //end nosocket check


		
		
		} //end blank & nofooterarea check
		?>
		<!-- end main -->
		</div>
		
		<?php
		
		if(avia_get_option('disable_post_nav') != "disable_post_nav")
		{
			//display link to previous and next portfolio entry
			echo avia_post_nav();
		}
		
		echo "<!-- end wrap_all --></div>";


		if(isset($avia_config['fullscreen_image']))
		{ ?>
			<!--[if lte IE 8]>
			<style type="text/css">
			.bg_container {
			-ms-filter:"progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $avia_config['fullscreen_image']; ?>', sizingMethod='scale')";
			filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $avia_config['fullscreen_image']; ?>', sizingMethod='scale');
			}
			</style>
			<![endif]-->
		<?php
			echo "<div class='bg_container' style='background-image:url(".$avia_config['fullscreen_image'].");'></div>";
		}
	?>


<?php




	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */


	wp_footer();


?>
<a href='#top' title='<?php _e('Scroll to top','avia_framework'); ?>' id='scroll-top-link' <?php echo av_icon_string( 'scrolltop' ); ?>><span class="avia_hidden_link_text"><?php _e('Scroll to top','avia_framework'); ?></span></a>

<div id="fb-root"></div>
</body>
</html>
