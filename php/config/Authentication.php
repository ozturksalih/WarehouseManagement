<?php
require_once  './php/entities/user.php';
require_once './php/DataAccessLayer/UserDal.php';
require_once 'config.php';
require_once 'dataAccess.php';
class Authentication {

    private bool $isLogged;
    private $dataAccess;
    private $userDal;
    
    public function __construct(){
        $this->dataAccess = new DataAccess();
        $this->userDal = new UserDal();
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
    public function getUserById($id){
        return $this->userDal->GetByUserId($id);
    }
    public function UpdateProfile($userToUpdate){
        $this->userDal->UpdateUser($userToUpdate);
    }

    public function IsPasswordsSame($p1, $p2) {
        if ($p1 != $p2) {
            return false;
        }return true;
    }

    private function PasswordCheck($email, $password) {
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
    private function WrongAttemptCheck($user_id){
        $wrongAttempt = $this->userDal->GetWrongAttempt($user_id);
        
        if($wrongAttempt>=3){
            sleep(30);
            $this->userDal->ResetWrongAttempt($user_id);
            return false;
        }return true;
    }
    private function IsLogged(){
        return $this->isLogged;
    }
    public function Login($email, $password){
        if($this->PasswordCheck($email, $password) ){
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
        
        $isUserExist = $this->IsUserExist($email);
        if ($isUserExist) {
            $this->Pop_Up("This Email is already registered!");
            return false;
        }
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $userToAdd= new User(0, $name, $surname,$email, $hashed_password, 0);
        $this->userDal->AddUser($userToAdd);
        $this->Pop_Up("Registeration Completed");
        return true;
    }

    
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
