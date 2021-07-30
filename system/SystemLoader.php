<?php
namespace system;

class SystemLoader {
    public static $includedFiles   = [];
    public static $coreLastLogId;
    public static $sessionExists   = false;
    public static $callingClass;
    public static $locationsToLook = [
        'system'        => 'includeSystem',
        'appController' => 'includeController',
        'appModel'      => 'includeModel',
        'appView'       => 'includeView',
        'base'          => 'includeBase',
        'helper'        => 'includeHelper',
        'handler'       => 'includeHandler'
    ];


    private static function includeSystem($include) {
        $include = str_replace('\\',DS,$include);
        $fileName = $include.'.php';
        if (file_exists(env('system.path').$fileName)) {
            include env('system.path').$fileName;
            return true;
        }
        return false;
    }

    private static function includeModel($include) {
        $fileName = $include.'.php';
        if (file_exists(env('app.models.path').$fileName)) {
            include env('app.models.path').$fileName;
            return true;
        }
        return false;
    }

    private static function includeView($include) {
        $fileName = $include.'.php';
        if (file_exists(env('app.views.path').$fileName)) {
            include env('app.views.path').$fileName;
            return true;
        }
        return false;
    }

    private static function includeSystemView($include) {
        $fileName = $include.'.php';
        if (file_exists(env('system.views.path').$fileName)) {
            include env('system.views.path').$fileName;
            return true;
        }
        return false;
    }

    private static function includeController($include) {
        $fileName = $include.'.php';
        if (file_exists(env('app.controllers.path').$fileName)) {
            include env('app.controllers.path').$fileName;
            return true;
        }
        return false;
    }

    private static function includeBase($include) {
        $fileName = $include.'.php';
        if (file_exists(env('system.base.path').$fileName)) {
            include env('system.base.path').$fileName;
            return true;
        }
        return false;
    }

    private static function includeHelper($include) {
        $fileName = $include.'.php';
        if (file_exists(env('system.helpers.path').$fileName)) {
            include env('system.helpers.path').$fileName;
            return true;
        }
        return false;
    }

    private static function includeHandler($include) {
        $fileName = $include.'.php';
        if (file_exists(env('system.handler.path').$fileName)) {
            include env('system.handler.path').$fileName;
            return true;
        }
        return false;
    }

    
    
    public static function AutoLoader($include) {
        $include = str_replace('\\',DS,$include);
        // Check if file is already included
        if (!in_array($include,self::$includedFiles)) {
            self::$includedFiles[] = $include;
            // Include class or trait
            foreach(self::$locationsToLook as $location => $method) {
                if (self::$method($include)) {
                    return true;
                }
            }
            return false;
        }
    }
}

/* Define Auto Loader */
spl_autoload_register([SystemLoader::class,'AutoLoader']);