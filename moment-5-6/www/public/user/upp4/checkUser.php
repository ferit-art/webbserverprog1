<?php
if (isset($_POST['username'], $_POST['pwd'])) {
    include_once('../inc/user.db.inc.php');

    $user = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $pwd = $_POST['pwd'];

    /* Bygger upp sql frågan */
    $stmt = $db->prepare("SELECT * FROM user WHERE username = :user");
    $stmt->bindValue(":user", $user);
    $stmt->execute();

    try {
        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($pwd, $user['password'])) {
                echo "<p>Du är inloggad!!<p>";
            } else {
                echo "<p>Kontrollera lösenordet</p>";
            }
        } else {
            echo "<p>Kontrollera användarnamnet eller lösenordet</p>";
        }
    } catch (Exception $e) {
        header('Content-Type: text/html; charset=utf-8');
        echo "<a href = 'index.php'>Försök igen</a>";
    }
}
