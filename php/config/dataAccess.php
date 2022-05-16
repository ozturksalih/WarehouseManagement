<?php
require_once 'Connection.php';
require_once 'DB.php';
require_once 'config.php';

class DataAccess{
    public $Con ;
    public $DB ;
    public function __construct(){
        $this->Con = new Connection(DB_HOST, DB_NAME, DB_USER, DB_PASS);
        $this->DB = new DB($this->Con);

    }
    
}

