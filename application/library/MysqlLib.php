<?php
/**
 * @name MysqlLib
 * @author ruansheng
 */
class MysqlLib {
    private static $host = '127.0.0.1';
    private static $port = 3306;
    private static $dbname = null;
    private static $_instance;
    private $mysql;

    private function __construct() {

    }

    private function __clone() {

    }

    public static function getInstance(){
        if(!(self::$_instance instanceof self)){
            self::$_instance = new self;
        }
        return self::$_instance;
    }


}
