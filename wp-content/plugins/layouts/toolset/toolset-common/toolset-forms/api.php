<?php

<<<<<<< HEAD
<<<<<<< HEAD
function wptoolset_form( $form_id, $config = array() ){
	/** @var WPToolset_Forms_Bootstrap $wptoolset_forms */
	global $wptoolset_forms;
=======
=======
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
/**
 *
 *
 */

function wptoolset_form( $form_id, $config = array() ){
    global $wptoolset_forms;
<<<<<<< HEAD
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
=======
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
    $html = $wptoolset_forms->form( $form_id, $config );
    return apply_filters( 'wptoolset_form', $html, $config );
}

function wptoolset_form_field( $form_id, $config, $value = array() ){
<<<<<<< HEAD
<<<<<<< HEAD
    /** @var WPToolset_Forms_Bootstrap $wptoolset_forms */
	global $wptoolset_forms;
=======
    global $wptoolset_forms;
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
=======
    global $wptoolset_forms;
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
    $html = $wptoolset_forms->field( $form_id, $config, $value );
    return apply_filters( 'wptoolset_fieldform', $html, $config, $form_id );
}

//function wptoolset_form_field_edit( $form_id, $config ){
//    global $wptoolset_forms;
//    $html = $wptoolset_forms->fieldEdit( $form_id, $config );
//    return apply_filters( 'wptoolset_fieldform_edit', $html, $config, $form_id );
//}

function wptoolset_form_validate_field( $form_id, $config, $value ){
<<<<<<< HEAD
<<<<<<< HEAD
	/** @var WPToolset_Forms_Bootstrap $wptoolset_forms */
	global $wptoolset_forms;
=======
    global $wptoolset_forms;
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
=======
    global $wptoolset_forms;
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
    return $wptoolset_forms->validate_field( $form_id, $config, $value );
}

function wptoolset_form_conditional_check( $config ){
<<<<<<< HEAD
<<<<<<< HEAD
	/** @var WPToolset_Forms_Bootstrap $wptoolset_forms */
	global $wptoolset_forms;
=======
    global $wptoolset_forms;
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
=======
    global $wptoolset_forms;
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
    return $wptoolset_forms->checkConditional( $config );
}

function wptoolset_form_add_conditional( $form_id, $config ){
<<<<<<< HEAD
<<<<<<< HEAD
	/** @var WPToolset_Forms_Bootstrap $wptoolset_forms */
	global $wptoolset_forms;
    $wptoolset_forms->addConditional( $form_id, $config );
}

function wptoolset_form_filter_types_field( $field, $post_id = null, $_post_wpcf = array() ){
	/** @var WPToolset_Forms_Bootstrap $wptoolset_forms */
	global $wptoolset_forms;
=======
=======
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
    global $wptoolset_forms;
    return $wptoolset_forms->addConditional( $form_id, $config );
}

function wptoolset_form_filter_types_field( $field, $post_id = null, $_post_wpcf = array() ){
    global $wptoolset_forms;
<<<<<<< HEAD
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
=======
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
    return $wptoolset_forms->filterTypesField( $field, $post_id, $_post_wpcf );
}

function wptoolset_form_field_add_filters( $type ){
<<<<<<< HEAD
<<<<<<< HEAD
	/** @var WPToolset_Forms_Bootstrap $wptoolset_forms */
	global $wptoolset_forms;
=======
    global $wptoolset_forms;
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
=======
    global $wptoolset_forms;
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
    $wptoolset_forms->addFieldFilters( $type );
}

function wptoolset_form_get_conditional_data( $post_id ){
<<<<<<< HEAD
<<<<<<< HEAD
	/** @var WPToolset_Forms_Bootstrap $wptoolset_forms */
	global $wptoolset_forms;
=======
    global $wptoolset_forms;
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
=======
    global $wptoolset_forms;
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
    return $wptoolset_forms->getConditionalData( $post_id );
}

function wptoolset_strtotime( $date, $format = null ){
<<<<<<< HEAD
<<<<<<< HEAD
	/** @var WPToolset_Forms_Bootstrap $wptoolset_forms */
	global $wptoolset_forms;
=======
    global $wptoolset_forms;
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
=======
    global $wptoolset_forms;
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
    return $wptoolset_forms->strtotime( $date, $format );
}

function wptoolset_timetodate( $timestamp, $format = null ){
<<<<<<< HEAD
<<<<<<< HEAD
	/** @var WPToolset_Forms_Bootstrap $wptoolset_forms */
	global $wptoolset_forms;
=======
    global $wptoolset_forms;
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
=======
    global $wptoolset_forms;
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
    return $wptoolset_forms->timetodate( $timestamp, $format );
}

/**
 * wptoolset_esc_like
 *
 * In WordPress 4.0, like_escape() was deprecated, due to incorrect
 * documentation and improper sanitization leading to a history of misuse
 * To maintain compatibility with versions of WP before 4.0, we duplicate the
 * logic of the replacement, wpdb::esc_like()
 *
 * @see wpdb::esc_like() for more details on proper use.
 *
 * @global object $wpdb
 *
<<<<<<< HEAD
<<<<<<< HEAD
 * @param string $like The raw text to be escaped.
=======
 * @param string $text The raw text to be escaped.
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
=======
 * @param string $text The raw text to be escaped.
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
 * @return string Text in the form of a LIKE phrase. Not SQL safe. Run through
 *                wpdb::prepare() before use.
 */
function wptoolset_esc_like( $like )
{
    global $wpdb;
    if ( method_exists( $wpdb, 'esc_like' ) ) {
        return $wpdb->esc_like( $like );
    }
    if ( version_compare( get_bloginfo('version'), '4' ) < 0 ) {
        return like_escape( $like );
    }
    return addcslashes( $like, '_%\\' );
}

