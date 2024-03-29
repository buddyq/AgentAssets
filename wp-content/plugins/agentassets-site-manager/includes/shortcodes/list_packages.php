<?php
add_shortcode('package_list', 'list_packages_callback');

function list_packages_callback($atts) {
    $atts = shortcode_atts(
            array(
        'title' => 'All Packages'
            ), $atts, 'package_list');

    $args = array(
        'post_type' => 'package',
        'post_status' => 'publish',
        'meta_key' => 'wpcf-status',
        'meta_value' => '1',
        'posts_per_page' => '-1',
        'orderby' => 'ID',
        'order' => 'ASC'
    );
    global $wpdb;
    $user_id = get_current_user_id();
    $total_package = $wpdb->get_results("SELECT id FROM `" . $wpdb->base_prefix . "orders` WHERE user_id = '" . $user_id . "' AND status='1'");
    // echo "<pre>"; print_r ($wpdb->base_prefix); die("</pre>");

    $total_sites = "";
    $total_consumed = "";
    if (!empty($total_package)) {
        foreach ($total_package as $pck) {
            $sites_stats = $wpdb->get_results("SELECT site_allowed,site_consumed FROM `" . $wpdb->base_prefix . "package_counter` WHERE order_id = '" . $pck->id . "'");
            $total_sites = $total_sites + $sites_stats[0]->site_allowed;
            $total_consumed = $total_consumed + $sites_stats[0]->site_consumed;
        }
    }

    if ($total_consumed == $total_sites || empty($total_package)) {
        $packages = get_posts($args);

        if (count($packages) > 0) {

            $mism_package_settings = get_option('mism_package_settings');

            # Paypal URL (LIVE/Sandbox)
            $paypal_url = '';
            if ($mism_package_settings['environment'] == "1") {
                $paypal_url = 'https://www.sandbox.paypal.com/webscr?';
            } elseif ($mism_package_settings['environment'] == "2") {
                $paypal_url = 'https://www.paypal.com/webscr?';
            }

            # Currency Code implementation with Paypal
            $currency_code = '';
            if ($mism_package_settings['default_currency'] == "1") {
                $currency_code = 'USD';
            } elseif ($mism_package_settings['default_currency'] == "2") {
                $currency_code = "EUR";
            }
            ?>
            <script type="text/javascript">
               jQuery(document).ready(function($) {
                    jQuery('.buy_button').click(function(e){
                        var package_id = jQuery(this).parent('form').children('#package_id').val();
                        var paypal_url = jQuery(this).parent('form').children('#paypal_url').val();
                        var default_currency = jQuery(this).parent('form').children('#default_currency').val();
                        var user_id = jQuery(this).parent('form').children('#user_id').val();

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
                        // We can also pass the url value separately from ajaxurl for front end AJAX implementations
                        jQuery.post('<?php echo get_option("siteurl") . "/wp-admin/admin-ajax.php"; ?>', data, function(response) {
                            //alert('Got this from the server: ' + response);
                            //window.location.href = response;
                            jQuery('#form_buy_package'+package_id).attr('action',response);
                            jQuery('#form_buy_package'+package_id).submit();
                        });
                    });
                });
            </script>
            <div class="packages avia-table main_color avia-pricing-table-container avia-table-2  avia-builder-el-5  el_after_av_section  el_before_av_table  avia-builder-el-first ">
                <div class="pricing-table-wrap">
                    <ul class="pricing-table avia-desc-col">
                        <li class="avia-heading-row">
                            <div class="first-table-item">Package</div>
                            <span class="pricing-extra"></span>
                        </li>
                        <li class="avia-pricing-row empty-table-cell">
                            <span class="fallback-table-val">
                                &nbsp;
                            </span>
                        </li>
                        <li class="">Sites Allowed</li>
                        <li class="">Duration (in months)</li>
                        <li class="avia-button-row empty-table-cell">
                            <span class="fallback-table-val">
                                <div class="avia-button-wrap avia-button-center  avia-builder-el-6  el_before_av_button  avia-builder-el-first ">
                                    <a class="avia-button  avia-icon_select-yes-left-icon avia-color-theme-color avia-size-medium avia-position-center " href="">
                                        <span data-av_iconfont="entypo-fontello" data-av_icon="" aria-hidden="true" class="avia_button_icon avia_button_icon_left "></span>
                                        <span class="avia_iconbox_title">Buy</span>
                                    </a>
                                </div>
                                <p></p>
                                <p></p>
                            </span>
                        </li>
                    </ul>
                </div>
                <?php
                $package_settings = get_option('mism_package_settings');
                if ($package_settings['default_currency'] == "1") {
                    $default_currency = '&dollar;';
                } elseif ($package_settings['default_currency'] == "2") {
                    $default_currency = '&euro;';
                }

                foreach ($packages AS $package) {
                    ?>
                    <div class="package pricing-table-wrap">
                        <ul class="pricing-table ">
                            <li class="avia-heading-row">
                                <div class="first-table-item"><?php echo get_the_title($package->ID); ?></div>
                                <span class="pricing-extra"></span>
                            </li>
                            <li class="avia-pricing-row">
                                <?php  echo $default_currency; echo $package_price = get_post_meta($package->ID, 'wpcf-price', true); ?>
                                <span class="currency-symbol"><?php //echo $default_currency; ?></span><br>

                            </li>
                            <li class="">
                                <?php
                                $sites = get_post_meta($package->ID, 'wpcf-sites-allowed', true);
                                if ($sites == "-1") {
                                    $sites = "Unlimited Sites";
                                }
                                elseif ($sites == "1") {
                                    $sites = $sites." Site";
                                }
                                else{
									$sites = $sites." Sites";
								}
                                echo $sites;
                                ?>
                            </li>
                            <li class="">
                                <?php
                                $months = get_post_meta($package->ID, 'wpcf-duration', true);
                                echo $months . ' months';
                                ?>
                            </li>
                            <li class="avia-button-row">
                                <div class="avia-button-wrap avia-button-center  avia-builder-el-6  el_before_av_button  avia-builder-el-first ">
                                    <?php if (is_user_logged_in()) { ?>

                                        <form id="form_buy_package<?php echo $package->ID; ?>" method="POST" action="<?php echo get_option('siteurl') . '/checkout' ?>">
                                            <input id="package_id" type="hidden" name="package_id" value="<?php echo $package->ID; ?>"/>
                                            <input id="paypal_url" type="hidden" name="paypal_url" value="<?php echo $paypal_url ?>"/>
                                            <input id="default_currency" type="hidden" name="currency_code" value="<?php echo $currency_code; ?>"/>
                                            <input id="user_id" type="hidden" name="user_id" value="<?php echo get_current_user_id(); ?>"/>
                                            <input type="hidden" name="custom" value="<?php echo get_current_user_id(); ?>"/>
                                            <input type="hidden" name="cmd" value="_xclick"/>
                                            <input type="hidden" name="tax" value="<?php echo $mism_package_settings['tax']; ?>"/>
                                            <input type="hidden" name="business" value="<?php echo $mism_package_settings['business_email']; ?>"/>
                                            <input type="hidden" name="return" value="<?php echo $mism_package_settings['return']; ?>"/>
                                            <input type="hidden" name="notify_url" value="<?php echo $mism_package_settings['notify']; ?>"/>
                                            <input type="hidden" name="cancel_return" value="<?php echo $mism_package_settings['cancel']; ?>"/>
                                            <input type="hidden" name="amount" value="<?php echo $package_price; ?>"/>
                                            <input type="hidden" name="item_name" value="<?php echo $package->post_title; ?>"/>
                                            <input type="hidden" name="item_number" value="<?php echo $package->ID; ?>"/>



                                            <input class="avia_iconbox_title buy_button avia-button  avia-color-green avia-size-medium" type="submit" name="buy_package" value="Buy"/>
                                        </form>
                                    <?php } else { ?>
                                        <a class="avia-button  avia-icon_select-yes-left-icon avia-color-theme-color avia-size-medium avia-position-center " href="<?php echo get_option('siteurl') . "/login"; ?>">
                                            <span data-av_iconfont="entypo-fontello" data-av_icon="" aria-hidden="true" class="avia_button_icon avia_button_icon_left "></span>
                                            <span class="avia_iconbox_title">Login</span>
                                        </a>
                                    <?php } ?>

                                </div>
                                <p></p>
                                <p></p>
                            </li>
                        </ul>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        }
    } else {
        ?>
        <div class="avia_message_box avia-color-red avia-size-large avia-icon_select-yes avia-border-  avia-builder-el-2  el_after_av_notification  el_before_av_notification ">
            <span class="avia_message_box_title">Note</span>
            <div class="avia_message_box_content">
                <span data-av_iconfont="entypo-fontello" data-av_icon="" aria-hidden="true" class="avia_message_box_icon"></span>
                <p>You can purchase package after full consumption of all sites in current package.</p>
            </div>
            <p>Please contact our support for more information or read our documentation.</p>
        </div>
        <?php
    }
}

add_action('wp_ajax_purchase_package', 'purchase_package_callback');
add_action('wp_ajax_nopriv_purchase_package', 'purchase_package_callback');

function purchase_package_callback() {
    global $wpdb;
    $package_id = $_POST['package_id'];
    $user_id = $_POST['userid'];
    $package_details = get_post($package_id);
    $package_name = $package_details->post_title;
    $package_price = get_post_meta($package_id, 'wpcf-price', true); # Package Price
    $site_allowed = get_post_meta($package_id, 'wpcf-sites-allowed', true);
    $site_consumed = 0; # No. of Sites consumed
    $months = get_post_meta($package_id, 'wpcf-duration', true);
    $mism_package_settings = get_option('mism_package_settings');
    $discount =  $_POST['discount']; # Discount
    $tax = $_POST['tax']; # Tax
    $date = date('Y-m-d H:i:s');
    $currency_code = $_POST['currency_code'];
    $business_email = $_POST['business_email'];
    $return_url = $_POST['return'];
    $notify_url = $_POST['notify_url'];
    $cancel_url = $_POST['cancel_return'];
    $paypal_url = $_POST['paypal_url'];
    $total_amount = $_POST['total_amount']; # Total Price including Tax and Discount
    $purchased_date = date('Y-m-d H:i:s');  #Current Date
    $expiry_date = date('Y-m-d H:i:s', strtotime('+' . $months . 'months'));
    $status = 2; # payment pending status

    if($total_amount==0)
    {
        $paypal_url = $return_url;
    }
    else
    {
        $total_price = $sub_price + $tax;
    }

    $data = array(
        'cmd' => '_xclick',
        'currency_code' => $currency_code,
        'item_name' => $package_name,
        'item_number' => $package_id,
        'custom' => $id,
        'amount' => $package_price,
        'business' => $business_email,
        'return' => $return_url,
        'notify_url' => $notify_url,
        'cancel_return' => $cancel_url,
    );

    #   Loop for posted values and append to querystring
    $queryString = '';
    foreach ($data as $key => $value) {
        if ($key != "submit") {
            //$value = urlencode(stripslashes($value));
            $queryString .= "$key=$value&";
        }
    }

    $sql = "SELECT count(*) FROM `" . $wpdb->base_prefix . "orders` WHERE package_id='" . $package_id . "' AND user_id='" . $user_id . "'";
    $results = $wpdb->get_results($sql);

    if ($results > 0) {
        $sql = "INSERT INTO `" . $wpdb->base_prefix . "orders`(package_id, user_id, package_name, package_price, discount, tax, total_price, purchased_date, expiry_date, status) VALUES('" . $package_id . "','" . $user_id . "','" . $package_name . "','" . $package_price . "', '" . $discount . "','" . $tax . "','" . $total_amount . "','" . $purchased_date . "','" . $expiry_date . "','" . $status . "')";
        $wpdb->query($wpdb->prepare($sql));
        $order_id = $wpdb->insert_id;

        $query = "INSERT INTO `" . $wpdb->base_prefix . "package_counter`(order_id, site_allowed, site_consumed)VALUES('" . $order_id . "','" . $site_allowed . "','" . $site_consumed . "')";
        $wpdb->query($wpdb->prepare($query));
    }

    echo $paypal_url;
    wp_die();
}

/*---------------------   adding a new page under settings for admin to add manual package-------------------------------*/
add_action('admin_menu' , 'cu_addpackage_page');

function cu_addpackage_page() {
    add_submenu_page('edit.php?post_type=package', 'Assign Package Manually', 'Assign Package Manually', 'manage_options', 'add-package-manually', 'cu_add_package_manually');
    add_submenu_page('edit.php?post_type=package', 'Orders', 'Orders', 'manage_options', 'package-orders', 'cu_package_orders');
}


function cu_add_package_manually(){
	 // Check that the user is allowed to update options
    global $wpdb;
    if (!current_user_can('manage_options')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }

    $html = '';
    $html .= '<div class="wrap">';
    $html .= '<div id="icon-tools" class="icon32"></div>';
    $html .= '<h2>Add Package Manually</h2>';

    if(isset($_POST['save_settings']))
    {
        $user_id = $_POST['add_package_username'];
        $package_id = $_POST['add_packagename'];

        if ($package_id == 'reset') {
            /*$numUsedSites = $wpdb->get_row("SELECT * FROM " . $wpdb->base_prefix . "orders WHERE user_id = " . $user_id . " AND status = 1");
            $package_counter_id = $numUsedSites->id;
            $total_consumed = $wpdb->get_row("SELECT `site_consumed` FROM " . $wpdb->base_prefix . "package_counter WHERE order_id = " . $package_counter_id);
            $sites_consumed = $total_consumed->site_consumed;
            */
            $data = array('status' => 2);
            $where = array('user_id' => $user_id, 'status' => 1);
            $where_format = array('%d', '%d');
            $wpdb->update
            (
                $wpdb->base_prefix . "orders",
                $data,
                $where,
                '',
                $where_format
            );

        } else {
            $package_price = get_post_meta($package_id, 'wpcf-price', true);

            $package_details = get_post($package_id);

            $package_settings = get_option('mism_package_settings');
            $tax_manually_percent = $package_settings['tax'];
            $discount_manually = 0;
            $tax_amount = (($package_price * $tax_manually_percent) / 100);
            $taxed_price = $tax_amount + $package_price;

            $purchased_date = date('Y-m-d H:i:s') . "<br/>";  #Current Date
            $months = get_post_meta($package_id, 'wpcf-duration', true) . "<br/>";
            $months = '+' . (int)$months . 'months';
            $expiry_date = date('Y-m-d H:i:s', strtotime($months));

            $status = 1; # payment paid status

            //Designed to get number of consumed sites in users current package to apply to new package so they don't get FREE sites.
            //If they have a package for 50 sites and have used 40 but want to move to a larger package, we need to apply that 40.

            $numUsedSites = $wpdb->get_row("SELECT * FROM " . $wpdb->base_prefix . "orders WHERE user_id = " . $user_id . " AND status = 1");
            $package_counter_id = $numUsedSites->id;

            //Query package counter to get actual number of consumed sites
            $total_consumed = $wpdb->get_row("SELECT `site_consumed` FROM " . $wpdb->base_prefix . "package_counter WHERE order_id = " . $package_counter_id);
            $sites_consumed = $total_consumed->site_consumed;
            // if (!$total_consumed->site_consumed) {
            //           $total_consumed->site_consumed = '0';
            //         }
            //
            //Enter function here to detect and disable any CURRENT package so that new package shows on their Create New Site page with new package!!
            // Added by Buddy Quaid - bq
            $data = array('status' => 2);
            $where = array('user_id' => $user_id, 'status' => 1);
            $where_format = array('%d', '%d');
            $wpdb->update
            (
                $wpdb->base_prefix . "orders",
                $data,
                $where,
                '',
                $where_format
            );
            //End function to disable existing plan before assigning new plan.
            $sql = "INSERT INTO `" . $wpdb->base_prefix . "orders`(package_id, user_id, package_name, package_price, discount, tax, total_price, purchased_date, expiry_date, status) VALUES('" . $package_id . "','" . $user_id . "','" . $package_details->post_title . "','" . $package_price . "', '" . $discount_manually . "','" . $tax_amount . "','" . $taxed_price . "','" . $purchased_date . "','" . $expiry_date . "','" . $status . "')";
            $wpdb->query($wpdb->prepare($sql));

            $order_id = $wpdb->insert_id;
            $sites_allowed = get_post_meta($package_id, 'wpcf-sites-allowed', true);

            $sql = "INSERT INTO `" . $wpdb->base_prefix . "package_counter`(order_id, site_allowed, site_consumed) VALUES('" . $order_id . "','" . $sites_allowed . "','" . $sites_consumed . "')";
            $result = $wpdb->query($wpdb->prepare($sql));

            if ($result) {
                $html .= "<div class='updated'><p>";
                $html .= "Your package has been assigned successfully.";
                $html .= '<a title="View Orders" href=' . get_admin_url() . 'edit.php?post_type=package&page=package-orders>Click here</a>&nbsp;to see your order.';
                $html .= "</p></div>";
            } else {
                $html .= "<div class='error'><p>";
                $html .= "Unable to assign package. Please try again.";
                $html .= "</p></div>";
            }
        }
        //echo $html;
    }




    $html .= '<form method="POST" action="">';
    $html .= '<table class="form-table">';
     global $wpdb;
    $sql = "SELECT * FROM `{$wpdb->base_prefix}users` WHERE ID!='1'";
    $results = $wpdb->get_results($sql);

    $html .= '<tr>';
    $html .= '<th scope="row"><label>User: </label></th>';
    $html .= '<td><select id="add_package_username" name="add_package_username">';

    $html .= '<option value="0">Select User</option>';
    foreach($results as $username => $uservalue)
    {
        $user_first_name = get_the_author_meta('first_name', $uservalue->ID );

        $html .= '<option value="'.$uservalue->ID.'"> '.$user_first_name .'  ('.$uservalue->user_email.')  ID='.$uservalue->ID.' </option>';
    }
    $html .='</select>';
    $html .= '</td>';
    $html .= '</tr>';

    $args = array(
        'post_type' => 'package',
        'post_status' => 'publish',
        'meta_key' => 'wpcf-status',
        'meta_value' => array('1', '2'),
        'posts_per_page' => '-1',
        'orderby' => 'ID',
        'order' => 'ASC'
    );
    $packages = get_posts($args);

    $html .= '<tr>';
    $html .= '<th scope="row"><label>Package:</label></th>';
    $html .= '<td><select id="add_packagename" name="add_packagename">';

    $html .= '<option>Select Package</option>';
    $html .= '<option value="reset">No Package</option>';
    foreach($packages as $packagename => $packagevalue)
    {
      // echo "<pre>"; print_r (get_post_meta($packagevalue->ID)); die("</pre>");
        $package_price = get_post_meta($packagevalue->ID, 'wpcf-price', true );
        $package_sites_allowed = get_post_meta($packagevalue->ID, 'wpcf-sites-allowed', true );
        $package_duration = get_post_meta($packagevalue->ID, 'wpcf-duration', true );

	$html .= '<option value="'.$packagevalue->ID.'"> '.$packagevalue->post_title .' | $'.$package_price.' | '. $package_sites_allowed.' | '. $package_duration.')</option>';

    }
    $html .= '</select>';
    $html .= '</td>';
    $html .= '</tr>';
    $html .= '<tr><td>';
    $html .= '<input type="submit" name="save_settings" class="button button-primary" value="Save Settings"/>';
    $html .= '</td></tr>';
    $html .= '</table>';
    $html .= '</form>';
    $html .= '</div>';
    $html .= '</div>';

    echo $html;
}

function cu_package_orders(){

  if (!current_user_can('manage_options')) {
      wp_die('You do not have sufficient permissions to access this page.');
  }

  global $wpdb;
  $current_user_id= get_current_user_id();
  $sql= "SELECT * FROM `".$wpdb->base_prefix."orders`";
  $result = $wpdb->get_results($sql);
  $count_for_result = count($result);
  $current_date = date('Y-m-d');

  $html='';
  $html.='<div class="cu-order-table" style="margin: 30px;">';
  $html.='<h1>Orders</h1>';
    $html.='<table class="wp-list-table widefat fixed posts">';
    $html.='<thead>';
    $html.='<tr>';

		$html.='<th scope="col" id="thumb column-comments" class="manage-column column-thumb column-comments" style="">Order Id.</th>';
		$html.='<th scope="col" id="tags" class="manage-column column-tags" style="">Username</th>';
		$html.='<th scope="col" id="tags" class="manage-column column-tags" style="">Package Title</th>';
		$html.='<th scope="col" id="tags" class="manage-column column-tags" style="">Package Price</th>';
		$html.='<th scope="col" id="date" class="manage-column column-date sortable asc" style="">';
		$html.='<span>Discount</span>';
		$html.='</th>';
		$html.='<th scope="col" id="date" class="manage-column column-date sortable asc" style="">';
		$html.='<span>Tax</span>';
		$html.='</th>	';
		$html.='<th scope="col" id="date" class="manage-column column-date sortable asc" style="">';
		$html.='<span>Total Price</span>';
		$html.='</th>	';
		$html.='<th scope="col" id="date" class="manage-column column-date sortable asc" style="">';
		$html.='<span>Purchased On</span>';
		$html.='</th>';
		$html.='<th scope="col" id="date" class="manage-column column-date sortable asc" style="">';
		$html.='<span>Expires On</span>';
		$html.='</th>';
		$html.='<th scope="col" id="date" class="manage-column column-date sortable asc" style="">';
		$html.='<span>Amount Status</span>';
		$html.='</th>';
	$html.='</tr>';
	$html.='</thead>';

	$html.='<tfoot>';
		$html.='<tr>';

		$html.='<th scope="col" id="thumb column-comments" class="manage-column column-thumb column-comments" style="">Order Id.</th>';
		$html.='<th scope="col" id="tags" class="manage-column column-tags" style="">Username</th>';
		$html.='<th scope="col" id="tags" class="manage-column column-tags" style="">Package Title</th>';
		$html.='<th scope="col" id="tags" class="manage-column column-tags" style="">Package Price</th>';
		$html.='<th scope="col" id="date" class="manage-column column-date sortable asc" style="">';
		$html.='<span>Discount</span>';
		$html.='</th>';
		$html.='<th scope="col" id="date" class="manage-column column-date sortable asc" style="">';
		$html.='<span>Tax</span>';
		$html.='</th>';
		$html.='<th scope="col" id="date" class="manage-column column-date sortable asc" style="">';
		$html.='<span>Total Price</span>';
		$html.='</th>';
		$html.='<th scope="col" id="date" class="manage-column column-date sortable asc" style="">';
		$html.='<span>Purchased On</span>';
		$html.='</th>';
		$html.='<th scope="col" id="date" class="manage-column column-date sortable asc" style="">';
		$html.='<span>Expires On</span>';
		$html.='</th>';
		$html.='<th scope="col" id="date" class="manage-column column-date sortable asc" style="">';
		$html.='<span>Amount Status</span>';
		$html.='</th>';
	$html.='</tr>';
	$html.='</tfoot>';

	$html.='<tbody id="the-list">';


	foreach($result as $data => $value) {
    $user_first_name = get_the_author_meta('user_email', $value->user_id );

		$html.='<tr class="no-items">';
		$html.='<td class="colspanchange" >'.$value->id.'</td>';
		$html.='<td class="colspanchange" >'.$user_first_name.'</td>';
		$html.='<td class="colspanchange" >'.$value->package_name.'</td>';
		$html.='<td class="colspanchange" >'.$value->package_price.'</td>';
		$html.='<td class="colspanchange" >'.$value->discount.'</td>';
		$html.='<td class="colspanchange" >'.$value->tax.'</td>';
		$html.='<td class="colspanchange" >'.$value->total_price.'</td>';
		$html.='<td class="colspanchange" >'.$value->purchased_date.'</td>';
		$html.='<td class="colspanchange" >'.$value->expiry_date.'</td>';

		if($value->status == 1)
		{
		    $html.='<td class="colspanchange" >Paid</td>';
		}else{
		    $html.='<td class="colspanchange" >Pending</td>';
		}

  	$html.='</tr>';
	} //end foreach

	   $html.='</tbody>';
   $html.='</table>';
  $html.='</div>';
  echo $html;
}
