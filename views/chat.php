<?php
//viestin lähetys
if($_SERVER["REQUEST_METHOD"] === "POST"){
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
    header("Location: /login");
    exit;
}
if(!empty($params["id"])){
    //viestit
    $mysqli = require __DIR__."/../src/database.php";
    //$sql = sprintf("SELECT * FROM message WHERE RecipentID = '%s'",$mysqli->real_escape_string($_SESSION["userID"]),"OR RecipentID = '%s'",$mysqli->real_escape_string($params["id"]),"ORDER BY Timesent DESC");
    //$sql = sprintf("SELECT * FROM message WHERE RecipentID = '%s'",$mysqli->real_escape_string($params["id"]),"ORDER BY Timesent DESC");
    $sql = sprintf(
        "SELECT * FROM message WHERE RecipentID = '%s' AND SenderID = '%s' OR SenderID = '%s' AND RecipentID = '%s' ORDER BY Timesent ASC",
        $mysqli->real_escape_string($_SESSION["userID"]),
        $mysqli->real_escape_string($params["id"]),
        $mysqli->real_escape_string($_SESSION["userID"]),
        $mysqli->real_escape_string($params["id"])
    );
    $result = $mysqli->query($sql);
    $messages = $result->fetch_all(MYSQLI_ASSOC);
    //echo '<pre>'; print_r($messages); echo '</pre>';
}
//chatattavat ihmiset
$mysqli = require __DIR__."/../src/database.php";
    $sql = sprintf("SELECT username,userID FROM user WHERE userID != '%s'",$mysqli->real_escape_string($_SESSION["userID"]));
    $result = $mysqli->query($sql);
    $chats = $result->fetch_all(MYSQLI_ASSOC);
?>
<h1>chat</h1>
<p>username: <?=$_SESSION["username"]?> userID: <?=$_SESSION["userID"]?> <a href="/logout">logout</a></p>
<h3>Chats</h3>
<?php
    //echo '<pre>'; print_r($chats); echo '</pre>';
    foreach($chats as $chat){
        echo "<a href='/chat?id=".$chat["userID"]."'>".$chat["username"]."</a> <br>";
    }
?>
<?php
    if(!empty($params["id"])){

        $mysqli = require __DIR__."/../src/database.php";
        $sql = sprintf("SELECT username FROM user WHERE userID = '%s'",$mysqli->real_escape_string($params["id"]));
        $result = $mysqli->query($sql);
        $user = $result->fetch_assoc();

        echo "<h3>Messaging: ".$user["username"]."</h3> ";
        if(!empty($messages)){
            foreach($messages as $message){
                $sql = sprintf("SELECT username FROM user WHERE userID = '%s'",$mysqli->real_escape_string($message["SenderID"]));
                $result = $mysqli->query($sql);
                $sender = $result->fetch_assoc();
                echo "<p>--------------------------------------------------------</p><h3>".$sender["username"]."<br></h3><p>".$message["Text"]."</p><p>".$message["Timesent"]."</p>";
            }
        }else{
            echo"No messages found";
        }
    }
?>
<form method="post">
    <p>------------------------------------------------------------</p>
    <input type="text" name="text" id="text">
    <button type="submit">Send</button>
</form>