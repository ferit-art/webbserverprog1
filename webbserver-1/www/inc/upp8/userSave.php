<?php
function saveUsers($userArray)
{
    $file = "../../../inc/upp8/User.dat";
    file_put_contents($file, serialize($userArray));
}
