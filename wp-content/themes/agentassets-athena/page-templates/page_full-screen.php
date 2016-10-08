<?php

/* Template Name: Fullscreen Template */

get_header(); 

// Start the loop.
while ( have_posts() ) : the_post();

	// Include the page content template.
	get_template_part( 'template-parts/content', 'page' );

	// End of the loop.
endwhile;

get_footer(); 

?>
