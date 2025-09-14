<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    include '../inc/function.php';

    if (isset($_POST['namn'])) {

        try {
            $data = array(
                "name" => $_POST['namn'],
                "efternamn" => $_POST['efternamn'],
                "användarnamn" => $_POST['annamn'],
                "kod" => $_POST['kod']
            );

            foreach ($data as $value) {

                if (!empty($value)) {
                    echo "<br>" . cleanData($value);
                }
            }
        } catch (Exception $e) {
            header("location: index.html");
            exit();
        }
    } else {
        header("location: index.html");
        exit();
    }
    ?>
</body>

</html>