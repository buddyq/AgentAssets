<?php 
// add_action( 'wpmu_new_blog', 'add_parked_domain' );

function add_parked_domain(){
  
  // Get cPanel settings from Admin Panel
  $ip = get_option('msm_main_site_ip', '');
  $main_site_port = get_option('msm_main_site_port', '');
  $main_site_output_type = get_option('msm_main_site_output_type', '');
  $main_site_account = get_option('msm_main_site_account', '');
  $main_site_cpanel_username = get_option('msm_main_site_cpanel_username', '');
  $main_site_cpanel_password = get_option('msm_main_site_cpanel_password', '');
  
  // Perform the Park action on the server
  if (!empty($ip) && !empty($main_site_port) && !empty($main_site_output_type) && !empty($main_site_account) && !empty($main_site_cpanel_username) && !empty($main_site_cpanel_password)) {
    $xmlapi = new xmlapi($ip); 
    $xmlapi->set_port($main_site_port); 
    $xmlapi->set_output($main_site_output_type);
    $xmlapi->password_auth($main_site_cpanel_username, $main_site_cpanel_password);
    $xmlapi->set_debug(1);
    $args = array(
        // 'dir' => 'public_html',
        'domain' => $externalDomain,
        'topdomain' => $main_site_account
    );

    //Just need the username of the cpanel account here. Password is handled above in password auth
    $result = $xmlapi->api2_query($main_site_cpanel_username, 'Park', 'park', $args);    
  }
}