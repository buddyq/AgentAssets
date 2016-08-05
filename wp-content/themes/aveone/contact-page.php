<?php
/**
 * Template Name: Contact 
 *
 * @package Aveone
 * @subpackage Template
 */
 
 get_header(); 
 $aveone_recaptcha_public = aveone_get_option('evl_recaptcha_public','');
 $aveone_recaptcha_private = aveone_get_option('evl_recaptcha_private','');
 $aveone_email_address = aveone_get_option('evl_email_address','');
 $aveone_sent_email_header = aveone_get_option('evl_sent_email_header',get_bloginfo('name')); 
?>  

<?php 

//If the form is submitted
if(isset($_POST['submit'])) {
	//Check to make sure that the name field is not empty
	if(trim($_POST['contact_name']) == '' || trim($_POST['contact_name']) == 'Name (required)') {
		$hasError = true;
	} else {
		$name = trim($_POST['contact_name']);
	}

	//Subject field is not required
	if(function_exists('stripslashes')) {
		$subject = stripslashes(trim($_POST['url']));
	} else {
		$subject = trim($_POST['url']);
	}

	//Check to make sure sure that a valid email address is submitted
	$pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';

	if(trim($_POST['email']) == '' || trim($_POST['email']) == 'Email (required)')  {
		$hasError = true;
	} else if ( preg_match($pattern, $_POST['email']) === 0 ) {
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}

	//Check to make sure comments were entered
	if(trim($_POST['msg']) == '' || trim($_POST['msg']) == 'Message') {
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$comments = stripslashes(trim($_POST['msg']));
		} else {
			$comments = trim($_POST['msg']);
		}
	}

	if((function_exists('recaptcha_get_html')) && ($aveone_recaptcha_public && $aveone_recaptcha_private)) {
		$resp = recaptcha_check_answer ($aveone_recaptcha_private,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
		if(!$resp->is_valid) {
			$hasError = true;
		}
	}   

	//If there is no error, send the email
	if(!isset($hasError)) {  
		$name = wp_filter_kses( $name );
		$email = wp_filter_kses( $email );
		$subject = wp_filter_kses( $subject );
		$comments = wp_filter_kses( $comments );  

		if(function_exists('stripslashes')) {
			$subject = stripslashes($subject);
			$comments = stripslashes($comments);
		}		
  
		$emailTo = $aveone_email_address; //Put your own email address here
    $emailFrom = $aveone_sent_email_header;    
		$body = __('Name:', 'aveone')." $name \n\n";
		$body .= __('Email:', 'aveone')." $email \n\n";
		$body .= __('Subject:', 'aveone')." $subject \n\n";
		$body .= __('Comments:', 'aveone')."\n $comments";
		$headers = 'Reply-To: ' . $name . ' <' . $email . '>' . "\r\n";
    
    if($aveone_sent_email_header) {
    $headers .= 'From: '. $emailFrom . ' <' . $email . '>' . "\r\n";
    } else {
    $headers .= 'From: '. $emailTo . ' <' . $email . '>' . "\r\n";
    }      
		$mail = wp_mail($emailTo, $subject, $body, $headers);
		
		$emailSent = true;
	}

	if($emailSent == true) {
		$_POST['contact_name'] = '';
		$_POST['email'] = '';
		$_POST['url'] = '';
		$_POST['msg'] = '';
	}    
}
?>
    
    			<!--BEGIN #primary .hfeed-->
			<div id="primary" class="hfeed full-width contact-page">
  
  
  
  
  
    <?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>

				<!--BEGIN .hentry-->
				<div id="post-<?php the_ID(); ?>" class="<?php semantic_entries(); ?>"> 
				<h1 class="entry-title"><?php if ( get_the_title() ){ the_title(); }else{ } ?></h1>  
                    
                    <?php if ( current_user_can( 'edit_post', $post->ID ) ): ?>
       
						<?php edit_post_link( __( 'EDIT', 'aveone' ), '<span class="edit-page">', '</span>' ); ?>
            
				
                    <?php endif; ?>

					<!--BEGIN .entry-content .article-->
					<div class="entry-content article">
						<?php the_content(); ?>
            
            	<?php if(isset($hasError)) { //If errors are found ?>
					<div class="alert alert-danger"><i class="fa fa-ban"></i> <?php echo __("Please check if you've filled all the fields with valid information. Thank you.", 'aveone'); ?></div>
					<br />
				<?php } ?>

				<?php if(isset($emailSent) && $emailSent == true) { //If email is sent ?>
					<div class="alert alert-success"><i class="fa fa-check"></i> <?php echo __('Thank you', 'aveone'); ?> <strong><?php echo $name;?></strong> <?php echo __('for using my contact form! Your email was successfully sent!', 'aveone'); ?></div></div>
					<br />
				<?php } ?>
			</div>
			<form action="" method="post">
					
					<div id="comment-input">

						<div class="col-sm-4 col-md-4 padding-l"><input type="text" name="contact_name" id="author" value="<?php if(isset($_POST['contact_name']) && !empty($_POST['contact_name'])) { echo esc_html( $_POST['contact_name'] ); } ?>" placeholder="<?php _e('Name (required)', 'aveone'); ?>" size="22" tabindex="1" aria-required="true" class="input-name"></div>

						<div class="col-sm-4 col-md-4 padding-l"><input type="text" name="email" id="email" value="<?php if(isset($_POST['email']) && !empty($_POST['email'])) { echo esc_html( $_POST['email'] ); } ?>" placeholder="<?php _e('Email (required)', 'aveone'); ?>" size="22" tabindex="2" aria-required="true" class="input-email"></div>
					                     
						<div class="col-sm-4 col-md-4 padding-l"><input type="text" name="url" id="url" value="<?php if(isset($_POST['url']) && !empty($_POST['url'])) { echo esc_html( $_POST['url'] ); } ?>" placeholder="<?php _e('Subject', 'aveone'); ?>" size="22" tabindex="3" class="input-website"></div>
						
					</div>
          
          <div class="clearfix"></div>
					
					<div id="comment-textarea" class="col-md-12">
						
						<textarea name="msg" id="comment" cols="39" rows="4" tabindex="4" class="textarea-comment" placeholder="<?php _e('Message', 'aveone'); ?>"><?php if(isset($_POST['msg']) && !empty($_POST['msg'])) { esc_html( $_POST['msg'] ); } ?></textarea>
					
					</div>
          
          <div class="clearfix"></div>

					<?php if((function_exists('recaptcha_get_html')) && ($aveone_recaptcha_public && $aveone_recaptcha_private)): ?>

					<div id="comment-recaptcha">

					<?php echo recaptcha_get_html($aveone_recaptcha_public, null, is_ssl() ); ?>

					</div>

					<?php endif; ?>
					
					<div id="comment-submit">

						<div><input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Send Message', 'aveone'); ?>"></div>			
					</div>

			</form>
            
            
            
            
            
					<!--END .entry-content .article-->
          <div class="clearfix"></div> 
					
          
             

					<!-- Auto Discovery Trackbacks
					<?php trackback_rdf(); ?>
					-->
				<!--END .hentry-->
				</div>
        
               <?php $aveone_share_this = aveone_get_option('evl_share_this','single'); if (($aveone_share_this == "all")) { 
        aveone_sharethis();  } ?>
        
				<?php comments_template( '', true ); ?>

			<?php endwhile; endif; ?> 
  
  
  
  
  
 	<!--END #primary .hfeed-->
			</div> 
  
  

	<?php get_footer(); ?>