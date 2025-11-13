<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="utf-8">
    <title>Namn och Ålder</title>
</head>

<body>
    <h1>Namn och ålder</h1>
    <?php
    $info1 = $_POST['info0'];
    $info2 = $_POST['info1'];
    $theRest = 65 - $info2;
    echo "<p>$info1 är $info2 år gammal och har $theRest år kvar till pension</p>";
    ?>
</body>

</html>