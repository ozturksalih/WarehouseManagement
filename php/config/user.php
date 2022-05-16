<?php

class User {
    public int $id;
    public string $name;
    public string $surname;
    public string $email;
    public string $passwordHash;
    
    public function __construct($id, ?string $name,?string $surname,?string $email,?string $passwordHash)
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
    }
        
    
    
    public function getId(): int
    {
        return $this->id;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function getSurname(): string
    {
        return $this->surname;
    }
    public function setSurname(string $surname): void
    {
        $this->name = $surname;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    public function getPasswordHash(): string
    {
        return $this->$passwordHash;
    }
    public function setPasswordHash(string $passwordHash): void
    {
        $this->passwordHash = $passwordHash;
    }
    
    
    
    
}

