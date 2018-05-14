<?php 

function bp_redirect($user) {
	$home = home_url( '/', 'https' );
  $redirect_url = esc_url($home) . '/registration-successful';
  bp_core_redirect($redirect_url);
}

add_action('bp_core_signup_user', 'bp_redirect', 100, 1);

 ?>