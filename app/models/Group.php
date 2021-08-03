<?php 
use system\base\Model;
use system\extensions\DB;

class Group extends Model {
    function __construct($id = null) {
        $this->table = 'groups';
        if (isset($id)) {
            parent::__construct($id);
        } else {
            parent::__construct($id,true);
        }
    }
}