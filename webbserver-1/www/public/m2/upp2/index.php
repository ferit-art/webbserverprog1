<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    echo "for-loop:";

    for ($i = 0; $i < 5; $i += 0.1) {
        echo "<br>" . $i;
    }

    echo "<br>" . "while-loop:";

    $a = 0;

    while ($a < 5) {
        echo "<br>" . $a;
        $a += 0.1;
    }
    ?>
</body>

</html>