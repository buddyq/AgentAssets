<?php 

function themeslug_theme_customizer( $wp_customize ) {
$wp_customize->add_section( 'et_divi_header_layoutt' , array(
		'title'		=> esc_html__( 'Logo upload', 'Divi' ),
		'panel' => 'et_divi_header_panel',
	) );
	$wp_customize->add_setting( 'image' );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'image', array(
			'label'		=> esc_html__( 'logo upload', 'Divi' ),
			'section'	=> 'et_divi_header_layoutt',
			'settings' => 'image',
		) ) );
	
	
    //~ $wp_customize->add_section( 'themeslug_logo_section' , array(
        //~ 'title' => __( 'logo upload', 'themeslug' ),
        //~ 'priority' => 30,
        //~ 'description' => 'Upload a logo to replace the default site name and description in the header',
    //~ ) );
    //~ $wp_customize->add_setting( 'themeslug_logo' );
    //~ $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'themeslug_logo', array(
        //~ 'label' => __( 'Logo', 'themeslug' ),
        //~ 'section' => 'themeslug_logo_section',
        //~ 'settings' => 'themeslug_logo',
    //~ ) ) );
    // Fun code will go here
}

add_action( 'customize_register', 'themeslug_theme_customizer' );
