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


/*
 * Display Property Details Page
 */
/*
add_shortcode('display_property_details', 'property_details');
function property_details()
{
    ?>
    <div class="row property-details">
        <div class="col-sm-12">
            <div class="col-sm-4">
                <h3 class="heading">Facts & Figures</h3>
                <ul class="details">
                    <li>
                        <label>Price:</label>
                        <span><?php echo get_option('property_price'); ?></span>
                    </li>
                    <li>
                        <label>Type:</label>
                        <span><?php echo get_option('property_type'); ?></span>
                    </li>
                    <li>
                        <label>MLS#:</label>
                        <span><?php echo get_option('property_mls'); ?></span>
                    </li>
                    <li>
                        <label>Area:</label>
                        <span><?php echo get_option('property_area'); ?></span>
                    </li>
                    <li>
                        <label>Bedrooms:</label>
                        <span><?php echo get_option('property_bedrooms'); ?></span>
                    </li>
                    <li>
                        <label>Baths:</label>
                        <span><?php echo get_option('property_baths'); ?></span>
                    </li>
                    <li>
                        <label>Living Areas:</label>
                        <span><?php echo get_option('property_living_areas'); ?></span>
                    </li>
                    <li>
                        <label>Square Feet:</label>
                        <span><?php echo get_option('property_square_feet'); ?></span>
                    </li>
                    <li>
                        <label>School District:</label>
                        <span><?php echo get_option('property_school_district'); ?></span>
                    </li>

                    <li>
                        <label>View:</label>
                        <span><?php echo get_option('property_view'); ?></span>
                    </li>
                    <li>
                        <label>Garages:</label>
                        <span><?php echo get_option('property_garages'); ?></span>
                    </li>
                    <li>
                        <label>Year Built:</label>
                        <span><?php echo get_option('property_year_built'); ?></span>
                    </li>
                    <li>
                        <label>Lot Size:</label>
                        <span><?php echo get_option('property_lot_size'); ?></span>
                    </li>
                    <li>
                        <label>Acreage:</label>
                        <span><?php echo get_option('property_acreage'); ?></span>
                    </li>
                </ul>
            </div>
            <div class="col-sm-8">
                <h3 class="heading">Property Description</h3>
                <?php echo get_option('property_description');?>
                <div class="property-tour-links">
                    <h3>Tour</h3>
                    <ul class="tour-links">
                        <?php
                        if(get_option('property_tour_link1'))
                        {
                            ?>
                            <li><a href="<?php echo get_option('property_tour_link1');?>"><?php echo get_option('property_tour_link1');?></a></li>
                            <?php
                        }
                        if(get_option('property_tour_link2'))
                        {
                            ?>
                            <li><a href="<?php echo get_option('property_tour_link2');?>"><?php echo get_option('property_tour_link2');?></a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php
}
*/

/*
 * @package Theme Settings | Customizer
 * @since 05/11/2015
 * @author MG
 *
 */



/*add_action( 'admin_menu', 'custom_theme_options_menu' );
//add_action( 'admin_menu', 'custom_admin_scripts' );


function custom_theme_options_menu() {

    add_menu_page('Agent Information', 'Theme Options', 'manage_options', 'mi-top-level-handle', 'mi_theme_options' );

    add_submenu_page('mi-top-level-handle', 'Agent Information', 'Agent Information' , 'manage_options', 'mi-sub-agent-information', 'mi_sub_agent_information');

    add_submenu_page('mi-top-level-handle', 'Property Details', 'Property Details' , 'manage_options', 'mi-sub-property-details', 'mi_sub_property_details');
    add_submenu_page('mi-top-level-handle', 'Printable Info', 'Printable Info' , 'manage_options', 'mi-sub-printable-info', 'mi_sub_printable_info');
    add_submenu_page('mi-top-level-handle', 'Contact Info', 'Contact Info' , 'manage_options', 'mi-sub-contact-details', 'mi_sub_contact_details');
    add_submenu_page('mi-top-level-handle', 'Meta Info', 'Meta Info' , 'manage_options', 'mi-sub-meta-info', 'mi_sub_meta_information');

}


function mi_sub_meta_information(){

     if(isset($_POST['submit']))
    {
        $input_meta_keywords = $_POST['meta_keywords'];
        update_option('meta_keywords', $input_meta_keywords);
        $meta_keywords = get_option('meta_keywords');

        $input_meta_description = $_POST['meta_description'];
        update_option('meta_description', $input_meta_description);
       $meta_description = get_option('meta_description');

    }
    $meta_keywords = get_option('meta_keywords');
    $meta_description = get_option('meta_description');

    ?>
    <div class="wrap">
            <h1>Meta Information</h1>

            <form method="post" action="" novalidate="novalidate">

                <table class="form-table">
                    <tbody>

                        <tr>
                            <th scope="row">
                                <label for="meta_keywords">Meta Keywords</label>
                            </th>
                            <td>
                               <textarea name="meta_keywords" cols="50" rows="10"><?php if(isset($meta_keywords)){ echo $meta_keywords; }?></textarea>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="meta_description">Meta Description</label>
                            </th>
                            <td>
                                <textarea name="meta_description" cols="50" rows="10"><?php echo $meta_description; ?></textarea>
                            </td>
                        </tr>

                    </tbody>
                </table>
                <p class="submit">
                    <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
                </p>
            </form>
    </div>
    <?php


}


function mi_sub_property_details(){

    if(isset($_POST['submit']))
    {
        $input_property_description = addslashes($_POST['property_description']);

        update_option('property_description', $input_property_description);
        $property_description = stripslashes(get_option('property_description',true));

        $input_property_price_type = $_POST['property_price_type'];
        update_option('property_price_type', $input_property_price_type);
        $property_price_type = get_option('property_price_type',true);

        $input_property_price = $_POST['property_price'];
        update_option('property_price', $input_property_price);
        $property_price = get_option('property_price',true);


        $property_price_min = $_POST['property_price1'];
        update_option('property_price1', $property_price_min);
        $property_price_min = get_option('property_price1',true);


        $property_price_max = $_POST['property_price2'];
        update_option('property_price2', $property_price_max);
        $property_price_max = get_option('property_price2',true);


        $input_property_type = $_POST['property_type'];
        update_option('property_type', $input_property_type);
        $property_type = get_option('property_type',true);


        $input_property_mls = $_POST['property_mls'];
        update_option('property_mls', $input_property_mls);
        $property_mls = get_option('property_mls',true);

        $input_property_area = $_POST['property_area'];
        update_option('property_area', $input_property_area);
        $property_area = get_option('property_area',true);

        $input_property_bedrooms = $_POST['property_bedrooms'];
        update_option('property_bedrooms', $input_property_bedrooms);
        $property_bedrooms = get_option('property_bedrooms',true);


        $input_property_baths = $_POST['property_baths'];
        update_option('property_baths', $input_property_baths);
        $property_baths = get_option('property_baths',true);


        $input_property_living_areas = $_POST['property_living_areas'];
        update_option('property_living_areas', $input_property_living_areas);
        $property_living_areas = get_option('property_living_areas',true);


        $input_property_square_feet = $_POST['property_square_feet'];
        update_option('property_square_feet', $input_property_square_feet);
        $property_square_feet = get_option('property_square_feet',true);


        $input_property_school_district = $_POST['property_school_district'];
        update_option('property_school_district', $input_property_school_district);
        $property_school_district = get_option('property_school_district',true);

        $input_property_view = $_POST['property_view'];
        update_option('property_view', $input_property_view);
        $property_view = get_option('property_view',true);


        $input_property_garages = $_POST['property_garages'];
        update_option('property_garages', $input_property_garages);
        $property_garages = get_option('property_garages',true);


        $input_property_year_built = $_POST['property_year_built'];
        update_option('property_year_built', $input_property_year_built);
        $property_year_built = get_option('property_year_built',true);

        $input_property_lot_size = $_POST['property_lot_size'];
        update_option('property_lot_size', $input_property_lot_size);
        $property_lot_size = get_option('property_lot_size',true);

        $input_property_acreage = $_POST['property_acreage'];
        update_option('property_acreage', $input_property_acreage);
        $property_acreage = get_option('property_acreage',true);

        $input_property_tour_link1 = $_POST['property_tour_link1'];
        update_option('property_tour_link1', $input_property_tour_link1);
        $property_tour_link1 = get_option('property_tour_link1',true);

        $input_property_tour_link2 = $_POST['property_tour_link2'];
        update_option('property_tour_link2', $input_property_tour_link2);
        $property_tour_link2 = get_option('property_tour_link2',true);


    }
     $property_desc_rawdata = get_option('property_description',true);
     $property_description = stripslashes($property_desc_rawdata);
     $property_price_type = get_option('property_price_type',true);
     $property_price = get_option('property_price',true);
     $property_price_min = get_option('property_price1',true);
     $property_price_max = get_option('property_price2',true);
     $property_type = get_option('property_type',true);
     $property_mls = get_option('property_mls',true);
     $property_area = get_option('property_area',true);
     $property_bedrooms = get_option('property_bedrooms',true);
     $property_baths = get_option('property_baths',true);
     $property_living_areas = get_option('property_living_areas',true);
     $property_square_feet = get_option('property_square_feet',true);
     $property_school_district = get_option('property_school_district',true);
     $property_view = get_option('property_view',true);
     $property_garages = get_option('property_garages',true);
     $property_year_built = get_option('property_year_built',true);
     $property_lot_size = get_option('property_lot_size',true);
     $property_acreage = get_option('property_acreage',true);
     $property_tour_link1 = get_option('property_tour_link1',true);
      $property_tour_link2 = get_option('property_tour_link2',true);

    ?>
     <div class="wrap">
            <h1>Property Details</h1>

            <form method="post" action="" novalidate="novalidate">

                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <label for="agentname">Property Description</label>
                            </th>
                            <td>
                                <?php wp_editor(stripslashes($property_description), 'property_description');?>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="property_price_type">Price Type</label>
                            </th>
                            <td>
                                <select name="property_price_type" id="property_price_type">
                                    <option value="">Select Price Type</option>
                                   <?php if (get_option('property_price_type') == "fixed") {
                                       echo"selected fixed";?>
                                    <option value="fixed" selected="selected">Fixed</option>
                                    <?php }else{
                                        echo "non selected";?>
                                        <option value="fixed">Fixed</option>
                                 <?php   } ?>
                                        <?php if (get_option('property_price_type') == "range") { ?>
                                    <option value="range" selected="selected">Range</option>
                                    <?php }else{?>
                                        <option value="range">Range</option>
                                 <?php   } ?>

                                </select>
                            </td>
                        </tr>

                        <tr id="fixed-price-type">
                            <th scope="row">
                                <label for="property_price">Price</label>
                            </th>
                            <td>
                                <input name="property_price" type="text" id="property_price" value="<?php if(isset($property_price)){ echo $property_price; }?>" class="regular-text">
                            </td>
                        </tr>

                        <tr id="range-price-type-min">
                            <th scope="row">
                                <label for="property_price1">Min. Price</label>
                            </th>
                            <td>
                                <input name="property_price1" type="text" id="property_price1" value="<?php if(isset($property_price_min)){ echo $property_price_min; }?>" class="regular-text">
                            </td>
                        </tr>
                        <tr id="range-price-type-max">
                            <th scope="row">
                                <label for="property_price2">Max. Price</label>
                            </th>
                            <td>
                                <input name="property_price2" type="text" id="property_price2" value="<?php if(isset($property_price_max)){ echo $property_price_max; }?>" class="regular-text">
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="property_type">Type:</label>
                            </th>
                            <td>
                                <input name="property_type" type="text" id="property_type" value="<?php if(isset($property_type)){ echo $property_type; }?>" class="regular-text">
                            </td>
                        </tr>

                         <tr>
                            <th scope="row">
                                <label for="property_mls">MLS#:</label>
                            </th>
                            <td>
                                <input name="property_mls" type="text" id="property_mls" value="<?php if(isset($property_mls)){ echo $property_mls; }?>" class="regular-text">
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="property_area">Area:</label>
                            </th>
                            <td>
                                <input name="property_area" type="text" id="property_area" value="<?php if(isset($property_area)){ echo $property_area; }?>" class="regular-text">
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="property_bedrooms">Bedrooms:</label>
                            </th>
                            <td>
                                <input name="property_bedrooms" type="text" id="property_bedrooms" value="<?php if(isset($property_bedrooms)){ echo $property_bedrooms; }?>" class="regular-text">
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="property_baths">Baths:</label>
                            </th>
                            <td>
                                <input name="property_baths" type="text" id="property_baths" value="<?php if(isset($property_baths)){ echo $property_baths; }?>" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="property_living_areas">Living Areas:</label>
                            </th>
                            <td>
                                <input name="property_living_areas" type="text" id="property_living_areas" value="<?php if(isset($property_living_areas)){ echo $property_living_areas; }?>" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="property_square_feet">Square Feet:</label>
                            </th>
                            <td>
                                <input name="property_square_feet" type="text" id="property_square_feet" value="<?php if(isset($property_square_feet)){ echo $property_square_feet; }?>" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="property_school_district">School District:</label>
                            </th>
                            <td>
                                <input name="property_school_district" type="text" id="property_school_district" value="<?php if(isset($property_school_district)){ echo $property_school_district; }?>" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="property_view">View:</label>
                            </th>
                            <td>
                                <input name="property_view" type="text" id="property_view" value="<?php if(isset($property_view)){ echo $property_view; }?>" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="property_garages">Garages:</label>
                            </th>
                            <td>
                                <input name="property_garages" type="text" id="property_garages" value="<?php if(isset($property_garages)){ echo $property_garages; }?>" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="property_year_built">Year Built:</label>
                            </th>
                            <td>
                                <input name="property_year_built" type="text" id="property_year_built" value="<?php if(isset($property_year_built)){ echo $property_year_built; }?>" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="property_lot_size">Lot Size:</label>
                            </th>
                            <td>
                                <input name="property_lot_size" type="text" id="property_lot_size" value="<?php if(isset($property_lot_size)){ echo $property_lot_size; }?>" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="property_acreage">Acreage:</label>
                            </th>
                            <td>
                                <input name="property_acreage" type="text" id="property_acreage" value="<?php if(isset($property_acreage)){ echo $property_acreage; }?>" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="property_tour_link1">Tour Link1:</label>
                            </th>
                            <td>
                                <input name="property_tour_link1" type="text" id="property_tour_link1" value="<?php if(isset($property_tour_link1)){ echo $property_tour_link1; }?>" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="property_tour_link2">Tour Link2:</label>
                            </th>
                            <td>
                                <input name="property_tour_link2" type="text" id="property_tour_link2" value="<?php if(isset($property_tour_link2)){ echo $property_tour_link2; }?>" class="regular-text">
                            </td>
                        </tr>

                </table>
                <p class="submit">
                    <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
                </p>
            </form>
     </div>
    <?php

}







function mi_sub_printable_info(){

     if(isset($_POST['submit']))
    {

         // Check that the nonce is valid, and the user can edit this post.
        if (    isset( $_POST['printable_image_upload_nonce'] )    && wp_verify_nonce( $_POST['printable_image_upload_nonce'], 'printable_image_upload' ))
        {
               require_once( ABSPATH . 'wp-admin/includes/file.php' );

               $file = $_FILES['printable_image_upload'];

               $overrides = array(
                        'test_form' => false,
                        'test_size' => true,
                        'test_upload' => true,
                );

               $printable_image_results = wp_handle_sideload( $file, $overrides );

                if (!empty($printable_image_results['error'])) {
                        // insert any error handling here
                } else {
                        update_option('printable_image', $printable_image_results['url']);
                        // perform any actions here based in the above results
                }

       } else {

               // The security check failed, maybe show the user an error.
       }

        $input_printable_text = addslashes($_POST['printable_text']);

        update_option('printable_text', $input_printable_text);
        $printable_text = stripslashes(get_option('printable_text'));
        $printable_image = get_option('printable_image');
    }
    $printable_text = stripslashes(get_option('printable_text'));
     $printable_image = get_option('printable_image');

     ?>

     <div class="wrap">
            <h1>Printable Info</h1>

            <form method="post" action="" novalidate="novalidate" enctype="multipart/form-data">

                <table class="form-table">
                    <tbody>

                        <tr>
                            <th scope="row">
                                <label for="printable_image">Printable Image</label>
                            </th>
                            <td>
                                <img src="<?php echo $printable_image; ?>" style="width: auto; height: 100px;"/>
                                <input type="file" name="printable_image_upload" id="printable_image_upload"  multiple="false" />
                                <?php wp_nonce_field( 'printable_image_upload', 'printable_image_upload_nonce' ); ?>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="printable_text">Printable Text</label>
                            </th>
                            <td>
                                <?php if(isset($printable_text)){ wp_editor($printable_text, 'printable_text'); }?>
                            </td>
                         </tr>
                         <tr>

                             <td><h3>Note:</h3> </td>
                            <td><a href="<?php echo admin_url('edit.php?post_type=printable_info'); ?>">Click Here</a> to add attachments to Printable Info</td>

                         </tr>

                    </tbody>
                </table>
                <p class="submit">
                    <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
                </p>
            </form>
    </div>
    <?php
}

function mi_sub_contact_details(){
    if(isset($_POST['submit']))
    {

        // Check that the nonce is valid, and the user can edit this post.
        if (    isset( $_POST['contact_image_upload_nonce'] )    && wp_verify_nonce( $_POST['contact_image_upload_nonce'], 'contact_image_upload' ))
        {
               // The nonce was valid and the user has the capabilities, it is safe to continue.

               // These files need to be included as dependencies when on the front end.
               //require_once( ABSPATH . 'wp-admin/includes/image.php' );
               require_once( ABSPATH . 'wp-admin/includes/file.php' );
               //require_once( ABSPATH . 'wp-admin/includes/media.php' );

               $file = $_FILES['contact_image_upload'];

               $overrides = array(
                        // tells WordPress to not look for the POST form
                        // fields that would normally be present, default is true,
                        // we downloaded the file from a remote server, so there
                        // will be no form fields
                        'test_form' => false,

                        // setting this to false lets WordPress allow empty files, not recommended
                        'test_size' => true,

                        // A properly uploaded file will pass this test.
                        // There should be no reason to override this one.
                        'test_upload' => true,
                );


               $results = wp_handle_sideload( $file, $overrides );

                if (!empty($results['error'])) {
                        // insert any error handling here
                } else {

                        //$filename = $results['file']; // full path to the file
                        //$local_url = $results['url']; // URL to the file in the uploads dir
                        //$type = $results['type']; // MIME type of the file
                        update_option('contact_page_image', $results['url']);
                        // perform any actions here based in the above results
                }

       } else {

               // The security check failed, maybe show the user an error.
       }



         $input_contact_form_shortcode = $_POST['contact_form_shortcode'];
        update_option('contact_form_shortcode', $input_contact_form_shortcode);
      $contact_form_shortcode_slash = get_option('contact_form_shortcode',true);
         // $contact_form_shortcode = stripcslashes($contact_form_shortcode_slash);
       $contact_form_shortcode = stripcslashes($contact_form_shortcode_slash);


         $input_google_map_address = $_POST['google_map_address'];
        update_option('google_map_address', $input_google_map_address);
         $google_map_address = get_option('google_map_address',true);

         $input_google_map_bubble_marker_address = $_POST['google_map_bubble_marker_address'];
        update_option('google_map_bubble_marker_address', $input_google_map_bubble_marker_address);
         $google_map_bubble_marker_address = get_option('google_map_bubble_marker_address',true);

         $input_google_map_bubble_marker_city_state = $_POST['google_map_bubble_marker_city_state'];
        update_option('google_map_bubble_marker_city_state', $input_google_map_bubble_marker_city_state);
         $google_map_bubble_marker_city_state = get_option('google_map_bubble_marker_city_state',true);

         $input_google_map_bubble_marker_price = $_POST['google_map_bubble_marker_price'];
        update_option('google_map_bubble_marker_price', $input_google_map_bubble_marker_price);
         $google_map_bubble_marker_price = get_option('google_map_bubble_marker_price',true);

         $input_google_map_bubble_marker_agentname = $_POST['google_map_bubble_marker_agentname'];
        update_option('google_map_bubble_marker_agentname', $input_google_map_bubble_marker_agentname);
         $google_map_bubble_marker_agentname = get_option('google_map_bubble_marker_agentname',true);

    }

    $contact_page_image = get_option('contact_page_image');
    $contact_form_shortcode_slash = get_option('contact_form_shortcode');
    $contact_form_shortcode = stripcslashes($contact_form_shortcode_slash);
    $google_map_address = get_option('google_map_address');
    $google_map_bubble_marker_address = get_option('google_map_bubble_marker_address');
    $google_map_bubble_marker_city_state = get_option('google_map_bubble_marker_city_state');
    $google_map_bubble_marker_price = get_option('google_map_bubble_marker_price');
    $google_map_bubble_marker_agentname = get_option('google_map_bubble_marker_agentname');

    ?>

    <div class="wrap">
            <h1>Contact Info</h1>

            <form method="post" enctype="multipart/form-data" action="" novalidate="novalidate">

                <table class="form-table">
                    <tbody>

                        <tr>
                            <th scope="row">
                                <label for="contact_page_image">Contact Page Image</label>
                            </th>
                            <td>

                                <img src="<?php echo $contact_page_image; ?>" style="width: auto; height: 100px;"/>
                                <input type="file" name="contact_image_upload" id="contact_image_upload"  multiple="false" />
                                <?php wp_nonce_field( 'contact_image_upload', 'contact_image_upload_nonce' ); ?>

                                <!--<input name="contact_page_image" type="file" id="contact_page_image" value="<?php //if(isset($contact_page_image)){ echo $contact_page_image; }?>" class="regular-text">-->
                                Upload Photo to be displayed in the contact page
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                               <label for="contact_form_shortcode">Contact Form Shortcode</label>
                            </th>
                            <td>
                                <input name="contact_form_shortcode" type="text" id="contact_form_shortcode" value='<?php if(isset($contact_form_shortcode)){ echo $contact_form_shortcode; }?>' class="regular-text">
                                Copy/Paste Contact Form Shortcode
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="google_map_address">Google Map Address</label>
                            </th>
                            <td>
                                <input name="google_map_address" type="text" id="google_map_address" value="<?php if(isset($google_map_address)){ echo $google_map_address; }?>" class="regular-text">
                                Example: 775 New York Eve, Brooklyn.
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="google_map_bubble_marker_address">Google Map Bubble Marker Address</label>
                            </th>
                            <td>
                                <input name="google_map_bubble_marker_address" type="text" id="google_map_bubble_marker_address" value="<?php if(isset($google_map_bubble_marker_address)){ echo $google_map_bubble_marker_address; }?>" class="regular-text">
                                Example: 775 New York Eve, Brooklyn.
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="google_map_bubble_marker_city_state">Google Map Bubble Marker City/State</label>
                            </th>
                            <td>
                                <input name="google_map_bubble_marker_city_state" type="text" id="google_map_bubble_marker_city_state" value="<?php if(isset($google_map_bubble_marker_city_state)){ echo $google_map_bubble_marker_city_state; }?>" class="regular-text">
                                Displays City/state on Google Bubble marker
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="google_map_bubble_marker_price">Google Map Bubble Marker Price</label>
                            </th>
                            <td>
                                <input name="google_map_bubble_marker_price" type="text" id="google_map_bubble_marker_price" value="<?php if(isset($google_map_bubble_marker_price)){ echo $google_map_bubble_marker_price; }?>" class="regular-text">
                                Displays Price on Google Bubble marker
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="google_map_bubble_marker_agentname">Google Map Bubble Agent Name</label>
                            </th>
                            <td>
                                <input name="google_map_bubble_marker_agentname" type="text" id="google_map_bubble_marker_agentname" value="<?php if(isset($google_map_bubble_marker_agentname)){ echo $google_map_bubble_marker_agentname; }?>" class="regular-text">
                                 Displays Agent Name on Google Bubble marker
                            </td>
                        </tr>


                    </tbody>
                </table>
                <p class="submit">
                    <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
                </p>
            </form>
    </div>
<?php
}





add_action('in_admin_footer','medma_cms_add_script');
function medma_cms_add_script(){
     wp_enqueue_script('media-upload');
    ?>

<script type="text/javascript">
        // Uploading files
        var file_frame;

          jQuery('.upload_image').live('click', function( event ){

            event.preventDefault();

            // If the media frame already exists, reopen it.
            if ( file_frame ) {
              file_frame.open();
              return;
            }

            // Create the media frame.
            file_frame = wp.media.frames.file_frame = wp.media({
              title: jQuery( this ).data( 'uploader_title' ),
              button: {
                text: jQuery( this ).data( 'uploader_button_text' ),
              },
              multiple: false  // Set to true to allow multiple files to be selected
            });

            // When an image is selected, run a callback.
            file_frame.on( 'select', function() {
              // We set multiple to false so only get one image from the uploader
              attachment = file_frame.state().get('selection').first().toJSON();

                jQuery('.upload_image_text').val(attachment.url);
                alert(attachment.url);
                jQuery('.upload_image_hidden').val(attachment.id);
                 alert(attachment.id);

            });

            // Finally, open the modal
            file_frame.open();
          });

    </script>

  <script language="JavaScript">
jQuery(document).ready(function() {
jQuery('#upload_image_button').click(function() {
formfield = jQuery('#upload_image').attr('name');
tb_show('', 'media-upload.php?type=image&TB_iframe=true');
return false;
});

window.send_to_editor = function(html) {
imgurl = jQuery('img',html).attr('src');
jQuery('#upload_image').val(imgurl);
tb_remove();
}

});
</script>
    <?php
}





function mi_sub_agent_information() {


        $blog_id = get_current_blog_id();
        switch_to_blog($blog_id);
        $admin_email = get_option('admin_email');
        $user_details = get_user_by('email',$admin_email);
        $user_id = $user_details->ID;
        if($user_id == 0 || $user_id == null)
        {
            switch_to_blog(1);
            $admin_email = get_option('admin_email');
            $user_details = get_user_by('email',$admin_email);
            $user_id = $user_details->ID;
            switch_to_blog($blog_id);
        }


        if(isset($_POST['submit']))
        {
            $input_agent_name = $_POST['agentname'];
            $input_designation = $_POST['designation'];
            $input_business_phone = $_POST['business_phone'];
            $input_mobile_phone = $_POST['mobile_phone'];
            $input_broker_name = $_POST['brokername'];
            $input_broker_website = $_POST['broker_website'];
            $input_facebook = $_POST['facebook'];
            $input_twitter = $_POST['twitter'];
            $input_googleplus = $_POST['googleplus'];


            if (    isset( $_POST['profile_picture_upload_nonce'] )    && wp_verify_nonce( $_POST['profile_picture_upload_nonce'], 'profile_picture_upload' ))
            {
                   require_once( ABSPATH . 'wp-admin/includes/file.php' );

                   $file = $_FILES['profile_picture_upload'];

                   $overrides = array(
                            'test_form' => false,
                            'test_size' => true,
                            'test_upload' => true,
                    );

                   $profile_picture_results = wp_handle_sideload( $file, $overrides );

                    if (!empty($profile_picture_results['error'])) {
                            // insert any error handling here
                    } else {
                            update_user_meta($user_id,'profile_picture', $profile_picture_results['url']);
                            // perform any actions here based in the above results
                    }

           } else {

                   // The security check failed, maybe show the user an error.
           }

           if (    isset( $_POST['broker_logo_upload_nonce'] )    && wp_verify_nonce( $_POST['broker_logo_upload_nonce'], 'broker_logo_upload' ))
            {
                   require_once( ABSPATH . 'wp-admin/includes/file.php' );

                   $file = $_FILES['broker_logo_upload'];

                   $overrides = array(
                            'test_form' => false,
                            'test_size' => true,
                            'test_upload' => true,
                    );

                   $broker_logo_results = wp_handle_sideload( $file, $overrides );

                    if (!empty($broker_logo_results['error'])) {
                            // insert any error handling here
                    } else {
                            update_user_meta($user_id,'broker_logo', $broker_logo_results['url']);
                            // perform any actions here based in the above results
                    }

           } else {

                   // The security check failed, maybe show the user an error.
           }


            update_user_meta($user_id,'first_name',$input_agent_name);
            update_user_meta($user_id,'designation',$input_designation);
            update_user_meta($user_id,'business_phone',$input_business_phone);
            update_user_meta($user_id,'mobile_phone',$input_mobile_phone);
            update_user_meta($user_id,'broker',$input_broker_name);
            update_user_meta($user_id,'broker_website',$input_broker_website);
            update_user_meta($user_id,'facebook',$input_facebook);
            update_user_meta($user_id,'twitter',$input_twitter);
            update_user_meta($user_id,'googleplus',$input_googleplus);




        }

        $agentname = get_user_meta($user_id,'first_name',true);
        $designation = get_user_meta($user_id,'designation',true);
        $business_phone = get_user_meta($user_id,'business_phone',true);
        $mobile_phone = get_user_meta($user_id,'mobile_phone',true);
        $brokername = get_user_meta($user_id,'broker',true);
        $broker_website = get_user_meta($user_id,'broker_website',true);
        $twitter = get_user_meta($user_id,'twitter',true);
        $facebook = get_user_meta($user_id,'facebook',true);
        $googleplus = get_user_meta($user_id,'googleplus',true);
        $agent_profile_picture =  get_user_meta($user_id,'profile_picture',true);
        if(is_numeric($agent_profile_picture) && $agent_profile_picture>0)
        {
            switch_to_blog(1);
            $agent_profile_picture_url = wp_get_attachment_image_src($agent_profile_picture,'full');
            switch_to_blog($blog_id);
        }
        else
        {
            $agent_profile_picture_url = $agent_profile_picture;
        }

        $agent_broker_logo =  get_user_meta($user_id,'broker_logo',true);
        if(is_numeric($agent_broker_logo) && $agent_broker_logo>0)
        {
            switch_to_blog(1);
            $agent_broker_logo_url = wp_get_attachment_image_src($agent_broker_logo,'full');
            switch_to_blog($blog_id);
        }
        else
        {
            $agent_broker_logo_url = $agent_broker_logo;
        }


	?>
        <div class="wrap">
            <h1>Agent Information</h1>

            <form method="post" action="admin.php?page=mi-sub-agent-information" novalidate="novalidate" enctype="multipart/form-data">

                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <label for="agentname">Agent Name</label>
                            </th>
                            <td>
                                <input name="agentname" type="text" id="agentname" value="<?php if(isset($agentname)){ echo $agentname; }?>" class="regular-text">
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="designation">Designation</label>
                            </th>
                            <td>
                                <input name="designation" type="text" id="designation" value="<?php if(isset($designation)){ echo $designation; }?>" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="business_phone">Business Phone</label>
                            </th>
                            <td>
                                <input name="business_phone" type="text" id="business_phone" value="<?php if(isset($business_phone)){ echo $business_phone; }?>" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="mobile_phone">Mobile Phone</label>
                            </th>
                            <td>
                                <input name="mobile_phone" type="text" id="mobile_phone" value="<?php if(isset($mobile_phone)){ echo $mobile_phone; }?>" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="profile_picture">Profile Picture</label>
                            </th>
                            <td>
                                <?php if(isset($agent_profile_picture_url)){ ?>
                                    <img style="height:100px; width:auto;" src="<?php echo $agent_profile_picture_url; ?>" alt="Profile Picture"/>
                                <?php }else{ ?>
                                    <img style="height:100px; width:auto;" src="<?php echo plugins_url('medma-site-manager'); ?>/images/dummy_agent_pic.png" alt="Profile Picture"/>
                                <?php } ?>

                                <input type="file" name="profile_picture_upload" id="profile_picture_upload"  multiple="false" />
                                <?php wp_nonce_field( 'profile_picture_upload', 'profile_picture_upload_nonce' ); ?>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="brokername">Broker Name</label>
                            </th>
                            <td>
                                <input name="brokername" type="text" id="brokername" value="<?php if(isset($brokername)){ echo $brokername; }?>" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="broker_website">Broker Website</label>
                            </th>
                            <td>
                                <input name="broker_website" type="text" id="broker_website" value="<?php if(isset($broker_website)){ echo $broker_website; }?>" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="broker_logo">Broker Logo</label>
                            </th>
                            <td>
                                <?php if(isset($agent_broker_logo_url)){ ?>
                                    <img style="height:100px; width:auto;" src="<?php echo $agent_broker_logo_url; ?>" alt="Broker Logo"/>
                                <?php }else{ ?>
                                    <img style="height:100px; width:auto;" src="<?php echo plugins_url('medma-site-manager'); ?>/images/placeholder_wide.jpg" alt="Broker Logo"/>
                                <?php } ?>

                                <input type="file" name="broker_logo_upload" id="broker_logo_upload"  multiple="false" />
                                <?php wp_nonce_field( 'broker_logo_upload', 'broker_logo_upload_nonce' ); ?>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="facebook">Facebook</label>
                            </th>
                            <td>
                                <input name="facebook" type="text" id="facebook" value="<?php if(isset($facebook)){ echo $facebook; }?>" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="twitter">Twitter</label>
                            </th>
                            <td>
                                <input name="twitter" type="text" id="twitter" value="<?php if(isset($twitter)){ echo $twitter; }?>" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="googleplus">Google Plus</label>
                            </th>
                            <td>
                                <input name="googleplus" type="text" id="googleplus" value="<?php if(isset($googleplus)){ echo $googleplus; }?>" class="regular-text">
                            </td>
                        </tr>

                    </tbody>
                </table>

                <p class="submit">
                    <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
                </p>
            </form>

        </div>
        <?php

}

function wp_gear_manager_admin_scripts() {
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_enqueue_script('jquery');
}

function wp_gear_manager_admin_styles() {
wp_enqueue_style('thickbox');
}

add_action('admin_print_scripts', 'wp_gear_manager_admin_scripts');
add_action('admin_print_styles', 'wp_gear_manager_admin_styles');


add_action('in_admin_footer', 'custom_admin_scripts');

function custom_admin_scripts() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery(document).on('keyup', '#property_price', function() {
                var x = jQuery(this).val();
                jQuery(this).val(x.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            });

            jQuery(document).on('keyup', '#property_price1', function() {
                var x = jQuery(this).val();
                jQuery(this).val(x.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            });

            jQuery(document).on('keyup', '#property_price2', function() {
                var x = jQuery(this).val();
                jQuery(this).val(x.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            });

            jQuery(document).on('keyup', '#property_square_feet', function() {
                var x = jQuery(this).val();
                jQuery(this).val(x.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            });

            jQuery(document).on('keyup', '#property_lot_size', function() {
                var x = jQuery(this).val();
                jQuery(this).val(x.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            });
            var price_type = jQuery("#property_price_type").val();

            if(price_type == "fixed")
            {
                jQuery('#property_price').show();
                jQuery('#range-price-type-min').hide();
                jQuery('#range-price-type-max').hide();
            }
            else
            {
                jQuery('#fixed-price-type').hide();
                jQuery('#property_price1').show();
                jQuery('#property_price2').show();
            }
            jQuery("#property_price_type").on('change',function(){
                var price_type = jQuery("#property_price_type").val();
                if(price_type == "fixed")
                {
                    jQuery('#fixed-price-type').show();
                    jQuery('#range-price-type-min').hide();
                    jQuery('#range-price-type-max').hide();
                }
                else
                {
                    jQuery('#fixed-price-type').hide();
                    jQuery('#range-price-type-min').show();
                    jQuery('#range-price-type-max').show();
                }
            });
        });
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>
    <?php
}*/

/*
add_shortcode('custom_map', 'custom_map_shortcode');

function custom_map_shortcode($atts) {
        $atts = shortcode_atts(
                array(
            'address' => '',
            'apikey' => ''
                ), $atts, 'custom_map');
        $apikey = 'AIzaSyDRPlDrXxbII4KE0GIwnre3ocT4WgN7tak';

        $location = get_option('google_map_address', true);
        if ($location == '') {
            $location = '';
        }

        $address = get_option('google_map_bubble_marker_address', true);
        if ($address == '') {
            $address = '';
        }

        $city_state = get_option('google_map_bubble_marker_city_state', true);
        if ($city_state == '') {
            $city_state = '';
        }

        $price = get_option('google_map_bubble_marker_price', true);
        if ($price == '') {
            $price = '';
        }

        $agent = get_option('google_map_bubble_marker_agentname', true);
        if ($agent == '') {
            $agent = '';
        }

        $html = '';
        $html .= '<div class="location-container">';
        $html .= '<style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
      #panel {
        position: absolute;
        top: 5px;
        left: 50%;
        margin-left: -180px;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
      }
    </style>
    ';
        $html .= '<script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=' .$apikey.'">
    </script>';

        $html .= '<script>
        jQuery(document).ready(function($){

        });
    </script>';

        $html .= '<script>
    var directionsDisplay;
    var directionsService = new google.maps.DirectionsService();
    var map;

    function initialize() {
    var lat = 37.42291810;
    var lng = -122.08542120;

    jQuery.ajax({
        url: "https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($location) . '&key=' .$apikey.'",
        type: "post",
        success: function(response){

            lat = response.results[0].geometry.location.lat;
            lng = response.results[0].geometry.location.lng;
            directionsDisplay = new google.maps.DirectionsRenderer();

              var myLatlng = new google.maps.LatLng(lat, lng);
              var mapOptions = {
                zoom: 15,
                center: myLatlng
              }
              map = new google.maps.Map(document.getElementById(\'map-canvas\'), mapOptions);
              directionsDisplay.setMap(map);

              directionsDisplay.setPanel(document.getElementById(\'directionsPanel\'));

             var contentString = "<div id=\'bubble-content\'><h5>'.$city_state.'</h5><p><label>Price:&nbsp;</label>'.$price.'</p><p><label>Represented By:&nbsp;</label>'.$agent.'</p></div>";

            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });

             var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                title: "Location"
            });

            infowindow.open(map,marker);


            calcRoute();


        }
    });

    }

    function computeTotalDistance(result) {
        var total = 0;
        var myroute = result.routes[0];
        for (var i = 0; i < myroute.legs.length; i++) {
            total += myroute.legs[i].distance.value;
        }
        total = total / 1000.0;
        document.getElementById(\'total\').innerHTML = total + \' km\';
    }


    function calcRoute() {

        var start = document.getElementById(\'start\').value;
        var end = document.getElementById(\'end\').value;
        var waypts = [];
        var checkboxArray = document.getElementById(\'waypoints\');
        for (var i = 0; i < checkboxArray.length; i++) {
            if (checkboxArray.options[i].selected == true) {
                waypts.push({
                location:checkboxArray[i].value,
                stopover:true});
            }
        }

        var request = {
          origin: start,
          destination: end,
          waypoints: waypts,
          optimizeWaypoints: true,
          travelMode: google.maps.TravelMode.DRIVING
        };
        directionsService.route(request, function(response, status) {

            if (status == google.maps.DirectionsStatus.OK) {
              directionsDisplay.setDirections(response);
            }

        });
        }

    google.maps.event.addDomListener(window, \'load\', initialize);

    </script>';


        $html .= '<div id="map-canvas"></div>';
        $html .= '<div id="map-controlpanel">';
        $html .= '<label>From Address: </label>';
        $html .= '<input id="start" type="text" name="start_point" value=""/>';
        $html .= '<input id="end" type="hidden" name="end_point" value="' . $location . '"/>';
        $html .= '<input id="waypoints" type="hidden" name="waypoints" value=""/>';
        $html .= '<input type="submit" class="button" value="Get Directions" onclick="calcRoute();">';
        $html .= '<div id="directionsPanel">';
        //$html .= '<p>Total Distance: <span id="total"></span></p>';
        $html .= '</div>';
        //$html .= '<hr/>';
        $html .= '</div>';


        $html  .= '</div>';
        return $html;
 }
*/

/*
add_shortcode('display_printable_info', 'display_printable_info');

function display_printable_info() {
    ?>

        <div class="printable-information row">
        <div class="col-sm-12">
            <div class="title">
                    <h3>Printables</h3>
                </div>
            <div class="col-sm-4">
                <div class="intro-text">
                    <?php echo get_option('printable_text');?>
                </div>
                <div class="attachments"><!-- Item attachments -->
                    <h2>Available Downloads</h2>
                <ul class="itemAttachments">
                          <?php
                                                    // The Query
                          $the_query = new WP_Query( array(
                                            'post_type' => 'printable_info',   /* edit this line */
/*                                            'posts_per_page' => 1 ) );

                         // The Loop
                         if ( $the_query->have_posts() ) {

                                 while ( $the_query->have_posts() ) {
                                         $the_query->the_post();
                             ?>

                            <li>
                                <h3><?php echo get_the_title();  ?></h3>

                                <h5><?php echo get_the_content(); ?></h5>

                                <div style="border:none" class="button medium white download">
                                     <?php $Printable_info_pdf = get_post_meta(get_the_ID(), 'wpcf-select-file-here', true );
                                     //echo "<prE>";print_r($Printable_info_pdf);echo "</pre>";
                                        //$pdf_file = $Printable_info_pdf['file'];
                                        if(!empty($Printable_info_pdf)) { ?>
                                            <a class="btn btn-primary" target="_new" href="<?php echo $Printable_info_pdf; ?>">Download</a>
                                        <?php }


                                            ?>
                                        <div class="pdf-size-details">
<!--                                            <span class="pdf-dowmload-size">Size: 0.37 MB </span><br>-->
                                        </div>
                                </div>
                            </li>
                            <?php
                            }

                         }
                         /* Restore original Post Data */
/*                         wp_reset_postdata();

                           ?>
                       </ul>
                </div>

                </div>
               <div class="col-sm-8 info-picture">
                <img src= "<?php echo get_option('printable_image');?>" style="height:100%;width:100%;" alt="image"/>
            </div>
            </div>
        </div>
    <?php
}
*/

// Register Custom Post Type
// function printable_info_post_type() {
//
// 	$labels = array(
// 		'name'                => _x( 'Printable_infos', 'Post Type General Name', 'text_domain' ),
// 		'singular_name'       => _x( 'Printable_info', 'Post Type Singular Name', 'text_domain' ),
// 		'menu_name'           => __( 'Printable_info', 'text_domain' ),
// 		'name_admin_bar'      => __( 'Post Type', 'text_domain' ),
// 		'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
// 		'all_items'           => __( 'All Items', 'text_domain' ),
// 		'add_new_item'        => __( 'Add New Item', 'text_domain' ),
// 		'add_new'             => __( 'Add New', 'text_domain' ),
// 		'new_item'            => __( 'New Item', 'text_domain' ),
// 		'edit_item'           => __( 'Edit Item', 'text_domain' ),
// 		'update_item'         => __( 'Update Item', 'text_domain' ),
// 		'view_item'           => __( 'View Item', 'text_domain' ),
// 		'search_items'        => __( 'Search Item', 'text_domain' ),
// 		'not_found'           => __( 'Not found', 'text_domain' ),
// 		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
// 	);
// 	$args = array(
// 		'label'               => __( 'Printable_info', 'text_domain' ),
// 		'description'         => __( 'Post Type Description', 'text_domain' ),
// 		'labels'              => $labels,
// 		'supports'            => array( 'title','editor','thumbnail'),
// 		'hierarchical'        => false,
// 		'public'              => true,
// 		'show_ui'             => true,
// 		'show_in_menu'        => true,
// 		'menu_position'       => 5,
// 		'show_in_admin_bar'   => true,
// 		'show_in_nav_menus'   => true,
// 		'can_export'          => true,
// 		'has_archive'         => true,
// 		'exclude_from_search' => false,
// 		'publicly_queryable'  => true,
// 		'capability_type'     => 'page',
// 	);
// 	register_post_type( 'Printable_info', $args );
// }
//
// add_action( 'init', 'printable_info_post_type', 0 );

/* For add meta box of the printable info */
/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
/*function printable_info_add_meta_box() {

	$screens = array( 'post', 'printable_info' );

	foreach ( $screens as $screen ) {

		add_meta_box(
			'printable_info_sectionid',
			__( 'Pdf Upload', 'myplugin_textdomain' ),
			'printable_info_meta_box_callback',
			$screen
		);
	}
}
add_action('add_meta_boxes', 'printable_info_add_meta_box' );
*/

/* For create a custom pdf upload field */
/*function printable_info_meta_box_callback() {
    wp_nonce_field(plugin_basename(__FILE__), 'wp_custom_attachment_nonce');
    ?>
    <p class="description">
    Upload your PDF here:
    </p>
    <?php
    $Printable_info_pdf = get_post_meta(get_the_ID(), 'wp_custom_attachment', true );
    ?>

    <input type="file" id="wp_custom_attachment" name="wp_custom_attachment" value="" size="25">
    <br>
    <p class="description">
        Uploaded file path:

    </p>
    <input style="width:700px;" type="text" id="cu-wp-url" value="<?php echo $Printable_info_pdf['url']; ?>">
    <p class="description">
       <label>Download</label> <a href="<?php echo $Printable_info_pdf['url']; ?>" target="_new" > <img style="width:22px;" src="<?php echo get_site_url();?>/wp-content/themes/supersized/images/pdficon.png"/></a>
    </p>
<?php
 }
*/
/* for Save the Custom pdf feild */

/*add_action('save_post', 'save_custom_meta_data');
function save_custom_meta_data($id) {
    if(!empty($_FILES['wp_custom_attachment']['name'])) {
        $supported_types = array('application/pdf');
        $arr_file_type = wp_check_filetype(basename($_FILES['wp_custom_attachment']['name']));
        $uploaded_type = $arr_file_type['type'];

        if(in_array($uploaded_type, $supported_types)) {
            $upload = wp_upload_bits($_FILES['wp_custom_attachment']['name'], null, file_get_contents($_FILES['wp_custom_attachment']['tmp_name']));
            if(isset($upload['error']) && $upload['error'] != 0) {
                wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
            } else {
                update_post_meta($id, 'wp_custom_attachment', $upload);
            }
        }
        else {
            wp_die("The file type that you've uploaded is not a PDF.");
        }
    }
}
*/
/*function update_edit_form(){
    echo ' enctype="multipart/form-data"';
}
add_action('post_edit_form_tag', 'update_edit_form');*/

/*
 * Disable admin bar
 */

add_filter('show_admin_bar', '__return_false');

add_action( 'wp_ajax_send_contact_details', 'send_contact_details_callback' );
add_action( 'wp_ajax_nopriv_send_contact_details', 'send_contact_details_callback' );

function send_contact_details_callback() {
	global $wpdb; // this is how you get access to the database

	$name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $subject_id = $_POST['subject'];
        $message = $_POST['message'];

        if(0 == $subject_id){
            $subject = 'Schedule a viewing';
        }elseif(1 == $subject_id){
            $subject = 'Property still available?';
        }elseif(2 == $subject_id){
            $subject = 'Learn more details';
        }elseif(3 == $subject_id){
            $subject = 'Alter me on similar homes';
        }elseif(4 == $subject_id){
            $subject = 'Make an offer';
        }elseif(5 == $subject_id){
            $subject = 'Other';
        }

        $content = '';
        $content .= '<html>';
        $content .= '<body>';
        $content .= '<div>';
        $content .= '<p>Dear Admin,</p>';
        $content .= '<p></p>';
        $content .= '<p>Please get back to me on my details below: </p>';
        $content .= '<p><strong>Name:&nbsp;</strong>'.$name.'</p>';
        $content .= '<p><strong>Email:&nbsp;</strong>'.$email.'</p>';
        $content .= '<p><strong>Phone:&nbsp;</strong>'.$phone.'</p>';
        $content .= '<p><strong>Message:&nbsp;</strong>'.$message.'</p>';
        $content .= '</div>';
        $content .= '</body>';
        $content .= '</html>';

        $current_blog_id = get_current_blog_id();
        $users = get_users(array('blog_id'=>$current_blog_id,'role'=>'administrator'));
        $admin_email = $users['0']->data->user_email;

        $send = wp_mail($admin_email, $subject, $content);
        if($send){
            echo "sent";
        }else{
            echo "fail";
        }

	wp_die(); // this is required to terminate immediately and return a proper response
}

add_filter( 'wp_mail_content_type', 'set_content_type' );
function set_content_type( $content_type ) {
	return 'text/html';
}

//add_action( 'wp', 'render_dynamic_css', 99);

$model = ThemeSettingsModel::model();

$model->registerDynamicCss(array(
    'site_title_size' => array(
        'selector' => '.site-title a',
        'css' => array(
            'font-size' => '{value}px',
        ),
    ),
    'site_title_face' => array(
        'selector' => '.site-title a',
        'css' => array(
            'font-family' => '{value}',
        ),
    ),
    'site_title_shadow' => array(
        'selector' => '.site-title a',
        'options' => array(
            'yes' => array(
                'text-shadow' => '1px 1px 0 #000000',
            ),
            'no' => array(
                'text-shadow' => 'none',
            ),
        )
    ),
    'top_page_background_color' => array(
        'selector' => 'header',
        'params' => array(
            'alpha' => 'top_page_background_opacity',
        ),
        'css' => array(
            'background-color' => '{rgba}',
        ),
    ),
    'site_title_color' => array(
        'selector' => '.site-title a',
        'css' => array(
            'color' => '{value}',
        ),
    ),
    'content_title_color' => array(
        'selector' => '.main-content .container .content h1',
        'css' => array(
            'color' => '{value}',
        ),
    ),
    'navigation_text_color' => array(
        'selector' => '.navbar-default .navbar-nav > li > a',
        'css' => array(
            'color' => '{value}',
        ),
    ),
    'navigation_hilight_text_color' => array(
        'selector' => '.navbar-default .navbar-nav > li > a:hover',
        'css' => array(
            'color' => '{value}',
        ),
    ),
    'main_navigation_background_color' => array(
        'selector' => '.navbar-default .navbar-nav > li',
        'css' => array(
            'background-color' => '{value}',
        ),
    ),
    'main_navigation_background_hover_color' => array(
        'selector' => '.navbar-default .navbar-nav > li > a:hover',
        'css' => array(
            'background-color' => '{value}',
        ),
    ),
    'site_rest_font_face' => array(
        'selector' => '.main-content .container .content',
        'css' => array(
            'font-family' => '{value}',
        ),
    ),

    'highlighted_accent_color' => array(
        'selector' => '.main-content .container .content em, .main-content .container .content strong, .main-content .container .content cite',
        'css' => array(
            'color' => '{value}',
        ),
    ),
    'main_text_color' => array(
        'selector' => 'html,body',
        'css' => array(
            'color' => '{value}',
        ),
    ),
    'footer_text_color' => array(
        'selector' => 'footer, footer .agent-info h2, footer ul li, footer .broker-wrapper p.tiny',
        'css' => array(
            'color' => '{value}',
        ),
    ),
    'footer_link_color' => array(
        'selector' => 'footer a',
        'css' => array(
            'color' => '{value}',
        ),
    ),
    'always_show_footer' => array(
        'selector' => '.none',
        'options' => array(
            'yes' => array(
                'text-shadow' => '1px 1px 0 #000000',
            ),
            'no' => array(
                'text-shadow' => 'none',
            ),
        )
    ),
), array('supersized-style'));
/*
function render_dynamic_css() {
    echo generate_font_css(
        '.navbar-default .navbar-nav > li > a',
        $model->main_menu_font_size,
        $model->main_menu_font_face,
        $model->main_menu_font_style,
        $model->main_menu_font_color
        );

    echo generate_font_css(
        '.site-title a',
        $model->big_title_font_size,
        $model->big_title_font_face,
        $model->big_title_font_style,
        $model->big_title_font_color
    );

    echo generate_font_css(
        '.post-title, .page-title, .content h1',
        $model->post_title_font_size,
        $model->post_title_font_face,
        $model->post_title_font_style,
        $model->post_title_font_color
    );

    echo generate_font_css(
        '.heading',
        $model->headings_font_size,
        $model->headings_font_face,
        $model->headings_font_style,
        $model->headings_font_color
    );

    echo generate_font_css(
        '.main-content .container .content',
        $model->content_font_size,
        $model->content_font_face,
        $model->content_font_style,
        $model->content_font_color
    );
}
*/




