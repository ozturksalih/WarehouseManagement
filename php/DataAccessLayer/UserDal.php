<?php

require_once './php/config/dataAccess.php';

class UserDal {

    private $dataAccess;

    public function __construct() {
        $this->dataAccess = new DataAccess();
    }

    public function GetAllUsers() {
        $gelAllQuery = "SELECT 
    user_id, name, surname, email, password_hash, wrong_attempt , last_wrong_attempt

    FROM users
    
            
    ";
        $allUsers = $this->dataAccess->DB->Query($gelAllQuery);
        return $allUsers;
    }
    public function GetByUserId($id) : User{
        $getQuery = "SELECT 
    user_id, name, surname, email, password_hash, wrong_attempt , last_wrong_attempt

    FROM users
    WHERE user_id = ?
            
    ";
        $db = $this->dataAccess->DB->QueryWithArgs($getQuery,[$id]);
        
        $user = new User($db[0]["user_id"], $db[0]["name"], $db[0]["surname"], $db[0]["email"], $db[0]["password_hash"], $db[0]["wrong_attempt"]
                ,$db[0]["last_wrong_attempt"]);
        return $user;
    }
    public function GetByEmail($email) {
        $getQuery = "SELECT 
    user_id, name, surname, email, password_hash, wrong_attempt, last_wrong_attempt

    FROM users
    WHERE email = ?
            
    ";
        $db = $this->dataAccess->DB->QueryWithArgs($getQuery,[$email]);
        
        if($db != null){
            $user = new User($db[0]["user_id"], $db[0]["name"], $db[0]["surname"], $db[0]["email"], $db[0]["password_hash"], $db[0]["wrong_attempt"],
                    $db[0]["last_wrong_attempt"]);
            return $user;
        }
        return null;
    }

    public function AddUser($userToAdd) {
        $addQuery = "INSERT INTO users (name, surname, email, password_hash) VALUES (?,?,?,?);";
        $name = $userToAdd -> name;
        $surname = $userToAdd -> surname;
        $email = $userToAdd -> email;
        $hashed_password = $userToAdd->passwordHash;
        
        $this->dataAccess->DB->QueryWithArgs($addQuery,[$name, $surname, $email, $hashed_password]);
    
        return true;
    }
    

    public function DeleteUser($id) {
        $deleteQuery = "DELETE FROM users WHERE user_id=?;";
        
        $this->dataAccess->DB->QueryWithArgs($deleteQuery,[$id]);
       
        return true;
    }
    public function IncreaseWrongAttempt($id){
        $user = $this->GetByUserId($id);
        
        $wrongAttempt = $user->wrongAttempt;
        $wrongAttempt+=1;
        
        $updateQuery="UPDATE users
        SET wrong_attempt= ?
        WHERE user_id = ?;";
        $this->dataAccess->DB->QueryWithArgs($updateQuery,[$wrongAttempt, $id]);
        return true;
        
        
    }
    public function SetLastWrongAttempt($user_id){
        $user = $this->GetByUserId($user_id);
        
        $now = date("Y-m-d H:i:s");
        
        $setquery = "UPDATE users
        SET last_wrong_attempt= ?
        WHERE user_id = ?;";
        $this->dataAccess->DB->QueryWithArgs($setquery, [$now, $user_id]);
        return true;
    }
    
    public function GetWrongAttempt($user_id){
        $getQuery = "SELECT 
    wrong_attempt 

    FROM users
    WHERE user_id = ?
            
    ";
        $db = $this->dataAccess->DB->QueryWithArgs($getQuery,[$user_id]);
        return $db[0]["wrong_attempt"];
    }
    public function ResetWrongAttempt($user_id){
        $updateQuery= "UPDATE users
        SET wrong_attempt= ?
        WHERE user_id = ?;";
        $this->dataAccess->DB->QueryWithArgs($updateQuery,[0, $user_id]);
    }

    public function UpdateUser($userToUpdate) {
        $updateQuery="UPDATE users
        SET name = ?, surname= ?, email = ?, password_hash = ?
        WHERE user_id = ?;";
        $user_id = $userToUpdate -> user_id;
        $name = $userToUpdate -> name;
        $surname = $userToUpdate -> surname;
        $email = $userToUpdate -> email;
        $passwordHash = $userToUpdate -> passwordHash;
                
        $this->dataAccess->DB->QueryWithArgs($updateQuery,[$name, $surname, $email, $passwordHash, $user_id]);
    
        return true;
    }

}
