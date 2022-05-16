<?php




require_once 'dataAccess.php';
require_once 'Authentication.php';

class Logic {

    private $dataAccess;
    public bool $isLogged;
    private $auth;
   
    public function __construct() {
        $this->dataAccess = new DataAccess();
        $this->auth = new Authentication();
       
        
        if (isset($_POST["login"])) {
            //$this->EditRow(filter_input(INPUT_GET, "edit-id"));
            $this->auth->Login($_POST["email"], $_POST["pass"]);
            
            
        } else if (filter_has_var(INPUT_GET, "register")) {
            if (!$this->auth->IsPasswordsSame(filter_input(INPUT_GET, "pass"), filter_input(INPUT_GET, "passConfirm"))) {
                $this->auth->Pop_Up("passwords are not same!");
                return;
            }
            $this->auth->Register(filter_input(INPUT_GET, "name"), filter_input(INPUT_GET, "surname"), filter_input(INPUT_GET, "email"), filter_input(INPUT_GET, "pass"));
        }
        if(filter_has_var(INPUT_GET, "profile-email")){
            //echo "sistem geliyor". filter_input(INPUT_GET, 'profile-email');
            //$_SESSION['user']= $this->getByEmail(filter_input(INPUT_GET, 'profile-email'));
          //  print_r($_SESSION['user']);
            
        }
        
        if(filter_has_var(INPUT_GET, "logout")){
            $this->auth->LogOut();
        }
    }
    public function Pop_Up($text) {
        $output = $text;
        if (is_array($output)) {
            $output = implode(',', $output);
        }

        echo "<script> alert('" . $output . "') </script>";
    }
    public function getByEmail($email){
        return $this->auth->getUser($email);
    }
    

    

}
