<?php 

/**
 * Redirect WordPress front end https URLs to http without a plugin
 *
 * Necessary when running forced SSL in admin and you don't want links to the front end to remain https.
 *
 * @link http://blackhillswebworks.com/?p=5088
 */
 
	add_action( 'template_redirect', 'aa_template_redirect', 1 );

	function aa_template_redirect() {

		if ( is_ssl() && ! is_admin() ) {
		
			if ( 0 === strpos( $_SERVER['REQUEST_URI'], 'http' ) ) {
			
				wp_redirect( preg_replace( '|^https://|', 'http://', $_SERVER['REQUEST_URI'] ), 301 );
				exit();
				
			} else {
			
				wp_redirect( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 301 );
				exit();
				
			}
			
		}
		
	}

 ?>