<?php

add_shortcode('aa-media-image', 'aa_media_image_shortcode');

function aa_media_image_shortcode($atts, $content) {
    $atts = shortcode_atts(array(
        'size' => 'full',
        'class' => '',
        'alt' => '',
        'title' => '',
        'height' => '',
        'width' => '',
        'align' => '',
        'default' => '',
        'style' => '',
    ), $atts);

    $mediaIdRaw = do_shortcode($content);

    $blogId = null;
    if (false !== mb_strpos($mediaIdRaw, ',')) {
        $idComponens = explode(',', $mediaIdRaw);
        if (count($idComponens) == 2) {
            $mediaIdRaw = $idComponens[1];
            $blogId = filter_var($idComponens[0], FILTER_SANITIZE_NUMBER_INT);
        }
    }
    $mediaId = filter_var($mediaIdRaw, FILTER_SANITIZE_NUMBER_INT);

    if ($blogId) {
        switch_to_blog($blogId);
    }
    $image = wp_get_attachment_image_src((int)$mediaId, $atts['size']);
    if ($blogId) {
        restore_current_blog();
    }
    $image_url = ($image) ? $image[0] : $atts['default'];

    return '<img src="'.$image_url.'" '
        . (empty($atts['class']) ? '' : 'alt="'.htmlspecialchars($atts['class']).'" ')
        . (empty($atts['alt']) ? '' : 'alt="'.htmlspecialchars($atts['alt']).'" ')
        . (empty($atts['title']) ? '' : 'title="'.htmlspecialchars($atts['title']).'" ')
        . (empty($atts['align']) ? '' : 'align="'.htmlspecialchars($atts['align']).'" ')
        . (empty($atts['height']) ? '' : 'height="'.htmlspecialchars($atts['height']).'" ')
        . (empty($atts['width']) ? '' : 'align="'.htmlspecialchars($atts['width']).'" ')
        . (empty($atts['style']) ? '' : 'style="'.htmlspecialchars($atts['style']).'" ')
        . '/>';
}
