<?php

namespace Model;

use PDO;
use PDOException;

class Database extends PDO 
{
    private static $instance;

    private const DB_HOST = 'localhost';
    private const DB_NAME = 'locavore';
    private const DB_USER = 'root';
    private const DB_PASSWORD = '';

    private function __construct() 
    {
        $dsn = 'mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME;

        try {
            parent::__construct($dsn, self::DB_USER, self::DB_PASSWORD);

            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance():self 
    {
        if(self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}