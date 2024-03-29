<?php
/**
 * Template: Index.php
 *
 * @package Aveone
 * @subpackage Template
 */

get_header();
global $post;
?>



    <?php $xyz = "";
    $aveone_layout = aveone_get_option('evl_layout','2cl');
    $aveone_post_layout = aveone_get_option('evl_post_layout','two');
    $aveone_nav_links = aveone_get_option('evl_nav_links','after');
    $aveone_header_meta = aveone_get_option('evl_header_meta','single_archive');
	  $aveone_category_page_title = aveone_get_option('evl_category_page_title','1');
    $aveone_excerpt_thumbnail = aveone_get_option('evl_excerpt_thumbnail','0');
    $aveone_share_this = aveone_get_option('evl_share_this','single');
    $aveone_post_links = aveone_get_option('evl_post_links','after');
    $aveone_similar_posts = aveone_get_option('evl_similar_posts','disable');
    $aveone_featured_images = aveone_get_option('evl_featured_images','1');
    $aveone_thumbnail_default_images=aveone_get_option('evl_thumbnail_default_images','0');
    $aveone_posts_excerpt_title_length=intval(aveone_get_option('evl_posts_excerpt_title_length','40'));
    $aveone_blog_featured_image =  aveone_get_option('evl_blog_featured_image','0');


  if (($aveone_layout == "1c"))


    { ?>


  <?php } else { ?>

  <?php $options = get_option('aveone');

  if((is_page() || is_single()) && get_post_meta($post->ID, 'aveone_full_width', true) == 'yes'):

  else:

  if ($aveone_layout == "3cm" || $aveone_layout == "3cl" || $aveone_layout == "3cr") { ?>

  <?php get_sidebar('2'); ?>

  <?php } ?>

  <?php endif; ?>

    <?php } ?>



			<!--BEGIN #primary .hfeed-->
			<div id="primary" class="<?php echo $post->post_name;?>

      <?php
      $content_css = '';
    	if(get_post_meta($post->ID, 'aveone_full_width', true) == 'yes'):
			$content_css = ' full-width';
		  echo $content_css;
		endif;?>">


      <?php
      /*$aveone_breadcrumbs = aveone_get_option('evl_breadcrumbs','1');
      if ($aveone_breadcrumbs == "1"):
      if (!is_home() || !is_front_page()): aveone_breadcrumb();
      endif;
      endif;*/ ?>


 <!-- attachment begin -->


 <?php if (is_attachment()) { ?>


     <?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>

				<!--BEGIN .hentry-->
				<div id="post-<?php the_ID(); ?>" class="<?php semantic_entries(); ?>">

            <?php $options = get_option('aveone'); if (($aveone_header_meta == "") || ($aveone_header_meta == "single_archive"))
        { ?>

        <h1 class="entry-title"><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment" class="attach-font"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php if ( get_the_title() ){ the_title();
 } ?></h1>



	<!--BEGIN .entry-meta .entry-header-->
					<div class="entry-meta entry-header">
          <a href="<?php the_permalink() ?>"><span class="published updated"><?php the_time(get_option('date_format')); ?></span></a>

          <?php /*if ( comments_open() ) : ?>
          <span class="comment-count"><?php comments_popup_link( __( 'Leave a Comment', 'aveone' ), __( '1 Comment', 'aveone' ), __( '% Comments', 'aveone' ) ); ?></span>
          <?php else : // comments are closed
           endif;*/ ?>


          <span class="author vcard">

          <?php $aveone_author_avatar = aveone_get_option('evl_author_avatar','0');
          if ($aveone_author_avatar == "1") { echo get_avatar( get_the_author_meta('email'), '30' ); } ?>



          <?php _e( 'By', 'aveone' ); ?> <strong><?php printf( '<a class="url fn" href="' . get_author_posts_url( $authordata->ID, $authordata->user_nicename ) . '" title="' . sprintf( 'View all posts by %s', $authordata->display_name ) . '">' . get_the_author() . '</a>' ) ?></strong></span>

						<?php edit_post_link( __( 'edit', 'aveone' ), '<span class="edit-post">', '</span>' ); ?>

					<!--END .entry-meta .entry-header-->
                    </div>

                     <?php } else { ?>

                    <h1 class="entry-title"><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h1>

                     <?php if ( current_user_can( 'edit_post', $post->ID ) ): ?>

				    <?php edit_post_link( __( 'EDIT', 'aveone' ), '<span class="edit-post edit-attach">', '</span>' ); ?>
                    <?php endif; ?>

                    <?php } ?>

					<!--BEGIN .entry-content .article-->
					<div class="entry-content article">


							<?php if ( wp_attachment_is_image() ) :
	$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
	foreach ( $attachments as $k => $attachment ) {
		if ( $attachment->ID == $post->ID )
			break;
	}
	$k++;
	// If there is more than 1 image attachment in a gallery
	if ( count( $attachments ) > 1 ) {
		if ( isset( $attachments[ $k ] ) )
			// get the URL of the next image attachment
			$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
		else
			// or get the URL of the first image attachment
			$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
	} else {
		// or, if there's only 1 image attachment, get the URL of the image
		$next_attachment_url = wp_get_attachment_url();
	}
?>
						<p class="attachment" align="center"><a href="<?php echo wp_get_attachment_url(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" class="single-gallery-image"><?php
							echo wp_get_attachment_image( $post->ID, $size='medium' ); // filterable image width with, essentially, no limit for image height.
						?></a></p>




              <div class="navigation-links single-page-navigation clearfix row">
<div class="col-sm-6 col-md-6 nav-previous"><?php previous_image_link ( false, '<div class="btn btn-left icon-arrow-left icon-big">Previous Image</div>' ); ?></div>
	<div class="col-sm-6 col-md-6 nav-next"><?php next_image_link ( false, '<div class="btn btn-right icon-arrow-right icon-big">Next Image</div>' ); ?></div>

<!--END .navigation-links-->
	</div>


<?php else : ?>
						<a href="<?php echo wp_get_attachment_url(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php echo basename( get_permalink() ); ?></a>
<?php endif; ?>

<div class="entry-caption"><?php if ( !empty( $post->post_excerpt ) ) the_excerpt(); ?></div>



					 <!--END .entry-content .article-->
           <div class="clearfix"></div>
					</div>
				<!--END .hentry-->
				</div>

         <?php $options = get_option('aveone'); if (($aveone_share_this == "single_archive") || ($aveone_share_this == "all")) {
        aveone_sharethis();  } else { ?> <div class="margin-40"></div> <?php }?>


				<?php //comments_template( '', true ); ?>

				<?php endwhile; else : ?>

				<!--BEGIN #post-0-->
				<div id="post-0" class="<?php semantic_entries(); ?>">
					<h1 class="entry-title"><?php _e( 'Not Found', 'aveone' ); ?></h1>

					<!--BEGIN .entry-content-->
					<div class="entry-content">
						<p><?php _e( 'Sorry, no attachments matched your criteria.', 'aveone' ); ?></p>
					<!--END .entry-content-->
					</div>
				<!--END #post-0-->
				</div>

         <!-- attachment end -->

			<?php endif; ?>

 <!--  single post begin  -->

 <?php } elseif (is_single()) { ?>


 <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>

                 <?php $options = get_option('aveone'); if (($aveone_post_links == "before") || ($aveone_post_links == "both")) { ?>


         <span class="nav-top">
				<?php get_template_part( 'navigation', 'index' ); ?>
        </span>

        <?php } ?>

				<!--BEGIN .hentry-->
				<div id="post-<?php the_ID(); ?>" class="<?php semantic_entries(); ?> col-md-12">




          <?php $options = get_option('aveone'); if (($aveone_header_meta == "") || ($aveone_header_meta == "single") || ($aveone_header_meta == "single_archive"))
        { ?>  <h1 class="entry-title"><?php if ( get_the_title() ){ the_title(); } ?></h1>


					<!--BEGIN .entry-meta .entry-header-->
					<div class="entry-meta entry-header">
          <a href="<?php the_permalink() ?>"><span class="published updated"><?php the_time(get_option('date_format')); ?></span></a>

          <?php /*if ( comments_open() ) : ?>
          <span class="comment-count"><?php comments_popup_link( __( 'Leave a Comment', 'aveone' ), __( '1 Comment', 'aveone' ), __( '% Comments', 'aveone' ) ); ?></span>
          <?php else : // comments are closed
           endif;*/ ?>


          <span class="author vcard">

          <?php $aveone_author_avatar = aveone_get_option('evl_author_avatar','0');
          if ($aveone_author_avatar == "1") { echo get_avatar( get_the_author_meta('email'), '30' );

          } ?>



          <?php _e( 'Written by', 'aveone' ); ?> <strong><?php printf( '<a class="url fn" href="' . get_author_posts_url( $authordata->ID, $authordata->user_nicename ) . '" title="' . sprintf( 'View all posts by %s', $authordata->display_name ) . '">' . get_the_author() . '</a>' ) ?></strong></span>


            				    <?php edit_post_link( __( 'edit', 'aveone' ), '<span class="edit-post">', '</span>' ); ?>
					<!--END .entry-meta .entry-header-->
                    </div>   <?php } else { ?>

                    <h1 class="entry-title"><?php the_title(); ?></h1>

                     <?php if ( current_user_can( 'edit_post', $post->ID ) ): ?>

						<?php edit_post_link( __( 'EDIT', 'aveone' ), '<span class="edit-post edit-attach">', '</span>' ); ?>



                    <?php endif; ?>

                    <?php } ?>

         <?php
           if($aveone_blog_featured_image == "1" && has_post_thumbnail()) {
	       echo '<span class="thumbnail-post-single">';
           the_post_thumbnail('post-thumbnail');
           echo '</span>';
           }
         ?>

			<!--BEGIN .entry-content .article-->
					<div class="entry-content article">
						<?php the_content( __('READ MORE &raquo;', 'aveone' ) ); ?>
            <?php wp_link_pages( array( 'before' => '<div id="page-links"><p>' . __( '<strong>Pages:</strong>', 'aveone' ), 'after' => '</p></div>' ) ); ?>
					<!--END .entry-content .article-->

          <div class="clearfix"></div>
          </div>


						<!--BEGIN .entry-meta .entry-footer-->
                    <div class="entry-meta entry-footer row">
                    <div class="col-md-6">

                    	<?php if ( aveone_get_terms( 'cats' ) ) { ?>
                    	<div class="entry-categories"> <?php echo aveone_get_terms( 'cats' ); ?></div>
                      <?php } ?>
						<?php if ( aveone_get_terms( 'tags' ) ) { ?>
                                                <div class="entry-tags"> <?php echo aveone_get_terms( 'tags' ); ?></div>
                        <?php } ?>
					<!--END .entry-meta .entry-footer-->

          </div>

          <div class="col-md-6">
           <?php $options = get_option('aveone'); if (($aveone_share_this == "") || ($aveone_share_this == "single") || ($aveone_share_this == "single_archive")  || ($aveone_share_this == "all")) {
        aveone_sharethis(); } else { ?> <div class="margin-40"></div> <?php }?>
        </div>

                    </div>



                    <!-- Auto Discovery Trackbacks
					<?php trackback_rdf(); ?>
					-->
				<!--END .hentry-->
				</div>






<?php $options = get_option('aveone'); if (($aveone_similar_posts == "") || ($aveone_similar_posts == "disable")) {} else {
aveone_similar_posts(); } ?>


        <?php $options = get_option('aveone'); if (($aveone_post_links == "") || ($aveone_post_links == "after") || ($aveone_post_links == "both")) { ?>

				<?php get_template_part( 'navigation', 'index' ); ?>


        <?php } ?>

				<?php //comments_template( '', true ); ?>

				<?php endwhile; else : ?>

				<!--BEGIN #post-0-->
				<div id="post-0" class="<?php semantic_entries(); ?>">
					<h1 class="entry-title"><?php _e( 'Not Found', 'aveone' ); ?></h1>



					<!--BEGIN .entry-content-->
					<div class="entry-content">
						<p><?php _e( 'Sorry, but you are looking for something that isn\'t here.', 'aveone' ); ?></p>
						<?php get_search_form(); ?>
					<!--END .entry-content-->
					</div>
				<!--END #post-0-->
				</div>

			<?php endif; ?>

 <!--  single post end -->


 <!-- home/date/category/tag/search/author begin -->

      <?php } elseif ( is_date() || is_category() || is_tag() || is_search() || is_author()) { ?>



 <!-- 2 or 3 columns begin -->



      <?php if (is_date()) { ?>


      	<?php /* If this is a daily archive */ if ( is_day() ) { ?>
				<h2 class="page-title archive-title"><?php _e( 'Daily archives for', 'aveone' ); ?> <span class="daily-title updated"><?php the_time( 'F jS, Y' ); ?></span></h2>
        				<?php /* If this is a monthly archive */ } elseif ( is_month() ) { ?>
				<h2 class="page-title archive-title"><?php _e( 'Monthly archives for', 'aveone' ); ?> <span class="monthly-title updated"><?php the_time( 'F, Y' ); ?></span></h2>
				<?php /* If this is a yearly archive */ } elseif ( is_year() ) { ?>
				<h2 class="page-title archive-title"><?php _e( 'Yearly archives for', 'aveone' ); ?> <span class="yearly-title updated"><?php the_time( 'Y' ); ?></span></h2>
				<?php } ?>

      <?php } elseif (is_category() && $aveone_category_page_title) { ?>
    <h2 class="page-title archive-title"><?php _e( 'Posts in category', 'aveone' ); ?> <span id="category-title"><?php single_cat_title(); ?></span></h2>


       <?php } elseif (is_tag()) { ?>
       <h2 class="page-title archive-title"><?php _e( 'Posts tagged', 'aveone' ); ?> <span id="tag-title"><?php single_tag_title(); ?></span></h2>


       <?php } elseif (is_search()) { ?>


       <h2 class="page-title search-title"><?php _e( 'Search results for', 'aveone' ); ?> <?php echo '<span class="search-term">'.the_search_query().'</span>'; ?></h2>

          <?php } elseif (is_author()) { ?>


       <h2 class="page-title archive-title"><?php _e( 'Posts by', 'aveone' ); ?> <span class="author-title"><?php the_post(); echo $authordata->display_name; rewind_posts(); ?></span></h2>

       <?php } ?>

  <?php $options = get_option('aveone'); if ($aveone_post_layout == "two" || $aveone_post_layout == "three") { ?>


       <?php if (($aveone_nav_links == "before") || ($aveone_nav_links == "both")) { ?>



				   <span class="nav-top">
				<?php get_template_part( 'navigation', 'index' ); ?>
        </span>

        <?php } else {?>

        <?php } ?>



			<?php if ( have_posts() ) : ?>





                <?php while ( have_posts() ) : the_post(); ?>


				<!--BEGIN .hentry-->
				<div id="post-<?php the_ID(); ?>" class="<?php semantic_entries(); if ($aveone_post_layout == "two") { echo ' col-md-6 odd'.($xyz++%2); } else { echo ' col-md-4 odd'.($xyz++%3); } ?> <?php if (has_post_format( array('aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'),'')) { echo 'formatted-post'; } ?> margin-40">



          <?php $options = get_option('aveone'); if (($aveone_header_meta == "") || ($aveone_header_meta == "single_archive"))
        { ?>

					<h2 class="entry-title">



          <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">
<?php
if ( get_the_title() ){ $title = the_title('', '', false);
echo aveone_truncate($title, $aveone_posts_excerpt_title_length, '...'); } ?></a>



          </h2>

					<!--BEGIN .entry-meta .entry-header-->
					<div class="entry-meta entry-header">
          <a href="<?php the_permalink() ?>"><span class="published updated"><?php the_time(get_option('date_format')); ?></span></a>
          <span class="author vcard">

          <?php _e( 'Written by', 'aveone' ); ?> <strong><?php printf( '<a class="url fn" href="' . get_author_posts_url( $authordata->ID, $authordata->user_nicename ) . '" title="' . sprintf( 'View all posts by %s', $authordata->display_name ) . '">' . get_the_author() . '</a>' ) ?></strong></span>

						 <?php edit_post_link( __( 'edit', 'aveone' ), '<span class="edit-post">', '</span>' ); ?>

					<!--END .entry-meta .entry-header-->
                    </div>

                  <?php } else { ?>

                    <h1 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">
<?php
if ( get_the_title() ){ $title = the_title('', '', false);
echo aveone_truncate($title, 40, '...'); }
 ?></a> </h1>

                     <?php if ( current_user_can( 'edit_post', $post->ID ) ): ?>

						<?php edit_post_link( __( 'EDIT', 'aveone' ), '<span class="edit-post edit-attach">', '</span>' ); ?>



                    <?php endif; ?>

                    <?php } ?>

					<!--BEGIN .entry-content .article-->
					<div class="entry-content article">


          <?php if ($aveone_featured_images == "1") { ?>

            <?php
if(has_post_thumbnail()) {
	echo '<span class="thumbnail-post"><a href="'; the_permalink(); echo '">';the_post_thumbnail('post-thumbnail'); echo '
  <div class="mask">
     <div class="icon"></div>
     </div>

  </a></span>';

     } else {

                      $image = aveone_get_first_image();

                        if ($image):
                      echo '<span class="thumbnail-post"><a href="'; the_permalink(); echo'"><img src="'.$image.'" alt="';the_title();echo'" />
                       <div class="mask">
     <div class="icon"></div>
     </div>
     </a></span>';

                       else:
    if($aveone_thumbnail_default_images==0)
    {
                      echo '<span class="thumbnail-post"><a href="'; the_permalink(); echo'"><img src="'.get_template_directory_uri().'/library/media/images/no-thumbnail.jpg" alt="';the_title();echo'" />
                       <div class="mask">
     <div class="icon"></div>
     </div>
     </a></span>';
    }

                       endif;
               } ?>
               <?php } ?>



    <?php the_excerpt(); ?>

          <div class="entry-meta entry-footer">

          <div class="read-more btn btn-right icon-arrow-right">
           <a href="<?php the_permalink(); ?>"><?php _e('READ MORE', 'aveone' ); ?></a>
           </div>

           <?php /*if ( comments_open() ) : ?>
          <span class="comment-count"><?php comments_popup_link( __( 'Leave a Comment', 'aveone' ), __( '1 Comment', 'aveone' ), __( '% Comments', 'aveone' ) ); ?></span>
          <?php else : // comments are closed
           endif;*/ ?>
          </div>

					<!--END .entry-content .article-->
          <div class="clearfix"></div>
					</div>



				<!--END .hentry-->
				</div>

        <?php $i='';$i++; ?>

				<?php endwhile; ?>
				<?php get_template_part( 'navigation', 'index' ); ?>
				<?php else : ?>



        <?php if (is_search()) { ?>


        	<!--BEGIN #post-0-->
				<div id="post-0" class="<?php semantic_entries(); ?>">
					<h1 class="entry-title"><?php _e( 'Your search for', 'aveone' ); ?> "<?php echo the_search_query(); ?>" <?php _e( 'did not match any entries', 'aveone' ); ?></h1>

					<!--BEGIN .entry-content-->
					<div class="entry-content">
				<br />
						<p><?php _e( 'Suggestions:', 'aveone' ); ?></p>
						<ul>
							<li><?php _e( 'Make sure all words are spelled correctly.', 'aveone' ); ?></li>
							<li><?php _e( 'Try different keywords.', 'aveone' ); ?></li>
							<li><?php _e( 'Try more general keywords.', 'aveone' ); ?></li>
						</ul>
					<!--END .entry-content-->
					</div>
				<!--END #post-0-->
				</div>

        <?php } else { ?>

				<!--BEGIN #post-0-->
				<div id="post-0" class="<?php semantic_entries(); ?>">
					<h1 class="entry-title"><?php _e( 'Not Found', 'aveone' ); ?></h1>

					<!--BEGIN .entry-content-->
					<div class="entry-content">
						<p><?php _e( 'Sorry, but you are looking for something that isn\'t here.', 'aveone' ); ?></p>
							<!--END .entry-content-->
					</div>
				<!--END #post-0-->
				</div>

        <?php } ?>

			<?php endif; ?>


<!-- 2 or 3 columns end -->


 <!-- 1 column begin -->


  <?php } else { ?>

      <?php  if (($aveone_nav_links == "before") || ($aveone_nav_links == "both")) { ?>



				   <span class="nav-top">
				<?php get_template_part( 'navigation', 'index' ); ?>
        </span>

        <?php } else {?>

        <?php } ?>



			<?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>





				<!--BEGIN .hentry-->
				<div id="post-<?php the_ID(); ?>" class="<?php semantic_entries(); ?> <?php if (has_post_format( array('aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'),'') || is_sticky()) { echo 'formatted-post formatted-single margin-40'; } ?>">



          <?php  if (($aveone_header_meta == "") || ($aveone_header_meta == "single_archive"))
        { ?>

        <h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php if ( get_the_title() ){ the_title();} ?></a></h1>

					<!--BEGIN .entry-meta .entry-header-->
					<div class="entry-meta entry-header">
          <a href="<?php the_permalink() ?>"><span class="published updated"><?php the_time(get_option('date_format')); ?></span></a>

           <?php /*if ( comments_open() ) : ?>
          <span class="comment-count"><a href="<?php comments_link(); ?>"><?php comments_popup_link( __( 'Leave a Comment', 'aveone' ), __( '1 Comment', 'aveone' ), __( '% Comments', 'aveone' ) ); ?></a></span>
          <?php else : // comments are closed
           endif;*/ ?>

          <span class="author vcard">

          <?php $aveone_author_avatar = aveone_get_option('evl_author_avatar','0');
          if ($aveone_author_avatar == "1") { echo get_avatar( get_the_author_meta('email'), '30' );

          } ?>



          <?php _e( 'Written by', 'aveone' ); ?> <strong><?php printf( '<a class="url fn" href="' . get_author_posts_url( $authordata->ID, $authordata->user_nicename ) . '" title="' . sprintf( 'View all posts by %s', $authordata->display_name ) . '">' . get_the_author() . '</a>' ) ?></strong></span>



            <?php edit_post_link( __( 'edit', 'aveone' ), '<span class="edit-post">', '</span>' ); ?>
					<!--END .entry-meta .entry-header-->
                    </div>

                    <?php } else { ?>

                    <h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php if ( get_the_title() ){ the_title();} ?></a></h1>

                     <?php if ( current_user_can( 'edit_post', $post->ID ) ): ?>

						<?php edit_post_link( __( 'EDIT', 'aveone' ), '<span class="edit-post edit-attach">', '</span>' ); ?>


                    <?php endif; ?>

                    <?php } ?>

					<!--BEGIN .entry-content .article-->
					<div class="entry-content article">

           <?php if ($aveone_featured_images == "1") { ?>

             <?php
if(has_post_thumbnail()) {
	echo '<span class="thumbnail-post"><a href="'; the_permalink(); echo '">';the_post_thumbnail('post-thumbnail'); echo '
  <div class="mask">
     <div class="icon"></div>
     </div>

  </a></span>';

     } else {

                      $image = aveone_get_first_image();



                        if ($image):
                      echo '<span class="thumbnail-post"><a href="'; the_permalink(); echo'"><img src="'.$image.'" alt="';the_title();echo'" />
                       <div class="mask">
     <div class="icon"></div>
     </div>
     </a></span>';

                       else:
                       if($aveone_thumbnail_default_images==0)
                       {
                      echo '<span class="thumbnail-post"><a href="'; the_permalink(); echo'"><img src="'.get_template_directory_uri().'/library/media/images/no-thumbnail.jpg" alt="';the_title();echo'" />
                       <div class="mask">
     <div class="icon"></div>
     </div>
     </a></span>';
                       }


                       endif;
               } ?>
               <?php } ?>

                  <?php if (($aveone_excerpt_thumbnail == "1")) { ?>

          <?php the_excerpt();?>


           <div class="read-more btn btn-right icon-arrow-right">
           <a href="<?php the_permalink(); ?>"><?php _e('READ MORE', 'aveone' ); ?></a>
           </div>

          <?php } else { ?>


						<?php the_content( __('READ MORE &raquo;', 'aveone' ) ); ?>

            <?php wp_link_pages( array( 'before' => '<div id="page-links"><p>' . __( '<strong>Pages:</strong>', 'aveone' ), 'after' => '</p></div>' ) ); ?>

            <?php } ?>

					<!--END .entry-content .article-->
          <div class="clearfix"></div>
					</div>



					<!--BEGIN .entry-meta .entry-footer-->

                     <div class="entry-meta entry-footer row">
                    <div class="col-md-6">
                     <?php if ( aveone_get_terms( 'cats' ) ) { ?>
                    	<div class="entry-categories"> <?php echo aveone_get_terms( 'cats' ); ?></div>
                      <?php } ?>
						<?php if ( aveone_get_terms( 'tags' ) ) { ?>

                        <div class="entry-tags"> <?php echo aveone_get_terms( 'tags' ); ?></div>
                        <?php } ?>
					<!--END .entry-meta .entry-footer-->
                         </div>

                         <div class="col-md-6">
          <?php  if (($aveone_share_this == "single_archive") || ($aveone_share_this == "all")) {
        aveone_sharethis();  } else { ?> <div class="margin-40"></div> <?php }?>
                         </div>
                    </div>

				<!--END .hentry-->
				</div>





      <?php //comments_template(); ?>


				<?php endwhile; ?>


        <?php  if (($aveone_nav_links == "") || ($aveone_nav_links == "after") || ($aveone_nav_links == "both")) { ?>



				<?php get_template_part( 'navigation', 'index' ); ?>

        <?php } else {?>

        <?php } ?>

				<?php else : ?>

		     <?php if (is_search()) { ?>


        	<!--BEGIN #post-0-->
				<div id="post-0" class="<?php semantic_entries(); ?>">

    		<h1 class="entry-title"><?php _e( 'Your search for', 'aveone' ); ?> "<?php echo the_search_query(); ?>" <?php _e( 'did not match any entries', 'aveone' ); ?></h1>

					<!--BEGIN .entry-content-->
					<div class="entry-content">
				<br />
						<p><?php _e( 'Suggestions:', 'aveone' ); ?></p>
						<ul>
							<li><?php _e( 'Make sure all words are spelled correctly.', 'aveone' ); ?></li>
							<li><?php _e( 'Try different keywords.', 'aveone' ); ?></li>
							<li><?php _e( 'Try more general keywords.', 'aveone' ); ?></li>
						</ul>
					<!--END .entry-content-->
					</div>
				<!--END #post-0-->
				</div>

        <?php } else { ?>

				<!--BEGIN #post-0-->
				<div id="post-0" class="<?php semantic_entries(); ?>">
					<h1 class="entry-title"><?php _e( 'Not Found', 'aveone' ); ?></h1>

					<!--BEGIN .entry-content-->
					<div class="entry-content">
						<p><?php _e( 'Sorry, but you are looking for something that isn\'t here.', 'aveone' ); ?></p>



							<!--END .entry-content-->
					</div>
				<!--END #post-0-->
				</div>

        <?php } ?>

			<?php endif; ?>



      <?php } ?>

 <!--  1 column end -->

<!-- home/date/category/tag/search/author end -->

      <?php } elseif (is_page()) { ?>


      <?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>

				<!--BEGIN .hentry-->
				<div id="post-<?php the_ID(); ?>" class="<?php semantic_entries(); ?>">
				<h1 class="entry-title"><?php if ( get_the_title() ){ the_title(); } ?></h1>

                    <?php if ( current_user_can( 'edit_post', $post->ID ) ): ?>
                             <?php
                             global $post;
                             if($post->post_name == "property-details")
                             {
                                ?>
                                <span class="edit-page" >
                                    <a class="post-edit-link" href="<?php echo get_option('siteurl');?>/wp-admin/themes.php?page=theme_options#section-evl-tab-17">EDIT</a>
                                </span>
                                <?php
                             }
                             elseif($post->post_name == "gallery")
                             {
                                ?>
                                <span class="edit-page" >
                                    <a class="post-edit-link" href="<?php echo get_option('siteurl');?>/wp-admin/admin.php?page=new_royalslider">EDIT</a>
                                </span>
                                <?php
                             }
                             elseif($post->post_name == "contact")
                             {
                                ?>
                                <span class="edit-page" >
                                    <a class="post-edit-link" href="<?php echo get_option('siteurl');?>/wp-admin/themes.php?page=theme_options#section-evl-tab-13">EDIT</a>
                                </span>
                                <?php
                             }
                             elseif($post->post_name == "printable-info")
                             {
                                ?>
                                <span class="edit-page" >
                                    <a class="post-edit-link" href="<?php echo get_option('siteurl');?>/wp-admin/themes.php?page=theme_options#section-evl-tab-19">EDIT</a>
                                </span>
                                <?php
                             }
                             elseif($post->post_name == "location")
                             {
                                ?>
                                <span class="edit-page" >
                                    <a class="post-edit-link" href="<?php echo get_option('siteurl');?>/wp-admin/themes.php?page=theme_options#section-evl-tab-13">EDIT</a>
                                </span>
                                <?php
                             }
                             ?>
						<?php //edit_post_link( __( 'EDIT', 'aveone' ), '<span class="edit-page">', '</span>' ); ?>


                    <?php endif; ?>



					<!--BEGIN .entry-content .article-->
					<div class="entry-content article">
						<?php the_content( __('READ MORE &raquo;', 'aveone' ) ); ?>
					<!--END .entry-content .article-->
          <div class="clearfix"></div>
					</div>



					<!-- Auto Discovery Trackbacks
					<?php trackback_rdf(); ?>
					-->
				<!--END .hentry-->
				</div>

               <?php  if (($aveone_share_this == "all")) {
        aveone_sharethis();  } ?>

				<?php //comments_template( '', true ); ?>

			<?php endwhile; endif; ?>



      <?php }elseif (is_404()) { ?>

     	<!--BEGIN #post-0-->
				<div id="post-0" class="<?php semantic_entries(); ?>">
           <h1 class="entry-title"><?php _e( 'Not Found', 'aveone' ); ?></h1>

					<!--BEGIN .entry-content-->
					<div class="entry-content">
						<p><?php _e( 'Sorry, but you are looking for something that isn\'t here.', 'aveone' ); ?></p>


					<!--END .entry-content-->
					</div>
				<!--END #post-0-->
				</div>



      <?php } ?>




			<!--END #primary .hfeed-->
			</div>

      <?php
  if (($aveone_layout == "1c"))


    { ?>


  <?php } else { ?>

  <?php if((is_page() || is_single()) && get_post_meta($post->ID, 'aveone_full_width', true) == 'yes'):

  else: ?>

<?php //get_sidebar(); ?>

<?php endif; ?>

<?php } ?>

<?php get_footer(); ?>
