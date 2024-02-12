<?php

$is_invalid = false;

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $mysqli = require __DIR__."/../src/database.php";
        $sql = sprintf("SELECT * FROM user WHERE username = '%s'",$mysqli->real_escape_string($_POST["username"]));
        $result = $mysqli->query($sql);
        $user = $result->fetch_assoc();

        if ($user){
            if (password_verify($_POST["password"],$user["password"])){
                session_start();
                $_SESSION["userID"] = $user["userID"];
                $_SESSION["username"] = $user["username"];
                header("Location: /chat");
                exit;
            }
        }
        $is_invalid = true;
    }



?>
<h1>login</h1>
<?php if($is_invalid): ?>
    <h2>invalid username or password</h2>
<?php endif; ?>
<form method="post">
    <div>
        <label for="username">username</label>
        <input type="text" name="username" id="username" value="<?= htmlspecialchars($_POST["username"] ?? "")?>">
        <label for="password">password</label>
        <input type="password" name="password" id="password">
        <button type="submit">login</button>
    </div>
    <a href="/signup">Signup</a>
</form>
