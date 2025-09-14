<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $page["head"] = "<h1>Välkommen</h1>";
    $page["main"] = "<p>Detta är innehållet på min sida</p>";
    $page["footer"] = "<hr><p>Min sidfoot</p>";

    header('Content-Type: text/html; charset=utf-8');

    foreach ($page as $value) {
        echo $value . "<br>";
    }
    ?>
</body>

</html>