<?php
use core\Heepp;

function dd($var) {
    $callingClass = getCallingClass();
    if (empty($callingClass)) {
        $callingClass = 'Global Scope';
    }
    echo 'Dumping and Die Called From: <strong>'.$callingClass."</strong> \r\n\r\n <br/><br/>";
    var_dump($var);
    die;
}

function ddc($var) {
    echo 'Dumping and Continue Called From: <strong>'.getCallingClass()."</strong> \r\n\r\n <br/><br/>";
    var_dump($var);
    echo '</pre>';
}

function pd($var) {
    $callingClass = getCallingClass();

    if (empty($callingClass)) {
        $trace = debug_backtrace();
        $callingClass = 'File: "'.$trace[0]['file'].'" | Line: "'.$trace[0]['line'].'""';
    }

    echo 'Print and Die Called From: <strong>'.$callingClass."</strong> \r\n\r\n <br/><br/> <pre>";
    print_r($var);
    echo '</pre>';
    die;
}

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

function fileIncludeOrigin(){
    $traceArray = debug_backtrace();
    return array_pop($traceArray)['file'];
}

function pdc($var) {
    $callingClass = getCallingClass();

    if (empty($callingClass)) {
        $trace = debug_backtrace();
        $callingClass = 'File: "'.$trace[0]['file'].'" | Line: "'.$trace[0]['line'].'""';
    }

    echo 'Print, Dump and Continue Called From: '.$callingClass." \r\n\r\n ";
    print_r($var);
}

function isClosure($var) {
    return is_object($var) && ($var instanceof Closure);
}

function getMethodParams($class,$method) {
    $ReflectionMethod =  new \ReflectionMethod($class, $method);
    $params = $ReflectionMethod->getParameters();
    $paramNames = array_map(function( $item ){
        return $item->getName();
    }, $params);
    return $paramNames;
}

function getFunctionParams($function) {
    $reflectionFunction =  new \ReflectionFunction($function);
    $params = $reflectionFunction->getParameters();
    $paramNames = array_map(function( $item ){
        return $item->getName();
    }, $params);
    return $paramNames;
}

function classProperties(&$object) {
    $className = get_class($object);
    $ref = new \ReflectionClass($className);
    $ownProps = array_filter($ref->getProperties(), function($property) use ($className) {
        return $property->class == $className; 
    });
    $returnProps = new stdClass();
    foreach($ownProps as $prop) {
        
        $returnProps->{$prop->name} = $object->{$prop->name};
    }
    return $returnProps;
}

function base64EncodeImage($filename = string,$filetype = string) {
    if ($filename) {
        $imgbinary = fread(fopen($filename, "r"), filesize($filename));
        return 'data:image/' . $filetype . ';base64,' . base64_encode($imgbinary);
    }
}

function getCallingClass() {
    //get the trace
    $trace = debug_backtrace();

    // Get the class that is asking for who awoke it
    if (isset($trace[1]['class'])) {
        $class = $trace[1]['class'];
    } else {
        $class = $trace[1]['class'] = 'Static';
    }

    // +1 to i cos we have to account for calling this function
    for ($i=1,$iMax = count($trace); $i< $iMax; $i++ ) {
        if (isset($trace[$i])) { // is it set?
             if ($class != @$trace[$i]['class']) {// is it a different class
                 return @$trace[$i]['class'];
             }
        }
    }
}

// Find Class Ancestors (Parents and Parents of Parents)
function getAncestors($class) {
  for ($classes[] = $class; $class = get_parent_class ($class); $classes[] = $class);
  return $classes;
}

function dotNotation($string) {
    return str_replace(['-','\\','/'],'.',$string);
}

/**
 * Check if $object is valid $class instance
 *
 * @access public
 * @param mixed $object Variable that need to be checked against className
 * @param string $class ClassName
 * @return null
 */
function isInstanceOf($object, $class) {
    return $object instanceof $class;
}

/**
 * This function will return clean variable info
 *
 * @param mixed $var
 * @param string $indent Indent is used when dumping arrays recursivly
 * @param string $indent_close_bracet Indent close bracket param is used
 *   internaly for array output. It is shorter that var indent for 2 spaces
 * @return null
 */
function cleanVarInfo($var, $indent = '&nbsp;&nbsp;', $indent_close_bracet = '') {
    if (is_object($var)) {
        return 'Object (class: '.get_class($var).')';
    } elseif (is_resource($var)) {
        return 'Resource (type: '.get_resource_type($var).')';
    } elseif (is_array($var)) {
        $result = 'Array (';
        if (count($var)) {
            foreach ($var as $k => $v) {
                $k_for_display = is_integer($k) ? $k : "'" . clean($k) . "'";
                $result .= "\n".$indent.'['.$k_for_display.'] => ' .clean_var_info($v,$indent.'&nbsp;&nbsp;',$indent_close_bracet.$indent);
            }
        }
        return $result."\n$indent_close_bracet)";
    } elseif (is_int($var)) {
        return '(int)'.$var;
    } elseif (is_float($var)) {
        return '(float)'.$var;
    } elseif (is_bool($var)) {
        return $var ? 'true' : 'false';
    } elseif (is_null($var)) {
        return 'NULL';
    } else {
        return "(string) '".clean($var)."'";
    }
}

/**
 * Equivalent to htmlspecialchars(), but allows &#[0-9]+ (for unicode)
 * This function was taken from punBB codebase <http://www.punbb.org/>
 *
 * @param string $str
 * @return string
 */
function clean($str) {
    $str = preg_replace('/&(?!#[0-9]+;)/s','&amp;',$str);
    $str = str_replace(array('<', '>', '"'),array('&lt;','&gt;','&quot;'),$str);

    return $str;
}

/**
 * This function will return true if $str is valid function name (made out of alpha numeric characters + underscore)
 *
 * @param string $str
 * @return boolean
 */
function isValidFunctionName($str) {
    $check_str = trim($str);
    if ($check_str == '') {
        return false; // empty string
    }

    $first_char = substr_utf($check_str,0,1);
    if (is_numeric($first_char)) {
        return false; // first char can't be number
    }

    return (boolean) preg_match("/^([a-zA-Z0-9_]*)$/",$check_str);
}


/**
 * This function will walk recursivly thorugh array and strip slashes from scalar values
 *
 * @param array $array
 * @return null
 */
function arrayStripslashes(&$array) {
    if (!is_array($array)) {
        return;
    }
    foreach ($array as $k => $v) {
        if (is_array($array[$k])) {
            arrayStripslashes($array[$k]);
        } else {
            $array[$k] = stripslashes($array[$k]);
        }
    }
    return $array;
}

/**
 * Generates a random id to be used as id of HTML elements.
 * It does not guarantee the uniqueness of the id, but the probability
 * of generating a duplicate id is very small.
 *
 */
function genId() {
    static $ids = array();
    do {
        $time = time();
        $rand = rand(0, 1000000);
        $id = "og_" . $time . "_" . $rand;
    } while (arrayVar($ids, $id, false));
    $ids[$id] = true;
    return $id;
}

function zipSupported() {
    return class_exists('ZipArchive',false);
}
