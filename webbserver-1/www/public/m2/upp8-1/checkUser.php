<?php
if (!isset($_POST['user'])) {
    header("location: index.html");
    exit;
}

include '../../../inc/upp8/users.php';
include '../../../inc/function.php';
include '../../../inc/upp8/userSave.php';

$usr = cleanData($_POST['user']);
$pwd = cleanData($_POST['pwd']);

saveUsers($userArray);

for ($i = 0; $i < count($userArray); $i++) {
    if ($usr == $userArray[$i]["user"] && $pwd == $userArray[$i]["pwd"]) {
        header("location: userPage.php?name=" . $userArray[$i]["name"]);
        exit;
    }
}

header("location: index.html");
