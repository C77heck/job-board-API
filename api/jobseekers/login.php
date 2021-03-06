<?php

require '../../includes/init.php';
$conn = require '../../includes/db.php';


$data = json_decode(file_get_contents("php://input"));

try {
    echo JobSeeker::authenticate($conn, $data->username, $data->password);
} catch (Exception $e) {
    $message = $e->getMessage();
    echo json_encode([
        "message" => "$message",
        "statusCode" => 500
    ]);
}
