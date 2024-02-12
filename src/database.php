<?php

$host = "localhost";
$dbname = "chatroom";
$username = "root";
$password = "";


$mysqli = new mysqli($host,$username,$password,$dbname);
if ($mysqli->connect_errno) {
    die("connect error". $mysqli->connect_error);
}

return $mysqli;