<?php function change_bar_color() { ?>

<style>
    #wpadminbar {
        background: #559987 !important;
    }
    div.avia_section_header.goto_update,
    div.avia_section_header.goto_upload,
    div.avia_section_header.goto_demo,
    div.avia_section_header.goto_google,
    div.avia_section_header.goto_layout,
    div.avia_section_header.goto_menu,
    div.avia_section_header.goto_header,
    div.avia_section_header.goto_sidebars,
    div.avia_section_header.goto_footer,
    div.avia_section_header.goto_builder,
    div.avia_section_header.goto_blog{ 
        display: none !important;
    }
</style>

<?php

}



// Change Admin Bar menu items add/remove
function aa_admin_bar_render() {
  
  if (!is_super_admin()) {
    
    global $wp_admin_bar;

    // REMOVE ITEMS
    $wp_admin_bar->remove_menu( 'comments' );
    $wp_admin_bar->remove_node( 'new-content' );
    $wp_admin_bar->remove_node( 'updates' );
    $wp_admin_bar->remove_node( 'my-sites' );
    $wp_admin_bar->remove_menu( 'about' );
    $wp_admin_bar->remove_menu( 'wporg' );            // Remove the WordPress.org link
    $wp_admin_bar->remove_menu( 'documentation' );    // Remove the WordPress documentation link
    $wp_admin_bar->remove_menu( 'support-forums' );   // Remove the support forums link
    $wp_admin_bar->remove_menu( 'feedback' );
    $wp_admin_bar->remove_menu( 'my-account' ); // Remove manage account 
    $wp_admin_bar->remove_menu( 'wplv-menu' ); // Remove WP Log Viewer
    $wp_admin_bar->remove_menu( 'site-name' ); // Remove WP Log Viewer
    $wp_admin_bar->remove_menu( 'google');
    $wp_admin_bar->remove_menu( 'update');
    $wp_admin_bar->remove_menu( 'demo');
    $wp_admin_bar->remove_menu( 'upload');
    $wp_admin_bar->remove_menu( 'sidebars');
    
    // ADD items
    $user = wp_get_current_user();
    
    //ADD My Sites Link
    $wp_admin_bar->add_menu( array(
		'parent' => false, 
		'id' => 'my-aa-sites',
		'title' => __('My Sites'), 
		'href' => network_site_url('members/'.$user->user_login.'/sites/'),
		'meta' => false // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', target => '', title => '' );
  	));
    
    /* Adds 'Printables' for users to upload documents to their sites - White Labeled WPYog Documents Plugin */
    $wp_admin_bar->add_menu( array(
		'parent' => false, 
		'id' => 'printables', 
		'title' => __('Printables'),
		'href' => admin_url( 'admin.php?page=aa_all_document'), 
		'meta' => false // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', target => '', title => '' );
  	));
    
    /* Adds Edit Main Menu */
    // $query['autofocus[section]'] = 'nav_menu';
    // $panel_link = add_query_arg( $query, admin_url( 'customize.php' ) );
    $wp_admin_bar->add_menu( array(
		'parent' => false, 
		'id' => 'edit-menu',
		'title' => __('Edit Main Menu'),
		'href' => admin_url( 'customize.php?autofocus%5Bsection%5D=nav_menu[2]' ),
		'meta' => false // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', target => '', title => '' );
  	));
    
  }
}

function remove_dashboard_widgets () {
  
  remove_meta_box('dashboard_quick_press','dashboard','side'); //Quick Press widget
  remove_meta_box('dashboard_recent_drafts','dashboard','side'); //Recent Drafts
  remove_meta_box('dashboard_primary','dashboard','side'); //WordPress.com Blog
  remove_meta_box('dashboard_secondary','dashboard','side'); //Other WordPress News
  remove_meta_box('dashboard_incoming_links','dashboard','normal'); //Incoming Links
  remove_meta_box('dashboard_plugins','dashboard','normal'); //Plugins
  remove_meta_box('dashboard_right_now','dashboard', 'normal'); //Right Now
  remove_meta_box('rg_forms_dashboard','dashboard','normal'); //Gravity Forms
  remove_meta_box('dashboard_recent_comments','dashboard','normal'); //Recent Comments
  remove_meta_box('icl_dashboard_widget','dashboard','normal'); //Multi Language Plugin
  remove_meta_box('dashboard_activity','dashboard', 'normal'); //Activity
  remove_meta_box(''); // Remove Publish meta box from the right side of page edit
  remove_action('welcome_panel','wp_welcome_panel');
  

}

function remove_admin_menuitems() {
  
  if (!is_super_admin()) {
    
    // Main Menu items to remove  
    remove_menu_page( 'edit.php' );            // Posts
    remove_menu_page( 'edit-comments.php' );   // Comments
    remove_menu_page( 'tools.php' );           // Tools
    remove_menu_page( 'options-general.php' ); // Settings
    remove_menu_page( 'link-manager.php' ); // Settings
    remove_menu_page( 'edit.php?post_type=portfolio' ); // Settings
    remove_menu_page( 'admin.php?page=revslider' ); // Remove Revolution Slider
    remove_menu_page( 'admin.php?page=avia' ); // Remove Enfold Theme settings from Left
    remove_menu_page( 'admin.php?page=et_divi_options'); // Remove the DIVI left menu item
    // Submenu items to remove
    remove_submenu_page( 'index.php', 'my-sites.php' );
    remove_submenu_page( 'themes.php', 'widgets.php' );
    remove_submenu_page( 'themes.php', 'nav-menus.php' );
    
  }
}

//Hide admin footer from admin
function change_footer_admin () {
  return '<div style="text-align: center;padding: 20px 10px;color: #fff;background-color: #559987;border:1px solid #275851"><strong>AgentAssets.com - <em>an Austin company!</em></strong><br>Thanks for using us for your single property websites. <br> Recommend us to your workmates!</div>';
}


/* ADDS Link to Backend to Edit DIVI Site */
function add_edit_site_link(){
    global $wp_admin_bar;
    
    $use_visual_builder_url = add_query_arg( 'et_fb', '1', wp_get_referer() );
	
    $wp_admin_bar->add_menu( array(
        'parent' => false,
		'id'    => 'et-use-visual-builder',
		'title' => esc_html__( 'Enable Visual Builder', 'et_builder' ),
		'href'  => esc_url( $use_visual_builder_url ),
        'meta' => false
	) );
}

function change_footer_version() {
  return ' ';
}

function theme_customize_register( $wp_customize ) {

 //=============================================================
 // Remove header image and widgets option from theme customizer
 //=============================================================
 // $wp_customize->remove_control("header_image");
 // $wp_customize->remove_panel("widgets");

 //=============================================================
 // Remove Colors, Background image, and Static front page 
 // option from theme customizer     
 //=============================================================
 $wp_customize->remove_section("blogdescription");
 // $wp_customize->remove_section("background_image");
 $wp_customize->remove_section("static_front_page");

}

function show_hide_admin_bar(){
    // Get current blog ID
    $blog_id = get_current_blog_id();
    $user = wp_get_current_user();
    $is_member = is_user_member_of_blog( $user->ID, $blog_id );
    if( $is_member ){ // If the user is a member do this stuff
        $roles = array('author','administrator');
        if ( array_intersect($roles, $user->roles) || current_user_can('manage_options') ){
        // if ( in_array( 'author', 'administrator', (array) $user->roles ) || current_user_can('manage_options') ) {
            /*The user has the "author" or "administrator" role
            admin_bar should show automatically.
            */
        }else{
            // Does not have permissions to show admin_bar. Hide it!
            add_filter( 'show_admin_bar', '__return_false');
        }
    }else{
        //Not a member of this site. Hide admin_bar!
        add_filter( 'show_admin_bar', '__return_false');
    }
}
    
// add_action('wp_dashboard_setup', 'remove_dashboard_widgets');

add_action( 'admin_menu', 'remove_admin_menuitems');
add_action( 'wp_before_admin_bar_render', 'aa_admin_bar_render' );
add_filter( 'update_footer', 'change_footer_version', 9999);

/* ADMIN MENU - IF FRONTEND */
add_action( 'wp_head', 'change_bar_color');

/* ADMIN MENU - IF BACKEND */
add_action( 'admin_head', 'change_bar_color', 10);
// add_action( 'admin_head', 'add_edit_site_link',10);

// add_filter('admin_footer_text', 'change_footer_admin', 9999);
add_action( "customize_register", "theme_customize_register" );
add_action( "init", "show_hide_admin_bar");
