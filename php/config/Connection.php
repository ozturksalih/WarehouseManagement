<?php

class Connection {

    private $connection = null;
    private $host = null;
    private $dbName = null;
    private $user = null;
    private $password = null;

    public function __construct($host = DB_HOST, $dbName = DB_NAME, $user = DB_USER, $password = DB_PASS) {
        $this->host = $host;
        $this->dbName = $dbName;
        
        $this->user = $user;
        $this->password = $password;
    }

    public function CheckConnection() {
        if ($this->connection != null) {
            return true;
        } else {
            try {
                    $this->connection = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbName . ';', $this->user, $this->password);
                    $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return true;
            } catch (PDOException $e) {
                Log::Add($e, LogTypes::Error);
                return false;
            }
        }
        return false;
    }

    public function Prepare($query) {
        return $this->connection->prepare($query);
    }

    public function GetLastInsertId() {
        return $this->connection->lastInsertId();
    }

    public function GetConnection() {
        return $this->connection;
    }

}
