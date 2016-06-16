<?php
/**
 * Plugin Name: Medma Multisite Site Manager
 * Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
 * Description: A plugin designed to handle numbers of sites of a user
 * Version: 1.0.0
 * Author: Medma Infomatix
 * Author URI: http://www.medma.net
 * Text Domain: mism
 * Network: true
 * License: GPL2
 */

# Files Added
include 'XML-API/xmlapi.php';

require_once 'includes/ordermap.class.php';
require_once 'includes/ordermodel.class.php';
require_once 'includes/packagecounter.class.php';

require_once 'includes/post-types.php';

require_once 'includes/metaboxes.php';

require_once 'includes/shortcodes/create_new_site.php';
require_once 'includes/shortcodes/list_sites.php';
require_once 'includes/shortcodes/list_packages.php';
require_once 'includes/shortcodes/package_status.php';

require_once 'includes/settings/package-settings.php';

require_once 'includes/ajax_action_callbacks.php';

require_once 'includes/actions.php';
require_once 'includes/filters.php';

/*
 * Load Stylesheet to Header
 */
function add_style_to_head()
{
    wp_enqueue_style('medma-site-manager-general', plugins_url('medma-site-manager').'/css/general.css','','1.0');
    wp_enqueue_style('medma-site-manager-alertify', plugins_url('medma-site-manager').'/css/alertify.min.css','','1.7.1');
    wp_enqueue_style('medma-site-manager-alertify-theme', plugins_url('medma-site-manager').'/css/alertify-medma-theme.css','','1.7.1');
    wp_enqueue_script('medma-site-manager-alertify', plugins_url('medma-site-manager').'/js/alertify.min.js','','1.7.1');
}

add_action('wp_head','add_style_to_head');
    
/*
 * Load Scripts at Footer
 */
function add_scripts_to_footer()
{
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            jQuery('.listblog_delete').click(function(){
                var msg = 'You are going to remove the <strong>%s</strong> site. You can restore it during 24 hours since deletion. Otherwise it will be deleted completely.';
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

add_action('network_admin_menu', 'add_custom_menu_to_admin');

function add_custom_menu_to_admin() {
	add_submenu_page( 'settings.php', 'Medma Site Manager', 'Medma Site Manager', 'manage_options', 'medma-site-manager-options-page', 'medma_site_manager_options_callback' );
}

function medma_site_manager_options_callback() {
	
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
    $html .= '<h2>Medma Site Manager Settings</h2>';

    $html .= '<div class="container">';
    $html .= '<form method="POST" action="settings.php?page=medma-site-manager-options-page">';

    $html .= '<div class="form-field">';
    $html .= '<label>Edit Return URL</label>';
    $html .= '<input type="text" name="edit_return_url" value="'.$edit_return_url.'"/>';
    $html .= '</div>';
    
    $html .= '<div class="form-field">';
    $html .= '<label>Main Site Domain</label>';
    $html .= '<input type="text" name="main_site_domain" value="'.$main_site_domain.'"/>';
    $html .= '</div>';
    
    $html .= '<div class="form-field">';
    $html .= '<label>Site IP Address</label>';
    $html .= '<input type="text" name="main_site_ip" value="'.$main_site_ip.'"/>';
    $html .= '</div>';
    
    $html .= '<div class="form-field">';
    $html .= '<label>Port</label>';
    $html .= '<input type="text" name="main_site_port" value="'.$main_site_port.'"/>';
    $html .= '</div>';
    
    $html .= '<div class="form-field">';
    $html .= '<label>Output Method Type</label>';
    $html .= '<input type="text" name="main_site_output_type" value="'.$main_site_output_type.'"/>';
    $html .= '</div>';
    
    $html .= '<div class="form-field">';
    $html .= '<label>Account</label>';
    $html .= '<input type="text" name="main_site_account" value="'.$main_site_account.'"/>';
    $html .= '</div>';
    
    $html .= '<div class="form-field">';
    $html .= '<label>cPanel Username</label>';
    $html .= '<input type="text" name="main_site_cpanel_username" value="'.$main_site_cpanel_username.'"/>';
    $html .= '</div>';
    
    $html .= '<div class="form-field">';
    $html .= '<label>cPanel Password</label>';
    $html .= '<input type="password" name="main_site_cpanel_password" value="'.$main_site_cpanel_password.'"/>';
    $html .= '</div>';

    $html .= '<div class="form-field">';
    $html .= '<input type="submit" name="save_settings" class="button button-primary" value="Save Settings"/>';
    $html .= '</div>';

    $html .= '</form>';
    $html .= '</div>';

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