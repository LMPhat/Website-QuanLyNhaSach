<?php
class Database {
    
    public function getConnect() {
        $host = "localhost";
        $db = "database_sach";
        $user = "root";
        $pass = "mysql";

        $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

        try {
            $pdo = new PDO($dsn, $user, $pass);
        
            return $pdo;

        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
}