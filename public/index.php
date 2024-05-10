<?php
require_once  __DIR__."/../vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
use app\controllers\SiteController;
use app\controllers\AuthController;

use app\core\Application;
$config = [
    "db"=>[
        'dsn'=>$_ENV["DB_DSN"],
        "user"=>$_ENV["DB_USER"],
        "password"=>$_ENV["DB_PASSWORD"],
    ]
];
$app = new Application(dirname(__DIR__),$config);

$app->router->get('/',[SiteController::class,'index']);
$app->router->get('/contact-us',"layouts.user.main.contact");
$app->router->post('/contact-us',[SiteController::class,"contact"]);
$app->router->post('/register',[AuthController::class,"register"]);
$app->router->get('/register',[AuthController::class,"register"]);
$app->router->get('/login',[AuthController::class,"login"]);
$app->router->post('/login',[AuthController::class,"login"]);
$app->router->get('/about-us',function (){
    return "About Us";
});

$app->run();

