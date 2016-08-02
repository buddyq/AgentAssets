<?php

/*
 * IPN Notification Call URL: <DOMAIN_URL>/wp-admin/admin-ajax.php?action=mi_ipnlistener_notification 
 */
add_action('wp_ajax_mi_ipnlistener_notification', 'mi_ipnlistener_notification_callback');
add_action('wp_ajax_nopriv_mi_ipnlistener_notification', 'mi_ipnlistener_notification_callback');

function mi_ipnlistener_notification_callback() {
    //ini_set('log_errors', true);
    //ini_set('error_log', dirname(__FILE__) . '/ipn_errors.log');
    //include_once 'includes/ipn.listener.class.php';
    $listener = new IpnListener();

    $listener->use_sandbox = true;
    $listener->use_ssl = true;
    $listener->force_ssl_v3 = false;

    try {
        $listener->requirePostMethod();
        $verified = $listener->processIpn();
    } catch (Exception $e) {
        file_put_contents(dirname(__FILE__) . '/ipn_errors.log', $e->getMessage()."\n", FILE_APPEND);
        exit(0);
    }
    if ($verified) {
        
        if (isset($_POST['item_number']) && isset($_POST['custom'])) {
            global $wpdb;

            $package_id = $_POST['item_number'];
            $custom_params = explode(',', $_POST['custom']);
            $user_id = $custom_params[0]; # User ID
            $coupon_id = $custom_params[1]; # Coupon ID
            $payment_process = $custom_params[2]; # Payment Process
            $order_id = $custom_params[3]; # order ID
            
            $coupon_details = get_post($coupon_id);
            $discount_code = $coupon_details->post_title;
            
            if ($payment_process == 'renew') {
                $new_expiry=strtotime("+1 year");
                $current_date = date("Y-m-d h:i:s",$new_expiry);
                $sql = "UPDATE `" . $wpdb->base_prefix . "orders` SET expiry_date = '".$current_date."' WHERE id='" . $order_id . "' AND user_id = '" . $user_id . "' AND status='1'";
                $result = $wpdb->query($sql);
               
            } else {
                $sql = "UPDATE `" . $wpdb->base_prefix . "orders` SET status = '1' WHERE package_id='" . $package_id . "' AND user_id = '" . $user_id . "' AND status='2'";
                $result = $wpdb->query($sql);
            
            }
            
            if ($discount_code != "") {
                $couponusedcount = 1;
                $querystring = "INSERT INTO `" . $wpdb->base_prefix . "coupons`(coupon_id, coupon_code, user_id, coupon_used_count) VALUES('" . $coupon_id . "','" . $discount_code . "','" . $user_id . "','" . $couponusedcount . "')";
                $wpdb->query($wpdb->prepare($querystring));
            }
        }
    } else {
        file_put_contents(dirname(__FILE__) . '/ipn_errors.log', 'Paypal Verification | Invalid'."\n",  FILE_APPEND);
    }
}

?>
