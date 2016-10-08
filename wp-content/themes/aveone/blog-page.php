<?php
/**
 * Template Name: Blog
 *
 * @package Aveone
 * @subpackage Template
 */

get_header();
$first = "";
?>


       <?php 
       
       global $authordata;
       $xyz = ""; 
       $options = get_option('aveone'); 
 		   $aveone_layout = aveone_get_option('evl_layout','2cl'); 
	     $aveone_post_layout = aveone_get_option('evl_post_layout','two');  
 		   $aveone_nav_links = aveone_get_option('evl_nav_links','after'); 
 		   $aveone_header_meta = aveone_get_option('evl_header_meta','single_archive'); 
       $aveone_excerpt_thumbnail = aveone_get_option('evl_excerpt_thumbnail','0'); 
	     $aveone_share_this = aveone_get_option('evl_share_this','single'); 
 	     $aveone_post_links = aveone_get_option('evl_post_links','after'); 
 	     $aveone_similar_posts = aveone_get_option('evl_similar_posts','disable'); 
       
       if ($aveone_layout == "1c") {  
       $imagewidth = "960";
       } elseif ($aveone_layout == "2cl" || $aveone_layout == "2cr") {
	     $imagewidth = "620";
       } else {
       $imagewidth = "506";
       }
 
 		  if (($aveone_layout == "1c"))    
  
    { ?>
  
  
  <?php } else { ?>

  <?php $options = get_option('aveone');
  
  if(get_post_meta($post->ID, 'aveone_full_width', true) == 'yes'):
  
  else:
  
  if (($aveone_layout == "3cm" || $aveone_layout == "3cl" || $aveone_layout == "3cr")) { ?>   
  
  <?php get_sidebar('2'); ?>
  
  
  <?php } ?>
  
  <?php endif; ?>
  
    <?php } ?>

		<?php get_template_part( 'content', 'blog' ); ?>
      
      
 <?php  
   if ($aveone_layout == "1c")  
  
  
    { ?>
  
  
  <?php } else { ?>


<?php wp_reset_query(); if(get_post_meta($post->ID, 'aveone_full_width', true) == 'yes'):
  
  else:       

get_sidebar(); 

endif; ?>

    <?php } ?>

<?php get_footer(); ?>

