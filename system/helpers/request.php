<?php
/**
 * Return current base url
 *
 * @return void
 */
function url(){
    return sprintf(
      "%s://%s%s",
      isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
      $_SERVER['SERVER_NAME'],
      $_SERVER['REQUEST_URI']
    );
}

/**
 * get function
 *
 * @param mixed $getKey
 * @param mixed $default
 * @return mixed
 */
function get($getKey = null,$default = null) {
    if (isset($_GET[$getKey])) {
        return $_GET[$getKey];
    }
    if (isset($default)) {
        return $default;
    }
    if (!isset($getKey) && !isset($default)) {
        return $_GET;
    }
    return null;
}

/**
 * post function
 *
 * @param mixed $postKey
 * @param mixed $default
 * @return mixed
 */
function post($postKey = null,$default = null) {
    if (isset($_GET[$postKey])) {
        return $_GET[$postKey];
    }
    if (isset($default)) {
        return $default;
    }
    if (!isset($postKey) && !isset($default)) {
        return $_POST;
    }
    return null;
}

/**
 * input function, simular to PHP $_REQUEST but with a default value
 *
 * @param mixed $inputKey
 * @param mixed $default
 * @return mixed
 */
function input($inputKey = null,$default = null) {
    // There is a $_GET and a POST with the same key the $_POST key will take precedence
    if (isset($_POST[$inputKey])) {
        return $_POST[$inputKey];
    }
    if (isset($_GET[$inputKey])) {
        return $_GET[$inputKey];
    }
    if (isset($default)) {
        return $default;
    }

    /**
     * Return array of all GET and POST variables with post taking presidence
     * and unsetting controller, action and params
     */
    if (!isset($inputKey) && !isset($default)) {
        $values = [];
        if (isset($_GET) && !empty($_GET)) {
            array_push($values = $_GET);
        } elseif (isset($_POST) && !empty($_POST)) {
            array_push($values = $_POST);
        }
        unset($values['controller'],$values['action'],$values['params']);
        return $values;
    }
    return null;
}