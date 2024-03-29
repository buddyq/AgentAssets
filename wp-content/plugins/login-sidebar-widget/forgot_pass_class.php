<?php

class afo_forgot_pass_class {
	
	public function ForgotPassForm(){
		if(!session_id()){
			@session_start();
		}
		
		$this->error_message();
		if(!is_user_logged_in()){
		?>
		<form name="forgot" id="forgot" method="post" action="">
		<input type="hidden" name="option" value="afo_forgot_pass" />
			<ul class="login_wid forgot_pass">
				<li><?php _e('Email','lwa');?></li>
				<li><input type="text" name="user_username" required="required"/></li>
				<li><input name="forgot" type="submit" value="<?php _e('Submit','lwa');?>" /></li>
				<li class="forgot-text"><?php _e('Please enter your email. The password reset link will be provided in your email.','lwa');?></li>
			</ul>
		</form>
		<?php 
		}
	}
	
	public function message_close_button(){
		$cb = '<a href="javascript:void(0);" onclick="closeMessage();" class="close_button_afo">x</a>';
		return $cb;
	}
	
	public function error_message(){
		if(!session_id()){
			@session_start();
		}
		
		if($_SESSION['msg']){
			echo '<div class="'.$_SESSION['msg_class'].'">'.$_SESSION['msg'].$this->message_close_button().'</div>';
			unset($_SESSION['msg']);
			unset($_SESSION['msg_class']);
		}
	}
} 


function forgot_pass_validate(){
	if(!session_id()){
		@session_start();
	}
	
	if(isset($_GET['key']) && $_GET['action'] == "reset_pwd") {
		global $wpdb;
		$reset_key = $_GET['key'];
		$user_login = $_GET['login'];
		$user_data = $wpdb->get_row($wpdb->prepare("SELECT ID, user_login, user_email FROM $wpdb->users WHERE user_activation_key = %s AND user_login = %s", $reset_key, $user_login));
		
		$user_login = $user_data->user_login;
		$user_email = $user_data->user_email;
		
		if(!empty($reset_key) && !empty($user_data)) {
			$new_password = wp_generate_password(7, false);
				wp_set_password( $new_password, $user_data->ID );
			//mailing reset details to the user
			$headers = 'From: '.get_bloginfo('name').' <no-reply@wordpress.com>' . "\r\n";
			$message = __('Your new password for the account at:','lwa') . "\r\n\r\n";
			$message .= site_url() . "\r\n\r\n";
			$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
			$message .= sprintf(__('Password: %s'), $new_password) . "\r\n\r\n";
			$message .= __('You can now login with your new password at: ','lwa') . site_url() . "\r\n\r\n";
                        
                        $message = '';
                        $message .= '<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Agent Assets</title>
	<style type="text/css">
	body {margin: 0; padding: 0; min-width: 100%!important;}
	.content {width: 100%; max-width: 600px;}  
	</style>
</head>
<body yahoo bgcolor="#EEEEEE" style="padding:50px 0;">
        <table align="center" width="70%" bgcolor="#ffffff" border="0" cellpadding="10" cellspacing="0">
            <tr>
				<td style="background-color: #559987;" align="center"><img src="http://agentassets.com/wp-content/uploads/2015/06/aa-logo.png"/></td>
			</tr>
			
			<tr>
                <td>
                    <table class="content" align="center" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td>
								<p>&nbsp;</p>
								<p>Howdy '.$user_login.',</p>
								<p></p>
								<p>Your new password for the account at: <a href="http://agentassets.com">Agent Assets</a></p>
								<p></p>
								<p><strong>Username:</strong> '.$user_login.'</p>
								<p><strong>Password:</strong> '.$new_password.'</p>
								<p></p>
								<p>You can now login with your new password at: <a href="http://agentassets.com/login/">Click here to login</a></p>
								<p>&nbsp;</p>
								<p>Thanks and Regards,</p>
								<p>AgentAssets Team</p>
								<p>&nbsp;</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr>
				<td style="background-color: #559987; color: #FFFFFF;">Copyright &copy; 2015. All rights reserved.</td>
            </tr>
        </table>
    </body>
</html>
';
                        
			
			if ( $message && !wp_mail($user_email, 'Password Reset Request', $message, $headers) ) {
				wp_die('Email failed to send for some unknown reason');
				exit;
			}
			else {
				wp_die('New Password successfully sent to your mail address.');
				exit;
			}
		} 
		else {
			wp_die('Not a Valid Key.');
			exit;
		}
}

	if(isset($_POST['option']) and $_POST['option'] == "afo_forgot_pass"){
	
		global $wpdb;
		$msg = '';
		if(empty($_POST['user_username'])) {
			$_SESSION['msg_class'] = 'error_wid_login';
			$msg .= __('Email is empty!','lwa');
		}
		
		$user_username = $wpdb->escape(trim($_POST['user_username']));
		
		$user_data = get_user_by('email', $user_username);
		if(empty($user_data)) { 
			$_SESSION['msg_class'] = 'error_wid_login';
			$msg .= __('Invalid E-mail address!','lwa');
		}
		
		$user_login = $user_data->data->user_login;
		$user_email = $user_data->data->user_email;
		
		if($user_email){
			$key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
			if(empty($key)) {
				$key = wp_generate_password(10, false);
				$wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));	
			}
			
			//mailing reset details to the user
			$headers = 'From: '.get_bloginfo('name').' <no-reply@wordpress.com>' . "\r\n";
			$message = __('Someone requested that the password be reset for the following account:','lwa') . "\r\n\r\n";
			$message .= site_url() . "\r\n\r\n";
			$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
			$message .= __('If this was a mistake, just ignore this email and nothing will happen.','lwa') . "\r\n\r\n";
			$message .= __('To reset your password, visit the following address:','lwa') . "\r\n\r\n";
			$message .= site_url() . "?action=reset_pwd&key=$key&login=" . rawurlencode($user_login) . "\r\n";
			
                        $message = '';
                        $message .= '<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Agent Assets</title>
	<style type="text/css">
	body {margin: 0; padding: 0; min-width: 100%!important;}
	.content {width: 100%; max-width: 600px;}  
	</style>
</head>
<body yahoo bgcolor="#EEEEEE" style="padding:50px 0;">
        <table align="center" width="70%" bgcolor="#ffffff" border="0" cellpadding="10" cellspacing="0">
            <tr>
				<td style="background-color: #559987;" align="center"><img src="http://agentassets.com/wp-content/uploads/2015/06/aa-logo.png"/></td>
			</tr>
			
			<tr>
                <td>
                    <table class="content" align="center" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td>
								<p>&nbsp;</p>
								<p>Howdy '.$user_login.',</p>
								<p></p>
								<p>Someone requested that the password be reset for the following account: <a href="http://agentassets.com">Agent Assets</a></p>
								<p></p>
								<p><strong>Username:</strong> '.$user_login.'</p>
								<p></p>
								<p>If this was a mistake, just ignore this email and nothing will happen.</p>
								<p></p>
								<p>To reset your password, visit the following address: <a href="http://agentassets.com?action=reset_pwd&key='.$key.'&login='.rawurlencode($user_login).'">Reset Password</a></p>
								<p>&nbsp;</p>
								<p>Thanks and Regards,</p>
								<p>AgentAssets Team</p>
								<p>&nbsp;</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr>
				<td style="background-color: #559987; color: #FFFFFF;">Copyright &copy; 2015. All rights reserved.</td>
            </tr>
        </table>
    </body>
</html>
';
                        
			if ( !wp_mail($user_email, 'Password Reset Request', $message, $headers) ) {
				$_SESSION['msg_class'] = 'error_wid_login';
				$_SESSION['msg'] = __('Email failed to send for some unknown reason.','lwa');
			}
			else {
				$_SESSION['msg_class'] = 'success_wid_login';
				$_SESSION['msg'] = __('We have just sent you an email with Password reset instructions.','lwa');
			}
		} else {
			$_SESSION['msg_class'] = 'error_wid_login';
			$_SESSION['msg'] = $msg;
		}
	}
}
	

add_action( 'init', 'forgot_pass_validate' );
?>