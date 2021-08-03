<?php
namespace system\base;

class Session {
    public static $instance;
    public static $dotData;
    
    function __construct(){
        $this->dotData = new DotData();
        if (!isset($this->data)) {
            $this->data = new \stdClass();
        }
    }

    public static function getInstance() {

    }

    public function keyExist($key) {
        return $this->dotData->keyExist($key,$this->dotData->dataSet->session);
    }

    public function session($dotName,$value = null,$default = null) {
        if (isset($value)) {
            return $this->dotData->setData($dotName,$value,$this->dotData->dataSet->session);
        }

        if ($this->keyExist($dotName)) {
            return $this->dotData->getData([
                'key'     => $dotName,
                'default' => $default ?? null,
                'dataSet' => $this->dotData->dataSet->session
            ]);
        }
        return $default;
    }
}