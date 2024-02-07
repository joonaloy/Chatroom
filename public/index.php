<?php

require_once __DIR__."/../vendor/autoload.php";
use App\Router;

$router = new Router();

$router->get("/",function(){
    echo "homepage";
});
$router->get("/about",function(){
    echo "about";
});
$router->addNotFoundHandler(function(){
    require_once __DIR__."/../views/404.php"; 
});

$router->run();