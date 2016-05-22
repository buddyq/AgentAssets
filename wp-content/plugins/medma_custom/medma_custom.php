<?php
/*
 * Plugin Name: Medma Custom
 * 
 */

# Required Files
// These files need to be included as dependencies when on the front end.
require_once( ABSPATH . 'wp-admin/includes/image.php' );
require_once( ABSPATH . 'wp-admin/includes/file.php' );
require_once( ABSPATH . 'wp-admin/includes/media.php' );

# Include Files
include 'includes/shortcodes/register-form.php';
include 'includes/shortcodes/profile-form.php';
include 'includes/meta-boxes.php';
include 'includes/filters.php';
include 'includes/actions.php';
include 'includes/widgets.php';
include 'includes/shortcodes/theme_settings.php';


# Add Scripts
//wp_enqueue_script( 'jquery-validate', plugins_url('medma_custom').'/js/jquery.validate.js', '', '1.13.1', true );
// wp_enqueue_script( 'additional-methods', plugins_url('medma_custom').'/js/additional-methods.js', '', '1.13.1', true );

// wp_enqueue_script( 'mi-custom', plugins_url('medma_custom').'/js/custom.js', '', '1.0', true );

# Add Styles
wp_enqueue_style( 'mi-custom', plugins_url('medma_custom').'/css/custom.css', '', time(), 'all');


add_filter( 'wp_mail_content_type', 'custom_mi_agentassets_set_content_type' );
function custom_mi_agentassets_set_content_type( $content_type ) {
	return 'text/html';
}

?>