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
    
    public function getName()
    {
        return $this->name;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getPwd()
    {
        return $this->pwd;
    }

    public function setPwd($pwd)
    {
        $this->pwd = $pwd;
    }
}
