jQuery('document').ready(function(){
    google.maps.event.addListener(map, 'tilesloaded', function() {
        jQuery('#map_canvas, #map').find('img').attr('nopin','nopin');
    });
});
