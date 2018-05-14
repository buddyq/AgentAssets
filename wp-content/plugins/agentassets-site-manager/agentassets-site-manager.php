<?php
/**
 * Plugin Name: Agentassets Master Plugin
 * Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
 * Description: This plugin allows for most major functions needed for AgentAssets.com
 * Version: 1.0.0
 * Author: Agentassets
 * Author URI: http://agentassets.com
 * Text Domain: mism
 * Network: true
 * License: GPL2
 */

 function __construct() 
{
  
  add_filter( 'wp_new_user_notification_email', 'new_user_notification_email', 10, 3 );
 
}

add_image_size( 'contact-picture', 600, 450, array( 'center', 'top' ) );
add_filter( 'image_size_names_choose', 'my_custom_sizes' );
 
function my_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'contact-picture' => __( 'Contact Picture' ),
    ) );
}
/* Add Error Logging */
if ( ! function_exists('write_log')) {
   function write_log ( $log )  {
      if ( is_array( $log ) || is_object( $log ) ) {
         error_log( print_r( $log, true ) );
      } else {
         error_log( $log );
      }
   }
}

$user_id = get_current_user_id();


# Files Added
include 'XML-API/xmlapi.php';

// require_once 'includes/medmahelper.class.php';
// require_once 'includes/ordermap.class.php';
// require_once 'includes/ordermodel.class.php';
require_once 'includes/packagecounter.class.php';
require_once 'includes/medmagroupmodel.class.php';
require_once 'includes/medmathememanager.class.php';

// require_once 'includes/post-types.php';

// require_once 'includes/metaboxes.php';

// require_once 'includes/medmaclonefactory.php';

// require_once 'includes/shortcodes/create_new_site.php';
// require_once 'includes/shortcodes/my_purchases.php';
// require_once 'includes/shortcodes/list_sites.php';
// require_once 'includes/shortcodes/list_packages.php';
// require_once 'includes/shortcodes/package_status.php';
// require_once 'includes/shortcodes/medma_groups_info.php';
// require_once 'includes/shortcodes/medma_groups_admin.php';
// require_once 'includes/shortcodes/medma_group_assign_code.php';

// require_once 'includes/settings/package-settings.php';
require_once 'includes/settings/medma-manager-admin.php';

require_once 'includes/ajax_action_callbacks.php';

require_once 'includes/actions.php';
require_once 'includes/filters.php';

// Added by Buddy Quaid
require_once 'includes/aa-add_parked_domain.php';
require_once 'includes/aa-admin-screen-cleanup.php';
require_once 'includes/aa-agentassets-class.php';
require_once 'includes/aa-buddypress-slug-changes.php';
require_once 'includes/aa-customizer-options.php';
require_once 'includes/aa-delete-site-actions.php';
require_once 'includes/aa-do_after_site_created.php';
require_once 'includes/aa-do_after_user_signup.php';
require_once 'includes/aa-envira_whitelabel.php';
// require_once 'includes/aa-new_site_add_expiration_date.php';
require_once 'includes/aa-save_pmprolevel_expiry_to_levelmeta.php';
require_once 'includes/aa-redirect-non-existing-subdomains.php';
require_once 'includes/aa-show-groupcodes-admin.php';
require_once 'includes/aa-add-sites_owner_column_toadmin.php';
require_once 'includes/aa-login-logout-redirects.php';
// require_once 'includes/aa-force-http-on-subdomains.php';
require_once 'includes/aa-customized-emails.php';
require_once ABSPATH . 'wp-content/plugins/blogtemplates/blogtemplatesfiles/tables/templates_table.php';

function doctype_opengraph($output) {
    return $output . '
    xmlns:og="http://opengraphprotocol.org/schema/"
    xmlns:fb="http://www.facebook.com/2008/fbml"';
}
add_filter('language_attributes', 'doctype_opengraph');

// add_filter('wp_loaded','send_mail_now');
add_action('groups_created_group', 'AgentAssets::add_code_to_new_group');
add_action('wp_ajax_toggle_livesite', 'AgentAssets::ajax_toggle_livesite');


/*
 * Load Stylesheet to Header
 */
function add_style_to_head()
{
    wp_enqueue_style('medma-site-manager-general', plugins_url('agentassets-site-manager').'/css/general.css','','1.0');
    wp_enqueue_style('medma-site-manager-alertify', plugins_url('agentassets-site-manager').'/css/alertify.min.css','','1.7.1');
    wp_enqueue_style('medma-site-manager-alertify-theme', plugins_url('agentassets-site-manager').'/css/alertify-medma-theme.css','','1.7.1');
    wp_enqueue_script('medma-site-manager-alertify', plugins_url('agentassets-site-manager').'/js/alertify.min.js','','1.7.1');
}

add_action('wp_head','add_style_to_head');



function unique_identifyer_admin_notices() {
     settings_errors( 'unique_identifyer' );
}
add_action( 'admin_notices', 'unique_identifyer_admin_notices' );


function getExternalDomainByBlogId($id)
{
    global $wpdb;
    $sql = "SELECT domain FROM `{$wpdb->base_prefix}domain_mapping` WHERE blog_id='".$id."'";
    $results = $wpdb->get_results($sql,OBJECT);
    return $results[0]->domain;
}

function getNextRemovingSitesTime($format = 'H:i') {
    $ret = array(
        'timestamp' => 0,
        'string' => '',
        'hours_left' => 0,
    );
    $hours_delta = 1;

    $s_next_day = date('Y-m-d', strtotime('+1 day')).' 00:00:00';
    $d_next_day = DateTime::createFromFormat('Y-m-d H:i:s', $s_next_day);
    $t_next_day = $d_next_day->getTimestamp();

    $ret['timestamp'] = $t_next_day + ($hours_delta * 3600);
    $ret['string'] = date($format, $ret['timestamp']);
    $ret['hours_left'] = (int)(((float)($ret['timestamp'] - time())) / 3600);

    return $ret;
}