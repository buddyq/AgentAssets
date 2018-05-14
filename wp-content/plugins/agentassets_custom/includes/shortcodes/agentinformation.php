<?php
add_shortcode('agentinformation', 'agentinformation_shortcode');
add_shortcode('agentinformation_first_name', 'agentinformation_first_name_shortcode');
add_shortcode('agentinformation_designation', 'agentinformation_designation_shortcode');
add_shortcode('agentinformation_business_phone', 'agentinformation_business_phone_shortcode');
add_shortcode('agentinformation_mobile_phone', 'agentinformation_mobile_phone_shortcode');
add_shortcode('agentinformation_profile_picture', 'agentinformation_profile_picture_shortcode');
add_shortcode('agentinformation_broker_name', 'agentinformation_broker_name_shortcode');
add_shortcode('agentinformation_broker_website', 'agentinformation_broker_website_shortcode');
add_shortcode('agentinformation_broker_logo', 'agentinformation_broker_logo_shortcode');
add_shortcode('agentinformation_facebook', 'agentinformation_facebook_shortcode');
add_shortcode('agentinformation_twitter', 'agentinformation_twitter_shortcode');
add_shortcode('agentinformation_googleplus', 'agentinformation_googleplus_shortcode');
add_shortcode('agentinformation_bloginfo', 'agentinformation_bloginfo_shortcode');
add_shortcode('agentinformation_email', 'agentinformation_email_shortcode');
add_shortcode('agentinformation_contact_page_image', 'agentinformation_contact_page_image_shortcode');

function agentinformation_shortcode($atts)
{
    $value = null;
    if (isset($atts['key'])) {
        $blog_id = get_current_blog_id();
        $user_id = OrderMap::getBlogOwner($blog_id);
        if (!$user_id) $user_id = 1;
        $user_info = get_userdata($user_id);

        $defaults = array(
            'profile_picture' => plugins_url('aa-site-customizer') . '/inc/images/dummy_agent_pic.png',
            'broker_logo' => plugins_url('aa-site-customizer') . '/inc/images/placeholder_wide.jpg',
            'contact_page_image' => 'error',
            'email' => 'buddy'.$user_info->user_email,
        );

        $value = get_user_meta($user_id, $atts['key'], true);
        if (empty($value)) {
            $value = get_option($atts['key']);
        }


        if (in_array($atts['key'], array('profile_picture', 'broker_logo', 'contact_page_image'))) {
            if (!empty($value)) {
                $size = 'full';

                if (!empty($atts['size'])) {
                    $size = $atts['size'];
                } else if (!empty($atts['width']) && !empty($atts['height'])) {
                    $size = array($atts['width'], $atts['height']);
                }

                $attachment_blog_id = 1;
                if (is_array($value)) {
                    $attachment_blog_id = $value[0];
                    $value = $value[1];
                }
                if (is_numeric($value) && $value > 0) {

                    // if ($attachment_blog_id != $blog_id) {
                    //     switch_to_blog($attachment_blog_id);
                    // }
                    $alt = (empty($atts['alt'])) ? '' : $atts['alt'];
                    $title = (empty($atts['title'])) ? '' : $atts['title'];
                    $align = (empty($atts['align'])) ? '' : $atts['align'];
                    $value = get_image_tag($value, $alt, $title, $align, $size);

                    if ($attachment_blog_id != $blog_id) {
                        switch_to_blog($blog_id);
                    }
                }
            }
        }

        if (isset($defaults[$atts['key']]) && empty($value)) {
            $value = $defaults[$atts['key']];
        }
    }
    return $value;
}

/**
 * function for debug values
 *
 * @param $var
 * @param $die
 * @param string $label
 * @return bool
 */
function showVar($var, $die, $label = '')
{
    if (!isset($_GET['dev']))
        return false;
    echo '<pre>';
    if (!empty($label))
        echo $label . ': ';
    if ($var === null)
        echo 'NULL';
    elseif ($var === false)
        echo 'FALSE';
    elseif ($var === '')
        echo 'EMPTY STRING';
    else
        // print_r($var);
        echo '</pre>';
    if ($die)
        die();
}


function agentinformation_first_name_shortcode($attr = array())
{
    $attr['key'] = 'first_name';
    return agentinformation_shortcode($attr);
}

function agentinformation_email_shortcode($attr = array())
{
    $attr['key'] = 'email';
    return agentinformation_shortcode($attr);
}

function agentinformation_designation_shortcode($attr = array())
{
    $attr['key'] = 'designation';
    return agentinformation_shortcode($attr);;
}

function agentinformation_business_phone_shortcode($attr = array())
{
    $attr['key'] = 'business_phone';
    return agentinformation_shortcode($attr);
}

function agentinformation_mobile_phone_shortcode($attr = array())
{
    $attr['key'] = 'mobile_phone';
    return agentinformation_shortcode($attr);
}

function agentinformation_profile_picture_shortcode($attr = array())
{
    $attr['key'] = 'profile_picture';
    return agentinformation_shortcode($attr);
}

function agentinformation_broker_name_shortcode($attr = array())
{
    $attr['key'] = 'broker';
    return agentinformation_shortcode($attr);
}

function agentinformation_broker_website_shortcode($attr = array())
{
    $attr['key'] = 'broker_website';
    return agentinformation_shortcode($attr);
}

function agentinformation_broker_logo_shortcode($attr = array())
{
    $attr['key'] = 'broker_logo';
    return agentinformation_shortcode($attr);
}

function agentinformation_facebook_shortcode($attr = array())
{
    $attr['key'] = 'facebook';
    return agentinformation_shortcode($attr);
}

function agentinformation_twitter_shortcode($attr = array())
{
    $attr['key'] = 'twitter';
    return agentinformation_shortcode($attr);
}

function agentinformation_googleplus_shortcode($attr = array())
{
    $attr['key'] = 'googleplus';
    return agentinformation_shortcode($attr);
}

function agentinformation_bloginfo_shortcode($attr = array())
{
    $key = $attr['key'];
    $value = get_bloginfo($key);
    return $value;
}

function agentinformation_contact_page_image_shortcode($attr = array()) {
    $attr['key'] = 'contact_page_image';
    return agentinformation_shortcode($attr);
}
