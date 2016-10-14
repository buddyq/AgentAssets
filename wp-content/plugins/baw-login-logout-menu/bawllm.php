<<<<<<< HEAD
<<<<<<< HEAD
<?php
/*
Plugin Name: BAW Login/Logout menu
Plugin URI: http://www.boiteaweb.fr/?p=3337
Description: You can now add a correct login & logout link in your WP menus.
Author: Juliobox
Author URI: http://wp-rocket.me
Version: 1.3.3
*/

define( 'BAWLLM_VERSION', '1.3.3' );

add_action( 'plugins_loaded', create_function( '', '
	$filename  = "inc/";
	$filename .= is_admin() ? "backend-" : "frontend-";
	$filename .= defined( "DOING_AJAX" ) && DOING_AJAX ? "" : "no";
	$filename .= "ajax.inc.php";
	if( file_exists( plugin_dir_path( __FILE__ ) . $filename ) )
		include( plugin_dir_path( __FILE__ ) . $filename );
	$filename  = "inc/";
	$filename .= "bothend-";
	$filename .= defined( "DOING_AJAX" ) && DOING_AJAX ? "" : "no";
	$filename .= "ajax.inc.php";
	if( file_exists( plugin_dir_path( __FILE__ ) . $filename ) )
		include( plugin_dir_path( __FILE__ ) . $filename );
' )
=======
=======
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
<?php
/*
Plugin Name: BAW Login/Logout menu
Plugin URI: http://www.boiteaweb.fr/?p=3337
Description: You can now add a correct login & logout link in your WP menus.
Author: Juliobox
Author URI: http://wp-rocket.me
Version: 1.3.3
*/

define( 'BAWLLM_VERSION', '1.3.3' );

add_action( 'plugins_loaded', create_function( '', '
	$filename  = "inc/";
	$filename .= is_admin() ? "backend-" : "frontend-";
	$filename .= defined( "DOING_AJAX" ) && DOING_AJAX ? "" : "no";
	$filename .= "ajax.inc.php";
	if( file_exists( plugin_dir_path( __FILE__ ) . $filename ) )
		include( plugin_dir_path( __FILE__ ) . $filename );
	$filename  = "inc/";
	$filename .= "bothend-";
	$filename .= defined( "DOING_AJAX" ) && DOING_AJAX ? "" : "no";
	$filename .= "ajax.inc.php";
	if( file_exists( plugin_dir_path( __FILE__ ) . $filename ) )
		include( plugin_dir_path( __FILE__ ) . $filename );
' )
<<<<<<< HEAD
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
=======
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
 );