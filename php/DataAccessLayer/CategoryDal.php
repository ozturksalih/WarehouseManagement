<?php

require_once './php/config/dataAccess.php';

class CategoryDal {

    private $dataAccess;

    public function __construct() {
        $this->dataAccess = new DataAccess();
    }

    public function GetAllCategories() {
        $gelAllQuery = "SELECT 
    category_id, category_name

    FROM categories
    ORDER BY category_name ASC
            
    ";
        $allCategories = $this->dataAccess->DB->Query($gelAllQuery);
        return $allCategories;
    }
    public function GetByCategoryId($id){
        $getQuery = "SELECT 
    category_id, category_name 

    FROM categories
    WHERE category_id = ?
            
    ";
        $category = $this->dataAccess->DB->QueryWithArgs($getQuery,[$id]);
        return $category;
    }

    public function AddCategory($categoryToAdd) {
        $addQuery = "INSERT INTO categories (category_name)
VALUES (?);";
        $category_name = $categoryToAdd -> category_name;
        
        
        $this->dataAccess->DB->QueryWithArgs($addQuery,[$category_name]);
    
        return true;
    }

    public function DeleteCategory($id) {
        $deleteQuery = "DELETE FROM categories WHERE category_id=?;";
        
        $this->dataAccess->DB->QueryWithArgs($deleteQuery,[$id]);
       
        return true;
    }

    public function UpdateCategory($categoryToUpdate) {
        $updateQuery="UPDATE categories
        SET  category_name= ?
        WHERE category_id = ?;";
        
        $category_id = $categoryToUpdate->category_id;
        $category_name = $categoryToUpdate->category_name;
        
        
        $this->dataAccess->DB->QueryWithArgs($updateQuery,[$category_name,$category_id]);
    
        return true;
    }

}
