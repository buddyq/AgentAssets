<?php
/**
 * Plugin Name: Agentassets Multisite Site Manager
 * Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
 * Description: A plugin designed to handle numbers of sites of a user
 * Version: 1.0.0
 * Author: Agentassets
 * Author URI: http://agentassets.com
 * Text Domain: mism
 * Network: true
 * License: GPL2
 */

# Files Added
include 'XML-API/xmlapi.php';

require_once 'includes/medmahelper.class.php';
require_once 'includes/ordermap.class.php';
require_once 'includes/ordermodel.class.php';
require_once 'includes/packagecounter.class.php';
require_once 'includes/medmagroupmodel.class.php';
require_once 'includes/medmathememanager.class.php';

require_once 'includes/post-types.php';

require_once 'includes/metaboxes.php';

require_once 'includes/medmaclonefactory.php';

require_once 'includes/shortcodes/create_new_site.php';
require_once 'includes/shortcodes/my_purchases.php';
require_once 'includes/shortcodes/list_sites.php';
require_once 'includes/shortcodes/list_packages.php';
require_once 'includes/shortcodes/package_status.php';
require_once 'includes/shortcodes/medma_groups_info.php';
require_once 'includes/shortcodes/medma_groups_admin.php';
require_once 'includes/shortcodes/medma_group_assign_code.php';

require_once 'includes/settings/package-settings.php';
require_once 'includes/settings/medma-manager-admin.php';

require_once 'includes/ajax_action_callbacks.php';

require_once 'includes/actions.php';
require_once 'includes/filters.php';

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

/*
 * Load Scripts at Footer
 */
function add_scripts_to_footer()
{
  $sites_remaining = PackageCounter::getRemainingSites();
  $user_id = get_current_user_id();
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            jQuery('.listblog_delete').click(function(){
                var msg = 'You are going to remove the <strong>%s</strong> site. You can restore it during 24 hours after deletion. Otherwise it will be deleted completely.';
                msg = msg.replace('%s', jQuery(this).attr('data-site-name'));
                var el = this;
                alertify.confirm(msg, function() {
                    var data = {
                        'action': 'delete_site',
                        'blog_id': jQuery(el).attr('data-id')
                    };
                    alertify.message('Processing request');
                    // We can also pass the url value separately from ajaxurl for front end AJAX implementations
                    jQuery.post('<?php echo admin_url( 'admin-ajax.php' )?>', data, function (response) {
                        if (typeof(response.result) === 'undefined') {
                            alertify.error('Bad response!');
                        } else if ('error' == response.result) {
                            alertify.error(response.message);
                        } else {
                            alertify.success('Site deleted successfully!');
                            location.reload();
                        }
                    }, 'json');
                }).set('title', 'Deleting site');
            });

            jQuery('.listblog_extend').click(function(){
                var msg = '<strong>%s</strong> will be renewed for <strong>%d</strong> using one of your remaining site credits.';
                msg = msg.replace('%s', jQuery(this).attr('data-site-name')).replace('%d', jQuery(this).attr('data-duration'));
                var el = this;
                alertify.confirm(msg, function() {
                    var data = {
                        'action' : 'extend_site',
                        'blog_id': jQuery(el).attr('data-id')
                    };
                    alertify.message('Processing request');
                    jQuery.post('<?php echo admin_url('admin-ajax.php')?>', data, function( response) {
                        if (typeof(response.result) === 'undefined') {
                            alertify.error('Bad response!');
                        } else if ('error' == response.result) {
                            alertify.error(response.message);
                        } else {
                            alertify.success('Site extended successfully!');
                            location.reload();
                        }
                    }, 'json');
                }).set('title', 'Extending site');
            });

            jQuery('.listblog_pricing').click(function(){
                var msg = 'Sorry, you have no spare sites left. Please <a href="/pricing">obtain a new site package</a> to extend your site\'s <strong>%s</strong> validity.';
                msg = msg.replace('%s', jQuery(this).attr('data-site-name')).replace('%d', jQuery(this).attr('data-duration'));

                alertify.alert(msg).set('title', 'Information');
            });

            // Restore expired site using a site credit (payment)
            jQuery('.restore_with_purchase').click(function(){
              var msg = 'You\'re out of sites! We\'ll restore <strong>%s</strong> site as soon as you buy a new package. Clicking OK will take you to the packages.';
              msg = msg.replace('%s', jQuery(this).attr('data-site-name'));
              var el = this;
              alertify.confirm(msg, function() {
                var data = {
                    'action' : 'restore_with_purchase', 
                    'extend_blog_id': jQuery(el).attr('data-id'),
                    'site_expired' : true,
                    'user_id' : <?php echo $user_id; ?>,
                    'buy_package' : 'buy'
                };
                alertify.message('Saving some info...');
                jQuery.post('<?php echo admin_url('admin-ajax.php')?>', data, function( response ) {
                    if (typeof(response.result) === 'undefined') {
                        alertify.error('Bad response!');
                    } else if ('error' == response.result) {
                        alertify.error(response.message);
                    } else {
                        alertify.success(response.message);
                        // location.reload();
                        location.replace("/pricing");
                    }
                }, 'json');
              }).set('title', 'Purchase needed to restore this site');
            });

            // Restore a site the user deactivated but is not expired
            jQuery('.listblog_restore').click(function(){
                var data = {
                    'action' : 'restore_site',
                    'blog_id': jQuery(this).attr('data-id')
                };
                alertify.message('Processing request');
                jQuery.post('<?php echo admin_url('admin-ajax.php')?>', data, function( response) {
                    if (typeof(response.result) === 'undefined') {
                        alertify.error('Bad response!');
                    } else if ('error' == response.result) {
                        alertify.error(response.message);
                    } else {
                        alertify.success('Site restored successfully!');
                        location.reload();
                    }
                }, 'json');
            });

            jQuery('.listblog_pricing').click(function() {
                //todo normal message
                var msg = 'SOME PRICE MSG <strong>%s</strong> ___';
                msg = msg.replace('%s', jQuery(this).attr('data-site-name'));
                alertify.alert(msg);
            });

        });
    </script>
    <?php
}
add_action('wp_footer','add_scripts_to_footer');


function add_blogOwner()
{
  $user_id = get_current_user_id();
  add_site_option( 'blog_owner', $user_id );
}

add_action( 'wpmu_new_blog', 'add_blogOwner' );
add_action('network_admin_menu', 'add_custom_menu_to_admin');

function add_custom_menu_to_admin() {
	add_submenu_page( 'settings.php', 'AA Site Manager', 'AA Site Manager', 'manage_options', 'medma-site-manager-options-page', 'aa_site_manager_options_callback' );
}

function aa_site_manager_options_callback() {

    // Check that the user is allowed to update options
    if (!current_user_can('manage_options')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }



    if(isset($_POST['save_settings']) && $_POST['save_settings']!="")
    {
        update_option('msm_edit_return_url',$_POST['edit_return_url']);
        update_option('msm_main_site_domain',$_POST['main_site_domain']);
        update_option('msm_main_site_ip',$_POST['main_site_ip']);
        update_option('msm_main_site_output_type',$_POST['main_site_output_type']);
        update_option('msm_main_site_port',$_POST['main_site_port']);
        update_option('msm_main_site_account',$_POST['main_site_account']);
        update_option('msm_main_site_cpanel_username',$_POST['main_site_cpanel_username']);
        update_option('msm_main_site_cpanel_password',$_POST['main_site_cpanel_password']);

    }

    $edit_return_url = get_option('msm_edit_return_url');
    if(empty($edit_return_url))
    {
        $edit_return_url = "";
    }

    $main_site_domain = get_option('msm_main_site_domain');
    if(empty($main_site_domain))
    {
        $main_site_domain = "";
    }

    $main_site_ip = get_option('msm_main_site_ip');
    if(empty($main_site_ip))
    {
        $main_site_ip = "";
    }

    $main_site_port = get_option('msm_main_site_port');
    if(empty($main_site_port))
    {
        $main_site_port = "";
    }

    $main_site_output_type = get_option('msm_main_site_output_type');
    if(empty($main_site_output_type))
    {
        $main_site_output_type = "";
    }

    $main_site_account = get_option('msm_main_site_account');
    if(empty($main_site_account))
    {
        $main_site_account = "";
    }

    $main_site_cpanel_username = get_option('msm_main_site_cpanel_username');
    if(empty($main_site_cpanel_username))
    {
        $main_site_cpanel_username = "";
    }

    $main_site_cpanel_password = get_option('msm_main_site_cpanel_password');
    if(empty($main_site_cpanel_password))
    {
        $main_site_cpanel_password = "";
    }

    //add_settings_field( 'return-url-id', 'Return URL', 'return_url_callback_function', '', '' , array( 'label_for' => 'myprefix_setting-id' ) );
    //settings_fields( 'my-plugin-settings-group' );

    $html = '';
    $html .= '<div class="wrap">';
    $html .= '<div id="icon-tools" class="icon32"></div>';
    $html .= '<h1>AgentAssets Manager Settings</h1>';

    $html .= '<table class="form-table"><tbody>';
    $html .= '<form method="POST" action="settings.php?page=medma-site-manager-options-page">';

    $html .= '<tr>';
    $html .= '<th scope="row>"<label for="edit_return_url">Edit Return URL</label></th>';
    $html .= '<td><input class="regular-text" type="text" name="edit_return_url" value="'.$edit_return_url.'"/></td>';
    $html .= '</tr>';

    $html .= '<tr>';
    $html .= '<th scope="row"><label>Main Site Domain</label></th>';
    $html .= '<td><input class="regular-text" type="text" name="main_site_domain" value="'.$main_site_domain.'"/></td>';
    $html .= '</tr>';

    $html .= '<tr>';
    $html .= '<th scope="row"><label>Site IP Address</label></th>';
    $html .= '<td><input class="regular-text" type="text" name="main_site_ip" value="'.$main_site_ip.'"/></td>';
    $html .= '</tr>';

    $html .= '<tr>';
    $html .= '<th scope="row"><label>Port</label></th>';
    $html .= '<td><input class="regular-text" type="text" name="main_site_port" value="'.$main_site_port.'"/></td>';
    $html .= '</tr>';

    $html .= '<tr>';
    $html .= '<th scope="row"><label>Output Method Type</label></th>';
    $html .= '<td><input class="regular-text" type="text" name="main_site_output_type" value="'.$main_site_output_type.'"/></td>';
    $html .= '</tr>';

    $html .= '<tr>';
    $html .= '<th scope="row"><label>Account</label></th>';
    $html .= '<td><input class="regular-text" type="text" name="main_site_account" value="'.$main_site_account.'"/></td>';
    $html .= '</tr>';

    $html .= '<tr>';
    $html .= '<th scope="row"><label>cPanel Username</label></th>';
    $html .= '<td><input class="regular-text" type="text" name="main_site_cpanel_username" value="'.$main_site_cpanel_username.'"/></td>';
    $html .= '</tr>';

    $html .= '<tr>';
    $html .= '<th scope="row"><label>cPanel Password</label></th>';
    $html .= '<td><input class="regular-text" type="password" name="main_site_cpanel_password" value="'.$main_site_cpanel_password.'"/></td>';
    $html .= '</tr>';

    // $html .= '<tr>';
    // $html .= '</tr>';

    $html .= '</form>';
    $html .= '</tbody></table>';
    $html .= '<p><input type="submit" name="save_settings" class="button button-primary" value="Save Settings"/></p>';
    $html .= '</div>';

    echo $html;
}

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
