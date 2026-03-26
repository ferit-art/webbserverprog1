<?php
include_once('../../model/dbFunctions.php');
$db = connectToDb();
$result = getAllPostsWithComments($db);

// Behövs för session-cookies och anger att formatet är json
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');

// Gör om arrayen till en array med json-objekt
echo json_encode($result, JSON_UNESCAPED_UNICODE);
