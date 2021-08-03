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
        $params = explode('/',get('params'),2);
        if (isset($params[1])) {
            $params = explode('/',$params[1]);
        }
       
        $controllerNameAll = ucfirst($controllerName) . 'Controller';
        if (class_exists($controllerNameAll)) {
            $controller = new $controllerNameAll();
            $controller->id = $controllerName;
            $controller->action = $method;
            if(method_exists($controller,$method)) {
                return call_user_func_array([$controller,$method],(array)$params);
            }
        }
    }
}