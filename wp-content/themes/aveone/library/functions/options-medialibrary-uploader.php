<?php
/**
* @package Options_Framework
* @author Devin Price <devin@wptheming.com>
* @license GPL-2.0+
* @link http://wptheming.com
* @copyright 2010-2014 WP Theming
*/
class aveone_Framework_Media_Uploader {
/**
* Initialize the media uploader class
*
* @since 1.7.0
*/
public function init() {
add_action( 'admin_enqueue_scripts', array( $this, 'aveone_media_scripts' ) );
}
/**
* Media Uploader Using the WordPress Media Library.
*
* Parameters:
*
* string $_id - A token to identify this field (the name).
* string $_value - The value of the field, if present.
* string $_desc - An optional description of the field.
*
*/
static function aveone_uploader( $_id, $_value, $_desc = '', $_name = '' ) {
$aveone_settings = get_option( 'aveone' );
// Gets the unique option id
$option_name = $aveone_settings['id'];
$output = '';
$id = '';
$class = '';
$int = '';
$value = '';
$name = '';
$id = strip_tags( strtolower( $_id ) );
// If a value is passed and we don't have a stored value, use the value that's passed through.
if ( $_value != '' && $value == '' ) {
$value = $_value;
}
if ($_name != '') {
$name = $_name;
}
else {
$name = $option_name.'['.$id.']';
}
if ( $value ) {
$class = ' has-file';
}
$output .= '<input id="' . $id . '" class="upload' . $class . '" type="text" name="'.$name.'" value="' . $value . '" placeholder="' . __('No file chosen', 'aveone') .'" />' . "\n";
if ( function_exists( 'wp_enqueue_media' ) ) {
if ( ( $value == '' ) ) {
$output .= '<input id="upload-' . $id . '" class="upload-button button" type="button" value="' . __( 'Upload', 'aveone' ) . '" />' . "\n";
} else {
$output .= '<input id="remove-' . $id . '" class="remove-image button" type="button" value="' . __( 'Remove', 'aveone' ) . '" />' . "\n";   
}
} else {
$output .= '<p><i>' . __( 'Upgrade your version of WordPress for full media support.', 'aveone' ) . '</i></p>';
}
if ( $_desc != '' ) {
$output .= '<span class="of-metabox-desc">' . $_desc . '</span>' . "\n";
}
$output .= '<div class="screenshot" id="' . $id . '-image">' . "\n";
if ( $value != '' ) {
$image = preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $value );
if ( $image ) {
$output .= '<img src="' . $value . '" alt="" />';
} else {
$parts = explode( "/", $value );
for( $i = 0; $i < sizeof( $parts ); ++$i ) {
$title = $parts[$i];
}
// No output preview if it's not an image.
$output .= '';
// Standard generic output if it's not an image.
$title = __( 'View File', 'aveone' );
$output .= '<div class="no-image"><span class="file_link"><a href="' . $value . '" target="_blank" rel="external">'.$title.'</a></span></div>';
}
}
$output .= '</div>' . "\n";
return $output;
}
/**
* Enqueue scripts for file uploader
*/
function aveone_media_scripts( $hook ) {
if ( function_exists( 'wp_enqueue_media' ) )
wp_enqueue_media();
wp_register_script( 'aveone-media-uploader', AVEONE_DIRECTORY .'/js/medialibrary-uploader.js', array( 'jquery' ) );
wp_enqueue_script( 'aveone-media-uploader' );
wp_localize_script( 'aveone-media-uploader', 'aveoneframework_l10n', array(
'upload' => __( 'Upload', 'aveone' ),
'remove' => __( 'Remove', 'aveone' )
) );
}
}