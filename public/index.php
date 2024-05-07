<?php
require_once  __DIR__."/../vendor/autoload.php";

use app\controllers\SiteController;
use app\core\Application;

$app = new Application(dirname(__DIR__));

$app->router->get('/',[SiteController::class,'index']);
$app->router->get('/contact-us',"layouts.user.main.contact");
$app->router->post('/contact-us',[SiteController::class,"contact"]);
$app->router->get('/about-us',function (){
    return "About Us";
});

$app->run();

