<?php
/**
 * Functions - general template functions that are used throughout Aveone
 *
 * @package aveone
 * @subpackage Functions
 */
add_action('wp_ajax_aveone_dynamic_css', 'aveone_dynamic_css');
add_action('wp_ajax_nopriv_aveone_dynamic_css', 'aveone_dynamic_css');

function strip_tags_content($text, $tags = '', $invert = FALSE) {

  preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
  $tags = array_unique($tags[1]);
   
  if(is_array($tags) AND count($tags) > 0) {
    if($invert == FALSE) {
      return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
    }
    else {
      return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text);
    }
  }
  elseif($invert == FALSE) {
    return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
  }
  return $text;
} 







function aveone_dynamic_css() {
    global $wp_customize;
    if (method_exists($wp_customize, 'is_preview') and !is_admin()) {
        
    } else {
        header('Content-type: text/css');
    }
    require (get_template_directory() . '/custom-css.php');
    exit;
}

function aveone_media() {
    $template_url = get_template_directory_uri();
    $options = get_option('aveone');
    $aveone_css_data = '';

    $aveone_pagination_type = aveone_get_option('evl_pagination_type', 'pagination');
    $aveone_pos_button = aveone_get_option('evl_pos_button', 'right');
    $aveone_carousel_slider = aveone_get_option('evl_carousel_slider', '1');
    $aveone_parallax_slider = aveone_get_option('evl_parallax_slider_support', '1');
    $aveone_status_gmap = aveone_get_option('evl_status_gmap', '1');

    if (is_admin())
        return;
    wp_enqueue_script('jquery');
    wp_deregister_script('hoverIntent');

    if ($aveone_parallax_slider == "1") {
        wp_enqueue_script('parallax', AVEONEJS . '/parallax/parallax.js');
        wp_enqueue_style('parallaxcss', AVEONEJS . '/parallax/parallax.css');
        wp_enqueue_script('modernizr', AVEONEJS . '/parallax/modernizr.js');
    }

    if ($aveone_carousel_slider == "1") {
        wp_enqueue_script('carousel', AVEONEJS . '/carousel.js');
    }
    wp_enqueue_script('tipsy', AVEONEJS . '/tipsy.js');
    wp_enqueue_script('fields', AVEONEJS . '/fields.js');
    wp_enqueue_script('tabs', AVEONEJS . '/tabs.js', array(), '', true);

    if ($aveone_pagination_type == "infinite") {
        wp_enqueue_script('jscroll', AVEONEJS . '/jquery.infinite-scroll.min.js');
    }

    if ($aveone_pos_button == "disable" || $aveone_pos_button == "") {
        
    } else {
        wp_enqueue_script('jquery_scroll', AVEONEJS . '/jquery.scroll.pack.js');
    }
    wp_enqueue_script('supersubs', AVEONEJS . '/supersubs.js');
    wp_enqueue_script('superfish', AVEONEJS . '/superfish.js');
    wp_enqueue_script('hoverIntent', AVEONEJS . '/hoverIntent.js');
    wp_enqueue_script('buttons', AVEONEJS . '/buttons.js');
    wp_enqueue_script('ddslick', AVEONEJS . '/ddslick.js');
    wp_enqueue_script('main', AVEONEJS . '/main.js', array(), '', true);

    if ($aveone_status_gmap == "1") {
        wp_enqueue_script('googlemaps', '//maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false&amp;language=' . mb_substr(get_locale(), 0, 2));
        wp_enqueue_script('gmap', AVEONEJS . '/gmap.js', array(), '', true);
    }

    $blog_title = aveone_get_option('evl_title_font');
    $blog_tagline = aveone_get_option('evl_tagline_font');
    $post_title = aveone_get_option('evl_post_font');
    $content_font = aveone_get_option('evl_content_font');
    $heading_font = aveone_get_option('evl_heading_font');
    $bootstrap_font = aveone_get_option('evl_bootstrap_slide_title_font');
    $bootstrap_desc = aveone_get_option('evl_bootstrap_slide_desc_font');
    $parallax_font = aveone_get_option('evl_parallax_slide_title_font');
    $parallax_desc = aveone_get_option('evl_parallax_slide_desc_font');
    $carousel_font = aveone_get_option('evl_carousel_slide_title_font');
    $carousel_desc = aveone_get_option('evl_carousel_slide_desc_font');
    $menu_font = aveone_get_option('evl_menu_font');


    $selected_fonts[0] = $blog_title['face'];
    $selected_fonts[1] = $blog_tagline['face'];
    $selected_fonts[2] = $post_title['face'];
    $selected_fonts[3] = $content_font['face'];
    $selected_fonts[4] = $heading_font['face'];
    $selected_fonts[5] = $parallax_font['face'];
    $selected_fonts[6] = $parallax_desc['face'];
    $selected_fonts[7] = $carousel_font['face'];
    $selected_fonts[8] = $carousel_desc['face'];
    $selected_fonts[9] = $menu_font['face'];
    $selected_fonts[10] = $bootstrap_font['face'];
    $selected_fonts[11] = $bootstrap_desc['face'];


    $font_face_all = '';
    $j = 0;
    $font_storage[] = '';
    for ($i = 0; $i < 12; $i++) {
        if (in_array($selected_fonts[$i], $font_storage)) {
            
        } else {
            $font_storage[] = $selected_fonts[$i];
            $font_face = explode(',', $selected_fonts[$i]);
            $font_face = str_replace(" ", "+", $font_face[0]);
            if ($font_face != 'Arial' && $font_face != 'Calibri' && $font_face != 'Georgia' && $font_face != 'Impact' && $font_face != 'Lucida+Sans+Unicode' && $font_face != 'Myriad+Pro*' && $font_face != 'Palatino+Linotype' && $font_face != 'Tahoma' && $font_face != 'Times+New+Roman' && $font_face != 'Trebuchet+MS' && $font_face != 'Verdana') {
                if ($j > 0) {
                    $ext = '|';
                } else {
                    $ext = '';
                }
                $j++;
                $font_face = $ext . $font_face . ':r,b,i';
                $font_face_all = $font_face_all . $font_face;
            }
        }
    }
    if ($font_face_all) {
        wp_enqueue_style('googlefont', "//fonts.googleapis.com/css?family=" . $font_face_all);
    }

    // FontAwesome 

    wp_enqueue_style('fontawesomecss', AVEONEJS . '/fontawesome/css/font-awesome.css');

    // Main Stylesheet

    function aveone_styles() {
        global $wp_customize;

        wp_enqueue_style('maincss', get_stylesheet_uri(), false);


        if (method_exists($wp_customize, 'is_preview') and !is_admin()) {

            // Custom CSS for Customizer

            require_once( get_template_directory() . '/custom-css.php' );
            wp_enqueue_style('dynamic-css', admin_url('admin-ajax.php') . '?action=aveone_dynamic_css');
            wp_add_inline_style('maincss', $aveone_css_data);
        } else {

            // Custom CSS for Live website

            wp_enqueue_style('dynamic-css', admin_url('admin-ajax.php') . '?action=aveone_dynamic_css');
        }
    }

    add_action('wp_enqueue_scripts', 'aveone_styles');


    // Bootstrap Elements        

    wp_enqueue_script('bootstrap', AVEONEJS . '/bootstrap/js/bootstrap.js');
    wp_enqueue_style('bootstrapcss', AVEONEJS . '/bootstrap/css/bootstrap.css', array('maincss'));
    wp_enqueue_style('bootstrapcsstheme', AVEONEJS . '/bootstrap/css/bootstrap-theme.css', array('bootstrapcss'));
}

/**
 * aveone_menu - adds css class to the <ul> tag in wp_page_menu.
 *
 * @since 0.3
 * @filter aveone_menu_ulclass
 * @needsdoc
 */
function aveone_menu_ulclass($ulclass) {
    $classes = apply_filters('aveone_menu_ulclass', (string) 'nav-menu'); // Available filter: aveone_menu_ulclass
    return preg_replace('/<ul>/', '<ul class="' . $classes . '">', $ulclass, 1);
}

/**
 * aveone_nice_terms clever terms
 *
 * @since 0.2.3
 * @needsdoc
 */
function aveone_nice_terms($term = '', $normal_separator = ', ', $penultimate_separator = ' and ', $end = '') {
    if (!$term)
        return;
    switch ($term):
        case 'cats':
            $terms = aveone_get_terms('cats', $normal_separator);
            break;
        case 'tags':
            $terms = aveone_get_terms('tags', $normal_separator);

            break;
    endswitch;
    if (empty($term))
        return;
    $things = explode($normal_separator, $terms);

    $thelist = '';
    $i = 1;
    $n = count($things);

    foreach ($things as $thing) {

        $data = trim($thing, ' ');

        $links = preg_match('/>(.*?)</', $thing, $link);
        $hrefs = preg_match('/href="(.*?)"/', $thing, $href);
        $titles = preg_match('/title="(.*?)"/', $thing, $title);
        $rels = preg_match('/rel="(.*?)"/', $thing, $rel);

        if (1 < $i and $i != $n) {
            $thelist .= $normal_separator;
        }

        if (1 < $i and $i == $n) {
            $thelist .= $penultimate_separator;
        }
        $thelist .= '<a rel="' . $rel[1] . '" href="' . $href[1] . '"';
        if (!$term = 'tags')
            $thelist .= ' title="' . $title[1] . '"';
        $thelist .= '>' . $link[1] . '</a>';
        $i++;
    }
    $thelist .= $end;
    return apply_filters('aveone_nice_terms', (string) $thelist);
}

/**
 * aveone_get_terms() Returns other terms except the current one (redundant)
 *
 * @since 0.2.3
 * @usedby aveone_entry_footer()
 */
function aveone_get_terms($term = NULL, $glue = ', ') {
    if (!$term)
        return;

    $separator = "\n";
    switch ($term):
        case 'cats':
            $current = single_cat_title('', false);
            $terms = get_the_category_list($separator);
            break;
        case 'tags':
            $current = single_tag_title('', '', false);
            $terms = get_the_tag_list('', "$separator", '');
            break;
    endswitch;
    if (empty($terms))
        return;

    $thing = explode($separator, $terms);
    foreach ($thing as $i => $str) {
        if (strstr($str, ">$current<")) {
            unset($thing[$i]);
            break;
        }
    }
    if (empty($thing))
        return false;

    return trim(join($glue, $thing));
}

/**
 * aveone_get Gets template files
 *
 * @since 0.2.3
 * @needsdoc
 * @action aveone_get
 * @todo test this on child themes
 */
function aveone_get($file = NULL) {
    do_action('aveone_get'); // Available action: aveone_get
    $error = "Sorry, but <code>{$file}</code> does <em>not</em> seem to exist. Please make sure this file exist in <strong>" . get_stylesheet_directory() . "</strong>\n";
    $error = apply_filters('aveone_get_error', (string) $error); // Available filter: aveone_get_error
    if (isset($file) && file_exists(get_stylesheet_directory() . "/{$file}.php"))
        locate_template(get_stylesheet_directory() . "/{$file}.php");
    else
        echo $error;
}

/**
 * aveone_include_all() A function to include all files from a directory path
 *
 * @since 0.2.3
 * @credits k2
 */
function aveone_include_all($path, $ignore = false) {

    /* Open the directory */
    $dir = @dir($path) or die('Could not open required directory ' . $path);

    /* Get all the files from the directory */
    while (( $file = $dir->read() ) !== false) {
        /* Check the file is a file, and is a PHP file */
        if (is_file($path . $file) and (!$ignore or !in_array($file, $ignore) ) and preg_match('/\.php$/i', $file)) {
            require_once( $path . $file );
        }
    }
    $dir->close(); // Close the directory, we're done.
}

/**
 * Gets the profile URI for the document being displayed.
 * @link http://microformats.org/wiki/profile-uris Profile URIs
 *
 * @since 0.2.4
 * @param integer $echo 0|1
 * @return string profile uris seperatd by spaces
 * */
function aveone_get_profile_uri($echo = 1) {
    // hAtom profile
    $profile[] = 'http://purl.org/uF/hAtom/0.1/';

    // hCard, hCalendar, rel-tag, rel-license, rel-nofollow, VoteLinks, XFN, XOXO profile
    $profile[] = 'http://purl.org/uF/2008/03/';

    $profile = join(' ', apply_filters('profile_uri', $profile)); // Available filter: profile_uri

    if ($echo)
        echo $profile;
    else
        return $profile;
}

add_action('customize_controls_enqueue_scripts', 'my_add_scripts');

function my_add_scripts() {
    wp_enqueue_media();
    wp_enqueue_script('aveone-media-manager', AVEONE_DIRECTORY . 'js/aveone-media-manager.js', array(), '1.0', true);
}

add_action('customize_controls_print_styles', 'my_customize_styles', 50);

function my_customize_styles() {
    ?>
    <style>
        .wp-full-overlay {
            z-index: 150000 !important;
        }
    </style>
<?php
}

add_action('wp_head', 'aveone_scripts');

function aveone_scripts() {
    wp_enqueue_style('aveone-flexslider', get_template_directory_uri() . '/css/flexslider.css');
    wp_enqueue_script('aveone-zaccordion', get_template_directory_uri() . '/js/jquery.zaccordion.min.js');
    wp_enqueue_script('aveone-flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js');
}

/* Disable Admin Bar */

add_filter('show_admin_bar', '__return_false');

/*
 * Display Property Details Page
 */

add_shortcode('display_property_details', 'custom_property_details');

function custom_property_details() {
    ?>
    <div class="row property-details">
        <div class="col-sm-12">
            <div class="col-sm-4">
                <h3 class="heading">Facts & Figures</h3>
                <ul class="details">
                    
    <?php
    if (get_option('property_price_type') == "fixed") {
        ?>
                        <li>
                            <label>Price</label>
                            <span><?php echo '$' . get_option('property_price'); ?></span>
                        </li>
        <?php
    } elseif (get_option('property_price_type') == "range") {
        ?>
                        <li>
                            <label>Min Price:</label>
                            <span><?php echo '$' . get_option('property_price1'); ?></span>
                        </li>
                        <li>
                            <label>Max Price:</label>
                            <span><?php echo '$' . get_option('property_price2'); ?></span>
                        </li>
        <?php
    }
    ?>
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
                        <?php $property_desc_rawdata = get_option('property_description',true);
                         $property_description = stripslashes($property_desc_rawdata);
                         echo stripslashes($property_description);
                        ?>
                <div class="property-tour-links">
                    <h3>Tour</h3>
                    <ul class="tour-links">
    <?php
    if (get_option('property_tour_link1')) {
        ?>
                            <li><a href="<?php echo get_option('property_tour_link1'); ?>"><?php echo get_option('property_tour_link1'); ?></a></li>
        <?php
    }if (get_option('property_tour_link2')) {
        ?>
                            <li><a href="<?php echo get_option('property_tour_link2'); ?>"><?php echo get_option('property_tour_link2'); ?></a></li>
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

            /*
             * Contact Page Shortcode
             */

            add_shortcode('display_contact_page', 'custom_contact_page');

            function custom_contact_page() {
                ?>
    <div class="contact-page">
        <div class="col-sm-12">
            <div class="col-sm-5">
    <?php 
    $contact_form = stripcslashes(get_option('contact_form_shortcode'));
    echo do_shortcode($contact_form); ?>
            </div>
            <div class="col-sm-7">
               <?php  $contact_page_image = get_option('contact_page_image',true);?>
                <img class="col-sm-12" src="<?php echo $contact_page_image; ?>" alt="Contact Image" />
            </div>
        </div>
    </div>
    <?php
}

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


add_shortcode('custom_map', 'custom_map_shortcode');

function custom_map_shortcode($atts) {
    $atts = shortcode_atts(
            array(
        'address' => '',
        'apikey' => ''
            ), $atts, 'custom_map');

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
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDRPlDrXxbII4KE0GIwnre3ocT4WgN7tak">
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
        url: "https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($location) . '&key=AIzaSyDRPlDrXxbII4KE0GIwnre3ocT4WgN7tak",
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

             var contentString = "<div id=\'bubble-content\'><h3>' . $address . '</h3><h3>' . $city_state . '</h3><label>Price:&nbsp;</label>' . $price . '<br><label>Represented By:&nbsp;</label>'.$agent.'</div>";

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
    $html .= '</div>';
    $html .= '<hr/>';
    $html .= '</div>';
    $html .= '</div>';
    return $html;
}



add_shortcode('display_printable_info', 'display_printable_info');

function display_printable_info() {
    ?>

    <div class="printable-information row">
        <div class="col-sm-12 row">
            <div class="col-sm-4">
                <div class="intro-text">
                    <?php echo get_option('printable_text'); ?>
                </div>
                <div class="available-downloads">
                    <h3>Available Downloads</h3>
                    <?php
                    switch_to_blog(get_current_blog_id());
                    global $wpdb, $table_prefix;

                    $sql = "SELECT ID FROM `{$table_prefix}posts` WHERE post_type = 'printable_info'";
                    $id = $wpdb->get_var($sql);
                    restore_current_blog();


                    $type = 'printable_info';
                    $args = array(
                        'post_type' => $type,
                        'post_status' => 'publish',
                        'posts_per_page' => -1
                    );

                    $my_query = new WP_Query($args);
                    if ($my_query->have_posts()) {
                        while ($my_query->have_posts()) : $my_query->the_post();
                            ?>
                            <div class="item-attachments">

                                <div id="attachment-1" class="attachment">
                                    <h4 class="attachment-title">
                                        <?php the_title(); ?>
                                    </h4>
                                        <?php the_content(); ?>

                                        <?php $meta_values = get_post_meta(get_the_ID(), 'wpcf-select-file-here', true);
                                        $file_type_extension = substr($meta_values, -3);
                                        ?>
                                    <div class="">
            <?php if ($meta_values == NULL) {
                ?>
                                            <a target="_blank"  class="cu-printables-download-link btn btn-primary" href="#" alt="#"/>No Files To Download</a>
                            <?php } else { ?>
                                            <a target="_blank" class="cu-printables-download-link btn btn-primary" href="<?php echo $meta_values; ?>" alt="<?php echo $meta_values; ?>"/>Download</a>
                                <?php $filesizebytes = filesize(get_attached_file(get_the_ID() + 1));
                                /*$sizeinkb = ($filesizebytes) / 1024;
                                $sizeinmb = $sizeinkb/1024;
                                ?>
                                            <span class="cu-filesize">Size: <?php echo round($sizeinmb, 2); ?>MB</span>*/?>
                                        </div>
            <?php } ?>
                                </div>

                            </div>
            <?php
        endwhile;
    }
    wp_reset_query();  // Restore global post data stomped by the_post().
    ?>
                </div>
            </div>
            <div class="col-sm-8 info-picture">
              <?php  $printable_image = get_option('printable_image',true); ?>
                <img src="<?php echo $printable_image; ?>"/>
            </div>
        </div>
    </div>
    <?php
}

add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts() {
    ?>
    <style>
        #section-evl_printable_info_text .option .controls textarea, #section-evl_printable_info_text .option .controls{ width: 100% !important;}
    </style>
    <?php
}

/*---------------- adding file types to types upload only for pdf docx doc txt files------------------*/
    
   
     if ( isset( $_REQUEST['post_id'] ) && get_post_type( $_REQUEST['post_id'] ) === 'printable_info' )
   {
        
          add_filter('wp_handle_upload_prefilter', 'tang_wp_handle_upload_prefilter');
function tang_wp_handle_upload_prefilter($file) {
  // This bit is for the flash uploader
  if ($file['type']=='application/octet-stream' && isset($file['tmp_name'])) {
    $file_size = getimagesize($file['tmp_name']);
    if (isset($file_size['error']) && $file_size['error']!=0) {
      $file['error'] = "Unexpected Error: {$file_size['error']}";
      return $file;
    } else {
      $file['type'] = $file_size['mime'];
    }
  }
  list($category,$type) = explode('/',$file['type']);
  
  if (! in_array( $type, array( 'pdf', 'msword','vnd.openxmlformats-officedocument.wordprocessingml.document'))) {
    $file['error'] = "Sorry, you can only upload a .pdf, a .doc, .docx file.";
  } 
  return $file;
   }
}



/*---------------- adding file types to types upload only for pdf docx doc txt files------------------*/
//Add custom column
add_filter('manage_edit-printable_info_columns', 'tan_printables_admin_column');
function tan_printables_admin_column($defaults) {
$defaults['FILE TYPE'] = 'FILE TYPE';
return $defaults;
}
//Add rows data
add_action( 'manage_printable_info_posts_custom_column' , 'tan_printables_admin_column_reg', 10, 2 );
function tan_printables_admin_column_reg($column, $post_id ){
 $meta_values = get_post_meta(get_the_ID(), 'wpcf-select-file-here', true);
                            $file_type_extension=substr($meta_values, -4);
                           
                          if($file_type_extension == '.pdf')
                          { ?>
                             <img src="<?php echo get_template_directory_uri(); ?>/images/pdf.png" width="70px" height="70px"/>
                          <?php }
                          elseif($file_type_extension == '.doc')
                              { ?>
                              <img src="<?php echo get_template_directory_uri(); ?>/images/doc.png" width="70px" height="70px"/>
                              <?php
                          }
                          elseif($file_type_extension == 'docx')
                              { ?>
                              <img src="<?php echo get_template_directory_uri(); ?>/images/docx.png" width="70px" height="70px"/>
                              <?php
                          }
}

function remove_menus(){
  remove_submenu_page( 'themes.php', 'customize.php' );
}

if(is_blog_admin())
{
add_action( 'admin_menu', 'remove_menus',999 );
}
add_action( 'admin_menu', 'remove_menus',999 );

?>
