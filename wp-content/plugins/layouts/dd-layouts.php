<?php
/*
Plugin Name: Toolset Layouts
Plugin URI: http://wp-types.com/
Description: Design entire WordPress sites using a drag-and-drop interface. Layouts 1.6 <a href="https://wp-types.com/documentation/user-guides/#layouts">release notes</a>
Author: OnTheGoSystems
Author URI: http://www.onthegosystems.com
Version: 1.6
*/

/**
 * WPDDL_DEVELOPMENT -> default development, loads production files and leave embedded files alone
 *
 * WPDDL_EMBEDDED -> loads embedded files.
 *
 * WPDDL_PRODUCTION -> loads production files (not to be set manually)
 */
define('WPDDL_PRODUCTION', 'Layouts');

if (
    file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes/wpddl.admin-embedded.class.php') &&
    defined('WPDDL_EMBEDDED') &&
    (defined('WPDDL_DEVELOPMENT') === false && defined('WPDDL_PRODUCTION') === false)
) {

    define('WPDDL_EMBEDDED_PATH', plugin_basename(__FILE__));
    define('WPDDL_EMBEDDED_ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);

    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'ddl-embedded-loader.php';

} else if (
    file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes/wpddl.admin-plugin.class.php') &&
    (defined('WPDDL_DEVELOPMENT') || defined('WPDDL_PRODUCTION')) &&
    !function_exists('ddl_layouts_plugin_loader')
) {
    add_action('plugins_loaded', 'ddl_layouts_plugin_loader', 2);

    function ddl_layouts_plugin_loader()
    {
        if (!defined('WPDDL_IN_THEME_MODE')) { // This check is only needed when the plugin is being activated while the bootstrap theme is in use.
            require_once dirname(__FILE__) . '/ddl-loader.php';
        }
    }
}

if( !function_exists('wpddl_layout_deactivate_plugin') ){
    function wpddl_layout_deactivate_plugin(){
        global $current_user ;
        $user_id = $current_user->ID;
        delete_user_meta( $user_id, WPDDL_Messages::$release_option_name );
    }
    register_deactivation_hook( __FILE__, 'wpddl_layout_deactivate_plugin' );
}

if( !function_exists('ddl_cred_user_cell_disable_if_not_version') ){
  //  add_action('init', 'ddl_cred_user_cell_disable_if_not_version', 7);
    function ddl_cred_user_cell_disable_if_not_version(){
        $version = defined('CRED_FE_VERSION') ? (float) CRED_FE_VERSION : 0;
        if( $version < 1.4){
            remove_ddl_support('cred-user-cell');
        }
    }
}

