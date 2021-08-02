<?php
use system\base\Controller;
use system\base\Model;

class EmployeeController extends Controller {

    public function view() {
        $empoyees = new Employee(null,true);
        $this->data->setData('employees',$empoyees->items);
        $this->render('employees');
    }

    public function edit($id) {
        $emp = new Employee($id);
        pd($emp);
        $this->render('editEmployee',[
           'employee' => $emp
        ]);
    }
}