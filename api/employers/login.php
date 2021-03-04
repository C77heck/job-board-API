<?php

require '../../includes/init.php';
$conn = require '../../includes/db.php';

// Additional headers
header('Access-Control-Allow-Methods: POST');


$data = json_decode(file_get_contents("php://input"));

if (Employer::authenticate($conn, $data->username, $data->password)) {

    echo json_encode(['message' => 'successfully logged in']);
} else {
    print_r("Could not log you in");
}
/* we need to return an error or exception */