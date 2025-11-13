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
    $ansFive = $_POST['qFive'];
    $ansSix = $_POST['qSix'];

    if ($ansOne == 'php')
        $points++;
    if ($ansTwo == 'tolv')
        $points++;
    if ($ansThree == 'frontend')
        $points++;
    if ($ansFour == 'go')
        $points++;
    if ($ansFive == '60')
        $points++;
    if ($ansSix == 'bread')
        $points++;

    if ($points <= 2) {
        echo '<strong>Läs på mer och försök igen</strong>';
    } elseif ($points > 2 && $points < 5) {
        echo '<strong>Godkänd</strong>';
    } else {
        echo '<strong>Bra, du behärskar det mesta</strong>';
    }
    ?>
</body>

</html>