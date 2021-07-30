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
