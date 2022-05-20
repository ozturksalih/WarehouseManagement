<?php

require_once './php/entities/user.php';
require_once './php/DataAccessLayer/UserDal.php';
require_once 'config.php';
require_once 'PopUp.php';

class Authentication {

    private bool $isLogged;
    private $userDal;
    private $popup;

    public function __construct() {
        $this->userDal = new UserDal();
        $this->popup = new PopUp();
    }

    public function Login($email, $password) {
        $isUserExist = $this->IsUserExist($email);
        if ($isUserExist) {
            $user = $this->getUser($email);
            if ($this->CheckLoginCredentials($email, $password)) {

                $_SESSION["isLogged"] = true;
                $_SESSION["user"] = $user;
                //print_r($_SESSION["user"]);
                return true;
            }
            
        } else {
            $this->popup->CreatePopUp("Error", "User doesn't exist!");
        }

        $this->LogOut();
        return false;
    }
    
    private function CheckLoginCredentials($email, $password) {
        $user = $this->getUser($email);

        $passwordCheck = $this->PasswordCheck($email, $password);
        $wrongAttempt = $this->WrongAttemptCheck($user->user_id);
        $lastWrongDate = $this->GetLastWrongAttempt($user ->user_id);
        $checkLastWrong = $this->CompareLastWrongAttempt($lastWrongDate);
        if (!$wrongAttempt) {
            
            $this->SetLastWrongAttempt($user->user_id);
            
            $this->userDal->ResetWrongAttempt($user->user_id);
            
            
            return false;
            
        }
        if(!$checkLastWrong){
            $this->popup->CreatePopUp("Error", "You need for 30 seconds to log in!");
            return false;
        }
        
        if (!$passwordCheck) {
            $this->popup->CreatePopUp("Error", "Wrong Password");
            return false;
        } 
        return true;
    }
    private function CompareLastWrongAttempt($date){
        $seconds = 30;
        $date = date("Y-m-d H:i:s", (strtotime(date($date)) + $seconds));
        $date_now = date("Y-m-d H:i:s");
        if($date_now > $date){
            return true;
        }return false;
    }
    private function GetLastWrongAttempt($user_id){
        $user = $this->getUserById($user_id);
        return $lastWrongDate = $user->last_wrong_attempt;
    }
    private function SetLastWrongAttempt($user_id){
        
        $this->userDal->SetLastWrongAttempt($user_id);
        
    }
    
    private function WrongAttemptCheck($user_id) {
        $wrongAttempt = $this->userDal->GetWrongAttempt($user_id);
        print_r($wrongAttempt);
        if ($wrongAttempt >= 3) {
            return false;
        }return true;
    }

    private function PasswordCheck($email, $password) {
        $user = $this->getUser($email);
        $hashFromDB = $user->passwordHash;
        if ($this->IsPasswordTrue($password, $hashFromDB)) {

            return true;
        }
        $this->userDal->IncreaseWrongAttempt($user->user_id);

        return false;
    }

    public function IsPasswordTrue($password, $hashFromDB) {
        return password_verify($password, $hashFromDB);
    }

    

    public function IsUserExist($email): bool {

        $db = $this->userDal->GetByEmail($email);

        if ($db != null) {
            return true;
        }
        return false;
    }

    public function getUser($email): User {

        return $this->userDal->GetByEmail($email);
    }

    public function getUserById($id) {
        return $this->userDal->GetByUserId($id);
    }

    public function UpdateProfile($userToUpdate) {
        $this->userDal->UpdateUser($userToUpdate);
    }

    public function IsPasswordsSame($p1, $p2) {
        if ($p1 != $p2) {
            return false;
        }return true;
    }

    private function IsLogged() {
        return $this->isLogged;
    }

    public function LogOut() {
        $_SESSION["isLogged"] = false;
        unset($_SESSION["user"]);
    }

    public function Register($name, $surname, $email, $password) {

        $isUserExist = $this->IsUserExist($email);
        if ($isUserExist) {
            $this->popup->CreatePopUp("Warning", "This Email is already registered!");
            return false;
        }
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $userToAdd = new User(0, $name, $surname, $email, $hashed_password, 0, strtotime(date("Y-m-d H:i:s")));
        $this->userDal->AddUser($userToAdd);
        $this->popup->CreatePopUp("Success", "Registeration Completed");
        return true;
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
