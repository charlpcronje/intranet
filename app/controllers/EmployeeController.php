<?php
use system\base\Controller;
use system\base\Model;

class EmployeeController extends Controller {
    public function view() {
        $this->render('employees');
    }

    public function edit($id) {
        $grps = Group::all();
        $emps = Employee::all();
        $emps = transpose($emps,'id','groups','group_id',['group_name','group_id']);
        $this->data->setData('employees',Employee::all());
        $this->data->setData('employee_count',count($emps));
        $this->data->setData('employee',$emps[$id]);
        $this->data->setData('groups',$grps);

        $this->render('editEmployee');
    }

    public function update() {

    }
}