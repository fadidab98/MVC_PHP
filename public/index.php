<?php
require_once  __DIR__."/../vendor/autoload.php";
use app\core\Application;

$app = new Application();

$app->router->get('/',function (){
    return "Hallo World";
});
$app->router->get('/contact-us',"contact");
$app->router->get('/about-us',function (){
    return "About Us";
});

$app->run();

