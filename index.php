<?php
require 'includes/init.php';


// Instantiate DB & connect
$database = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$db = $database->connect();

//Instantiate job ad object;
$job = new Job($db);

// Job ad query
$result = $job->getAdById();
// Check if there's any ads in the database
$num = $result->rowCount();

if ($num > 0) {
    $ad_array = [];
    $job_arr['data'] = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $job_item = [
            'id' => $id,
            'job_title' => $job_title,
            'content' => $content,
            'company_name' => $company_name,
            'salary' => $salary,
            'submitted_at' => $submitted_at
        ];
        //Push to 'data'
        array_push($job_arr['data'], $job_item);
    }
    // turn it into json
    echo json_encode($job_arr);
    var_dump($job_arr);
} else {
    // no jobs
    echo json_encode(['message' => 'No jobs found']);
    //might bug out due to the syntax
}

?>

<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">

    <title>The HTML5 Herald</title>
    <meta name="description" content="The HTML5 Herald">
    <meta name="author" content="SitePoint">


</head>
<h2>whats up</h2>

<body>
    <script src="js/scripts.js"></script>
</body>

</html>