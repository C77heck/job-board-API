<?php


require '../../includes/init.php';

$db = require '../../includes/db.php';
//Instantiate job ad object;
$job = new Job($db);


//Instantiate job ad object;
$job = new Job($db);

// get ID
$job->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get job ad
$job->getAdById();


// json conversion
echo json_encode($job);
