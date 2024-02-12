<?php
session_start();
require_once __DIR__."/../vendor/autoload.php";
use App\Router;

$router = new Router();

$router->get("/",function(){
    echo"<a href='/chat'>Chat</a>";
});
$router->get("/chat",function(){
    require_once __DIR__."/../views/chat.php";
});
$router->post("/chat",function(array $params){
    require_once __DIR__."/../views/chat.php";
});
$router->get("/chat",function(array $params){
    require_once __DIR__."/../views/chat.php";
});
$router->get("/create-group",function(){
    require_once __DIR__."/../views/create-group.php";
});
$router->post("/create-group",function(){
    require_once __DIR__."/../views/create-group.php";
});
$router->get("/invite",function(array $params){
    require_once __DIR__."/../views/group-invite.php";
});
$router->get("/login",function(){
    require_once __DIR__."/../views/login.php";
});
$router->get("/signup",function(){
    require_once __DIR__."/../views/signup.php";
});
$router->get("/signup-success",function(){
    require_once __DIR__."/../views/signup-success.php";
});
$router->get("/logout",function(){
    require_once __DIR__."/../views/logout.php";
});
$router->post("/signup-process",function(){
    require_once __DIR__."/../views/signup-process.php";
});
$router->post("/login",function(){
    require_once __DIR__."/../views/login.php";
});
$router->addNotFoundHandler(function(){
    require_once __DIR__."/../views/404.php"; 
});

$router->run();
?>