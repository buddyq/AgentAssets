<?php 


function my_login_redirect( $redirect_to, $request, $user ) {
	// write_log($redirect_to . " | " . $request . " | ".$user);
	//is there a user to check?
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		//check for admins
		if ( in_array( 'administrator', $user->roles ) ) {
			// redirect them to the default place
			write_log("redirect_to: ". $redirect_to);
			return $redirect_to;
		} else {
			return home_url('/members/'.$user->user_login);
		}
	} else {
		return $redirect_to;
	}
}

// Change login URL
add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );

// Change Logout url
// add_action('wp_logout','auto_redirect_after_logout');

function auto_redirect_after_logout(){
    wp_redirect( home_url() );
    return;
}