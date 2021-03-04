<?php

require '../../includes/init.php';
$conn = require '../../includes/db.php';

// Additional headers
header('Access-Control-Allow-Methods: POST');

$user = new Employer($conn);

$data = json_decode(file_get_contents("php://input"));

if ($user->register($data)) {
    print_r('Registration successful');
} else {
    print_r('Registration unsuccessful');
}
