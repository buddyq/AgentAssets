<?php 

function featured_image_gallery_customize_register( $wp_customize ) {
 
    if ( ! class_exists( 'CustomizeImageGalleryControl\Control' ) ) {
        return;
    }
 
    $wp_customize->add_section( 'featured_image_gallery_section', array(
        'title'      => __( 'Gallery Section' ),
        'priority'   => 25,
    ) );
    $wp_customize->add_setting( 'featured_image_gallery', array(
        'default' => array(),
        'sanitize_callback' => 'wp_parse_id_list',
    ) );
    $wp_customize->add_control( new CustomizeImageGalleryControl\Control(
        $wp_customize,
        'featured_image_gallery',
        array(
            'label'    => __( 'Image Gallery Field Label' ),
            'section'  => 'featured_image_gallery_section',
            'settings' => 'featured_image_gallery',
            'type'     => 'image_gallery',
        )
    ) );
}
add_action( 'customize_register', 'featured_image_gallery_customize_register' );
?>