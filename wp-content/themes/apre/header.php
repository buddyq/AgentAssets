<?php
/**
 * Template: Header.php
 *
 * @package Aveone
 * @subpackage Template
 */
?>
<!DOCTYPE html>
<!--BEGIN html-->
<html <?php language_attributes(); ?>>
<!--BEGIN head-->
<head>

	<?php $aveone_favicon = aveone_get_option('evl_favicon'); if( $aveone_favicon ) { ?>
	<!-- Favicon -->
	<!-- Firefox, Chrome, Safari, IE 11+ and Opera. -->
	<link href="<?php echo $aveone_favicon; ?>" rel="icon" type="image/x-icon" />
	<?php }
 	// $meta_keywords = aveone_get_option('evl_meta_keywords');
  //$meta_description = aveone_get_option('evl_meta_description');
  $meta_keywords = get_option('meta_keywords',true);
  $meta_description = get_option('meta_description',true);
  ?>
  <meta name="keywords" content="<?php echo $meta_keywords;?>" />
  <meta name="description" content="<?php echo $meta_description;?>" />
  <meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<?php wp_head(); ?>
<!--END head-->

  <!--[if lt IE 9]>
  <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/ie.css">
  <![endif]-->

</head>

<!--BEGIN body-->
<body <?php body_class(); ?>>
<?php include_once("analyticstracking.php") ?>
<?php //$aveone_custom_background = aveone_get_option('evl_custom_background','1'); if ($aveone_custom_background == "1") { ?>
<div id="wrapper">
<?php //} ?>

<div id="top"></div>

	<!--BEGIN .header-->
		<div class="header">

	<!--BEGIN .container-->
	<div class="container container-header custom-header">



 <?php $aveone_pos_logo = aveone_get_option('evl_pos_logo','left'); if ($aveone_pos_logo == "disable") { ?>

  <?php } else { ?>

   <?php $aveone_header_logo = aveone_get_option('evl_header_logo', 'aveone-header-logo');
    // if ($aveone_header_logo) {
    //     echo "<div class='logo-container'>";
    //     // echo "<a href=".get_site_url()."><img id='logo-image' class='img-responsive' src=".$aveone_header_logo." /></a>";
    //     echo "<a href=".get_site_url().">".do_shortcode('[agentinformation_broker_logo_url size=aveone-header-logo]')."</a>";
    //     echo "</div>";
    // }
    // else
    // {
        echo "<div class='logo-container'>";
        echo "<a href=".get_site_url()."><img id='logo-image' class='img-responsive' src='".  get_template_directory_uri()."/images/logo.png' /></a>";
        echo "</div>";
    // }
      ?>

     <?php } ?>

     <!--BEGIN .title-container-->

<div class="aveone-menu-header">

  <!--BEGIN .container-menu-->
  <div class="container nacked-menu container-menu">
			<div class="title-container">
				  <?php

				 $tagline = '<div id="tagline">'.get_bloginfo( 'description' ).'</div>';

				 $aveone_tagline_pos = aveone_get_option('evl_tagline_pos','next');

				 if (($aveone_tagline_pos !== "disable") && ($aveone_tagline_pos == "above")) {

				 echo $tagline;

				 } ?>


				 <?php $aveone_blog_title = aveone_get_option('evl_blog_title','0');
				 if ($aveone_blog_title == "0" || !$aveone_blog_title) { ?>

					<div id="logo"><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ) ?></a></div>

					<?php
					if (($aveone_tagline_pos !== "disable") && (($aveone_tagline_pos == "") || ($aveone_tagline_pos == "next") || ($aveone_tagline_pos == "under")))
					{
						echo $tagline;

					}
					?>

				 <?php
				 } else { ?>

				  <?php }  ?>

				  <!--END .title-container-->
				</div>
     <?php $aveone_main_menu = aveone_get_option('evl_main_menu','0'); if ($aveone_main_menu == "1") { ?>
    <br /><br />

   <?php } else { ?>

   <div class="primary-menu">
 <?php

if ( has_nav_menu( 'primary-menu' ) ) {

echo '<nav id="nav" class="nav-holder">';
 wp_nav_menu( array( 'theme_location' => 'primary-menu', 'menu_class' => 'nav-menu','fallback_cb' => 'wp_page_menu', 'walker' => new aveone_Walker_Nav_Menu() ) );
 } else { ?>
		<nav id="nav" class="nav-holder">
			<?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'menu_class' => 'nav-menu','fallback_cb' => 'wp_page_menu') );} ?>
   </nav>
   </div>








<?php /*$aveone_sticky_header = aveone_get_option('evl_sticky_header','1'); if ( $aveone_sticky_header == "1" ) {

	// sticky header
		get_template_part('sticky-header');

	}*/	?>



       <?php } ?>






       </div>

    </div>
	<!--END .container-->
		</div>




    		<!--END .header-->
		</div>




  <div class="menu-container">



      <?php $aveone_menu_background = aveone_get_option('evl_disable_menu_back','1'); $aveone_width_layout = aveone_get_option('evl_width_layout','fixed'); if ( $aveone_width_layout == "fluid" && $aveone_menu_background == "1" ) { ?>

    <div class="fluid-width">

    <?php } ?>




	<div class="menu-back">



          <?php $aveone_width_layout = aveone_get_option('evl_width_layout','fixed'); if ( $aveone_width_layout == "fluid" ) { ?>

    <div class="container">

    <?php } ?>

 	<?php $aveone_slider_page_id = ''; $aveone_bootstrap = aveone_get_option('evl_bootstrap_slider','homepage');
	if(!is_home() && !is_front_page() && !is_archive()) {
		$aveone_slider_page_id = $post->ID;
	}
	if(!is_home() && is_front_page()) {
		$aveone_slider_page_id = $post->ID;
	}
	if(is_home() && !is_front_page()){
		$aveone_slider_page_id = get_option('page_for_posts');
	}

	/*if(get_post_meta($aveone_slider_page_id, 'aveone_slider_type', true) == 'bootstrap' || ($aveone_bootstrap == "homepage" && is_home()) || ($aveone_bootstrap == "homepage" && is_front_page()) || $aveone_bootstrap == "all" ):

  aveone_bootstrap();

  endif;*/ ?>


 	<?php $aveone_slider_page_id = ''; $aveone_parallax = aveone_get_option('evl_parallax_slider','post');
	if(!is_home() && !is_front_page() && !is_archive()) {
		$aveone_slider_page_id = $post->ID;
	}
	if(!is_home() && is_front_page()) {
		$aveone_slider_page_id = $post->ID;
	}
	if(is_home() && !is_front_page()){
		$aveone_slider_page_id = get_option('page_for_posts');
	}

	if(get_post_meta($aveone_slider_page_id, 'aveone_slider_type', true) == 'parallax' || ($aveone_parallax == "homepage" && is_home()) || ($aveone_parallax == "homepage" && is_front_page()) || $aveone_parallax == "all" ):

  $aveone_parallax_slider = aveone_get_option('evl_parallax_slider_support', '1');

  /*if ($aveone_parallax_slider == "1"):

  aveone_parallax();

  endif;*/

  endif; ?>


  <?php # Displays Zaccordion slider
  if(is_home() || is_front_page()){
  aveone_posts_slider();
  }
  ?>



 <?php $aveone_header_widgets_placement = aveone_get_option('evl_header_widgets_placement', 'home');
 $aveone_widget_this_page = get_post_meta($post->ID, 'aveone_widget_page', true);
 if (((is_home() || is_front_page()) && $aveone_header_widgets_placement == "home") || (is_single() && $aveone_header_widgets_placement == "single")  || (is_page() && $aveone_header_widgets_placement == "page") || ($aveone_header_widgets_placement == "all") || ($aveone_widget_this_page == "yes" && $aveone_header_widgets_placement == "custom")) { ?>





          <?php $aveone_widgets_header = aveone_get_option('evl_widgets_header','disable');

// if Header widgets exist

  if (($aveone_widgets_header == "") || ($aveone_widgets_header == "disable"))
{ } else { ?>


<?php

$aveone_header_css = '';

if ($aveone_widgets_header == "one") { $aveone_header_css = 'widget-one-column col-sm-6'; }

if ($aveone_widgets_header == "two") { $aveone_header_css = 'col-sm-6 col-md-6'; }

if ($aveone_widgets_header == "three") { $aveone_header_css = 'col-sm-6 col-md-4'; }

if ($aveone_widgets_header == "four") { $aveone_header_css = 'col-sm-6 col-md-3'; }

?>

    <div class="container">
  <div class="widgets-back-inside row">

    <div class="<?php echo $aveone_header_css; ?>">
    	<?php	if ( !dynamic_sidebar( 'header-1' )) : ?>
      <?php endif; ?>
      </div>

     <div class="<?php echo $aveone_header_css; ?>">
      <?php	if ( !dynamic_sidebar( 'header-2' ) ) : ?>
      <?php endif; ?>
      </div>

    <div class="<?php echo $aveone_header_css; ?>">
	    <?php	if ( !dynamic_sidebar( 'header-3' ) ) : ?>
      <?php endif; ?>
      </div>

    <div class="<?php echo $aveone_header_css; ?>">
    	<?php	if ( !dynamic_sidebar( 'header-4' ) ) : ?>
      <?php endif; ?>
      </div>

    </div>
    </div>


     <?php } ?>

     <?php } else {} ?>


      </div>



      </div>




         <?php $aveone_width_layout = aveone_get_option('evl_width_layout','fixed'); if ( $aveone_width_layout == "fluid" ) { ?>

         </div>

   <?php } ?>


             	<!--BEGIN .content-->
	<div class="content <?php semantic_body(); ?>">

  <?php if (is_page_template('contact.php')): ?>
  <div class="gmap" id="gmap"></div>
  <?php endif; ?>

       	<!--BEGIN .container-->
	<div class="container container-center row">

		<!--BEGIN #content-->
		<div id="content">


  <?php /*if (is_home() || is_front_page()) {

  aveone_content_boxes();

  }*/ ?>
