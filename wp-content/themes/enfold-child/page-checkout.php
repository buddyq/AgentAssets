<?php
/*
  Template Name: Paypal Checkout page
 */
global $avia_config;

get_header();
if (get_post_meta(get_the_ID(), 'header', true) != 'no')
    echo avia_title();
$mism_package_settings = get_option('mism_package_settings');

# Set Session Variable
if (isset($_POST['buy_package']) && $_POST['buy_package'] = "Buy") {
    $_SESSION['cart'] = $_POST;
}

$discount_flag = 0;
$discount = $discount_amount = 0;
$coupon_id = null;

if (isset($_POST['add_coupon']) && $_POST['add_coupon'] = "Apply Coupon") {
    global $wpdb;
    $discount_code = $_POST['discount_code'];

    $args = array(
        'post_type' => 'coupon',
        'post_status' => 'publish',
        's' => $discount_code,
        'exact' => true
    );
    $coupon_details = get_posts($args);
    $coupon_id = $coupon_details['0']->ID;
    $discount_type = get_post_meta($coupon_id, 'wpcf-discount-type', true);
    $allusers = get_post_meta($coupon_details[0]->ID, 'micu_coupon_users', true);
    $discount_amount = get_post_meta($coupon_id, 'wpcf-total-discount', true);
    $current_user_id = get_current_user_id();

    if(!empty($coupon_details)){
      foreach ($allusers AS $singleUser) {
          if (($singleUser == $current_user_id) || $singleUser == '0') {
              $discount = $discount_amount;
              $discount_flag = 1;
          } elseif (empty($_POST['discount_code'])) {
              $discount = 0;
          } else {
              $discount = 0;
          }
      }//end foreach
    }//end if
 }


# Paypal URL (LIVE/Sandbox)
$paypal_url = '';
if ($mism_package_settings['environment'] == "1") {
    $paypal_url = 'https://www.sandbox.paypal.com/webscr?';
} elseif ($mism_package_settings['environment'] == "2") {
    $paypal_url = 'https://www.paypal.com/webscr?';
}

$price = $_SESSION['cart']['amount'];

# Tax Calcultation
$tax = 0;
$tax_amount = $_SESSION['cart']['tax'];
if (isset($_SESSION['cart']['tax'])) {
    $tax = ($price * $_SESSION['cart']['tax']) / 100; # Considered Tax is provided in percentage, calcultation for tax
}
if ($discount_flag == 1) {
# Discount Calculation
    if ($discount_type == "1") { # Discount type amount
      $discount = $price - $discount_amount;
    } elseif ($discount_type == "2") { # Discount type percentage
       $discount = (($price * $discount_amount) / 100);
       }
}

$sub_amount = $price - $discount;
if($sub_amount == 0)
{
    $total_amount = 0;
}
else
{
    $total_amount = $price + $tax - $discount;
}
?>

<div class="container_wrap main_color">
    <div class="container">
        <div class="template-page " style="margin-bottom: 25px;">
            <div class="entry-content-wrapper clearfix">
                <div class="avia-data-table-wrap avia_responsive_table">
                    <table id="checkout"class="avia-table avia-data-table avia-table-4  avia-builder-el-12  el_after_av_table  avia-builder-el-last ">
                        <tbody>
                            <?php $i = 1; ?>
                            <tr class="avia-heading-row">
                                <th>#</th>
                                <th>Package Name</th>
                                <th>Price</th>
                            </tr>
								<?php if($_SESSION['cart']['currency_code'] == 'USD'){
										$currency_symbol = "$";
									}elseif($_SESSION['cart']['currency_code'] == 'EUR'){
											$currency_symbol = "&euro;";
										}?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $_SESSION['cart']['item_name']; ?></td>
                                <td><?php echo $currency_symbol . " " . number_format($price, 2); ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td style="text-align: right;">Tax (+)</td>
                                <td><?php echo $currency_symbol . " " . number_format($tax, 2)." (".$tax_amount."%)"; ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td style="text-align: right;">Discount (-)</td>
                                <td><?php echo $currency_symbol . " " . number_format($discount, 2); ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td style="text-align: right;">Total Amount (=)</td>
                                <?php
                                //$total = $price - $discount + $tax;
                                ?>
                                <td><?php echo $currency_symbol . " " . number_format($total_amount, 2); ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td class="coupon-container">
                                    <form method="POST">

                                        <?php
                                        if (isset($_POST['add_coupon']) && $_POST['add_coupon'] = "Apply Coupon") {

                                            $args = array(
                                                'post_type' => 'coupon',
                                                'post_status' => 'publish',
                                                's' => $_POST['discount_code'],
                                                'exact' => true
                                            );
                                            $coupons = get_posts($args);
                                            $allusers = get_post_meta($coupons[0]->ID, 'micu_coupon_users', true);
                                            $current_user_id = get_current_user_id();

                                            if (!empty($coupons)) {

                                              foreach ($allusers AS $singleUser) {

                                                  if (($singleUser == $current_user_id) || $singleUser == '0') {
                                                      # Do something
                                                      ?>
                                                      <div class="coupon-applied success">Coupon Applied Successfully</div>
                                                      <?php
                                                  } elseif (empty($_POST['discount_code'])) {
                                                      ?>
                                                      <div class="coupon-applied empty">Please enter some coupon code for availing the discount</div>

                                                      <?php
                                                  } else {
                                                      ?>
                                                      <div class="coupon-applied invalid">Coupon Code Invalid.</div>
                                                      <?php
                                                  }
                                              }
                                            }else{
                                              ?>
                                              <div class="coupon-applied invalid">Coupon Code Invalid.</div>
                                              <?php
                                            }
                                        }
                                        ?>


                                        <input class="input-textfield" type="text" name="discount_code" value=""/>
                                        <input class="button-textfield" type="submit" name="add_coupon" value="Apply Coupon"/>

                                    </form>

                                </td>
                                <td>
                                    <?php $paypal_url = $_SESSION['cart']['paypal_url']; ?>
                                    <form id="form_checkout" method="POST">
                                        <?php
                                        $package_id = $_SESSION['cart']['package_id'];
                                        $currency_code = $_SESSION['cart']['currency_code'];
                                        $user_id = $_SESSION['cart']['user_id'];

                                        $custom_params = array(
                                            'user_id' => $user_id,
                                            'coupon_id' => $coupon_id,
                                            'process_type' => 'new'
                                        );
                                        $custom = implode(',', $custom_params);

                                        $cmd = $_SESSION['cart']['cmd'];
//$amount = $_SESSION['cart']['amount'];
//$tax = ($amount * $_SESSION['cart']['tax']) / 100;
                                        $business = $_SESSION['cart']['business'];
//$bn = $_SESSION['cart']['bn'];
                                        $return = $_SESSION['cart']['return'];
                                        $notify_url = $_SESSION['cart']['notify_url'];
                                        $cancel_return = $_SESSION['cart']['cancel_return'];
                                        $item_name = $_SESSION['cart']['item_name'];
                                        $item_number = $_SESSION['cart']['item_number'];
                                        $buy_package = $_SESSION['cart']['buy_package'];
                                        ?>
                                        <input id="package_id" type="hidden" name="package_id" value="<?php echo $package_id; ?>"/>
                                        <input id="paypal_url" type="hidden" name="paypal_url" value="<?php echo $paypal_url; ?>"/>
                                        <input id="default_currency" type="hidden" name="currency_code" value="<?php echo $currency_code; ?>"/>
                                        <input id="user_id" type="hidden" name="user_id" value="<?php echo $user_id; ?>"/>
                                        <input type="hidden" name="custom" value="<?php echo $custom; ?>"/>
                                        <input type="hidden" name="cmd" value="_xclick"/>
                                        <input type="hidden" name="pagestyle" value="agentassets"/>
                                        <input type="hidden" name="discount_amount" value="<?php echo round($discount, 2); ?>"/>
                                        <input type="hidden" name="tax" value="<?php echo round($tax, 2); ?>"/>
                                        <input type="hidden" name="business" value="<?php echo $business; ?>"/>
                                        <input type="hidden" name="return" value="<?php echo $return; ?>"/>
                                        <input type="hidden" name="notify_url" value="<?php echo $notify_url; ?>"/>
                                        <input type="hidden" name="cancel_return" value="<?php echo $cancel_return; ?>"/>
                                        <input type="hidden" name="amount" value="<?php echo round($price, 2); ?>"/>
                                        <input type="hidden" name="item_name" value="<?php echo $item_name; ?>"/>
                                        <input type="hidden" name="item_number" value="<?php echo $item_number; ?>"/>

                                        <input id="checkout-button" type="button" name="checkout" value="Checkout" class="avia-button size-medium avia-color-theme-color avia-size-medium avia-position-center"/>

                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

	/* $sql = "SELECT count(*) FROM `" . $wpdb->base_prefix . "orders` WHERE package_id='" . $package_id . "' AND user_id='" . $user_id . "'";
    $results = $wpdb->get_results($sql);

	 $package_id;
     $user_id;
     $package_name =$_SESSION['cart']['item_name'];
   $price;
     $discount;
	 $tax;
    $total_amount;
     $purchased_date = date('Y-m-d H:i:s');  #Current Date
     $months = get_post_meta($package_id, 'wpcf-duration', true);
    $expiry_date = date('Y-m-d H:i:s', strtotime('+' . $months . 'months'));
     $purchased_date;
     $expiry_date;
     $site_allowed = get_post_meta($package_id, 'wpcf-sites-allowed', true);
   $status="2";
	//exit('hi checkout here');
    if ($results > 0) {
        $sql = "INSERT INTO `" . $wpdb->base_prefix . "orders`(package_id, user_id, package_name, package_price, discount, tax, total_price, purchased_date, expiry_date, status) VALUES('" . $package_id . "','" . $user_id . "','" . $package_name . "','" . $price . "', '" . $discount . "','" . $tax . "','" . $total_amount . "','" . $purchased_date . "','" . $expiry_date . "','" . $status . "')";
        $wpdb->query($wpdb->prepare($sql));
        $order_id = $wpdb->insert_id;

        $query = "INSERT INTO `" . $wpdb->base_prefix . "package_counter`(order_id, site_allowed, site_consumed)VALUES('" . $order_id . "','" . $site_allowed . "','" . $site_consumed . "')";
        $wpdb->query($wpdb->prepare($query));
    }
*/

 ?>



<script type="text/javascript">
    jQuery(document).ready(function($) {
        jQuery('#checkout-button').click(function(e){
            var package_id = jQuery('#checkout-button').parent('form').children('#package_id').val();
            var paypal_url = jQuery('#checkout-button').parent('form').children('#paypal_url').val();
            var default_currency = jQuery('#checkout-button').parent('form').children('#default_currency').val();
            var user_id = jQuery('#checkout-button').parent('form').children('#user_id').val();


            var data = {
                'action': 'purchase_package',
                'cmd': '_xclick',
                'currency_code': default_currency,
                'paypal_url': paypal_url,
                'package_id': package_id,
                'notify_url': '<?php echo $mism_package_settings['notify']; ?>',
                'return': '<?php echo $mism_package_settings['return']; ?>',
                'cancel_return': '<?php echo $mism_package_settings['cancel']; ?>',
                'business_email': '<?php echo $mism_package_settings['business_email']; ?>',
                'price': '<?php echo $price; ?>',
                'discount': '<?php echo $discount; ?>',
                'tax': '<?php echo $tax; ?>',
                'userid': user_id,
                'total_amount' : '<?php echo $total_amount;?>'
            };

            // We can also pass the url value separately from ajaxurl for front end AJAX implementations
            jQuery.post('<?php echo get_option("siteurl") . "/wp-admin/admin-ajax.php"; ?>', data, function(response) {

                jQuery('#form_checkout').attr('action',response);
                jQuery('#form_checkout').submit();
            });
        });
    });
</script>
<?php
get_footer();
?>
