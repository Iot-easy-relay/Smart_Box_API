<?php
function OpenCon()
{
    $dbhost = "localhost";        //@ip du server ovh
    $dbuser = "user1";
    $dbpass = "root";            //"X7ecLlU7KQB83T2c";
    $db = "Smart_box";

    $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n" . $conn->error);

    return $conn;
}
function CloseCon($conn)
{
    $conn->close();
}
//
?>
