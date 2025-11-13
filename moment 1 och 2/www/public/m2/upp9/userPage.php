<?php
include '../../../inc/function.php';

if (!isset($_GET['name'])) {
    header("location: index.html");
    exit;
}

$name = cleanData($_GET['name']);

?>

<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $name ?></title>
</head>

<body>
    <h1>
        <?php
        echo "Hej " . $name;
        ?>
    </h1>
</body>

</html>