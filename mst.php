<?php

include 'include/graph.php';

$results = calculate_all($_GET['cities']);

echo json_encode($results);
?>
