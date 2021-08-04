<?php 
use system\base\Model;

class EmployeeGroup extends Model {
    
    function __construct($id = null) {
        $this->table = 'employee_groups';
        $this->sqlStmts = 'employeeGroups.sql';
        $this->validate = [
            'group_id' => ['required'],
            'employee_id' => ['required']
        ];
        if (isset($id)) {
            parent::find($id);
        }
    }
}