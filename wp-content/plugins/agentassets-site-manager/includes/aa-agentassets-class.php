<?php 

class AgentAssets{
  
  // Parks a domain name. Triggered when site is created.
  public static function add_parked_domain($domain_name_to_park) {
    
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
          'domain' => $domain_name_to_park,
          // 'topdomain' => ''
      );

      //Just need the username of the cpanel account here. Password is handled above in password auth
      $result = $xmlapi->api2_query($main_site_cpanel_username, 'Park', 'park', $args);    
    }  
    return $result;
  }
  
  // Unparks the domain name from cPanel - Triggered when site is deleted
  public static function unpark_domain($blog_id, $delete_tables){
    global $wpdb;
    $result = '';
    
    switch_to_blog(1);
    $ip = get_option('msm_main_site_ip', '');
    $main_site_port = get_option('msm_main_site_port', '');
    $main_site_output_type = get_option('msm_main_site_output_type', '');
    $main_site_account = get_option('msm_main_site_account', '');
    $main_site_cpanel_username = get_option('msm_main_site_cpanel_username', '');
    $main_site_cpanel_password = get_option('msm_main_site_cpanel_password', '');
    restore_current_blog();
    
    $query = 'SELECT * FROM aa_domain_mapping WHERE blog_id = '. $blog_id;
    
    if($query){
      $domain_name = $wpdb->get_results($query);
      $domain_name = $domain_name[0]->domain;
      // Get cPanel settings from Admin Panel

      // Unpark the domain on the server
      if (!empty($ip) && !empty($main_site_port) && !empty($main_site_output_type) && !empty($main_site_account) && !empty($main_site_cpanel_username) && !empty($main_site_cpanel_password)) {
        $xmlapi = new xmlapi($ip); 
        $xmlapi->set_port($main_site_port); 
        $xmlapi->set_output($main_site_output_type);
        $xmlapi->password_auth($main_site_cpanel_username, $main_site_cpanel_password);
        $xmlapi->set_debug(1);
        $args = array(
            'domain' => $domain_name,
            // 'topdomain' => ''
        );
        //Just need the username of the cpanel account here. Password is handled above in password auth
        $result = $xmlapi->api2_query($main_site_cpanel_username, 'Park', 'unpark', $args); 
      }
    }
    
    return $result;
  }
  
  // This adds maps a domain name to the site
  public static function add_domain_mapping($domain_name_to_park, $blog_id){
    global $wpdb;
    $domain_map_insertion = $wpdb->insert($wpdb->base_prefix . 'domain_mapping', array(
        'blog_id' => $blog_id,
        'domain' => $domain_name_to_park,
        'active' => 0
    ), array(
            '%d',
            '%s',
            '%d'
        )
    );
    switch_to_blog($blog_id);
    update_option( 'domainmap_frontend_mapping', "original" );
    restore_current_blog();
  }
  
  // Determines if given site is Live or Not
  public static function isSiteLive($blog_id){
    global $wpdb;
    $table = $wpdb->prefix . 'domain_mapping';
    $mapped_site = $wpdb->get_row('SELECT active, domain FROM '. $table.' WHERE blog_id = '.$blog_id, ARRAY_A);

    if(isset($mapped_site) && $mapped_site != NULL){
      $domain['live_status'] = ($mapped_site['active'] == true ? 'isLive' : 'notLive');
      $domain['domain'] = $mapped_site['domain'];
    // echo '<input type="checkbox" '.$live_status.' data-toggle="toggle" onclick="">';
      return $domain;
    }
  }
  
  // Ajax handler for "Go Live" button on MY SITES page
  public static function ajax_toggle_livesite() {
    $blog_id = $_POST['id'];
    $toggle = $_POST['live_status'];
    $result = AgentAssets::toggle_domain_mapping($blog_id, $toggle);
    if($result == 1){
      return wp_send_json_success('Succefully saved in db');
    }else{
      return wp_send_json_error('Did not save');
    }
  }
  
  // Toggles domain mapping on/off
  public static function toggle_domain_mapping($blog_id, $live_status) {
    global $wpdb;
    $table = $wpdb->prefix . 'domain_mapping';
    if(isset($live_status)){
      $toggle = ($live_status == 'isLive' ? 0 : 1 );
    }
    $result = $wpdb->query( $wpdb->prepare("UPDATE $table SET active = %d WHERE blog_id = %d", $toggle, $blog_id));
    return $result;
  }
  
  // Turns a site "offline" by switching the flag in the database for domain mapping
  public static function deactivate_site_domain_mapping($blog_id){
    global $wpdb;
    $table = $wpdb->prefix . 'domain_mapping';
    $result = $wpdb->query( $wpdb->prepare("UPDATE $table SET active = 0 WHERE blog_id = %s", $blog_id));
  }
  
  // Gets users MyCred balance - how many sites left
  public static function check_user_credits(){
    
    $user_id = get_current_user_id();
    global $mycred;
    $user_balance = $mycred->get_users_balance( $user_id ) - 1; //Because cred is not taken off before this!
    
    if( $user_balance < 1){
      self::cancel_user_membership($user_id);
    }
    
  }
  
  // Cancels users PMPro membership
  function cancel_user_membership($user_id){
    
    $level = 0; // Cancel membership level
    $old_level_status = 'expired';
    $cancelled = pmpro_changeMembershipLevel(  $level,  $user_id,  $old_level_status); 

  }
  
  public static function aa_signup_user_notification( $user, $user_email, $key, $meta = array() ){
      
      $user = $meta['field_1'];
      $blog_id = get_current_blog_id();
      
      // Send email with activation link.
      $admin_email = get_option( 'admin_email' );
      
      if ( $admin_email == '' )
        $admin_email = 'info@' . $_SERVER['SERVER_NAME'];
        $from_name = get_option( 'blogname' ) == '' ? 'AgentAssets' : esc_html( get_option( 'blogname' ) );
        $message_headers = "From: \"{$from_name}\" <{$admin_email}>\n" . "Content-Type: text/html; charset=\"" . get_option('blog_charset') . "\"\n";
        $message  = sprintf(__('<div style="text-align:center"><h2 style="text-align:center">Thanks for joining AgentAssets, <strong>%s</strong>!</h2>'), $user);
        $message .= '<p>We\'re super glad to have you! You just need to click on the link to verify your account.<br>Once you do that, you can start using the site!<br><br></p>';
        $message .= sprintf(__('<p><a href="%s" class="button" style="text-decoration:none;background-color:#559987;color:#ffffff;border:1px solid #337765;padding:5px 10px 5px 10px;font-weight:300;font-size:20px;text-transform:uppercase;" title="Click to activate your account">Activate Account</a></p></div>'),
        site_url( "wp-activate.php?key=$key" ) );

        $subject = sprintf(
                    apply_filters('wpmu_signup_user_notification_subject', __( '[%1$s] Activate %2$s' ), 
                    $user, $user_email, $key, $meta
                    ),
                    $from_name, $user
                  );
                  $result = wp_mail($user_email, $subject, $message, $message_headers);

                  return false;  
  }
  
  
  // Generates the Group Code
  public static function generateGroupCode($seed = 0) {
    $code = md5(time() - ($seed * 5));
    $code[4] = '-';
    $code[9] = '-';
    return substr($code,0 ,16);
  }
  
  // Gets generated group code and adds it to the groups meta table when a GROUP is created
  public static function add_code_to_new_group(){
    global $bp;
    $group_id = $bp->groups->new_group_id;
    $code = AgentAssets::generateGroupCode();
    AgentAssets::updateGroupCode($group_id, $code);
  }
  
  // Updates the group code to a new code
  public static function updateGroupCode($group_id, $code){
    global $wpdb;
    $table = $wpdb->prefix . 'bp_groups_groupmeta';
    $results = $wpdb->replace($table,
                array(
                  'id' => '',
                  'group_id' => $group_id,
                  'meta_key' => 'group_code',
                  'meta_value' => $code
                ),
                array(
                  '%d',
                  '%d',
                  '%s',
                  '%s'
                )
              );
  }
  
  public static function get_current_theme( $blog_id ){
    
    if ( !isset($blog_id)) {
      $blog_id = get_current_blog_id();
      $theme = get_option('current_theme');
    }else{
      switch_to_blog($blog_id);
      $theme = get_option('current_theme');
      restore_current_blog();
    }
    
    return $theme;
    
  }
  
  public static function join_group($code) {
      global $wpdb;
      $group_id = $wpdb->get_var( $wpdb->prepare("SELECT `group_id` FROM {$wpdb->prefix}bp_groups_groupmeta WHERE `meta_value` = %s", $code) );

      if ($group_id) { // The group code exists... 
          
          // Success
          $result = AgentAssets::add_user_to_group($group_id);
          
      }else{
          // Failed. No such code in the database.
          $result['status']  = 0;
          $result['reason'] = "The group code was not found";
      }
      
      // write_log($result);
      return $result;
      
  }
  
  public static function add_user_to_group($group_id) {
      global $wpdb;
      $table = $wpdb->prefix."bp_groups_members";
      $user_id = get_current_user_id();
      
      // Check to make sure the user doesn't already belong to the group. Otherwise, bail and send a message
      $already_belongs = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE user_id = %d AND group_id = %d", $user_id, $group_id));
      
      if ($already_belongs) {
          write_log("User alrady blongs to group");
          $result['status'] = 0;
          $result['reason'] = 'You already belong to this group!';
          return $result;
      }
      
      // If we're here, the user did not already exist!
      $result['status'] = $wpdb->insert( $table, array(
          'id' => '',
          'group_id' => $group_id,
          'user_id' => $user_id,
          'inviter_id' => '',
          'is_admin' => '0',
          'is_mod' => '0',
          'user_title' => '',
          'date_modified' => $date = date('Y-m-d H:i:s'),
          'comments' => '',
          'is_confirmed' => 1,
          'is_banned' => 0,
          'invite_sent' => 0
      ) );
      
      if ($result['status']) {
          $result['reason'] = "You have been added to the group!";
      }
      return $result;
      
  }

}