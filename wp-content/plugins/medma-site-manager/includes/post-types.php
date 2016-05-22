<?php
#   Administrator Privilege Authentication
if(is_admin())
{
    //add_action( 'init', 'mism_add_post_types_init' );
}
/**
 * Register new post types.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function mism_add_post_types_init() {
    
        # Post-type | Package
    
	$labels_package = array(
		'name'               => _x( 'Packages', 'packages', 'mism' ),
		'singular_name'      => _x( 'Package', 'package', 'mism' ),
		'menu_name'          => _x( 'Packages', 'admin-packages', 'mism' ),
		'name_admin_bar'     => _x( 'Packages', 'admin-bar-packages', 'mism' ),
		'add_new'            => _x( 'Add New', 'package', 'mism' ),
		'add_new_item'       => __( 'Add New Package', 'mism' ),
		'new_item'           => __( 'New Package', 'mism' ),
		'edit_item'          => __( 'Edit Package', 'mism' ),
		'view_item'          => __( 'View Package', 'mism' ),
		'all_items'          => __( 'All Packages', 'mism' ),
		'search_items'       => __( 'Search Packages', 'mism' ),
		'parent_item_colon'  => __( 'Parent Packages:', 'mism' ),
		'not_found'          => __( 'No packages found.', 'mism' ),
		'not_found_in_trash' => __( 'No packages found in Trash.', 'mism' )
	);

	$args_package = array(
		'labels'             => $labels_package,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'package' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title' )
	);

	register_post_type( 'package', $args_package );
        
        # Post-type | Coupons
        
        $labels_coupons = array(
		'name'               => _x( 'Coupons', 'coupons', 'mism' ),
		'singular_name'      => _x( 'Coupon', 'coupon', 'mism' ),
		'menu_name'          => _x( 'Coupons', 'admin-coupons', 'mism' ),
		'name_admin_bar'     => _x( 'Coupons', 'admin-bar-coupons', 'mism' ),
		'add_new'            => _x( 'Add New', 'coupon', 'mism' ),
		'add_new_item'       => __( 'Add New Coupon', 'mism' ),
		'new_item'           => __( 'New Coupon', 'mism' ),
		'edit_item'          => __( 'Edit Coupon', 'mism' ),
		'view_item'          => __( 'View Coupon', 'mism' ),
		'all_items'          => __( 'All Coupons', 'mism' ),
		'search_items'       => __( 'Search Coupons', 'mism' ),
		'parent_item_colon'  => __( 'Parent Coupons:', 'mism' ),
		'not_found'          => __( 'No Coupons found.', 'mism' ),
		'not_found_in_trash' => __( 'No Coupons found in Trash.', 'mism' )
	);

	$args_coupons = array(
		'labels'             => $labels_coupons,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'coupon' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title' )
	);

	register_post_type( 'coupon', $args_coupons );
}


