<?php
/**
 * PTB 2017 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */

add_action( 'wp_enqueue_scripts', 'enqueue_agent_2017_style' );
/**
 * Proper way to enqueue scripts and styles
 */
function enqueue_agent_2017_style() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
// 
// add_filter( 'twentyseventeen_front_page_sections', 'pbrx_adjust_panel_quantity' );
// /**
//  * Return value of front panels.
//  **/
// function pbrx_adjust_panel_quantity() {
// 	$front_page_panels = get_theme_mod( 'front_page_panels' );
// 	return $front_page_panels;
// }
// 
// new Theme_2017_Customizer();
// 
// class Theme_2017_Customizer {
//  // extends WP_Customizer_Control {
// 	// Whitelist content parameter
// 	public $content = '';
// 
// 	public function __construct() {
// 		add_action( 'customize_register', array( &$this, 'agent_2017_manager' ) );
// 		// add_shortcode( 'insert-hours-of-operation', array( &$this, 'agent_2017_hours_shortcode' ) );
// 	}
// 
// 	/**
// 	 * Customizer manager demo
// 	 * @param  WP_Customizer_Manager $wp_manager
// 	 * @return void
// 	 */
// 	public function agent_2017_manager( $wp_manager ) {
// 		$this->agent_2017_section( $wp_manager );
// 	}
// 
// 	public function agent_2017_section( $wp_manager ) {
// 		$wp_manager->add_section( 'theme_2017_section',
// 			array(
// 				'title'          => 'Front Panels',
// 				'priority'       => 35,
// 			)
// 		);
// 
// 	// Select control
// 	$wp_manager->add_setting( 'front_page_panels', array(
// 		'default'        => '2',
// 	) );
// 
// 	$wp_manager->add_control( 'front_page_panels', array(
// 		'label'   => 'Select number of panels to show on homepage',
// 		'section' => 'theme_2017_section',
// 		'type'    => 'select',
// 		'choices' => array(
// 			'1' => 1,
// 			'2' => 2,
// 			'3' => 3,
// 			'4' => 4,
// 			'5' => 5,
// 			'6' => 6,
// 			'7' => 7,
// 			'8' => 8,
// 			'9' => 9,
// 		),
// 		'priority' => 4,
// 	) );
// 	}
// 
// }
// 
