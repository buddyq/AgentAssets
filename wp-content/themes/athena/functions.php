<?php


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