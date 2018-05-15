<?php
/*
	Enfold Anew functions.php
*/
add_theme_support( 'deactivate_layerslider' );
add_theme_support( 'deactivate_portfolio' );

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function theme_enqueue_styles() {
	// wp_enqueue_scripts( 'custom-style', 'https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js');
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	// wp_enqueue_style( 'custom-style', 'https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css' );
	// wp_enqueue_style( 'main', get_stylesheet_directory_uri() . '/inc/css/main.css' );
}


add_action( 'ava_inside_main_menu', 'enfold_customization_header_widget_area' );
function enfold_customization_header_widget_area() {
	if(is_user_logged_in()){
		$object = new myCRED_Balance();
		echo '<li class="menu-item menu-item-top-level menu-credit-counter"><div id="odometer" class="credit-counter odometer">'.$object->current.'</div><span class="credits">Sites remaining</span></li>';
	}
}

// add_action( 'ava_main_header', 'add_menu_tab_homepage' );
function add_menu_tab_homepage() {
	/*
	    background: #559987;
		color: white;
		padding: 1rem;
		position: relative;
		top: 1rem;
		*/
	if ( ! is_user_logged_in() ) {
		echo '<button style="position: absolute; background: #559987;color: white;padding:.5rem; top 2rem; right: 4rem;">' . do_shortcode( '[wp-ajax-login text="Login/Register"]' )  . '</button>';
	}
}

add_filter( 'login_menu_location', 'add_menu_item_homepage' );
function add_menu_item_homepage() {
	return 'avia2';
}

//set builder mode to debug
// This shows the generated shortcodes below when editing a Page.
add_action( 'avia_builder_mode', 'builder_set_debug' );
function builder_set_debug() {
	return 'debug';
}

add_filter('manage_users_columns', 'pippin_add_user_id_column');
function pippin_add_user_id_column($columns) {
    $columns['user_id'] = 'User ID';
    return $columns;
}

add_action('manage_users_custom_column',  'pippin_show_user_id_column_content', 10, 3);
function pippin_show_user_id_column_content($value, $column_name, $user_id) {
    $user = get_userdata( $user_id );
	if ( 'user_id' == $column_name )
		return $user_id;
    return $value;
}

//Add More Google font choices
add_filter( 'avf_google_heading_font',  'avia_add_heading_font');
function avia_add_heading_font($fonts)
{
	$fonts['Cinzel'] = 'Cinzel:400,700,900';
	return $fonts;
}

add_filter( 'avf_google_content_font',  'avia_add_content_font');
function avia_add_content_font($fonts)
{
	$fonts['Cinzel'] = 'Cinzel:400,700,900';
	return $fonts;
}

// Add OpenGraph Facebook tags for websites
function fb_opengraph() {
    global $post;
 
    if(is_single()) {
        if(has_post_thumbnail($post->ID)) {
            $img_src = wp_get_attachment_image_src(get_post_thumbnail_id( $post->ID ), 'medium');
        } else {
            $img_src = network_site_url('external-images/agentassets_screenshot.jpg', 'https');
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
    <meta property="og:image" content="<?php echo $img_src[0]; ?>"/>
 
<?php
    } else {
				$img_src = network_site_url('external-images/agentassets_screenshot.jpg', 'https');
				?>
				<meta property="og:title" content="AgentAssets.com - Amazing Real Estate Single Property Websites"/>
		    <meta property="og:description" content="Amazing Single Property Website platform made for your business! Customization, personalization and branding at your fingertips."/>
		    <meta property="og:type" content="website"/>
		    <meta property="og:url" content="<?php echo the_permalink(); ?>"/>
		    <meta property="og:site_name" content="AgentAssets.com"/>
		    <meta property="og:image" content="<?php echo $img_src; ?>"/>
				<?php
        // return;
    }
}
add_action('wp_head', 'fb_opengraph', 5);
