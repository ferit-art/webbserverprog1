<?php
class Person
{
    public $name;
    public $age;
    public $phone;
    public $user;
    public $pwd;

    public function __construct($name, $age, $phone, $user, $pwd)
    {
        $this->name = $name;
        $this->age = $age;
        $this->phone = $phone;
        $this->user = $user;
        $this->pwd = $pwd;
    }
}

// $userArray = [];
//
//$userArray[] = new Person("Gabriella", "18", "12 12 12", "gabbe", "12345");
//$userArray[] = new Person("Ozzy", "70", "12 12", "ozi", "123444");
//$userArray[] = new Person("Gella", "20", "20 12 12", "gela", "3333");
