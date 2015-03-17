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
    //Go through each city, compare it to other cities if it's not blank or
    //comparing against itself
    foreach($cities as &$i){
        if($i != ''){
            $cities2[$i] = array();
            foreach($cities as $j){
                if($i != $j && $j != ''){
                    $x = get_two_cities($i,$j);
                    $results = parse_city_results($x);
                    if(!is_null($results)){
                        $cities2[$i][$j] = $results;
                        $locations[$i] = $results['start_coord'];
                        $locations[$j] = $results['end_coord'];
                    }
                }
            }
            //If the city couldn't be found it should be removed and added to the list of error cities
            if(empty($cities2[$i])){
                unset($cities2[$i]);
                array_push($error_cities,$i);
            }
        }
    }

    $spanning_tree = prims_mst($cities2);

    return array("distances"=>$cities2,"locations"=>$locations,"spanning_tree"=>$spanning_tree,"errors"=>$error_cities);

}



?>
