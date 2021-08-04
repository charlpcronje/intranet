<?php
use system\base\Controller;

class HomeController extends Controller {
    function __construct() {
        $grps = Group::all();
        $this->employees = Employee::all();
        $this->employees = transpose($this->employees,'id','groups','group_id',['group_name','group_id']);
        
        parent::__construct();  
        
        $this->data->setData('groups',$grps);
        $this->data->setData('employees',Employee::all());
        $this->data->setData('employee_count',count($this->employees)); 
        $this->render('dashboard');  
    }
}

