<?php
include '../../../inc/upp9/Person.php';
include '../../../inc/function.php';

if (!isset($_POST['name1'])) {
    header("location: index.html");
    exit;
}

$name = cleanData($_POST['name1']);
$age = cleanData($_POST['age1']);
$phone = cleanData($_POST['phone1']);
$user = cleanData($_POST['user1']);
$pwd = $_POST['pwd1'];

$file = "../../../inc/upp9/User.dat";

if (file_exists($file)) {
    $userArray = unserialize(file_get_contents($file));
    $newPerson = new Person($name, $age, $phone, $user, $pwd);
    $userArray[] = $newPerson;
} else {
    $userArray = [];
    $userArray[] = new Person("Gabriella", "18", "12 12 12", "gabbe", "12345");
    $userArray[] = new Person("Ozzy", "70", "12 12", "ozi", "123444");
    $userArray[] = new Person("Gella", "20", "20 12 12", "gela", "3333");
}

file_put_contents($file, serialize($userArray));

header("location: index.html");
