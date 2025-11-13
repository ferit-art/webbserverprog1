<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $name = $_GET['name'];
    $age = 2025 - $_GET['birthday'];
    echo "<p>$name är $age år gammal <p>" 
    ?>
</body>
</html>