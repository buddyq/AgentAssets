<?php
/*
Enfold functions overrides - SG
*/

add_theme_support('deactivate_layerslider');

$avia_config['imgSize']['slider_post_img'] = array('width'=>500,  'height'=>375); // for homepage slider using post image

add_action( 'admin_enqueue_scripts', 'load_admin_style' );
add_filter('show_admin_bar', '__return_false');

// add_action( 'ava_inside_main_menu', 'enfold_customization_header_widget_area' );
function enfold_customization_header_widget_area() {
	if(is_user_logged_in()){
		$object = new myCRED_Balance();
		echo '<li class="menu-item menu-item-top-level menu-credit-counter"><span class="credit-counter">'.$object->current.'</span><span class="credits">Sites remaining</span></li>';
	}
}

function my_login_redirect( $redirect_to, $request, $user ) {
	//is there a user to check?
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		//check for admins
		if ( in_array( 'administrator', $user->roles ) ) {
			// redirect them to the default place
			return $redirect_to;
		} else {
			return home_url();
		}
	} else {
		return $redirect_to;
	}
}

add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );

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

function custom_broker_styles($styles = "")
{

  $styles["KW Luxury"] = array(
  						'style'=>'background-color:#b40000;',
  						'default_font' => 'Open Sans:400,600',
  						'google_webfont' => 'Open Sans:400,600',
  						'color_scheme'	=>'Keller Williams',

  						// header
  						'colorset-header_color-bg'				=>'#ffffff',
  						'colorset-header_color-bg2'			 	=>'#f8f8f8',
  						'colorset-header_color-primary'		 	=>'#b40000',
  						'colorset-header_color-secondary'	 	=>'#870000', //Hovered link color
  						'colorset-header_color-color'		 	=>'#333333',
  						'colorset-header_color-border'		 	=>'#e1e1e1',
  						'colorset-header_color-img'			 	=>'',
  						'colorset-header_color-customimage'	 	=>'',
  						'colorset-header_color-pos' 		 	=> 'center center',
  						'colorset-header_color-repeat' 		 	=> 'repeat',
  						'colorset-header_color-attach' 		 	=> 'scroll',
  						'colorset-header_color-heading' 		=> '#000000',
  						'colorset-header_color-meta' 			=> '#808080',

  						// main
  						'colorset-main_color-bg'			 	=>'#ffffff',
  						'colorset-main_color-bg2'			 	=>'#e3e3e3', //Hilight box bg color
  						'colorset-main_color-primary'	 	 	=>'#b40000', //Link color
  						'colorset-main_color-secondary'	 	 	=>'#870000', //Hovered link color
  						'colorset-main_color-color'		 	 	=>'#111111', //Main content font color
  						'colorset-main_color-border'	 	 	=>'#919191', //Border colors
  						'colorset-main_color-img'			 	=>'',
  						'colorset-main_color-customimage'	 	=>'',
  						'colorset-main_color-pos' 			 	=> 'center center',
  						'colorset-main_color-repeat' 		 	=> 'repeat',
  						'colorset-main_color-attach' 		 	=> 'scroll',
  						'colorset-main_color-heading' 			=> '#000000',//Heading color
  						'colorset-main_color-meta' 				=> '#919191', //Secondary font color

  						// alternate
  						'colorset-alternate_color-bg'		 	=>'#ebebeb',
  						'colorset-alternate_color-bg2'		 	=>'#fadfdf', //Alt hilight box bg color
  						'colorset-alternate_color-primary'	 	=>'#b40000',
  						'colorset-alternate_color-secondary' 	=>'#f7bebe', // hovered link
  						'colorset-alternate_color-color'	 	=>'#666666', // Alt Content font color
  						'colorset-alternate_color-border'	 	=>'#b40000', //border colors
  						'colorset-alternate_color-img'		 	=>'',
  						'colorset-alternate_color-customimage'	=>'',
  						'colorset-alternate_color-pos' 		 	=> 'center center',
  						'colorset-alternate_color-repeat' 	 	=> 'repeat',
  						'colorset-alternate_color-attach' 	 	=> 'scroll',
  						'colorset-alternate_color-heading' 		=> '#b40000',
  						'colorset-alternate_color-meta' 		=> '#333333', //


  						// Footer
  						'colorset-footer_color-bg'			 	=>'#222222',
  						'colorset-footer_color-bg2'			 	=>'#111111',
  						'colorset-footer_color-primary'		 	=>'#aaaaaa',
  						'colorset-footer_color-secondary'	 	=>'#ffffff',
  						'colorset-footer_color-color'		 	=>'#aaaaaa',
  						'colorset-footer_color-border'		 	=>'#555555',
  						'colorset-footer_color-img'			 	=>'',
  						'colorset-footer_color-customimage'	 	=>'',
  						'colorset-footer_color-pos' 		 	=> 'center center',
  						'colorset-footer_color-repeat' 		 	=> 'repeat',
  						'colorset-footer_color-attach' 		 	=> 'scroll',
  						'colorset-footer_color-heading' 		=> '#888888',
  						'colorset-footer_color-meta' 			=> '#888888',

  						// Socket
  						'colorset-socket_color-bg'			 	=>'#333333',
  						'colorset-socket_color-bg2'			 	=>'#000000',
  						'colorset-socket_color-primary'		 	=>'#ffffff',
  						'colorset-socket_color-secondary'	 	=>'#eeeeee',
  						'colorset-socket_color-color'		 	=>'#eeeeee',
  						'colorset-socket_color-border'		 	=>'#333333',
  						'colorset-socket_color-img'			 	=>'',
  						'colorset-socket_color-customimage'	 	=>'',
  						'colorset-socket_color-pos' 		 	=> 'center center',
  						'colorset-socket_color-repeat' 		 	=> 'repeat',
  						'colorset-socket_color-attach' 		 	=> 'scroll',
  						'colorset-socket_color-heading' 		=> '#ffffff',
  						'colorset-socket_color-meta' 			=> '#999999',

  						//body bg
  						'color-body_style'						=>'boxed',
  						'color-body_color'						=>'#000000',
  						'color-body_attach'						=>'scroll',
  						'color-body_repeat'						=>'no-repeat',
  						'color-body_pos'						=>'top center',
  						"color-body_img"						=> AVIA_BASE_URL."images/background-images/fullsize-grunge.jpg",
  						'color-body_customimage'				=>'',
  						);


  $styles["Moreland"] = array(
              'style'=>'background-color:#8DC63F;',
              'default_font' => 'Open Sans:400,600',
              'google_webfont' => 'Montserrat',
              'color_scheme'	=>'Moreland',

              // header
              'colorset-header_color-bg'				=>'#8DC63F',
              'colorset-header_color-bg2'			 	=>'#f8f8f8',
              'colorset-header_color-primary'		 	=>'#688a36',
              'colorset-header_color-secondary'	 	=>'#e0e0e0', //Hovered link color
              'colorset-header_color-color'		 	=>'#333333',
              'colorset-header_color-border'		 	=>'#8DC63F',
              'colorset-header_color-img'			 	=>'',
              'colorset-header_color-customimage'	 	=>'',
              'colorset-header_color-pos' 		 	=> 'center center',
              'colorset-header_color-repeat' 		 	=> 'repeat',
              'colorset-header_color-attach' 		 	=> 'scroll',
              'colorset-header_color-heading' 		=> '#000000',
              'colorset-header_color-meta' 			=> '#ffffff',

              // main
              'colorset-main_color-bg'			 	=>'#ffffff',
              'colorset-main_color-bg2'			 	=>'#e3e3e3', //Hilight box bg color
              'colorset-main_color-primary'	 	 	=>'#b40000', //Link color
              'colorset-main_color-secondary'	 	 	=>'#870000', //Hovered link color
              'colorset-main_color-color'		 	 	=>'#111111', //Main content font color
              'colorset-main_color-border'	 	 	=>'#919191', //Border colors
              'colorset-main_color-img'			 	=>'',
              'colorset-main_color-customimage'	 	=>'',
              'colorset-main_color-pos' 			 	=> 'center center',
              'colorset-main_color-repeat' 		 	=> 'repeat',
              'colorset-main_color-attach' 		 	=> 'scroll',
              'colorset-main_color-heading' 			=> '#000000',//Heading color
              'colorset-main_color-meta' 				=> '#919191', //Secondary font color

              // alternate
              'colorset-alternate_color-bg'		 	=>'#f0f0f0',
              'colorset-alternate_color-bg2'		 	=>'#e7f0da', //Alt hilight box bg color
              'colorset-alternate_color-primary'	 	=>'#8ec63f',
              'colorset-alternate_color-secondary' 	=>'#8ec63f', // hovered link
              'colorset-alternate_color-color'	 	=>'#333333', // Alt Content font color
              'colorset-alternate_color-border'	 	=>'#8ec63f', //border colors
              'colorset-alternate_color-img'		 	=>'',
              'colorset-alternate_color-customimage'	=>'',
              'colorset-alternate_color-pos' 		 	=> 'center center',
              'colorset-alternate_color-repeat' 	 	=> 'repeat',
              'colorset-alternate_color-attach' 	 	=> 'scroll',
              'colorset-alternate_color-heading' 		=> '#8ec63f',
              'colorset-alternate_color-meta' 		=> '#000000', //


              // Footer
              'colorset-footer_color-bg'			 	=>'#222222',
              'colorset-footer_color-bg2'			 	=>'#111111',
              'colorset-footer_color-primary'		 	=>'#aaaaaa',
              'colorset-footer_color-secondary'	 	=>'#ffffff',
              'colorset-footer_color-color'		 	=>'#aaaaaa',
              'colorset-footer_color-border'		 	=>'#555555',
              'colorset-footer_color-img'			 	=>'',
              'colorset-footer_color-customimage'	 	=>'',
              'colorset-footer_color-pos' 		 	=> 'center center',
              'colorset-footer_color-repeat' 		 	=> 'repeat',
              'colorset-footer_color-attach' 		 	=> 'scroll',
              'colorset-footer_color-heading' 		=> '#888888',
              'colorset-footer_color-meta' 			=> '#888888',

              // Socket
              'colorset-socket_color-bg'			 	=>'#333333',
              'colorset-socket_color-bg2'			 	=>'#000000',
              'colorset-socket_color-primary'		 	=>'#ffffff',
              'colorset-socket_color-secondary'	 	=>'#eeeeee',
              'colorset-socket_color-color'		 	=>'#eeeeee',
              'colorset-socket_color-border'		 	=>'#333333',
              'colorset-socket_color-img'			 	=>'',
              'colorset-socket_color-customimage'	 	=>'',
              'colorset-socket_color-pos' 		 	=> 'center center',
              'colorset-socket_color-repeat' 		 	=> 'repeat',
              'colorset-socket_color-attach' 		 	=> 'scroll',
              'colorset-socket_color-heading' 		=> '#ffffff',
              'colorset-socket_color-meta' 			=> '#999999',

              //body bg
              'color-body_style'						=>'boxed',
              'color-body_color'						=>'#000000',
              'color-body_attach'						=>'scroll',
              'color-body_repeat'						=>'no-repeat',
              'color-body_pos'						=>'top center',
              "color-body_img"						=> AVIA_BASE_URL."images/background-images/fullsize-grunge.jpg",
              'color-body_customimage'				=>'',
              );
return $styles;
}

add_filter('avf_skin_options', 'custom_broker_styles');

add_filter( 'gettext', 'tgm_envira_whitelabel', 10, 3 );
function tgm_envira_whitelabel( $translated_text, $source_text, $domain ) {

    // If not in the admin, return the default string.
    if ( ! is_admin() ) {
        return $translated_text;
    }

    if ( strpos( $source_text, 'an Envira' ) !== false ) {
        return str_replace( 'an Envira', '', $translated_text );
    }

    if ( strpos( $source_text, 'Envira' ) !== false ) {
        return str_replace( 'Envira', 'Photo', $translated_text );
    }

    return $translated_text;

}
// Code
class bpgmq_feature_group {
    public function __construct() {
        $this->setup_hooks();
    }
    private function setup_hooks() {
        // in Group Administration screen, you add a new metabox to display a checkbox to featured the displayed group
        add_action('bp_groups_admin_meta_boxes', array($this, 'admin_ui_edit_featured'));
        // Once the group is saved you store a groupmeta in db, the one you will search for in your group meta query
        add_action('bp_group_admin_edit_after', array($this, 'admin_ui_save_featured'), 10, 1);
    }
    /**
     * registers a new metabox in Edit Group Administration screen, edit group panel
     */
    public function admin_ui_edit_featured() {
        add_meta_box(
                'bpgmq_feature_group_mb', __('Template Categories'), array(&$this, 'admin_ui_metabox_featured'), get_current_screen()->id, 'side', 'core'
        );
    }
    /**
     * Displays the meta box
     */
    public function admin_ui_metabox_featured($item = false) {
        if (empty($item))
            return;
        $templatects = new blog_templates_model();
        $cats = $templatects->get_templates_categories();
        // Using groups_get_groupmeta to check if the group is featured
        $cats_data = groups_get_groupmeta($item->id, '_bd_temp_cat');
        $socialSel = unserialize($cats_data);
        if (empty($socialSel))
            $socialSel = array();
        foreach ($cats as $k => $v) {
            ?>
                <p><input type="checkbox" name="bd_temp_cat[<?php echo $v['ID']; ?>]" <?php if($v['is_default']) echo 'checked="checked" readonly'; ?> value="1" <?php echo array_key_exists($v['ID'], $socialSel) ? 'checked="checked"' : ''; ?>> <?php echo $v['name']; ?></p>
        <?php } ?>
        <?php
        wp_nonce_field('bpgmq_featured_save_' . $item->id, 'bpgmq_featured_admin');
    }
    function admin_ui_save_featured($group_id = 0) {
        if ('POST' !== strtoupper($_SERVER['REQUEST_METHOD']) || empty($group_id))
            return false;
        check_admin_referer('bpgmq_featured_save_' . $group_id, 'bpgmq_featured_admin');
        groups_update_groupmeta($group_id, '_bd_temp_cat', serialize($_POST['bd_temp_cat']));
    }
}

function bpgmq_feature_group() {
    if (bp_is_active('groups'))
        return new BPGMQ_Feature_Group();
}

add_action('bp_init', 'bpgmq_feature_group');

// End of Code

?>
