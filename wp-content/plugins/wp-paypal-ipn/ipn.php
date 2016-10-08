<?php
/*
 * IPN Notification Call URL: <DOMAIN_URL>/wp-admin/admin-ajax.php?action=mi_ipnlistener_notification 
 */

/*
global $wpdb;

include_once 'includes/ipn.listener.class.php';

$listener = new IpnListener();

$listener->use_sandbox = true;
$listener->use_ssl = true;
$listener->force_ssl_v3 = false;     
 $args = array(
        'post_type' => 'coupon',
        'post_status' => 'publish',
        's' => $_POST['discount_code'],
        'exact' => true
    );
    $coupons = get_posts($args);
    $coupon_id = $coupon_details['0']->ID;
    $discount_code = $_POST['discount_code'];
     $current_user_id = get_current_user_id();
     $couponusedcount=1;
try {
    $listener->requirePostMethod();    
    $verified = $listener->processIpn();  
} catch (Exception $e) {
    error_log($e->getMessage());
    exit(0);
}
if($verified)
{
    mail('mehul@medma.in','Paypal Verification | Verified', $_POST['item_number']."--".$_POST['custom']);
    if(isset($_POST['item_number']) && isset($_POST['custom']))
    {
        $package_id = $_POST['item_number'];
        $user_id = $_POST['custom'];
        
        $sql = "UPDATE `".$wpdb->base_prefix."orders` SET status = '1' WHERE package_id='".$package_id."' AND user_id = '".$user_id."'";
        $wpdb->query($wpdb->prepare($sql));
       
        $querystring = "INSERT INTO `".$wpdb->base_prefix."coupons`(coupon_id, coupon_code, user_id, coupon_used_count) VALUES('".$coupon_id."','".$discount_code."','".$current_user_id."','".$couponusedcount."')";
            $wpdb->query($wpdb->prepare($querystring));
            //$order_id = $wpdb->insert_id;
    }
}
else
{
    mail('mehul@medma.in','Paypal Verification | Invalid', $verified);
}


?>
