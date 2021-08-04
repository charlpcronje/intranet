<?php
namespace system\base;

use IteratorAggregate;
use system\extensions\DB;
use system\extensions\DBh;
use \stdClass; 
class Model implements IteratorAggregate {
    protected $db = null; // MySQLi or PDO  
    public $dbClass = 'system\extensions\DBh';
    public $sqlStmts = null;
    public $sql = null;
    public $items = [];
    public $name = null;
    public $table = null;
    public $key = 'id';
    public $validate = [];
    public $orderBy = null;
    

    public function __construct(){
        // Get an instance of the DB Class
        if (!isset($this->db)) {
            $this->db = $this->dbClass::getInstance('default');
        }
        // Load the prepared statements
        if (isset($this->sqlStmts)) {
            $this->sql = loadSQL($this->sqlStmts);
        }
    }

    public static function all() {
        
        $model = new static();
        
        $model->items = $model
            ->db::prepare($model->sql->all)
            ->execute()
            ->all(\PDO::FETCH_OBJ);
        return $model->items;
    }

    public static function find($id) {
        $model = new static();
        $model->items = $model->db::prepare($model->sql->find)->bindParam('id', $id)->execute()->all(\PDO::FETCH_OBJ);
        return $model->items;
    }

    public function __set($name, $value) {
        $this->items[$name] = $value;
    }

    public function __get($name) {
        if (array_key_exists($name,current($this->items))) {
            return current($this->items)[$name];
        }
        if (property_exists(current($this->items), $name)) {
            return current($this->items)->$name;
        }
        return null;
    }

    public function save(Model $record) {
        $validated = validate($this->validate,input());
        if (!$validated['status']) {
            return $validated;
        }
        
        return true;
    }

    public function fetchRecord() {
        $sql = "SELECT * FROM ".DBh::escapeTable($this->table)." WHERE :key = :id";
        $this->items = DBh::prepare($sql)->bindParam('id', $this->id)->bindParam('key',$this->id)->execute()->one(\PDO::FETCH_OBJ);
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

    public function count() {
        return count($this->items);
    }

    // public function getIterator(){
    //     return (function () {
    //         while(list($key, $val) = each($this->items)) {
    //             yield $key => $val;
    //         }
    //     })();
    // }
}