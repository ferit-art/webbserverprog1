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
