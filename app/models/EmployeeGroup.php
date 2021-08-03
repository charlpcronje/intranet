<?php 
use system\base\Model;
use system\extensions\DB;

class Employee extends Model {
    public $validate = [
        'employee_id' => ['required'],
        'group_id' => ['required']
    ];

    function __construct($id = null) {
        $this->table = 'employee';
        $this->orderBy = 'start_date';
        if (isset($id)) {
            parent::__construct($id);
        } else {
            parent::__construct($id,true);
        }
    }

    

    public function count() {
        return count($this->items);
    }
}