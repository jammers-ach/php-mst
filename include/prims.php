<?php
/**
 * Prims.php
 * uses prims algorithm to find a minimum spanning tree
 * @author jtm
 */

/**
 * Checks if $seen contains $all
 */
function contains_all_verticies($seen,$all){
    return empty(array_diff($all,$seen));
}

/**
 * looks up in the distance table the size
 */
function distance_lookup($c1,$c2,$distance_table){
    //TODO make this return infinite if there's nothing in the table
    return $distance_table[$c1][$c2]['duration']['value'];
}

/**
 * find the smallest vertex from $v1 to the ones in $vertices
 */
function find_min_vertex($v1,$vertices,$distance_table){
    $min = INF;
    $min_i = 0;

    foreach($vertices as $v2){
        $d = distance_lookup($v1,$v2,$distance_table);
        if($d < $min){
            $min = $d;
            $min_i = $v2;
        }
    }
    return array($min_i,$min);

}

/**
 * Delete an element from an array
 */
function array_delete($array, $element) {
    return array_diff($array, [$element]);
}


/**
 * Use pims to compute the minimum spanning tree
 * @returns an array of names for each vertex in this e.g. ((Helsinki,Stockholm),(Stockholm,Gdansk),(Gdansk,Vilinus))
 */
function prims_mst($distance_table){
    //TODO use sets or something similar to sets for this
    //TODO remove directionality by assuming in = out
    $u = array();
    $v = array_keys($distance_table);

    $new_edges = array();
    $all_vertexes = array_keys($distance_table);

    $a = array_pop($v);
    array_push($u,$a);

    //Keep looping until we've got all the edges
    $i = 0; //Loop protector to prevent infinite loops
    $max_ittr = count($all_vertexes)+4;
    while(!contains_all_verticies($u,$all_vertexes) && $i < $max_ittr){

        //Now go through all the edges in $v find it's closest neighbour in $u
        //Find the miinmum of those and put that vertex in $v
        $min_v = INF;
        $min_i = 0;
        $min_j = 0;
        foreach($v as $v1){
            $mins = find_min_vertex($v1,$u,$distance_table);
            if($mins[1] < $min_v){
                $min_v = $mins[1];
                $min_i = $mins[0];
                $min_j = $v1;
            }
        }
        //echo "$min_i - $min_j\n";
        //add the edge to the edges and the vertex to $u
        array_push($u,$min_j);
        array_push($new_edges,array($min_j,$min_i));

        $v = array_delete($v,$min_j);



        $i++;
    }

    return $new_edges;
}

?>
