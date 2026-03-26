<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <form action="checkUser.php" method="POST">

        <fieldset>
            <label>Användarnamn</label>
            <br>
            <input name="username">
            <br>
            <legend>Logga in</legend>
            <label>Lösenord</label><br>
            <input type="password" name="pwd">
            <br>
            <input type="submit" value="Loggin">
        </fieldset>
    </form>
</body>

</html>