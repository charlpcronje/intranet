<?php
namespace system\base;

/**
 * Application is the base class for all application classes.
 */
class Application {
    private $appNamespace = '';
    
    public function getController($default = 'home') {
        if(isset($_GET['controller'])) {
            return $_GET['controller'];
        }
        return $default;
    }

    public function getAction($default = 'render') {
        if(isset($_GET['action'])) {
            return str_replace('/','',$_GET['action']);
        }
        return $default;
    }

    public function getParams($default = null) {
        if(isset($_GET['params'])) {
            return explode('/',$_GET['params']);
        }
        return $default;
    }

    

    public function handleRequest() {
        $controllerName = $this->getController();
        $actionName = $this->getAction();
        $params = $this->getParams();
        $ucController = ucfirst($controllerName);
        $controllerNameAll = $this->appNamespace . '\\' . $ucController . 'Controller';
        $controller = new $controllerNameAll();
        $controller->id = $controllerName;
        $controller->action = $actionName;
        return call_user_func([$controller, $actionName],$params);
    }
}