<?php
/***
* PBrx Customizer Functions
**/

add_action( 'wp_head', 'show_slider_function' );
function show_slider_function() {
	$show_slider = get_theme_mod( 'show_slider' );
	if ( '1' === $show_slider ) {
		echo '<h3 style="position:absolute;z-index: 1112;text-align:center;color:indianred;">Show Slider</h3>';
	}
}


add_action( 'admin_menu', 'add_dashboard_page1' );
function add_dashboard_page1() {
	add_dashboard_page( 'Debugging Dashboard', 'Debugging', 'manage_options', 'debug-dashboard', 'debug_dashboard' );
}

// In your functions.php file or some plugin's file.
function the_featured_image_gallery( $atts = array() ) {
    $setting_id = 'customizer_image_gallery';
    $ids_array = get_theme_mod( $setting_id );
    if ( is_array( $ids_array ) && ! empty( $ids_array ) ) {
        $atts['ids'] = implode( ',', $ids_array );
        echo gallery_shortcode( $atts );
    }
}


function customizer_image_gallery_shortcode( $atts ) {
    $ids_array = get_theme_mod( 'customizer_image_gallery' );
    if ( is_array( $ids_array ) && ! empty( $ids_array ) ) {
		$ids = implode( ',', $ids_array );
		$atts['include'] = $ids;
    }
    return gallery_shortcode( $atts );
}
add_shortcode( 'customizer-image-gallery', 'customizer_image_gallery_shortcode' );

function debug_dashboard() {
	echo '<div class="wrap">';
	echo get_theme_mod( 'front_page_panels' ) . ' is ';
	echo gettype( intval( get_theme_mod( 'front_page_panels' ) ) );
	$mods = get_theme_mod( 'customizer_image_gallery' );
	$customizer_images = customizer_image_gallery_shortcode( $atts );
	$ids_array = get_theme_mod( 'customizer_image_gallery' );

	foreach( $mods as $key=>$mod ) {
		echo '<br>' . wp_get_attachment_url( $mod );
	}

	echo '<pre>';
	// var_dump( $var );
	print_r( $mods );
	echo '</pre>';

	echo '</div>';
}


