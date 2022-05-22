<?php

class User {
    public int $user_id;
    public string $name;
    public string $surname;
    public string $email;
    public string $passwordHash;
    public int $wrongAttempt;
    public $last_wrong_attempt;
    
    public function __construct($user_id, ?string $name,?string $surname,?string $email,?string $passwordHash, ?int $wrongAttempt,
             $last_wrong_attempt)
    {
        $this->user_id = $user_id;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->wrongAttempt = $wrongAttempt;
        $this->last_wrong_attempt = $last_wrong_attempt;
    }
        
    
    
    public function getUserId(): int
    {
        return $this->user_id;
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
    
    public function getWrongAttempt(): int
    {
        return $this->wrongAttempt;
    }
    public function setWrongAttempt(int $wrongAttempt): void
    {
        $this->wrongAttempt = $wrongAttempt;
    }
    public function getLastWrongAttempt()
    {
        return $this->last_wrong_attempt;
    }
    public function setLastWrongAttempt( $lastWrongAttempt): void
    {
        $this->last_wrong_attempt = $lastWrongAttempt;
    }
    
    
    
    
}

