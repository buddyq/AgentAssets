<?php 

$blog_id = get_current_blog_id();
 switch_to_blog($blog_id);
 $user_email = get_option('admin_email',true);
 
 $user = get_user_by('email',$user_email);
 $user_id = $user->ID;
 if($user_id == 0 || $user == null)
{
    switch_to_blog(1);
    $admin_email = get_option('admin_email');
    $user_details = get_user_by('email',$admin_email);
    $user_id = $user_details->ID;
    switch_to_blog($blog_id);
}
// restore_current_blog();
 

$aveone_facebook = get_user_meta($user_id,'facebook',true);
$aveone_twitter_id = get_user_meta($user_id,'twitter',true);
$aveone_googleplus = get_user_meta($user_id,'googleplus',true);

?>   

<ul class="sc_menu">

<?php 
if (!empty($aveone_facebook)) { ?>
<li>
	<a target="_blank" href="//facebook.com/<?php echo get_user_meta($user_id,'facebook',true);?>" class="tipsytext" id="facebook" original-title="<?php _e( 'Facebook', 'aveone' ); ?>"><img src="<?php echo get_template_directory_uri();?>/images/social/facebook.png" alt="Facebook"/></a></li><?php } else { ?>
<?php } ?>

<?php 
  if (!empty($aveone_twitter_id)) { ?>
<li><a target="_blank" href="//twitter.com/<?php echo get_user_meta($user_id,'twitter',true);?>" class="tipsytext" id="twitter" original-title="<?php _e( 'Twitter', 'aveone' ); ?>"><img src="<?php echo get_template_directory_uri();?>/images/social/twitter.png" alt="Twitter"/></a></li><?php } else { ?><?php } ?>

<?php 
  if (!empty($aveone_googleplus)) { ?>
<li><a target="_blank" href="//plus.google.com/<?php echo get_user_meta($user_id,'googleplus',true);?>" class="tipsytext" id="plus" original-title="<?php _e( 'Google Plus', 'aveone' ); ?>"><img src="<?php echo get_template_directory_uri();?>/images/social/googleplus.png" alt="Google Plus"/></a></li><?php } else { ?>
    <?php } ?>

</ul>
