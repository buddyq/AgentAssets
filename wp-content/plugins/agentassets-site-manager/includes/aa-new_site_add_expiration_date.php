<?php 

function new_site_add_expiration_date($blog_id, $user_id) {
	// $blog_id = 337;
	// global $blog_id;
	write_log("Blog ID: $blog_id");
	write_log("User ID: $user_id");
	if(!function_exists('pmpro_getMembershipLevelsForUser'))
		return;
		
	if( is_user_logged_in() ) {

		$membership_level = pmpro_getMembershipLevelsForUser($user_id);
		$expire_number = $membership_level[0]->expiration_number;
		$expiration_period = $membership_level[0]->expiration_period;
		

		$expiration_date = strtotime('+'. $expire_number." ".$expiration_period);
		write_log("Expiration Date should be: ". $expiration_date);
		switch_to_blog($blog_id);
		update_option( 'aa_expiration', $expiration_date);
		restore_current_blog();
		update_blog_option($blog_id,"aaexpiration",$expiration_date);
	}
}

add_action( 'wpmu_new_blog', 'new_site_add_expiration_date', 10, 2 );
// add_action('init', 'new_site_add_expiration_date', 10, 2);