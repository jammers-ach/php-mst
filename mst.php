<?php

include 'include/graph.php';

$results = calculate_distance_table($_GET['cities']);

echo json_encode($results);
?>
