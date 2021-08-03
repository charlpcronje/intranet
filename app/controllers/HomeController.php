<?php
use system\base\Controller;

class HomeController extends Controller {
    function __construct() {
        

        parent::__construct();  
        $this->render('dashboard');   
    }
}