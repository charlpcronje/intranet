<?php
namespace system\extensions;

class DB {
    protected $connection;
	protected $query;
    protected $show_errors = true;
    protected $query_closed = true;
	public $query_count = 0;

    /**
     * DB Construct function
     * The connections are specified in the .env file 
     * 
     * @param string $conn
     */
	public function __construct($conn = 'default') {
        // uses the credentials saved in the .env file
		$this->connection = new \mysqli(env('db.'.$conn.'.host'),env('db.'.$conn.'.username'),env('db.'.$conn.'.password'),env('db.'.$conn.'.dbname'));
		if ($this->connection->connect_error) {
			$this->error('Failed to connect to MySQL - ' . $this->connection->connect_error);
		}
		$this->connection->set_charset(env('db.'.$conn.'.charset'));
	}

    /**
     * query function
     * 
     * $user = $db->query('SELECT * FROM users WHERE username = ? AND password = ?',['test', 'test'])->fetchArray();
     * OR
     * $user = $db->query('SELECT * FROM users WHERE username = ? AND password = ?', 'test', 'test')->fetchArray();
     * @param any $query
     * @return DB
     */
    public function query($query) {
        if (!$this->query_closed) {
            $this->query->close();
        }
        // Prepares a sql statement, 1st stop to avoid sql injection
		if ($this->query = $this->connection->prepare($query)) {
            if (func_num_args() > 1) {
                // Get all the arguments received by the query
                $x = func_get_args();
                $args = array_slice($x, 1); // Store in all but the first argument in $args variable, the first argument is the query itself
				$types = '';
                $args_ref = [];
                /*
                 * Get the types of each argument of the prepared statement
                 * this is needed for the bind_param function called later
                 */
                foreach ($args as $k => &$arg) {
					if (is_array($args[$k])) {
						foreach ($args[$k] as $j => &$a) {
							$types .= $this->gettype($args[$k][$j]);
							$args_ref[] = &$a;
						}
					} else {
	                	$types .= $this->gettype($args[$k]);
	                    $args_ref[] = &$arg;
					}
                }
				array_unshift($args_ref, $types);
                call_user_func_array(array($this->query, 'bind_param'), $args_ref);
            }
            $this->query->execute();
           	if ($this->query->errno) {
				$this->error('Unable to process MySQL query (check your params) - ' . $this->query->error);
           	}
            $this->query_closed = false;
			$this->query_count++;
        } else {
            $this->error('Unable to prepare MySQL statement (check your syntax) - ' . $this->connection->error);
        }
		return $this;
    }


    /**
     * fetchAll function
     *
     * @param function $callback
     * @return array
     */
	public function fetchAll($callback = null) {
	    $params = [];
        $row = [];
	    $meta = $this->query->result_metadata();
	    while ($field = $meta->fetch_field()) {
	        $params[] = &$row[$field->name];
	    }
	    call_user_func_array([$this->query, 'bind_result'], $params);
        $result = [];
        while ($this->query->fetch()) {
            $r = [];
            foreach ($row as $key => $val) {
                $r[$key] = $val;
            }
            if ($callback != null && is_callable($callback)) {
                $value = call_user_func($callback, $r);
                if ($value == 'break') break;
            } else {
                $result[] = $r;
            }
        }
        $this->query->close();
        $this->query_closed = true;
		return $result;
	}

    /**
     * fetchAllObj function
     *
     * @param function $callback
     * @return array 
     */
    public function fetchAllObj($callback = null) {
        $params = [];
        $row = [];
        $meta = $this->query->result_metadata();
        while ($field = $meta->fetch_field()) {
            $params[] = &$row[$field->name];
        }
        call_user_func_array(array($this->query, 'bind_result'), $params);
        $result = [];
        while ($this->query->fetch()) {
            $r = new \stdClass();
            foreach ($row as $key => $val) {
                $r->$key = $val;
            }
            if ($callback != null && is_callable($callback)) {
                $value = call_user_func($callback, $r);
                if ($value == 'break') break;
            } else {
                $result[] = $r;
            }
        }
        $this->query->close();
        $this->query_closed = true;
        return $result;
    }

    /**
     * fetchArray function
     *
     * @return array
     */
	public function fetchArray() {
	    $params = [];
        $row = [];
	    $meta = $this->query->result_metadata();
	    while ($field = $meta->fetch_field()) {
	        $params[] = &$row[$field->name];
	    }
	    call_user_func_array([$this->query, 'bind_result'], $params);
        $result = [];
		while ($this->query->fetch()) {
			foreach ($row as $key => $val) {
				$result[$key] = $val;
			}
		}
        $this->query->close();
        $this->query_closed = true;
		return $result;
	}

    /**
     * fetchObject function
     *
     * @return object
     */
    public function fetchObject() {
        $params = [];
        $row = [];
        $meta = $this->query->result_metadata();
        while ($field = $meta->fetch_field()) {
            $params[] = &$row[$field->name];
        }
        call_user_func_array(array($this->query, 'bind_result'), $params);
        $result = new \stdClass();
        while ($this->query->fetch()) {
            foreach ($row as $key => $val) {
                $result->$key = $val;
            }
        }
        $this->query->close();
        $this->query_closed = true;
        return $result;
    }

    /**
     * close function
     *
     * @return boolean
     */
	public function close() {
		return $this->connection->close();
	}

    /**
     * numRows function
     *
     * @return int
     */
    public function numRows() {
		$this->query->store_result();
		return $this->query->num_rows;
	}

    /**
     * affectedRows function
     *
     * @return int
     */
	public function affectedRows() {
		return $this->query->affected_rows;
	}

    /**
     * lastInsertID function
     *
     * @return int
     */
    public function lastInsertID() {
    	return $this->connection->insert_id;
    }

    /**
     * error function
     *
     * @param string $error
     * @return void
     */
    public function error($error) {
        if ($this->show_errors) {
            exit($error);
        }
    }

    /**
     * gettype function
     *
     * @param any $var
     * @return void
     */
	private function gettype($var) {
	    if (is_string($var)) return 's';
	    if (is_float($var)) return 'd';
	    if (is_int($var)) return 'i';
	    return 'b';
	}

}
