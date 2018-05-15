<?php
/**
 * BuddyPress - Blogs Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter().
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

/**
 * Fires before the start of the blogs loop.
 *
 * @since 1.2.0
 */

if ( bp_is_my_profile() || is_super_admin() ) { 
 
wp_enqueue_script( 'toggle-livesite-ajax', '/wp-content/plugins/agentassets-site-manager/js/ajax-toggle-livesite.js');

do_action( 'bp_before_blogs_loop' ); ?>

<?php if ( bp_has_blogs( bp_ajax_querystring( 'blogs' ) ) ) : ?>

	<div id="pag-top" class="pagination">

		<div class="pag-count" id="blog-dir-count-top">
			<?php bp_blogs_pagination_count(); ?>
		</div>

		<div class="pagination-links" id="blog-dir-pag-top">
			<?php bp_blogs_pagination_links(); ?>
		</div>

	</div>

	<?php

	/**
	 * Fires before the blogs directory list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_directory_blogs_list' ); ?>

	<ul id="blogs-list" class="item-list">
		
	<?php
  // Include Headei
	$counter = 0;
	while ( bp_blogs() ) : bp_the_blog(); 
	global $blogs_template;
	$blog_id = $blogs_template->blogs[$counter]->blog_id;
	$counter++;
	?>

		<li <?php bp_blog_class() ?>>
			<!-- <div class="item-avatar">
				<a href="<?php bp_blog_permalink(); ?>"><?php bp_blog_avatar( 'type=thumb' ); ?></a>
			</div> -->

			<div class="item">
				<div class="item-title"><a href="<?php bp_blog_permalink(); ?>"><?php bp_blog_name(); ?></a></div>
				<div class="item-meta">
                    <span class="link"><?php bp_blog_permalink(); ?></span>
				</div>
				
				<?php

				/**
				 * Fires after the listing of a blog item in the blogs loop.
				 *
				 * @since 1.2.0
				 */
				do_action( 'bp_directory_blogs_item' ); ?>
			</div>

			<div class="action">

				<?php
				
				/**
				 * Fires inside the blogs action listing area.
				 *
				 * @since 1.1.0
				 */
				do_action( 'bp_directory_blogs_actions' ); ?>
				
				<!-- Edit Site Link -->
                <?php
                $current_theme = AgentAssets::get_current_theme($blog_id);
                $domain = AgentAssets::isSiteLive($blog_id);
                
                if ( $domain['live_status'] == 'isLive' ) {
                    $site_url = 'http://'.$domain['domain'];
                } else {
                    $site_url = get_home_url( $blog_id );
                }
                ?>
                
				<div class="blog-button visit generic-button">
                    <?php if ($current_theme == "Austin Portfolio Theme") { ?>
                    <a href="<?php echo $site_url; ?>?et_fb=1" title="Will open in new tab" target="_blank" class="blog-button visit">Edit Site</a></br>
                    <?php } else { ?>
                    <a href="<?php echo $site_url; ?>/wp-admin" title="Will open in new tab" target="_blank" class="blog-button visit">Edit Site</a></br>
                    <?php } ?>
				</div>
				<!-- Make Site live toggle button -->
				<?php 
                $class = $domain['live_status'];
                if( !empty($class) ): ?>
    				<div class="blog-button visit generic-button live-button">
    					<img src="<?php echo plugins_url();?>/agentassets-site-manager/images/loading-img.gif" alt="Loading..." class="ajax-loader" width="10px" style="display:none;">
    					<a href="#" rel="<?php echo $class;?>" role="<?php echo $blog_id;?>" class="blog-button-toggle visit <?php echo $class;?>"><?php echo ($class == 'isLive' ? 'Live Site' : 'Go Live');?></a></br>
    				</div>
                <?php endif; ?>
				<!-- <div class="meta">

					<?php bp_blog_latest_post(); ?>
					
				</div> -->

			</div>

			<div class="clear"></div>
		</li>

	<?php endwhile; ?>

	</ul>

	<?php

	/**
	 * Fires after the blogs directory list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_directory_blogs_list' ); ?>

	<?php bp_blog_hidden_fields(); ?>

	<div id="pag-bottom" class="pagination">

		<div class="pag-count" id="blog-dir-count-bottom">

			<?php bp_blogs_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="blog-dir-pag-bottom">

			<?php bp_blogs_pagination_links(); ?>

		</div>

	</div>

<?php else : ?>

	<div id="message" class="info">
		<p><?php _e( 'Sorry, there were no sites found.', 'buddypress' ); ?></p>
	</div>

<?php endif; ?>

<?php

/**
 * Fires after the display of the blogs loop.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_blogs_loop' ); 
}else{
  $page = get_page_by_title('Not Allowed');
  // echo "<pre>";print_r($page);"</pre>";
  wp_redirect( get_permalink( $page->ID ) );
}

?>