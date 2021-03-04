<?php

require '../../includes/init.php';

$db = require '../../includes/db.php';

// Additional headers
header('Access-Control-Allow-Methods: PUT');

//Instantiate job ad object;
$job = new Job($db);

// Get raw posted data

$data = json_decode(file_get_contents("php://input"));

$job->id = $data->id;
$job->job_title = $data->job_title;
$job->content = $data->content;
$job->company_name = $data->company_name;
$job->salary = $data->salary;
$job->submitted_at = $data->submitted_at;

// Update job ad

if ($job->update()) {

    echo json_encode(json_encode(['message' => 'Ad updated']));
    echo json_encode($job);
} else {
    echo json_encode(json_encode(['message' => 'Ad not updated']));
}
