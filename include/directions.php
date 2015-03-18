<?php
/**
 * directions.php
 * functions for talking to and parsing google status
 * @author jtm
 */
include 'api_key.php';


define("retries_max",2);

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
function parse_city_results($results,$tries=0){
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
    } elseif($status_code == "OVER_QUERY_LIMIT"){
        //If we're over query it might just be because we've made too many queries in a second
        //So just try again until we get the error
        if($tires > retries_max){

            $error_message = $results["error_message"];
            throw new Exception("Error from google: status $status_code, $error_message ");
        }else{
            error_log("Overy query limit, sleeping");
            sleep(1);
            return parse_city_results($results,$tries+1);
        }

    }else {
        error_log("Error of $status_code for $i,$j");
        $error_message = $results["error_message"];
        throw new Exception("Error from google: status $status_code, $error_message ");
    }
}
?>

