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

require_once 'includes/post-types.php';

require_once 'includes/metaboxes.php';

require_once 'includes/shortcodes/create_new_site.php';
require_once 'includes/shortcodes/list_sites.php';
require_once 'includes/shortcodes/list_packages.php';
require_once 'includes/shortcodes/package_status.php';

require_once 'includes/settings/package-settings.php';

require_once 'includes/ajax_action_callbacks.php';

require_once 'includes/actions.php';

/*
 * Load Stylesheet to Header
 */
function add_style_to_head()
{
    wp_enqueue_style('medma-site-manager-general', plugins_url('medma-site-manager').'/css/general.css','','1.0');
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
                var data = {
                        'action': 'delete_site',
                        'blog_id': jQuery(this).attr('data-id')
                };
                // We can also pass the url value separately from ajaxurl for front end AJAX implementations
                jQuery.post('<?php echo admin_url( 'admin-ajax.php' )?>', data, function(response) {
                        alert('Site deleted successfully!');
                        location.reload();
                });
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
