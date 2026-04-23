<?php

class DatabaseConnection{

    protected function connect(){
        try{
            $dsn = "mysql:host=;port=;dbname=";
            $username = "";
            $password = "";

            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            print "Connection failed: " . $e->getMessage();
            die();
        }
    }
}
