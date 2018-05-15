<?php get_header(); ?>
<?php 
$options = get_option('aveone'); 
$aveone_layout = aveone_get_option('evl_layout','2cl'); 
$aveone_post_layout = aveone_get_option('evl_post_layout','two'); 
?>
	<?php if ($aveone_layout == "3cm" || $aveone_layout == "3cl" || $aveone_layout == "3cr") { ?>
		<?php get_sidebar('2'); ?>
	<?php } ?>

	<div id="primary" class="<?php if ($aveone_layout == "1c") {echo ' col-md-12';} else {echo ' col-xs-12 col-sm-6'; if (($aveone_layout == "2cr" && ($aveone_post_layout == "two") || $aveone_layout == "2cl" && ($aveone_post_layout == "two"))) { echo ' col-md-8';}  if (($aveone_layout == "3cm" || $aveone_layout == "3cl" || $aveone_layout == "3cr")) {echo ' col-md-6';} else {echo ' col-md-8'; }  if ( is_single() || is_page() ) { echo ' col-single';  } } ?>">
		
		<?php if(have_posts()): the_post(); ?>
		
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<span class="entry-title" style="display: none;"><?php the_title(); ?></span>
			<span class="vcard" style="display: none;"><span class="vcard author"><span class="fn"><?php the_author_posts_link(); ?></span></span></span>
			
			<div class="post-content">
				<?php the_content(); ?>
				<?php wp_link_pages( array( 'before' => '<div id="page-links"><p><strong>'.__( 'Pages', 'aveone' ).':</strong>', 'after' => '</p></div>' ) ); ?>
			</div>    
		</div>
		
		<?php endif; ?>
		
	</div>
	<?php wp_reset_query(); ?>  
	
	<?php if ($aveone_layout !== "1c") { ?>
		<?php get_sidebar(); ?>
	<?php } ?>

<?php get_footer(); ?>