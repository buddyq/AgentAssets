<?php

/*
 * Ajax Action | Delete Site
 */

add_action( 'wp_ajax_delete_site', 'delete_site_callback' );
function delete_site_callback() {
	global $wpdb; // this is how you get access to the database

	$blog_id = intval( $_POST['blog_id'] );

	update_blog_status($blog_id, 'deleted', 1, true);

	wp_die(); // this is required to terminate immediately and return a proper response
}