<?php

add_shortcode('aa-media-image', 'aa_media_image_shortcode');

function aa_media_image_shortcode($atts, $content) {
    $atts = shortcode_atts(array(
        'size' => 'full',
        'class' => '',
        'alt' => '',
        'title' => '',
        'align' => '',
    ), $atts);

    $mediaIdRaw = do_shortcode($content);
    $mediaId = filter_var($mediaIdRaw, FILTER_SANITIZE_NUMBER_INT);

    $image = wp_get_attachment_image_src((int)$mediaId, $atts['size']);
    $image_url = ($image) ? $image[0] : '';

    return '<img src="'.$image_url.'" '
        . (empty($atts['class']) ? '' : 'alt="'.$atts['class'].'" ')
        . (empty($atts['alt']) ? '' : 'alt="'.$atts['alt'].'" ')
        . (empty($atts['title']) ? '' : 'title="'.$atts['title'].'" ')
        . (empty($atts['align']) ? '' : 'align="'.$atts['align'].'" ')
        . '/>';
}
