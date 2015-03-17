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
 * Given a list of cities creates a table showing the dinstances between them
 *
 */
function calculate_distance_table($cities){
    $cities2 = array();
    $locations = array();
    $error_cities = array();

    //remove all the blank cities
    $cities = array_filter($cities);

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
            $x = get_two_cities($c1,$c2);
            $results = parse_city_results($x);

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

    $spanning_tree = prims_mst($cities2);

    return array("distances"=>$cities2,"locations"=>$locations,"spanning_tree"=>$spanning_tree,"errors"=>$error_cities);

}



?>
