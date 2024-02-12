<?php
    if($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["name"])){
        $groupID=rand();
        $groupID = md5($groupID);
        $inviteID=rand();
        $inviteID = md5($inviteID);
        $json = json_encode(array(array("userID" => $_SESSION["userID"])));
        $mysqli = require __DIR__."/../src/database.php";
        
        $sql = "INSERT INTO groupchat (name,groupID,users,inviteID) VALUES (?,?,?,?)";

        $stmt = $mysqli->prepare($sql);
        if (!$stmt){
            die("prepare failed: ".$mysqli->error);
        }
        
        $stmt->bind_param("ssss",$_POST["name"],$groupID,$json,$inviteID);
        if ($stmt->execute()){
            echo "group created";
            header("Location: /chat");
            exit;
        }else{
            die("execute failed: ".$stmt->error);
        }
    }
?>
<h1>Create Group</h1>
<form action="create-group" method="post">
    <div>
        <label for="name">name</label>
        <input type="text" name="name" id="name">
        <button type="submit">Create</button>
    </div>
</form>
