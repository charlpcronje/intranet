<?php
namespace system\base;

use IteratorAggregate;
use system\extensions\DB;

class Model implements IteratorAggregate {
    protected $items = [];

    protected $db;
    public $name = null;
    public $table = null;
    public $key = 'id';
    public $validate = [];
    public $orderBy = null;

    public function __construct($id = null,$fetchAll = false){
        $this->db = new DB('default');
        if (isset($id) && isset($this->table)) {
            $this->id = $id;
            $this->fetchRecord();
        }
        if ($fetchAll) {
            $this->fetchAllRecords();
        }
    }

    public function __set($name, $value) {
        $this->items[$name] = $value;
    }

    public function __get($name) {
        if (array_key_exists($name, $this->items)) {
            return $this->items[$name];
        }
        return null;
    }

    public function fetchRecord() {
        $this->db->query("SELECT * FROM ? WHERE ? = ?",[$this->table,$this->key,$this->id]);
        $this->fetch();
    }

    public function fetchAllRecords() {
        if (isset($this->orderBy)) {
            $query = 'SELECT * FROM '.$this->table.' ORDER BY '.$this->orderBy.' ASC';
            $this->db->query($query);
        }
        $this->db->query('SELECT * FROM '.$this->table);
        $this->fetchAll();
    }

    public function fetch() {
        $this->items = [];
        array_push($this->items,$this->db->fetchObject());
    }

    public function fetchAll() {
        $this->items = [];
        $this->items = $this->db->fetchAll();
    }

    public function append($data = []) {
        array_push($this->items,$data);
    }

    public function getIterator() {
        yield from $this->items;
    }

    // public function getIterator(){
    //     return (function () {
    //         while(list($key, $val) = \each($this->items)) {
    //             yield $key => $val;
    //         }
    //     })();
    // }
}