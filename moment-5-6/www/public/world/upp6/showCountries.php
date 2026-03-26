<?php
include_once('../inc/world.db.inc.php');

if (isset($_GET['name'])) {
   $name = $_GET['name'];

   /**Kör frågan mot databasen world och tabellen city. 
    * ? ERSÄTTS I RADEN UNDER MED EN PARAMETER
    */
   $stmt = $db->prepare("SELECT Name, Population FROM country WHERE Name LIKE ? ORDER BY Name");
   $stmt->bindValue(1, "$name%", PDO::PARAM_STR);
   $stmt->execute();

   /* Anger teckenkodningen för webbläsaren */
   $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

   /* Anger att datan är i json-formatet */
   header('Content-Type: application/json');

   // Gör om arrayen till en array med json-objekt
   echo json_encode($result, JSON_UNESCAPED_UNICODE);
}
