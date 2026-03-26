<?php
include_once('../inc/world.db.inc.php');
/* Bygger upp sql frågan */
$sqlkod = "SELECT Name FROM city WHERE Name LIKE 'Z%' ORDER BY Name";

/* Kör frågan mot databasen world och tabellen country */
$stmt = $db->prepare($sqlkod);
$stmt->execute();

/* Anger teckenkodningen för webbläsaren */
header('Content-Type: text/html; charset=utf-8');

/* skriver ut resultatet på webbsidan. */
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<strong>Stad: </strong>" . $row['Name'];
    echo "<br /><hr />";
}
