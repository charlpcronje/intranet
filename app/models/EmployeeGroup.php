<?php 
use system\base\Model;
class EmployeeGroup extends Model {
    
    function __construct($id = null) {
        $this->table = 'employee_groups';
        $this->sqlStmts = 'employeeGroup.sql';
        $this->validate = [
            'group_id' => ['required'],
            'employee_id' => ['required']
        ];
        if (isset($id)) {
            parent::find($id);
        }
        parent::__construct($id);
    }

    public static function save($data,$model = null) {
        $model = new static();
        parent::delete(['employee_id'=>input('id')],$model);
        if (count($data) > 0) {
            foreach($data as $value) {
                parent::insert(['group_id' => $value,'employee_id'=>input('id')]);
            } 
        } 
        
    }
}

