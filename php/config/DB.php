<?php

class DB {

    public $Connection = null;

    public function __construct($Connection = null) {
        if ($Connection == null) {
            $this->Connection = new Connection();
        } else {
            $this->Connection = $Connection;
        }
    }

    public function Query($queryString) {
        if ($this->Connection->CheckConnection()) {
            try {
                $query = $this->Connection->Prepare(trim($queryString));

                $query->execute();
            } catch (Exception $ex) {
                throw new Exception($ex->getMessage());
            }
            if (strtoupper(substr(trim($queryString), 0, 6)) == "SELECT") {
                return $query->fetchAll();
            } else if (strtoupper(substr(trim($queryString), 0, 6)) == "INSERT") {
                return $this->Connection->GetLastInsertId();
            } else if (strtoupper(substr(trim($queryString), 0, 6)) == "DELETE" || strtoupper(substr($queryString, 0, 6)) == "UPDATE") {
                return true;
            }
        } else {
            Log::Add("Błąd połaczenia z bazą danych", LogTypes::Error);
            throw new Exception("Błąd połaczenia z bazą danych");
        }
    }

    public function QueryWithArgs($queryString, $arguments) {
        if ($this->Connection->CheckConnection()) {
            try {
                $query = $this->Connection->Prepare(trim($queryString));
                $i = 1;
                foreach ($arguments as $argument) {
                    $query->bindValue($i, $argument, PDO::PARAM_STR);
                    $i++;
                }$query->execute();
            } catch (Exception $ex) {
                throw new Exception($ex->getMessage());
            }            if (strtoupper(substr(trim($queryString), 0, 6)) == "SELECT") {
                return $query->fetchAll();
            } else if (strtoupper(substr(trim($queryString), 0, 6)) == "INSERT") {
                return $this->Connection->GetLastInsertId();
            } else if (strtoupper(substr(trim($queryString), 0, 6)) == "DELETE" || strtoupper(substr($queryString, 0, 6)) == "UPDATE") {
                return true;            }        } else {
            Log::Add("Błąd połaczenia z bazą danych", LogTypes::Error);
            throw new Exception("Błąd połaczenia z bazą danych");
        }
    }

}
