<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>

<body>
    <?php
    echo strip_tags("Hello <b>world!</b>", "");
    echo strip_tags("<i><br>hej </i>", allowed_tags: "<br>,<i>");
    ?>
</body>

</html>