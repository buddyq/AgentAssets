<?php
/**
 *
 * @package WPaveone
 * @subpackage Functions
 */

/**
 * class WPaveone Main class loads all includes, adds/removes filters.
 * 
 * @since 0.1
 */
class WPaveone {
	
	/**
	 * init() Initialisation method which calls all other methods in turn.
	 *
	 * @since 0.1
	 */
	public static function init() {		
		$theme = new WPaveone;
		
		$theme->enviroment();
		$theme->aveone();
		$theme->extentions();
		$theme->defaults();
		$theme->ready();
		
		do_action( 'aveone_init' );
	}
	
	/**
	 * enviroment() defines WP aveone directory constants
	 *
	 * @since 0.2.3
	 */
	public static function enviroment() {	
		define( 'AVEONETHEMELIB', get_template_directory() . '/library' ); // Shortcut to point to the /library/ dir
		define( 'AVEONETHEMECORE', AVEONETHEMELIB . '/functions/' ); // Shortcut to point to the /functions/ dir
		define( 'AVEONETHEMEMORE', AVEONETHEMELIB . '/extensions/' ); // Shortcut to point to the /extensions/ dir
		define( 'AVEONETHEMEMEDIA', AVEONETHEMELIB . '/media' ); // Shortcut to point to the /media/ URI
		define( 'AVEONETHEMECSS', AVEONETHEMEMEDIA . '/css' );
		define( 'AVEONETHEMEIMAGES', AVEONETHEMEMEDIA . '/images' );
		define( 'AVEONETHEMEJS', AVEONETHEMEMEDIA . '/js' );
		
		// URI shortcuts
		define( 'AVEONETHEME', get_template_directory_uri(), true );
		define( 'AVEONELIBRARY', AVEONETHEME . '/library', true ); // Shortcut to point to the /library/ URI
		
		define( 'AVEONEMEDIA', AVEONELIBRARY . '/media', true ); // Shortcut to point to the /media/ URI
		
		define( 'AVEONECSS', AVEONEMEDIA . '/css', true );
		define( 'AVEONEIMAGES', AVEONEMEDIA . '/images', true );
		define( 'AVEONEJS', AVEONEMEDIA . '/js', true );

		do_action( 'enviroment' ); // Available action: load_enviroment
	}
	
	/**
	 * aveone() includes all the core functions for WP aveone
	 *
	 * @since 0.2.3
	 */
	public static function aveone() {    
		get_template_part( 'library/functions/hooks' ); // load the WP aveone Hook System
		get_template_part( 'library/functions/functions' ); // load aveone functions
		get_template_part( 'library/functions/comments' ); // load comment functions
		get_template_part( 'library/functions/widgets' ); // load Widget functions
	}
	
	/**
	 * extentions() includes all extentions if they exist
	 *
	 * @since 0.2.3
	 */
	public static function extentions() {
		aveone_include_all( AVEONETHEMEMORE );
	}
	
	/**
	 * defaults() connects WP aveone default behavior to their respective action
	 *
	 * @since 0.2.3
	 */
	public static function defaults() {
		add_filter( 'wp_page_menu', 'aveone_menu_ulclass' ); // adds a .nav class to the ul wp_page_menu generates
		add_action( 'init', 'aveone_media' ); // aveone_media() loads scripts and styles
	}
	
	/**
	 * ready() includes user's theme.php if it exists, calls the aveone_init action, includes all pluggable functions and registers widgets
	 *
	 * @since 0.2.3
	 */
	public static function ready() {
		if ( file_exists( AVEONETHEMEMEDIA . '/custom-functions.php' ) ) get_template_part( 'library/functions/custom-functions' ); // include custom-functions.php if that file exist
		get_template_part( 'library/functions/pluggable' ); // load pluggable functions
		do_action( 'aveone_init' ); // Available action: aveone_init
	}
} // end of WPaveone;
?>