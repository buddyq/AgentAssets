<?php
/*
Plugin Name: Agentassets Common Plugin
Plugin URI: http://agentassets.com
Description: Agentassets common plugin. Thats it. :)
Version: 0.0.1
Author: aigletter
Author URI: http://agentassets.com
*/

class AgentassetsCommon {

    public static function run() { $o = new AgentassetsCommon; $o->init(); }

    public function init() {
        add_action( 'plugins_loaded', array($this, 'plugins_loaded' ));
    }

    public function plugins_loaded() {
        add_action( 'wp_enqueue_scripts', 'wr_no_captcha_login_form_script' );
        add_action( 'wp_enqueue_scripts', 'wr_no_captcha_css' );
        add_action( 'login_afo_form', 'wr_no_captcha_render_login_captcha' );

        add_filter( 'register_cu_form_captcha', array($this, 'recaptcha_verify'));
    }

    public function recaptcha_verify($val) {
        if ( $val && isset( $_POST['g-recaptcha-response'] ) ) {
            $no_captcha_secret = get_option( 'wr_no_captcha_secret_key' );
            $response = wp_remote_get( 'https://www.google.com/recaptcha/api/siteverify?secret=' . $no_captcha_secret . '&response=' . $_POST['g-recaptcha-response'] );
            $response = json_decode( $response['body'], true );
            if ( true === $response['success'] ) {
                $val = true;
            } else {
                $val = false;
            }
        } else if ( ! wr_no_captcha_api_keys_set() ) {
            $val = true;
        }

        return $val;
    }
}

AgentassetsCommon::run();