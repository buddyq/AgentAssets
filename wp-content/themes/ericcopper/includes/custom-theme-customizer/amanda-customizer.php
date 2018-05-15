<?php

class Amanda_Customizer {

	/** https://www.nosegraze.com/image-select-control-wordpress-customizer/
	 * Amanda_Customizer constructor.
	 *
	 * @param string $theme_slug
	 *
	 * @access public
	 * @since  1.1
	 * @return void
	 */
	public function __construct() {

		add_action( 'customize_register', array( $this, 'include_controls' ) );
		add_action( 'customize_register', array( $this, 'register_customize_sections' ) );

	}

	/**
	 * Include Custom Controls
	 *
	 * Includes all our custom control classes.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access public
	 * @since  1.1
	 * @return void
	 */
	public function include_controls( $wp_customize ) {

		require_once get_template_directory() . '/inc/customizer/controls/class-ng-image-select-control.php';

		$wp_customize->register_control_type( 'NG_Image_Select_Control' );

	}

	/**
	 * Add all panels and sections to the Customizer
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access public
	 * @since  1.1
	 * @return void
	 */
	public function register_customize_sections( $wp_customize ) {

		// Create sections
		$wp_customize->add_section( 'blog_layout', array(
			'title'    => __( 'Blog Layout', 'amanda' ),
			'priority' => 101,
		) );

		// Populate sections
		$this->blog_layout_section( $wp_customize );

	}

	/**
	 * Section: Blog Layout
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.1
	 * @return void
	 */
	private function blog_layout_section( $wp_customize ) {

		/* Our image select setting will go here */

	}

}