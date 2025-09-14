<?php
function saveUsers($userArray)
{
    $file = "../upp8-1/User.dat";
    file_put_contents($file, serialize($userArray));
}
