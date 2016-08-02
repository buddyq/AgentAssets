<?php
/*
 * Plugin Name: WP Paypal IPN
 * Version: 1.0.0
 * Author: Agentassets
 * License: GPLv2 or later
 */

ob_start();
global $wpdb;

//ini_set('log_errors', true);
//ini_set('error_log', dirname(__FILE__).'/ipn_errors.log');

# Include IPN Configuration File
if(file_exists(plugins_url().'/wp.paypal.ipn.pluggable.php'))
{
    include_once plugins_url().'/wp.paypal.ipn.pluggable.php';
}

include_once 'includes/ipn.listener.class.php';
include_once 'includes/ipn.listener.notification.call.php';

ob_end_flush();

