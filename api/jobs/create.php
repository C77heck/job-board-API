<?php

require '../../includes/init.php';

$db = require '../../includes/db.php';

// Additional headers
header('Access-Control-Allow-Methods: POST');


// Instantiate job object;
$job = new Job($db);

// Get raw posted data

$data = json_decode(file_get_contents("php://input"));

$job->job_title = $data->job_title;
$job->content = $data->content;
$job->company_name = $data->company_name;
$job->salary = $data->salary;
$job->submitted_at = $data->submitted_at;

// Create job ad

if ($job->create()) {

    echo json_encode(json_encode(['message' => 'Ad created']));
    echo json_encode($job);
} else {
    echo json_encode(json_encode(['message' => 'Ad not created']));
}
