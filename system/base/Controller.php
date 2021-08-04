<?php
namespace system\base;

use \system\base\DotData;
class Controller {
    public $id; 
    public $action;
    public $data;

    public function __construct() {
        $this->data = new DotData();
    }

     /**
     * Convert a array to json string
     * @param string $data
     */
    public function toJson($data = null) {
        if (is_string($data)) {
            return $data;
        }
        return json_encode($data);
    }

    public function render($view,$data = null) {
        //$this->data->setData('groups',$groups->items);
        return View::render($view,(array)$this->data->all());
    }
}