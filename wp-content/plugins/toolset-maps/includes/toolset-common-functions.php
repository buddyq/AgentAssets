<?php

/**
* Toolset Maps - Common methods
*
* @package ToolsetMaps
*
* @since 1.0
*/

class Toolset_Addon_Maps_Common {

	const address_coordinates_option = 'toolset_maps_address_coordinates';
	
	static $used_map_ids		= array();
	static $used_marker_ids		= array();
	
	static $coordinates_set		= null;
	static $coordinates_save	= false;
	
	static $maps_api_url_js			= null;
	static $maps_api_url_geocode	= null;
	
	function __construct() {
		add_action( 'init', array( $this, 'init' ), 5 );
		
		if ( is_admin() ) {
			$protocol = TOOLSET_ADDON_MAPS_PROTOCOL;
		} else {
			$protocol = TOOLSET_ADDON_MAPS_FRONTEND_PROTOCOL;
		}
		self::$maps_api_url_js	 	= $protocol . '://maps.googleapis.com/maps/api/js';
		self::$maps_api_url_geocode = 'https://maps.googleapis.com/maps/api/geocode/json';
	}
	
	function init() {
		
		$this->register_assets();
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ), 20 );
		
		add_action( 'wp_footer', array( $this, 'css_fix' ) );
		add_action( 'admin_footer', array( $this, 'css_fix' ) );
		
		add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 4 );
		
		add_action( 'wp_footer', array( $this, 'maybe_save_stored_coordinates_in_footer' ), 99 );
		add_action( 'admin_footer', array( $this, 'maybe_save_stored_coordinates_in_footer' ), 99 );
		// When saving meta values, the footer actions are not fired
		add_action( 'added_post_meta', array( $this, 'maybe_save_stored_coordinates_in_footer' ), 99 );
		add_action( 'updated_post_meta', array( $this, 'maybe_save_stored_coordinates_in_footer' ), 99 );
		//add_action( 'deleted_post_meta', array( $this, 'maybe_save_stored_coordinates_in_footer' ), 99 );
		add_action( 'added_term_meta', array( $this, 'maybe_save_stored_coordinates_in_footer' ), 99 );
		add_action( 'updated_term_meta', array( $this, 'maybe_save_stored_coordinates_in_footer' ), 99 );
		//add_action( 'deleted_term_meta', array( $this, 'maybe_save_stored_coordinates_in_footer' ), 99 );
		add_action( 'added_user_meta', array( $this, 'maybe_save_stored_coordinates_in_footer' ), 99 );
		add_action( 'updated_user_meta', array( $this, 'maybe_save_stored_coordinates_in_footer' ), 99 );
		//add_action( 'deleted_user_meta', array( $this, 'maybe_save_stored_coordinates_in_footer' ), 99 );
	}
	
	/**
	* css_fix
	*
	* Fix styles for some elements needed by this plugin
	*
	* @since 1.0
	*/

	function css_fix() {
		if ( is_admin() ) {
			$assets_url = TOOLSET_ADDON_MAPS_URL;
		} else {
			$assets_url = TOOLSET_ADDON_MAPS_FRONTEND_URL;
		}
		?>
		<style>
		/* Global fix for images inside the map */
		.gm-style img,
		.toolset-google-map-preview .gm-style img {
			max-width: none;
		}
		/* Global glow effect when updating a field */
		.toolset-google-map {
			transition: all 1s linear;
		}
		.toolset-google-map-container .toolset-google-map.toolset-being-updated,
		.toolset-google-map-container .toolset-google-map-lat.toolset-being-updated ,
		.toolset-google-map-container .toolset-google-map-lon.toolset-being-updated {
			box-shadow: 0 0 10px 2px #7ad03a;
			border-color: #7ad03a;
		}
		.toolset-google-map-container .toolset-google-map.toolset-latlon-error,
		.toolset-google-map-container .toolset-google-map-lat.toolset-latlon-error ,
		.toolset-google-map-container .toolset-google-map-lon.toolset-latlon-error {
			box-shadow: 0 0 10px 2px #B94A48;
			border-color: #B94A48;
			color: #B94A48;
		}
		/* Global map preview dimensions */
		.toolset-google-map-preview {
			width: 100%;
			height: 200px;
			float: right;
			background-color: #ccc;
			background-image: url(<?php echo $assets_url; ?>/resources/images/powered-by-google-on-toolset.png);
			background-position: 50% 50%;
			background-repeat: no-repeat;
		}
		.toolset-google-map-preview-closest-address {
			width: 100%;
			float: right;
			clear: right;
			background: #f1f1f1;
			margin: 0;
			font-size: 0.9em;
		}
		.toolset-google-map-preview-closest-address-value {
			font-size: 0.9em;
		}
		.toolset-google-map-preview .toolset-google-map-preview-reload {
			display: none;
			overflow: hidden;
			position: absolute; 
			top: 0px; 
			left: 0px; 
			right: 0px; 
			bottom: 0px; 
			text-align: center;
			background-color: #ccc;
			background-image: url(<?php echo $assets_url; ?>/resources/images/powered-by-google-on-toolset-reload.png);
			background-position: 50% 40%;
			background-repeat: no-repeat;
			z-index: 1000;
		}
		.toolset-google-map-preview .toolset-google-map-preview-reload a {
			display: block;
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			cursor: pointer;
			margin-left: -999999px;
		}
		/* Backend styles - generic */
		.wp-admin .pac-container {
			z-index: 100150;
		}
		/* Backend styles - Types field */
		.wp-admin .wpt-google_address.wpt-repetitive .wpt-field-item {
			padding: 0 0 0 10px;
			border-left: solid 3px #ccc;
		}
		.wp-admin .toolset-google-map-container {
			overflow: hidden;
		}
		.wp-admin .toolset-google-map-inputs-container {
			width: 52%;
			float: left;
		}
		.wp-admin .toolset-google-map-preview {
			width: 45%;
			height: 200px;
			float: right;
		}
		.wp-admin .toolset-google-map-preview-closest-address {
			width: 45%;
			float: right;
			clear: right;
		}
		/* Backend styles - Types fields table */
		.wp-admin .toolset-google-map-toggle-latlon {
			cursor: pointer;
			display: block;
			margin: 5px 0 10px;
		}
		.wp-admin .toolset-google-map-toggling-latlon {
			padding-bottom: 5px
		}
		.wp-admin .toolset-google-map-toggling-latlon p{
			margin: 0 0 5px 0;
		}
		.wp-admin .toolset-google-map-label,
		.wp-admin .toolset-shortcode-gui-dialog-container .toolset-google-map-label {
			display: inline-block;
			width: 120px;
		}
		.wp-admin .toolset-google-map-lat,
		.wp-admin .toolset-google-map-lon{
			display: inline-block;
			width: -webkit-calc(100% - 80px);
			width: calc(100% - 80px;);
			max-width: 300px;
		}
		.wp-admin #wpcf-post-relationship .toolset-google-map-inputs-container,
		.wp-admin #wpcf-post-relationship .toolset-google-map-preview {
			width: 100%;
			min-width: 200px;
			float: none;
		}
		.wp-admin #wpcf-post-relationship .toolset-google-map-preview {
			height: 150px;
		}
		.wp-admin #wpcf-post-relationship .toolset-google-map-preview-closest-address {
			width: 100%;
			float: none;
			clear: both;
		}
		#wpcf-post-relationship table .textfield.toolset-google-map {
			width: 99% !important;
		}
		.wp-admin #wpcf-post-relationship .toolset-google-map-label {
			display: block;
			width: auto;
		}
		.wp-admin #wpcf-post-relationship .toolset-google-map-lat,
		.wp-admin #wpcf-post-relationship .toolset-google-map-lon {
			width: auto;

		}
		</style>
		<?php
	}
	
	function plugin_row_meta( $plugin_meta, $plugin_file, $plugin_data, $status ) {
		$this_plugin = basename( TOOLSET_ADDON_MAPS_PATH ) . '/toolset-maps-loader.php';
		if ( $plugin_file == $this_plugin ) {
			$promo_args = array(
				'query'	=> array(
					'utm_source'	=> 'mapsplugin',
					'utm_campaign'	=> 'maps',
					'utm_medium'	=> 'release-notes-plugin-row',
					'utm_term'		=> 'Toolset Maps 1.1 release notes'
				)
			);
			$plugin_link = self::get_documentation_promotional_link( $promo_args, 'https://wp-types.com/version/maps-1-1/' );
			$plugin_meta[] = sprintf(
					'<a href="%1$s" target="_blank">%2$s</a>',
					$plugin_link,
					__( 'Toolset Maps 1.1 release notes', 'wpv-views' ) 
				);
		}
		return $plugin_meta;
	}
	
	function register_assets() {
		
		if ( is_admin() ) {
			$assets_url = TOOLSET_ADDON_MAPS_URL;
		} else {
			$assets_url = TOOLSET_ADDON_MAPS_FRONTEND_URL;
		}
		
		$maps_api_js_url = self::$maps_api_url_js;
		$maps_api_js_url = apply_filters( 'toolset_filter_toolset_maps_api_js_url', $maps_api_js_url );
		
		/**
		* Google Maps script
		* @version 3.5.2
		*/
        wp_register_script(
            'google-maps',
            esc_url(
                add_query_arg(
                    array(
                        'sensor' => false,
                        'libraries' => 'places',
                    ),
                    $maps_api_js_url
                )
            ),
            array(),
            '3.5.2',
            true
        );
		
		/**
		* jQuery geocomplete
		* @version 1.6.5
		* @url http://ubilabs.github.io/geocomplete/
		*/
		wp_register_script( 'jquery-geocomplete', $assets_url . '/resources/js/jquery.geocomplete.min.js', array( 'jquery', 'google-maps' ), '1.6.5', true );
		
		/**
		* Frontend rendering script
		*/
		wp_register_script( 'views-addon-maps-script', $assets_url . '/resources/js/wpv_addon_maps.js', array( 'jquery', 'google-maps', 'underscore' ), TOOLSET_ADDON_MAPS_VERSION, true );
		wp_localize_script(
			'views-addon-maps-script',
			'views_addon_maps_i10n',
			array(
				'marker_default_url'		=> TOOLSET_ADDON_MAPS_FRONTEND_URL . '/resources/images/spotlight-poi.png',
				'cluster_default_imagePath'	=> TOOLSET_ADDON_MAPS_FRONTEND_URL . '/resources/images/clusterer/m'
			)
		);
		
		/**
		* Marker clusterer
		* @version 1.0
		* @url https://github.com/googlemaps/js-marker-clusterer
		*/
		wp_register_script( 'marker-clusterer-script', $assets_url . '/resources/js/markerclusterer.js', array( 'jquery', 'google-maps', 'underscore', 'views-addon-maps-script' ), '1.0', true );
		wp_localize_script(
			'marker-clusterer-script',
			'views_addon_maps_clusterer_i10n',
			array(
				
			)
		);
		
		/**
		* Editor assets for Types in backend and CRED in frontend
		*/		
		wp_register_script( 'toolset-google-map-editor-script', $assets_url . '/resources/js/wpv_addon_maps_editor.js', array( 'jquery-geocomplete' ), TOOLSET_ADDON_MAPS_VERSION, true );
        wp_localize_script(
            'toolset-google-map-editor-script',
            'toolset_google_address_i10n',
            array(
				'showhidecoords'	=> __( 'Show/Hide coordinates', 'toolset-maps' ),
                'latitude'			=> __('Latitude', 'toolset-maps'),
                'longitude'			=> __('Longitude', 'toolset-maps'),
				'usethisaddress'	=> __( 'Use this address', 'toolset-maps' ),
				'closestaddress'	=> __( 'Closest address: ', 'toolset-maps' ),
            )
        );
		
	}
	
	function wp_enqueue_scripts() {
		
	}
	
	static function get_stored_coordinates() {
		$coordinates_set = self::$coordinates_set;
		if ( $coordinates_set === null ) {
			$coordinates_set = get_option( self::address_coordinates_option, array() );
			self::$coordinates_set = $coordinates_set;
		}
		return $coordinates_set;
	}
	
	/**
	* get_coordinates
	*
	* Given an address, ping the Maps API and get the latitude and longitude coordinates
	*
	* @since 1.0
	*/
	
	static function get_coordinates( $address ) {
		
		$address_hash = md5( $address );
		$coordinates_set = self::get_stored_coordinates();
		$data = array();

		if ( ! isset( $coordinates_set[ $address_hash ] ) ) {
			
			if ( 
				strpos( $address, '{' ) === 0
				&& strpos( $address, '}' ) === intval( strlen( $address ) - 1 )
			) {
				$address_trimmed = str_replace( array( '{', '}' ), '', $address );
				$address_components = explode( ',', $address_trimmed );
				$address_components = array_map( 'trim', $address_components );
				if ( count( $address_components ) == 2 ) {
					$address_lat = $address_components[0];
					$address_lon = $address_components[1];
					if (
						self::is_valid_latitude( $address_lat ) 
						&& self::is_valid_longitude( $address_lon )
					) {
						$coordinates_set[ $address_hash ]['lat'] 			= $address_lat;
						$coordinates_set[ $address_hash ]['lon'] 			= $address_lon;
						$coordinates_set[ $address_hash ]['address']		= $address;
						$coordinates_set[ $address_hash ]['address_passed']	= $address;
						
						$data = $coordinates_set[ $address_hash ];
						
						self::$coordinates_save = true;
						self::$coordinates_set = $coordinates_set;
					} else {
						return sprintf(
						__( 'The pair of coordinates %1$s passed is not valid', 'toolset-maps' ),
						$address
					);
					}
				} else {
					return sprintf(
						__( 'The pair of coordinates %1$s passed is not valid', 'toolset-maps' ),
						$address
					);
				}
			} else {

				$args = array( 'address' => urlencode( $address ), 'sensor' => 'false' );
				
				$api_key = apply_filters( 'toolset_filter_toolset_maps_get_api_key', '' );
				if ( ! empty( $api_key ) ) {
					$args['key'] = esc_attr( $api_key );
				}
				
				$maps_api_url_geocode = self::$maps_api_url_geocode;
				$maps_api_url_geocode = apply_filters( 'toolset_filter_toolset_maps_api_geocode_url', $maps_api_url_geocode );
				
				$url        = add_query_arg( $args, $maps_api_url_geocode );
				$response 	= wp_remote_get( $url, array( 'decompress' => false ) );

				if ( is_wp_error( $response ) ) {
					return __( 'wp_remote_get could not communicate with the Gogle Maps API.', 'toolset-maps' );
				}

				$data = wp_remote_retrieve_body( $response );

				if ( is_wp_error( $data ) ) {
					return sprintf(
						__( 'wp_remote_retrieve_body could not get data from the the Gogle Maps API response. URL was %s', 'toolset-maps' ),
						$url
					);
				}

				if ( $response['response']['code'] == 200 ) {

					$data = json_decode( $data );

					if ( $data->status === 'OK' ) {

						$coordinates = $data->results[0]->geometry->location;

						$coordinates_set[ $address_hash ]['lat'] 			= $coordinates->lat;
						$coordinates_set[ $address_hash ]['lon'] 			= $coordinates->lng;
						$coordinates_set[ $address_hash ]['address']		= (string) $data->results[0]->formatted_address;
						$coordinates_set[ $address_hash ]['address_passed']	= $address;

						$data = $coordinates_set[ $address_hash ];
						
						self::$coordinates_save = true;
						self::$coordinates_set = $coordinates_set;

					} elseif ( $data->status === 'ZERO_RESULTS' ) {
						return sprintf(
							__( 'ZERO_RESULTS - No location found for the entered address. URL was %s', 'toolset-maps' ),
							$url
						);
					} elseif( $data->status === 'INVALID_REQUEST' ) {
						return sprintf(
							__( 'INVALID_REQUEST - Invalid request. Did you enter an address? URL was %s', 'toolset-maps' ),
							$url
						);
					} else {
						return sprintf( 
							__( '%1$s - Something went wrong while retrieving your map, please ensure you have entered the short code correctly. URL was %2$s', 'toolset-maps' ),
							$data->status,
							$url
						);
					}

				} else {
					return sprintf(
						__( '%1$s - Unable to contact Google API service. URL was %2$s', 'toolset-maps' ),
						$response['response']['code'],
						$url
					);
				}
			
			}

		} else {

			$data = $coordinates_set[ $address_hash ];

		}

		return $data;
	}
	
	static function is_valid_latitude( $latitude ) {
		if ( preg_match( "/^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,20}$/", $latitude ) ) {
			return true; 
		} else { 
			return false; 
		} 
	}
	
	static function is_valid_longitude( $longitude ) { 
		if ( preg_match( "/^-?([1]?[1-7][1-9]|[1]?[1-8][0]|[1-9]?[0-9])\.{1}\d{1,20}$/", $longitude ) ) { 
			return true; 
		} else { 
			return false; 
		} 
	}
	
	/**
	* render_map
	*
	* @since 1.0
	*/
	
	static function render_map( $map_id, $map_data ) {
		$defaults = array(
			'map_width'					=> '100%',
			'map_height'				=> '250px',
			'general_zoom'				=> 5,
			'general_center_lat'		=> 0,
			'general_center_lon'		=> 0,
			'fitbounds'					=> 'on',
			'single_zoom'				=> 14,
			'single_center'				=> 'on',
			'map_type'					=> 'roadmap',
			'show_layer_interests'		=> 'false',
			'marker_icon'				=> '',
			'marker_icon_hover'			=> '',
			'draggable'					=> 'on',
			'scrollwheel'				=> 'on',
			'double_click_zoom'			=> 'on',
			'background_color'			=> '',
			'cluster'					=> 'off',
			'cluster_grid_size'			=> 60,
			'cluster_max_zoom'			=> '',
			'cluster_click_zoom'		=> 'on',
			'cluster_min_size'			=> 2
		);
		$map_data = wp_parse_args( $map_data, $defaults );
		
		if ( preg_match( '/^[+-]?((\d+(\.\d*)?)|(\.\d+))$/', $map_data['map_width'] ) ) {                
			$map_data['map_width'] .= 'px';
		}
		if ( preg_match( '/^[+-]?((\d+(\.\d*)?)|(\.\d+))$/', $map_data['map_height'] ) ) {                
			$map_data['map_height'] .= 'px';
		}
		
		$current_used_map_ids = self::$used_map_ids;
		$current_used_map_ids[] = $map_id;
		self::$used_map_ids = $current_used_map_ids;
		
		$return = '<div';
		$return .= ' id="js-wpv-addon-maps-render-' . $map_id . '"';
		$return .= ' style="width:' . $map_data['map_width'] . '; height:' . $map_data['map_height'] . ';"';
		$return .= ' class="wpv-addon-maps-render js-wpv-addon-maps-render js-wpv-addon-maps-render-' . $map_id . '"';
		$return .= ' data-map="' . esc_attr( $map_id ) . '"';
		$return .= ' data-generalzoom="' . esc_attr( $map_data['general_zoom'] ) . '"';
		$return .= ' data-generalcenterlat="' . esc_attr( $map_data['general_center_lat'] ) . '"';
		$return .= ' data-generalcenterlon="' . esc_attr( $map_data['general_center_lon'] ) . '"';
		$return .= ' data-fitbounds="' . esc_attr( $map_data['fitbounds'] ) . '"';
		$return .= ' data-singlezoom="' . esc_attr( $map_data['single_zoom'] ) . '"';
		$return .= ' data-singlecenter="' . esc_attr( $map_data['single_center'] ) . '"';
		$return .= ' data-maptype="' . esc_attr( $map_data['map_type'] ) . '"';
		$return .= ' data-showlayerinterests="' . esc_attr( $map_data['show_layer_interests'] ) . '"';
		$return .= ' data-markericon="' . esc_attr( $map_data['marker_icon'] ) . '"';
		$return .= ' data-markericonhover="' . esc_attr( $map_data['marker_icon_hover'] ) . '"';
		$return .= ' data-draggable="' . esc_attr( $map_data['draggable'] ) . '"';
		$return .= ' data-scrollwheel="' . esc_attr( $map_data['scrollwheel'] ) . '"';
		$return .= ' data-doubleclickzoom="' . esc_attr( $map_data['double_click_zoom'] ) . '"';
		$return .= ' data-backgroundcolor="' . esc_attr( $map_data['background_color'] ) . '"';
		$return .= ' data-cluster="' . esc_attr( $map_data['cluster'] ) . '"';
		$return .= ' data-clustergridsize="' . esc_attr( $map_data['cluster_grid_size'] ) . '"';
		$return .= ' data-clustermaxzoom="' . esc_attr( $map_data['cluster_max_zoom'] ) . '"';
		$return .= ' data-clusterclickzoom="' . esc_attr( $map_data['cluster_click_zoom'] ) . '"';
		$return .= ' data-clusterminsize="' . esc_attr( $map_data['cluster_min_size'] ) . '"';
		$return .= '>';
		$return .= '</div>';
		return $return;
	}
	
	/**
	* render_marker
	*
	* @since 1.0
	*/
	
	static function render_marker( $map_id, $marker_data, $content = '' ) {
		$defaults = array(
			'id'			=> '',
			'title'			=> '',
			'lat'			=> '',
			'lon'			=> '',
			'icon'			=> '',
			'icon_hover'	=> '',
		);
		if (
			empty( $marker_data['id'] )
			|| empty( $marker_data['lat'] )
			|| empty( $marker_data['lon'] )
		) {
			return;
		}
		$marker_data = wp_parse_args( $marker_data, $defaults );
		
		$current_used_marker_ids = self::$used_marker_ids;
		if ( ! isset( $current_used_marker_ids[ $map_id ] ) ) {
			$current_used_marker_ids[ $map_id ] = array();
		}
		$current_used_marker_ids[ $map_id ][] = $marker_data['id'] ;
		self::$used_marker_ids = $current_used_marker_ids;
		
		$return = '<div style="display:none"';
		$return .= ' class="wpv-addon-maps-marker js-wpv-addon-maps-marker js-wpv-addon-maps-marker-' . esc_attr( $marker_data['id'] ) . ' js-wpv-addon-maps-markerfor-' . esc_attr( $map_id ) . '"';
		$return .= ' data-marker="' . esc_attr( $marker_data['id'] ) . '"';
		$return .= ' data-markertitle="' . esc_attr( $marker_data['title'] ) . '"';
		$return .= ' data-markerfor="' . esc_attr( $map_id ) . '"';
		$return .= ' data-markerlat="' . esc_attr( $marker_data['lat'] ) . '"';
		$return .= ' data-markerlon="' . esc_attr( $marker_data['lon'] ) . '"';
		$return .= ' data-markericon="' . esc_attr( $marker_data['icon'] ) . '"';
		$return .= ' data-markericonhover="' . esc_attr( $marker_data['icon_hover'] ) . '"';
		$return .= '>' . $content . '</div>';
		return $return;
	}
	
	function maybe_save_stored_coordinates_in_footer() {
		$coordinates_save = self::$coordinates_save;
		if ( $coordinates_save ) {
			$coordinates_set = self::$coordinates_set;
			if ( 
				$coordinates_set !== null 
				&& is_array( $coordinates_set )
			) {
				update_option( self::address_coordinates_option, $coordinates_set, false );
			}
		}
	}
	
	static function save_stored_coordinates( $coordinates_set ) {
		self::$coordinates_set = $coordinates_set;
		update_option( self::address_coordinates_option, $coordinates_set, false );
	}
	
	
	/**
	* get_documentation_promotional_link
	*
	* @param $args	array
	* 		@param query	array
	* 		@param anchor	string
	* @param $url	string
	*
	* @return string
	*
	* @note utm_source=toolsetmapsplugin&utm_campaign=toolsetmaps&utm_medium=foo&utm_term=bar
	*
	* @since 1.0
	*/
	
	static function get_documentation_promotional_link( $args = array(), $url = TOOLSET_ADDON_MAPS_DOC_LINK ) {
		if ( isset( $args['query'] ) ) {
			$url = esc_url( add_query_arg( $args['query'], $url ) );
		}
		if ( isset( $args['anchor'] ) ) {
			$url .= '#' . esc_attr( $args['anchor'] );
		}
		return $url;
	}
	
	/**
	* Pluck a certain field out of each object in a list, if it exists.
	*
	* This has the same functionality and prototype of
	* array_column() (PHP 5.5) but also supports objects.
	* This is a post of the native wp_list_pluck 
	* but avoids errors when the $field key is not found on the $list entry
	*
	* @since 1.1
	*
	* @param array      $list      List of objects or arrays
	* @param int|string $field     Field from the object to place instead of the entire object
	* @param int|string $index_key Optional. Field from the object to use as keys for the new array.
	*                              Default null.
	* @return array Array of found values. If `$index_key` is set, an array of found values with keys
	*               corresponding to `$index_key`. If `$index_key` is null, array keys from the original
	*               `$list` will be preserved in the results.
	*/
	static function pseudo_list_pluck( $list, $field, $index_key = null ) {
		if ( ! $index_key ) {
			/*
			 * This is simple. Could at some point wrap array_column()
			 * if we knew we had an array of arrays.
			 */
			foreach ( $list as $key => $value ) {
				if ( is_object( $value ) ) {
					if ( property_exists( $value, $field ) ) {
						$list[ $key ] = $value->$field;
					} else {
						unset( $list[ $key ] );
					}
				} else {
					if ( isset( $value[ $field ] ) ) {
						$list[ $key ] = $value[ $field ];
					} else {
						unset( $list[ $key ] );
					}
				}
			}
			return $list;
		}

		/*
		 * When index_key is not set for a particular item, push the value
		 * to the end of the stack. This is how array_column() behaves.
		 */
		$newlist = array();
		foreach ( $list as $value ) {
			if ( is_object( $value ) ) {
				if ( property_exists( $value, $field ) ) {
					if ( isset( $value->$index_key ) ) {
						$newlist[ $value->$index_key ] = $value->$field;
					} else {
						$newlist[] = $value->$field;
					}
				}
			} else {
				if ( isset( $value[ $field ] ) ) {
					if ( isset( $value[ $index_key ] ) ) {
						$newlist[ $value[ $index_key ] ] = $value[ $field ];
					} else {
						$newlist[] = $value[ $field ];
					}
				}
			}
		}

		return $newlist;
	}
	
}

$Toolset_Addon_Maps_Common = new Toolset_Addon_Maps_Common();