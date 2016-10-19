<?php
	/*
	Plugin Name: Random Quotes
	Plugin URI: http://wordpress.org/extend/plugins/random-quotes/
	Description: Lets you manage and display random quotations
	Version: 1.3
	Author: Stephen Coley
	Author URI: http://coley.co

	Copyright 2010  Stephen Coley  (email : stephen@srcoley.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
	*/


	function rq_install() {
		global $wpdb;
		$rq_db_version = "1.3";

		$installed_ver = get_option("rq_db_version");

		if($installed_ver != $rq_db_version) {

			$table_name = $wpdb->prefix . "rq";

			if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
				if($wpdb->query("CREATE TABLE $table_name (id mediumint(9) NOT NULL AUTO_INCREMENT, quotation longtext NOT NULL, quotation2 longtext NULL, UNIQUE KEY id (id));") === FALSE) {
					add_option("rq_db_error", "false");
				} else {
					add_option("rq_db_version", $rq_db_version);
				}
			} else {
				if($wpdb->query("ALTER TABLE $table_name MODIFY `quotation` longtext NOT NULL;") && $wpdb->query("ALTER TABLE $table_name MODIFY `quotation2` longtext NULL;")) {
					update_option("rq_db_version", $rq_db_version);
				} else {
					update_option("rq_db_version", mysql_error());
				}
			}
		}
	}

	add_shortcode("random-quote","display_rq");

	function display_rq($id = "") {
		global $wpdb;
		if($id != "") {
			$quote = $wpdb->get_results("SELECT quotation FROM " . $wpdb->prefix . "rq WHERE id = " . $wpdb->escape($id), ARRAY_A);
			if(count($quote) > 0) {
				return '' . stripslashes($quote[0]['quotation']) . '';
			} else {
				return "There is no quotation with this id.";
			}
		} else {
			$quotes = $wpdb->get_results("SELECT quotation FROM " . $wpdb->prefix . "rq", ARRAY_A);
			if($quotes < 1) {
				return "There are no quotes to display.";
			} else {
				$count = count($quotes) - 1;
				$rand = rand(0, $count);
				return '' . stripslashes($quotes[$rand]['quotation']) . '';
			}
		}
	}

	function rq_admin() {
		include('rq_admin.php');
	}

	function rq_admin_actions() {
		add_options_page("Random Quotes", "Random Quotes", 1, "Random-Quotes", "rq_admin");
	}


	register_activation_hook(__FILE__, 'rq_install');
	add_action('admin_menu', 'rq_admin_actions');



?>
