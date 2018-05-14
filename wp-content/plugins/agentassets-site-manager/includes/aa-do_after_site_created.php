<?php 
/*
 * All actions to perform after a site has been created.
 * @version 1.0
 */

// add_action( 'wpmu_new_blog', 'site_create_checklist', 10, 6 );

function site_create_checklist( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {

    // 1. Add new site expiration date
    new_site_add_expiration_date( $blog_id, $user_id );
    
    // 2. Deduct a credit and then see if we need to cancel membership if they've used all credits
    check_user_credits( $user_id );
    
    // 3. Add blog_owner option to new blog (user_id)
    add_blog_owner( $blog_id, $user_id );
    
    // 4. Add domain mapping into the database
    AgentAssets::add_domain_mapping( $meta['domain_name_to_park'], $blog_id );
    
    // 5. Add parked domain on the server
    AgentAssets::add_parked_domain( $meta['domain_name_to_park'] );
}



function add_blog_owner( $blog_id, $user_id )
{
    
    add_blog_option( $blog_id, 'blog_owner', $user_id );

}

function new_site_add_expiration_date( $blog_id, $user_id ) {

	if( !function_exists('pmpro_getMembershipLevelsForUser' ))
		return;
		
	if( is_user_logged_in() ) {

		$membership_level = pmpro_getMembershipLevelsForUser( $user_id );
		$expire_number = $membership_level[0]->expiration_number;
		$expiration_period = $membership_level[0]->expiration_period;
		
		$expiration_date = strtotime('+'. $expire_number." ".$expiration_period);
	
		update_blog_option( $blog_id, 'expiration', $expiration_date );
	}
}

function check_user_credits( $user_id ){
  
  global $mycred;
  $user_balance = $mycred->get_users_balance( $user_id ) - 1; //Because cred is not taken off before this!
  
  if( $user_balance < 1){
    cancel_users_with_zero_credits( $user_id );
  }
  
}

function cancel_users_with_zero_credits( $user_id ){
  
  $level = 0; // Cancel membership level
  $old_level_status = 'expired';
  $cancelled = pmpro_changeMembershipLevel( $level, $user_id, $old_level_status ); 
  
}
