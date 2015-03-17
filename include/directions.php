<?php
/**
 * directions.php
 * functions for talking to and parsing google status
 * @author jtm
 */
include 'api_key.php';

/**
 * Contacts google to find the direction distance between two cities
 * @returns just returns the parsed JSON @see https://developers.google.com/maps/documentation/directions/#DirectionsRequests
 * @param $city1 the starting point
 * @param $city2 the destination
 * @param $key the google api key
 */
function get_two_cities($city1,$city2){
    global $key;
    //Form the URL for the directions reuqest
    $url = 'https://maps.googleapis.com/maps/api/directions/json?';
    $options= array("origin"=>$city1,"destination"=>$city2,"key"=>$key);

    //Make the request, reutnr data
    //$result = http_get($url,$options,$info); //Can't use this, pcel_http is not installing
    $result = file_get_contents($url.http_build_query($options),false);
    $data = json_decode(utf8_encode($result), true);
    return $data;
}


/**
 * Parses the results from google to tell us:
 *   the lat&long of the two cities
 *   the distance/time between them
 *   the points of the route in lat&long
 * @param $results @see https://developers.google.com/maps/documentation/directions/#DirectionsRequests
 * @returns associative array:
 */
function parse_city_results($results){
    $status_code = $results["status"];
    if($status_code == "OK"){
        $route = $results['routes'][0];
        $leg = $route['legs'][0];

        $new_results = array();

        $new_results['line'] = $route['overview_polyline']['points'];
        $new_results['start_coord'] = $leg['start_location'];
        $new_results['end_coord'] =  $leg['end_location'];
        $new_results['duration'] = $leg['duration'];
        $new_results['distance'] = $leg['distance'];
        return $new_results;
    } elseif($status_code == "ZERO_RESULTS"){
        return NULL;
    } elseif($status_code == "NOT_FOUND"){
        return NULL;

    }else {
        error_log("Error of $status_code for $i,$j");
        throw new Exception("Error from google: status $status_code");
    }
}
?>

