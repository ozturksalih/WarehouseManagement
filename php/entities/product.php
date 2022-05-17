<?php

class Product {
    public int $product_id;
    public int $category_id;
    public string $product_name;
    public int $quantity;
    
    
    public function __construct($product_id, ?int $category_id, ?string $product_name, ?int $quantity)
    {
        $this->product_id = $product_id;
        $this->category_id =  $category_id;
        $this->product_name = $product_name;
        $this->quantity = $quantity;
    }
        
    
    
    public function getProductId(): int
    {
        return $this->product_id;
    }
    
    public function getProductName(): string
    {
        return $this->category_name;
    }
    public function setProductName(string $product_name): void
    {
        $this->product_name = $product_name;
    }
    public function getCategoryId(): int
    {
        return $this->category_id;
    }
    public function setCategoryId(int $category_id): void
    {
        $this->category_id = $category_id;
    }
    public function getQuantity(): int
    {
        return $this->quantity;
    }
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
    
    
    
    
}