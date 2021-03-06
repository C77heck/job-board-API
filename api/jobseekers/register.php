<?php

require '../../includes/init.php';
$conn = require '../../includes/db.php';


$user = new JobSeeker($conn);

// we get the data from the body
$data = json_decode(file_get_contents("php://input"));

//we send to the front either the success message or the exception thrown

/* we throw an exception if the registration fails but it is not handlend as execption
on the frontend so there's extra logic there to turn it into one...
*/
try {
    echo $user->register($data);
} catch (Exception $e) {
    $message = $e->getMessage();
    echo json_encode([
        "message" => "$message",
        "statusCode" => 500
    ]);
}
