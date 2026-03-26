<?php
function cleanData($data)
{
    $data = htmlspecialchars($data);
    $data = strip_tags($data);
    $data = trim($data);
    $data = stripslashes($data);

    return $data;
}
