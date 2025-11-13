<?php
include '../../../inc/function.php';
include '../../../inc/upp9/Person.php';

if (!isset($_POST['user'])) {
    header("location: index.html");
    exit;
}

$name = cleanData($_POST['user']);
$pwd = $_POST['pwd'];

$file = "../../../inc/upp9/User.dat";

if (file_exists($file)) {
    $userArray = unserialize(file_get_contents($file));
} else {
    $userArray = [];
    $userArray[] = new Person("Gabriella", "18", "12 12 12", "gabbe", "12345");
    $userArray[] = new Person("Ozzy", "70", "12 12", "ozi", "123444");
    $userArray[] = new Person("Gella", "20", "20 12 12", "gela", "3333");

    file_put_contents($file, serialize($userArray));
}

for ($i = 0; $i < count($userArray); $i++) {
    if ($name == $userArray[$i]->getUser() && $pwd == $userArray[$i]->getPwd()) {
        header("location: userPage.php?name=" . $userArray[$i]->getName());
        exit;
    }
}

header("location: index.html");
