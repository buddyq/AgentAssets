<?php

add_shortcode('aa_purchase_domain', array('AAPurchaseDomainShortcode','run'));

class AAPurchaseDomainShortcode {

    public static function run() {
        ob_start();

        if (isset($_POST['payment_system'])) {
            if ($_POST['payment_system'] == 'PayPal') {
                self::render_paypal_form();
            }
            if ($_POST['payment_system'] == 'Stripe') {
                self::render_stripe_form();
            }
        } else if(isset($_POST['payment_confirmation'])) {
            if ($_POST['payment_confirmation'] == 'Stripe') {
                self::confirm_stripe();
            }
        } else {
            self::render_purchase_form();
        }

        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public static function render_purchase_form() {
        ?>
        <form method="POST">
            <label>Domain:</label>
            <input type="text" name="domain" value="<?php echo (isset($_GET['domain']) ? $_GET['domain'] : ''); ?>"/>
            <div class="domain-helper"></div>

            <label>Select payment system:</label> <br/>
            <input type="submit" name="payment_system" value="PayPal">
            <input type="submit" name="payment_system" value="Stripe">
        </form>
        <?php
    }

    public static function render_paypal_form($enomDomainModel) {
        $mism_package_settings = get_option( 'mism_package_settings' );
        $payNowButtonUrl = 'https://www.sandbox.paypal.com/cgi-bin/websc';
        $userId = $enomDomainModel['user_id'];

        $receiverEmail = $mism_package_settings['business_email'];

        $productId = $enomDomainModel['id'];
        $itemName = 'Domain: '.$_POST['domain'];

        $domainInfo = self::verify_domain($_POST['domain']);
        $amount = self::calc_price($domainInfo['price']);

        $quantity = 1;

        $returnUrl = 'http://agentassets.com/purchase-domain?status=success&ps=paypal';
        $notifyUrl = $mism_package_settings['notify'];
        $customData = ['user_id' => $userId, 'product_id' => $productId, 'product_type' => 'enom_domain'];
        $domain = $_POST['domain'];

        ?>
        <h4>Order details:</h4>
        Domain: <h3><?php echo strtoupper($domain); ?></h3><br/>
        Price: <h2><?php echo $amount; ?>$</h2><br/>
        <hr/>

        <form action="<?php echo $payNowButtonUrl; ?>" method="post">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="business" value="<?php echo $receiverEmail; ?>">
            <input id="paypalItemName" type="hidden" name="item_name" value="<?php echo $itemName; ?>">
            <input id="paypalQuantity" type="hidden" name="quantity" value="<?php echo $quantity; ?>">
            <input id="paypalAmmount" type="hidden" name="amount" value="<?php echo $amount; ?>">
            <input type="hidden" name="no_shipping" value="1">
            <input type="hidden" name="return" value="<?php echo $returnUrl; ?>">
            <input type="hidden" name="notify" value="<?php echo $notifyUrl; ?>">

            <input type="hidden" name="custom" value="<?php echo json_encode($customData);?>">

            <input type="hidden" name="currency_code" value="USD">
            <input type="hidden" name="lc" value="US">
            <input type="hidden" name="bn" value="PP-BuyNowBF">

            <button class="btn" type="submit">
                Pay Now
            </button>
        </form>

        <?php
    }

    public static function render_stripe_form() {
        $mism_package_settings = get_option( 'mism_package_settings' );
        $domain = $_POST['domain'];
        $domainInfo = self::verify_domain($_POST['domain']);
        $amount = self::calc_price($domainInfo['price']);
        ?>
        <script src="https://js.stripe.com/v3/"></script>

        <h4>Order details:</h4>
        Domain: <h3><?php echo strtoupper($domain); ?></h3><br/>
        Price: <h2><?php echo $amount; ?>$</h2><br/>
        <hr/>
        <form action="" method="post" id="payment-form">
            <div class="form-row">
                <label for="card-element">
                    Credit or debit card
                </label>
                <input type="hidden" name="domain" value="<?php echo $_POST['domain']; ?>">
                <input type="hidden" name="payment_confirmation" value="Stripe" >
                <div id="card-element">
                    <!-- a Stripe Element will be inserted here. -->
                </div>

                <!-- Used to display Element errors -->
                <div id="card-errors" role="alert"></div>
            </div>

            <button class="btn">Submit Payment</button>
        </form>

        <script>
            var stripe = Stripe('<?php echo $mism_package_settings['stripe_public_key']; ?>');
            var elements = stripe.elements();
            // Custom styling can be passed to options when creating an Element.
            var style = {
                base: {
                    // Add your base input styles here. For example:
                    fontSize: '16px',
                    lineHeight: '24px'
                }
            };

            // Create an instance of the card Element
            var card = elements.create('card', {style: style});

            // Add an instance of the card Element into the `card-element` <div>
            card.mount('#card-element');

            card.addEventListener('change', function(event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            // Create a token or display an error when the form is submitted.
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                stripe.createToken(card).then(function(result) {
                    if (result.error) {
                        // Inform the user if there was an error
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        // Send the token to your server
                        stripeTokenHandler(result.token);
                    }
                });
            });
            function stripeTokenHandler(token) {
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);

                // Submit the form
                form.submit();
            }
        </script>
        <?php
    }

    public static function confirm_stripe() {
        ini_set('display_errors', 1);

        // step 1: verify domain
        if (!empty($_POST['domain'])) {
            $domain = $_POST['domain'];
            $domainInfo = self::verify_domain($domain);

            if (is_array($domainInfo) && $domainInfo['available']) {
                $mism_package_settings = get_option( 'mism_package_settings' );
                $price = self::calc_price($domainInfo['price']);

                // step 2: verify payment
                require_once(dirname(dirname(__FILE__)) . "/lib/Stripe.php");
                Stripe::setApiKey($mism_package_settings['stripe_secret_key']);
                $token = $_POST['stripeToken'];

                /** @var WP_User $user */
                $user = WP_User::get_data_by("ID", get_current_user_id());
                $customer = Stripe_Customer::create(array(
                    "email" => $user->user_email,
                    "card" => $token,
                    "description" => $user->user_login,
                ));

                $charge = Stripe_Charge::create(array(
                    "amount" => $price * 100, // amount in cents, again
                    "currency" => "usd",
                    //"card" => $token,
                    "customer" => $customer->id,
                    "description" => "Agentassets.com - purchasing domain ".$domain)
                );

                // step 3: register domain
                if ($charge) {
                    $result = EnomDomainModel::purchaseDomain($domainInfo['tld'], $domainInfo['sld']);
                    if ($result != false /* && $result->ErrCount < 1*/ ) {
                        $insertResult = EnomDomainModel::insert(array(
                            'tld'               => $domainInfo['tld'],
                            'sld'               => $domainInfo['sld'],
                            'user_id'           => get_current_user_id(),
                            'price'             => $price,
                            'expire'            => $result->RegistryExpDate,
                            'status'            => EnomDomainModel::STATUS_ACTIVE,
                        ));

                        if (!$insertResult) {
                            echo "Invalid DB query!\n";
                            global $wpdb;
                            var_dump($wpdb->last_error);
                            echo "\n\n\n";
                            var_dump($result->asXML());
                            die();
                        }
                    } else {
                        echo "Invalid API request!\n";
                        var_dump($result);
                        die();
                    }
                } else {
                    echo "Invalid charge!\n";
                    var_dump($charge);
                    die();
                }
            } else {
                wp_redirect('/purchase-domain/?domain='.urlencode($_POST['domain']));
            }
        }
        echo '...';
        //wp_redirect('/create-new-site');
    }

    public static function verify_domain($domain) {
        $ret = 'Invalid domain format';
        $domainParts = explode('.', $domain);
        if (count($domainParts) == 2) {
            $sld = $domainParts[0];
            $tld = $domainParts[1];

            $plugin = Domainmap_Plugin::instance();
            $domainInfo = array();
            $domainInfo['sld'] = $sld;
            $domainInfo['tld'] = $tld;
            $domainInfo['available'] = $plugin->get_reseller()->check_domain($tld, $sld);
            $domainInfo['price'] = $plugin->get_reseller()->get_tld_price($tld);

            return $domainInfo;
        }
        return $ret;
    }

    public static function calc_price($amount) {
        $mism_package_settings = get_option( 'mism_package_settings' );
        return round($amount * ( 100 + (float)$mism_package_settings['domain_fee']) / 100, 0);
    }

}