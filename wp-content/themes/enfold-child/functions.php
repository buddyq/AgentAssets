<?php
/*
Enfold functions overrides
*/

add_theme_support('deactivate_layerslider');

$avia_config['imgSize']['slider_post_img'] = array('width'=>500,  'height'=>375); // for homepage slider using post image

add_action( 'admin_enqueue_scripts', 'load_admin_style' );


function load_admin_style() {
  // wp_register_style( 'admin_css', get_template_directory_uri() . '/admin-style.css', false, '1.0.0' );
  //OR
  wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/css/admin-style.css', false, '1.0.0' );
}

// Used for the conditional output on the pricing page.
function show_packages(){
  global $wpdb;
  $user_id = get_current_user_id();
  $total_package = $wpdb->get_results("SELECT id FROM `" . $wpdb->base_prefix . "orders` WHERE user_id = '" . $user_id . "' AND status='1'");
  $has_package = $total_package;
  return $has_package;
}

function rebranding_wordpress_logo(){
  global $wp_admin_bar;
  //the following codes is to remove sub menu
  $wp_admin_bar->remove_menu('about');
  $wp_admin_bar->remove_menu('documentation');
  $wp_admin_bar->remove_menu('support-forums');
  $wp_admin_bar->remove_menu('feedback');
  $wp_admin_bar->remove_menu('wporg');

  //and this is to change wordpress logo
  $wp_admin_bar->add_menu( array(
      'id'    => 'wp-logo',
      'title' => '<img src="http://agentassets.com/wp-content/uploads/2016/05/AA_circle-20px.png" />',
      'href'  => __('http://www.agentassets.com/'),
      'meta'  => array(
          'title' => __('Back to AgentAssets.com'),
      ),
  ) );
}
add_action('wp_before_admin_bar_render', 'rebranding_wordpress_logo' );

function notify_admin_newsite($msg){
  // Extract pertinent information from the message.
  // Maybe a better way to do this? Filter is called after message is assembled...
  preg_match("/New\sSite:\s([^\\n]*)/", $msg, $site_name);
  preg_match("/URL:\s([^\\n]*)/", $msg, $site_url);
  preg_match("/Remote\sIP:\s([^\\n]*)/", $msg, $remote_ip);
  preg_match("/Disable\sthese\snotifications:\s([^\\n]*)/", $msg, $disable_notifications);
  preg_match("!^([a-z])?\.?agentassets\.com$!", $site_url[1], $blog_name);

  $user = get_userdata(get_current_user_id());
  $blog_details = get_blog_details($blog_name[1]);
  $options_site_url = esc_url(network_admin_url('settings.php'));

  $top_description = 'Message from the Admin of AgentAssets.com';
  $email_title = 'A New Site Has Been Created!';
  $email_body = '
  <table>
    <tr>
      <td width="50%"><strong>Created by: </strong></td>
      <td>'.$user->display_name.' - ('.$user->user_login.')</td>
    </tr>
    <tr>
      <td><strong>Email: </strong> </td>
      <td>'.$user->user_email.'</td>
    </tr>
    <tr>
      <td><strong>Site Title: </strong></td>
      <td>'.$site_name[1].'</td>
    </tr>
    <tr>
      <td><strong>URL: </strong></td>
      <td>'.$site_url[1].'</td>
    </tr>
    <tr>
      <td><strong>Remote IP: </strong></td>
      <td>'.$remote_ip[1].'</td>
    </tr>
  </table>';

  include_once(dirname(__FILE__).'/includes/aa-email-template.php');

  return $msg;
}
add_action('newblog_notify_siteadmin', 'notify_admin_newsite', 10, 1 );


?>
