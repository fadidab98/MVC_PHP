<?php
require_once  __DIR__."/../vendor/autoload.php";
use app\core\Application;

$app = new Application(dirname(__DIR__));

$app->router->get('/',function (){
    return "Hallo World";
});
$app->router->get('/contact-us',"layouts.user.main.contact");
$app->router->get('/about-us',function (){
    return "About Us";
});

$app->run();

