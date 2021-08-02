<?php
ini_set('display_errors',$_ENV['debug.error.display']);
ini_set('error_reporting',$_ENV['debug.error.reporting']);
ini_set('log_errors',$_ENV['debug.error.file.log']);
ini_set('error_log',$_ENV['debug.error.file.log.path'].'error.log');
error_reporting(constant($_ENV['debug.error.reporting.level']));

define('BASE_PATH',__DIR__.DS);
function getURL() {
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') { 
        $link = "http"; 
    } else { 
        $link = "https";
    }
    $link .= "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    return $link;
}
define('URL',getURL());
