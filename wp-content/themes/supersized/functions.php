<?php

function setup() {

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 825, 510, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu',      'twentyfifteen' ),
		'social'  => __( 'Social Links Menu', 'twentyfifteen' ),
	) );



}

add_action( 'after_setup_theme', 'setup' );

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

// add_action( 'admin_init', 'tgm_envira_remove_header' );
function tgm_envira_remove_header() {

    // Remove the Envira banner
    remove_action( 'in_admin_header', array( Envira_Gallery_Posttype_Admin::get_instance(), 'admin_header' ), 100 );

}

function rebranding_wordpress_logo(){
    global $wp_admin_bar;
    //the following codes is to remove sub menu
    $wp_admin_bar->remove_menu('about');
    $wp_admin_bar->remove_menu('documentation');
    $wp_admin_bar->remove_menu('support-forums');
    $wp_admin_bar->remove_menu('feedback');
    $wp_admin_bar->remove_menu('wporg');


    //and this is to change wordpress logo
    $wp_admin_bar->add_menu( array(
        'id'    => 'wp-logo',
        'title' => '<img src="http://agentassets.com/wp-content/uploads/2016/05/AA_circle-20px.png" />',
        'href'  => __('http://www.agentassets.com/'),
        'meta'  => array(
            'title' => __('Back to AgentAssets.com'),
        ),
    ) );
    //and this is to add new sub menu.
    // $wp_admin_bar->add_menu( array(
    //                 'parent' => 'wp-logo',
    //                 'id'     => 'sub-menu-id-1',
    //                 'title'  => __('Sub Menu 1'),
    //                 'href'  => __('url-for-link-in-sub-menu-1'),
    //         ) );


}
add_action('wp_before_admin_bar_render', 'rebranding_wordpress_logo' );

/**
 * Enqueue scripts and styles.
 *
 * @since Twenty Fifteen 1.0
 */
function scripts() {

        wp_enqueue_script('jquery');

        // Load Bootstrap CSS
        wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css');

        // Load Supersized CSS
        wp_enqueue_style( 'supersized', get_template_directory_uri() . '/css/supersized.css');

        // Load Supersized Shutter CSS
        wp_enqueue_style( 'supersized-shutter', get_template_directory_uri() . '/css/supersized.shutter.css');

	      // Load our main stylesheet.
	      wp_enqueue_style( 'supersized-style', get_stylesheet_uri() );

        // Load Bootstrap JS
        wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js');

        // Load jQuery Easing JS
        wp_enqueue_script( 'jquery-easing', get_template_directory_uri() . '/js/jquery.easing.min.js');

        // Load Supersized JS
        wp_enqueue_script( 'supersized', get_template_directory_uri() . '/js/supersized.min.js');

        // Load Supersized Shutter JS
        wp_enqueue_script( 'supersized-shutter', get_template_directory_uri() . '/js/supersized.shutter.js');

}
add_action( 'wp_enqueue_scripts', 'scripts' );

// add_action( 'init', 'gallery_init' );
/**
 * Register a gallery post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function gallery_init() {
	$labels = array(
		'name'               => _x( 'Gallery', 'gallery', 'supersized' ),
		'singular_name'      => _x( 'Gallery', 'gallery', 'supersized' ),
		'menu_name'          => _x( 'Gallery', 'gallery', 'supersized' ),
		'name_admin_bar'     => _x( 'Gallery', 'gallery', 'supersized' ),
		'add_new'            => _x( 'Add New', 'gallery', 'supersized' ),
		'add_new_item'       => __( 'Add New Gallery', 'supersized' ),
		'new_item'           => __( 'New Gallery', 'supersized' ),
		'edit_item'          => __( 'Edit Gallery', 'supersized' ),
		'view_item'          => __( 'View Gallery', 'supersized' ),
		'all_items'          => __( 'All Gallery', 'supersized' ),
		'search_items'       => __( 'Search Gallery', 'supersized' ),
		'parent_item_colon'  => __( 'Parent Gallery:', 'supersized' ),
		'not_found'          => __( 'No gallery found.', 'supersized' ),
		'not_found_in_trash' => __( 'No gallery found in Trash.', 'supersized' )
	);

	$args = array(
		'labels'             => $labels,
    'description'        => __( 'Description.', 'supersized' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'gallery' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'thumbnail' )
	);

	register_post_type( 'gallery', $args );
}

class wp_bootstrap_navwalker extends Walker_Nav_Menu {
	/**
	 * @see Walker::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul role=\"menu\" class=\" dropdown-menu\">\n";
	}
	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param int $current_page Menu item ID.
	 * @param object $args
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		/**
		 * Dividers, Headers or Disabled
		 * =============================
		 * Determine whether the item is a Divider, Header, Disabled or regular
		 * menu item. To prevent errors we use the strcasecmp() function to so a
		 * comparison that is not case sensitive. The strcasecmp() function returns
		 * a 0 if the strings are equal.
		 */
		if ( strcasecmp( $item->attr_title, 'divider' ) == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="divider">';
		} else if ( strcasecmp( $item->title, 'divider') == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="divider">';
		} else if ( strcasecmp( $item->attr_title, 'dropdown-header') == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="dropdown-header">' . esc_attr( $item->title );
		} else if ( strcasecmp($item->attr_title, 'disabled' ) == 0 ) {
			$output .= $indent . '<li role="presentation" class="disabled"><a href="#">' . esc_attr( $item->title ) . '</a>';
		} else {
			$class_names = $value = '';
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
			if ( $args->has_children )
				$class_names .= ' dropdown';
			if ( in_array( 'current-menu-item', $classes ) )
				$class_names .= ' active';
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
			$output .= $indent . '<li' . $id . $value . $class_names .'>';
			$atts = array();
			$atts['title']  = ! empty( $item->title )	? $item->title	: '';
			$atts['target'] = ! empty( $item->target )	? $item->target	: '';
			$atts['rel']    = ! empty( $item->xfn )		? $item->xfn	: '';
			// If item has_children add atts to a.
			if ( $args->has_children && $depth === 0 ) {
				$atts['href']   		= '#';
				$atts['data-toggle']	= 'dropdown';
				$atts['class']			= 'dropdown-toggle';
				$atts['aria-haspopup']	= 'true';
			} else {
				$atts['href'] = ! empty( $item->url ) ? $item->url : '';
			}
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );
			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}
			$item_output = $args->before;
			/*
			 * Glyphicons
			 * ===========
			 * Since the the menu item is NOT a Divider or Header we check the see
			 * if there is a value in the attr_title property. If the attr_title
			 * property is NOT null we apply it as the class name for the glyphicon.
			 */
			if ( ! empty( $item->attr_title ) )
				$item_output .= '<a'. $attributes .'><span class="glyphicon ' . esc_attr( $item->attr_title ) . '"></span>&nbsp;';
			else
				$item_output .= '<a'. $attributes .'>';
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= ( $args->has_children && 0 === $depth ) ? ' <span class="caret"></span></a>' : '</a>';
			$item_output .= $args->after;
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}
	/**
	 * Traverse elements to create list from elements.
	 *
	 * Display one element if the element doesn't have any children otherwise,
	 * display the element and its children. Will only traverse up to the max
	 * depth and no ignore elements under that depth.
	 *
	 * This method shouldn't be called directly, use the walk() method instead.
	 *
	 * @see Walker::start_el()
	 * @since 2.5.0
	 *
	 * @param object $element Data object
	 * @param array $children_elements List of elements to continue traversing.
	 * @param int $max_depth Max depth to traverse.
	 * @param int $depth Depth of current element.
	 * @param array $args
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return null Null on failure with no changes to parameters.
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( ! $element )
            return;
        $id_field = $this->db_fields['id'];
        // Display this element.
        if ( is_object( $args[0] ) )
           $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
	/**
	 * Menu Fallback
	 * =============
	 * If this function is assigned to the wp_nav_menu's fallback_cb variable
	 * and a manu has not been assigned to the theme location in the WordPress
	 * menu manager the function with display nothing to a non-logged in user,
	 * and will add a link to the WordPress menu manager if logged in as an admin.
	 *
	 * @param array $args passed from the wp_nav_menu function.
	 *
	 */
	public static function fallback( $args ) {
		if ( current_user_can( 'manage_options' ) ) {
			extract( $args );
			$fb_output = null;
			if ( $container ) {
				$fb_output = '<' . $container;
				if ( $container_id )
					$fb_output .= ' id="' . $container_id . '"';
				if ( $container_class )
					$fb_output .= ' class="' . $container_class . '"';
				$fb_output .= '>';
			}
			$fb_output .= '<ul';
			if ( $menu_id )
				$fb_output .= ' id="' . $menu_id . '"';
			if ( $menu_class )
				$fb_output .= ' class="' . $menu_class . '"';
			$fb_output .= '>';
			$fb_output .= '<li><a href="' . admin_url( 'nav-menus.php' ) . '">Add a menu</a></li>';
			$fb_output .= '</ul>';
			if ( $container )
				$fb_output .= '</' . $container . '>';
			echo $fb_output;
		}
	}
}