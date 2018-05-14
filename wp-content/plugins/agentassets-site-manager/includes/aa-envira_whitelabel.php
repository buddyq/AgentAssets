<?php 

add_filter( 'gettext', 'tgm_envira_whitelabel', 10, 3 );
function tgm_envira_whitelabel( $translated_text, $source_text, $domain ) {

	// If not in the admin, return the default string.
	if ( ! is_admin() ) {
		return $translated_text;
	}

	if ( strpos( $source_text, 'an Envira' ) !== false ) {
		return str_replace( 'an Envira', '', $translated_text );
	}

	if ( strpos( $source_text, 'Envira' ) !== false ) {
		return str_replace( 'Envira', 'Photo', $translated_text );
	}

	return $translated_text;

}

?>