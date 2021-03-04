<?php

require '../../includes/init.php';
$conn = require '../../includes/db.php';

// Additional headers
header('Access-Control-Allow-Methods: PUT');

$user = new Employer($conn);

$data = json_decode(file_get_contents("php://input"));

// assign the id to the class
$user->id = $data->id;

if ($user->update($data)) {
    print_r('User data has been updated');
} else {
    print_r('User data updated unsuccessful');
}
