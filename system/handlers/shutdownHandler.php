<?php
use system\base\Data;

register_shutdown_function(function() {
    $_SESSION['dotData'] = (Data::getInstance())->data;
});