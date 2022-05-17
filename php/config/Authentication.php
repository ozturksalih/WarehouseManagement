<?php
require_once 'user.php';

require_once 'config.php';
require_once 'dataAccess.php';
class Authentication {

    private bool $isLogged;
    private $dataAccess;
    public function __construct(){
        $this->dataAccess = new DataAccess();
    }
    public function IsUserExist($email): bool {
        $emailQuery = "SELECT email FROM users WHERE email = ?";
        $db = $this->dataAccess->DB->QueryWithArgs($emailQuery, [$email]);
      
        if ($db != null) {
            return true;
        }
        return false;
    }

    public function getUser($email): User {
        $isUserExist = $this->IsUserExist($email);
        if ($isUserExist) {
            $emailQuery = "SELECT user_id , name, surname, email, password_hash FROM users WHERE email = ?";
            //$user= new User($email);
            $db = $this->dataAccess->DB->QueryWithArgs($emailQuery, [$email]);
            $user = new User($db[0]["user_id"], $db[0]["name"], $db[0]["surname"], $db[0]["email"], $db[0]["password_hash"]);

            return $user;
        }
        return null;
    }
    public function UpdateProfile($userToUpdate){
        $updateQuery="UPDATE users
        SET name = ?, surname= ?, email = ?, password_hash = ? 
        WHERE user_id = ?;";
        $user_id = $userToUpdate -> user_id;
        $name = $userToUpdate -> name;
        $surname = $userToUpdate -> surname;
        $email = $userToUpdate -> email;
        $passwordHash = $userToUpdate -> passwordHash;
                
        $this->dataAccess->DB->QueryWithArgs($updateQuery,[$name, $surname, $email, $passwordHash, $user_id]);
    }

    public function IsPasswordsSame($p1, $p2) {
        if ($p1 != $p2) {
            return false;
        }return true;
    }

    private function LoginCheckDatabase($email, $password) {
        $user = $this->getUser($email);
        if ($user != null) {

            //$this->debug_to_console($user);
            $hashFromDB = $user->passwordHash;
            if ($this->IsPasswordTrue($password, $hashFromDB)) {

                return true;
            }$this->Pop_Up("Wrong password");
            return false;
        }
        
        $this->Pop_Up("User doesnt exist");
        return false;
    }
    private function IsLogged(){
        return $this->isLogged;
    }
    public function Login($email, $password){
        if($this->LoginCheckDatabase($email, $password)){
            $this->isLogged = true;
            $_SESSION["isLogged"] = $this->isLogged;
            $_SESSION["user"] = $this->getUser($email);
            //print_r($_SESSION["user"]);
        }else{
            $this->LogOut();
        }
        
        
        
    }
    
    public function LogOut(){
        $this->isLogged = false;
        $_SESSION["isLogged"] = $this->isLogged;
        unset($_SESSION["user"]);
        
    }

    public function Register($name, $surname, $email, $password) {
        $registerQuery = "INSERT INTO users (name, surname, email, password_hash) VALUES (?,?,?,?);";
        $isUserExist = $this->IsUserExist($email);
        if ($isUserExist) {
            $this->Pop_Up("This Email is already registered!");
            return false;
        }
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $this->dataAccess->DB->QueryWithArgs($registerQuery, [$name, $surname, $email, $hashed_password]);
        $this->Pop_Up("Registeration Completed");
        return true;
    }

    //
    public function IsPasswordTrue($password, $hashFromDB) {
        return password_verify($password, $hashFromDB);
    }

    public function Pop_Up($text) {
        $output = $text;
        if (is_array($output)) {
            $output = implode(',', $output);
        }

        echo "<script> alert('" . $output . "') </script>";
    }

    public function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);

        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }

}
