<?php
/**
 * Hooks - WP aveone's hook system
 *
 * @package WPaveone
 * @subpackage WP_aveone
 */

/**
 * aveone_hook_before_html() short description.
 *
 * Long description.
 *
 * @since 0.3
 * @hook action aveone_hook_before_html
 */
function aveone_hook_before_html() {
	do_action( 'aveone_hook_before_html' );
}

/**
 * aveone_hook_after_html() short description.
 *
 * Long description.
 *
 * @since 0.3
 * @hook action aveone_hook_after_html
 */
function aveone_hook_after_html() {
	do_action( 'aveone_hook_after_html' );
}

/**
 * aveone_hook_comments() short description.
 *
 * Long description.
 *
 * @since 0.3
 * @hook action aveone_hook_loop
 */
function aveone_hook_comments( $callback = array('aveone_comment_author', 'aveone_comment_meta', 'aveone_comment_moderation', 'aveone_comment_text', 'aveone_comment_reply' ) ) {
	do_action( 'aveone_hook_comments_open' ); // Available action: aveone_comment_open
	do_action( 'aveone_hook_comments' );

	$callback = apply_filters( 'aveone_comments_callback', $callback ); // Available filter: aveone_comments_callback
	
	// If $callback is an array, loop through all callbacks and call those functions if they exist
	if ( is_array( $callback ) ) {
		foreach( $callback as $function ) {
			if ( function_exists( $function ) ) {
				call_user_func( $function );
			}
		}
	}
	
	// If $callback is a string, just call that function if it exist
	elseif ( is_string( $callback ) ) {
		if ( function_exists( $callback ) ) {
			call_user_func( $callback );
		}
	}
	do_action( 'aveone_hook_comments_close' ); // Available action: aveone_comment_close
}
?>