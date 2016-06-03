<?php   
/**
* A unique identifier is defined to store the options in the database and reference them from the theme.
* By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
* If the identifier changes, it'll appear as if the options have been reset.
*
*/

function aveone_option_name() {

  // This gets the theme name from the stylesheet (lowercase and without spaces)
  $themename = wp_get_theme();
  $themename = $themename['Name'];
  $themename = preg_replace("/\W/", "", strtolower($themename) );

  $aveone_settings = get_option('aveone');
  $aveone_settings['id'] = 'aveone-theme';
  update_option('aveone', $aveone_settings); 

}

/**
* Defines an array of options that will be used to generate the settings page and be saved in the database.
* When creating the "id" fields, make sure to use all lowercase and no spaces.
*
*/

function aveone_options() {

  // Pull all the categories into an array
  $options_categories = array();
  $options_categories_obj = get_categories();
  foreach ($options_categories_obj as $category) {
  $options_categories[$category->cat_ID] = $category->cat_name;
  }

  // Pull all the pages into an array
  $options_pages = array();
  $options_pages_obj = get_pages('sort_column=post_parent,menu_order');
  $options_pages[''] = 'Select a page:';
  foreach ($options_pages_obj as $page) {
  $options_pages[$page->ID] = $page->post_title;
  }

  // If using image radio buttons, define a directory path
  $imagepath = get_template_directory_uri() . '/library/functions/images/';
  $imagepathfolder = get_template_directory_uri() . '/library/media/images/';
  $aveone_shortname = "evl";
  $template_url = get_template_directory_uri();

  $options = array();


// Subscribe buttons

$options[] = array( "name" => $aveone_shortname."-tab-2", "id" => $aveone_shortname."-tab-2",
"type" => "open-tab");

$options['evl_social_media_note'] = array( "name" => __( 'Note:', 'aveone' ),
"desc" => "Click Here to add social media links.",
"id" => $aveone_shortname."_social_media_note",
"type" => "note-for-social-media",
"std" => ''
);


$options[] = array( "name" => $aveone_shortname."-tab-2", "id" => $aveone_shortname."-tab-2",
"type" => "close-tab" );


// Header content

$options[] = array( "name" => $aveone_shortname."-tab-1", "id" => $aveone_shortname."-tab-1",
"type" => "open-tab");

// Favicon Option @since 3.1.5
$options['evl_favicon'] = array(
"name" => __( 'Custom Favicon', 'aveone' ),
"desc" => __( 'Upload custom favicon.', 'aveone' ),
"id" => $aveone_shortname."_favicon",
"type" => "upload"
);

$options['evl_header_logo'] = array( "name" => __( 'Custom logo', 'aveone' ),
"desc" => __( 'Upload a logo for your theme, or specify an image URL directly.', 'aveone' ),
"id" => $aveone_shortname."_header_logo",
"type" => "upload",
"std" => "");


$options[] = array( "name" => $aveone_shortname."-tab-1", "id" => $aveone_shortname."-tab-1",
"type" => "close-tab" );


// Typography

$options[] = array( "id" => $aveone_shortname."-tab-8",
"type" => "open-tab");

$options['evl_title_font'] = array( "name" => __( 'Blog Title font', 'aveone' ),
"desc" => __( 'Select the typography you want for your blog title. * non web-safe font.', 'aveone' ),
"id" => $aveone_shortname."_title_font",
"type" => "typography",
"std" => array('size' => '39px', 'face' => 'Roboto','style' => 'bold','color' => '')
);

$options['evl_tagline_font'] = array( "name" => __( 'Blog tagline font', 'aveone' ),
"desc" => __( 'Select the typography you want for your blog tagline. * non web-safe font.', 'aveone' ),
"id" => $aveone_shortname."_tagline_font",
"type" => "typography",
"std" => array('size' => '13px', 'face' => 'Roboto','style' => 'normal','color' => '')
);

$options['evl_menu_font'] = array( "name" => __( 'Main menu font', 'aveone' ),
"desc" => __( 'Select the typography you want for your main menu. * non web-safe font.', 'aveone' ),
"id" => $aveone_shortname."_menu_font",
"type" => "typography",
"std" => array('size' => '14px', 'face' => 'Roboto','style' => 'normal','color' => '')
);

$options['evl_post_font'] = array( "name" => __( 'Post title font', 'aveone' ),
"desc" => __( 'Select the typography you want for your post titles. * non web-safe font.', 'aveone' ),
"id" => $aveone_shortname."_post_font",
"type" => "typography",
"std" => array('size' => '28px', 'face' => 'Roboto','style' => 'normal','color' => '')
);

$options['evl_content_font'] = array( "name" => __( 'Content font', 'aveone' ),
"desc" => __( 'Select the typography you want for your blog content. * non web-safe font.', 'aveone' ),
"id" => $aveone_shortname."_content_font",
"type" => "typography",
"std" => array('size' => '16px', 'face' => 'Roboto','style' => 'normal','color' => '')
);

$options['evl_heading_font'] = array( "name" => __( 'Headings font', 'aveone' ),
"desc" => __( 'Select the typography you want for your blog headings (H1, H2, H3, H4, H5, H6). * non web-safe font.', 'aveone' ),
"id" => $aveone_shortname."_heading_font",
"type" => "typography",
"std" => array('size' => 'none', 'face' => 'Roboto','style' => 'normal','color' => '')
);

$options[] = array( "name" => $aveone_shortname."-tab-8", "id" => $aveone_shortname."-tab-8",
"type" => "close-tab" );


// General Styling


$options[] = array( "name" => $aveone_shortname."-tab-9", "id" => $aveone_shortname."-tab-9",
"type" => "open-tab");


$options['evl_content_back'] = array( "name" => __( 'Content color', 'aveone' ),
"desc" => __( 'Background color of content', 'aveone' ),
"id" => $aveone_shortname."_content_back",
"type" => "select",
"std" => "light",
"options" => array(
'light' => __( 'Light', 'aveone' ),
'dark' => __( 'Dark', 'aveone' )
));

$options['evl_menu_back'] = array( "name" => __( 'Menu color', 'aveone' ),
"desc" => __( 'Background color of main menu', 'aveone' ),
"id" => $aveone_shortname."_menu_back",
"type" => "select",
"std" => "light",
"options" => array(
'light' => __( 'Light', 'aveone' ),
'dark' => __( 'Dark', 'aveone' )
));


$options['evl_menu_back_color'] = array( "name" => __( 'Or custom menu color', 'aveone' ),
"desc" => __( 'Custom background color of main menu. <strong>Dark menu must be enabled.</strong>', 'aveone' ),
"id" => $aveone_shortname."_menu_back_color",
"type" => "color",
"std" => ""
);

$options['evl_disable_menu_back'] = array( "name" => __( 'Disable Menu Background', 'aveone' ),
"desc" => __( 'Check this box if you want to disable menu background', 'aveone' ),
"id" => $aveone_shortname."_disable_menu_back",
"type" => "checkbox",
"std" => "0");

$options['evl_header_footer_back_color'] = array( "name" => __( 'Header and Footer color', 'aveone' ),
"desc" => __( 'Custom background color of header and footer', 'aveone' ),
"id" => $aveone_shortname."_header_footer_back_color",
"type" => "color",
"std" => ""
);

$options['evl_pattern'] = array( "name" => __( 'Header and Footer pattern', 'aveone' ),
"desc" => __( 'Choose the pattern for header and footer background', 'aveone' ),
"id" => $aveone_shortname."_pattern",
"type" => "images",
"std" => "pattern_8.png",
"options" => array(
'none' => $imagepathfolder . '/header-two/none.jpg',
'pattern_1.png' => $imagepathfolder . '/pattern/pattern_1_thumb.png',
'pattern_2.png' => $imagepathfolder . '/pattern/pattern_2_thumb.png',
'pattern_3.png' => $imagepathfolder . '/pattern/pattern_3_thumb.png',
'pattern_4.png' => $imagepathfolder . '/pattern/pattern_4_thumb.png',
'pattern_5.png' => $imagepathfolder . '/pattern/pattern_5_thumb.png',
'pattern_6.png' => $imagepathfolder . '/pattern/pattern_6_thumb.png',
'pattern_7.png' => $imagepathfolder . '/pattern/pattern_7_thumb.png',
'pattern_8.png' => $imagepathfolder . '/pattern/pattern_8_thumb.png'
));


$options['evl_scheme_widgets'] = array( "name" => __( 'Background Color', 'aveone' ),
"desc" => __( 'Choose the color scheme for the background', 'aveone' ),
"id" => $aveone_shortname."_scheme_background_color",
"type" => "color",
"std" => "#000000"
);

$options['evl_scheme_background'] = array( "name" => __( 'Background Image', 'aveone' ),
"desc" => __( 'Upload an image for the area below header menu', 'aveone' ),
"id" => $aveone_shortname."_scheme_background",
"type" => "upload",
"std" => '',
);

$options['evl_scheme_background_100'] = array( "name" => __( '100% Background Image', 'aveone' ),
"desc" => __( 'Have background image always at 100% in width and height and scale according to the browser size.', 'aveone' ),
"id" => $aveone_shortname."_scheme_background_100",
"type" => "checkbox",
"std" => "0");

$options['evl_scheme_background_repeat'] = array( "name" => __( 'Background Repeat', 'aveone' ),
"desc" => "",
"id" => $aveone_shortname."_scheme_background_repeat",
"type" => "select",
"std" => "no-repeat",
"options" => array(
'repeat' => __( 'repeat', 'aveone' ),
'repeat-x' => __( 'repeat-x', 'aveone' ),
'repeat-y' => __( 'repeat-y', 'aveone' ),
'no-repeat' => __( 'no-repeat &nbsp;&nbsp;&nbsp;(default)', 'aveone' )
));

$options['evl_general_link'] = array( "name" => __( 'General Link Color', 'aveone' ),
"desc" => __( 'Custom color for links', 'aveone' ),
"id" => $aveone_shortname."_general_link",
"type" => "color",
"std" => "#7a9cad"
);

$options['evl_button_1'] = array( "name" => __( 'Buttons 1 Color', 'aveone' ),
"desc" => __( 'Custom color for buttons: Read more, Reply', 'aveone' ),
"id" => $aveone_shortname."_button_1",
"type" => "color",
"std" => ""
);

$options['evl_button_2'] = array( "name" => __( 'Buttons 2 Color', 'aveone' ),
"desc" => __( 'Custom color for buttons: Post Comment, Submit', 'aveone' ),
"id" => $aveone_shortname."_button_2",
"type" => "color",
"std" => ""
);

$options['evl_widget_background'] = array( "name" => __( 'Enable Widget Title Black Background', 'aveone' ),
"desc" => __( 'Check this box if you want to enable black background for widget titles', 'aveone' ),
"id" => $aveone_shortname."_widget_background",
"type" => "checkbox",
"std" => "0");

$options['evl_widget_background_image'] = array( "name" => __( 'Disable Widget Background', 'aveone' ),
"desc" => __( 'Check this box if you want to disable widget background', 'aveone' ),
"id" => $aveone_shortname."_widget_background_image",
"type" => "checkbox",
"std" => "0");

$options[] = array( "name" => $aveone_shortname."-tab-10", "id" => $aveone_shortname."-tab-10",
"type" => "close-tab" );


// Contact Options

$options[] = array( "id" => $aveone_shortname."-tab-6",
"type" => "open-tab");

$options['evl_contact_image'] = array( "name" => __( 'Contact Image', 'aveone' ),
"desc" => __( 'Select the you want to upload on the contact page.', 'aveone' ),
"id" => $aveone_shortname."_contact_image",
"std" => "",
"type" => "upload" );

$options['evl_contact_shortcode'] = array( "name" => __( 'Contact Form Shortcode', 'aveone' ),
"desc" => __( 'Copy/Paste Contact form shortcode.', 'aveone' ),
"id" => $aveone_shortname."_contact_shortcode",
"std" => "",
"type" => "text" );

$options['evl_gmap_type'] = array( "name" => __( 'Google Map Type', 'aveone' ),
"desc" => __( 'Select the type of google map to show on the contact page.', 'aveone' ),
"id" => $aveone_shortname."_gmap_type",
"std" => "hybrid",
"options" => array(
'roadmap' => __( 'roadmap', 'aveone' ), 
'satellite' => __( 'satellite', 'aveone' ),
'hybrid' => __( 'hybrid (default)', 'aveone' ),
'terrain' => __( 'terrain', 'aveone' ),
"type" => "select" ));

$options['evl_gmap_width'] = array( "name" => __( 'Google Map Width', 'aveone' ),
"desc" => __( '(in pixels or percentage, e.g.:100% or 100px)', 'aveone' ),
"id" => $aveone_shortname."_gmap_width",
"std" => "100%",
"type" => "text");

$options['evl_gmap_height'] = array( "name" => __( 'Google Map Height', 'aveone' ),
"desc" => __( '(in pixels, e.g.: 100px)', 'aveone' ),
"id" => $aveone_shortname."_gmap_height",
"std" => "415px",
"type" => "text");

$options['evl_gmap_address'] = array( "name" => __( 'Google Map Address', 'aveone' ),
"desc" => __( 'Example: 775 New York Ave, Brooklyn, Kings, New York 11203.<br /> For multiple markers, separate the addresses with the | symbol. ex: Address 1|Address 2|Address 3.', 'aveone' ),
"id" => $aveone_shortname."_gmap_address",
"std" => "Via dei Fori Imperiali",
"type" => "text");

$options['evl_bubble_marker_address'] = array( "name" => __( 'Google Map Bubble Marker Address', 'aveone' ),
"desc" => __( 'Example: 775 New York Ave, Brooklyn, Kings, New York 11203.<br /> For multiple markers, separate the addresses with the | symbol. ex: Address 1|Address 2|Address 3.', 'aveone' ),
"id" => $aveone_shortname."_bubble_marker_address",
"std" => "Via dei Fori Imperiali",
"type" => "text");

$options['evl_bubble_marker_city_state'] = array( "name" => __( 'Google Map Bubble Marker City/State', 'aveone' ),
"desc" => __( 'Displays City/State in Google Map Bubble Marker', 'aveone' ),
"id" => $aveone_shortname."_bubble_marker_city_state",
"std" => "",
"type" => "text");

$options['evl_bubble_marker_price'] = array( "name" => __( 'Google Map Bubble Marker Price', 'aveone' ),
"desc" => __( 'Displays Price in Google Map Bubble Marker', 'aveone' ),
"id" => $aveone_shortname."_bubble_marker_price",
"std" => "",
"type" => "text");

$options['evl_bubble_marker_agent'] = array( "name" => __( 'Google Map Bubble Marker Agent Name', 'aveone' ),
"desc" => __( 'Displays Agent Name in Google Map Bubble Marker', 'aveone' ),
"id" => $aveone_shortname."_bubble_marker_agent",
"std" => "",
"type" => "text");

$options['evl_sent_email_header'] = array( "name" => __( 'Sent Email Header (From)', 'aveone' ),
"desc" => __( 'Insert name of header which will be in the header of sent email.', 'aveone' ),
"id" => $aveone_shortname."_sent_email_header", 
"std" => get_bloginfo('name'), 
"type" => "text"); 

$options['evl_email_address'] = array( "name" => __( 'Email Address', 'aveone' ),
"desc" => __( 'Enter the email adress the form will be sent to.', 'aveone' ),
"id" => $aveone_shortname."_email_address",
"std" => "",
"type" => "text");

$options['evl_map_zoom_level'] = array( "name" => __( 'Map Zoom Level', 'aveone' ),
"desc" => __( 'Higher number will be more zoomed in.', 'aveone' ),
"id" => $aveone_shortname."_map_zoom_level",
"std" => "18",
"type" => "text");

$options[] = array( "name" => $aveone_shortname."-tab-6", "id" => $aveone_shortname."-tab-6",
"type" => "close-tab" );


// Agent Information

$options[] = array( "id" => $aveone_shortname."-tab-7", "type" => "open-tab");

$options['evl_agent_info_note'] = array( "name" => __( 'Note:', 'aveone' ),
"desc" => "Click the Link to add Agent Information.",
"id" => $aveone_shortname."_agent_information_note",
"type" => "note-for-agent-information",
"std" => ''
);

$options[] = array( "name" => $aveone_shortname."-tab-7", 
"id" => $aveone_shortname."-tab-7",
"type" => "close-tab" );


// Printable Info

$options[] = array( "id" => $aveone_shortname."-tab-4",
"type" => "open-tab");

$options['evl_printable_info_picture'] = array( "name" => __( 'Intro Picture', 'aveone' ),
"desc" => "",
"id" => $aveone_shortname."_printable_info_picture",
"type" => "upload",
"std" => ''
);

$options['evl_printable_info_text'] = array( "name" => __( 'Intro Text', 'aveone' ),
"desc" => "",
"id" => $aveone_shortname."_printable_info_text",
"type" => "editor",
"std" => ''
);

$options['evl_printable_info_note'] = array( "name" => __( 'Note:', 'aveone' ),
"desc" => "Click the Link to add attachments to Printable Info.",
"id" => $aveone_shortname."_printable_info_note",
"type" => "note-for-printables",
"std" => ''
);


$options[] = array( "name" => $aveone_shortname."-tab-4", 
"id" => $aveone_shortname."-tab-4",
"type" => "close-tab" );


// Property Details

$options[] = array( "id" => $aveone_shortname."-tab-3",
"type" => "open-tab");

$options['evl_property_price_type'] = array( "name" => __( 'Price Type', 'aveone' ),
"desc" => "",
"id" => $aveone_shortname."_property_price_type",
"type" => "select",
"std" => 'fixed',
"options" => array('fixed'=>'Fixed','range'=>'Range')    
);

$options['evl_property_price'] = array( "name" => __( 'Price', 'aveone' ),
"desc" => "",
"id" => $aveone_shortname."_property_price",
"type" => "text",
"std" => '',
);

$options['evl_property_price1'] = array( "name" => __( 'Min Price', 'aveone' ),
"desc" => "",
"id" => $aveone_shortname."_property_price1",
"type" => "text",
"std" => '',
);

$options['evl_property_price2'] = array( "name" => __( 'Max Price', 'aveone' ),
"desc" => "",
"id" => $aveone_shortname."_property_price2",
"type" => "text",
"std" => '',
);

$options['evl_property_type'] = array( "name" => __( 'Type', 'aveone' ),
"desc" => "",
"id" => $aveone_shortname."_property_type",
"type" => "select",
"std" => '',
"options" => array(
    '' => 'Select Type',
    'House' => 'House',
    'Condo' => 'Condo',
    'Ranch' => 'Ranch',
    'Lot' => 'Lot',
    'Townhouse' => 'Townhouse',
    'Commercial' => 'Commercial',
    'Duplex' => 'Duplex',
    'Loft' => 'Loft',
    'Land' => 'Land',
    'Multi-Family' => 'Multi-Family',
    'Single-Family' => 'Single-Family',
    'Office' => 'Office',
    'Retail' => 'Retail',
    'Mixed Development' => 'Mixed Development',
)
);

$options['evl_property_mls'] = array( "name" => __( 'MLS#', 'aveone' ),
"desc" => "",
"id" => $aveone_shortname."_property_mls",
"type" => "text",
"std" => '',
);

$options['evl_property_area'] = array( "name" => __( 'Area', 'aveone' ),
"desc" => "",
"id" => $aveone_shortname."_property_area",
"type" => "select",
"std" => '',
"options" => array(
    '' => 'N/A',
    '1B' => '1B',
    '1N' => '1N',
    '2' => '2',
    '3' => '4',
    '6' => '6',
    '7' => '7',
    'DT' => 'DT',
    'UT' => 'UT',
    '3' => '3',
    '5' => '5',
    '3E' => '3E',
    '5E' => '5E',
    'NE' => 'NE',
    '1A' => '1A',
    '2N' => '2N',
    'N' => 'N',
    'NW' => 'NW',
    '10N' => '10N',
    '10S' => '10S',
    'SWE' => 'SWE',
    'SWW' => 'SWW',
    '11' => '11',
    '9' => '9',
    'SC' => 'SC',
    'SE' => 'SE',
    '8W' => '8W',
    'RN' => 'RN',
    'W' => 'W',
    'CLN' => 'CLN',
    'LN' => 'LN',
    'MA' => 'MA',
    'BL' => 'BL',
    'HD' => 'HD',
    'LS' => 'LS',
    'GTE' => 'GTE',
    'GTW' => 'GTW',
    'HU' => 'HU',
    'JA' => 'JA',
    'PF' => 'PF',
    'RRE' => 'RRE',
    'RRW' => 'RRW',
    '8E' => '8E',
)
);

$options['evl_property_bedrooms'] = array( "name" => __( 'Bedrooms', 'aveone' ),
"desc" => "",
"id" => $aveone_shortname."_property_bedrooms",
"type" => "text",
"std" => '',
);

$options['evl_property_baths'] = array( "name" => __( 'Baths', 'aveone' ),
"desc" => "",
"id" => $aveone_shortname."_property_baths",
"type" => "text",
"std" => '',
);

$options['evl_property_living_areas'] = array( "name" => __( 'Living Areas', 'aveone' ),
"desc" => "",
"id" => $aveone_shortname."_property_living_areas",
"type" => "text",
"std" => '',
);

$options['evl_property_square_feet'] = array( "name" => __( 'Square Feet', 'aveone' ),
"desc" => "",
"id" => $aveone_shortname."_property_square_feet",
"type" => "text",
"std" => '',
);

$options['evl_property_school_district'] = array( "name" => __( 'School District', 'aveone' ),
"desc" => "",
"id" => $aveone_shortname."_property_school_district",
"type" => "text",
"std" => '',
);

$options['evl_property_view'] = array( "name" => __( 'View', 'aveone' ),
"desc" => "",
"id" => $aveone_shortname."_property_view",
"type" => "text",
"std" => '',
);

$options['evl_property_garages'] = array( "name" => __( 'Garages', 'aveone' ),
"desc" => "",
"id" => $aveone_shortname."_property_garages",
"type" => "text",
"std" => '',
);

$options['evl_property_year_built'] = array( "name" => __( 'Year Built', 'aveone' ),
"desc" => "",
"id" => $aveone_shortname."_property_year_built",
"type" => "text",
"std" => '',
);

$options['evl_property_lot_size'] = array( "name" => __( 'Lot Size', 'aveone' ),
"desc" => "",
"id" => $aveone_shortname."_property_lot_size",
"type" => "text",
"std" => '',
);

$options['evl_property_acreage'] = array( "name" => __( 'Acreage', 'aveone' ),
"desc" => "",
"id" => $aveone_shortname."_property_acreage",
"type" => "text",
"std" => '',
);

$options['evl_property_tour_link1'] = array( "name" => __( 'Tour Link 1', 'aveone' ),
"desc" => "",
"id" => $aveone_shortname."_property_tour_link1",
"type" => "text",
"std" => '',
);

$options['evl_property_tour_link2'] = array( "name" => __( 'Tour Link 2', 'aveone' ),
"desc" => "",
"id" => $aveone_shortname."_property_tour_link2",
"type" => "text",
"std" => '',
);

$options['evl_property_description'] = array( "name" => __( 'Property Description', 'aveone' ),
"desc" => "",
"id" => $aveone_shortname."_property_description",
"type" => "editor",
"std" => '',
);

$options[] = array( "name" => $aveone_shortname."-tab-3", 
"id" => $aveone_shortname."-tab-3",
"type" => "close-tab" );

// Meta Information

$options[] = array( "id" => $aveone_shortname."-tab-5",
"type" => "open-tab");

$options['evl_meta_keywords'] = array( "name" => __( 'Meta Keywords', 'aveone' ),
"desc" => "",
"id" => $aveone_shortname."_meta_keywords",
"type" => "textarea",
"std" => '',
);

$options['evl_meta_description'] = array( "name" => __( 'Meta Description', 'aveone' ),
"desc" => "",
"id" => $aveone_shortname."_meta_description",
"type" => "textarea",
"std" => '',
);

$options[] = array( "name" => $aveone_shortname."-tab-5", 
"id" => $aveone_shortname."-tab-5",
"type" => "close-tab" );


return $options;
}

/**
 * Front End Customizer
 *
 * WordPress 3.4 Required
 */
add_action( 'customize_register', 'aveone_customizer_register' );
        
function aveone_customizer_register( $wp_customize ) {
    /**
     * This is optional, but if you want to reuse some of the defaults
     * or values you already have built in the options panel, you
     * can load them into $options for easy reference
     */
	get_template_part('library/functions/customizer-class') ; 
    $customizer_array = array(
        'layout' => array(
            'name' => __( 'General', 'aveone'),
            'priority' => 101,
            'settings' => array(
				        'evl_favicon',
                'evl_layout',            
                'evl_width_layout',
                'evl_width_px',
                )
        ),
        'header' => array(
            'name' => __( 'Header', 'aveone'),
            'priority' => 102,
            'settings' => array(
                'evl_header_logo',
                'evl_pos_logo',
                'evl_blog_title',
                'evl_tagline_pos',
                'evl_main_menu',
                'evl_sticky_header',
                'evl_searchbox',
                'evl_widgets_header',                
                'evl_header_widgets_placement',
            )
        ),
        'footer' => array(
            'name' => __( 'Footer', 'aveone'),
            'priority' => 103,
            'settings' => array(
                'evl_widgets_num',
                'evl_footer_content',
            )
        ),   
        'typography' => array(
            'name' => __( 'Typography', 'aveone'),
            'priority' => 104,
            	'settings' => array(
                'evl_title_font',
                'evl_tagline_font',
                'evl_menu_font',
                'evl_post_font',
                'evl_content_font',
                'evl_heading_font',
         
            )
        ),    
        'styling' => array(
            'name' => __( 'Styling', 'aveone'),
            'priority' => 105,
            'settings' => array(
                'evl_content_back',
                'evl_menu_back',
                'evl_menu_back_color',
                'evl_disable_menu_back',
                'evl_header_footer_back_color',
                'evl_pattern',
                'evl_scheme_widgets',
                'evl_scheme_background',
                'evl_scheme_background_100',
                'evl_scheme_background_repeat',
                'evl_general_link',
                'evl_button_1',
                'evl_button_2',
                'evl_widget_background',
                'evl_widget_background_image',
            )
        ),      
        'blog' => array(
            'name' => __( 'Blog', 'aveone'),
            'priority' => 106,
            'settings' => array(
                'evl_post_layout',
                'evl_excerpt_thumbnail',
                'evl_featured_images',
                'evl_blog_featured_image',                
                'evl_author_avatar',
                'evl_header_meta',
				'evl_category_page_title',
                'evl_posts_excerpt_title_length',                
                'evl_share_this',
                'evl_post_links',
                'evl_similar_posts',
				'evl_pagination_type'
            )
        ),   
        'social' => array(
            'name' => __( 'Social Media Links', 'aveone'),
            'priority' => 107,
            'settings' => array(
                'evl_social_links',
                'evl_social_color_scheme',
                'evl_social_icons_size',
                'evl_show_rss',                
                'evl_rss_feed',
                'evl_newsletter',
                'evl_facebook',
                'evl_twitter_id',
                'evl_instagram',
                'evl_skype',
                'evl_youtube',
                'evl_flickr',
                'evl_linkedin',
                'evl_googleplus',
                'evl_pinterest',                
            )
        ),   
        'boxes' => array(
            'name' => __( 'Front Page Content Boxes', 'aveone'),
            'priority' => 108,
            'settings' => array(
               'evl_content_boxes',
               'evl_content_box1_title',
               'evl_content_box1_icon',
               'evl_content_box1_icon_color',
               'evl_content_box1_desc',
               'evl_content_box1_button',
               'evl_content_box2_title',
               'evl_content_box2_icon',
               'evl_content_box2_icon_color',
               'evl_content_box2_desc',
               'evl_content_box2_button',
               'evl_content_box3_title',
               'evl_content_box3_icon',
               'evl_content_box3_icon_color',
               'evl_content_box3_desc',
               'evl_content_box3_button',
			   'evl_content_box4_title',
			   'evl_content_box4_icon',
			   'evl_content_box4_icon_color',
			   'evl_content_box4_desc',
			   'evl_content_box4_button',
            )
        ),    
        'bootstrap' => array(
            'name' => __( 'Bootstrap Slider', 'aveone'),
            'priority' => 109,
            'settings' => array(
               'evl_bootstrap_slider',
               'evl_bootstrap_speed',
               'evl_bootstrap_slide_title_font',
               'evl_bootstrap_slide_desc_font',
               'evl_bootstrap_slide1',
               'evl_bootstrap_slide1_img',
               'evl_bootstrap_slide1_title',
               'evl_bootstrap_slide1_desc',
               'evl_bootstrap_slide1_button',
               'evl_bootstrap_slide2',
               'evl_bootstrap_slide2_img',
               'evl_bootstrap_slide2_title',
               'evl_bootstrap_slide2_desc',
               'evl_bootstrap_slide2_button',
               'evl_bootstrap_slide3',
               'evl_bootstrap_slide3_img',
               'evl_bootstrap_slide3_title',
               'evl_bootstrap_slide3_desc',
               'evl_bootstrap_slide3_button',
               'evl_bootstrap_slide4',
               'evl_bootstrap_slide4_img',
               'evl_bootstrap_slide4_title',
               'evl_bootstrap_slide4_desc',
               'evl_bootstrap_slide4_button',
               'evl_bootstrap_slide5',
               'evl_bootstrap_slide5_img',
               'evl_bootstrap_slide5_title',
               'evl_bootstrap_slide5_desc',
               'evl_bootstrap_slide5_button',
            )
        ),        
        'parallax' => array(
            'name' => __( 'Parallax Slider', 'aveone'),
            'priority' => 110,
            'settings' => array(        
               'evl_parallax_slider',
               'evl_parallax_speed',
               'evl_parallax_slide_title_font',
               'evl_parallax_slide_desc_font',
               'evl_show_slide1',
               'evl_slide1_img',
               'evl_slide1_title',
               'evl_slide1_desc',
               'evl_slide1_button',
               'evl_show_slide2',
               'evl_slide2_img',
               'evl_slide2_title',
               'evl_slide2_desc',
               'evl_slide2_button',
               'evl_show_slide3',
               'evl_slide3_img',
               'evl_slide3_title',
               'evl_slide3_desc',
               'evl_slide3_button',
               'evl_show_slide4',
               'evl_slide4_img',
               'evl_slide4_title',
               'evl_slide4_desc',
               'evl_slide4_button',
               'evl_show_slide5',
               'evl_slide5_img',
               'evl_slide5_title',
               'evl_slide5_desc',
               'evl_slide5_button',
            )
        ),   
        'posts' => array(
            'name' => __( 'Posts Slider', 'aveone'),
            'priority' => 111,
            'settings' => array(        
               'evl_posts_slider',
               'evl_posts_number',
               'evl_posts_slider_content',
               'evl_posts_slider_id',
               'evl_carousel_speed',
               'evl_carousel_slide_title_font',
               'evl_carousel_slide_desc_font',
            )
        ),   
        'contact' => array(
            'name' => __( 'Contact', 'aveone'),
            'priority' => 112,
            'settings' => array(        
               'evl_gmap_type',
               'evl_gmap_width',
               'evl_gmap_height',
               'evl_gmap_address',
               'evl_sent_email_header',
               'evl_email_address',
               'evl_map_zoom_level',
               'evl_map_pin',
               'evl_map_popup',
               'evl_map_scrollwheel',
               'evl_map_scale',
               'evl_map_zoomcontrol',
            )
        ),    
        'extra' => array(
            'name' => __( 'Extra', 'aveone'),
            'priority' => 113,
            'settings' => array(        
               'evl_breadcrumbs',
               'evl_nav_links',
               'evl_pos_button',
               'evl_parallax_slider_support',
               'evl_carousel_slider',
               'evl_status_gmap',
               'evl_animatecss',
            )
        ),   
        'css' => array(
            'name' => __( 'Custom CSS', 'aveone'),
            'priority' => 114,
            'settings' => array(        
               'evl_css_content',
            )
        ),          
                                                                      
    );
	global $my_image_controls;
	$my_image_controls = array();
    $options = aveone_options();
    $i = 0;
    foreach ( $customizer_array as $name => $val ) {
        $wp_customize->add_section( "aveone-theme_$name", array(
            'title' => $val['name'],
            'priority' => $val['priority']
        ) );
        foreach ( $val['settings'] as $setting ) {

			$options[$setting]['std']	= isset( $options[$setting]['std'] ) ? $options[$setting]['std'] : '';
			$options[$setting]['type']	= isset( $options[$setting]['type'] ) ? $options[$setting]['type'] : '';

			//aveone_sanitize_typography
        	if ( $options[$setting]['type'] == 'typography' ){
        		$wp_customize->add_setting( "aveone-theme[$setting]", array(
	                'default' => $options[$setting]['std'],
	                'type' => 'option',
	                'sanitize_callback' => 'aveone_sanitize_typography',
	            ) );
        	}

        	else{
                
                
               /*             
	            $wp_customize->add_setting( "aveone-theme[$setting]", array(
	                'default' => $options[$setting]['std'],
	                'type' => 'option'
	            ) );
                 */
                
                 //sanitize everything else
                
                switch($options[$setting]['id'])
                {
                   
                       
                    /* image sanitization start */
                    case "evl_favicon":
                    case "evl_header_logo":
                    case "evl_scheme_background":
                    case "evl_bootstrap_slide1_img":
                    case "evl_bootstrap_slide2_img":
                    case "evl_bootstrap_slide3_img":
                    case "evl_bootstrap_slide4_img":
                    case "evl_bootstrap_slide5_img":
                    case "evl_slide1_img":
                    case "evl_slide2_img":
                    case "evl_slide3_img":
                    case "evl_slide4_img":
                    case "evl_slide5_img":
                    case "evl_scheme_background":
                    
                       $wp_customize->add_setting( "aveone-theme[$setting]", array(
	                       'default' => $options[$setting]['std'],
                           'type' => 'option',
                           'sanitize_callback' => 'aveone_sanitize_upload'
	                    ));
                    
                       break;
                 
                    // image sanitization end
                    
                   
                    // hex color sanitization start
                    
                    case "evl_menu_back_color":
                    case "evl_header_footer_back_color":
                    case "evl_scheme_widgets":
                    case "evl_general_link":
                    case "evl_button_1":
                    case "evl_button_2":
                    case "evl_social_color_scheme":
                    case "evl_content_box1_icon_color":
                    case "evl_content_box2_icon_color":
                    case "evl_content_box3_icon_color":
					case "evl_content_box4_icon_color":
                    
                    
                        $wp_customize->add_setting( "aveone-theme[$setting]", array(
	                       'default' => $options[$setting]['std'],
                           'type' => 'option',
                           'sanitize_callback' => 'aveone_sanitize_hex'
	                    ));
                    
                    break;
                    
                    
                  
                    // hex color sanitization end 
                    
            
                    
                    // select sanitization start 
                    case "evl_layout":
                    case "evl_width_layout":
                    case "evl_post_links":
                    case "evl_pos_logo":
                    case "evl_tagline_pos":
                    case "evl_widgets_header":
                    case "evl_header_widgets_placement":
                    case "evl_widgets_num":
                    case "evl_content_back":
                    case "evl_menu_back":
                    case "evl_pattern":
                    case "evl_scheme_background_repeat":
                    case "evl_post_layout":
                    case "evl_header_meta":
                    case "evl_share_this":
                    case "evl_similar_posts":
					case "evl_pagination_type":
                    case "evl_social_icons_size":
                    case "evl_bootstrap_slider":
                    case "evl_parallax_slider":
                    case "evl_posts_slider":
                    case "evl_posts_number":
                    case "evl_posts_slider_content":
                    case "evl_gmap_type":
                    case "evl_nav_links":
                    case "evl_pos_button":
                    
                        $wp_customize->add_setting( "aveone-theme[$setting]", array(
	                       'default' => $options[$setting]['std'],
                           'type' => 'option',
                           'sanitize_callback' => 'aveone_sanitize_choices'
	                    ));
                    
                    break;
                    
                  
                    // select sanitization end 
                 
                    
                    // numerical text sanitization start 
                    
                    case "evl_bootstrap_speed":
                    case "evl_parallax_speed":
                    case "evl_carousel_speed":
                    case "evl_map_zoom_level":
                    case "evl_width_px":
                    case "evl_posts_excerpt_title_length":  
					case "evl_category_page_title":
                        $wp_customize->add_setting( "aveone-theme[$setting]", array(
	                       'default' => $options[$setting]['std'],
                           'type' => 'option',
                           'sanitize_callback' => 'aveone_sanitize_numbers'
	                    ));
                    
                    break;
                    
                    // numerical text sanitization end 
                    
                    
                    // pixel sanitization start 
                    
                    case "evl_gmap_width":
                    case "evl_gmap_height":
                        $wp_customize->add_setting( "aveone-theme[$setting]", array(
	                       'default' => $options[$setting]['std'],
                           'type' => 'option',
                           'sanitize_callback' => 'aveone_sanitize_pixel'
	                    ));
                    
                    break;
                    
                    // pixel sanitization end 
                    
                    
                    
                    
                    // text url sanitization start 
                                      
                    case "evl_newsletter":
                    case "evl_facebook":
                    case "evl_rss_feed":
                    case "evl_twitter_id":
                    case "evl_instagram":
                    case "evl_skype":
                    case "evl_youtube":
                    case "evl_flickr":
                    case "evl_linkedin":
                    case "evl_googleplus":
                    case "evl_pinterest":
                    
                        $wp_customize->add_setting( "aveone-theme[$setting]", array(
	                       'default' => $options[$setting]['std'],
                           'type' => 'option',
                           'sanitize_callback' => 'esc_url_raw'
	                    ));
                    
                      break;
                    
                            
                    // text url sanitization end 
                    
                    
                    
                    // text field sanitization start 
                    
                    case "evl_content_box1_title":
                    case "evl_bootstrap_slide1_title":
                    case "evl_bootstrap_slide2_title":
                    case "evl_bootstrap_slide3_title":
                    case "evl_bootstrap_slide4_title":
                    case "evl_bootstrap_slide5_title":
                    case "evl_content_box2_title":
                    case "evl_content_box3_title":
					case "evl_content_box4_title":
                    case "evl_slide1_title":
                    case "evl_slide2_title":
                    case "evl_slide3_title":
                    case "evl_slide4_title":
                    case "evl_slide5_title":
                    case "evl_posts_slider_id":
                    case "evl_gmap_address":
                    case "evl_sent_email_header":
                        $wp_customize->add_setting( "aveone-theme[$setting]", array(
	                       'default' => $options[$setting]['std'],
                           'type' => 'option',
                           'sanitize_callback' => 'aveone_sanitize_text_field'
	                    ));
                    
                    break;
                    
                     // text field sanitization end 
                    
                    
                    
                    // fontawesome fields sanitization start 
                     
                    case "evl_content_box1_icon":
                    case "evl_content_box2_icon":
                    case "evl_content_box3_icon":
					case "evl_content_box4_icon":
                    
                        $wp_customize->add_setting( "aveone-theme[$setting]", array(
	                       'default' => $options[$setting]['std'],
                           'type' => 'option',
                           'sanitize_callback' => 'aveone_sanitize_text_field'
	                    ));
                    
                    break;
                    
                   // fontawesome fields sanitization end 
                    
                    
                    
                    // text email field sanitization start 
                    
                    case "evl_email_address":
                    
                        $wp_customize->add_setting( "aveone-theme[$setting]", array(
	                       'default' => $options[$setting]['std'],
                           'type' => 'option',
                           'sanitize_callback' => 'sanitize_email'
	                    ));
                    
                    break;
                    
                    
                    // text email field sanitization end 
                    
                    
                    
                    
                    
                   
                    
                    // textarea sanitization start 
                    
                    case "evl_footer_content":
                    case "evl_content_box1_desc":
                    case "evl_content_box1_button":
                    case "evl_content_box2_desc":
                    case "evl_content_box2_button":
                    case "evl_content_box3_desc":
                    case "evl_content_box3_button":
					case "evl_content_box4_desc":
					case "evl_content_box4_button":
                    case "evl_bootstrap_slide1_desc":
                    case "evl_bootstrap_slide1_button":
                    case "evl_bootstrap_slide2_desc":
                    case "evl_bootstrap_slide2_button":
                    case "evl_bootstrap_slide3_desc":
                    case "evl_bootstrap_slide3_button":
                    case "evl_bootstrap_slide4_desc":
                    case "evl_bootstrap_slide4_button":
                    case "evl_bootstrap_slide5_desc":
                    case "evl_bootstrap_slide5_button":
                    case "evl_slide1_desc":
                    case "evl_slide1_button":
                    case "evl_slide2_desc":
                    case "evl_slide2_button":
                    case "evl_slide3_desc":
                    case "evl_slide3_button":
                    case "evl_slide4_desc":
                    case "evl_slide4_button":
                    case "evl_slide5_desc":
                    case "evl_slide5_button":
                    case "evl_css_content":
                     
                        $wp_customize->add_setting( "aveone-theme[$setting]", array(
	                       'default' => $options[$setting]['std'],
                           'type' => 'option',
                           'sanitize_callback' => 'aveone_sanitize_textarea'
	                    ));
                    
                        break;
                  
                    // textarea sanitization end 
                    
                    
                    
                    // checkbox sanitization start 
                    
                    case "evl_blog_title":
                    case "evl_main_menu":
                    case "evl_disable_menu_back":
                    case "evl_scheme_background_100":
                    case "evl_widget_background":
                    case "evl_widget_background_image":
					case "evl_pagination_type":
                    case "evl_excerpt_thumbnail":
                    case "evl_author_avatar":
                    case "evl_map_pin":
                    case "evl_map_popup":
                    case "evl_map_scrollwheel":
                    case "evl_map_scale":
                    case "evl_map_zoomcontrol":
                    // Following has 1 by default for the checkbox 
                    case "evl_sticky_header":
                    case "evl_searchbox":
                    case "evl_featured_images":
                    case "evl_blog_featured_image":                    
                    case "evl_social_links":
                    case "evl_show_rss":
                    case "evl_content_boxes":
                    case "evl_bootstrap_slide1":
                    case "evl_bootstrap_slide2":
                    case "evl_bootstrap_slide3":
                    case "evl_bootstrap_slide4":
                    case "evl_bootstrap_slide5":
                    case "evl_show_slide1":
                    case "evl_show_slide2":
                    case "evl_show_slide3":
                    case "evl_show_slide4":
                    case "evl_show_slide5":
                    case "evl_breadcrumbs":
                    case "evl_parallax_slider_support":
                    case "evl_carousel_slider":
                    case "evl_status_gmap":
                    case "evl_animatecss":
                   
                       $wp_customize->add_setting( "aveone-theme[$setting]", array(
	                       'default' => $options[$setting]['std'],
                           'type' => 'option',
                           'sanitize_callback' => 'aveone_sanitize_checkbox'
	                    ));
                       break;
                    
                    // checkbox sanitization end
                    
                    
                    
                }                
        	}

            
            if ( $options[$setting]['type'] == 'radio' || $options[$setting]['type'] == 'select' ) {
                $wp_customize->add_control( "aveone-theme_$setting", array(
                    'label' => $options[$setting]['name'],
                    'section' => "aveone-theme_$name",
                    'settings' => "aveone-theme[$setting]",
                    'type' => $options[$setting]['type'],
                    'choices' => $options[$setting]['options'],
                    'priority' => $i
                ) );
            } elseif ( $options[$setting]['type'] == 'text' || $options[$setting]['type'] == 'checkbox' ) {
                $wp_customize->add_control( "aveone-theme_$setting", array(
                    'label' => $options[$setting]['name'],
                    'section' => "aveone-theme_$name",
                    'settings' => "aveone-theme[$setting]",
                    'type' => $options[$setting]['type'],
                    'priority' => $i
                ) );
            } elseif ( $options[$setting]['type'] == 'color' ) {
                $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "aveone-theme_$setting", array(
                            'label' => $options[$setting]['name'],
                            'section' => "aveone-theme_$name",
                            'settings' => "aveone-theme[$setting]",
                            'type' => $options[$setting]['type'],
                            'priority' => $i
                                ) ) );

            /********************************************
            *
            * Typography add new by ddo
            *
            * code cho class aveone_Customize_Typography_Control dat o :
            * library/functions/customizer-class.php
            *
            *********************************************/
            
            } elseif ( $options[$setting]['type'] == 'typography' ) {
            	
                $wp_customize->add_control( new aveone_Customize_Typography_Control( $wp_customize, "aveone-theme_$setting", array(
                            'label' => $options[$setting]['name'],
                            'section' => "aveone-theme_$name",
                            'settings' => "aveone-theme[$setting]",
                             
                            'priority' => $i
                                ) ) );    

            } elseif ( $options[$setting]['type'] == 'upload' ) {
				$my_image_controls["aveone-theme_$setting"] =  aveone_add_image_control($options,$setting, $name,$i);

				
			} elseif ( $options[$setting]['type'] == 'images' ) {
                $wp_customize->add_control( new aveone_Customize_Image_Control( $wp_customize, "aveone-theme_$setting", array(
                            'label' => $options[$setting]['name'],
                            'section' => "aveone-theme_$name",
                            'settings' => "aveone-theme[$setting]",
							'type' => $options[$setting]['type'],
							'choices' => $options[$setting]['options'],
							'priority' => $i
                                ) ) );
            } elseif ( $options[$setting]['type'] == 'textarea' ) {
                $wp_customize->add_control( new aveone_Customize_Textarea_Control( $wp_customize, "aveone-theme_$setting", array(
                            'label' => $options[$setting]['name'],
                            'section' => "aveone-theme_$name",
                            'settings' => "aveone-theme[$setting]",
							'type' => $options[$setting]['type'],
							'priority' => $i
                                ) ) );
            }
            $i++;
        }
    }
    foreach ($my_image_controls as $id => $control) {
				   $control->add_tab( 'library',   __( 'Media Library', 'aveone' ), 'aveone_library_tab' );
            
     }     

} 

function aveone_library_tab() {
	
    global $my_image_controls;
    static $tab_num = 0; // Sync tab to each image control
   
    $control = array_slice($my_image_controls, $tab_num, 1);
      
    ?>
    <a class="choose-from-library-link button"
        data-controller = "<?php printf ('%s', esc_attr( key($control) )); ?>">
        <?php _e( 'Open Library', 'aveone' ); ?>
    </a>
     
    <?php
    $tab_num++;

}   

function aveone_add_image_control( $options,$setting, $name,$i) {
    global $wp_customize;
    $control =
    new WP_Customize_Image_Control( $wp_customize, "aveone-theme_$setting",
        array(
        'label'         => $options[$setting]['name'],
        'section'       => "aveone-theme_$name",
        'priority'      => $i,
        'settings'      => "aveone-theme[$setting]"// "aveone-theme[$setting]"
        )
    );
   
    $wp_customize->add_control($control);
    return $control;
}