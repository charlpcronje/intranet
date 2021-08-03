<?php

function session($key,$value = null,$default = null) {
    setupSession();
    if (!isset($value)) {
        getSessionItem($key);
    }
        
    $_SESSION['base']->{$key} = $value;
    
}

function getSessionItem($key) {

}



function sessionObj($key,$value = null) {
    if (!isset($_SESSION['objects'])) {
        $_SESSION['objects'] = (object)[];
    }
    if (isset($value)) {
        $_SESSION['objects']->{$key} = $value;
    }
}

function setupSession() {
    if (!isset($_SESSION['base'])) {
        $_SESSION['base'] = (object)[];
    }
    if (!isset($_SESSION['base']->objects)) {
        $_SESSION['base']->objects = (object)[];
    }
    if (!isset($_SESSION['base']->arrays)) {
        $_SESSION['base']->arrays = [];
    }

}