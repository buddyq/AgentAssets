<?php

$aveone_themename = "aveone";

add_filter( 'jpeg_quality', create_function( '', 'return 100;' ) );

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

if (get_stylesheet_directory() == get_template_directory()) {
    define('AVEONE_URL', get_template_directory() . '/library/functions/');
    define('AVEONE_DIRECTORY', get_template_directory_uri() . '/library/functions/');
} else {
    define('AVEONE_URL', get_template_directory() . '/library/functions/');
    define('AVEONE_DIRECTORY', get_template_directory_uri() . '/library/functions/');
}

get_template_part('library/functions/options-framework');
get_template_part('library/functions/basic-functions');
get_template_part('library/functions/options');

/* Gallery Post type */

add_action( 'init', 'gallery_init' );
/**
 * Register a gallery post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function gallery_init() {
	$labels = array(
		'name'               => _x( 'Gallery', 'gallery', 'supersized' ),
		'singular_name'      => _x( 'Gallery', 'gallery', 'supersized' ),
		'menu_name'          => _x( 'Gallery', 'gallery', 'supersized' ),
		'name_admin_bar'     => _x( 'Gallery', 'gallery', 'supersized' ),
		'add_new'            => _x( 'Add New', 'gallery', 'supersized' ),
		'add_new_item'       => __( 'Add New Gallery', 'supersized' ),
		'new_item'           => __( 'New Gallery', 'supersized' ),
		'edit_item'          => __( 'Edit Gallery', 'supersized' ),
		'view_item'          => __( 'View Gallery', 'supersized' ),
		'all_items'          => __( 'All Gallery', 'supersized' ),
		'search_items'       => __( 'Search Gallery', 'supersized' ),
		'parent_item_colon'  => __( 'Parent Gallery:', 'supersized' ),
		'not_found'          => __( 'No gallery found.', 'supersized' ),
		'not_found_in_trash' => __( 'No gallery found in Trash.', 'supersized' )
	);

	$args = array(
		'labels'             => $labels,
    'description'        => __( 'Description.', 'supersized' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'gallery' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'thumbnail' )
	);

	register_post_type( 'gallery', $args );
}

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

add_action( 'admin_init', 'tgm_envira_remove_header' );
function tgm_envira_remove_header() {

    // Remove the Envira banner
    remove_action( 'in_admin_header', array( Envira_Gallery_Posttype_Admin::get_instance(), 'admin_header' ), 100 );

}
?>
