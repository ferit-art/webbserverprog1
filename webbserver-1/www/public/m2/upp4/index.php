<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    function div($array)
    {
        $kvot = $array[0] / $array[1];
        return $kvot;
    }

    function sub($array)
    {
        $skillnad = $array[0] - $array[1];
        return $skillnad;
    }

    echo "division mellan 10 och 5:" . "<br>";
    $array = [10, 5];
    echo div($array) . "<br>";

    echo "division mellan 10 och 5:" . "<br>";
    echo sub($array);
    ?>
</body>

</html>