<?php
//viestin lähetys
if($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["text"])){
    $mysqli = require __DIR__."/../src/database.php";
    $sql = "INSERT INTO message (senderID,recipentID,text) VALUES (?,?,?)";

    $stmt = $mysqli->prepare($sql);
    if (!$stmt){
        die("prepare failed: ".$mysqli->error);
    }

    $stmt->bind_param("sss",$_SESSION["userID"],$params["id"],$_POST["text"]);
    if ($stmt->execute()){
    }else{
        die("execute failed: ".$stmt->error);
    }
}

if (!isset($_SESSION["userID"])){
    header("Location: /chatroom/public/login");
    exit;
}
if(!empty($params["id"])){
    //viestit
    if($params["group"] == "false"){
    $mysqli = require __DIR__."/../src/database.php";
    $sql = sprintf(
        "SELECT * FROM message WHERE RecipentID = '%s' AND SenderID = '%s' OR SenderID = '%s' AND RecipentID = '%s' ORDER BY Timesent DESC",
        $mysqli->real_escape_string($_SESSION["userID"]),
        $mysqli->real_escape_string($params["id"]),
        $mysqli->real_escape_string($_SESSION["userID"]),
        $mysqli->real_escape_string($params["id"])
    );
    $result = $mysqli->query($sql);
    $messages = $result->fetch_all(MYSQLI_ASSOC);
    //groupchatit
    }elseif($params["group"] == "true"){
    $mysqli = require __DIR__."/../src/database.php";
    $sql = sprintf(
        "SELECT * FROM message WHERE RecipentID = '%s' ORDER BY Timesent DESC",
        $mysqli->real_escape_string($params["id"]),
    );
    $result = $mysqli->query($sql);
    $messages = $result->fetch_all(MYSQLI_ASSOC);
    }
    //echo '<pre>'; print_r($messages); echo '</pre>';
}
//chatattavat ihmiset
$mysqli = require __DIR__."/../src/database.php";
    $sql = sprintf("SELECT username,userID FROM user WHERE userID != '%s'",$mysqli->real_escape_string($_SESSION["userID"]));
    $result = $mysqli->query($sql);
    $chats = $result->fetch_all(MYSQLI_ASSOC);
// groupchatit
$mysqli = require __DIR__."/../src/database.php";

$userID = $mysqli->real_escape_string($_SESSION["userID"]);
$jsonUserID = json_encode(array("userID" => $userID));
$sql = sprintf(
    "SELECT name,groupID FROM groupchat WHERE JSON_CONTAINS(users, '%s')",
    $jsonUserID
);
    $result = $mysqli->query($sql);
    $groupchats = $result->fetch_all(MYSQLI_ASSOC);
?>
<div class="Side">
<h1 class="Name">Chat</h1>
<p id="UID">Logged in as: <?=$_SESSION["username"]?> <a id="LO" href="/chatroom/public/logout"><svg id="LOimg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
<path d="m16 17 5-5-5-5"></path>
<path d="M21 12H9"></path>
</svg></a></p>

<h3 id="Text1">Direct messages</h3>
<?php
    $Uimg = '<svg id="Uimg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
    <path d="M12 3a4 4 0 1 0 0 8 4 4 0 1 0 0-8z"></path>
  </svg>';
    //echo '<pre>'; print_r($chats); echo '</pre>';
    foreach($chats as $chat){
        echo "$Uimg<a id='DM' href='/chatroom/public/chat?id=".$chat["userID"]."&group=false'>".$chat["username"]."</a> <br>";
    }
?>
<h3 id="Text2">Groups <a id="GC" href="/chatroom/public/create-group"><svg id="GCimg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
  <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
  <path d="M8.5 3a4 4 0 1 0 0 8 4 4 0 1 0 0-8z"></path>
  <path d="M20 8v6"></path>
  <path d="M23 11h-6"></path>
</svg>
</svg></a></h3>
</h1>
<?php
    $GCimg = '<svg id="GCimg2" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
    <path d="M9 3a4 4 0 1 0 0 8 4 4 0 1 0 0-8z"></path>
    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
  </svg>';
    //echo '<pre>'; print_r($groupchats); echo '</pre>';
    foreach($groupchats as $group){
        echo "$GCimg<a id='GC2' href='/chatroom/public/chat?id=".$group["groupID"]."&group=true'>".$group["name"]."</a><br>";
    }
?>
</div>
<div class="">
<?php
    if(!empty($params["id"])){
        if($params["group"] == "true"){
            $mysqli = require __DIR__."/../src/database.php";
            $sql = sprintf("SELECT name,inviteID FROM groupchat WHERE groupID = '%s'",$mysqli->real_escape_string($params["id"]));
            $result = $mysqli->query($sql);
            $group = $result->fetch_assoc();
            echo "<h3 id='Messaging'>Messaging: " . $group["name"] . " <a id='Messaging1' href='/chatroom/public/invite?id=" . $group["inviteID"] . "'>Invite Link</a></h3>";
        }elseif ($params["group"] == "false"){
            $mysqli = require __DIR__."/../src/database.php";
            $sql = sprintf("SELECT username FROM user WHERE userID = '%s'",$mysqli->real_escape_string($params["id"]));
            $result = $mysqli->query($sql);
            $user = $result->fetch_assoc();
            echo "<h3 id='Messaging'>Messaging: ".$user["username"]."</h3> ";
        }
?>
</div>
<div class="allmessage">
<?php
        if(!empty($messages)){
            foreach($messages as $message){
            //onko session userID databasessa
            $sql = "SELECT EXISTS(SELECT 1 FROM user WHERE userID = ?) as 'exists'";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param('s', $message["SenderID"]);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $exists = (bool) $row['exists'];
            if ($exists == true){
                $sql = sprintf("SELECT username FROM user WHERE userID = '%s'",$mysqli->real_escape_string($message["SenderID"]));
                $result = $mysqli->query($sql);
                $sender = $result->fetch_assoc();
                echo "<div id='Chats'><h3 id='Chats'>".$sender["username"]."<span id='Chats1'>".$message["Timesent"]."</span><br></h3><p id='Chats'>".$message["Text"]."</p></div>";
                }
            }
        }else{
            echo"No messages found";
        }
    }
?>
</div>
<form method="post" id="form">
<input type="text" name="text" id="text">
<button type="submit" id="sendButton" ><svg id="Simg" width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<path d="M22 2 11 13"></path>
<path d="m22 2-7 20-4-9-9-4 20-7z"></path>
</svg></button>
</form>
