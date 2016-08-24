<span id="wpv-shortcode-generator-target">
        [wpv-map-marker
            map_id='<?php echo $atts['map_id'];?>'
            marker_id='<?php echo $atts['marker_id'];?>'
            marker_icon='http://aveone.agentassets.com/wp-content/plugins/toolset-maps/resources/images/markers/Home.png'
            address='<?php echo $atts['address'];?>'
        ]
        <div style="color: #000;">

            <?php if (!empty($atts['bubble_marker_address'])): ?>
                <strong><?php echo $atts['bubble_marker_address']; ?></strong><br/>
            <?php endif; ?>

            <?php if (!empty($atts['city_state'])): ?>
                <strong><?php echo $atts['city_state']; ?></strong><br/>
            <?php endif; ?>

            <?php if (!empty($atts['price'])): ?>
                <strong>Price:</strong> <?php echo $atts['price'];?><br/>
            <?php endif; ?>

            <?php if (!empty($atts['agent_name'])): ?>
          <strong><em>Represented By:</strong> <?php echo $atts['agent_name'];?></em>
        <?php endif; ?>

        </div>
        [/wpv-map-marker]
    </span>
<span id="wpv-shortcode-generator-target">
        [wpv-map-render map_id='<?php echo $atts['map_id'];?>' map_height='<?php echo $atts['map_height'];?>']
    </span>
<?php if ($atts['show_focus_map_button'] == 1) { ?>
    <br/>
    <div><a class="js-wpv-addon-maps-focus-map button" href="#" data-map="<?php echo $atts['map_id'];?>" data-marker="<?php echo $atts['marker_id'];?>">Focus on marker</a></div>
<?php } ?>