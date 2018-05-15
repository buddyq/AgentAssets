<?php
/**
 * Template Name: Google Maps API
 *
 * This template is used to demonstrate how to use Google Maps
 * in conjunction with a WordPress theme.
 *
 * @since          Twenty Fifteen 1.0
 *
 * @package        Acme_Project
 * @subpackage     Twenty_Fifteen
 * AIzaSyDWbWUlpzZQTWji_KBnz-uYtaXUTEr4l8I
 */
?>

<?php get_header(); ?>

<style type="text/css">
#map-canvas {
	width:    100%;
	height:   650px;
}
</style>

<div id="map-canvas"></div><!-- #map-canvas -->

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&signed_in=true"></script>

<script type="text/javascript">
/**

google.maps.event.addDomListener( window, 'load', gmaps_results_initialize );
/**
 * Renders a Google Maps centered on Atlanta, Georgia. This is done by using
 * the Latitude and Longitude for the city.
 *
 * Getting the coordinates of a city can easily be done using the tool availabled
 * at: http://www.latlong.net
 *
 * @since    1.0.0
 * /
function gmaps_results_initialize() {

	var map = new google.maps.Map( document.getElementById( 'map-canvas' ), {

		zoom:           10,
		center:         new google.maps.LatLng( 36.656295, -119.6056783 ),

	});

}
*/
</script>
<script type="text/javascript">
	google.maps.event.addDomListener( window, 'load', gmaps_results_initialize );
/**
 * Renders a Google Maps centered on Atlanta, Georgia. This is done by using
 * the Latitude and Longitude for the city.
 *
 * Getting the coordinates of a city can easily be done using the tool availabled
 * at: http://www.latlong.net
 *
 * @since    1.0.0
 */
function gmaps_results_initialize() {

	if ( null === document.getElementById( 'map-canvas' ) ) {
		return;
	}

	var map, marker;

	map = new google.maps.Map( document.getElementById( 'map-canvas' ), {

		zoom:           10,
		center:         new google.maps.LatLng( 36.656295, -119.6056783 ),

	});

	marker = new google.maps.Marker({

		position: new google.maps.LatLng( 36.727062, -119.7928532 ),
		map:      map

	});

	marker = new google.maps.Marker({

		position: new google.maps.LatLng( 36.858857, -119.783139 ),
		map:      map

	});

	marker = new google.maps.Marker({

		position: new google.maps.LatLng( 36.331729, -119.292332 ),
		map:      map

	});

}
</script>

<?php

get_footer();
