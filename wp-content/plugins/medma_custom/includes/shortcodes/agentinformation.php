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
        
		$user_id = null;
		$admins = get_users( 'blog_id='.$blog_id.'&orderby=ID&role=administrator' );			
		foreach($admins as $admin) {
			if ($admin->ID == 1) continue;
			$user_id = $admin->ID;
			break;
		}
		showVar($admin->user_login);

		$value = get_user_meta($user_id, $atts['key'], true);
		
        if (in_array($atts['key'], array(
            'profile_picture',
            'broker_logo'
        ))) {
            if (!empty($value)) {
				switch_to_blog(1);
                $value = wp_get_attachment_image_src($value, 'full');
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


function agentinformation_first_name_shortcode() {
    return agentinformation_shortcode(array('key' => 'first_name'));
}

function agentinformation_designation_shortcode() {
    return agentinformation_shortcode(array('key' => 'designation'));
}

function agentinformation_business_phone_shortcode() {
    return agentinformation_shortcode(array('key' => 'business_phone'));
}

function agentinformation_mobile_phone_shortcode() {
    return agentinformation_shortcode(array('key' => 'mobile_phone'));
}

function agentinformation_profile_picture_url_shortcode() {
    return agentinformation_shortcode(array('key' => 'profile_picture'));
}

function agentinformation_broker_name_shortcode() {
    return agentinformation_shortcode(array('key' => 'broker'));
}

function agentinformation_broker_website_shortcode() {
    return agentinformation_shortcode(array('key' => 'broker_website'));
}

function agentinformation_broker_logo_url_shortcode() {
    return agentinformation_shortcode(array('key' => 'broker_logo'));
}

function agentinformation_facebook_shortcode() {
    return agentinformation_shortcode(array('key' => 'facebook'));
}

function agentinformation_twitter_shortcode() {
    return agentinformation_shortcode(array('key' => 'twitter'));
}

function agentinformation_googleplus_shortcode() {
    return agentinformation_shortcode(array('key' => 'googleplus'));
}