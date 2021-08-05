<?php 
use system\base\Model;

class Employee extends Model {
    
    function __construct($id = null) {
        $this->table = 'employee';
        $this->sqlStmts = 'employee.sql';
        $this->orderBy = 'start_date';
        $this->validate = [
            'first_name' => ['required'],
            'email' => ['required','email']
        ];
        parent::__construct($id);
    }

    public static function save($data,$model = null) {
        if (!isset($data['active']) || empty($data['active'])) {
            $data['active'] = '0';
        } 
        EmployeeGroup::save($data['employee_groups'] ?? []);
        unset($data['employee_groups']);
        parent::save($data);
    }

    public function count() {
        return count($this->items);
    }
}

