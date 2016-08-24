<?php
add_shortcode('aa-printable-info', 'printable_info_shortcode');

function printable_info_shortcode()
{
    return AACRender::instance(AA_CUSTOM_RENDER_INSTANCE)->srender('aa-printable-info', 'shortcode', array(
        'model' => PrintableInfoModel::model(),
    ));
}