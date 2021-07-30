<?php
namespace system\base;
use system\base\View;

class Controller {
    // @var Action the action that is currently being executed.
    public $action;
    protected $view;
     /**
     * Convert a array to json string
     * @param string $data
     */
    public function toJson($data) {
        if (is_string($data)) {
            return $data;
        }
        return json_encode($data);
    }

    public function render($view) {
        return View::render((string)$view);
    }
}