<?php

$aveone_themename = "aveone";

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

?>