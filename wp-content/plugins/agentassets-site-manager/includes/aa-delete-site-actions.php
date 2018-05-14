<?php 
/**
// Perform these actions when a user or Admin deletes a site.
*/

add_action( 'delete_blog', 'AgentAssets::unpark_domain', 1, 2 );

  // Unparks domain name from cpanel

  // Deletes domain domain_mapping

  // Make sure tables are deleted

