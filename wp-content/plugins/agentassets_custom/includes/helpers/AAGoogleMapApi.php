<?php
class AAGoogleMapApi
{
    private $map_height;
    private $map_width;
    private $options;
    private $position;
    private $description;
    private $api_key;
    private $open_window;
    private $marker;
    
    public function __construct($atts) {

        $this->map_height = (!strpos($atts['map_height'], '%') ? (int)$atts['map_height'] . 'px' : $atts['map_height']);
        $this->map_width = (!strpos($atts['map_width'], '%') ? (int)$atts['map_width'] . 'px' : $atts['map_width']);

        $this->options['mapTypeId'] = (isset($atts['map_type_id']) && in_array(strtolower($atts['map_type_id']),
            array('roadmap', 'satellite', 'hybrid', 'terrain')) ? strtolower($atts['map_type_id'] ) : 'roadmap');
        $this->options['zoom'] = $atts['zoom'];

        if (!empty($atts['latitude']) && !empty($atts['longitude'])) {
            $this->options['center'] = $this->position = array('lat' => (float)$atts['latitude'], 'lng' => (float)$atts['longitude']);
        } elseif (!empty($atts['address'])) {
            $geocode = $this->getGeocode($atts['address']);
            if ($geocode) {
                $this->options = array_merge($this->options, $geocode);
                $this->options['center'] = $this->position = $geocode;
            } else {
                return false;
            }
        } else {
            return false;
        }

        $this->options['scrollwheel'] = $atts['scrollwheel'];
        $this->options['disableDefaultUI'] = $atts['disable_default_ui'];

        $this->description = '';
        if (!empty($atts['bubble_marker_address'])) {
            $this->description .= '<strong>' . $atts['bubble_marker_address'] . '</strong><br>';
        }
        if (!empty($atts['city_state'])) {
            $this->description .= '<strong>' . $atts['city_state'] . '</strong><br>';
        }
        if (!empty($atts['price'])) {
            $this->description .= '<strong>Price:&nbsp;</strong>' . $atts['price'] . '<br>';
        }
        if (!empty($atts['agent_name'])) {
            $this->description .= '<strong><em>Represented By:&nbsp;</em></strong><em>' . $atts['agent_name'] . '</em><br>';
        }

        $this->api_key = 'key=' . (!empty($atts['api_key']) ? $atts['api_key'] : 'AIzaSyCFVCN5SzM9EzvW-5FzL3nHhmcCkY1EYr4');

        $this->open_window = !empty($atts['open_window']) ? 'infowindow.open(map, marker);' : '';

        $this->marker = '""';
        if (!empty($atts['marker_url'])) {
            $this->marker = '{
                url: "' . $atts['marker_url'] . '",
                ';
            if (!empty($atts['marker_size'])) {
                $this->marker .= '
                /*size: new google.maps.Size(' . $atts['marker_size'] . ', ' . $atts['marker_size'] . '),
                origin: new google.maps.Point(0, 0),*/
                scaledSize: new google.maps.Size(' . $atts['marker_size'] . ', ' . $atts['marker_size'] . ')
                ';
            }
            $this->marker .= '
            }';
        }

        $this->options['mapTypeControlOptions'] = array (
            'style' => 'google.maps.MapTypeControlStyle.HORIZONTAL_BAR',
            'position' => 'google.maps.ControlPosition.TOP_CENTER'
        );
    }
    
    public function showMap() {
        $content = "
            <script src=\"https://maps.googleapis.com/maps/api/js?{$this->api_key}&sensor=false\" type=\"text/javascript\"></script>
            <div id=\"google_map\" style=\"height: " . $this->map_height . "; width: " . $this->map_width . ";\"></div>
            <br>
            <div>
                <a id=\"aa_google_map_focus\" class=\"button\" href=\"#\" data-map=\"location_map\" 
                        data-marker=\"address_marker\">Focus on marker</a>
            </div>
            <script>
                var map;
                function initialize() {
                    var mapOptions = " . json_encode($this->options, JSON_UNESCAPED_UNICODE) . "
                    map = new google.maps.Map(document.getElementById('google_map'), mapOptions);
                    
                    var marker = new google.maps.Marker({
                        position: " . json_encode($this->position) . ",
                        map: map,
                        icon: " . $this->marker . "
                    });
        
                    var infowindow = new google.maps.InfoWindow({
                        content: '<p>$this->description</p>'
                    });
            
                    google.maps.event.addListener(marker, 'click', function() {
                        infowindow.open(map, marker);
                    });
                    
                    " . $this->open_window . "
                    
                    var centerControlDiv = document.createElement('div');
                    
                    centerControlDiv.index = 1;
                    map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);
                    
                    map.setOptions({
                        mapTypeControlOptions: {
                            left: '130px',
                            style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                            position: google.maps.ControlPosition.TOP_LEFT
                        }
                    });
                    
                    document.getElementById('aa_google_map_focus').addEventListener('click', function(e){
                        e.preventDefault();
                        map.setCenter(" . json_encode($this->position) . ");
                        return false;
                    });
                }

                google.maps.event.addDomListener(window, 'load', initialize);
            </script>
        ";

        echo $content;
    }


    public function getGeocode($address) {
        $result = false;
        
        $cache = get_option('google_map_address');
        if (!empty($cache) && md5($cache) == get_option('google_map_info_hash')) {
            $result = array(
                'lat' => $cache->results[0]->geometry->location->lat,
                'lng' => $cache->results[0]->geometry->location->lng,
            );
            return $result;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://maps.googleapis.com/maps/api/geocode/json?address=" . rawurlencode($address) . "&sensor=false");
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($status == 200) {
            $response = json_decode($response);
            update_option('google_map_address', $response);
            $result = array(
                'lat' => $response->results[0]->geometry->location->lat,
                'lng' => $response->results[0]->geometry->location->lng,
            );
        }
        return $result;
    }
    
}