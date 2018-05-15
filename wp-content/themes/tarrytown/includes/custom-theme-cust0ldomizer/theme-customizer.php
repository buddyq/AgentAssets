<?php
new Theme_Customizer();

class Theme_Customizer {
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( &$this, 'customizer_css' ) );
		add_action( 'customize_register', array( &$this, 'customize_realty_manager' ) );
		add_action( 'customize_register', array( &$this, 'customize_realtor_manager' ) );
		add_action( 'customize_register', array( &$this, 'remove_default_customizer' ), 20 );
	}

	/**
	 * Add the Customize link to the admin menu
	 * @return void
	 */
	public function customizer_css() {
		wp_enqueue_style( 'customizer', get_stylesheet_directory_uri() . '/includes/custom-theme-customizer/text/css/customizer.css' );
	}

	public function remove_default_customizer( $wp_customize ) {
		$wp_customize->remove_panel( 'nav_menus' );
		$wp_customize->remove_panel( 'widgets' );
		// $wp_customize->remove_panel( 'static_front_page' );
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

	/**
	 * Customizer manager demo
	 * @param  WP_Customizer_Manager $aa_property
	 * @return void
	 */
	public function customize_realtor_manager( $aa_realtor ) {
		$this->aa_open_house_section( $aa_realtor );
	}

	public function aa_open_house_section( $aa_realtor ) {
		$aa_realtor->add_section( 'aa_open_house_section',
			array(
				'title'          => 'Open House Info',
				'priority'       => 15,
			)
		);
	    // Checkbox control
		$aa_realtor->add_setting( 'aa_show_open_house', array(
			'default'        => '1',
		) );

		$aa_realtor->add_control( 'aa_show_open_house', array(
			'label'   => 'Checkbox Setting',
			'section' => 'aa_open_house_section',
			'type'    => 'checkbox',
			// 'priority' => 2,
		) );

	    // Add a user dropdown control
		require_once dirname( __FILE__ ) . '/select/user-dropdown-custom-control.php';

		$aa_realtor->add_setting( 'open_house_host_dropdown', array(
			'default'        => '',
		) );

		$aa_realtor->add_control( new User_Dropdown_Custom_Control( $aa_realtor, 'open_house_host_dropdown', array(
			'label'   => 'Open House Host Dropdown',
			'section' => 'aa_open_house_section',
			'settings'   => 'open_house_host_dropdown',
			// 'priority' => 1,
		) ) );

	    // Add A Date Picker
		require_once dirname( __FILE__ ) . '/date/date-picker-custom-control.php';
		$aa_realtor->add_setting( 'open_house_date_picker', array(
			'default'        => '',
		) );

		$aa_realtor->add_control( new Date_Picker_Custom_Control( $aa_realtor, 'open_house_date_picker', array(
			'label'   => 'Date Picker Setting',
			'section' => 'aa_open_house_section',
			'settings'   => 'open_house_date_picker',
			// 'priority' => 1,
		) ) );

	    // Textbox control
		$aa_realtor->add_setting( 'aa_open_house_time',
			array(
				'default'        => 'aa_open_house_time',
			)
		);

		$aa_realtor->add_control( 'aa_open_house_time',
			array(
				'label'   => 'Open House Time',
				'section' => 'aa_open_house_section',
				'type'    => 'text',
				// 'priority' => 1,
			)
		);

	}
}
