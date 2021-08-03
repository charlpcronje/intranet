<?php
namespace system\base;

use Group;
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

    public function render($view) {
        $empoyees = new \Employee(null,true);
        $this->data->setData('employees',$empoyees->items);
        $this->data->setData('employee_count',count($empoyees->items));

        $groups = new Group(null,true);
        $this->data->setData('groups',$groups->items);
        $this->data->setData('group_count',$empoyees->count());

        return View::render($view,(array)$this->data->all());
    }
}