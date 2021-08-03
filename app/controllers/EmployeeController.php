<?php
use system\base\Controller;
use system\base\Model;

class EmployeeController extends Controller {

    public function view() {
        $this->render('employees');
    }

    public function edit($id) {
        $this->data->setData('employee',(new Employee($id))->items[0]);
        $this->render('editEmployee');
    }
}