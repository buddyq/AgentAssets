jQuery('document').ready(function(){
    google.maps.event.addListener(map, 'tilesloaded', function() {
        jQuery('#map_canvas, #map').find('img').attr('nopin','nopin');
        jQuery('div.gm-style img:not([nopin=nopin])').attr('nopin','nopin');
    });
});