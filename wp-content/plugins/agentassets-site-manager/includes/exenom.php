<?php


class ExEnom extends Domainmap_Reseller_Enom {
    /**
     * Purchases a domain name.
     *
     * @since 4.0.0
     *
     * @access protected
     * @return string|boolean The domain name if purchased successfully, otherwise FALSE.
     */
    public function purchaseDomain($data) {
        $sld = $data['sld'];
        $tld = $data['tld'];
        //$expiry = array_map( 'trim', explode( '/', filter_input( INPUT_POST, 'card_expiration' ), 2 ) );

        $response = $this->_exec_command( self::COMMAND_PURCHASE, array(
                'sld'                        => $sld,
                'tld'                        => $tld,
                'UseDNS'                     => 'default',
                //'ChargeAmount'               => $this->get_tld_price( $tld ),
                //'EndUserIP'                  => self::_get_remote_ip(),
                //'CardType'                   => filter_input( INPUT_POST, 'card_type' ),
                //'CCName'                     => filter_input( INPUT_POST, 'card_cardholder' ),
                //'CreditCardNumber'           => preg_replace( '/[^0-9]/', '', filter_input( INPUT_POST, 'card_number' ) ),
                //'CreditCardExpMonth'         => $expiry[0],
                //'CreditCardExpYear'          => isset( $expiry[1] ) ? "20{$expiry[1]}" : '',
                //'CVV2'                       => filter_input( INPUT_POST, 'card_cvv2' ),
                //'CCAddress'                  => filter_input( INPUT_POST, 'billing_address' ),
                //'CCCity'                     => filter_input( INPUT_POST, 'billing_city' ),
                //'CCStateProvince'            => filter_input( INPUT_POST, 'billing_state' ),
                //'CCZip'                      => filter_input( INPUT_POST, 'billing_zip' ),
                //'CCPhone'                    => $billing_phone,
                //'CCCountry'                  => filter_input( INPUT_POST, 'billing_country' ),
                //'RegistrantFirstName'        => filter_input( INPUT_POST, 'registrant_first_name' ),
                //'RegistrantLastName'         => filter_input( INPUT_POST, 'registrant_last_name' ),
                //'RegistrantOrganizationName' => filter_input( INPUT_POST, 'registrant_organization' ),
                //'RegistrantJobTitle'         => filter_input( INPUT_POST, 'registrant_job_title' ),
                //'RegistrantAddress1'         => filter_input( INPUT_POST, 'registrant_address1' ),
                //'RegistrantAddress2'         => filter_input( INPUT_POST, 'registrant_address2' ),
                //'RegistrantCity'             => filter_input( INPUT_POST, 'registrant_city' ),
                //'RegistrantStateProvince'    => filter_input( INPUT_POST, 'registrant_state' ),
                //'RegistrantPostalCode'       => filter_input( INPUT_POST, 'registrant_zip' ),
                //'RegistrantCountry'          => filter_input( INPUT_POST, 'registrant_country' ),
                //'RegistrantEmailAddress'     => filter_input( INPUT_POST, 'registrant_email' ),
                //'RegistrantPhone'            => $registrant_phone,
                //'RegistrantFax'              => $registrant_fax
            ) + ( isset( $data['ExtendedAttributes'] ) ? (array)$data['ExtendedAttributes'] : array() ) );

        $this->_log_enom_request( self::REQUEST_PURCHASE_DOMAIN, $response );

        if ( $response && isset( $response->RRPCode ) && $response->RRPCode == 200 ) {
            $this->_populate_dns_records( $tld, $sld );
            return $response;
        }
        var_dump($response);
        die();
        return false;
    }

    /**
     * Executes remote command and returns response of execution.
     *
     * @since 4.0.0
     *
     * @access private
     * @param string $command The command name.
     * @param array $args Additional optional arguments.
     * @param string $endpoint The concrete endpoint to use for the request.
     * @return SimpleXMLElement Returns simplexml object on success, otherwise FALSE.
     */
    protected function _exec_command( $command, $args = array(), $endpoint = false ) {
        $options = Domainmap_Plugin::instance()->get_options();

        if ( !isset( $args['uid'] ) || !isset( $args['pw'] ) ) {
            if ( !isset( $args['uid'] ) ) {
                $args['uid'] = isset( $options[self::RESELLER_ID]['uid'] ) ? $options[self::RESELLER_ID]['uid'] : '';
            }

            if ( !isset( $args['pw'] ) ) {
                $args['pw'] = isset( $options[self::RESELLER_ID]['pwd'] ) ? $options[self::RESELLER_ID]['pwd'] : '';
            }
        }

        if ( !isset( $args['responsetype'] ) ) {
            $args['responsetype'] = 'xml';
        }

        $args['command'] = $command;

        if ( !$endpoint ) {
            $endpoint = $this->_get_environment() == self::ENVIRONMENT_PRODUCTION ? self::ENDPOINT_PRODUCTION : self::ENDPOINT_TEST;
        }

        $sslverify = !isset( $options[self::RESELLER_ID]['sslverification'] ) || $options[self::RESELLER_ID]['sslverification'] == 1;
        $response = wp_remote_get( $endpoint . http_build_query( $args ), array( 'sslverify' => $sslverify ) );
        if ( is_wp_error( $response ) ) {
            return $response;
        }

        $response_code = wp_remote_retrieve_response_code( $response );
        $response_body = wp_remote_retrieve_body( $response );
        if ( $response_code != 200 ) {
            $error = new WP_Error();
            $error->add( $response_code, strip_tags( $response_body ) );
            return $error;
        }

        libxml_use_internal_errors( true );
        return simplexml_load_string( $response_body );
    }

    /**
     * Returns current environment.
     *
     * @since 4.0.0
     *
     * @access private
     * @param array $options The plugin options.
     * @return string The current environment.
     */
    private function _get_environment( $options = null ) {
        // if no options were passed, take it from the plugin instance
        if ( !$options ) {
            $options = Domainmap_Plugin::instance()->get_options();
            $options = isset( $options[self::RESELLER_ID] ) ? $options[self::RESELLER_ID] : array();
        }

        return isset( $options['environment'] ) ? $options['environment'] : self::ENVIRONMENT_TEST;
    }

    /**
     * Logs request to reseller API.
     *
     * @since 4.0.0
     *
     * @access protected
     * @param int $type The request type.
     * @param SimpleXMLElement $response The response information, received on request.
     */
    private function _log_enom_request( $type, $xml ) {
        if ( !is_object( $xml ) ) {
            return;
        }

        $valid = false;
        $errors = array();

        if ( is_wp_error( $xml ) ) {
            $errors = $xml->get_error_messages();
            $xml = array();
        } elseif ( is_a( $xml, 'SimpleXMLElement' ) ) {
            $valid = !isset( $xml->ErrCount ) || $xml->ErrCount == 0;
            if ( !$valid && isset( $xml->errors ) ) {
                $errors = json_decode( json_encode( $xml->errors ), true );
            }
        } else {
            $errors[] = __( 'Unexpected error appears during request processing. Please, try again later.', 'domainmap' );
            if ( filter_input( INPUT_GET, 'debug' ) ) {
                $errors[] = $xml;
            }
        }

        $this->_log_request( $type, $valid, $errors, $xml );
    }

    /**
     * Populates either DNS A or CNAME records for purchased domain.
     *
     * @since 4.0.0
     *
     * @access private
     * @global wpdb $wpdb The database connection.
     * @param string $tld The TLD name.
     * @param string $sld The SLD name.
     */
    private function _populate_dns_records( $tld, $sld ) {
        global $wpdb, $blog_id;

        $ips = $args = array();
        $options = Domainmap_Plugin::instance()->get_options();

        // if server ip addresses are provided, use it to populate DNS records
        if ( !empty( $options['map_ipaddress'] ) ) {
            foreach ( explode( ',', trim( $options['map_ipaddress'] ) ) as $ip ) {
                if ( filter_var( $ip, FILTER_VALIDATE_IP ) ) {
                    $ips[] = $ip;
                }
            }
        }

        // looks like server ip addresses are not set, then try to read it automatically
        if ( empty( $ips ) && function_exists( 'dns_get_record' ) ) {
            // fetch unchanged domain name from database, because get_option function could return mapped domain name
            $basedomain = parse_url( $wpdb->get_var( "SELECT option_value FROM {$wpdb->options} WHERE option_name = 'siteurl'" ), PHP_URL_HOST );
            // fetch domain DNS A records
            $dns = @dns_get_record( $basedomain, DNS_A );
            if ( is_array( $dns ) ) {
                $ips = wp_list_pluck( $dns, 'ip' );
            }
        }

        // if we have an ip address to populate DNS record, then try to detect if we use shared or dedicated hosting
        $dedicated = false;
        if ( !empty( $ips ) ) {
            $check = sha1( time() );

            switch_to_blog( 1 );
            $ajax_url = admin_url( 'admin-ajax.php' );
            $ajax_url = str_replace( parse_url( $ajax_url, PHP_URL_HOST ), current( $ips ), $ajax_url );
            restore_current_blog();

            $response = wp_remote_request( esc_url_raw( add_query_arg( array(
                'action' => Domainmap_Plugin::ACTION_HEARTBEAT_CHECK,
                'check'  => $check,
            ), $ajax_url ) ) );

            $dedicated = !is_wp_error( $response ) && wp_remote_retrieve_response_code( $response ) == 200 && wp_remote_retrieve_body( $response ) == $check;
        }

        // populate request arguments
        if ( !empty( $ips ) && $dedicated ) {
            // network is hosted on dedicated hosting and we can use DNS A records
            $i = 0;
            foreach ( $ips as $ip ) {
                if ( filter_var( trim( $ip ), FILTER_VALIDATE_IP ) ) {
                    $i++;
                    $args["HostName{$i}"] = '@';
                    $args["RecordType{$i}"] = 'A';
                    $args["Address{$i}"] = $ip;
                }
            }
        } else {
            // network is hosted on shared hosting and we can use DNS CNAME records for it
            $origin = $wpdb->get_row( "SELECT * FROM {$wpdb->blogs} WHERE blog_id = " . intval( $blog_id ) );

            $args['HostName1'] = "{$sld}.{$tld}";
            $args['RecordType1'] = 'CNAME';
            $args['Address1'] = "{$origin->domain}.";

            $args['HostName2'] = "www.{$sld}.{$tld}";
            $args['RecordType2'] = 'CNAME';
            $args['Address2'] = "{$origin->domain}.";
        }

        // setup DNS records if it has been populated
        if ( !empty( $args ) ) {
            $args['sld'] = $sld;
            $args['tld'] = $tld;

            $response = $this->_exec_command( self::COMMAND_SET_HOSTS, $args );
            $this->_log_enom_request( self::REQUEST_SET_DNS_RECORDS, $response );
        }
    }
}