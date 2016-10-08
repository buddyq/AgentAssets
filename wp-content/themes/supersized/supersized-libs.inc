<?php
// function supersized_scripts(){
// Load Supersized JS
wp_enqueue_script( 'supersized', get_template_directory_uri() . '/js/supersized.min.js');

// Load Supersized Shutter JS
wp_enqueue_script( 'supersized-shutter', get_template_directory_uri() . '/js/supersized.shutter.js');

// Load Supersized CSS
wp_enqueue_style( 'supersized', get_template_directory_uri() . '/css/supersized.css');

// Load Supersized Shutter CSS
wp_enqueue_style( 'supersized-shutter', get_template_directory_uri() . '/css/supersized.shutter.css');
// }

// add_action( 'wp_enqueue_scripts', 'supersized_scripts' );
?>
