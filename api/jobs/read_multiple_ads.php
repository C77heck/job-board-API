<?php

require '../../includes/init.php';

$db = require '../../includes/db.php';
//Instantiate job ad object;
$job = new Job($db);
// Job ad query
$result = $job->getAds();
// Check if there's any ads in the database
$num = $result->rowCount();

if ($num > 0) {
    $ad_array = [];
    $job_arr['ads'] = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $job_item = [
            'id' => $id,
            'job_title' => $job_title,
            'location' => $location,
            'content' => $content,
            'company_name' => $company_name,
            'salary' => $salary,
            'submitted_at' => $submitted_at
        ];
        //Push to 'data'
        array_push($job_arr['ads'], $job_item);
    }
    // turn it into json
    echo json_encode($job_arr);
} else {
    // no jobs
    echo json_encode(['message' => 'No jobs found']);
}
