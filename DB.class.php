<?php
class DB {
    private static $dbh;
    public function get() {
        if (is_null(self::$dbh)) {
            global $db;
            self::$dbh = new PDO('mysql:host='.$db['host'].';dbname='.$db['db'],$db['user'],$db['pass']);
        }
        return self::$dbh;
    }
}