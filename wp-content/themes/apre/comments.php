<?php
/**
 * Template: Comments.php
 *
 * @package Aveone
 * @subpackage Template
 */

if ( post_password_required() ) { ?>
	<p class="password-protected alert"><?php _e( 'This post is password protected. Enter the password to view comments.', 'aveone' ); ?></p>
<?php return; } ?>

<div id="comments">   
<?php if ( have_comments() ) : // If comments exist for this entry, continue ?>
<!--BEGIN #comments-->

    
<?php if ( ! empty( $comments_by_type['comment'] ) ) { ?>
	<span class="comments-title-back"><?php aveone_discussion_title( 'comment' ); ?>
    <?php aveone_discussion_rss(); ?></span> 
    <!--BEGIN .comment-list-->
    <ol class="comment-list">
		<?php wp_list_comments(array(
        'type' => 'comment',
        'callback' => 'aveone_comments_callback',
        'end-callback' => 'aveone_comments_endcallback' )); ?>
    <!--END .comment-list-->
    </ol>
    
<div class="navigation-links page-navigation clearfix row">
<div class="col-sm-6 col-md-6 nav-next"><?php previous_comments_link('<div class="btn btn-left icon-arrow-left icon-big">Older Comments</div>'); ?></div>
<div class="col-sm-6 col-md-6 nav-previous"><?php next_comments_link('<div class="btn btn-right icon-arrow-right icon-big">Newer Comments</div>'); ?></div>
</div>    
    
<?php } ?>

<?php if ( ! empty( $comments_by_type['pings'] ) ) { ?>
	<?php aveone_discussion_title( 'pings' ); ?>
	<!--BEGIN .pings-list-->
    <ol class="pings-list">
		<?php wp_list_comments(array(
        'type' => 'pings',
        'callback' => 'aveone_pings_callback',
        'end-callback' => 'aveone_pings_endcallback' )); ?>
	<!--END .pings-list-->
    </ol>
<?php } ?>

<!--END #comments-->   

<?php else : // this is displayed if there are no comments so far ?>
	<?php if ( comments_open() ) :
		// If comments are open, but there are no comments.  
   echo '<span class="comments-title-back"><h3 class="comment-title"><span class="comment-title-meta no-comment">';
   _e( 'No Comments Yet', 'aveone' );
   echo '</span></h3>';
   echo aveone_discussion_rss();
   echo '</span>';
	else : // comments are closed
 
	endif;
endif;
 // ( have_comments() ) ?>
</div>

<?php if ( comments_open() ) : // show comment form ?>
<!--BEGIN #respond-->


    
    
  
    <!--BEGIN #comment-form-->

<div class="clearfix"></div>        

	<?php comment_form(); ?>
    <!--END #comment-form-->
   
    

<!--END #respond-->



<?php endif; // ( comments_open() ) ?>