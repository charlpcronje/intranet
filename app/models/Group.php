<?php 
use system\base\Model;

class Group extends Model {
    function __construct($id = null) {
        $this->table = 'groups';
        $this->sqlStmts = 'group.sql';
        $this->validate = [
            'group_name' => ['required']
        ];
        parent::__construct($id);
    }
}