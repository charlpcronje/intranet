<?php
namespace system\extensions;

class DBh {
	public static $instance;
	static private $conn;
	static private $connName = 'default';
	private $savedResult;
	private mixed $savedPrepare = null;
	private $savedValues;
	private static $methods = [
        'execute' => 'execute'
    ];
	
	/**
	 * Undocumented function
	 *
	 * @param string $sql
	 * @param array $values
	 */
	protected function __construct($sql = null, $values = null) {
		if (func_num_args() == 1) { // query
			$this->savedResult = $this->querySetup($sql);
		} elseif(func_num_args() > 1) { // prepared statement
			$this->savedPrepare = self::prepareSetup($sql, $values);
		}
	}

	public static function getInstance($connName = 'default') {
		self:$connName = $connName;
        if (!isset(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }

	
	/**
	 * __callStatic function
	 *
	 * @param mixed $method
	 * @param mixed $parameters
	 * @return mixed
	 */
	public static function __callStatic($method,$parameters) {
		$db = new self;
		if (!array_key_exists($method, self::$methods)) {
            throw new \Exception('The ' . $method . ' is not supported.');
        }
		return call_user_func_array([$db,self::$methods[$method]], $parameters);
	}

	/**
	 * connected function
	 * @return object
	 */
	public static function connected() {
		return self::$conn;
	}
	
	/**
	 * connect function
	 * @return void
	 */
	static function connect() {
		if (!self::connected()) {
			try {
				self::$conn = new \PDO('mysql:host='.env('db.'.self::$connName.'.host').';dbname='.env('db.'.self::$connName.'.dbname').';charset='.env('db.'.self::$connName.'.charset'),env('db.'.self::$connName.'.username'),env('db.'.self::$connName.'.password'));
				self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			} catch (\PDOException $e) {
				die('Connection failed: ' .$e->getMessage());
			}
		}
		return self::$conn;
	}
	
	/**
	 * disconnect from database function
	 * @return void
	 */
	public static function disconnect() {
		self::$conn = null;
	}
	
	/**
	 * querySetup function
	 * @param string $sql
	 * @return obeject
	 */
	protected function querySetup($sql) {
		self::connect();
		try {
			return self::$conn->query($sql);
		} catch (\PDOException $e) {
			pp('Error: '.$e->getMessage());
			die();
		}
	}
	
    /**
     * query function
     * @param string $sql
     * @return DBh
     */
	public static function query($sql) {
		return new self($sql);
	}
	
    /**
     * one function
     * @param int $flags
     * @return array
     */
	function one($flags = \PDO::FETCH_ASSOC) {
		return $this->savedResult->fetch($flags);
	}
	
    /**
     * column function
     * @param integer $columNumber
     * @return string
     */
	function column($columNumber = 0) {
		return $this->savedResult->fetchColumn($columNumber);
	}
	
    /**
     * all function
     * @param int $flags
     * @return array
     */
	function all($flags = \PDO::FETCH_ASSOC) {
		return $this->savedResult->fetchAll($flags);
	}
	
    /**
     * get function
     * @param int $number_of_rows
     * @param int $flags
     * @return array
     */
	function get($number_of_rows = null, $flags = \PDO::FETCH_ASSOC) {
		$return = [];
		while (($row = $this->savedResult->fetch($flags)) && ($number_of_rows !== null ? $number_of_rows-- : true)) {
			$return[] = $row;
		}
		return $return;
	}

	/**
     * lastInsertId function
     * @return string|int
     */
	function lastInsertId() {
		return self::$conn->lastInsertId();
	}

    /**
     * Undocumented function
     *
     * @param array $array
     * @return array
     */
	public static function colonize($array) {
		$return = [];
		foreach ($array as $key => $value) {
			if ($key[0] != ':') {
				$return[':' . $key] = $value;
			} else {
				$return[$key] = $value;
			}
		}
		return $return;
	}

    /**
     * Undocumented function
     *
     * @param string $sql
     * @param array $values
     * @return void
     */
	protected function prepareSetup($sql, $values = []) {
		self::connect();
		$this->savedValues = self::colonize($values);
		try {
			$prepared = self::$conn->prepare($sql);
			if (!$prepared) {
				die("can't prepare statement");
			}
			return $prepared;
		} catch (\PDOException $e) {
			pp('Error: ' . $e->getMessage());
			die();
		}
	}
	
    /**
     * prepare function
     *
     * @param string $sql
     * @param array $values
     * @return object
     */
	static function prepare($sql, $values = []) {
		return new self($sql, $values);
	}
	
    /**
     * bindParam function
     *
     * @param string $key
     * @param string $value
     * @return void
     */
	function bindParam($key, $value) {
		if ($key[0] != ':') {
			$key = ':' . $key;
		}
		$this->savedValues[$key] = $value;
		return $this;
	}
	
    /**
     * bindParams function
     * @param string $values
     * @return DBh
     */
	function bindParams($values = null) {
		if ($values) {
			$values = self::colonize($values);
			$this->savedValues = $values + $this->savedValues;
		}
		return $this;
	}

	/**
	 * function execute($values = []) {
	 * @param array $values
	 * @return mixed|null|object|DBh
	 */
	function execute($values = []) {
		$valuesToUse = func_num_args() ? self::colonize($values) : $this->savedValues;
		
		if ($this->savedPrepare->execute($valuesToUse)) {
			$this->savedResult = $this->savedPrepare;
			return $this;
		}
	}

    /**
     * columnNames function
     * @param string $table
     * @return array
     */
	static function columnNames($table) {
		self::connect();
		try {
			$query = self::$conn->query('DESCRIBE `' . self::escapeTable($table) . '`');
			return $query->fetchAll(\PDO::FETCH_COLUMN);
		} catch (\PDOException $e) {
			pp('Error: ' . $e->getMessage());
			die();
		}
	}
	
    /**
     * getEnums function
     *
     * @param string $table
     * @param string $column
     * @return object
     */
	static function getEnums($table, $column) {
		return self::getEnumsOrSet($table, $column);
	}
	
    /**
     * getSet function
     *
     * @param string $table
     * @param string $column
     * @return object
     */
	static function getSet($table, $column) {
		return self::getEnumsOrSet($table, $column);
	}
	
    /**
     * getEnumsOrSet function
     * @param string $table
     * @param string $column
     * @return object
     */
	static function getEnumsOrSet($table, $column) {
		$result = self::query("SHOW COLUMNS FROM " . self::escapeTable($table) . " WHERE Field = '" . self::escapeColumn($column) . "'")->column(1);
		if (!$result) {	
			return false;
		}
		return self::parseList($result);
	}
	
    /**
     * parseList function
     * @param string $list
     * @return void
     */
	static function parseList($list) {
		$list = str_replace("''", "\n", $list); // replace escaped commas as something mysql never outputs
		$list = preg_replace("#^(enum\\('|set\\(')|'\\)$#", '', $list);
		$parts = explode("','", $list);

		$values = [];
		foreach ($parts as $i => $part) {
			$part = str_replace("\n", "'", $part); // convert newlines back to commas
			$part = preg_replace('#^\\\\r|([^\\\\])(\\\\\\\\)*(\\\\r)#', "$1$2\r", $part); // mysql return \r as \\r in SHOW COLUMNS
			$part = preg_replace('#^\\\\n|([^\\\\])(\\\\\\\\)*(\\\\n)#', "$1$2\n", $part); // mysql return \n as \\n in SHOW COLUMNS
			$part = preg_replace('#\\\\\\\\#', '\\', $part);
			$values[$i + 1] = $part; // internally enums and sets are stored 1 indexed or start by 1
		}
		return $values;
		
	}

    /**
     * escapeTable function
     *
     * @param string $table
     * @return string
     */
	static function escapeTable($table) {
		return preg_replace('/[^a-z0-9_$]/i', '', $table);
	}
	
    /**
     * escapeColumn function
     *
     * @param string $column
     * @return void
     */
	static function escapeColumn($column) {
		return self::escapeTable($column);
	}
}
