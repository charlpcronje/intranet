<?php
use system\base\Controller;
use system\base\Model;

class EmployeeController extends Controller {
    function __construct() {
        
    }

    public function view() {
        $this->render('employees.html',[
           'employees' => new Employee(null,true)
        ]);
    }

    public function edit($id) {
        $this->render('editEmployee.html',[
           'employee' => new Employee($id)
        ]);
    }
}