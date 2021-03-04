<?php

// Connection 

// Instantiate DB & connect
$database = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
return $database->connect();
