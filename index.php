<?php
define('DS',DIRECTORY_SEPARATOR); // The directory separator is different in Linux and Windows so its better to use `DS` 

// Set some environment variables to make including files easier
putenv("base.path=".__DIR__.DS);
putenv("domain=".parse_url('//'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], PHP_URL_HOST));

// Parse the .env file in the root containing the rest of the environment varuables
include 'system'.DS.'extensions'.DS.'env'.DS.'init.php';

// Set some constants
include 'system'.DS.'constants.php';

// Load the rest of the required files
include 'system'.DS.'bootstrap.php';

// Create Applicaiton Object and Handle the Incoming Request
$app = new system\base\Application();
$app->handleRequest();