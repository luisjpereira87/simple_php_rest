<?php

namespace Models;

class User
{

    public $name;
    public $email;
    public $birthday;
    public $gender;

    public function __construct(string $name, string $email, string $birthday, string $gender)
    {
        $this->name = $name;
        $this->email = $email;
        $this->birthday = $birthday;
        $this->gender = $gender;
    }

    // Getters
    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getBirthday(): string
    {
        return $this->birthday;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    // Setters
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setBirthday(string $birthday): void
    {
        $this->birthday = $birthday;
    }

    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }
}
