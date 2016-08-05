<?php
/*
Enfold functions overrides
*/
// echo "<pre>"; print_r (get_template_directory_uri()); die("</pre>");
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
        //and this is to add new sub menu.
        // $wp_admin_bar->add_menu( array(
        //                 'parent' => 'wp-logo',
        //                 'id'     => 'sub-menu-id-1',
        //                 'title'  => __('Sub Menu 1'),
        //                 'href'  => __('url-for-link-in-sub-menu-1'),
        //         ) );


}
add_action('wp_before_admin_bar_render', 'rebranding_wordpress_logo' );

/** Rebranding and whitelabel the EnviraGallery
    as per http://enviragallery.com/docs/whitelabel-envira/ **/

add_filter( 'gettext', 'tgm_envira_whitelabel', 10, 3 );

if (!function_exists('tgm_envira_whitelabel')) {
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
}
add_action( 'admin_init', 'tgm_envira_remove_header' );
function tgm_envira_remove_header() {

    // Remove the Envira banner
    remove_action( 'in_admin_header', array( Envira_Gallery_Posttype_Admin::get_instance(), 'admin_header' ), 100 );

}
