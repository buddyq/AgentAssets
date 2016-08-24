<?php
add_shortcode('aa-contact-page', 'contact_page_shortcode');

function contact_page_shortcode($atts, $content)
{
    return AACRender::instance(AA_CUSTOM_RENDER_INSTANCE)->srender('aa-contact-page', 'shortcode', array(
        'model' => ContactInfoModel::model(),
        'atts' => $atts,
        'content' => $content,
    ));
}