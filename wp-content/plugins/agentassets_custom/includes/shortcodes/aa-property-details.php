<?php
add_shortcode('aa-property-details', 'property_details_shortcode');

function property_details_shortcode()
{
    return AACRender::instance(AA_CUSTOM_RENDER_INSTANCE)->srender('aa-property-details', 'shortcode', array(
        'model' => PropertyDetailsModel::model(),
    ));
}