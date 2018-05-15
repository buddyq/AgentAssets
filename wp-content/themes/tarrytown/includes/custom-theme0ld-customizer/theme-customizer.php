<?php
new Theme_Customizer();

class Theme_Customizer {
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( &$this, 'customizer_admin' ) );
		add_action( 'customize_register', array( &$this, 'customize_realty_manager' ) );
		add_action( 'customize_register', array( &$this, 'customize_realtor_manager' ) );
	}

	/**
	 * Add the Customize link to the admin menu
	 * @return void
	 */
	public function customizer_admin() {
		wp_enqueue_style( 'customizer', get_stylesheet_directory_uri() . '/includes/custom-theme-customizer/text/css/customizer.css' );
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
				'title'          => 'My Property Overview',
				'priority'       => 25,
			)
		);


	    // Textbox control
		$aa_property->add_setting( 'aa_property_name',
			array(
				'default'        => 'aa_property_name',
			)
		);

		$aa_property->add_control( 'aa_property_name',
			array(
				'label'   => 'Propery Name',
				'section' => 'realty_customizer_section',
				'type'    => 'text',
				'priority' => 1,
			)
		);

	    // Textbox control
		$aa_property->add_setting( 'aa_property_label',
			array(
				'default'        => 'aa_property_label',
			)
		);

		$aa_property->add_control( 'aa_property_label',
			array(
				'label'   => 'Propery Label',
				'section' => 'realty_customizer_section',
				'type'    => 'text',
				'priority' => 1,
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

	    // Textbox control
		$aa_property->add_setting( 'aa_property_street_address',
			array(
				'default'        => 'aa_property_street_address',
			)
		);

		$aa_property->add_control( 'aa_property_street_address',
			array(
				'label'   => 'Propery Street Address',
				'section' => 'realty_customizer_section',
				'type'    => 'text',
				'priority' => 3,
			)
		);


	    // Textbox control
		$aa_property->add_setting( 'aa_property_city_state_zip',
			array(
				'default'        => 'aa_property_city_state_zip',
			)
		);

		$aa_property->add_control( 'aa_property_city_state_zip',
			array(
				'label'   => 'Propery City, State Zip',
				'section' => 'realty_customizer_section',
				'type'    => 'text',
				'priority' => 4,
			)
		);

	    // Textbox control
		$aa_property->add_setting( 'aa_property_address_line3',
			array(
				'default'        => 'aa_property_address_line3',
			)
		);

		$aa_property->add_control( 'aa_property_address_line3',
			array(
				'label'   => 'Propery Address Line 3',
				'description' => 'Apartment number or whatever else might need to go on another line for proper addressing.',
				'section' => 'realty_customizer_section',
				'type'    => 'text',
				'priority' => 5,
			)
		);


	    // Select control
		$aa_property->add_setting( 'bedroom_select',
			array(
				'default'        => '4',
			)
		);

		$aa_property->add_control( 'bedroom_select',
			array(
				'label'   => 'Number of Bedrooms',
				'section' => 'realty_customizer_section',
				'type'    => 'select',
				'choices' => array( '1', '2', '3', '4', '5' ),
				'priority' => 6,
			)
		);

	    // Select control
		$aa_property->add_setting( 'bathroom_select',
			array(
				'default'        => '2',
			)
		);

		$aa_property->add_control( 'bathroom_select',
			array(
				'label'   => 'Number of Bathrooms',
				'section' => 'realty_customizer_section',
				'type'    => 'select',
				'choices' => array( '1', '2', '3', '4', '5' ),
				'priority' => 6,
			)
		);


		$aa_property->add_setting( 'aa_property_description',
			array(
			'default'        => 'Default Text For Property Description',
			)
		);

		$aa_property->add_control('aa_property_description', array(
			'label'   => 'Property Description',
			'section' => 'realty_customizer_section',
			'type'    => 'textarea',
			'priority' => 17,
			)
		);
    }


	/**
	 * Customizer manager demo
	 * @param  WP_Customizer_Manager $aa_property
	 * @return void
	 */
	public function customize_realtor_manager( $aa_realtor ) {
		$this->aa_realtor_section( $aa_realtor );
	}

	public function aa_realtor_section( $aa_realtor ) {
		$aa_realtor->add_section( 'realtor_customizer_section',
			array(
				'title'          => 'My Realtor Info',
				'priority'       => 35,
			)
		);

	    // Textbox control
		$aa_realtor->add_setting( 'aa_realtor_text_3',
			array(
				'default'        => 'aa_realtor_text_3',
			)
		);

		$aa_realtor->add_control( 'aa_realtor_text_3',
			array(
				'label'   => 'Realtor Setting1',
				'section' => 'realtor_customizer_section',
				'type'    => 'text',
				'priority' => 1,
			)
		);

	    // Dropdown pages control
		$aa_realtor->add_setting( 'dropdown_pages_setting',
			array(
				'default'        => '1',
			)
		);

		$aa_realtor->add_control( 'dropdown_pages_setting',
			array(
				'label'   => 'Dropdown Pages Setting',
				'section' => 'realtor_customizer_section',
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
}
