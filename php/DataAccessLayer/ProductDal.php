<?php

require_once './php/config/dataAccess.php';

class ProductDal {

    private $dataAccess;

    public function __construct() {
        $this->dataAccess = new DataAccess();
    }

    public function GetAllProducts() {
        $gelAllQuery = "SELECT 
    product_id, category_id, product_name, quantity 

    FROM products
    ORDER BY product_name ASC
            
    ";
        $allProducts = $this->dataAccess->DB->Query($gelAllQuery);
        return $allProducts;
    }
    public function GetByProductId($id){
        $getQuery = "SELECT 
    product_id, category_id, product_name, quantity 

    FROM products
    WHERE product_id = ?
            
    ";
        $product = $this->dataAccess->DB->QueryWithArgs($getQuery,[$id]);
        return $product;
    }

    public function AddProduct($productToAdd) {
        $addQuery = "INSERT INTO products (category_id, product_name, quantity)
VALUES (?,?,?);";
        $category_id = $productToAdd -> category_id;
        $product_name = $productToAdd -> product_name;
        $quantity = $productToAdd -> quantity;
        
        $this->dataAccess->DB->QueryWithArgs($addQuery,[$category_id, $product_name,$quantity]);
    
        return true;
    }

    public function DeleteProduct($id) {
        $deleteQuery = "DELETE FROM products WHERE product_id=?;";
        
        $this->dataAccess->DB->QueryWithArgs($deleteQuery,[$id]);
       
        return true;
    }

    public function UpdateProduct($productToUpdate) {
        $updateQuery="UPDATE products
        SET category_id = ?, product_name= ?, quantity = ? 
        WHERE product_id = ?;";
        $product_id = $productToUpdate->product_id;
        $category_id = $productToUpdate->category_id;
        $product_name = $productToUpdate->product_name;
        $quantity = $productToUpdate->quantity;
        
        $this->dataAccess->DB->QueryWithArgs($updateQuery,[$category_id,$product_name,$quantity,$product_id]);
    
        return true;
    }

}
