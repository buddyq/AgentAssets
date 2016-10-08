<?php
include plugin_dir_path(__DIR__) . 'helpers/AAGoogleMapApi.php';

add_shortcode('aa-map-render', 'agentassets_map_render_shortcode');

function agentassets_map_render_shortcode($atts, $content, $tag)
{
    $contactsInfo = (class_exists('ContactInfoModel')) ? ContactInfoModel::model() : null;
    $atts = shortcode_atts(array(
        'map_id' => 'location_map',
        'marker_id' => 'address_marker',
        'map_height' => '500px',
        'show_focus_map_button' => 1,
        'address' => $contactsInfo ? $contactsInfo->google_map_address : get_option('google_map_address'),
        'city_state' => $contactsInfo ? $contactsInfo->google_map_bubble_marker_city_state : get_option('google_map_bubble_marker_city_state'),
        'bubble_marker_address' => $contactsInfo ? $contactsInfo->google_map_bubble_marker_address : get_option('google_map_bubble_marker_address'),
        'agent_name' => $contactsInfo ? $contactsInfo->google_map_bubble_marker_agentname : get_option('google_map_bubble_marker_agentname'),
        'price' => $contactsInfo ? $contactsInfo->google_map_bubble_marker_price : get_option('google_map_bubble_marker_price'),
        
        'map_type_id' => 'roadmap',
        'map_width' => '100%',
        'zoom' => 14,
        'latitude' => '',
        'longitude' => '',
        'scrollwheel' => true,
        'disable_default_ui' => false,
        'api_key' => 'AIzaSyCFVCN5SzM9EzvW-5FzL3nHhmcCkY1EYr4',
        'marker_size' => 0,
        'marker_url' => plugins_url('agentassets_custom/images/marker.png'),
        
        'open_window' => true,
    ), $atts);

    
    $googleMapApi = new AAGoogleMapApi($atts);
    $googleMapApi->showMap();

//    return do_shortcode(AACRender::instance(AA_CUSTOM_RENDER_INSTANCE)->srender('aa-map-render', 'shortcode', array(
//        'atts' => $atts, 'gma' => $googleMapApi
//    )));
    
}