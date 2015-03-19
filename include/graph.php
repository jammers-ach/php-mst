<?php
/**
 * graph.php
 * creates a graph of cities/distances
 * @author jtm
 *
 */

include 'directions.php';
include 'prims.php';

/**
 * Calculates the distances between citites
 * @param $cities a list of cities
 *  @returns an associative array of:
 *      distances: the routes and distances between cities
 *      locations: the lat/long of each city it found
 *      errors: list of cities that couldn't be found
 *      status: ok/fail
 */
function calculate_distance_table($cities){
    $cities2 = array();
    $locations = array();
    $error_cities = array();

    //remove all the blank cities
    $cities = array_filter($cities);
    $total_requests = 0;
    $requests_time = array();

    //Create our associative table where each index will give you route information
    foreach($cities as $city){
        $cities2[$city] = array();
    }

    //foreach($cities as &$i){
    for($i = 0;$i < count($cities);$i++ ){
        $c1 = $cities[$i];

        for($j = $i+1;$j < count($cities);$j++ ){

            //Get the rsults from the walk between the two
            $c2 = $cities[$j];

            $start = microtime(true); //track execution time
            $x = get_two_cities($c1,$c2); //make request
            $results = parse_city_results($x);//parse response
            $time_elapsed = microtime(true) - $start;

            $total_requests += 1;
            array_push($requests_time,$time_elapsed);

            //If it was a real result, put it in both both directions
            if(!is_null($results)){
                $cities2[$c1][$c2] = $results;
                $cities2[$c2][$c1] = $results;

                $locations[$c1] = $results['start_coord'];
                $locations[$c2] = $results['end_coord'];
            }
        }
        //If the city couldn't be found it should be removed and added to the list of error cities
        if(empty($cities2[$c1])){
            unset($cities2[$c1]);
            array_push($error_cities,$c1);
        }
    }




    return array("distances"=>$cities2,
        "locations"=>$locations,
        "errors"=>$error_cities,
        "status"=>"OK",
        "total_requests"=>$total_requests,
        "requests_time"=>$requests_time,);


}

/**
 * Calculates the distances between citites and the spanning trees
 * @param $cities a list of cities
 *  @returns same as @see calculate_distance_table  but with
 *      spanning_tree: a list of (city1,city2) edges for the minimum spanning tree
 **/
function calculate_all($cities){

    $results = calculate_distance_table($cities);

    $start = microtime(true); //track execution time
    $results["spanning_tree"] = prims_mst($results["distances"]);
    $time_elapsed = microtime(true) - $start;

    $results["graph_time"] = $time_elapsed;

    return $results;

}




?>
