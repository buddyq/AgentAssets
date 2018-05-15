<?php //* Mind this opening php tag
/**
 *	This will hide the Divi "Project" post type.
 *	Thanks to georgiee (https://gist.github.com/EngageWP/062edef103469b1177bc#gistcomment-1801080) for his improved solution.
 */
add_filter( 'et_project_posttype_args', 'mytheme_et_project_posttype_args', 10, 1 );
function mytheme_et_project_posttype_args( $args ) {
	return array_merge( $args, array(
		'public'              => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => false,
		'show_in_nav_menus'   => false,
		'show_ui'             => false
	));
}


function fb_opengraph() {
    global $post;
 
    if(is_single()) {
        if(has_post_thumbnail($post->ID)) {
            $img_src = wp_get_attachment_image_src(get_post_thumbnail_id( $post->ID ), 'medium');
        } else {
            $img_src = get_stylesheet_directory_uri() . '/apre-screenshot.jpg';
        }
        if($excerpt = $post->post_excerpt) {
            $excerpt = strip_tags($post->post_excerpt);
            $excerpt = str_replace("", "'", $excerpt);
        } else {
            $excerpt = get_bloginfo('description');
        }
        ?>
 
    <meta property="og:title" content="<?php echo the_title(); ?>"/>
    <meta property="og:description" content="<?php echo $excerpt; ?>"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="<?php echo the_permalink(); ?>"/>
    <meta property="og:site_name" content="<?php echo get_bloginfo(); ?>"/>
    <meta property="og:image" content="<?php echo $img_src; ?>"/>
 
<?php
    } 
	// else {
	// 		$img_src = get_stylesheet_directory_uri() . '/apre-screenshot.jpg';
	// 		?>
	<!-- 	<meta property="og:title" content="AgentAssets.com - Amazing Real Estate Single Property Websites"/>
	 	    <meta property="og:description" content="Amazing Single Property Website platform made for your business! Customization, personalization and branding at your fingertips."/>
	 	    <meta property="og:type" content="article"/>
	 	    <meta property="og:url" content="<?php //echo the_permalink(); ?>"/>
	 	    <meta property="og:site_name" content="AgentAssets.com"/>
	 	    <meta property="og:image" content="<?php //echo $img_src; ?>"/>
	 		--><?php
         	// return;
    // }
}
add_action('wp_head', 'fb_opengraph', 5);
