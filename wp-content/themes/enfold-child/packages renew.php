<?php
/*
  Template Name: Package Renew
 */
global $avia_config;
?>
<h1>Ciao!</h1>
<?php
if (!isset($_POST['add_coupon'])) {
    if ((!isset($_POST['package_id']) && !isset($_POST['order_id'])) || ($_POST['package_id'] == NULL && $_POST['order_id'] == NULL)) {
        wp_redirect(home_url());
    }
}

get_header();
if (get_post_meta(get_the_ID(), 'header', true) != 'no')
    echo avia_title();
$mism_package_settings = get_option('mism_package_settings');

if ($mism_package_settings['default_currency'] == '1') {
    $currency_code = 'USD';
} elseif ($mism_package_settings['default_currency'] == '2') {
    $currency_code = 'EUR';
}

if (isset($_POST['package_id'])) {
    $_SESSION['package_id'] = $_POST['package_id'];
}
$package_id = $_SESSION['package_id'];
$package_price = get_post_meta($package_id, 'wpcf-price', true);


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

    foreach ($allusers AS $singleUser) {
        if (($singleUser->ID == $current_user_id) || $singleUser->ID == '0') {
            $discount = $discount_amount;
            $discount_flag = 1;
        } elseif (empty($_POST['discount_code'])) {
            $discount = 0;
        } else {
            $discount = 0;
        }
    }
}

# Paypal URL (LIVE/Sandbox)
$paypal_url = '';
if ($mism_package_settings['environment'] == "1") {
    $paypal_url = 'https://www.sandbox.paypal.com/webscr?';
} elseif ($mism_package_settings['environment'] == "2") {
    $paypal_url = 'https://www.paypal.com/webscr?';
}

$price = $package_price;

# Tax Calcultation
$tax = 0;
if (isset($mism_package_settings['tax'])) {
    $tax = ($price * $mism_package_settings['tax']) / 100; # Considered Tax is provided in percentage, calcultation for tax
}

if ($discount_flag == 1) {
# Discount Calculation
    $discount = 0;
    if ($discount_type == "1") { # Discount type amount
        $discount = $price - $discount_amount;
    } elseif ($discount_type == "2") { # Discount type percentage
        $discount = (($price * $discount_amount) / 100);
    }
}
$total_amount = $price + $tax - $discount;
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
                'userid': user_id
            };
            // alert(paypal_url);
            // We can also pass the url value separately from ajaxurl for front end AJAX implementations
            jQuery.post('<?php echo get_option("siteurl") . "/wp-admin/admin-ajax.php"; ?>', data, function(response) {
                //alert('Got this from the server: ' + response);
                //e.preventDefault();
                //return false;
                //window.location.href = response;
                jQuery('#form_checkout').attr('action',response);
                jQuery('#form_checkout').submit();
            });
        });
    });
</script>
<div class="container_wrap main_color">
    <div class="container">
        <div class="template-page " style="margin-bottom: 25px;">
            <div class="entry-content-wrapper clearfix">
                <div class="avia-data-table-wrap avia_responsive_table">
                    <table id="renew-package" class="avia-table avia-data-table avia-table-4  avia-builder-el-12  el_after_av_table  avia-builder-el-last ">
                        <tbody>
                            <?php $i = 1; ?>
                            <tr class="avia-heading-row">
                                <th>#</th>
                                <th>Package Name</th>
                                <th>Price</th>
                            </tr>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo get_the_title($package_id); ?></td>
                                <td><?php echo $currency_code . " " . number_format($price, 2) . " "; ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td style="text-align: right;">Tax (+)</td>
                                <td><?php echo $currency_code . " " . number_format($tax, 2); ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td style="text-align: right;">Discount (-)</td>
                                <td><?php echo $currency_code . " " . number_format($discount, 2); ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td style="text-align: right;">Total Amount (=)</td>
                                <?php
                                $total = $package_price - $discount + $tax;
                                ?>
                                <td><?php echo $currency_code . " " . number_format($total, 2); ?></td>
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

                                            foreach ($allusers AS $singleUser) {
                                                if (($singleUser->ID == $current_user_id) || $singleUser->ID == '0') {
                                                    # Do something
                                                    ?>
                                                    <div class="coupon-applied">Coupon Applied Successfully</div>
                                                    <?php
                                                } elseif (empty($_POST['discount_code'])) {
                                                    ?>
                                                    <div class="coupon-applied">Please enter some coupon code for availing the discount</div>

                                                    <?php
                                                } else {
                                                    ?>
                                                    <div class="coupon-applied">Coupon Code Invalid for your user</div>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>     


                                        <input class="input-textfield" type="text" name="discount_code" value=""/>
                                        <input class="button-textfield" type="submit" name="add_coupon" value="Apply Coupon"/>

                                    </form>

                                </td>
                                <td>
                                    <?php $paypal_url = $paypal_url; ?>
                                    <form id="form_checkout" method="POST">
                                        <?php
//$_SESSION['cart'] = $_POST;
//echo "<pre>";
//   print_r($_SESSION['cart']);


                                        $user_id = get_current_user_id();

                                        $custom_params = array(
                                            'user_id' => $user_id,
                                            'coupon_id' => $coupon_id,
                                            'process_type' => 'renew',
                                            'order_id' => $_POST['order_id']
                                        );
                                        $custom = implode(',', $custom_params);

                                        $cmd = "_xclick";
                                        $business = $mism_package_settings['business_email'];
                                        $return = $mism_package_settings['return'];
                                        $notify_url = $mism_package_settings['notify'];
                                        $cancel_return = $mism_package_settings['cancel'];
                                        $item_name = get_the_title($package_id);
                                        $item_number = $package_id;
                                        ?>
                                        <input id="package_id" type="hidden" name="package_id" value="<?php echo $package_id; ?>"/>
                                        <input id="paypal_url" type="hidden" name="paypal_url" value="<?php echo $paypal_url; ?>"/>
                                        <input id="default_currency" type="hidden" name="currency_code" value="<?php echo $currency_code; ?>"/>
                                        <input id="user_id" type="hidden" name="user_id" value="<?php echo $user_id; ?>"/>
                                        <input type="hidden" name="custom" value="<?php echo $custom; ?>"/>
                                        <input type="hidden" name="cmd" value="_xclick"/>
                                        <input type="hidden" name="discount_amount" value="<?php echo round($discount, 2); ?>"/>
                                        <input type="hidden" name="tax" value="<?php echo round($tax, 2); ?>"/>
                                        <input type="hidden" name="business" value="<?php echo $business; ?>"/>
                                        <input type="hidden" name="return" value="<?php echo $return; ?>"/>
                                        <input type="hidden" name="notify_url" value="<?php echo $notify_url; ?>"/>
                                        <input type="hidden" name="cancel_return" value="<?php echo $cancel_return; ?>"/>
                                        <input type="hidden" name="amount" value="<?php echo round($price, 2); ?>"/>
                                        <input type="hidden" name="item_name" value="<?php echo $item_name; ?>"/>
                                        <input type="hidden" name="item_number" value="<?php echo $item_number; ?>"/>

                                        <input id="checkout-button" type="button" name="checkout" value="Checkout"/>

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
get_footer();
?>
