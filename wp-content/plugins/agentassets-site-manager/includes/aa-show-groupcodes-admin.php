<?php 
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Codes_List extends WP_List_Table {

	/** Class constructor */
	public function __construct() {

		parent::__construct( [
			'singular' => __( 'Code', 'sp' ), //singular name of the listed records
			'plural'   => __( 'Codes', 'sp' ), //plural name of the listed records
			'ajax'     => false //should this table support ajax?

		] );

	}
    
     /**
     * Retrieve customer’s data from the database
     *
     * @param int $per_page
     * @param int $page_number
     *
     * @return mixed
     */
     public static function get_codes() {

      global $wpdb;
      
      $sql  = "SELECT meta.meta_value, groups.name FROM {$wpdb->prefix}bp_groups_groupmeta AS meta ";
      $sql .= "INNER JOIN {$wpdb->prefix}bp_groups AS groups ON groups.id = meta.group_id WHERE meta.meta_key = 'group_code' ";

      $result = $wpdb->get_results( $sql, 'ARRAY_A' );
      return $result;
      }
}


add_action('network_admin_menu', 'add_custom_menu_to_admin', 11);

function add_custom_menu_to_admin() {
	add_submenu_page( 'settings.php', 'AA Site Manager', 'AA cPanel Settings', 'manage_options', 'medma-site-manager-options-page', 'aa_site_manager_options_callback' );
    
    add_submenu_page('bp-groups', 'Group Codes', 'Group Codes', 'manage_options', 'group-codes', 'show_groupcode_page');    
}

function show_groupcode_page() {
    
    echo "<h1>Group Codes List</h1>";
    $data = Codes_List::get_codes();
    echo "<table class='striped' width='50%'>";
    foreach ($data as $key => $value) {
        echo "<tr>";
        echo "<td style='padding:10px;' width='50%'>".$data[$key]['name']."</td>";
        echo "<td style='padding:10px' width='50%'>".$data[$key]['meta_value']."</td>";
        echo "</tr>";
    }
    echo "</table>";

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
    $html .= '<h1>AgentAssets cPanel Settings</h1>';

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

    $html .= '<p><input type="submit" name="save_settings" class="button button-primary" value="Save Settings"/></p>';
    $html .= '</form>';
    $html .= '</tbody></table>';
    $html .= '</div>';

    echo $html;
}