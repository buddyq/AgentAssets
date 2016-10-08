<?php
# Include IPN Listener
include_once 'ipn.listener.class.php';

# Log Errors, if debug is TRUE
ini_set('log_errors', true);
ini_set('error_log', dirname(__FILE__).'/ipn_errors.log');
        

        
if(!function_exists('callPaypalIPN')){    
    
    /*
     * callPaypalIPN() method is used for calling the Paypal IPN method
     */

    function callPaypalIPN($data)
    {
        $data = array(
        'cmd'           =>  '_xclick',
        'currency_code' =>  'USD',
        'item_name'     =>  'Test Product',
        'item_number'   =>  '98765418',
        'amount'        =>  '98',
        'business'      =>  'suman@medma.in',
        'return'        =>  'http://agentassets.com/',
        'notify_url'    =>  'http://agentassets.com/wp-admin/admin-ajax.php?action=mi_ipnlistener_notification',
        'cancel_return' =>  'http://agentassets.com/',
        );
        
        #   Loop for posted values and append to querystring
        $queryString = '';
        foreach($data as $key => $value){
            if($key!="submit")
            {
                $value = urlencode(stripslashes($value));
                $queryString .= "$key=$value&amp;";
            }
        }
        $paypal_url = 'https://www.sandbox.paypal.com/webscr?';
        //echo $paypal_url.$queryString;
        //wp_die('Paypal Call');
        wp_redirect($paypal_url.$queryString); exit;
        //header("Location: ".$paypal_url.$queryString);

        
        
        //echo "<pre>";print_r($data);wp_die('Paypal Call');
    }
    
}
?>