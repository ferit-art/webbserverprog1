<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>

<body>
    <form action="" method="POST">
        <fieldset>
            <legend><b>Personuppgifter</b></legend>
            <p><b>Förnamn</b></p>
            <input type="text" name="namn">

            <p><b>Efternamn</b></p>
            <input type="text" name="efternamn">

            <p><b>Användarnamn</b></p>
            <input type="text" name="annamn">

            <p><b>Lösenord</b></p>
            <input type="text" name="kod">

            <input type="submit">
        </fieldset>

        <?php
        include '../inc/function.php';

        if (isset($_POST['namn'])) {

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
        }
        ?>
</body>

</html>