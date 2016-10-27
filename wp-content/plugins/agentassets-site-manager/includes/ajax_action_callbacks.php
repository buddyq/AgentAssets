<?php

/*
 * Ajax Action | Delete Site
 */

add_action( 'wp_ajax_delete_site', 'delete_site_callback' );
add_action( 'wp_ajax_extend_site', 'extend_site_callback' );
add_action( 'wp_ajax_restore_site', 'restore_site_callback' );
add_action( 'wp_ajax_check_sites_for_removing', 'check_sites_for_removing');
add_action( 'wp_ajax_restore_with_purchase', 'restore_with_purchase');
add_action( 'wp_ajax_nopriv_restore_with_purchase', 'restore_with_purchase');

function restore_with_purchase(){
	$status = array('result' => 'error', 'message' => '');
	while (true){
		if (!isset($_POST['extend_blog_id'])) {
			$status['message'] = 'Invalid request';
			break;
		}
		$blog_id = $_POST['extend_blog_id'];
		$user_id = $_POST['user_id'];
		if ( add_user_meta($user_id, 'site_expired', $_POST['site_expired'], 1 )) {
			// $_SESSION['site_expired'] = "updated database with value: " . $_POST['site_expired'];
			// $status['message'] .= "site_expired added to DB.<br>";
		}
		if ( add_user_meta($user_id, 'extend_blog_id', $_POST['extend_blog_id'], 1 )) {
			// $_SESSION['extend_blog_id'] = "updated database with value: " . $_POST['extend_blog_id'];
			// $status['message'] .= "extend_blog_id added to DB.<br>";
		}
		$status['result'] = 'success';
		$status['message'] .= 'Site info saved. Let\'s go!';
		break;
	}
	echo json_encode($status);
	wp_die(); // this is required to terminate immediately and return a proper response
}

function delete_site_callback() {
	$status = array('result' => 'error', 'message' => '');
	while (true) {
		if (!isset($_POST['blog_id'])) {
			$status['message'] = 'Invalid request';
			break;
		}
		$blog_id = $_POST['blog_id'];
		$user_id = get_current_user_id();
		if (0 === $user_id) {
			$status['message'] = 'Access denied';
			break;
		}
		$user_blog_ids = OrderMap::getUserBlogIds($user_id);
		if (!in_array($blog_id, $user_blog_ids)) {
			$status['message'] = 'Access denied';
			break;
		}
		if (false === update_blog_status($blog_id, 'deleted', 1, true)) {
			$status['message'] = 'Unknown error';
			break;
		}
		$status['result'] = 'success';
		break;
	}
	echo json_encode($status);
	wp_die(); // this is required to terminate immediately and return a proper response
}

function extend_site_callback() {
	$status = array('result' => 'error', 'message' => '');
	while (true) {
		if (!isset($_POST['blog_id'])) {
			$status['message'] = 'Invalid request';
			break;
		}
		$blog_id = $_POST['blog_id'];
		$user_id = get_current_user_id();
		if (0 === $user_id) {
			$status['message'] = 'Access denied';
			break;
		}
		$user_blog_ids = OrderMap::getUserBlogIds($user_id);
		if (!in_array($blog_id, $user_blog_ids)) {
			$status['message'] = 'Access denied';
			break;
		}
		if (false === OrderMap::extendSite($blog_id)) {
			$status['message'] = 'Unknown error';
			break;
		}
		$status['result'] = 'success';
		break;
	}
	echo json_encode($status);
	wp_die(); // this is required to terminate immediately and return a proper response
}

function restore_site_callback() {
	$status = array('result' => 'error', 'message' => '');
	while (true) {
		if (!isset($_POST['blog_id'])) {
			$status['message'] = 'Invalid request';
			break;
		}
		$blog_id = $_POST['blog_id'];
		$user_id = get_current_user_id();
		if (0 === $user_id) {
			$status['message'] = 'Access denied';
			break;
		}
		$user_blog_ids = OrderMap::getUserBlogIds($user_id);
		if (!in_array($blog_id, $user_blog_ids)) {
			$status['message'] = 'Access denied';
			break;
		}
		if (false === update_blog_status($blog_id, 'deleted', 0, true)) {
			$status['message'] = 'Unknown error';
			break;
		}
		$status['result'] = 'success';
		break;
	}
	echo json_encode($status);
	wp_die(); // this is required to terminate immediately and return a proper response
}

function check_sites_for_removing() {
	$blogs = OrderMap::getAllBlogsDetails();
	foreach($blogs as $blog) {
		//step 1 - look for all expired blogs and de-activate them and run this function with cron job
		if ($blog->days_left == 0) {
			echo "<pre>";print_r($blog);"</pre>";
			// update_blog_status( $blog->userblog_id, 'archived', 1);
			wpmu_delete_blog( $blog->userblog_id, false );
		}
	}
}
