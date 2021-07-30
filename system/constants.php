<?php
ini_set('error_reporting',1);
error_reporting(E_ALL);

define('DS',DIRECTORY_SEPARATOR);
define('BASE_PATH',__DIR__.DS);

function getURL() {
    // Program to display URL of current page.
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $link = "https";
    } else {
        $link = "http";
    }

    // Here append the common URL characters.
    $link .= "://";

    // Append the host(domain name, ip) to the URL.
    $link .= $_SERVER['HTTP_HOST'];

    // Append the requested resource location to the URL
    $link .= $_SERVER['REQUEST_URI'];
    
    // Print the link
    return $link;
}
define('URL',getURL());

