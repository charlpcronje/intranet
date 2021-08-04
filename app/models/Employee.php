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

    public function count() {
        return count($this->items);
    }
}