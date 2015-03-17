/**
 * map.js
 * drawing routes and plots on the map element
 */


var map;

/**
 * Initilises our vase map
 */
function map_initilise(){
    var mapOptions = {
        center: { lat: 57.70000, lng: 11.9667},
        zoom: 4
    };
    map = new google.maps.Map(document.getElementById('map'),
                                  mapOptions);

    console.log('initilised map');
}


/**
 * puts all the little pins down on the map to show us where the cities are
 */
function load_markers(locations){
    //Create a bounds for convienent zooming
    var markerBounds = new google.maps.LatLngBounds();

    //Add a marker for each city
    for(i in locations){
        var city = locations[i];

        var coords = new google.maps.LatLng(city.lat,city.lng);
        var marker = new google.maps.Marker({
            position: coords,
            title:i,
        });
        marker.setMap(map);
        markerBounds.extend(coords);
    }

    //update the bounding box
    map.fitBounds(markerBounds);

}

/**
 * Goes through the graph and draws lines onto the map
 */
function draw_lines(results){

    for(i in results.distances){
        for(j in results.distances[i]){
            var line = results.distances[i][j].line;
            console.log(i,j,results.distances[i][j]);
            console.log(line);
            // Construct the polygon
             var poly = new google.maps.Polyline({
                path: google.maps.geometry.encoding.decodePath(line),
                 geodesic: true,
                strokeColor: '#FF0000',
                strokeOpacity: 1.0,
                strokeWeight: 2
             });
              poly.setMap(map);
        }
    }
}

/**
 * Loads the graph data to the map
 */
function load_graph_to_map(results){
    load_markers(results.locations);
    draw_lines(results);

}

$(function(){
    map_initilise();
});
