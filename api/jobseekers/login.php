<?php

require '../../includes/init.php';
$conn = require '../../includes/db.php';


$data = json_decode(file_get_contents("php://input"));

//print_r($data->username);
//$user = new JobSeeker($conn);
if (JobSeeker::authenticate($conn, $data->username, $data->password)) {
    JobSeeker::login();
    echo json_encode(['message' => 'successfully logged in']);
} else {
    echo json_encode(['message' => 'Could not log you in']);
}
/* we need to return an error or exception */