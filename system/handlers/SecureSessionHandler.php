<?php
namespace system\handlers;

class SecureSessionHandler extends \SessionHandler {
    private $key;

    /**
     * SecureSessionHandler constructor
     * @param string $key
     */
    public function __construct($key) {
        $this->key = env('session.key');
    }
    
    /**
     * read function
     * @param string $id
     * @return mixed
     */
    public function read($id) {
        $data = parent::read($id);
        if (!$data) {
            return "";
        } else {
            return \decrypt($data, $this->key);
        }
    }

    /**
     * write function
     * @param string $id
     * @param string $data
     * @return mixed
     */
    public function write($id, $data){
        $data = \encrypt($data, $this->key);
        return parent::write($id, $data);
    }
}

// Intercept the native 'files' handler
ini_set('session.save_handler', 'files');
// Define Session handler within a closue within an IIFE
session_set_save_handler((function($key) {
    return new SecureSessionHandler($key);
})(env('session.key')), true);
// Start Session
session_start();