<?php
use system\base\Controller;

class HomeController extends Controller {
    function __construct() {
        $this->render('index');   
    }
}