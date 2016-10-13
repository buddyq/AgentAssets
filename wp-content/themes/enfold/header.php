<?php
	if ( !defined('ABSPATH') ){ die(); }
<<<<<<< HEAD
	
=======

>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
	global $avia_config;

	$style 				= $avia_config['box_class'];
	$responsive			= avia_get_option('responsive_active') != "disabled" ? "responsive" : "fixed_layout";
<<<<<<< HEAD
	$blank 				= isset($avia_config['template']) ? $avia_config['template'] : "";	
=======
	$blank 				= isset($avia_config['template']) ? $avia_config['template'] : "";
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
	$av_lightbox		= avia_get_option('lightbox_active') != "disabled" ? 'av-default-lightbox' : 'av-custom-lightbox';
	$preloader			= avia_get_option('preloader') == "preloader" ? 'av-preloader-active av-preloader-enabled' : 'av-preloader-disabled';
	$sidebar_styling 	= avia_get_option('sidebar_styling');
	$filterable_classes = avia_header_class_filter( avia_header_class_string() );

<<<<<<< HEAD
	
=======

>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php echo "html_{$style} ".$responsive." ".$preloader." ".$av_lightbox." ".$filterable_classes ?> ">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<?php
/*
 * outputs a rel=follow or nofollow tag to circumvent google duplicate content for archives
 * located in framework/php/function-set-avia-frontend.php
 */
 if (function_exists('avia_set_follow')) { echo avia_set_follow(); }

?>


<!-- mobile setting -->
<?php

if( strpos($responsive, 'responsive') !== false ) echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">';
?>


<!-- Scripts/CSS and wp_head hook -->
<?php
/* Always have wp_head() just before the closing </head>
 * tag of your theme, or you will break many plugins, which
 * generally use this hook to add elements to <head> such
 * as styles, scripts, and meta tags.
 */

wp_head();

?>

</head>




<body id="top" <?php body_class($style." ".$avia_config['font_stack']." ".$blank." ".$sidebar_styling); avia_markup_helper(array('context' => 'body')); ?>>
<<<<<<< HEAD

	<?php 
		
	if("av-preloader-active av-preloader-enabled" === $preloader)
	{
		echo avia_preload_screen(); 
	}
		
=======
	<h1>LOCAL TEST</h1>
	<?php

	if("av-preloader-active av-preloader-enabled" === $preloader)
	{
		echo avia_preload_screen();
	}

>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
	?>

	<div id='wrap_all'>

<<<<<<< HEAD
	<?php 
	if(!$blank) //blank templates dont display header nor footer
	{ 
=======
	<?php
	if(!$blank) //blank templates dont display header nor footer
	{
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
		 //fetch the template file that holds the main menu, located in includes/helper-menu-main.php
         get_template_part( 'includes/helper', 'main-menu' );

	} ?>
<<<<<<< HEAD
		
	<div id='main' class='all_colors' data-scroll-offset='<?php echo avia_header_setting('header_scroll_offset'); ?>'>

	<?php 
		
		if(isset($avia_config['temp_logo_container'])) echo $avia_config['temp_logo_container'];
		do_action('ava_after_main_container'); 
		
=======

	<div id='main' class='all_colors' data-scroll-offset='<?php echo avia_header_setting('header_scroll_offset'); ?>'>

	<?php

		if(isset($avia_config['temp_logo_container'])) echo $avia_config['temp_logo_container'];
		do_action('ava_after_main_container');

>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
	?>
