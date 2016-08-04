<?php

add_shortcode('aa-map-render', 'agentassets_map_render_shortcode');

function agentassets_map_render_shortcode($atts, $content) {
    $atts = shortcode_atts(array(
        'map_id' => 'location_map',
        'marker_id' => 'address_marker',
        'map_height' => '500px',
        'show_focus_map_button' => 1,
        'address' => get_option('google_map_address'),
        'bubble_marker_address' => get_option('google_map_bubble_marker_address'),
        'agent_name' => get_option('google_map_agent_name'),
    ), $atts);
    ob_start(); ?>

    <span id="wpv-shortcode-generator-target">
        [wpv-map-marker
            map_id='<?php echo $atts['map_id'];?>'
            marker_id='<?php echo $atts['marker_id'];?>'
            marker_title='<?php echo $atts['bubble_marker_address'];?>'
            marker_icon='http://aveone.agentassets.com/wp-content/plugins/toolset-maps/resources/images/markers/Home.png'
            address='<?php echo $atts['address'];?>'
        ]<?php echo $atts['agent_name'];?>[/wpv-map-marker]
    </span>
    <span id="wpv-shortcode-generator-target">
        [wpv-map-render map_id='<?php echo $atts['map_id'];?>' map_height='<?php echo $atts['map_height'];?>']
    </span>
    <?php if ($atts['show_focus_map_button'] == 1) { ?>
    <a class="js-wpv-addon-maps-focus-map button" href="#" data-map="<?php echo $atts['map_id'];?>" data-marker="<?php echo $atts['marker_id'];?>">Focus on marker</a>
    <?php } ?>

    <?php
    $html = ob_get_contents();
    ob_end_clean();
    return do_shortcode($html);
}