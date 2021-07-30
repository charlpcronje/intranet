<?php 
use system\base\Model;
use system\extensions\DB;

class Employee extends Model {

    function __construct($id = null) {
        $this->table = 'employee';
       //$this->orderBy = 'start_date';
        parent::__construct($id,true);
    }
}