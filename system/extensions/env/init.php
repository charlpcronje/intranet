<?php
require_once __DIR__.DS.'exception'.DS.'ExceptionInterface.php';
require_once __DIR__.DS.'exception'.DS.'InvalidPathException.php';
require_once __DIR__.DS.'exception'.DS.'InvalidFileException.php';
require_once __DIR__.DS.'exception'.DS.'ValidationException.php';
require_once __DIR__.DS.'exception'.DS.'InvalidCallbackException.php';
require_once __DIR__.DS.'Loader.php';
require_once __DIR__.DS.'DotEnv.php';

use system\extensions\env\DotEnv;
(new DotEnv(realpath('./')))->load();

function env($key = null,$value = null,$default = null) {
    if (isset($value)) {
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }

    if (!isset($key) && !isset($default)) {
        return array_merge($_SERVER,$_ENV);
    }
    if (isset($_ENV[$key])) {
        return $_ENV[$key];
    }
    if (isset($_SERVER[$key])) {
        return $_SERVER[$key];
    }
    if (isset($default)) {
        return $default;
    }
}