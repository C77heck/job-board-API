<?php

require '../../includes/init.php';

$db = require '../../includes/db.php';


// Additional headers
header('Access-Control-Allow-Methods: DELETE');

// Instantiate job object;
$job = new Job($db);

// get raw request data(id)
$data = json_decode(file_get_contents("php://input"));

// Bind the request id to the job id to be used in the method below
$job->id = $data->id;

//delete ad
if ($job->delete()) {
    echo json_encode(['message' => 'advert is deleted']);
} else {
    echo json_encode(['message' => 'Sorry deleting the ad was not succesful']);
}
