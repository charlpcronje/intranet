<?php
namespace system\handlers;

use RuntimeException;

class LoadHandler {
    public static $includedFiles   = [];
    public static $sessionExists   = false;
    public static $callingClass;
    public static $locationsToLook = [
        'base'          => 'includeBase',
        'system'        => 'includeSystem',
        'systemBase'    => 'includeSystemBase',
        'appController' => 'includeController',
        'appModel'      => 'includeModel',
        'appView'       => 'includeView'
    ];
    public static $errorMessage = [];

    private static function includeSystem($include) {
        $path = env('system.path').str_replace('\\',DS,$include).'.php';
        if (file_exists($path)) {
            return include $path;
        }
        self::$errorMessage[] = "File: '".$path."' not found";
        return false;
    }

    private static function includeModel($include) {
        $path = str_replace('\\\\',DS,str_replace('\\',DS,env('app.models.path')).str_replace('\\',DS,$include).'.php');
        
        
        if (file_exists($path)) {
            return include $path;
        }
        self::$errorMessage[] = "File: '".$path."' not found";
        return false;
    }

    private static function includeView($include) {
        $path = env('app.views.path').str_replace('\\',DS,$include).'.php';
        if (file_exists($path)) {
            return include $path;
        }
        self::$errorMessage[] = "File: '".$path."' not found";
        return false;
    }

    private static function includeSystemView($include) {
        $path = env('system.views.path').str_replace('\\',DS,$include).'.php';
        if (file_exists($path)) {
            return include $path;
        }
        self::$errorMessage[] = "File: '".$path."' not found";
        return false;
    }

    private static function includeController($include) {
        $path = env('app.controllers.path').str_replace('\\',DS,$include).'.php';
        if (file_exists($path)) {
            return include $path;
        }
        self::$errorMessage[] = "File: '".$path."' not found";
        return false;
    }

    private static function includeSystemBase($include) {
        $path = env('system.base.path').str_replace('\\',DS,$include).'.php';
        if (file_exists($path)) {
            return include $path;
        }
        self::$errorMessage[] = "File: '".$path."' not found";
        return false;
    }

    private static function includeBase($include) {
        $path = env('base.path').str_replace('\\',DS,$include).'.php';
        if (file_exists($path)) {
            return include $path;
        }
        self::$errorMessage[] = "File: '".$path."' not found";
        return false;
    }

    /**
     * Autoload function
     *
     * @param string $include
     * @return bool|null
     */
    public static function autoLoad($include) {
        if (strpos($include,'Group')){
           // pd($include);
        }
        self::$callingClass = getCallingClass();
        self::$sessionExists = isset($_SESSION);
        self::$errorMessage = [];
        // Check if file is already included
        if (!in_array($include,self::$includedFiles)) {
            // Include class or trait 1st using the namespace as the path


            foreach(self::$locationsToLook as $location => $method) {
                if (self::$method($include)) {
                    self::$includedFiles[] = $include;
                    return true;
                }
            }

            /**
             * Cool feature of php7 is IIFE (Imediately Invoked function extression)
             * This had been in JS for a long time
             * Now I can use a closure where a string is exprected and return the string from within
             * the IIFE 
             * (function($arguments) {
             *      func content
             * })($args);
             * Where $arguments with get it's value from $args
             */
            new RuntimeException((function($include,$errorMessage) {
                $message = "Runtime Error: Class: '".$include."' not found!\r\n";
                foreach($errorMessage as $error) {
                    $message.= $error."\r\n";
                }
                return $message;
            })($include,self::$errorMessage));
        }
    }
}
spl_autoload_register([LoadHandler::class,'autoLoad']);