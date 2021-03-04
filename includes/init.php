<?php

/**
 * Initializations
 *
 * Register an autoloader, start or resume the session etc.
 */

//HEADERS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization X-Requested-With');
/*  content type restriction, CORS policy, XSS, ... etc*/

// dynamically require files
spl_autoload_register(function ($class) {
    require dirname(__DIR__) . "/classes/{$class}.php";
});

//cookies autopilot
session_start();

// config file with enviromental variables(constants)
require dirname(__DIR__) . '/config/config.php';

// turn errors into exceptions
function errorHandler($level, $message, $file, $line)
{
    throw new ErrorException($message, 0, $level, $file, $line);
}

// exception handler
function exceptionHandler($exception)
{
    http_response_code(500);

    if (SHOW_ERROR_DETAIL) { // dev mode

        echo "<h1>An error occurred</h1>";
        echo "<p>Uncaught exception: '" . get_class($exception) . "'</p>";
        echo "<p>" . $exception->getMessage() . "'</p>";
        echo "<p>Stack trace: <pre>" . $exception->getTraceAsString() . "</pre></p>";
        echo "<p>In file '" . $exception->getFile() . "' on line " . $exception->getLine() . "</p>";
    } else { // production mode
        echo "<h1>An error occurred</h1>";
        echo "<p>Please try again later.</p>";
    }
    exit();
}

//assign handlers
set_error_handler('errorHandler');
set_exception_handler('exceptionHandler');
