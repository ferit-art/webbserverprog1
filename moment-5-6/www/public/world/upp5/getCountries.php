<?php
include_once('../inc/world.db.inc.php');
/* Bygger upp sql frågan */
$sqlkod = "SELECT Code, Name, Population FROM country ORDER BY Name";

/* Kör frågan mot databasen world och tabellen country */
$stmt = $db->prepare($sqlkod);
$stmt->execute();

/* Anger teckenkodningen för webbläsaren */
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* Anger att datan är i json-formatet */
header('Content-Type: application/json');

// Gör om arrayen till en array med json-objekt
echo json_encode($result, JSON_UNESCAPED_UNICODE);
