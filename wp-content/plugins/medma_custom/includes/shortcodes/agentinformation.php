<?php

add_shortcode('agentinformation', 'agentinformation_shortcode');

add_shortcode('agentinformation_first_name', 'agentinformation_first_name_shortcode');
add_shortcode('agentinformation_designation', 'agentinformation_designation_shortcode');
add_shortcode('agentinformation_business_phone', 'agentinformation_business_phone_shortcode');
add_shortcode('agentinformation_mobile_phone', 'agentinformation_mobile_phone_shortcode');
add_shortcode('agentinformation_profile_picture_url', 'agentinformation_profile_picture_url_shortcode');
add_shortcode('agentinformation_broker_name', 'agentinformation_broker_name_shortcode');
add_shortcode('agentinformation_broker_website', 'agentinformation_broker_website_shortcode');
add_shortcode('agentinformation_broker_logo_url', 'agentinformation_broker_logo_url_shortcode');
add_shortcode('agentinformation_facebook', 'agentinformation_facebook_shortcode');
add_shortcode('agentinformation_twitter', 'agentinformation_twitter_shortcode');
add_shortcode('agentinformation_googleplus', 'agentinformation_googleplus_shortcode');

function agentinformation_shortcode($atts) {
    $value = null;
    if (isset($atts['key'])) {
		global $wpdb;
        $defaults = array(
            'profile_picture' => plugins_url('medma-site-manager').'/images/dummy_agent_pic.png',
            'broker_logo' => plugins_url('medma-site-manager').'/images/placeholder_wide.jpg',
        );
        $blog_id = get_current_blog_id();

		$user_id = 1;
		$admins = get_users( 'blog_id='.$blog_id.'&orderby=ID&role=administrator' );			
		foreach($admins as $admin) {
			if ($admin->ID == 1 && $blog_id != 1) continue;
			$user_id = $admin->ID;
			break;
		}
		$value = get_user_meta($user_id, $atts['key'], true);
        if (in_array($atts['key'], array(
            'profile_picture',
            'broker_logo'
        ))) {
            if (!empty($value)) {
                $size = 'full';
                if(!empty($atts['size'])) {
                    $size = $atts['size'];
                } else if (!empty($atts['width']) && !empty($atts['height'])) {
                    $size = array($atts['width'], $atts['height']);
                }
				switch_to_blog(1);
                $value = wp_get_attachment_image_src($value, $size);
				restore_current_blog();
                if (is_array($value))
                    $value = $value[0];
            }
        }
        if (isset($defaults[$atts['key']]) && empty($value)) {
            $value = $defaults[$atts['key']];
        }
    }
    return $value;
}

function showVar($var, $die, $label='') {
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
        print_r($var);
    echo '</pre>';
    if ($die)
        die();
}


function agentinformation_first_name_shortcode($attr = array()) {
    $attr['key'] = 'first_name';
    return agentinformation_shortcode($attr);
}

function agentinformation_designation_shortcode($attr = array()) {
    $attr['key'] = 'designation';
       return agentinformation_shortcode($attr);;
}

function agentinformation_business_phone_shortcode($attr = array()) {
    $attr['key'] = 'business_phone';
       return agentinformation_shortcode($attr);
}

function agentinformation_mobile_phone_shortcode($attr = array()) {
    $attr['key'] = 'mobile_phone';
       return agentinformation_shortcode($attr);
}

function agentinformation_profile_picture_url_shortcode($attr = array()) {
    $attr['key'] = 'profile_picture';
       return agentinformation_shortcode($attr);
}

function agentinformation_broker_name_shortcode($attr = array()) {
    $attr['key'] = 'broker';
       return agentinformation_shortcode($attr);
}

function agentinformation_broker_website_shortcode($attr = array()) {
    $attr['key'] = 'broker_website';
       return agentinformation_shortcode($attr);
}

function agentinformation_broker_logo_url_shortcode($attr = array()) {
    $attr['key'] = 'broker_logo';
       return agentinformation_shortcode($attr);
}

function agentinformation_facebook_shortcode($attr = array()) {
    $attr['key'] = 'facebook';
       return agentinformation_shortcode($attr);
}

function agentinformation_twitter_shortcode($attr = array()) {
    $attr['key'] = 'twitter';
       return agentinformation_shortcode($attr);
}

function agentinformation_googleplus_shortcode($attr = array()) {
    $attr['key'] = 'googleplus';
       return agentinformation_shortcode($attr);
}