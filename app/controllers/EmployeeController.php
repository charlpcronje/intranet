<?php
use system\base\Controller;
use system\base\Model;

class EmployeeController extends Controller {
    function __construct() {
        
    }

    public function view() {
        $employees = new Employee(null,true);
        $this->render('employees.html',[
           'people' => $employees
        ]);
    }
}