<?php
use system\base\Controller;
use system\base\Model;

class EmployeeController extends Controller {
    public $employees = null;
    function __construct() {
        $grps = Group::all();
        $this->employees = Employee::all();
        $this->employees = transpose($this->employees,'id','groups','group_id',['group_name','group_id']);
        parent::__construct();
       
        $this->data->setData('groups',$grps);
        $this->data->setData('employees',$this->employees);
        $this->data->setData('employee_count',count($this->employees));
    }

    public function view() {
        $emps = Employee::all();
        $emps = transpose($emps,'id','groups','group_id',['group_name','group_id']);
        $this->data->setData('employees', $emps);
        $this->render('employees');
    }

    public function edit($id) {
        $this->data->setData('employee',$this->employees[$id]);
        $this->render('editEmployee');
    }

    public function update() {
        $this->render('employees');
    }
}