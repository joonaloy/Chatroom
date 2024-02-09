<?php

if (empty($_POST["username"])){
    die("username is required");
}
if (!preg_match("/[a-z]/i",$_POST["password"])){
    die("password must contain at least one letter");
}
if($_POST["password"] !== $_POST["password_confirmation"]){
    die("passwords must match");
}
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__."/../src/database.php";

$sql = "INSERT INTO user (username,password) VALUES (?,?)";

$stmt = $mysqli->prepare($sql);
if (!$stmt){
    die("prepare failed: ".$mysqli->error);
}

$stmt->bind_param("ss",$_POST["username"],$password_hash);
if ($stmt->execute()){
    echo "user created";
    header("Location: /signup-success");
    exit;
}else{
    die("execute failed: ".$stmt->error);
}
