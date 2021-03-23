<?php


require '../../includes/init.php';

$db = require '../../includes/db.php';
//Instantiate job ad object;
$job = new Job($db);


//Instantiate job ad object;
$job = new Job($db);

// get ID
if (isset($_GET['id'])) {
    $job->id = $_GET['id'];
} else {
    echo json_encode(["message" => "id is not valid or not supplied"]);
    die();
}

// Get job ad

// json conversion if execution succeeds
if ($job->getAdById()) {
    echo json_encode($job);
} else {
    echo json_encode(["message" => "item not found in database"]);
}
