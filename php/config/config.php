<?php
require_once 'Connection.php';
require_once 'DB.php';
require_once  './php/config/user.php';
session_start();

define("DB_HOST","127.0.0.1");
define("DB_NAME","warehouse_management");
define("DB_USER",'test');
define("DB_PASS",'test');
$Con = new Connection(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$DB = new DB($Con);
