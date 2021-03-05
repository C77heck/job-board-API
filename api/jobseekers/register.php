<?php

require '../../includes/init.php';
$conn = require '../../includes/db.php';

// Additional headers
header('Access-Control-Allow-Methods: POST');

$user = new JobSeeker($conn);

$data = json_decode(file_get_contents("php://input"));


if ($user->register($data)) {

    echo   json_encode(["message" => "Succesful registration"]);
} else {
    echo  json_encode(["message" => "Unsuccesful registration"]);
}
