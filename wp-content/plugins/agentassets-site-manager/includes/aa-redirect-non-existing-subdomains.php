<?php 

function prevent_multisite_signup() 
{
    // $error = new WP_Error();
    echo "Site doesn't exist.";
    
    wp_redirect( 'https://www.agentassets.com');
    exit;
}
// add_action('signup_header', 'prevent_multisite_signup');