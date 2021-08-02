<?php
namespace system\base;

/**
 * Application is the base class for all application classes.
 */
class Application {
    private $appNamespace = '';

    /**
     * handleRequest function that gets the controller, action and params from query string
     *
     * @return mixed
     */
    public function handleRequest() {
        $controllerName = get('controller','home');
        $method = get('action','render');
        $params = get('params');
        
        $controllerNameAll = ucfirst($controllerName) . 'Controller';
        $controller = new $controllerNameAll();
        $controller->id = $controllerName;
        $controller->action = $method;
        return call_user_func([$controller,$method],(array)$params);
    }
}