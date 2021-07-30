<?php
use system\base\Application;

putenv("base.path=".__DIR__.DIRECTORY_SEPARATOR);
include 'system'.DIRECTORY_SEPARATOR.'constants.php';
putenv("domain=".parse_url(URL, PHP_URL_HOST));

include 'system'.DS.'extensions'.DS.'env'.DS.'init.php';
include 'system'.DS.'bootstrap.php';

$app = new system\base\Application();
$app->handleRequest();