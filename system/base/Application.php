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
        $action = explode('/',$_GET['action'],1)[0];
        if(isset($_GET['action'])) {
            return str_replace('/','',$action);
        }
        return $default;
    }

    public function getParams($default = null) {
        $params = explode('/',$_GET['action'],1)[1];
        print_r(params);
        return $default;
    }

    

    public function handleRequest() {
        $controllerName = $this->getController();
        $actionName = $this->getAction();
        $params = $this->getParams();
        pd($actionName);
        $ucController = ucfirst($controllerName);
        $controllerNameAll = $this->appNamespace . '\\' . $ucController . 'Controller';
        $controller = new $controllerNameAll();
        $controller->id = $controllerName;
        $controller->action = $actionName;
        return call_user_func([$controller, $actionName],$params);
    }
}