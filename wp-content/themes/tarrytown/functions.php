<?php
/*
Enfold functions overrides
*/
add_theme_support( 'deactivate_layerslider' );
add_theme_support( 'deactivate_portfolio' );

// include_once( 'includes/custom-theme-customizer/custom-theme-customizer.php' );
// include_once( 'includes/custom-theme-customizer/theme-customizer.php' );
// include_once( 'includes/custom-theme-customizer/customizer-shortcodes.php' );

// add_menu_page('Edit Your Site', 'Edit Site', '10', 'edit-your-site','tarrytown_edit_site','','2');

function tarrytown_edit_site(){
	
}

add_shortcode( 'aa-property-details', 'aa_property_description' );
add_shortcode( 'aa-property-description', 'aa_property_description' );
function aa_property_description() {
	return get_theme_mod( 'aa_property_description' );
}

add_shortcode( 'agentinformation_profile_picture', 'aa_image_setting' );
function aa_image_setting() {
	$agent_image = '<img src="' . get_theme_mod( 'image_setting' ) . '" >';
	return $agent_image;
}


function caption_shortcode( $atts, $content = null ) {
	return '<span class="caption">' . $content . '</span>';
}
add_shortcode( 'caption', 'caption_shortcode' );

$avia_config['imgSize']['slider_post_img'] = array( 'width' => 500,  'height' => 375 ); // for homepage slider using post image

add_action( 'admin_enqueue_scripts', 'load_admin_style' );

function load_admin_style() {
	// wp_register_style( 'admin_css', get_template_directory_uri() . '/admin-style.css', false, '1.0.0' );
	//OR
	wp_enqueue_style( 'admin_css', get_stylesheet_directory_uri() . '/css/admin-style.css', false, '1.0.0' );
}

// function rebranding_wordpress_logo() {

// 	$wp_admin_bar->add_menu( array(
// 		'id'    => 'wp-logo',
// 		'title' => '<img src="http://agentassets.com/wp-content/uploads/2016/05/AA_circle-20px.png" />',
// 		'href'  => __( 'http://www.agentassets.com/' ),
// 		'meta'  => array(
// 			'title' => __( 'Back to AgentAssets.com' ),
// 			),
// 	) );
// }
// add_action( 'wp_before_admin_bar_render', 'rebranding_wordpress_logo' );

function notify_admin_newsite( $msg ) {
	// Extract pertinent information from the message.
	// Maybe a better way to do this? Filter is called after message is assembled...
	preg_match("/New\sSite:\s([^\\n]*)/", $msg, $site_name);
	preg_match("/URL:\s([^\\n]*)/", $msg, $site_url);
	preg_match("/Remote\sIP:\s([^\\n]*)/", $msg, $remote_ip);
	preg_match("/Disable\sthese\snotifications:\s([^\\n]*)/", $msg, $disable_notifications);
	preg_match("!^([a-z])?\.?agentassets\.com$!", $site_url[1], $blog_name);

	$user = get_userdata( get_current_user_id() );
	$blog_details = get_blog_details( $blog_name[1] );
	$options_site_url = esc_url( network_admin_url( 'settings.php' ) );

	$top_description = 'Message from the Admin of AgentAssets.com';
	$email_title = 'A New Site Has Been Created!';
	$email_body = '
	<table>
		<tr>
			<td width="50%"><strong>Created by: </strong></td>
			<td>' . $user->display_name . ' - ( ' . $user->user_login . ' )</td>
		</tr>
		<tr>
			<td><strong>Email: </strong> </td>
			<td>' . $user->user_email . '</td>
		</tr>
		<tr>
			<td><strong>Site Title: </strong></td>
			<td>' . $site_name[1] . '</td>
		</tr>
		<tr>
			<td><strong>URL: </strong></td>
			<td>' . $site_url[1] . '</td>
		</tr>
		<tr>
			<td><strong>Remote IP: </strong></td>
			<td>' . $remote_ip[1] . '</td>
		</tr>
	</table>';

	include_once( dirname(__FILE__ ) . '/includes/aa-email-template.php' );

	return $msg;
}
add_action( 'newblog_notify_siteadmin', 'notify_admin_newsite', 10, 1 );

function custom_broker_styles( $styles = '' ) {

	$styles['Agent Assets'] = array(
		'style' => 'background-color: #559987;',
		'default_font' => 'Open Sans:400,600',
		'google_webfont' => 'Montserrat',
		'color_scheme'  => 'Agent Assets',

		// header
		'colorset-header_color-bg'              => '#559987',
		'colorset-header_color-bg2'             => '#ffffff',
		'colorset-header_color-primary'         => '#559987',
		'colorset-header_color-secondary'       => '#2b7561', //Hovered link color
		'colorset-header_color-color'           => '#316356',
		'colorset-header_color-border'          => '#316356', //#2b7561
		'colorset-header_color-img'             => '',
		'colorset-header_color-customimage'     => '',
		'colorset-header_color-pos'             => 'center center',
		'colorset-header_color-repeat'          => 'repeat',
		'colorset-header_color-attach'          => 'scroll',
		'colorset-header_color-heading'         => '#ffffff',
		'colorset-header_color-meta'            => '#ffffff',

		'colorset-main_color-bg'                => '#ffffff',
		'colorset-main_color-bg2'               => '#fcfcfc',
		'colorset-main_color-primary'           => '#559987',
		'colorset-main_color-secondary'         => '#bf4b11', //maroon button 870000
		'colorset-main_color-color'             => '#666666',
		'colorset-main_color-meta'              => '#222222',
		'colorset-main_color-heading'           => '#000000',
		'colorset-main_color-border'            => '#e1e1e1',
		'colorset-main_color-img'               => '',
		'colorset-main_color-customimage'       => '',
		'colorset-main_color-pos'               => 'center center',
		'colorset-main_color-repeat'            => 'repeat',
		'colorset-main_color-attach'            => 'scroll',

		'colorset-alternate_color-bg'           => '#fcfcfc',
		'colorset-alternate_color-bg2'          => '#000000',
		'colorset-alternate_color-primary'      => '#559987',
		'colorset-alternate_color-secondary'    => '#666666',
		'colorset-alternate_color-color'        => '#666666',
		'colorset-alternate_color-meta'         => '#333333',
		'colorset-alternate_color-heading'      => '#8f8f8f',
		'colorset-alternate_color-border'       => '#e1e1e1',
		'colorset-alternate_color-img'          => '',
		'colorset-alternate_color-customimage'  => '',
		'colorset-alternate_color-pos'          => 'center center',
		'colorset-alternate_color-repeat'       => 'repeat',
		'colorset-alternate_color-attach'       => 'scroll',

		'colorset-footer_color-bg'              => '#222222',
		'colorset-footer_color-bg2'             => '#333333',
		'colorset-footer_color-primary'         => '#ffffff',
		'colorset-footer_color-secondary'       => '#aaaaaa',
		'colorset-footer_color-color'           => '#dddddd',
		'colorset-footer_color-meta'            => '#919191',
		'colorset-footer_color-heading'         => '#919191',
		'colorset-footer_color-border'          => '#444444',
		'colorset-footer_color-img'             => '',
		'colorset-footer_color-customimage'     => '',
		'colorset-footer_color-pos'             => 'center center',
		'colorset-footer_color-repeat'          => 'repeat',
		'colorset-footer_color-attach'          => 'scroll',

		'colorset-socket_color-bg'              => '#333333',
		'colorset-socket_color-bg2'             => '#555555',
		'colorset-socket_color-primary'         => '#ffffff',
		'colorset-socket_color-secondary'       => '#aaaaaa',
		'colorset-socket_color-color'           => '#eeeeee',
		'colorset-socket_color-meta'            => '#999999',
		'colorset-socket_color-heading'         => '#ffffff',
		'colorset-socket_color-border'          => '#444444',
		'colorset-socket_color-img'             => '',
		'colorset-socket_color-customimage'     => '',
		'colorset-socket_color-pos'             => 'center center',
		'colorset-socket_color-repeat'          => 'repeat',
		'colorset-socket_color-attach'          => 'scroll',

		//body bg
		'color-body_style'                      => 'stretched',
		// not applicable if above is 'stretched'
		'color-body_color'                      => '#000000',
		'color-body_attach'                     => 'scroll',
		'color-body_repeat'                     => 'no-repeat',
		'color-body_pos'                        => 'top center',
		'color-body_customimage'                => '',
		);

	$styles['KW Luxury'] = array(
		'style' => 'background-color:#b40000;',
		'default_font' => 'Open Sans:400,600',
		'google_webfont' => 'Open Sans:400,600',
		'color_scheme'	=> 'Keller Williams',

		// header
		'colorset-header_color-bg'				=> '#ffffff',
		'colorset-header_color-bg2'			 	=> '#f8f8f8',
		'colorset-header_color-primary'		 	=> '#b40000',
		'colorset-header_color-secondary'	 	=> '#870000', //Hovered link color
		'colorset-header_color-color'		 	=> '#333333',
		'colorset-header_color-border'		 	=> '#e1e1e1',
		'colorset-header_color-img'			 	=> '',
		'colorset-header_color-customimage'	 	=> '',
		'colorset-header_color-pos' 		 	=> 'center center',
		'colorset-header_color-repeat' 		 	=> 'repeat',
		'colorset-header_color-attach' 		 	=> 'scroll',
		'colorset-header_color-heading' 		=> '#000000',
		'colorset-header_color-meta' 			=> '#808080',

		// main
		'colorset-main_color-bg'			 	=> '#ffffff',
		'colorset-main_color-bg2'			 	=> '#e3e3e3', //Hilight box bg color
		'colorset-main_color-primary'	 	 	=> '#b40000', //Link color
		'colorset-main_color-secondary'	 	 	=> '#870000', //Hovered link color
		'colorset-main_color-color'		 	 	=> '#111111', //Main content font color
		'colorset-main_color-border'	 	 	=> '#919191', //Border colors
		'colorset-main_color-img'			 	=> '',
		'colorset-main_color-customimage'	 	=> '',
		'colorset-main_color-pos' 			 	=> 'center center',
		'colorset-main_color-repeat' 		 	=> 'repeat',
		'colorset-main_color-attach' 		 	=> 'scroll',
		'colorset-main_color-heading' 			=> '#000000',//Heading color
		'colorset-main_color-meta' 				=> '#919191', //Secondary font color

		// alternate
		'colorset-alternate_color-bg'		 	=> '#ebebeb',
		'colorset-alternate_color-bg2'		 	=> '#fadfdf', //Alt hilight box bg color
		'colorset-alternate_color-primary'	 	=> '#b40000',
		'colorset-alternate_color-secondary' 	=> '#f7bebe', // hovered link
		'colorset-alternate_color-color'	 	=> '#666666', // Alt Content font color
		'colorset-alternate_color-border'	 	=> '#b40000', //border colors
		'colorset-alternate_color-img'		 	=> '',
		'colorset-alternate_color-customimage'	=> '',
		'colorset-alternate_color-pos' 		 	=> 'center center',
		'colorset-alternate_color-repeat' 	 	=> 'repeat',
		'colorset-alternate_color-attach' 	 	=> 'scroll',
		'colorset-alternate_color-heading' 		=> '#b40000',
		'colorset-alternate_color-meta' 		=> '#333333', //

		// Footer
		'colorset-footer_color-bg'			 	=> '#222222',
		'colorset-footer_color-bg2'			 	=> '#111111',
		'colorset-footer_color-primary'		 	=> '#aaaaaa',
		'colorset-footer_color-secondary'	 	=> '#ffffff',
		'colorset-footer_color-color'		 	=> '#aaaaaa',
		'colorset-footer_color-border'		 	=> '#555555',
		'colorset-footer_color-img'			 	=> '',
		'colorset-footer_color-customimage'	 	=> '',
		'colorset-footer_color-pos' 		 	=> 'center center',
		'colorset-footer_color-repeat' 		 	=> 'repeat',
		'colorset-footer_color-attach' 		 	=> 'scroll',
		'colorset-footer_color-heading' 		=> '#888888',
		'colorset-footer_color-meta' 			=> '#888888',

		// Socket
		'colorset-socket_color-bg'			 	=> '#333333',
		'colorset-socket_color-bg2'			 	=> '#000000',
		'colorset-socket_color-primary'		 	=> '#ffffff',
		'colorset-socket_color-secondary'	 	=> '#eeeeee',
		'colorset-socket_color-color'		 	=> '#eeeeee',
		'colorset-socket_color-border'		 	=> '#333333',
		'colorset-socket_color-img'			 	=> '',
		'colorset-socket_color-customimage'	 	=> '',
		'colorset-socket_color-pos' 		 	=> 'center center',
		'colorset-socket_color-repeat' 		 	=> 'repeat',
		'colorset-socket_color-attach' 		 	=> 'scroll',
		'colorset-socket_color-heading' 		=> '#ffffff',
		'colorset-socket_color-meta' 			=> '#999999',

		//body bg
		'color-body_style'						=> 'boxed',
		'color-body_color'						=> '#000000',
		'color-body_attach'						=> 'scroll',
		'color-body_repeat'						=> 'no-repeat',
		'color-body_pos'						=> 'top center',
		"color-body_img"						=> AVIA_BASE_URL . "images/background-images/fullsize-grunge.jpg",
		'color-body_customimage'				=> '',
		);

	$styles['Moreland'] = array(
		'style' => 'background-color: #8DC63F;',
		'default_font' => 'Open Sans:400,600',
		'google_webfont' => 'Montserrat',
		'color_scheme'	=> 'Moreland',

		// header
		'colorset-header_color-bg'				=> '#8DC63F',
		'colorset-header_color-bg2'			 	=> '#f8f8f8',
		'colorset-header_color-primary'		 	=> '#688a36',
		'colorset-header_color-secondary'	 	=> '#e0e0e0', //Hovered link color
		'colorset-header_color-color'		 	=> '#333333',
		'colorset-header_color-border'		 	=> '#8DC63F',
		'colorset-header_color-img'			 	=> '',
		'colorset-header_color-customimage'	 	=> '',
		'colorset-header_color-pos' 		 	=> 'center center',
		'colorset-header_color-repeat' 		 	=> 'repeat',
		'colorset-header_color-attach' 		 	=> 'scroll',
		'colorset-header_color-heading' 		=> '#000000',
		'colorset-header_color-meta' 			=> '#ffffff',

		// main
		'colorset-main_color-bg'			 	=> '#ffffff',
		'colorset-main_color-bg2'			 	=> '#e3e3e3', //Hilight box bg color
		'colorset-main_color-primary'	 	 	=> '#b40000', //Link color
		'colorset-main_color-secondary'	 	 	=> '#870000', //Hovered link color
		'colorset-main_color-color'		 	 	=> '#111111', //Main content font color
		'colorset-main_color-border'	 	 	=> '#919191', //Border colors
		'colorset-main_color-img'			 	=> '',
		'colorset-main_color-customimage'	 	=> '',
		'colorset-main_color-pos' 			 	=> 'center center',
		'colorset-main_color-repeat' 		 	=> 'repeat',
		'colorset-main_color-attach' 		 	=> 'scroll',
		'colorset-main_color-heading' 			=> '#000000',//Heading color
		'colorset-main_color-meta' 				=> '#919191', //Secondary font color

		// alternate
		'colorset-alternate_color-bg'		 	=> '#f0f0f0',
		'colorset-alternate_color-bg2'		 	=> '#e7f0da', //Alt hilight box bg color
		'colorset-alternate_color-primary'	 	=> '#8ec63f',
		'colorset-alternate_color-secondary' 	=> '#8ec63f', // hovered link
		'colorset-alternate_color-color'	 	=> '#333333', // Alt Content font color
		'colorset-alternate_color-border'	 	=> '#8ec63f', //border colors
		'colorset-alternate_color-img'		 	=> '',
		'colorset-alternate_color-customimage'	=> '',
		'colorset-alternate_color-pos' 		 	=> 'center center',
		'colorset-alternate_color-repeat' 	 	=> 'repeat',
		'colorset-alternate_color-attach' 	 	=> 'scroll',
		'colorset-alternate_color-heading' 		=> '#8ec63f',
		'colorset-alternate_color-meta' 		=> '#000000', //

		// Footer
		'colorset-footer_color-bg'			 	=> '#222222',
		'colorset-footer_color-bg2'			 	=> '#111111',
		'colorset-footer_color-primary'		 	=> '#aaaaaa',
		'colorset-footer_color-secondary'	 	=> '#ffffff',
		'colorset-footer_color-color'		 	=> '#aaaaaa',
		'colorset-footer_color-border'		 	=> '#555555',
		'colorset-footer_color-img'			 	=> '',
		'colorset-footer_color-customimage'	 	=> '',
		'colorset-footer_color-pos' 		 	=> 'center center',
		'colorset-footer_color-repeat' 		 	=> 'repeat',
		'colorset-footer_color-attach' 		 	=> 'scroll',
		'colorset-footer_color-heading' 		=> '#888888',
		'colorset-footer_color-meta' 			=> '#888888',

		// Socket
		'colorset-socket_color-bg'			 	=> '#333333',
		'colorset-socket_color-bg2'			 	=> '#000000',
		'colorset-socket_color-primary'		 	=> '#ffffff',
		'colorset-socket_color-secondary'	 	=> '#eeeeee',
		'colorset-socket_color-color'		 	=> '#eeeeee',
		'colorset-socket_color-border'		 	=> '#333333',
		'colorset-socket_color-img'			 	=> '',
		'colorset-socket_color-customimage'	 	=> '',
		'colorset-socket_color-pos' 		 	=> 'center center',
		'colorset-socket_color-repeat' 		 	=> 'repeat',
		'colorset-socket_color-attach' 		 	=> 'scroll',
		'colorset-socket_color-heading' 		=> '#ffffff',
		'colorset-socket_color-meta' 			=> '#999999',

		//body bg
		'color-body_style'						=> 'boxed',
		'color-body_color'						=> '#000000',
		'color-body_attach'						=> 'scroll',
		'color-body_repeat'						=> 'no-repeat',
		'color-body_pos'						=> 'top center',
		"color-body_img"						=> AVIA_BASE_URL . "images/background-images/fullsize-grunge.jpg",
		'color-body_customimage'				=> '',
		);
	return $styles;
}

add_filter( 'avf_skin_options', 'custom_broker_styles' );

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

add_action('init','avia_remove_debug');
function avia_remove_debug(){
	remove_action('wp_head','avia_debugging_info',1000);
	remove_action('admin_print_scripts','avia_debugging_info',1000);
}

add_action( 'admin_menu', 'admin_edit_site_link');

function admin_edit_site_link(){
	add_menu_page( null, 'Edit Your Site', 'edit_pages', '/post.php?post=554&action=edit', null, '', 1 );
}
