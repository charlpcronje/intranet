<?php
function input($inputKey = null,$default = null) {

    $value = null;
    // There is a $_GET and a POST with the same key the $_POST key will take precedence
    if (isset($_GET[$inputKey])) {
        $value = $_GET[$inputKey];
    }

    if (isset($_POST[$inputKey])) {
        $value = $_POST[$inputKey];
    }

    if (!isset($_GET[$inputKey]) && isset($default)) {
        $value = $default;
    }
    
    if (!isset($_POST[$inputKey]) && isset($default)) {
        $value = $default;
    }
    
    if (!isset($_POST[$inputKey]) && !isset($_GET[$inputKey]) && isset($default)) {
        $value = $default;
    }

    if (!isset($_POST[$inputKey]) && !isset($_GET[$inputKey]) && !isset($default)) {
        unset($_GET['controller']);
        unset($_GET['action']);
        unset($_GET['params']);
        if (isset($_GET) && !empty($_GET)) {
            $value = $_GET;
        }
        
        if(isset($_POST) && !empty($_POST)) {
            $value = $_POST;
        }
    }
    return $value;
}