<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8" />
    <title>Quiz med Formulär och PHP</title>
</head>

<body>
    <h1>Resultat</h1>
    <?php
    $points = 0;
    $ansOne = $_POST['qOne'];
    $ansTwo = $_POST['qTwo'];
    $ansThree = $_POST['qThree'];
    $ansFour = $_POST['qFour'];

    if ($ansOne == 'php') {
        $points++;
    }
    if ($ansTwo == 'tolv')
        $points++;
    if ($ansThree == 'frontend')
        $points++;
    if ($ansFour == 'go')
        $points++;

    echo '<strong>Du fick ' . $points . ' av 4 möjliga</strong>';
    ?>
</body>

</html>