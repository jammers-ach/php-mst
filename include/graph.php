<?php
/**
 * graph.php
 * creates a graph of cities/distances
 * @author jtm
 *
 */

include 'directions.php';

/**
 * Given a list of cities creates a table showing the dinstances between them
 *
 */
function calculate_distance_table($cities){
    $cities2 = array();
    $locations = array();
    //Go through each city, compare it to other cities if it's not blank or
    //comparing against itself
    foreach($cities as &$i){
        if($i != ''){
            $cities2[$i] = array();
            foreach($cities as $j){
                if($i != $j && $j != ''){
                    $x = get_two_cities($i,$j);
                    $results = parse_city_results($x);
                    $cities2[$i][$j] = $results;
                    $locations[$i] = $results['start_coord'];
                }
            }
        }
    }


    return array("distances"=>$cities2,"locations"=>$locations);

}



?>
