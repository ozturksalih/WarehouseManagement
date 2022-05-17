<?php

class Category {
    public int $category_id;
    public string $category_name;
    
    
    public function __construct($category_id, ?string $category_name)
    {
        $this->category_id = $category_id;
        $this->category_name = $category_name;
    }
        
    
    
    public function getCategoryId(): int
    {
        return $this->category_id;
    }
    
    public function getCategoryName(): string
    {
        return $this->category_name;
    }
    public function setCategoryName(string $category_name): void
    {
        $this->category_name = $category_name;
    }
    
    
    
    
}

