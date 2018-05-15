<?php
new Theme_Unused_Customizer();

class Theme_Unused_Customizer {
	public function __construct() {
		// add_action( 'wp_enqueue_scripts', array( &$this, 'customizer_css' ) );
		// add_action( 'customize_register', array( &$this, 'customize_realty_manager' ) );
		// add_action( 'customize_register', array( &$this, 'customize_realtor_manager' ) );
	}

	/**
	 * Customizer manager demo
	 * @param  WP_Customizer_Manager $aa_property
	 * @return void
	 */
	public function customize_realty_manager( $aa_property ) {
		$this->aa_property_section( $aa_property );
	}

	public function aa_property_section( $aa_property ) {
		$aa_property->add_section( 'realty_customizer_section',
			array(
				'title'          => 'Property Overview',
				'priority'       => 25,
			)
		);

	    // Textbox control
		$aa_property->add_setting( 'aa_property_price',
			array(
				'default'        => 'aa_property_price',
			)
		);

		$aa_property->add_control( 'aa_property_price',
			array(
				'label'   => 'Propery Price',
				'section' => 'realty_customizer_section',
				'type'    => 'text',
				'priority' => 2,
			)
		);

		$aa_property->add_setting( 'aa_cover_image', array(
			'default'        => '',
			) );

		$aa_property->add_control(
			new WP_Customize_Image_Control(
				$aa_property,
				'cover_image',
				array(
					'label'      => __( 'Upload a cover image', 'tarrytown' ),
					'section'    => 'realty_customizer_section',
					'settings'   => 'aa_cover_image',
					'context'    => 'cover_image_context',
					'priority'   => 1,
				)
			) );
    }

	    // Add A Layout Picker
		require_once dirname( __FILE__ ) . '/layout/layout-picker-custom-control.php';
		$wp_manager->add_setting( 'layout_picker_setting', array(
			'default'        => '',
		) );
		$wp_manager->add_control( new Layout_Picker_Custom_Control( $wp_manager, 'layout_picker_setting', array(
			'label'   => 'Layout Picker Setting',
			'section' => 'realtor_description_section',
			'settings'   => 'layout_picker_setting',
			'priority' => 2,
		) ) );

	    // Add a category dropdown control
		require_once dirname( __FILE__ ) . '/select/category-dropdown-custom-control.php';
		$wp_manager->add_setting( 'category_dropdown_setting', array(
			'default'        => '',
		) );
		$wp_manager->add_control( new Category_Dropdown_Custom_Control( $wp_manager, 'category_dropdown_setting', array(
			'label'   => 'Category Dropdown Setting',
			'section' => 'realtor_description_section',
			'settings'   => 'category_dropdown_setting',
			'priority' => 3,
		) ) );


	    // Dropdown pages control
		$aa_realtor->add_setting( 'dropdown_pages_setting',
			array(
				'default'        => '1',
			)
		);

		$aa_realtor->add_control( 'dropdown_pages_setting',
			array(
				'label'   => 'Dropdown Pages Setting',
				'section' => 'aa_open_house_section',
				'type'    => 'dropdown-pages',
				'priority' => 5,
			)
		);

	    // Color control
		$aa_realtor->add_setting( 'color_setting',
			array(
				'default'        => '#000000',
			)
		);

		$aa_realtor->add_control(
			new WP_Customize_Color_Control( $aa_realtor, 'color_setting',
				array(
					'label'   => 'Color Setting',
					'section' => 'aa_open_house_section',
					'settings'   => 'color_setting',
					'priority' => 6,
				)
			)
		);

	    // Textbox control
		$aa_realtor->add_setting( 'aa_realtor_details',
			array(
				'default'        => 'Default Text For Realtor Blurb',
			)
		);

		$aa_realtor->add_control( 'aa_realtor_details',
			array(
				'label'   => 'Realtor Details',
				'section' => 'aa_open_house_section',
				'type'    => 'textarea',
				'priority' => 11,
			)
		);

	    // WP_Customize_Image_Control
		$aa_realtor->add_setting( 'image_setting',
			array(
				'default'        => '',
			)
		);

		$aa_realtor->add_control(
			new WP_Customize_Image_Control( $aa_realtor, 'image_setting',
				array(
					'label'   => 'Image Setting',
					'section' => 'aa_open_house_section',
					'settings'   => 'image_setting',
					'priority' => 8,
				)
			)
		);

	/**
	 * Customizer manager demo
	 * @param  WP_Customizer_Manager $aa_property
	 * @return void
	 */
	public function customize_realtor_manager( $aa_realtor ) {
		$this->aa_unused_section( $aa_realtor );
	}

	public function aa_unused_section( $aa_realtor ) {
		$aa_realtor->add_section( 'realtor_customizer_section',
			array(
				'title'          => 'Open House Info',
				'priority'       => 15,
			)
		);

	    // Color control
		$aa_realtor->add_setting( 'color_setting',
			array(
				'default'        => '#000000',
			)
		);

		$aa_realtor->add_control(
			new WP_Customize_Color_Control( $aa_realtor, 'color_setting',
				array(
					'label'   => 'Color Setting',
					'section' => 'realtor_customizer_section',
					'settings'   => 'color_setting',
					'priority' => 6,
				)
			)
		);


	    // Textbox control
		$aa_realtor->add_setting( 'aa_realtor_details',
			array(
				'default'        => 'Default Text For Realtor Blurb',
			)
		);

		$aa_realtor->add_control( 'aa_realtor_details',
			array(
				'label'   => 'Realtor Details',
				'section' => 'realtor_customizer_section',
				'type'    => 'textarea',
				'priority' => 11,
			)
		);

	    // WP_Customize_Image_Control
		$aa_realtor->add_setting( 'image_setting',
			array(
				'default'        => '',
			)
		);

		$aa_realtor->add_control(
			new WP_Customize_Image_Control( $aa_realtor, 'image_setting',
				array(
					'label'   => 'Image Setting',
					'section' => 'realtor_customizer_section',
					'settings'   => 'image_setting',
					'priority' => 8,
				)
			)
		);
	}

	/**
	 * https://themeshaper.com/2013/04/29/validation-sanitization-in-customizer/
	 */
	function prefix_customize_register( $wp_customize ) {
		$wp_customize->add_section( 'prefix_theme_options', array(
			'title'    => __( 'Theme Options', 'textdomain' ),
			'priority' => 101,
			) );

		$wp_customize->add_setting( 'prefix_layout', array(
			'default'           => 'content-sidebar',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'prefix_sanitize_layout',
			) );

		$wp_customize->add_control( 'prefix_layouts', array(
			'label'    => __( 'Layout', 'textdomain' ),
			'section'  => 'prefix_theme_options',
			'settings' => 'prefix_layout',
			'type'     => 'radio',
			'choices'  => array(
				'content-sidebar' => __( 'Content on left', 'textdomain' ),
				'sidebar-content' => __( 'Content on right', 'textdomain' ),
				),
			) );
	}
	add_action( 'customize_register', 'prefix_customize_register' );

	function prefix_sanitize_layout( $value ) {
		if ( ! in_array( $value, array( 'content-sidebar', 'sidebar-content' ) ) )
			$value = 'content-sidebar';

		return $value;
	}
}
