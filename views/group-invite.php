<?php
$mysqli = require __DIR__."/../src/database.php";
$userID = $mysqli->real_escape_string($_SESSION["userID"]);

$inviteID = $mysqli->real_escape_string($params["id"]);

$stmt = $mysqli->prepare("UPDATE groupchat SET users = JSON_ARRAY_APPEND(users, '$', JSON_OBJECT('userID', ?)) WHERE inviteID = ?");
$stmt->bind_param('ss', $userID, $inviteID);

$stmt->execute();
?>
<h1>Joined groupchat.</h1>
<a href="/chat">Chat</a>