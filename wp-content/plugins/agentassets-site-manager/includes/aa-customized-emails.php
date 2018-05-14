<?php 
// remove_filter( 'wpmu_signup_blog_notification', 'bp_core_activation_signup_blog_notification', 1);
// remove_filter( 'wpmu_signup_user_notification', 'bp_core_activation_signup_blog_notification', 1);
// remove_filter( 'wpmu_signup_blog_notification_email', 'bp_core_activation_signup_blog_notification', 1);


add_filter( 'newuser_notify_siteadmin', 'aa_activated_user_email', 10, 2);

function aa_activated_user_email( $msg, $user){
  global $bp;
  $user_id = $user->ID;
  // write_log('$user_id: '. $user_id);
  $users_name = xprofile_get_field_data( 'Name', $user_id );
  $new_user = get_userdata($user->ID);
  // $users_name = xprofile_get_field_data( 'Name' , $user->ID);
  write_log('$users_name: '.$users_name);
  $msg  = "<h1>A User has been activated!</h1>";
  $msg .= "<p>Name: <strong>".$users_name."</strong><br>";
  $msg .= "<p>UserID: <strong>".$user->ID."</strong><br>";
  $msg .= "<p>User Login: <strong>".$new_user->user_login."</strong><br>";
  $msg .= "<p>User Email: <strong>".$new_user->user_email."</strong><br>";
  $msg .= "<p>Registered on: <strong>".$new_user->user_registered."</strong><br>";
  $msg .= "</p>";
  
  return $msg;
}



add_filter( 'newblog_notify_siteadmin', 'aa_newblog_notify_siteadmin', 10, 1);

function aa_newblog_notify_siteadmin( $msg ) {
  
  global $blog_id;
  global $blogname;
  global $siteurl;
  global $user_id;
  $user = get_userdata($user_id);
  $ip = wp_unslash( $_SERVER['REMOTE_ADDR'] );
  $new_msg  = "<h1>A New Site Was Created!</h1>";
  $new_msg .= "<p>Created by: <strong>".$user->user_login."</strong></p>";
  $msg = str_replace("New Site: ", "<p>New Site: <strong>", $msg);
  $msg = str_replace("URL:", "</strong></p><p>Site URL: <strong>", $msg);
  $msg = str_replace("Remote IP address:", "</strong></p><p>Remote IP address: <strong>", $msg);
  $msg = str_replace("Disable", "</strong></p><p>Disable", $msg);
  $msg = $new_msg . $msg.'</p>';
  
  return $msg;
  
}





function new_user_notification_email( $email, $user, $blogname ) {
  $text = __( '

<h1>Your new account is set up</h1>

<p class="center"><strong>You can log in with the following information:</strong></p>
<p class="center">Username: <strong>USERNAME</strong><br>
Password: <strong>PASSWORD</strong><br>
<a href="LOGINLINK">LOGIN</a>

Thanks!

SITE_NAME', 'ub' );
  $text = preg_replace( '/USERNAME/', $user->user_login, $text );
  $text = preg_replace( '/PASSWORD/', $_REQUEST['password_1'], $text );
  $text = preg_replace( '/LOGINLINK/', network_site_url( 'wp-login.php' ), $text );
  $text = preg_replace( '/SITE_NAME/', $blogname, $text );
  $email['message'] = $text;
  return $email;
}

?>