<?php
	/**
	This will be implemented in version 2 of the plugin
	*/
	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	require('../../../wp-blog-header.php');

	global $wpdb;

	if(isset($_GET['mode']) && isset($_GET['id'])) {
		$mode = $_GET['mode'];
		$id = mysqli_real_escape_string($_GET['id']);
		switch($mode) {
			case "update":
				if(isset($_GET['quote'])) {
					// $quote = $wpdb->_escape_string($_GET['quote']);
					$return = "updated: " . $id;
				} else {
					$return = "noquote";
				}
				break;
			case "delete":
				$return = "deleted: " . $id;
				break;
		}

		echo $return;
	}
?>
