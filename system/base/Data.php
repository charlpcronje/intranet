<?php
namespace system\base;

class Data {
    
    public static $instance;
    public $data;

    public function __construct() {
        if (!isset($this->data)) {
            $this->data = new \stdClass();
        }
    }

    public static function getInstance() {
        if (!isset(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }
}