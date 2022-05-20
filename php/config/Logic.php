<?php

require_once './php/DataAccessLayer/CategoryDal.php';
require_once './php/DataAccessLayer/ProductDal.php';
require_once 'dataAccess.php';
require_once 'Authentication.php';

class Logic {

    private $dataAccess;
    public bool $isLogged;
    private $auth;
    private $categoryDal;
    private $productDal;

    public function __construct() {
        $this->dataAccess = new DataAccess();
        $this->auth = new Authentication();
        $this->categoryDal = new CategoryDal();
        $this ->productDal = new ProductDal();

        if (isset($_POST["login"])) {
            //$this->EditRow(filter_input(INPUT_GET, "edit-id"));
            $this->Login($_POST["email"], $_POST["pass"]);
        } else if (filter_has_var(INPUT_GET, "register")) {
            if (!$this->auth->IsPasswordsSame(filter_input(INPUT_GET, "pass"), filter_input(INPUT_GET, "passConfirm"))) {
                $this->auth->Pop_Up("passwords are not same!");
                return;
            }
            $this->auth->Register(filter_input(INPUT_GET, "name"), filter_input(INPUT_GET, "surname"), filter_input(INPUT_GET, "email"), filter_input(INPUT_GET, "pass"));
        } else if (filter_has_var(INPUT_GET, "update-profile")) {
            $this->EditProfile(filter_input(INPUT_GET, "user-id"), filter_input(INPUT_GET, "name"), filter_input(INPUT_GET, "surname"), filter_input(INPUT_GET, "email"), filter_input(INPUT_GET, "profile-email"));
        }
        if (filter_has_var(INPUT_GET, "add-product")) {
            
            $this->GetCategories();
        }
        if(filter_has_var(INPUT_GET, "added-product")){
            $this->AddProduct(filter_input(INPUT_GET, "category_id"), filter_input(INPUT_GET, "product_name"), filter_input(INPUT_GET, "quantity"));
        }
        if(filter_has_var(INPUT_GET, "added-category")){
            $this->AddCategory(filter_input(INPUT_GET,"category_name"));
        }
        if(filter_has_var(INPUT_GET, "edit-product")){
            $this->GetCategories();
            $this->GetProduct(filter_input(INPUT_GET,"product_id"));
        }
        if(filter_has_var(INPUT_GET, "edit-category")){
            
            $this->GetCategoryById(filter_input(INPUT_GET,"category_id"));
        }
        if(filter_has_var(INPUT_GET, "edited-product")){
            
            $this->EditProduct(filter_input(INPUT_GET,"product_id"), filter_input(INPUT_GET,"category_id"), 
                    filter_input(INPUT_GET,"product_name"), filter_input(INPUT_GET,"quantity"));
        }
        if(filter_has_var(INPUT_GET, "edited-category")){
            $this->EditCategory(filter_input(INPUT_GET,"category_id"), filter_input(INPUT_GET,"category_name"));
        }if(filter_has_var(INPUT_GET, "delete-category")){
            $this->DeleteCategory(filter_input(INPUT_GET,"category_id"));
        }
        if(filter_has_var(INPUT_GET, "delete-product")){
            $this->DeleteProduct(filter_input(INPUT_GET,"product_id"));
        }
        
        
        if (filter_has_var(INPUT_GET, "profile-email")) {
            //echo "sistem geliyor". filter_input(INPUT_GET, 'profile-email');
            //$_SESSION['user']= $this->getByEmail(filter_input(INPUT_GET, 'profile-email'));
            //  print_r($_SESSION['user']);
        }

        if (filter_has_var(INPUT_GET, "logout")) {
            $this->auth->LogOut();
        }
    }
    private function Login($email, $password){
        $login = $this->auth->Login($email, $password);
        if($login){
            header("Location: http://localhost/WarehouseManagement/warehouse_tables.php");
        }
        
    }
    private function DeleteCategory($category_id){
        $this->categoryDal->DeleteCategory($category_id);
        
    }
    private function DeleteProduct($product_id){
        $this->productDal->DeleteProduct($product_id);
        
    }
    private function EditCategory($category_id, $category_name){
        $categoryToUpdate = new Category($category_id,$category_name);
        $this->categoryDal->UpdateCategory($categoryToUpdate);
        unset($_SESSION['categoryToUpdate']);
    }
    private function EditProduct($product_id, $category_id, $product_name, $quantity){
        
        $productToUpdate = new Product($product_id, $category_id, $product_name, $quantity);
        $this->productDal->UpdateProduct($productToUpdate);
        unset($_SESSION['product']);
        unset($_SESSION['categories']);
    }
    private function GetCategoryById($id){
        $categoryToUpdate = $this->categoryDal->GetByCategoryId($id);
        $_SESSION["categoryToUpdate"]= $categoryToUpdate;
        return $categoryToUpdate;
    }
    private function GetProduct($id){
        $product = $this->productDal->GetByProductId($id);
        $_SESSION['product'] = $product; 
        return $product;
    }
    private function AddCategory($category_name){
        $newCategory = new Category(0,$category_name);
        $this->categoryDal->AddCategory($newCategory);
    }
    private function AddProduct($categoryId, $product_name, $quantity){
        $newProduct = new Product(0, $categoryId, $product_name, $quantity);
        
        $this->productDal->AddProduct($newProduct);
        unset($_SESSION['categories']);
    }
    private function GetCategories() {
        $categories = $this->categoryDal->GetAllCategories();
        
        $_SESSION['categories'] = $categories;
        
        return $categories;
    }

    private function EditProfile($user_id, $name, $surname, $email) {
        $currentUserInformations = [$_SESSION['user']][0];

        $userToUpdate = new User($user_id, $name, $surname, $email, $currentUserInformations->passwordHash,0);
        $this->auth->UpdateProfile($userToUpdate);
        $_SESSION['user'] = $userToUpdate;
    }

    public function Pop_Up($text) {
        $output = $text;
        if (is_array($output)) {
            $output = implode(',', $output);
        }

        echo "<script> alert('" . $output . "') </script>";
    }
    public function getAllProducts(){
        return $this->productDal->GetAllProducts();
    }
    public function getAllCategories(){
        return $this->categoryDal->GetAllCategories();
    }

    public function getByEmail($email) {
        return $this->auth->getUser($email);
    }

}
