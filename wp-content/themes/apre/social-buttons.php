<?php
$agentInformation = AgentInformationModel::model();
$aveone_facebook = $agentInformation->facebook;
$aveone_twitter_id = $agentInformation->twitter;
$aveone_googleplus = $agentInformation->google_plus;
?>   

<ul class="sc_menu">

<?php 
if (!empty($aveone_facebook)) { ?>
<li>
	<a target="_blank" href="//facebook.com/<?php echo $aveone_facebook;?>" class="tipsytext" id="facebook" original-title="<?php _e( 'Facebook', 'aveone' ); ?>"><img src="<?php echo get_template_directory_uri();?>/images/social/facebook.png" alt="Facebook"/></a></li><?php } else { ?>
<?php } ?>

<?php 
  if (!empty($aveone_twitter_id)) { ?>
<li><a target="_blank" href="//twitter.com/<?php echo $aveone_twitter_id;?>" class="tipsytext" id="twitter" original-title="<?php _e( 'Twitter', 'aveone' ); ?>"><img src="<?php echo get_template_directory_uri();?>/images/social/twitter.png" alt="Twitter"/></a></li><?php } else { ?><?php } ?>

<?php 
  if (!empty($aveone_googleplus)) { ?>
<li><a target="_blank" href="//plus.google.com/<?php echo $aveone_googleplus;?>" class="tipsytext" id="plus" original-title="<?php _e( 'Google Plus', 'aveone' ); ?>"><img src="<?php echo get_template_directory_uri();?>/images/social/googleplus.png" alt="Google Plus"/></a></li><?php } else { ?>
    <?php } ?>

</ul>
